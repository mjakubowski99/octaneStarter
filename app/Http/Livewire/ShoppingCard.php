<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;

class ShoppingCard extends Component
{
    public string $uuid;

    public string $name;

    public string $description;

    public string $image_url;

    public int $amount;

    public string $currency;

    protected $listeners = ['buyClicked' => 'buyClicked'];

    public function render(): View
    {
        return view('livewire.shopping-card');
    }

    public function buyClicked()
    {
        $token = auth('web')->user()->createToken(Carbon::now()->toDateTimeString());

        return redirect()
            ->to(route('stripe.checkout').'?'.Arr::query([
                'id' => $this->uuid,
                'token' => $token->plainTextToken
            ]));
    }
}
