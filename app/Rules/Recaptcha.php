<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Validasi checkbox reCAPTCHA v2 ("Saya bukan robot") lewat endpoint resmi
 * Google (https://www.google.com/recaptcha/api/siteverify), tanpa perlu
 * composer package — cukup pakai Http client bawaan Laravel.
 *
 * Kenapa validasi ini wajib di SERVER, bukan cuma widget di frontend: kalau
 * cuma mengandalkan widget JS, seseorang bisa kirim POST langsung ke
 * /masuk atau /daftar (mis. lewat curl/Postman) tanpa pernah menyentuh
 * widget sama sekali, dan form tetap akan diproses seolah captcha lolos.
 */
class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret');

        // Admin belum pasang reCAPTCHA key di .env -> anggap fitur nonaktif,
        // jangan sampai bikin semua orang gagal login/daftar di environment
        // yang memang belum dikonfigurasi (mis. saat development lokal).
        if (blank($secret)) {
            Log::warning('RECAPTCHA_SECRET_KEY belum diisi di .env — validasi captcha dilewati sementara.');

            return;
        }

        if (blank($value)) {
            $fail('Harap centang kotak "Saya bukan robot" terlebih dahulu.');

            return;
        }

        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $value,
                ]);
        } catch (\Throwable $e) {
            Log::error('Gagal menghubungi server Google reCAPTCHA: ' . $e->getMessage());
            $fail('Tidak bisa memverifikasi captcha saat ini. Silakan coba lagi beberapa saat lagi.');

            return;
        }

        if (! $response->successful() || ! ($response->json('success') ?? false)) {
            $fail('Verifikasi "Saya bukan robot" gagal atau sudah kedaluwarsa. Silakan centang ulang.');
        }
    }
}
