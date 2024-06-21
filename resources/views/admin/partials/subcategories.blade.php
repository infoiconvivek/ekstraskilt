@foreach($subcategories as $subcategory)
    <input type="checkbox" name="categories[]" value="{{ $subcategory->id }}"> {{ $dash }} {{ $subcategory->title }}<br>
    @if(count($subcategory->subcategories))
        @include('admin.partials.subcategories', ['subcategories' => $subcategory->subcategories, 'dash' => $dash.'—'])
    @endif
@endforeach