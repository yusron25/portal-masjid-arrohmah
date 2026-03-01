<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Complaint;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateComplaint extends Component
{
    use WithFileUploads;

    public string $citizen_name = '';
    public string $citizen_nik = '';
    public string $citizen_phone = '';
    public string $citizen_email = '';
    public ?int $category_id = null;
    public string $description = '';
    public string $location = '';
    public $evidence_image;

    protected function rules(): array
    {
        return [
            'citizen_name' => ['required', 'string', 'max:255'],
            'citizen_nik' => ['required', 'string', 'max:32'],
            'citizen_phone' => ['required', 'string', 'max:32'],
            'citizen_email' => ['required', 'email', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['required', 'string', 'max:2000'],
            'location' => ['nullable', 'string', 'max:255'],
            'evidence_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function submit(): void
    {
        $data = $this->validate();

        if ($this->evidence_image) {
            $data['evidence_image'] = $this->evidence_image->store('complaints', 'public');
        }

        $data['status'] = 'pending';

        $complaint = Complaint::create($data);

        session()->flash('ticket_code', $complaint->ticket_code);

        $this->reset(['citizen_name', 'citizen_nik', 'citizen_phone', 'citizen_email', 'category_id', 'description', 'location', 'evidence_image']);
    }

    public function render()
    {
        return view('livewire.create-complaint', [
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }
}