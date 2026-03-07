<?php

namespace App\Filament\Resources\KajianScheduleResource\Pages;

use App\Filament\Resources\KajianScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKajianSchedule extends EditRecord
{
    protected static string $resource = KajianScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->label('Hapus'),
        ];
    }
}
