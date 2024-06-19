
@if($images->count() >=1)
@foreach($images as $row)
<div class="thumb" data-img="{{URL::asset($row->image)}}" onclick="addToolImage('{{URL::asset($row->image)}}')">
    <img src="{{URL::asset($row->image)}}">
</div>
@endforeach
@else
        <div class="text-center">
            <h2>Nothing Found</h2>
        </div>
    <div>
@endif

