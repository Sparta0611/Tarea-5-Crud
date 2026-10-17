<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_posts(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/posts');
    }

    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $response = $this->get('/posts');
        $response->assertRedirect('/login');
    }

    public function test_user_can_register_as_admin_and_see_name_in_topbar(): void
    {
        $response = $this->post('/register', [
            'name'     => 'Carlos Mendoza',
            'email'    => 'carlos.mendoza@usap.edu',
            'password' => '123456',
            'role'     => 'admin',
        ]);

        $response->assertRedirect('/posts');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name'  => 'Carlos Mendoza',
            'email' => 'carlos.mendoza@usap.edu',
            'role'  => 'admin',
        ]);

        $indexResponse = $this->get('/posts');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Carlos Mendoza');
        $indexResponse->assertSee('Crear');
    }

    public function test_user_can_login_with_credentials(): void
    {
        $user = User::factory()->create([
            'name'     => 'Carlos López',
            'email'    => 'carlos@usap.edu',
            'password' => 'secret123',
            'role'     => 'user',
        ]);

        $response = $this->post('/login', [
            'email'    => 'carlos@usap.edu',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/posts');
        $this->assertAuthenticatedAs($user);
    }

    public function test_readonly_user_can_only_view_posts_and_cannot_mutate(): void
    {
        $user = User::factory()->create([
            'name' => 'Visitante USAP',
            'role' => 'user',
        ]);

        $post = Post::create([
            'title'    => 'Admisiones',
            'content'  => 'Información general',
            'author'   => 'Admisiones',
            'category' => 'Admisiones',
        ]);

        $response = $this->actingAs($user)->get('/posts');
        $response->assertStatus(200);
        $response->assertSee('Visitante USAP');
        $response->assertSee('Admisiones');
        $response->assertDontSee('Editar articulo');

        $this->actingAs($user)->get('/posts/create')->assertStatus(403);
        $this->actingAs($user)->post('/posts', [
            'title' => 'Intento', 'content' => 'X', 'author' => 'X', 'category' => 'X',
        ])->assertStatus(403);
        $this->actingAs($user)->get("/posts/{$post->id}/edit")->assertStatus(403);
        $this->actingAs($user)->put("/posts/{$post->id}", [
            'title' => 'Intento', 'content' => 'X', 'author' => 'X', 'category' => 'X',
        ])->assertStatus(403);
        $this->actingAs($user)->delete("/posts/{$post->id}")->assertStatus(403);
    }

    public function test_posts_index_screen_can_be_rendered_for_admin(): void
    {
        $admin = User::factory()->admin()->create();

        Post::create([
            'title'    => 'Admisiones',
            'content'  => 'Información general',
            'author'   => 'Admisiones',
            'category' => 'Admisiones',
        ]);

        $response = $this->actingAs($admin)->get('/posts');
        $response->assertStatus(200);
        $response->assertSee('Artículos');
        $response->assertSee('Admisiones');
        $response->assertSee('Editar articulo');
    }

    public function test_posts_create_screen_can_be_rendered(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/posts/create');
        $response->assertStatus(200);
        $response->assertSee('Crear articulo');
        $response->assertSee('Nombre del articulo');
    }

    public function test_new_post_can_be_created(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/posts', [
            'title'    => 'Artículo de Prueba Automatizado',
            'content'  => 'Contenido para la prueba',
            'author'   => 'Estudiante USAP',
            'category' => 'Educación',
        ]);

        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Artículo creado correctamente.');

        $this->assertDatabaseHas('posts', [
            'title'  => 'Artículo de Prueba Automatizado',
            'author' => 'Estudiante USAP',
        ]);
    }

    public function test_post_edit_screen_can_be_rendered(): void
    {
        $admin = User::factory()->admin()->create();

        $post = Post::create([
            'title'    => 'Marco Alemán Watters',
            'content'  => 'Novedades',
            'author'   => 'Novedades',
            'category' => 'Novedades',
        ]);

        $response = $this->actingAs($admin)->get("/posts/{$post->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Editar articulo');
        $response->assertSee($post->title);
    }

    public function test_post_can_be_updated(): void
    {
        $admin = User::factory()->admin()->create();

        $post = Post::create([
            'title'    => 'Matriculate en línea',
            'content'  => 'Matrícula',
            'author'   => 'Matrícula',
            'category' => 'Matrícula',
        ]);

        $response = $this->actingAs($admin)->put("/posts/{$post->id}", [
            'title'    => 'Matriculate en línea Actualizado',
            'content'  => 'Contenido Actualizado',
            'author'   => $post->author,
            'category' => $post->category,
        ]);

        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Artículo actualizado correctamente.');

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Matriculate en línea Actualizado',
        ]);
    }

    public function test_post_can_be_soft_deleted(): void
    {
        $admin = User::factory()->admin()->create();

        $post = Post::create([
            'title'    => 'Post para eliminar',
            'content'  => 'Contenido a borrar',
            'author'   => 'Autor',
            'category' => 'General',
        ]);

        $response = $this->actingAs($admin)->delete("/posts/{$post->id}");

        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Artículo eliminado correctamente.');

        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }
}
