<div class="dropdown">
    <label tabindex="0" class="btn m-1">{{$content}}</label>
    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
        @foreach($items as $item)
            <li><a>{{$item}}</a></li>
        @endforeach
    </ul>
</div>
