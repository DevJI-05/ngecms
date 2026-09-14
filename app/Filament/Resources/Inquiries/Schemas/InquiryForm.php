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
        $disabledWhenEditing = fn (string $operation): bool => $operation === 'edit';

        return $schema
            ->components([
                Section::make('Sender Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama')->label('Name')->required()->disabled($disabledWhenEditing),
                        TextInput::make('jabatan')->label('Job Title')->disabled($disabledWhenEditing),
                        TextInput::make('email')->label('Email')->email()->required()->disabled($disabledWhenEditing),
                        TextInput::make('telepon')->label('Phone')->disabled($disabledWhenEditing),
                        TextInput::make('perusahaan')->label('Company')->disabled($disabledWhenEditing),
                        TextInput::make('sumber')->label('Source')->disabled($disabledWhenEditing),
                    ]),

                Section::make('Request Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('layanan')->label('Service')->required()->disabled($disabledWhenEditing),
                        TextInput::make('estimasi')->label('Estimated Value')->disabled($disabledWhenEditing),
                        TextInput::make('lokasi')->label('Project Location')->disabled($disabledWhenEditing),
                        Textarea::make('pesan')
                            ->label('Message')
                            ->required()
                            ->disabled($disabledWhenEditing)
                            ->columnSpanFull(),
                    ]),

                Select::make('status')
                    ->label('Follow-up Status')
                    ->options([
                        'baru' => 'New',
                        'dihubungi' => 'Contacted',
                        'selesai' => 'Completed',
                    ])
                    ->default('baru')
                    ->native(false)
                    ->required(),
            ]);
    }
}
