@extends('layouts.public')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($program->description ?: ('Detail program ' . $program->title . ' di Masjid Ar-Rohmah.')), 160))
@section('meta_image', $program->thumbnail ? url(Storage::url($program->thumbnail)) : asset('images/logo-arrohmah.png'))
@section('meta_url', route('programs.show', $program->slug))
@section('meta_type', 'article')
@section('title', $program->title . ' — Masjid Ar-Rohmah')

@section('content')
    <section class="mx-auto w-full max-w-4xl px-6 py-16">
        <a href="{{ route('programs.index') }}"
            class="inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline mb-6">
            ← Kembali ke Program
        </a>

        @if ($program->thumbnail)
            <div class="rounded-2xl overflow-hidden mb-8 shadow-lg">
                <img src="{{ Storage::url($program->thumbnail) }}" alt="{{ $program->title }}" class="w-full h-auto">
            </div>
        @endif

        <span
            class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-widest {{ $program->category === 'sosial' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
            {{ $program->category === 'sosial' ? 'Sosial' : 'Pendidikan' }}
        </span>

        <h1 class="mt-4 text-3xl font-bold text-ink">{{ $program->title }}</h1>

        @if ($program->published_at)
            <p class="mt-2 text-sm text-ink/40">{{ $program->published_at->format('d F Y') }}</p>
        @endif

        <x-video-embed :url="$program->video_url ?? null" />

        <div class="mt-8 prose prose-ink max-w-none">
            {!! $program->description !!}
        </div>
    </section>
@endsection
