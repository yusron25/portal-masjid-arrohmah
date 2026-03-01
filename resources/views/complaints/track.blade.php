@extends('layouts.public')

@section('content')
    <section class="mx-auto w-full max-w-3xl px-6 py-16">
        <h1 class="text-3xl font-semibold text-ink">Lacak Saran</h1>
        <p class="mt-2 text-sm text-ink/60">Masukkan kode tiket untuk melihat status saran Anda.</p>
        <div class="mt-8 rounded-3xl bg-white p-8 shadow-[0_20px_40px_rgba(15,23,42,0.08)]">
            <livewire:track-complaint />
        </div>
    </section>
@endsection