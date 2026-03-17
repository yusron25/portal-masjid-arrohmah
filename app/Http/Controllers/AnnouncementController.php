<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::query()
            ->where('is_active', true)
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->paginate(15);

        return view('pengumuman.index', [
            'announcements' => $announcements,
        ]);
    }

    public function show(int $announcement): View
    {
        $announcement = Announcement::query()
            ->whereKey($announcement)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedAnnouncements = Announcement::query()
            ->where('is_active', true)
            ->whereKeyNot($announcement->id)
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('pengumuman.show', [
            'announcement' => $announcement,
            'relatedAnnouncements' => $relatedAnnouncements,
        ]);
    }
}
