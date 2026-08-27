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
                Section::make('Sender Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama')->label('Name')->required()->disabled(),
                        TextInput::make('jabatan')->label('Job Title')->disabled(),
                        TextInput::make('email')->label('Email')->required()->disabled(),
                        TextInput::make('telepon')->label('Phone')->disabled(),
                        TextInput::make('perusahaan')->label('Company')->disabled(),
                        TextInput::make('sumber')->label('Source')->disabled(),
                    ]),

                Section::make('Request Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('layanan')->label('Service')->disabled(),
                        TextInput::make('estimasi')->label('Estimated Value')->disabled(),
                        TextInput::make('lokasi')->label('Project Location')->disabled(),
                        Textarea::make('pesan')
                            ->label('Message')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Select::make('status')
                    ->label('Follow-up Status')
                    ->options([
                        'baru' => 'New',
                        'dihubungi' => 'Contacted',
                        'selesai' => 'Completed',
                    ])
                    ->native(false)
                    ->required(),
            ]);
    }
}
