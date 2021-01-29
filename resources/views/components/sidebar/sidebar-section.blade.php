<ul>
    @foreach($categories as $item)
        <li id="{{$item->id}}">
            <a href="{{route('articles', ['slug' => $item->slug])}}">
                @if($item->children->count())<i class="sidebar-opener fa fa-plus"></i>@endif
                {{$item->name}}
            </a>

            @if($item->children->count())
                @include('components.sidebar.sidebar-section', ['categories' => $item->children])
            @endif
        </li>
    @endforeach
</ul>