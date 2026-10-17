<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Panel Administrativo USAP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <main class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <img src="{{ asset('img/logo-usap.svg') }}" alt="Universidad de San Pedro Sula - USAP" class="auth-logo">
                <h1 class="auth-title">Iniciar sesión</h1>
                <p class="auth-subtitle">Ingresa tus credenciales para acceder al panel</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3" role="alert" aria-live="polite">
                    <i class="bi bi-exclamation-circle me-1" aria-hidden="true"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label auth-label">Correo electrónico</label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control auth-input @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="ejemplo@usap.edu"
                           autocomplete="email"
                           required
                           autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label auth-label">Contraseña</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control auth-input @error('password') is-invalid @enderror"
                           placeholder="Ingresa tu contraseña"
                           autocomplete="current-password"
                           required>
                </div>

                <button type="submit" class="btn btn-primary w-100 auth-submit-btn">
                    <i class="bi bi-box-arrow-in-right me-1" aria-hidden="true"></i>
                    <span>Entrar al panel</span>
                </button>
            </form>

            <div class="auth-footer">
                <span>¿No tienes una cuenta?</span>
                <a href="{{ route('register') }}" class="auth-link">Crear usuario</a>
            </div>
        </div>
    </main>
</body>
</html>
