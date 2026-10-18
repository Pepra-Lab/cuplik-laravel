<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

/**
 * Sanitasi HTML sederhana berbasis whitelist, tanpa dependency composer
 * (tidak butuh akses packagist). Dipakai untuk membersihkan konten yang
 * ditulis lewat rich-text editor (isi berita, halaman info, footer, dsb)
 * sebelum disimpan ke database, supaya tag/atribut berbahaya (<script>,
 * <iframe>, onclick=, href="javascript:...", dst) tidak pernah sampai
 * dirender dengan {!! !!} di Blade.
 *
 * Catatan: ini BUKAN pengganti HTML Purifier yang sudah battle-tested.
 * Kalau nanti akses ke Packagist tersedia, pertimbangkan migrasi ke
 * `mews/purifier`. Untuk saat ini, whitelist di bawah sengaja dibuat
 * ketat (hanya tag/atribut yang benar-benar dipakai editor berita).
 */
class HtmlSanitizer
{
    /**
     * Tag yang diizinkan beserta atribut yang boleh menempel padanya.
     * Tag di luar daftar ini akan dibuang (isinya tetap dipertahankan
     * sebagai teks, kecuali untuk tag berbahaya yang dibuang total).
     */
    private const ALLOWED_TAGS = [
        'p' => ['style'],
        'br' => [],
        'strong' => [],
        'b' => [],
        'em' => [],
        'i' => [],
        'u' => [],
        's' => [],
        'a' => ['href', 'title', 'target', 'rel'],
        'ul' => [],
        'ol' => [],
        'li' => [],
        'h1' => [],
        'h2' => [],
        'h3' => [],
        'h4' => [],
        'h5' => [],
        'h6' => [],
        'blockquote' => [],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'figure' => [],
        'figcaption' => [],
        'span' => ['style'],
        'div' => ['style'],
        'table' => [],
        'thead' => [],
        'tbody' => [],
        'tr' => [],
        'th' => [],
        'td' => [],
        'code' => [],
        'pre' => [],
    ];

    /**
     * Tag yang kalau ditemukan, dibuang TOTAL beserta isinya (bukan cuma
     * tagnya), karena isinya sendiri sudah berbahaya (script, style CSS
     * global, dsb) atau tidak relevan untuk konten artikel.
     */
    private const STRIP_WITH_CONTENTS = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'noscript', 'svg'];

    /** Skema URL yang diizinkan untuk atribut href/src. */
    private const ALLOWED_URL_SCHEMES = ['http', 'https', 'mailto', 'tel', '/', '#'];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return '';
        }

        $dom = new DOMDocument('1.0', 'UTF-8');

        // Bungkus supaya fragment HTML (tanpa <html><body>) bisa di-parse
        // dengan aman, dan paksa encoding UTF-8.
        $wrapped = '<?xml encoding="utf-8" ?><div id="__root__">' . $html . '</div>';

        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML($wrapped, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $dom->getElementById('__root__');

        if (! $root) {
            return '';
        }

        self::stripDangerousTags($dom);
        self::sanitizeNode($root);

        $output = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $output .= $dom->saveHTML($child);
        }

        return trim($output);
    }

    private static function stripDangerousTags(DOMDocument $dom): void
    {
        $xpath = new DOMXPath($dom);

        foreach (self::STRIP_WITH_CONTENTS as $tag) {
            $nodes = $xpath->query("//{$tag}");
            if (! $nodes) {
                continue;
            }
            foreach (iterator_to_array($nodes) as $node) {
                $node->parentNode?->removeChild($node);
            }
        }
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! array_key_exists($tag, self::ALLOWED_TAGS)) {
                    // Tag tidak di-whitelist: buang tagnya, tapi pertahankan
                    // anak-anaknya (biar teks di dalamnya tidak hilang),
                    // lalu lanjut proses anak-anak itu di posisi barunya.
                    self::sanitizeNode($child);
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                    continue;
                }

                self::sanitizeAttributes($child, self::ALLOWED_TAGS[$tag]);
                self::sanitizeNode($child);
            }
        }
    }

    private static function sanitizeAttributes(DOMElement $el, array $allowedAttrs): void
    {
        foreach (iterator_to_array($el->attributes ?? []) as $attr) {
            $name = strtolower($attr->nodeName);

            // Buang semua atribut event handler (onclick, onerror, onload, ...)
            // dan apa pun yang bukan di-whitelist untuk tag ini.
            if (str_starts_with($name, 'on') || ! in_array($name, $allowedAttrs, true)) {
                $el->removeAttribute($attr->nodeName);
                continue;
            }

            if (in_array($name, ['href', 'src'], true)) {
                $value = trim($attr->nodeValue);
                if (! self::isSafeUrl($value)) {
                    $el->removeAttribute($attr->nodeName);
                    continue;
                }
            }

            if ($name === 'style') {
                // Buang 'expression(...)' dan 'url(javascript:...)' ala IE lama,
                // dan singkirkan style yang mengandung "javascript:".
                if (stripos($attr->nodeValue, 'javascript:') !== false || stripos($attr->nodeValue, 'expression(') !== false) {
                    $el->removeAttribute($attr->nodeName);
                }
            }

            if ($name === 'target' && $el->getAttribute('target') === '_blank') {
                // rel="noopener noreferrer" dipaksakan untuk cegah tabnabbing.
                $el->setAttribute('rel', 'noopener noreferrer');
            }
        }
    }

    private static function isSafeUrl(string $value): bool
    {
        if ($value === '') {
            return true;
        }

        // Path relatif atau anchor diizinkan.
        if ($value[0] === '/' || $value[0] === '#') {
            return true;
        }

        $scheme = parse_url($value, PHP_URL_SCHEME);

        if ($scheme === null) {
            // Tidak ada skema (mis. "gambar.jpg") -> dianggap path relatif, aman.
            return true;
        }

        return in_array(strtolower($scheme), self::ALLOWED_URL_SCHEMES, true);
    }
}
