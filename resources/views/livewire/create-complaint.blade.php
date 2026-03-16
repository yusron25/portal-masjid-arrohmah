<div>
    @if (session()->has('ticket_code'))
        {{-- Success Card --}}
        <div class="rounded-2xl border-2 border-emerald-200 bg-emerald-50 p-8 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                <svg class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-ink">Pengaduan Berhasil Dikirim!</h3>
            <p class="mt-2 text-sm text-ink/60">Simpan kode tiket berikut untuk melacak status pengaduan Anda:</p>

            <div
                class="mt-5 inline-flex items-center gap-3 rounded-xl bg-white px-6 py-4 shadow-sm border border-emerald-200">
                <span class="text-2xl font-extrabold tracking-wider text-emerald-700"
                    id="ticket-code">{{ session('ticket_code') }}</span>
                <button
                    onclick="navigator.clipboard.writeText(document.getElementById('ticket-code').textContent).then(()=>{this.textContent='✓ Tersalin';setTimeout(()=>{this.textContent='Salin'},2000)})"
                    class="rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 transition hover:bg-emerald-200">
                    Salin
                </button>
            </div>

            <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                <a href="{{ route('complaints.track') }}"
                    class="rounded-full bg-accent px-6 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5">
                    Lacak Status Pengaduan
                </a>
                <button wire:click="$refresh" onclick="setTimeout(()=>location.reload(),100)"
                    class="rounded-full border-2 border-ink/15 px-6 py-3 text-sm font-bold text-ink transition hover:border-ink/30">
                    Buat Pengaduan Lagi
                </button>
            </div>
        </div>
    @else
        {{-- Complaint Form --}}
        <form wire:submit.prevent="submit" class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Nama</label>
                <input type="text" wire:model="citizen_name"
                    class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm focus:border-ink focus:outline-none" />
                @error('citizen_name') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">NIK</label>
                <input type="text" wire:model="citizen_nik"
                    class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm focus:border-ink focus:outline-none" />
                @error('citizen_nik') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">No. HP</label>
                <input type="text" wire:model="citizen_phone"
                    class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm focus:border-ink focus:outline-none" />
                @error('citizen_phone') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Email</label>
                <input type="email" wire:model="citizen_email"
                    class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm focus:border-ink focus:outline-none"
                    placeholder="contoh@email.com" />
                @error('citizen_email') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>


            <div class="md:col-span-2">
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Lokasi</label>
                <input type="text" wire:model="location"
                    class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm focus:border-ink focus:outline-none" />
                @error('location') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Deskripsi</label>
                <textarea wire:model="description" rows="5"
                    class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm focus:border-ink focus:outline-none"></textarea>
                @error('description') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Bukti Foto (opsional)</label>
                <input type="file" wire:model="evidence_image"
                    class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm" />
                @error('evidence_image') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full rounded-2xl bg-ink px-4 py-3 text-sm font-semibold text-white transition hover:bg-ink/90">
                    Kirim Pengaduan
                </button>
            </div>
        </form>
    @endif
</div>