<?php

namespace App\Livewire;

use App\Models\PaymentMethod;
use App\Models\Product;
use Livewire\Component;

//ke7 use di bawah ini, harus digunakan agar bisa livewire konek dengan form filament
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Set;

class Pos extends Component implements HasForms
{

    use InteractsWithForms;

    public $search = '';
    public $name_customer = '';
    public $gender = '';
    public $payment_method_id = 0;
    public $payment_methods;
    public $order_items = [];
    public $total_price;

    public function render()
    {
        return view('livewire.pos', [
            'products' => Product::where('stock', '>', 0)
                            ->search($this->search)
                            ->paginate(12)
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
                ->schema([
                    Forms\Components\Section::make('Form Checkout')
                        ->schema([
                            Forms\Components\TextInput::make('name_customer')
                                ->required()
                                ->maxLength(255)
                                ->default(fn () => $this->name_customer),
                            Forms\Components\Select::make('gender')
                                ->options([
                                    'male' => 'Male',
                                    'female' => 'Female'
                                ])
                                ->required(),
                            Forms\Components\TextInput::make('total_price')
                                ->readOnly()
                                ->numeric()
                                ->default(fn () => $this->total_price),
                            Forms\Components\Select::make('payment_method_id') 
                                ->required()
                                ->label('Payment Method')
                                ->options($this->payment_methods->pluck('name', 'id'))
                        ])
                ]);
    }

    public function mount()
    {
        if (session()->has('orderItems')) {
            $this->order_items = session('orderItems');
        }
        
        $this->payment_methods = PaymentMethod::all();

        //data dari hasil query, di fill ke form nya
        $this->form->fill(['payment_methods', $this->payment_methods]);
    }

}
