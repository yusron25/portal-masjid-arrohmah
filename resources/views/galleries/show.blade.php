@extends('layouts.public')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 py-8">
        {{-- Breadcrumb --}}
        <nav class="mb-8 text-sm text-ink/50">
            <a href="{{ route('home') }}" class="hover:text-accent transition">Beranda</a>
            <span class="mx-2">›</span>
            <a href="{{ route('galleries.index') }}" class="hover:text-accent transition">Galeri</a>
            <span class="mx-2">›</span>
            <span class="text-ink/70">{{ Str::limit($gallery->title, 40) }}</span>
        </nav>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-ink">{{ $gallery->title }}</h1>
            @if ($gallery->description)
                <p class="mt-3 max-w-2xl text-sm text-ink/60">{{ $gallery->description }}</p>
            @endif
            @if ($gallery->published_at)
                <p class="mt-2 text-xs text-ink/40">{{ $gallery->published_at->format('d F Y') }}</p>
            @endif
        </div>

        @if ($gallery->images->count())
            <div class="columns-2 gap-4 space-y-4 md:columns-3 lg:columns-4">
                @foreach ($gallery->images as $image)
                    <div
                        class="break-inside-avoid overflow-hidden rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)]">
                        <img src="{{ Storage::url($image->image_path) }}" alt="Foto galeri {{ $gallery->title }}"
                            class="w-full cursor-pointer transition-transform duration-500 hover:scale-105"
                            onclick="openLightbox('{{ Storage::url($image->image_path) }}')" loading="lazy">
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border-2 border-dashed border-ink/10 p-16 text-center">
                <svg class="mx-auto h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-3 text-sm text-ink/40">Belum ada foto di galeri ini.</p>
            </div>
        @endif
    </section>

    {{-- Lightbox --}}
    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-6 backdrop-blur-sm"
        onclick="closeLightbox()">
        <button onclick="closeLightbox()"
            class="absolute right-6 top-6 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/20">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img id="lightbox-img" src="" alt="" class="max-h-[85vh] max-w-[90vw] rounded-lg shadow-2xl">
    </div>

    <script>
        function openLightbox(src) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightbox').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
@endsection