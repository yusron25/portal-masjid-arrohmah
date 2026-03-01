@extends('layouts.public')
@section('title', 'Program — Masjid Ar-Rohmah')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 py-16">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Kegiatan</p>
            <h1 class="mt-1 text-3xl font-bold text-ink section-title mx-auto">Program Sosial & Pendidikan</h1>
            <p class="mt-4 text-sm text-ink/50">Program pemberdayaan umat melalui kegiatan sosial dan pendidikan</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($programs as $program)
                <a href="{{ route('programs.show', $program->slug) }}" class="group card-hover rounded-2xl bg-white overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)]">
                    @if ($program->thumbnail)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($program->thumbnail) }}" alt="{{ $program->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-teal-50 to-teal-100 flex items-center justify-center">
                            <svg class="h-10 w-10 text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                    @endif
                    <div class="p-5">
                        <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest {{ $program->category === 'sosial' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $program->category === 'sosial' ? 'Sosial' : 'Pendidikan' }}
                        </span>
                        <h3 class="mt-2 text-lg font-bold text-ink group-hover:text-accent transition">{{ $program->title }}</h3>
                        @if ($program->description)
                            <p class="mt-2 text-sm text-ink/50 line-clamp-2">{!! strip_tags($program->description) !!}</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full rounded-2xl border-2 border-dashed border-ink/10 p-12 text-center text-sm text-ink/40">
                    Belum ada program. Tambahkan melalui panel admin.
                </div>
            @endforelse
        </div>

        @if ($programs->hasPages())
            <div class="mt-8">
                {{ $programs->links() }}
            </div>
        @endif
    </section>
@endsection
