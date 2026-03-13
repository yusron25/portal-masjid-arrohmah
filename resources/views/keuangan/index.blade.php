@extends('layouts.public')
@section('title', 'Laporan Keuangan — Masjid Ar-Rohmah')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 py-16">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Transparansi</p>
            <h1 class="mt-1 text-3xl font-bold text-ink section-title mx-auto">Laporan Keuangan</h1>
            <p class="mt-4 text-sm text-ink/50">Transparansi pengelolaan keuangan Masjid Ar-Rohmah</p>
        </div>

        {{-- Saldo Cards --}}
        <div class="grid gap-6 sm:grid-cols-1 mb-10">
            <div class="rounded-2xl bg-gradient-to-br from-teal-600 to-teal-800 p-8 text-white shadow-lg">
                <p class="text-sm font-medium text-white/70 uppercase tracking-widest">Saldo Kas DKM</p>
                <p class="mt-3 text-3xl font-extrabold">Rp {{ number_format($kasDkm, 0, ',', '.') }}</p>
            </div>
            {{-- <div class="rounded-2xl bg-gradient-to-br from-amber-600 to-amber-800 p-8 text-white shadow-lg">
                <p class="text-sm font-medium text-white/70 uppercase tracking-widest">Saldo GIAS</p>
                <p class="mt-3 text-3xl font-extrabold">Rp {{ number_format($gias, 0, ',', '.') }}</p>
            </div> --}}
        </div>

        {{-- Transaction Table --}}
        <div class="rounded-2xl bg-white shadow-[0_4px_24px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="px-6 py-4 border-b border-ink/5">
                <h2 class="text-lg font-bold text-ink">Riwayat Transaksi</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-ink/5 bg-ink/[0.02]">
                            <th class="px-6 py-3 text-left font-semibold text-ink/50 uppercase tracking-widest text-xs">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left font-semibold text-ink/50 uppercase tracking-widest text-xs">
                                Jenis</th>
                            <th class="px-6 py-3 text-left font-semibold text-ink/50 uppercase tracking-widest text-xs">
                                Sumber</th>
                            <th class="px-6 py-3 text-left font-semibold text-ink/50 uppercase tracking-widest text-xs">
                                Keterangan</th>
                            <th class="px-6 py-3 text-right font-semibold text-ink/50 uppercase tracking-widest text-xs">
                                Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $tx)
                            <tr class="border-b border-ink/5 hover:bg-ink/[0.01]">
                                <td class="px-6 py-3 text-ink/70">{{ $tx->transaction_date->format('d M Y') }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $tx->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $tx->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="rounded-full bg-blue-100 text-blue-700 px-2.5 py-0.5 text-xs font-bold">
                                        {{ $tx->fund_source === 'kas_dkm' ? 'Kas DKM' : 'GIAS' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-ink/70">{{ $tx->description }}</td>
                                <td
                                    class="px-6 py-3 text-right font-semibold {{ $tx->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $tx->type === 'income' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-ink/40">Belum ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($transactions->hasPages())
                <div class="px-6 py-4 border-t border-ink/5">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection