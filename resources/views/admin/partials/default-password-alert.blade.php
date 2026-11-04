{{--
  Alert SweetAlert2: muncul di tengah layar kalau akun yang login masih
  memakai password bawaan (config cuplik.default_password).
  - Pengecekan bcrypt hanya dilakukan sekali per sesi (hasilnya disimpan di sesi).
  - Alert muncul sekali per sesi login, dan tidak muncul di halaman profil.
--}}
@auth
    @php
        $dpState = session('default_pw_state');

        if ($dpState === null) {
            $dpState = auth()->user()->usesDefaultPassword() ? 'default' : 'ok';
            session(['default_pw_state' => $dpState]);
        }

        $showDefaultPwAlert = $dpState === 'default'
            && ! session('default_pw_alert_shown')
            && ! request()->routeIs('admin.profile.*');

        if ($showDefaultPwAlert) {
            session(['default_pw_alert_shown' => true]);
        }
    @endphp

    @if ($showDefaultPwAlert)
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ganti Password Anda',
                    text: @json('Karena cuplik.com sudah mengalami perubahan yang besar, saya sarankan untuk Anda mengganti password segera demi keamanan.'),
                    confirmButtonText: 'Ganti Password Sekarang',
                    showCancelButton: true,
                    cancelButtonText: 'Nanti',
                    confirmButtonColor: '#008a24',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(function (result) {
                    if (result.isConfirmed) {
                        window.location.href = @json(route('admin.profile.edit'));
                    }
                });
            });
        </script>
    @endif
@endauth
