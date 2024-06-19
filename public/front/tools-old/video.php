

<div class="playVideo" data-toggle="modal" data-target="#myModalVideo" data-link="">asdfsdfs</div>

<div id="myModalVideo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content"> <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="show_iframe"></div>
        </div>
    </div>
</div>

<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'
        id='jquery-js'></script>
<script type='text/javascript' src='https://us.watergen.com/wp-content/themes/watergen/js/bootstrap.min.js'
            id='bootstrap-js'></script>
<script>
    $(document).ready(function () {
        $('#myModalVideo').on('show.bs.modal', function () {
            $('#myModalVideo iframe').attr('src', $('#myModalVideo iframe').attr('data-src'));
        });
        $('#myModalVideo').on('hide.bs.modal', function () {
            $('#myModalVideo iframe').attr('src', "");
        });
    });

    window.onload = (event) => {
        $(".show_iframe").html('<iframe id="myVideoGenny" width="888" height="500" src="" data-src="https://www.youtube.com/embed/YdeZRIPKXbo?version=3&showinfo=0&autoplay=1&rel=0&loop=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
    }
</script>