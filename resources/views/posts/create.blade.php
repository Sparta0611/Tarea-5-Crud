@extends('layouts.app')

@section('content')
<div class="custom-card">
    <div class="custom-card-header">
        <h1 class="custom-card-title">Crear articulo</h1>
    </div>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="custom-card-body">
            <div class="form-horizontal-row">
                <label for="title" class="form-horizontal-label">
                    Nombre del articulo <span class="text-danger">*</span>
                </label>
                <div class="form-horizontal-input">
                    <input type="text" 
                           name="title" 
                           id="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-horizontal-row">
                <label for="content" class="form-horizontal-label">
                    Contenido <span class="text-danger">*</span>
                </label>
                <div class="form-horizontal-input">
                    <input type="text" 
                           name="content" 
                           id="content" 
                           class="form-control @error('content') is-invalid @enderror" 
                           value="{{ old('content') }}" 
                           required>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-horizontal-row">
                <label for="author" class="form-horizontal-label">
                    Autor <span class="text-danger">*</span>
                </label>
                <div class="form-horizontal-input">
                    <input type="text" 
                           name="author" 
                           id="author" 
                           class="form-control @error('author') is-invalid @enderror" 
                           value="{{ old('author') }}" 
                           required>
                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-horizontal-row">
                <label for="category" class="form-horizontal-label">
                    Categoria <span class="text-danger">*</span>
                </label>
                <div class="form-horizontal-input">
                    <input type="text" 
                           name="category" 
                           id="category" 
                           class="form-control @error('category') is-invalid @enderror" 
                           value="{{ old('category') }}" 
                           required>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="custom-card-footer">
            <div class="form-footer-content">
                <div class="form-notice-text">
                    <i class="bi bi-info-circle" aria-hidden="true"></i>
                    <span>Recuerda siempre guardar los cambios.</span>
                </div>
                <div>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4">Crear</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
