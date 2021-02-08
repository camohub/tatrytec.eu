<ul @if(!isset($nested))class="sortable"@endif>
	@foreach($categories as $item)
		<li id="menuItem_{{$item->id}}" data-module="{!! $item->module->id ?? 0 !!}">
			<div>
				{{$item->name}}
				@if( $item->slug != 'najnovsie' )
					<a href="{{route('admin.categories.delete', ['id' => $item->id])}}"
						class="ignore ajax fa fa-lg fa-trash-o d-none" title="Delete"> </a>

					<a data-toggle="modal" data-target="#editCategoryFormModal" rel="nofollow"
						data-name="{{$item->name}}" data-id="{{$item->id}}" data-parent_id="{{$item->parent_id}}"
						class="ignore fa fa-lg fa-pencil" title="Edit"> </a>

					<a href="{{route('admin.categories.visibility', ['id' => $item->id])}} {{$item->id}}"
						class="ignore ajax fa fa-lg {{$item->visible ? 'fa-check-circle' : 'fa-minus-circle'}}"
						title="Visible/Hidden"> </a>
				@endif
			</div>

			@if($item->children->count())
				@include('admin.categories.components.sortable-categories-item', ['categories' => $item->children, 'nested' => TRUE])
			@endif
		</li>
	@endforeach
</ul>