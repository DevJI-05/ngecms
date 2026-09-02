<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class IconPicker extends Field
{
    protected string $view = 'filament.forms.components.icon-picker';

    /**
     * @var array<string, string>
     */
    protected array $options = [];

    /**
     * @param  array<string, string>  $options  icon class (e.g. "ti-heart") => label
     */
    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
