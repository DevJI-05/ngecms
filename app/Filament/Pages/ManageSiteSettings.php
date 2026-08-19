<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManageSiteSettings extends Page
{
    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Profil Perusahaan')
                    ->columns(2)
                    ->components([
                        TextInput::make('company_name')->label('Nama Perusahaan')->required(),
                        TextInput::make('tagline')->label('Tagline')->required(),
                        TextInput::make('established_year')->label('Tahun Berdiri')->numeric()->required(),
                    ]),

                Section::make('Kontak & Alamat')
                    ->columns(2)
                    ->components([
                        TextInput::make('address')->label('Alamat')->required()->columnSpanFull(),
                        TextInput::make('phone')->label('Telepon')->required(),
                        TextInput::make('fax')->label('Fax'),
                        TextInput::make('email_info')->label('Email Info')->email()->required(),
                        TextInput::make('email_project')->label('Email Project')->email(),
                        TextInput::make('whatsapp_number')->label('Nomor WhatsApp (format 62xxx)')->required(),
                        TextInput::make('emergency_phone')->label('Telepon Emergency 24/7')->required(),
                        TextInput::make('map_query')->label('Query Google Maps')->columnSpanFull(),
                    ]),

                Section::make('Jam Operasional')
                    ->columns(3)
                    ->components([
                        TextInput::make('hours_weekday')->label('Senin – Jumat')->required(),
                        TextInput::make('hours_saturday')->label('Sabtu')->required(),
                        TextInput::make('hours_sunday')->label('Minggu & Libur')->required(),
                    ]),

                Section::make('Person in Charge')
                    ->columns(3)
                    ->components([
                        TextInput::make('pic1_name')->label('Nama PIC 1')->required(),
                        TextInput::make('pic1_role')->label('Jabatan PIC 1')->required(),
                        TextInput::make('pic1_phone')->label('Telepon PIC 1')->required(),
                        TextInput::make('pic2_name')->label('Nama PIC 2')->required(),
                        TextInput::make('pic2_role')->label('Jabatan PIC 2')->required(),
                        TextInput::make('pic2_phone')->label('Telepon PIC 2')->required(),
                    ]),

                Section::make('Statistik Hero & About')
                    ->columns(3)
                    ->components([
                        TextInput::make('stat_projects_completed')->label('Proyek Selesai')->required(),
                        TextInput::make('stat_pipeline_km')->label('Pipeline Terpasang')->required(),
                        TextInput::make('stat_years_experience')->label('Tahun Pengalaman')->required(),
                        TextInput::make('stat_provinces')->label('Jumlah Provinsi')->required(),
                        TextInput::make('stat_employees')->label('Jumlah Karyawan')->required(),
                        TextInput::make('stat_active_clients')->label('Klien Aktif')->required(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('Pengaturan situs disimpan')
            ->success()
            ->send();
    }
}
