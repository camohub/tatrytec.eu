<ul @if(!isset($nested))class="sortable"@endif>
	@foreach($categories as $item)
		<li id="{{$item->id}}" data-module="{!! $item->module->id ?? 0 !!}" id="menuItem_{{$item->id}}">
			<div>
				{{$item->name}}
				@if( $item->slug != 'najnovsie' )
					<a href="{{route('admin.categories.delete', ['id' => $item->id])}}"
						class="ignore ajax fa fa-lg fa-trash-o d-none" title="Delete"> </a>
					<a onclick="activateEditForm({{$item->id}}, {{$item->name}}, this);"
						class="ignore fa fa-lg fa-pencil" title="Edit"> </a>
				@endif
				<a href="{{route('admin.categories.visibility')}} {{$item->id}}"
					class="ignore ajax fa fa-lg {{$item->visible ? 'fa-check-circle' : 'fa-minus-circle'}}"
					title="Visible/Hidden"> </a>
			</div>

			@if($item->children->count())
				@include('admin.categories.components.sortable-categories-item', ['categories' => $item->children, 'nested' => TRUE])
			@endif
		</li>
	@endforeach
</ul>