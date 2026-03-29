@extends('layouts.public')
@section('title', $announcement->title . ' — Masjid Ar-Rohmah')

@section('content')
    <section class="mx-auto w-full max-w-4xl px-6 py-16">
        <a href="{{ route('pengumuman.index') }}"
            class="inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline mb-6">
            ← Kembali ke Pengumuman
        </a>

        <div class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-widest inline-flex {{ $announcement->type === 'pengumuman' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
            {{ $announcement->type === 'pengumuman' ? '📢 Pengumuman' : '📅 Agenda' }}
        </div>

        <h1 class="mt-4 text-3xl font-bold text-ink">{{ $announcement->title }}</h1>

        <div class="mt-4 flex flex-wrap gap-3 text-sm text-ink/45">
            @if ($announcement->published_at)
                <span>Dipublikasikan {{ $announcement->published_at->format('d F Y H:i') }} WIB</span>
            @endif
            @if ($announcement->event_date)
                <span class="rounded-full bg-teal-50 px-3 py-1 font-semibold text-accent">
                    Agenda: {{ $announcement->event_date->format('d F Y H:i') }} WIB
                </span>
            @endif
            @if ($announcement->is_pinned)
                <span class="rounded-full bg-accent/10 px-3 py-1 font-semibold text-accent">📌 Disematkan</span>
            @endif
        </div>

        <x-video-embed :url="$announcement->video_url ?? null" />

        <article class="mt-8 prose prose-ink max-w-none">
            {!! $announcement->content !!}
        </article>

        @if ($relatedAnnouncements->isNotEmpty())
            <section class="mt-12 border-t border-ink/10 pt-8">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Lainnya</p>
                        <h2 class="mt-1 text-2xl font-bold text-ink section-title">Pengumuman Terkait</h2>
                    </div>
                    <a href="{{ route('pengumuman.index') }}" class="text-sm font-bold text-accent transition hover:underline">
                        Lihat Semua →
                    </a>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach ($relatedAnnouncements as $item)
                        <a href="{{ route('pengumuman.show', $item->id) }}"
                            class="rounded-2xl bg-white p-5 shadow-[0_4px_24px_rgba(0,0,0,0.06)] transition hover:-translate-y-0.5 hover:shadow-[0_10px_30px_rgba(0,0,0,0.10)]">
                            <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest {{ $item->type === 'pengumuman' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $item->type === 'pengumuman' ? 'Pengumuman' : 'Agenda' }}
                            </span>
                            <h3 class="mt-3 text-base font-bold text-ink">{{ $item->title }}</h3>
                            <p class="mt-2 text-sm text-ink/50 line-clamp-3">{!! strip_tags($item->content) !!}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </section>
@endsection
