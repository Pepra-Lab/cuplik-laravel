<?php

return [
    /*
    | Password bawaan untuk akun hasil migrasi dari situs lama.
    | Dipakai skrip impor (saat membuat akun) dan pengecekan alert
    | "segera ganti password" di CMS. Bisa diganti lewat .env:
    |   CUPLIK_DEFAULT_PASSWORD=...
    */
    'default_password' => env('CUPLIK_DEFAULT_PASSWORD', 'cupliknew123'),
];
