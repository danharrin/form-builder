<?php

namespace App\Http\Livewire;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Form extends Component implements HasForms
{
    use InteractsWithForms;

    public \App\Models\Form $formModel;

    public $data = [];

    public function mount(\App\Models\Form $form)
    {
        $this->formModel = $form;

        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return array_map(function (array $field) {
            $config = $field['data'];

            return match ($field['type']) {
                'text' => TextInput::make($config['name'])
                    ->label($config['label'])
                    ->required($config['is_required']),
                'select' => Select::make($config['name'])
                    ->label($config['label'])
                    ->options($config['options'])
                    ->required($config['is_required']),
                'checkbox' => Checkbox::make($config['name'])
                    ->label($config['label'])
                    ->required($config['is_required']),
                'file' => FileUpload::make($config['name'])
                    ->label($config['label'])
                    ->multiple($config['is_multiple'])
                    ->required($config['is_required']),
            };
        }, $this->formModel->content);
    }

    protected function getFormStatePath(): ?string
    {
        // All of the form data needs to be saved in the `data` property,
        // as the form is dynamic and we can't add a public property for
        // every field.
        return 'data';
    }

    public function submit(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.form');
    }
}
