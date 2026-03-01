<?php

namespace App\Http\Controllers;

use App\Models\KajianSchedule;
use Illuminate\View\View;

class KajianController extends Controller
{
    public function index(): View
    {
        $schedules = KajianSchedule::query()
            ->where('is_active', true)
            ->orderByRaw("FIELD(day_of_week, 'Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->get();

        return view('kajian.index', [
            'schedules' => $schedules,
        ]);
    }
}
