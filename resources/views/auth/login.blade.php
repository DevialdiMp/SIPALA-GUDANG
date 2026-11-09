<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | SIPALA</title>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            min-height: 100dvh;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f1f5f9;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 12px;
        }

        /* LOGIN WRAPPER */
        .login-wrapper {
            width: 100%;
            max-width: 410px;
            margin: auto;
        }

        /* LOGIN CARD */
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e8edf4;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.07);
        }

        /* HEADER */
        .login-header {
            padding: 22px 28px 16px;
            text-align: center;
        }

        .logo {
            width: 56px;
            height: 56px;
            border-radius: 15px;
            background: #eaf2ff;
            color: #1677ff;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 12px;
            font-size: 27px;
        }

        .login-header h3 {
            font-size: 25px;
            font-weight: 750;
            color: #172b4d;
            margin: 0 0 5px;
            letter-spacing: 0.5px;
        }

        .login-header p {
            color: #7b8798;
            font-size: 13px;
            margin: 0;
        }

        /* BODY */
        .login-body {
            padding: 4px 28px 22px;
        }

        .welcome-text {
            margin-bottom: 17px;
        }

        .welcome-text h5 {
            color: #253858;
            font-size: 17px;
            font-weight: 650;
            margin: 0 0 4px;
        }

        .welcome-text p {
            color: #8994a5;
            font-size: 13px;
            margin: 0;
        }

        /* FORM */
        .form-group {
            margin-bottom: 13px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            height: 43px;
            border: 1px solid #dce3ed;
            border-radius: 9px;
            background: #ffffff;
            padding: 0 42px;
            font-size: 13px;
            color: #334155;
            outline: none;
            transition: 0.2s;
        }

        .form-control::placeholder {
            color: #a5afbd;
        }

        .form-control:focus {
            border-color: #1677ff;
            box-shadow: 0 0 0 3px rgba(22, 119, 255, 0.10);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 15px;
            background: none;
            border: none;
            padding: 5px;
        }

        .password-toggle:hover {
            color: #1677ff;
        }

        /* LOGIN BUTTON */
        .btn-login {
            width: 100%;
            height: 45px;
            border: none;
            border-radius: 9px;
            background: #1677ff;
            color: #ffffff;
            font-size: 14px;
            font-weight: 650;
            cursor: pointer;
            margin-top: 3px;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: #0866e8;
            box-shadow: 0 5px 14px rgba(22, 119, 255, 0.22);
        }

        .btn-login i {
            margin-right: 7px;
        }

        /* ALERT */
        .alert {
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 13px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .alert-success {
            color: #15803d;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            color: #dc2626;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert-close {
            margin-left: auto;
            border: none;
            background: none;
            color: inherit;
            cursor: pointer;
            font-size: 17px;
        }

        /* FOOTER */
        .login-footer {
            padding: 13px 16px;
            background: #fafbfc;
            border-top: 1px solid #edf0f5;
            text-align: center;
        }

        .beta-badge {
            display: inline-block;
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.7px;
            margin-bottom: 7px;
        }

        .login-footer p {
            margin: 0;
            color: #94a3b8;
            font-size: 11px;
        }

        .login-footer strong {
            color: #475569;
        }

        /* LAYAR PENDEK / LAPTOP */
        @media (max-height: 800px) {
            .login-header {
                padding-top: 17px;
                padding-bottom: 12px;
            }

            .logo {
                width: 50px;
                height: 50px;
                font-size: 24px;
                margin-bottom: 9px;
            }

            .login-body {
                padding-bottom: 17px;
            }

            .welcome-text {
                margin-bottom: 13px;
            }

            .form-group {
                margin-bottom: 11px;
            }

            .login-footer {
                padding: 10px 16px;
            }
        }

        /* MOBILE */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .login-header {
                padding: 22px 20px 16px;
            }

            .login-body {
                padding: 4px 20px 20px;
            }

            .login-card {
                border-radius: 13px;
            }
        }

        /* LAYAR MOBILE PENDEK */
        @media (max-width: 480px) and (max-height: 700px) {
            .login-header {
                padding-top: 12px;
                padding-bottom: 10px;
            }

            .logo {
                width: 44px;
                height: 44px;
                font-size: 22px;
                margin-bottom: 7px;
            }

            .login-body {
                padding-bottom: 13px;
            }

            .welcome-text {
                margin-bottom: 10px;
            }

            .form-group {
                margin-bottom: 9px;
            }

            .form-control {
                height: 40px;
            }

            .btn-login {
                height: 42px;
            }

            .login-footer {
                padding: 9px 12px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            {{-- HEADER --}}
            <div class="login-header">
                <div class="logo">
                    <i class="bi bi-tools"></i>
                </div>
                <h3>SIPALA</h3>
                <p>Sistem Informasi Peminjaman Alat</p>
            </div>

            {{-- FORM LOGIN --}}
            <div class="login-body">
                <div class="welcome-text">
                    <h5>Selamat Datang!</h5>
                    <p>Silakan masuk untuk melanjutkan.</p>
                </div>

                {{-- NOTIFIKASI SUKSES --}}
                @if (session('success'))
                    <div class="alert alert-success" id="successAlert">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="alert-close" onclick="closeAlert('successAlert')">
                            &times;
                        </button>
                    </div>
                @endif

                {{-- NOTIFIKASI ERROR --}}
                @if ($errors->any())
                    <div class="alert alert-danger" id="errorAlert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ $errors->first() }}</span>
                        <button type="button" class="alert-close" onclick="closeAlert('errorAlert')">
                            &times;
                        </button>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Masukkan alamat email" value="{{ old('email') }}" autocomplete="username"
                                required autofocus>
                        </div>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()"
                                aria-label="Tampilkan password">
                                <i class="bi bi-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                    </div>

                    {{-- TOMBOL LOGIN --}}
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk ke Dashboard
                    </button>
                </form>
            </div>

            {{-- FOOTER --}}
            <div class="login-footer">
                <div class="beta-badge">
                    BETA VERSION
                </div>
                <p>
                    &copy; {{ date('Y') }} SIPALA.
                    Developed by <strong>DEVMP Solutions.</strong>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Tampilkan / sembunyikan password
        function togglePassword() {

            const password = document.getElementById('password');
            const icon = document.getElementById('passwordIcon');
            const button = document.querySelector('.password-toggle');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
                button.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                password.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
                button.setAttribute('aria-label', 'Tampilkan password');
            }
        }

        // Tutup notifikasi otomatis
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.remove();
                }, 3000);
            });
        });
    </script>
</body>

</html>
