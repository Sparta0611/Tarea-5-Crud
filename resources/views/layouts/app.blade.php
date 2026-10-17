<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - USAP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>

    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('posts.index') }}">
                    <img src="{{ asset('img/logo-usap.png') }}" alt="Universidad de San Pedro Sula - USAP">
                </a>
            </div>

            <nav aria-label="Navegación principal">
                <ul class="sidebar-nav">
                    <li>
                        <a href="{{ route('posts.index') }}" class="nav-link">
                            <i class="bi bi-house" aria-hidden="true"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" class="nav-link active">
                            <i class="bi bi-person" aria-hidden="true"></i>
                            <span>Artículos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" class="nav-link">
                            <i class="bi bi-newspaper" aria-hidden="true"></i>
                            <span>Bolsa de Empleo</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" class="nav-link">
                            <i class="bi bi-gear" aria-hidden="true"></i>
                            <span>Configuraciones</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="main-content">
            <header class="topbar">
                @auth
                    <div class="dropdown">
                        <button class="user-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-profile-name">{{ Auth::user()->name }}</span>
                            <span class="role-badge {{ Auth::user()->isAdmin() ? 'role-badge-admin' : 'role-badge-user' }}">
                                {{ Auth::user()->isAdmin() ? 'Administrador' : 'Usuario' }}
                            </span>
                            <i class="bi bi-caret-down-fill" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-light-subtle">
                            <li class="px-3 py-2 border-bottom">
                                <div class="small text-muted">Conectado como</div>
                                <div class="fw-semibold text-dark text-truncate">{{ Auth::user()->email }}</div>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2">
                                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                                        <span>Cerrar sesión</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </header>

            <main class="page-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
