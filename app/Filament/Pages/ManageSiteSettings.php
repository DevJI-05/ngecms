<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Support\StrictEmail;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManageSiteSettings extends Page
{
    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

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
                Form::make([
                    Tabs::make('Settings')
                        ->contained(false)
                        ->tabs([
                            Tab::make('Company Profile')
                                ->icon(Heroicon::OutlinedBuildingOffice)
                                ->columns(2)
                                ->components([
                                    TextInput::make('company_name')->label('Company Name')->required(),
                                    TextInput::make('tagline')->label('Tagline')->required(),
                                    TextInput::make('established_year')->label('Year Established')->integer()->minValue(1900)->maxValue(fn (): int => (int) now()->year)->required(),
                                ]),

                            Tab::make('Contact & Address')
                                ->icon(Heroicon::OutlinedMapPin)
                                ->columns(2)
                                ->components([
                                    TextInput::make('address')->label('Address')->required()->columnSpanFull(),
                                    TextInput::make('phone')->label('Phone')->tel()->minLength(8)->maxLength(20)->mask(RawJs::make('$input.replace(/[^0-9+\-\s]/g, "")'))->required(),
                                    TextInput::make('fax')->label('Fax')->tel()->minLength(8)->maxLength(20)->mask(RawJs::make('$input.replace(/[^0-9+\-\s]/g, "")')),
                                    TextInput::make('email_info')->label('Info Email')->email()->regex(StrictEmail::REGEX)->required(),
                                    TextInput::make('email_project')->label('Project Email')->email()->regex(StrictEmail::REGEX),
                                    TextInput::make('whatsapp_number')
                                        ->label('WhatsApp Number (format 62xxx)')
                                        ->helperText('Diawali 62, tanpa tanda + atau 0 di depan. Contoh: 6281234567890')
                                        ->regex('/^62[0-9]{8,13}$/')
                                        ->maxLength(15)
                                        ->mask(RawJs::make('$input.replace(/[^0-9]/g, "")'))
                                        ->required(),
                                    TextInput::make('emergency_phone')->label('24/7 Emergency Phone')->tel()->minLength(8)->maxLength(20)->mask(RawJs::make('$input.replace(/[^0-9+\-\s]/g, "")'))->required(),
                                    TextInput::make('map_query')->label('Google Maps Query')->columnSpanFull(),
                                ]),

                            Tab::make('Business Hours')
                                ->icon(Heroicon::OutlinedClock)
                                ->columns(3)
                                ->components([
                                    TextInput::make('hours_weekday')->label('Monday – Friday')->required(),
                                    TextInput::make('hours_saturday')->label('Saturday')->required(),
                                    TextInput::make('hours_sunday')->label('Sunday & Holidays')->required(),
                                ]),

                            Tab::make('Persons in Charge')
                                ->icon(Heroicon::OutlinedUsers)
                                ->columns(3)
                                ->components([
                                    TextInput::make('pic1_name')->label('PIC 1 Name')->required(),
                                    TextInput::make('pic1_role')->label('PIC 1 Role')->required(),
                                    TextInput::make('pic1_phone')->label('PIC 1 Phone')->tel()->minLength(8)->maxLength(20)->mask(RawJs::make('$input.replace(/[^0-9+\-\s]/g, "")'))->required(),
                                    TextInput::make('pic2_name')->label('PIC 2 Name')->required(),
                                    TextInput::make('pic2_role')->label('PIC 2 Role')->required(),
                                    TextInput::make('pic2_phone')->label('PIC 2 Phone')->tel()->minLength(8)->maxLength(20)->mask(RawJs::make('$input.replace(/[^0-9+\-\s]/g, "")'))->required(),
                                ]),

                            Tab::make('Hero & About Stats')
                                ->icon(Heroicon::OutlinedChartBar)
                                ->columns(3)
                                ->components([
                                    TextInput::make('stat_projects_completed')->label('Completed Projects')->helperText('Angka saja, tanpa tanda "+" - ditambahkan otomatis di halaman publik.')->integer()->minValue(0)->required(),
                                    TextInput::make('stat_pipeline_km')->label('Pipeline Installed (km)')->helperText('Angka saja, tanpa satuan "km" - ditambahkan otomatis di halaman publik.')->integer()->minValue(0)->required(),
                                    TextInput::make('stat_years_experience')->label('Years of Experience')->helperText('Angka saja, tanpa tanda "+" - ditambahkan otomatis di halaman publik.')->integer()->minValue(0)->required(),
                                    TextInput::make('stat_provinces')->label('Provinces Covered')->integer()->minValue(0)->required(),
                                    TextInput::make('stat_employees')->label('Employees')->helperText('Angka saja, tanpa tanda "+" - ditambahkan otomatis di halaman publik.')->integer()->minValue(0)->required(),
                                    TextInput::make('stat_active_clients')->label('Active Clients')->integer()->minValue(0)->required(),
                                ]),
                        ]),
                ])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save Settings')
                                ->icon(Heroicon::OutlinedCheck)
                                ->submit('save'),
                        ])
                            ->alignment(Alignment::End)
                            ->sticky(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('Site settings saved')
            ->success()
            ->send();
    }
}
