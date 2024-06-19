<?php $dash .= '— '; ?>
@foreach($subcategories as $subcategory)
<option value="{{$subcategory->id}}" @if(isset($selected) && $selected==$subcategory->id) {{"selected"}} @endif>{{$dash}}{{$subcategory->title}} </option>
@if(count($subcategory->subcategory))
@include('admin.category.subCategoryList-option',['subcategories' => $subcategory->subcategory])
@endif
@endforeach