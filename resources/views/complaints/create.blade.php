@extends('layouts.public')

@section('content')
    <section class="mx-auto w-full max-w-4xl px-6 py-16">
        <h1 class="text-3xl font-semibold text-ink">Saran & Masukan</h1>
        <p class="mt-2 text-sm text-ink/60">Sampaikan saran, masukan, atau aspirasi Anda untuk Masjid Ar-Rohmah.</p>
        <div class="mt-8 rounded-3xl bg-white p-8 shadow-[0_20px_40px_rgba(15,23,42,0.08)]">
            <livewire:create-complaint />
        </div>
    </section>
@endsection