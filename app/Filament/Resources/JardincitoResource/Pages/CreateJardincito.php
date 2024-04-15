<?php

namespace App\Filament\Resources\JardincitoResource\Pages;

use App\Filament\Resources\JardincitoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJardincito extends CreateRecord
{
    protected static string $resource = JardincitoResource::class;
    protected function getRedirectUrl(): string
    {
        
        return $this->getResource()::getUrl('index');
    }
}
