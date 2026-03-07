<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Finance;
use App\Models\Gallery;
use App\Models\KajianSchedule;
use App\Models\Program;
use App\Models\Slider;
use App\Models\SocialMedia;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $galleries = Gallery::query()
            ->withCount('images')
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        // New module data
        $kajianSchedules = KajianSchedule::query()
            ->where('is_active', true)
            ->orderByRaw("FIELD(day_of_week, 'Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->take(6)
            ->get();

        $announcements = Announcement::query()
            ->where('is_active', true)
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        $programs = Program::query()
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        // Finance summary
        $kasDkm = Finance::where('fund_source', 'kas_dkm')
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) as saldo")
            ->value('saldo') ?? 0;

        $gias = Finance::where('fund_source', 'gias')
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) as saldo")
            ->value('saldo') ?? 0;

        $socialMedia = SocialMedia::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', [
            'sliders' => $sliders,
            'galleries' => $galleries,
            'kajianSchedules' => $kajianSchedules,
            'announcements' => $announcements,
            'programs' => $programs,
            'kasDkm' => $kasDkm,
            'gias' => $gias,
            'socialMedia' => $socialMedia,
        ]);
    }
}