@extends('layouts.public')
@section('title', 'Pengumuman & Agenda — Masjid Ar-Rohmah')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 py-16">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Informasi</p>
            <h1 class="mt-1 text-3xl font-bold text-ink section-title mx-auto">Pengumuman & Agenda</h1>
            <p class="mt-4 text-sm text-ink/50">Informasi terbaru dan agenda kegiatan Masjid Ar-Rohmah</p>
        </div>

        <div class="space-y-4">
            @forelse ($announcements as $item)
                <div class="rounded-2xl bg-white p-6 shadow-[0_4px_24px_rgba(0,0,0,0.06)] card-hover {{ $item->is_pinned ? 'ring-2 ring-accent/30' : '' }}">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                @if ($item->is_pinned)
                                    <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[10px] font-bold text-accent uppercase">📌 Disematkan</span>
                                @endif
                                <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest {{ $item->type === 'pengumuman' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $item->type === 'pengumuman' ? '📢 Pengumuman' : '📅 Agenda' }}
                                </span>
                            </div>
                            <h3 class="mt-2 text-lg font-bold text-ink">{{ $item->title }}</h3>
                            <div class="mt-2 text-sm text-ink/60 line-clamp-3">{!! strip_tags($item->content) !!}</div>
                        </div>
                        <div class="text-right shrink-0">
                            @if ($item->event_date)
                                <div class="rounded-xl bg-teal-50 px-4 py-2 text-center">
                                    <p class="text-2xl font-extrabold text-accent">{{ $item->event_date->format('d') }}</p>
                                    <p class="text-xs font-bold text-accent/70 uppercase">{{ $item->event_date->format('M Y') }}</p>
                                    <p class="text-[10px] text-ink/40">{{ $item->event_date->format('H:i') }} WIB</p>
                                </div>
                            @endif
                            @if ($item->published_at)
                                <p class="mt-2 text-xs text-ink/30">{{ $item->published_at->diffForHumans() }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border-2 border-dashed border-ink/10 p-12 text-center text-sm text-ink/40">
                    Belum ada pengumuman. Tambahkan melalui panel admin.
                </div>
            @endforelse
        </div>

        @if ($announcements->hasPages())
            <div class="mt-8">
                {{ $announcements->links() }}
            </div>
        @endif
    </section>
@endsection
