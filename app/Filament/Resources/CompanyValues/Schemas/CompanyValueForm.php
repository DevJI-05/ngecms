<?php

namespace App\Filament\Resources\CompanyValues\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompanyValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('icon')
                    ->label('Ikon (emoji)')
                    ->helperText('Contoh: 🛡️, ⚙️, 🤝')
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Nilai')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required(),
                ColorPicker::make('accent')
                    ->label('Warna Aksen')
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
