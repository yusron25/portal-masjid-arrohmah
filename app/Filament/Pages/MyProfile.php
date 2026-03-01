<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MyProfile extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $title = 'Profil Saya';
    protected static ?string $slug = 'my-profile';
    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 20;

    protected string $view = 'filament.pages.my-profile';

    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        Notification::make()
            ->title('Profil berhasil diperbarui!')
            ->success()
            ->send();
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => $this->new_password,
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        Notification::make()
            ->title('Password berhasil diubah!')
            ->success()
            ->send();
    }
}
