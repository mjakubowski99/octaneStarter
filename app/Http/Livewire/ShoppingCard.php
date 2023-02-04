<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ShoppingCard extends Component
{
    public string $name;

    public string $description;

    public string $image_url;

    public string $amount;

    public string $currency;

    protected $listeners = ['buyClicked' => 'buyClicked'];

    public function render(): View
    {
        return view('livewire.shopping-card');
    }

    public function buyClicked()
    {
        return redirect()->route('stripe.checkout');
    }
}
