<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <option value="{{$subcategory->id}}">{{$dash}}{{$subcategory->title}}</option>
    @if(count($subcategory->subcategory))
        @include('subCategoryList-option',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach