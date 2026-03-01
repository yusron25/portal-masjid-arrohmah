<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('programs.index', [
            'programs' => $programs,
        ]);
    }

    public function show(string $slug): View
    {
        $program = Program::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('programs.show', [
            'program' => $program,
        ]);
    }
}
