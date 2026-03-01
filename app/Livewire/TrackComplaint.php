<?php

namespace App\Livewire;

use App\Models\Complaint;
use Livewire\Component;

class TrackComplaint extends Component
{
    public string $ticket_code = '';
    public ?Complaint $complaint = null;

    protected function rules(): array
    {
        return [
            'ticket_code' => ['required', 'string', 'max:64'],
        ];
    }

    public function lookup(): void
    {
        $this->validate();

        $code = strtoupper(trim($this->ticket_code));

        $this->complaint = Complaint::query()
            ->where('ticket_code', $code)
            ->first();

        if (! $this->complaint) {
            $this->addError('ticket_code', 'Ticket code not found.');
        }
    }

    public function render()
    {
        return view('livewire.track-complaint');
    }
}