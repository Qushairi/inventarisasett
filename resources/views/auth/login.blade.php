<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Sistem Inventaris Aset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body.login-page {
            min-height: 100vh;
            margin: 0;
            overflow: auto;
            font-family: "Poppins", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.1), transparent 30%),
                radial-gradient(circle at bottom right, rgba(30, 64, 175, 0.08), transparent 24%),
                linear-gradient(180deg, #f7faff 0%, #eef3f9 100%);
            color: #18212f;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
        }

        .login-wrap {
            width: min(100%, 920px);
        }

        .login-shell {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 560px;
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.1);
        }

        .login-showcase {
            background: linear-gradient(160deg, rgba(18, 44, 121, 0.96) 0%, rgba(44, 89, 191, 0.92) 100%);
            color: #ffffff;
            padding: 42px 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .login-showcase::before {
            content: "";
            position: absolute;
            inset: 24px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            pointer-events: none;
        }

        .showcase-header {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 18px;
            text-align: center;
        }

        .logo-box {
            width: 88px;
            height: 108px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 18px 34px rgba(7, 18, 57, 0.22);
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .showcase-title {
            margin: 0;
            font-size: clamp(2rem, 3vw, 2.5rem);
            font-weight: 800;
            line-height: 1.2;
        }

        .showcase-subtitle {
            margin: 10px 0 0;
            max-width: 360px;
            font-size: 0.96rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.82);
        }

        .login-panel {
            padding: 54px 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.92);
        }

        .login-panel-inner {
            width: min(100%, 380px);
        }

        .login-title {
            font-size: clamp(2rem, 2.8vw, 2.35rem);
            font-weight: 800;
            margin: 0 0 10px;
            color: #18212f;
            text-align: center;
        }

        .login-desc {
            margin: 0 0 28px;
            color: #64748b;
            line-height: 1.65;
            font-size: 0.93rem;
            text-align: center;
        }

        .login-form {
            width: 100%;
        }

        .login-form .form-label {
            font-size: 0.92rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .login-form .form-control {
            border-radius: 14px;
            border: 1px solid #4f7ef7;
            height: 50px;
            background-color: #ffffff;
            color: #1e293b;
            margin-bottom: 18px;
            padding: 0 16px;
            box-shadow: none;
        }

        .login-form .form-control::placeholder {
            color: #94a3b8;
        }

        .login-form .form-control:focus {
            border-color: rgba(42, 91, 215, 0.42);
            box-shadow: 0 0 0 4px rgba(42, 91, 215, 0.08);
        }

        .login-btn {
            width: 100%;
            border: 0;
            border-radius: 14px;
            height: 50px;
            background: linear-gradient(135deg, #1d4ed8 0%, #2f6df6 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
            box-shadow: 0 16px 30px rgba(42, 91, 215, 0.2);
        }

        .login-btn:hover {
            filter: brightness(1.02);
            transform: translateY(-1px);
        }

        @media (max-width: 991.98px) {
            .login-wrap {
                width: min(100%, 620px);
            }

            .login-shell {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .login-showcase {
                padding: 34px 28px;
            }

            .login-panel {
                padding: 34px 28px 30px;
            }
        }

        @media (max-width: 575.98px) {
            body.login-page {
                padding: 18px 14px;
            }

            .login-showcase {
                padding: 28px 20px;
            }

            .showcase-title {
                font-size: 1.7rem;
            }

            .logo-box {
                width: 66px;
                height: 82px;
            }

            .login-panel {
                padding: 28px 20px 24px;
            }
        }
    </style>
</head>
<body class="login-page">
<div class="login-wrap">
    @php
        $logoPath = public_path('assets/logo/logobengkalis.png');
    @endphp

    <div class="login-shell">
        <section class="login-showcase">
            <div class="showcase-header">
                <div class="logo-box">
                    @if (file_exists($logoPath))
                        <img src="{{ asset('assets/logo/logobengkalis.png') }}" alt="Logo Bengkalis">
                    @else
                        BK
                    @endif
                </div>
                <div>
                    <h1 class="showcase-title">Sistem Inventaris Aset</h1>
                    <p class="showcase-subtitle">Disdik Kab. Bengkalis</p>
                </div>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-panel-inner">
                <h2 class="login-title">LOGIN</h2>
                <p class="login-desc">Masukkan email dan kata sandi untuk melanjutkan.</p>

                <form action="{{ route('login.attempt') }}" method="post" class="login-form">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 px-3 mb-3" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan email" required autofocus>

                    <label class="form-label" for="password">Kata Sandi</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>

                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </section>
    </div>
</div>
</body>
</html>
