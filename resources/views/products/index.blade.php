@extends('layouts.base')

@livewire('navbar')

<div id="body">
    <div class="grid grid-cols-4 gap-4">
        @foreach($products as $product)
            @livewire('shopping-card', $product->toArray())
        @endforeach
    </div>
</div>

