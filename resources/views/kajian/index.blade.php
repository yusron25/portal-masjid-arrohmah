@extends('layouts.public')
@section('title', 'Jadwal Kajian — Masjid Ar-Rohmah')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 py-16">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Dakwah</p>
            <h1 class="mt-1 text-3xl font-bold text-ink section-title mx-auto">Jadwal Kajian & Dakwah</h1>
            <p class="mt-4 text-sm text-ink/50">Jadwal kajian rutin dan kegiatan dakwah Masjid Ar-Rohmah</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($schedules as $schedule)
                <div class="rounded-2xl bg-white p-6 shadow-[0_4px_24px_rgba(0,0,0,0.06)] card-hover">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50">
                            <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        @if ($schedule->day_of_week)
                            <span
                                class="rounded-full bg-accent/10 px-3 py-1 text-xs font-bold text-accent">{{ $schedule->day_of_week }}</span>
                        @endif
                        @if ($schedule->event_date)
                            <span
                                class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">{{ $schedule->event_date->format('d M Y') }}</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-ink">{{ $schedule->title }}</h3>
                    <p class="mt-1 text-sm text-accent font-semibold">{{ $schedule->speaker }}</p>
                    <div class="mt-3 flex items-center gap-4 text-xs text-ink/50">
                        <span>🕐
                            {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}{{ $schedule->time_end ? ' - ' . \Carbon\Carbon::parse($schedule->time_end)->format('H:i') : '' }}</span>
                        @if ($schedule->location)
                            <span>📍 {{ $schedule->location }}</span>
                        @endif
                    </div>
                    @if ($schedule->description)
                        <p class="mt-3 text-sm text-ink/60 line-clamp-2">{!! strip_tags($schedule->description) !!}</p>
                    @endif
                </div>
            @empty
                <div
                    class="col-span-full rounded-2xl border-2 border-dashed border-ink/10 p-12 text-center text-sm text-ink/40">
                    Belum ada jadwal kajian. Tambahkan melalui panel admin.
                </div>
            @endforelse
        </div>
    </section>
@endsection