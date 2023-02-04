<div class="card w-96 bg-base-100/25 shadow-xl m-4">
    <figure><img src="{{$image_url}}" alt="Shoes" /></figure>
    <div class="card-body">
        <h2 class="card-title">{{$name}}</h2>
        <h2 class="card-title">Price: {{$amount}} {{$currency}}</h2>
        <p>{{$description}}</p>
        <div class="card-actions justify-end">
            <button wire:click="$emit('buyClicked')" class="btn btn-primary">Buy Now</button>
        </div>
    </div>
</div>
