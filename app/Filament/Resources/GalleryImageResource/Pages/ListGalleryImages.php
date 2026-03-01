<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use Filament\Resources\Pages\ListRecords;

class ListGalleryImages extends ListRecords
{
    protected static string $resource = GalleryImageResource::class;
}