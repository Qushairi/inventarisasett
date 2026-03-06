<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3 text-center">Login Sistem</h1>
                    <p class="text-muted text-center mb-4">Sistem Inventaris Aset</p>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.attempt') }}" method="post" class="d-grid gap-3">
                        @csrf
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                        </div>
                        <div>
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Masuk</button>
                    </form>

                    <hr class="my-4">
                    <small class="text-muted d-block">Akun default seed:</small>
                    <small class="text-muted d-block">Admin: admin@bengkalis.go.id / password123</small>
                    <small class="text-muted d-block">Email: pegawai@bengkalis.go.id</small>
                    <small class="text-muted d-block">Password: password123</small>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
