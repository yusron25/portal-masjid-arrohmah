<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $posts = Post::query()
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->take(6)
            ->get();

        $galleries = Gallery::query()
            ->withCount('images')
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('home', [
            'sliders' => $sliders,
            'posts' => $posts,
            'galleries' => $galleries,
        ]);
    }
}