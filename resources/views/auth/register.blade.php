<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Panel Administrativo USAP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <main class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <img src="{{ asset('img/logo-usap.svg') }}" alt="Universidad de San Pedro Sula - USAP" class="auth-logo">
                <h1 class="auth-title">Crear usuario</h1>
                <p class="auth-subtitle">Registra tu cuenta y elige tus permisos de acceso</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label auth-label">Nombre completo</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control auth-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Ej. Marco Alemán Watters"
                           autocomplete="name"
                           required
                           autofocus>
                    @error('name')
                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label auth-label">Correo electrónico</label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control auth-input @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="ejemplo@usap.edu"
                           autocomplete="email"
                           required>
                    @error('email')
                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label auth-label">Contraseña</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control auth-input @error('password') is-invalid @enderror"
                           placeholder="Mínimo 4 caracteres"
                           autocomplete="new-password"
                           required>
                    @error('password')
                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label auth-label">Rol en el sistema</label>
                    <select name="role"
                            id="role"
                            class="form-select auth-input @error('role') is-invalid @enderror"
                            required>
                        <option value="admin" @selected(old('role', 'admin') === 'admin')>
                            Administrador (Usar el CRUD completo)
                        </option>
                        <option value="user" @selected(old('role') === 'user')>
                            Usuario (Solo visualizar)
                        </option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 auth-submit-btn">
                    <i class="bi bi-person-check me-1" aria-hidden="true"></i>
                    <span>Crear usuario y entrar</span>
                </button>
            </form>

            <div class="auth-footer">
                <span>¿Ya tienes una cuenta?</span>
                <a href="{{ route('login') }}" class="auth-link">Iniciar sesión</a>
            </div>
        </div>
    </main>
</body>
</html>
