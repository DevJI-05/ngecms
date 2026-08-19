<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pengirim')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama')->label('Nama')->required()->disabled(),
                        TextInput::make('jabatan')->label('Jabatan')->disabled(),
                        TextInput::make('email')->label('Email')->required()->disabled(),
                        TextInput::make('telepon')->label('Telepon')->disabled(),
                        TextInput::make('perusahaan')->label('Perusahaan')->disabled(),
                        TextInput::make('sumber')->label('Sumber')->disabled(),
                    ]),

                Section::make('Detail Kebutuhan')
                    ->columns(2)
                    ->components([
                        TextInput::make('layanan')->label('Layanan')->disabled(),
                        TextInput::make('estimasi')->label('Estimasi Nilai')->disabled(),
                        TextInput::make('lokasi')->label('Lokasi Proyek')->disabled(),
                        Textarea::make('pesan')
                            ->label('Pesan')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Select::make('status')
                    ->label('Status Follow-up')
                    ->options([
                        'baru' => 'Baru',
                        'dihubungi' => 'Sudah Dihubungi',
                        'selesai' => 'Selesai',
                    ])
                    ->required(),
            ]);
    }
}
