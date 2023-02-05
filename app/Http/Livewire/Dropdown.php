<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dropdown extends Component
{
    public string $content;

    public array $items;

    public function render(): View
    {
        return view('livewire.dropdown');
    }

    public function mount()
    {
        $this->items = DB::table('user_products')
            ->where('user_id', auth('web')->user()->getAuthIdentifier())
            ->join('product_details', 'product_details.product_id', '=', 'user_products.product_id')
            ->select('product_details.name')
            ->get()
            ->pluck('name')
            ->toArray();
    }
}
