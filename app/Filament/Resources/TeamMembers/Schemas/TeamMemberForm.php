<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('role')
                    ->label('Jabatan')
                    ->required(),
                Select::make('level')
                    ->label('Level')
                    ->options([
                        'komisaris' => 'Komisaris',
                        'direksi' => 'Direksi Utama',
                        'manajer' => 'Direktur / Manajer',
                        'staff' => 'Kepala Departemen / Staff',
                    ])
                    ->required(),
                Select::make('parent_id')
                    ->label('Atasan Langsung')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('initials')
                    ->label('Inisial Avatar')
                    ->maxLength(3)
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
                ColorPicker::make('avatar_bg')->label('Warna Latar Avatar')->required(),
                ColorPicker::make('avatar_color')->label('Warna Teks Avatar')->required(),
            ]);
    }
}
