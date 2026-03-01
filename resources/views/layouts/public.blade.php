<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Website resmi Masjid Ar-Rohmah. Portal informasi masjid, jadwal solat, kajian, kegiatan, dan galeri.">
    <title>{{ config('app.name', 'Masjid Ar-Rohmah') }} — Portal Masjid</title>
    <link rel="icon" href="{{ asset('images/logo-arrohmah.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen">
    <header class="fixed inset-x-0 top-0 z-40">
        <nav
            class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-3 backdrop-blur-md bg-white/80 shadow-[0_4px_30px_rgba(0,0,0,0.06)] rounded-b-2xl">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-arrohmah.png') }}" alt="Logo Masjid Ar-Rohmah" class="h-10 w-auto">
                <div class="leading-tight">
                    <span class="block text-base font-bold tracking-tight text-ink">Masjid Ar-Rohmah</span>
                    <span class="block text-[10px] font-medium uppercase tracking-widest text-ink/50">Tambun Selatan,
                        Bekasi</span>
                </div>
            </a>
            <div class="hidden items-center gap-5 text-sm font-semibold text-ink/70 md:flex">
                <a href="{{ route('home') }}" class="transition hover:text-accent">Beranda</a>
                <a href="{{ route('posts.index') }}" class="transition hover:text-accent">Kajian & Berita</a>
                <a href="{{ route('galleries.index') }}" class="transition hover:text-accent">Galeri</a>
                <a href="#jadwal-solat" class="transition hover:text-accent">Jadwal Solat</a>
                <a href="{{ route('complaints.create') }}" class="transition hover:text-accent">Saran</a>
                <a href="/admin" class="rounded-full bg-ink px-4 py-2 text-white transition hover:bg-ink/90">Admin</a>
            </div>
            {{-- Mobile hamburger --}}
            <button id="mobile-menu-btn" class="md:hidden rounded-lg p-2 text-ink hover:bg-ink/5"
                onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </nav>
        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden mx-6 mt-2 rounded-2xl bg-white p-4 shadow-lg">
            <div class="flex flex-col gap-3 text-sm font-semibold text-ink/70">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 hover:bg-ink/5">Beranda</a>
                <a href="{{ route('posts.index') }}" class="rounded-lg px-3 py-2 hover:bg-ink/5">Kajian & Berita</a>
                <a href="{{ route('galleries.index') }}" class="rounded-lg px-3 py-2 hover:bg-ink/5">Galeri</a>
                <a href="#jadwal-solat" class="rounded-lg px-3 py-2 hover:bg-ink/5">Jadwal Solat</a>
                <a href="{{ route('complaints.create') }}" class="rounded-lg px-3 py-2 hover:bg-ink/5">Saran &
                    Masukan</a>
            </div>
        </div>
    </header>

    <main class="pt-24">
        @yield('content')
    </main>

    <footer class="mt-24 bg-ink text-white">
        <div class="mx-auto w-full max-w-6xl px-6 py-14">
            <div class="flex flex-col gap-10 md:flex-row md:justify-between">
                <div class="max-w-sm">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-arrohmah.png') }}" alt="Logo" class="h-12 w-auto">
                        <div>
                            <p class="text-lg font-bold">Masjid Ar-Rohmah</p>
                            <p class="text-xs text-white/50 uppercase tracking-widest">Tambun Selatan, Bekasi</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-white/60">Portal resmi Masjid Ar-Rohmah, Perum Tridaya
                        Indah 1, Tambun Selatan. Pusat informasi
                        jadwal solat, kajian rutin, kegiatan masjid, dan galeri dokumentasi kegiatan umat.
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-white/40">Navigasi</h4>
                    <ul class="mt-3 space-y-2 text-sm text-white/60">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('posts.index') }}" class="hover:text-white transition">Kajian & Berita</a>
                        </li>
                        <li><a href="{{ route('galleries.index') }}" class="hover:text-white transition">Galeri</a></li>
                        <li><a href="#jadwal-solat" class="hover:text-white transition">Jadwal Solat</a></li>
                        <li><a href="{{ route('complaints.create') }}" class="hover:text-white transition">Saran &
                                Masukan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-white/40">Kontak</h4>
                    <ul class="mt-3 space-y-2 text-sm text-white/60">
                        <li>Perum Tridaya Indah 1</li>
                        <li>Tambun Selatan, Kab. Bekasi</li>
                        <li>Jawa Barat</li>
                        <li>Buka 24 Jam (Solat 5 Waktu)</li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 border-t border-white/10 pt-6 text-center text-xs text-white/40">
                &copy; {{ date('Y') }} Masjid Ar-Rohmah. Semua hak dilindungi.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>