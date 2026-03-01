@extends('layouts.public')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 py-8">
        <div class="mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Portal Berita</p>
            <h1 class="mt-2 text-3xl font-bold text-ink section-title">Kajian & Berita Masjid</h1>
            <p class="mt-4 max-w-xl text-sm text-ink/60">Informasi terbaru seputar kajian, kegiatan, dan perkembangan Masjid Ar-Rohmah.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="group card-hover rounded-2xl bg-white overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)]">
                    @if ($post->thumbnail)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                            <svg class="h-12 w-12 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                    <div class="p-5">
                        @if ($post->category)
                            <span class="inline-block rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-emerald-600">{{ $post->category->name }}</span>
                        @endif
                        <h2 class="mt-3 text-lg font-bold text-ink leading-snug group-hover:text-accent transition">{{ $post->title }}</h2>
                        <p class="mt-2 text-sm text-ink/60 line-clamp-3">{{ Str::limit(strip_tags($post->content ?? ''), 120) }}</p>
                        <p class="mt-4 text-xs font-medium text-ink/40">{{ optional($post->published_at)->format('d M Y') }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full rounded-2xl border-2 border-dashed border-ink/10 p-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <p class="mt-3 text-sm text-ink/40">Belum ada berita yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    </section>
@endsection
