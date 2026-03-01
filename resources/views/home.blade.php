@extends('layouts.public')

@section('content')
    @php
        $hero = $sliders->first();
    @endphp

    {{-- Hero Section with Image Slider --}}
    <section class="relative overflow-hidden min-h-[520px]">
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Masjid Ar-Rohmah" class="h-full w-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/50 to-black/30"></div>
        <div class="relative mx-auto flex w-full max-w-6xl flex-col gap-10 px-6 pb-20 pt-8 md:flex-row md:items-center">
            <div class="max-w-xl text-white fade-up">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-white/15 backdrop-blur-sm px-4 py-1.5 text-xs font-bold text-teal-300">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                    Portal Masjid Ar-Rohmah
                </div>
                <h1 class="mt-5 text-4xl font-extrabold leading-tight md:text-5xl">
                    Masjid <span class="text-teal-400">Ar-Rohmah</span>
                </h1>
                <p class="mt-2 text-lg font-medium text-white/60">Perum Tridaya Indah 1, Tambun Selatan, Kabupaten Bekasi
                </p>
                <p class="mt-4 text-base leading-relaxed text-white/75">
                    Pusat ibadah, kajian, dan kegiatan umat Islam. Temukan jadwal solat, info kajian terbaru, dan galeri
                    kegiatan masjid kami.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#jadwal-solat"
                        class="rounded-full bg-accent px-6 py-3 text-sm font-bold text-white shadow-lg shadow-teal-500/20 transition hover:shadow-teal-500/40 hover:-translate-y-0.5">🕌
                        Jadwal Solat</a>
                    <a href="{{ route('posts.index') }}"
                        class="rounded-full border-2 border-white/30 px-6 py-3 text-sm font-bold text-white transition hover:border-white/60 hover:-translate-y-0.5">📖
                        Kajian & Berita</a>
                </div>
            </div>

            {{-- Slider Carousel --}}
            @if ($sliders->count() > 0)
                <div class="w-full md:w-[420px] shrink-0 fade-up" style="animation-delay:.2s" id="hero-slider">
                    <div class="relative rounded-2xl overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,0.15)] aspect-[4/3]">
                        @foreach ($sliders as $index => $slide)
                            <div class="slider-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                                data-slide="{{ $index }}">
                                @if ($slide->image_path)
                                    <img src="{{ Storage::url($slide->image_path) }}" alt="{{ $slide->title }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-gradient-to-br from-teal-400 to-teal-600"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <h3 class="text-lg font-bold text-white leading-snug">{{ $slide->title }}</h3>
                                    @if ($slide->description)
                                        <p class="mt-1.5 text-sm text-white/70 line-clamp-2">{{ $slide->description }}</p>
                                    @endif
                                    @if ($slide->link_url)
                                        <a href="{{ $slide->link_url }}"
                                            class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-teal-300 hover:text-teal-200 transition">
                                            Selengkapnya <span>→</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        {{-- Dot Navigation --}}
                        @if ($sliders->count() > 1)
                            <div class="absolute bottom-2 right-3 flex gap-1.5 z-10">
                                @foreach ($sliders as $index => $slide)
                                    <button
                                        class="slider-dot h-2 w-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-5' : 'bg-white/50' }}"
                                        data-target="{{ $index }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Slider Script --}}
                <script>             document.addEventListener('DOMContentLoaded', functio n() {                 const slides = document.querySelectorAll('.slider-slide');                 const dots = document.querySelectorAll('.slider-dot');                 if (slides.length <= 1) return;
                         let current = 0;                 let timer;
                         function goTo(index) {                     slides[current].classList.remove('opacity-100');                     slides[current].classList.add('opacity-0');                     dots[current].classList.remove('bg-white', 'w-5');                     dots[current].classList.add('bg-white/50');
                             current = index;
                             slides[current].classList.remove('opacity-0');                     slides[current].classList.add('opacity-100');                     dots[current].classList.remove('bg-white/50');                     dots[current].classList.add('bg-white', 'w-5');                 }
                         function next() {                     goTo((current + 1) % slides.length);                 }
                         function startTimer() {                     timer = setInterval(next, 5000);                 }
                         dots.forEach(functio n(dot) {                     dot.addEventListener('click', functio n() {                         clearInterval(timer);                         goTo(parseInt(this.dataset.target));                         startTimer();                     });                 });
                         startTimer();             });
                </script>
            @else
                <div class="glass-card fade-up" style="animation-delay:.2s">
                    <p class="text-sm text-ink/60">Tambahkan slider melalui admin untuk menampilkan sorotan.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Stats section --}}
    <section class="mx-auto -mt-6 w-full max-w-6xl px-6">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @php
                $stats = [
                    ['value' => '5', 'label' => 'Waktu Solat', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                    ['value' => $posts->count() . '+', 'label' => 'Kajian & Berita', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>'],
                    ['value' => $galleries->count() . '+', 'label' => 'Album Galeri', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                    ['value' => '24/7', 'label' => 'Terbuka Untuk Ibadah', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="rounded-2xl bg-white p-5 shadow-[0_4px_24px_rgba(0,0,0,0.05)] text-center card-hover">
                    <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50">
                        <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">{!! $stat['icon'] !!}</svg>
                    </div>
                    <p class="text-2xl font-extrabold text-ink">{{ $stat['value'] }}</p>
                    <p class="text-xs font-medium text-ink/50">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Jadwal Solat Section --}}
    <section id="jadwal-solat" class="mx-auto w-full max-w-6xl px-6 py-16">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Jadwal Harian</p>
            <h2 class="mt-1 text-2xl font-bold text-ink section-title mx-auto">Jadwal Solat Hari Ini</h2>
            <p class="mt-4 text-sm text-ink/50" id="prayer-date">Memuat jadwal...</p>
        </div>

        {{-- Countdown to Next Prayer --}}
        <div class="mb-8 flex justify-center">
            <div
                class="rounded-2xl bg-gradient-to-br from-teal-600 to-teal-700 px-8 py-5 text-center text-white shadow-lg shadow-teal-500/20">
                <p class="text-xs font-medium text-white/60 uppercase tracking-widest">Solat Berikutnya</p>
                <p class="mt-1 text-xl font-extrabold" id="next-prayer-name">—</p>
                <p class="mt-1 text-3xl font-extrabold tracking-tight" id="next-prayer-countdown">--:--:--</p>
            </div>
        </div>

        {{-- Prayer Times Grid --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6" id="prayer-times-grid">
            <div class="prayer-card rounded-2xl bg-white p-5 text-center shadow-[0_4px_24px_rgba(0,0,0,0.05)] card-hover"
                data-prayer="Fajr">
                <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50">
                    <span class="text-lg">🌅</span>
                </div>
                <p class="text-sm font-bold text-ink">Subuh</p>
                <p class="mt-1 text-xl font-extrabold text-accent" id="time-fajr">--:--</p>
            </div>
            <div class="prayer-card rounded-2xl bg-white p-5 text-center shadow-[0_4px_24px_rgba(0,0,0,0.05)] card-hover"
                data-prayer="Sunrise">
                <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50">
                    <span class="text-lg">☀️</span>
                </div>
                <p class="text-sm font-bold text-ink">Syuruq</p>
                <p class="mt-1 text-xl font-extrabold text-accent" id="time-sunrise">--:--</p>
            </div>
            <div class="prayer-card rounded-2xl bg-white p-5 text-center shadow-[0_4px_24px_rgba(0,0,0,0.05)] card-hover"
                data-prayer="Dhuhr">
                <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-50">
                    <span class="text-lg">🌤️</span>
                </div>
                <p class="text-sm font-bold text-ink">Dzuhur</p>
                <p class="mt-1 text-xl font-extrabold text-accent" id="time-dhuhr">--:--</p>
            </div>
            <div class="prayer-card rounded-2xl bg-white p-5 text-center shadow-[0_4px_24px_rgba(0,0,0,0.05)] card-hover"
                data-prayer="Asr">
                <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50">
                    <span class="text-lg">🌇</span>
                </div>
                <p class="text-sm font-bold text-ink">Ashar</p>
                <p class="mt-1 text-xl font-extrabold text-accent" id="time-asr">--:--</p>
            </div>
            <div class="prayer-card rounded-2xl bg-white p-5 text-center shadow-[0_4px_24px_rgba(0,0,0,0.05)] card-hover"
                data-prayer="Maghrib">
                <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50">
                    <span class="text-lg">🌆</span>
                </div>
                <p class="text-sm font-bold text-ink">Maghrib</p>
                <p class="mt-1 text-xl font-extrabold text-accent" id="time-maghrib">--:--</p>
            </div>
            <div class="prayer-card rounded-2xl bg-white p-5 text-center shadow-[0_4px_24px_rgba(0,0,0,0.05)] card-hover"
                data-prayer="Isha">
                <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50">
                    <span class="text-lg">🌙</span>
                </div>
                <p class="text-sm font-bold text-ink">Isya</p>
                <p class="mt-1 text-xl font-extrabold text-accent" id="time-isha">--:--</p>
            </div>
        </div>

        <p class="mt-4 text-center text-xs text-ink/40">Data dari Aladhan API • Metode: Kementerian Agama RI • Lokasi:
            Tambun Selatan, Bekasi</p>
    </section>

    {{-- Prayer Times Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tambun Selatan, Bekasi coordinates
            var lat = -6.2867;
            var lng = 107.0456;
            var method = 20; // Kementerian Agama RI method

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            // Format date for display
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var dateStr = today.toLocaleDateString('id-ID', options).replace('Minggu', 'Ahad');
            document.getElementById('prayer-date').textContent = dateStr;

            var apiUrl = 'https://api.aladhan.com/v1/timings/' + dd + '-' + mm + '-' + yyyy + '?latitude=' + lat + '&longitude=' + lng + '&method=' + method;

            fetch(apiUrl)
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    var timings = data.data.timings;

                    document.getElementById('time-fajr').textContent = timings.Fajr;
                    document.getElementById('time-sunrise').textContent = timings.Sunrise;
                    document.getElementById('time-dhuhr').textContent = timings.Dhuhr;
                    document.getElementById('time-asr').textContent = timings.Asr;
                    document.getElementById('time-maghrib').textContent = timings.Maghrib;
                    document.getElementById('time-isha').textContent = timings.Isha;

                    // Hijri date
                    var hijri = data.data.date.hijri;
                    document.getElementById('prayer-date').textContent = dateStr + ' / ' + hijri.day + ' ' + hijri.month.en + ' ' + hijri.year + ' H';

                    // Start countdown
                    startCountdown(timings);
                })
                .catch(function() {
                    document.getElementById('prayer-date').textContent = 'Gagal memuat jadwal solat. Silakan refresh.';
                });

            function startCountdown(timings) {
                var prayerOrder = [
                    { key: 'Fajr', name: 'Subuh' },
                    { key: 'Dhuhr', name: 'Dzuhur' },
                    { key: 'Asr', name: 'Ashar' },
                    { key: 'Maghrib', name: 'Maghrib' },
                    { key: 'Isha', name: 'Isya' }
                ];

                function updateCountdown() {
                    var now = new Date();
                    var nextPrayer = null;
                    var nextTime = null;

                    for (var i = 0; i < prayerOrder.length; i++) {
                        var prayer = prayerOrder[i];
                        var parts = timings[prayer.key].split(':');
                        var h = parseInt(parts[0]);
                        var m = parseInt(parts[1]);
                        var prayerTime = new Date(now);
                        prayerTime.setHours(h, m, 0, 0);

                        if (prayerTime > now) {
                            nextPrayer = prayer;
                            nextTime = prayerTime;
                            break;
                        }
                    }

                    if (!nextPrayer) {
                        // After Isha, next is Fajr tomorrow
                        var fajrParts = timings['Fajr'].split(':');
                        var tomorrow = new Date(now);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        tomorrow.setHours(parseInt(fajrParts[0]), parseInt(fajrParts[1]), 0, 0);
                        nextPrayer = { key: 'Fajr', name: 'Subuh' };
                        nextTime = tomorrow;
                    }

                    var diff = nextTime - now;
                    var hours = Math.floor(diff / 3600000);
                    var mins = Math.floor((diff % 3600000) / 60000);
                    var secs = Math.floor((diff % 60000) / 1000);

                    document.getElementById('next-prayer-name').textContent = nextPrayer.name;
                    document.getElementById('next-prayer-countdown').textContent =
                        String(hours).padStart(2, '0') + ':' + String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');

                    // Highlight active prayer card
                    var cards = document.querySelectorAll('.prayer-card');
                    for (var j = 0; j < cards.length; j++) {
                        cards[j].classList.remove('ring-2', 'ring-accent', 'bg-teal-50');
                        if (cards[j].dataset.prayer === nextPrayer.key) {
                            cards[j].classList.add('ring-2', 'ring-accent', 'bg-teal-50');
                        }
                    }
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            }
        });
    </script>

    {{-- Latest News / Kajian --}}
    <section class="mx-auto w-full max-w-6xl px-6 py-16">
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Terbaru</p>
                <h2 class="mt-1 text-2xl font-bold text-ink section-title">Kajian & Berita</h2>
            </div>
            <a href="{{ route('posts.index') }}"
                class="hidden text-sm font-bold text-accent transition hover:underline md:block">Lihat Semua →</a>
        </div>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}"
                    class="group card-hover rounded-2xl bg-white overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)]">
                    @if ($post->thumbnail)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-teal-50 to-teal-100 flex items-center justify-center">
                            <svg class="h-10 w-10 text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-5">
                        @if ($post->category)
                            <span
                                class="inline-block rounded-full bg-teal-50 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-teal-600">{{ $post->category->name }}</span>
                        @endif
                        <h3 class="mt-2 text-base font-bold text-ink leading-snug group-hover:text-accent transition">
                            {{ $post->title }}</h3>
                        <p class="mt-2 text-sm text-ink/60 line-clamp-2">{{ Str::limit(strip_tags($post->content ?? ''), 100) }}
                        </p>
                        <p class="mt-3 text-xs font-medium text-ink/40">{{ optional($post->published_at)->format('d M Y') }}</p>
                    </div>
                </a>
            @empty
                <div
                    class="col-span-full rounded-2xl border-2 border-dashed border-ink/10 p-12 text-center text-sm text-ink/40">
                    Belum ada berita. Tambahkan data melalui panel admin.
                </div>
            @endforelse
        </div>
        <div class="mt-6 text-center md:hidden">
            <a href="{{ route('posts.index') }}" class="text-sm font-bold text-accent">Lihat Semua Berita →</a>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section class="mx-auto w-full max-w-6xl px-6 pb-16">
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Dokumentasi</p>
                <h2 class="mt-1 text-2xl font-bold text-ink section-title">Galeri Masjid</h2>
            </div>
            <a href="{{ route('galleries.index') }}"
                class="hidden text-sm font-bold text-accent transition hover:underline md:block">Lihat Semua →</a>
        </div>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($galleries as $gallery)
                <a href="{{ route('galleries.show', $gallery->id) }}"
                    class="group card-hover rounded-2xl bg-white overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)]">
                    @if ($gallery->cover_image)
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ Storage::url($gallery->cover_image) }}" alt="{{ $gallery->title }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-square bg-gradient-to-br from-teal-50 to-teal-100 flex items-center justify-center">
                            <svg class="h-10 w-10 text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-sm font-bold text-ink group-hover:text-accent transition line-clamp-1">
                            {{ $gallery->title }}</h3>
                        <p class="mt-1 text-xs text-ink/40">{{ $gallery->images_count ?? 0 }} foto</p>
                    </div>
                </a>
            @empty
                <div
                    class="col-span-full rounded-2xl border-2 border-dashed border-ink/10 p-12 text-center text-sm text-ink/40">
                    Belum ada galeri. Tambahkan data melalui panel admin.
                </div>
            @endforelse
        </div>
        <div class="mt-6 text-center md:hidden">
            <a href="{{ route('galleries.index') }}" class="text-sm font-bold text-accent">Lihat Semua Galeri →</a>
        </div>
    </section>

    {{-- Infaq & Donasi Section --}}
    <section id="donasi" class="mx-auto w-full max-w-6xl px-6 pb-8">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-accent">Sedekah Jariyah</p>
            <h2 class="mt-1 text-2xl font-bold text-ink section-title mx-auto">Infaq & Donasi</h2>
            <p class="mt-4 text-sm text-ink/50">Mari berkontribusi dalam kemakmuran Masjid Ar-Rohmah. Setiap infaq dan
                sedekah Anda sangat berarti.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            {{-- Bank Transfer Card --}}
            <div class="rounded-2xl bg-white p-8 shadow-[0_4px_24px_rgba(0,0,0,0.06)] card-hover">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50">
                        <svg class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-ink">Transfer Bank</h3>
                        <p class="text-xs text-ink/50">Bank Jabar Banten Syariah</p>
                    </div>
                </div>
                <div class="rounded-xl bg-gradient-to-br from-teal-50 to-teal-100/50 p-5">
                    <p class="text-xs font-medium text-ink/50 uppercase tracking-widest">Nomor Rekening</p>
                    <div class="mt-2 flex items-center justify-between gap-3">
                        <p class="text-2xl font-extrabold tracking-wider text-ink" id="norek">5300 2018 49173</p>
                        <button onclick="copyNorek()" id="copy-btn"
                            class="rounded-lg bg-accent px-4 py-2 text-xs font-bold text-white transition hover:bg-accent-2 active:scale-95">
                            Salin
                        </button>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-ink/70">a.n. <span class="text-accent">Masjid Ar-Rohmah</span>
                    </p>
                </div>
                <p class="mt-4 text-xs text-ink/40 text-center">Mohon konfirmasi setelah transfer melalui pengurus masjid
                </p>
            </div>

            {{-- QRIS Card --}}
            <div class="rounded-2xl bg-white p-8 shadow-[0_4px_24px_rgba(0,0,0,0.06)] card-hover">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50">
                        <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v1m4-1h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m-4 0V9a2 2 0 012-2h2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-ink">Scan QRIS</h3>
                        <p class="text-xs text-ink/50">Semua aplikasi e-wallet & mobile banking</p>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="rounded-xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.08)] bg-white p-2">
                        <img src="{{ asset('images/qris-donation.jpeg') }}" alt="QRIS Masjid Ar-Rohmah"
                            class="w-64 h-auto rounded-lg">
                    </div>
                </div>
                <p class="mt-4 text-xs text-ink/40 text-center">NMID: ID2024347025965 • Masjid Ar-Rohmah</p>
            </div>
        </div>
    </section>

    {{-- Copy Norek Script --}}
    <script>
            function copyNorek() {
                const norek = '5300201849173';
                navigator.clipboard.writeText(norek).then(() => {
                    const btn = document.getElementById('copy-btn');
                    btn.textContent = '✓ Tersalin!';
                    btn.classList.add('bg-green-600');
                    setTimeout(() => {
                        btn.textContent = 'Salin';
                        btn.classList.remove('bg-green-600');
                    }, 2000);
                });
            }
    </script>

    {{-- Saran & Masukan CTA --}}
    <section class="mx-auto w-full max-w-6xl px-6 pb-8">
        <div
            class="rounded-3xl bg-gradient-to-br from-ink to-ink/90 px-8 py-12 text-white shadow-[0_20px_60px_rgba(15,23,42,0.3)] relative overflow-hidden">
            <div class="absolute inset-0 grid-bg opacity-10"></div>
            <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="max-w-lg">
                    <h3 class="text-xl font-bold">💬 Punya Saran atau Masukan?</h3>
                    <p class="mt-2 text-sm leading-relaxed text-white/60">Sampaikan aspirasi Anda untuk kemajuan Masjid
                        Ar-Rohmah. Kami siap mendengarkan.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('complaints.create') }}"
                        class="inline-flex items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5">Kirim
                        Saran</a>
                    <a href="{{ route('complaints.track') }}"
                        class="inline-flex items-center justify-center rounded-full bg-white/10 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/20 hover:-translate-y-0.5">Lacak
                        Saran</a>
                </div>
            </div>
        </div>
    </section>
@endsection