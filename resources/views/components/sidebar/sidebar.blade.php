<script>
	/* This var is used by main.js which opens/closes categories.
	It is current category id. You can set it in presenter via $this[name]->setCategory( $id ).*/
	var category_id = {{$current_id ?? 'null'}};
</script>

@php
    use App\Models\Entities\Category;
    $categories = Category::whereNull('parent_id')->orderBy('sort', 'ASC')->visible()->with('children')->get();
@endphp

<div class="translateInit-2 translate-2 col-xs-12 col-sm-4 col-md-3 col-lg-3 col-lg-offset-1 sidebar" id="sideMenu">

	@include('components.sidebar.sidebar-section', ['categories' => $categories])

	<ul>
		@auth
			<li class="hr pH0"><a href="{{route('logout')}}" rel="nofollow">Odhlásiť</a></li>
			@if(Auth::user()->hasRole(['admin', 'redactor']))
				<li><a href="{{route('admin.index')}}" rel="nofollow">Administrácia</a></li>
			@endif
			<li>
				<a href="{{route('user.detail')}}" rel="nofollow" class="small1 c1">Prihlásený: {{Auth::user()->name}}</a>
			</li>
		@endauth
		@guest
			<li class="hr pH0"><a data-toggle="modal" data-target="#loginModal" rel="nofollow" class="pointer">Prihlásiť</a></li>
			<li><a data-toggle="modal" data-target="#registerModal" rel="nofollow" class="pointer">Registrovať</a></li>
		@endguest
	</ul>

	<div class="hr"> </div>

</div>