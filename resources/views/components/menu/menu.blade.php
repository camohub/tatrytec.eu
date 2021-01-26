<script>
	/* This var is used by main.js which opens/closes categories.
	It is current category id. You can set it in presenter via $this[name]->setCategory( $id ).*/
	var category_id = {{$current_id ?? 'null'}};
</script>

@php
    use App\Models\Entities\Category;
    $categories = Category::whereNull('parent_id')->visible()->with('children')->get();
@endphp

@include('components.menu.menu-section', ['categories' => $categories])