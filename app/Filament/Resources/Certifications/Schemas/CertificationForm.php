<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nama Sertifikat')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('issuer')
                    ->label('Penerbit')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('valid_text')
                    ->label('Keterangan Masa Berlaku')
                    ->helperText('Contoh: Berlaku s/d 2027')
                    ->required(),
                TextInput::make('icon')
                    ->label('Tabler Icon')
                    ->helperText('Contoh: ti-certificate, ti-shield-check')
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
                ColorPicker::make('icon_bg')->label('Warna Latar Ikon')->required(),
                ColorPicker::make('icon_color')->label('Warna Ikon')->required(),
            ]);
    }
}
