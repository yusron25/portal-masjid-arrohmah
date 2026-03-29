@extends('layouts.public')
@section('title', 'Galeri Masjid - Masjid Ar-Rohmah')
@section('meta_description', 'Galeri dokumentasi kegiatan, kajian, dan momen penting Masjid Ar-Rohmah.')
@section('meta_image', $galleries->first()?->cover_image ? url(Storage::url($galleries->first()->cover_image)) : asset('images/logo-arrohmah.png'))
@section('meta_url', route('galleries.index'))

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 py-8">
        <div class="mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Dokumentasi</p>
            <h1 class="mt-2 text-3xl font-bold text-ink section-title">Galeri Masjid</h1>
            <p class="mt-4 max-w-xl text-sm text-ink/60">Kumpulan foto kegiatan, kajian, dan momen penting di Masjid
                Ar-Rohmah.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($galleries as $gallery)
                <a href="{{ route('galleries.show', $gallery->id) }}"
                    class="group card-hover rounded-2xl bg-white overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)]">
                    @if ($gallery->cover_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($gallery->cover_image) }}" alt="{{ $gallery->title }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                            <svg class="h-12 w-12 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-5">
                        <h2 class="text-lg font-bold text-ink group-hover:text-accent transition">{{ $gallery->title }}</h2>
                        @if ($gallery->description)
                            <div class="mt-2 text-sm text-ink/60 line-clamp-2">{!! strip_tags($gallery->description) !!}</div>
                        @endif
                        <div class="mt-3 flex items-center gap-2 text-xs text-ink/40">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $gallery->images_count ?? 0 }} foto</span>
                            @if ($gallery->published_at)
                                <span>• {{ $gallery->published_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full rounded-2xl border-2 border-dashed border-ink/10 p-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-3 text-sm text-ink/40">Belum ada galeri yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $galleries->links() }}
        </div>
    </section>
@endsection
