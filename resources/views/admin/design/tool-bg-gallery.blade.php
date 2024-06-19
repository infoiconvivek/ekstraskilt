
@if($bg_images->count() >=1)
@foreach($bg_images as $row)
<div class="thumb" data-img="{{URL::asset($row->image)}}" onclick="addToolbgImage('{{URL::asset($row->image)}}')">
    <img src="{{URL::asset($row->image)}}">
</div>
@endforeach
@else
        <div class="text-center">
            <h2>Nothing Found</h2>
        </div>
    <div>
@endif

