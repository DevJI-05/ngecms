<?php

namespace App\Filament\Resources\PortfolioProjects\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PortfolioProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Proyek')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Nama Proyek')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('cat')
                            ->label('Kategori')
                            ->options([
                                'pipeline' => 'Gas Pipeline',
                                'cng' => 'CNG',
                                'maintenance' => 'Maintenance',
                                'engineering' => 'Engineering',
                            ])
                            ->required(),
                        Select::make('status')
                            ->options([
                                'done' => 'Selesai',
                                'ongoing' => 'Berlangsung',
                            ])
                            ->required(),
                        TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->required(),
                        TextInput::make('scale')
                            ->label('Skala (1-5)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->default(1)
                            ->required(),
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->required(),
                        TextInput::make('client')
                            ->label('Klien')
                            ->required(),
                        TextInput::make('icon')
                            ->label('Tabler Icon')
                            ->helperText('Contoh: ti-line-dashed, ti-gas-station, ti-truck')
                            ->required(),
                    ]),

                Section::make('Tampilan')
                    ->columns(3)
                    ->components([
                        ColorPicker::make('color')->label('Warna Utama')->required(),
                        ColorPicker::make('bg_light')->label('Warna Latar')->required(),
                        ColorPicker::make('accent_text')->label('Warna Aksen Teks')->required(),
                    ]),

                Section::make('Spesifikasi & Statistik')
                    ->columns(3)
                    ->components([
                        Repeater::make('specs')
                            ->label('Spesifikasi Singkat (badge di kartu)')
                            ->simple(TextInput::make('spec')->required())
                            ->default([])
                            ->addActionLabel('Tambah spesifikasi'),
                        Repeater::make('stats')
                            ->label('Nilai Statistik Detail')
                            ->helperText('Urutan harus sejajar dengan Label Statistik')
                            ->simple(TextInput::make('value')->required())
                            ->default([])
                            ->addActionLabel('Tambah nilai'),
                        Repeater::make('stat_labels')
                            ->label('Label Statistik Detail')
                            ->simple(TextInput::make('label')->required())
                            ->default([])
                            ->addActionLabel('Tambah label'),
                    ]),

                Section::make('Lingkup Pekerjaan & Keunggulan')
                    ->columns(2)
                    ->components([
                        Repeater::make('scope')
                            ->label('Lingkup Pekerjaan')
                            ->simple(TextInput::make('item')->required())
                            ->default([])
                            ->addActionLabel('Tambah item'),
                        Repeater::make('highlights')
                            ->label('Keunggulan Proyek')
                            ->simple(TextInput::make('item')->required())
                            ->default([])
                            ->addActionLabel('Tambah item'),
                    ]),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
