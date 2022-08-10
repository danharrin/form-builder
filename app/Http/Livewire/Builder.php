<?php

namespace App\Http\Livewire;

use Closure;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Str;
use Livewire\Component;

class Builder extends Component implements HasForms
{
    use InteractsWithForms;

    public $content = [];

    public function mount()
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Builder::make('content')
                ->blocks([
                    Block::make('text')
                        ->label('Text input')
                        ->icon('heroicon-o-annotation')
                        ->schema([
                            $this->getFieldNameInput(),
                            Checkbox::make('is_required'),
                        ]),
                    Block::make('select')
                        ->icon('heroicon-o-selector')
                        ->schema([
                            $this->getFieldNameInput(),
                            KeyValue::make('options')
                                ->addButtonLabel('Add option')
                                ->keyLabel('Value')
                                ->valueLabel('Label'),
                            Checkbox::make('is_required'),
                        ]),
                    Block::make('checkbox')
                        ->icon('heroicon-o-check-circle')
                        ->schema([
                            $this->getFieldNameInput(),
                            Checkbox::make('is_required'),
                        ]),
                    Block::make('file')
                        ->icon('heroicon-o-photograph')
                        ->schema([
                            $this->getFieldNameInput(),
                            Grid::make()
                                ->schema([
                                    Checkbox::make('is_multiple'),
                                    Checkbox::make('is_required'),
                                ]),
                        ]),
                ])
                ->createItemButtonLabel('Add form input')
                ->disableLabel(),
        ];
    }

    protected function getFieldNameInput(): Grid
    {
        // This is not a Filament-specific method, simply saves on repetition
        // between our builder blocks.

        return Grid::make()
            ->schema([
                TextInput::make('name')
                    ->lazy()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $label = Str::of($state)
                            ->kebab()
                            ->replace(['-', '_'], ' ')
                            ->ucfirst();

                        $set('label', $label);
                    })
                    ->required(),
                TextInput::make('label')
                    ->required(),
            ]);
    }

    public function save(): void
    {
        $form = \App\Models\Form::create($this->form->getState());

        redirect()->route('form', ['form' => $form]);
    }

    public function render()
    {
        return view('livewire.builder');
    }
}
