<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\View\View;

class FinanceController extends Controller
{
    public function index(): View
    {
        $kasDkm = Finance::where('fund_source', 'kas_dkm')
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) as saldo")
            ->value('saldo') ?? 0;

        $gias = Finance::where('fund_source', 'gias')
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) as saldo")
            ->value('saldo') ?? 0;

        $transactions = Finance::query()
            ->orderByDesc('transaction_date')
            ->paginate(20);

        return view('keuangan.index', [
            'kasDkm' => $kasDkm,
            'gias' => $gias,
            'transactions' => $transactions,
        ]);
    }
}
