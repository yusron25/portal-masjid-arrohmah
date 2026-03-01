<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Informasi Profil --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="padding:16px 24px; border-bottom:1px solid #f3f4f6; font-weight:600; font-size:15px; color:#111827;">
                Informasi Profil
            </div>
            <form wire:submit="updateProfile" style="padding:24px;">
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:500; color:#374151;">Nama Lengkap</label>
                    <input type="text" wire:model="name" placeholder="Nama lengkap"
                        style="display:block; width:100%; padding:8px 12px; font-size:14px; border:1px solid #d1d5db; border-radius:8px; outline:none; color:#111827; background:#fff;" />
                    @error('name') <p style="margin-top:4px; font-size:12px; color:#dc2626;">{{ $message }}</p> @enderror
                </div>
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:500; color:#374151;">Alamat Email</label>
                    <input type="email" wire:model="email" placeholder="email@contoh.com"
                        style="display:block; width:100%; padding:8px 12px; font-size:14px; border:1px solid #d1d5db; border-radius:8px; outline:none; color:#111827; background:#fff;" />
                    @error('email') <p style="margin-top:4px; font-size:12px; color:#dc2626;">{{ $message }}</p> @enderror
                </div>
                <div style="text-align:right;">
                    <button type="submit"
                        style="display:inline-block; padding:8px 20px; font-size:13px; font-weight:600; color:#fff; background:#059669; border:none; border-radius:8px; cursor:pointer;">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- Ganti Password --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="padding:16px 24px; border-bottom:1px solid #f3f4f6; font-weight:600; font-size:15px; color:#111827;">
                Ganti Password
            </div>
            <form wire:submit="updatePassword" style="padding:24px;">
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:500; color:#374151;">Password Lama</label>
                    <input type="password" wire:model="current_password" placeholder="••••••••"
                        style="display:block; width:100%; padding:8px 12px; font-size:14px; border:1px solid #d1d5db; border-radius:8px; outline:none; color:#111827; background:#fff;" />
                    @error('current_password') <p style="margin-top:4px; font-size:12px; color:#dc2626;">{{ $message }}</p> @enderror
                </div>
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:500; color:#374151;">Password Baru <span style="color:#9ca3af; font-weight:400;">(min. 8 karakter)</span></label>
                    <input type="password" wire:model="new_password" placeholder="••••••••"
                        style="display:block; width:100%; padding:8px 12px; font-size:14px; border:1px solid #d1d5db; border-radius:8px; outline:none; color:#111827; background:#fff;" />
                    @error('new_password') <p style="margin-top:4px; font-size:12px; color:#dc2626;">{{ $message }}</p> @enderror
                </div>
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:500; color:#374151;">Konfirmasi Password Baru</label>
                    <input type="password" wire:model="new_password_confirmation" placeholder="••••••••"
                        style="display:block; width:100%; padding:8px 12px; font-size:14px; border:1px solid #d1d5db; border-radius:8px; outline:none; color:#111827; background:#fff;" />
                </div>
                <div style="text-align:right;">
                    <button type="submit"
                        style="display:inline-block; padding:8px 20px; font-size:13px; font-weight:600; color:#fff; background:#059669; border:none; border-radius:8px; cursor:pointer;">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-filament-panels::page>