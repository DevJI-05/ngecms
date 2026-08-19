<?php

namespace App\Filament\Resources\Milestones\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MilestoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('year_label')
                    ->label('Label Tahun')
                    ->helperText('Contoh: 2008 — Pendirian')
                    ->required(),
                TextInput::make('year')
                    ->label('Tahun (untuk urutan)')
                    ->numeric()
                    ->required(),
                TextInput::make('name')
                    ->label('Judul')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('badge')
                    ->label('Label Badge')
                    ->helperText('Contoh: Milestone, Sertifikasi, CNG, Penghargaan')
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
                ColorPicker::make('dot_color')->label('Warna Titik Timeline')->required(),
                ColorPicker::make('badge_bg')->label('Warna Latar Badge')->required(),
                ColorPicker::make('badge_color')->label('Warna Teks Badge')->required(),
            ]);
    }
}
