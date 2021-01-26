
@if(isset($flashes) && count($flashes))
    <div class="flash">
        @foreach($flashes as $flash)
            <div class="alert alert-dismissible fade in @if($flash->type == 'error') alert-danger @else alert-success @endif">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{$flash->message}}
            </div>
        @endforeach
    </div>
@endif