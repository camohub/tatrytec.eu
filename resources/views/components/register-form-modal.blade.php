<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{route('register')}}" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Registrácia</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    @if($showModal == 'registerModal')@include('components.form-errors', ['withoutCloseBtn' => TRUE])@endif
                </div>
                <div class="form-group">
                    <label for="name">Meno *</label>
                    <input name="name" value="{{old('name')}}" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Eamil *</label>
                    <input name="email" value="{{old('email')}}" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Heslo *</label>
                    <input name="password" type="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Zopakovať heslo *</label>
                    <input name="password_confirmation" type="password" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Zaregistrovať">
            </div>
        </form>
    </div>
</div>