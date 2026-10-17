@extends('layouts.app')

@section('content')
<div class="custom-card">
    <div class="custom-card-header">
        <h1 class="custom-card-title">Artículos</h1>
        @if (Auth::user()?->isAdmin())
            <a href="{{ route('posts.create') }}" class="btn-create-post text-decoration-none">
                <i class="bi bi-person-plus" aria-hidden="true"></i>
                <span>Crear</span>
            </a>
        @endif
    </div>

    <div class="custom-card-body">
        <form action="{{ route('posts.index') }}" method="GET" class="table-filter-bar">
            <div>
                <label for="cantidad" class="me-1">Show</label>
                <select name="cantidad" id="cantidad" onchange="this.form.submit()">
                    <option value="10" @selected($cantidad == 10)>10</option>
                    <option value="25" @selected($cantidad == 25)>25</option>
                    <option value="50" @selected($cantidad == 50)>50</option>
                </select>
                <span class="ms-1">entries</span>
            </div>

            <div class="d-flex align-items-center">
                <label for="buscar" class="me-2">Search:</label>
                <input type="text" name="buscar" id="buscar" value="{{ $buscar }}" placeholder="">
                @if ($buscar != '')
                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary ms-2" title="Limpiar filtro" aria-label="Limpiar filtro de búsqueda">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-posts">
                <thead>
                    <tr>
                        <th scope="col">Titulo <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 11px;" aria-hidden="true"></i></th>
                        <th scope="col">Autor <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 11px;" aria-hidden="true"></i></th>
                        @if (Auth::user()?->isAdmin())
                            <th scope="col">Acciones <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 11px;" aria-hidden="true"></i></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td class="post-title-cell">{{ $post->title }}</td>
                            <td>{{ $post->author }}</td>
                            @if (Auth::user()?->isAdmin())
                                <td>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn-edit-article me-2">
                                        Editar articulo
                                    </a>

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este artículo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-article">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()?->isAdmin() ? 3 : 2 }}" class="text-center text-muted py-4">
                                No hay artículos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
