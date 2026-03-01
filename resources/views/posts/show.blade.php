@extends('layouts.public')

@section('content')
    <article class="mx-auto w-full max-w-4xl px-6 py-8">
        {{-- Breadcrumb --}}
        <nav class="mb-8 text-sm text-ink/50">
            <a href="{{ route('home') }}" class="hover:text-accent transition">Beranda</a>
            <span class="mx-2">›</span>
            <a href="{{ route('posts.index') }}" class="hover:text-accent transition">Berita</a>
            <span class="mx-2">›</span>
            <span class="text-ink/70">{{ Str::limit($post->title, 40) }}</span>
        </nav>

        {{-- Category & Date --}}
        <div class="flex flex-wrap items-center gap-3">
            @if ($post->category)
                <span
                    class="rounded-full bg-emerald-50 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-emerald-600">{{ $post->category->name }}</span>
            @endif
            <span class="text-xs text-ink/40">{{ optional($post->published_at)->format('d F Y') }}</span>
        </div>

        {{-- Title --}}
        <h1 class="mt-4 text-3xl font-extrabold leading-tight text-ink md:text-4xl">{{ $post->title }}</h1>

        {{-- Thumbnail --}}
        @if ($post->thumbnail)
            <div class="mt-8 overflow-hidden rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full object-cover">
            </div>
        @endif

        {{-- Content --}}
        <div class="prose prose-lg mt-10 max-w-none prose-headings:text-ink prose-a:text-accent prose-img:rounded-xl">
            {!! $post->content !!}
        </div>

        {{-- Share --}}
        <div class="mt-12 flex items-center gap-3 border-t border-ink/10 pt-8">
            <span class="text-sm font-semibold text-ink/50">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank"
                class="rounded-full bg-emerald-50 p-2.5 text-emerald-600 transition hover:bg-emerald-100">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                class="rounded-full bg-blue-50 p-2.5 text-blue-600 transition hover:bg-blue-100">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
            </a>
        </div>
    </article>

    {{-- Related Posts --}}
    @if ($relatedPosts->count())
        <section class="mx-auto w-full max-w-6xl px-6 pb-8">
            <h2 class="text-xl font-bold text-ink section-title">Berita Terkait</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related->slug) }}"
                        class="group card-hover rounded-2xl bg-white overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)]">
                        @if ($related->thumbnail)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ Storage::url($related->thumbnail) }}" alt="{{ $related->title }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        @else
                            <div class="aspect-video bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                                <svg class="h-10 w-10 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-5">
                            <h3 class="text-base font-bold text-ink group-hover:text-accent transition">{{ $related->title }}</h3>
                            <p class="mt-2 text-xs text-ink/40">{{ optional($related->published_at)->format('d M Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection