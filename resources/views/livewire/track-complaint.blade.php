<div>
    <form wire:submit.prevent="lookup" class="flex flex-col gap-4">
        <div>
            <label class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Ticket Code</label>
            <input type="text" wire:model="ticket_code" class="mt-2 w-full rounded-2xl border border-ink/10 px-4 py-3 text-sm focus:border-ink focus:outline-none" placeholder="TRX-2024-XXXXXX" />
            @error('ticket_code') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="rounded-2xl bg-ink px-4 py-3 text-sm font-semibold text-white">Cek Status</button>
    </form>

    @if ($complaint)
        <div class="mt-6 rounded-2xl border border-ink/10 bg-ink/5 p-4">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Status</p>
            <p class="mt-2 text-lg font-semibold text-ink">{{ ucfirst(str_replace('_', ' ', $complaint->status->value)) }}</p>
            @if ($complaint->admin_response)
                <p class="mt-3 text-sm text-ink/70">{{ $complaint->admin_response }}</p>
            @endif
        </div>
    @endif
</div>