@if($bg_images->count() >=1)
<div class="boxes">
    <div class="box3">

        @foreach($bg_images as $row)
        <div class="box-img">
            <a href="javascript:void(0)" data-img="{{URL::asset($row->image)}}" onclick="addToolbgImage('{{URL::asset($row->image)}}')">
                <img src="{{URL::asset($row->image)}}" alt="" class="img-fluid">
            </a>
        </div>
        @endforeach


    </div>
</div>
@endif