<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar', '');

        $cantidad = (int) $request->input('cantidad', 10);
        if (!in_array($cantidad, [10, 25, 50])) {
            $cantidad = 10;
        }

        $posts = Post::where('title', 'like', '%' . $buscar . '%')
            ->orderBy('id', 'desc')
            ->paginate($cantidad)
            ->withQueryString();

        return view('posts.index', compact('posts', 'buscar', 'cantidad'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'category' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = $request->author;
        $post->category = $request->category;
        $post->save();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Artículo creado correctamente.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'category' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = $request->author;
        $post->category = $request->category;
        $post->save();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Artículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Artículo eliminado correctamente.');
    }
}
