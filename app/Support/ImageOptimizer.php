<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Mengubah gambar unggahan (JPG/PNG/WEBP) menjadi WebP (ukuran piksel tetap)
 * sebelum disimpan, supaya storage shared hosting tidak cepat penuh.
 *
 * Memakai ekstensi GD bawaan PHP (tanpa paket tambahan). Kalau GD tidak
 * mendukung WebP atau gambar gagal diproses, file asli disimpan apa adanya
 * supaya unggahan reporter tidak pernah gagal gara-gara konversi.
 */
class ImageOptimizer
{
    /** Batas jumlah piksel agar memori shared hosting tidak jebol (±40 megapiksel). */
    private const MAX_PIXELS = 40_000_000;

    /**
     * @return string Path relatif terhadap disk 'public', sama seperti hasil ->store().
     */
    public static function storeAsWebp(
        UploadedFile $file,
        string $dir = 'berita',
        ?int $maxWidth = null,
        int $quality = 80
    ): string {
        $data = self::convert($file, $maxWidth, $quality);

        if ($data === null) {
            return $file->store($dir, 'public');
        }

        $path = trim($dir, '/') . '/' . Str::random(40) . '.webp';
        Storage::disk('public')->put($path, $data);

        return $path;
    }

    private static function convert(UploadedFile $file, ?int $maxWidth, int $quality): ?string
    {
        if (! function_exists('imagewebp') || ! function_exists('imagecreatetruecolor')) {
            return null;
        }

        $realPath = $file->getRealPath();
        $info = @getimagesize($realPath);

        if (! $info || ($info[0] * $info[1]) > self::MAX_PIXELS) {
            return null;
        }

        $type = $info[2];
        $img = match ($type) {
            IMAGETYPE_JPEG => function_exists('imagecreatefromjpeg') ? @imagecreatefromjpeg($realPath) : false,
            IMAGETYPE_PNG => function_exists('imagecreatefrompng') ? @imagecreatefrompng($realPath) : false,
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($realPath) : false,
            default => false,
        };

        if (! $img) {
            return null;
        }

        // Foto dari HP sering tersimpan "miring" lewat EXIF; putar sesuai aslinya.
        if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $exif = @exif_read_data($realPath);
            $angle = match ($exif['Orientation'] ?? 1) {
                3 => 180,
                6 => -90,
                8 => 90,
                default => 0,
            };
            if ($angle !== 0) {
                $rotated = imagerotate($img, $angle, 0);
                if ($rotated) {
                    $img = $rotated;
                }
            }
        }

        // Pertahankan transparansi PNG/WebP.
        imagepalettetotruecolor($img);
        imagealphablending($img, false);
        imagesavealpha($img, true);

        // Dimensi gambar TIDAK diubah kecuali $maxWidth diisi (default null = ukuran asli).
        if ($maxWidth !== null && imagesx($img) > $maxWidth) {
            $scaled = imagescale($img, $maxWidth, -1, IMG_BICUBIC);
            if ($scaled) {
                imagealphablending($scaled, false);
                imagesavealpha($scaled, true);
                $img = $scaled;
            }
        }

        ob_start();
        $ok = imagewebp($img, null, $quality);
        $data = ob_get_clean();

        if (! $ok || $data === false || $data === '') {
            return null;
        }

        // File WebP yang sudah ringan jangan sampai malah membengkak.
        if ($type === IMAGETYPE_WEBP && strlen($data) >= filesize($realPath)) {
            return null;
        }

        return $data;
    }
}
