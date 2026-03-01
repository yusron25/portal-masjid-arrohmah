<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPosts = Post::query()
            ->where('id', '!=', $post->id)
            ->where('is_active', true)
            ->where('category_id', $post->category_id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
