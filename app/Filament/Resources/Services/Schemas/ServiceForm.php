<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Support\ServiceIconOptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Nama Layanan')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('tagline')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('cat')
                            ->label('Kategori')
                            ->options([
                                'pipeline' => 'Gas Pipeline',
                                'cng' => 'CNG',
                                'maintenance' => 'Maintenance',
                                'engineering' => 'Engineering',
                                'safety' => 'Safety & HSE',
                            ])
                            ->required(),
                        Select::make('icon')
                            ->label('Icon')
                            ->options(ServiceIconOptions::options())
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->required(),
                        Placeholder::make('icon_preview')
                            ->label('Pratinjau Icon')
                            ->content(fn (Get $get): HtmlString => new HtmlString(
                                '<i class="ti '.e($get('icon')).'" style="font-size: 22px;"></i>',
                            )),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('foot_note')
                            ->label('Catatan Kaki')
                            ->helperText('Contoh: Estimasi proyek: 3 — 18 bulan')
                            ->required(),
                        Textarea::make('prompt')
                            ->label('Pesan Inquiry WhatsApp')
                            ->required(),
                    ]),

                Section::make('Tampilan')
                    ->columns(3)
                    ->components([
                        ColorPicker::make('icon_bg')->label('Warna Latar Ikon')->required(),
                        ColorPicker::make('icon_color')->label('Warna Ikon')->required(),
                        ColorPicker::make('accent')->label('Warna Aksen')->required(),
                        ColorPicker::make('badge_bg')->label('Warna Latar Badge')->required(),
                        ColorPicker::make('badge_color')->label('Warna Teks Badge')->required(),
                    ]),

                Repeater::make('badges')
                    ->label('Badge')
                    ->simple(TextInput::make('badge')->required())
                    ->default([])
                    ->addActionLabel('Tambah badge'),

                Repeater::make('sections')
                    ->label('Bagian Lingkup Pekerjaan / Spesifikasi')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Bagian')
                            ->required(),
                        Repeater::make('items')
                            ->label('Poin-poin')
                            ->simple(TextInput::make('item')->required())
                            ->default([])
                            ->addActionLabel('Tambah poin'),
                    ])
                    ->default([])
                    ->addActionLabel('Tambah bagian')
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
