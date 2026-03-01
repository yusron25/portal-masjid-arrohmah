<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::query()
            ->withCount('images')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('galleries.index', compact('galleries'));
    }

    public function show(int $id): View
    {
        $gallery = Gallery::with('images')->findOrFail($id);

        return view('galleries.show', compact('gallery'));
    }
}
