@extends('admin.adminLayout')
@section('link')

@endsection
@section('main')
<style>
body {
    font-family: Arial;
}

input#crop {
    padding: 5px 25px 5px 25px;
    background: lightseagreen;
    border: #485c61 1px solid;
    color: #FFF;
    visibility: hidden;
}

#cropped_img {
    margin-top: 40px;
}
</style>

	<div class="input-group control-group increment">
		<input type="file" name="event_image" id="imageInput" accept="image/*"  required="required">
	</div>
    <div>
        <img src="{{ asset('img/original-image.jpeg') }}" id="cropbox" class="img" /><br/>
    </div>
    <div id="btn">
        <input type='button' id="crop" value='CROP'>
    </div>
    {{-- <div>
        <img src="#" id="cropped_img" style="display: none;">
    </div> --}}


@endsection
@section('script')
<link rel="stylesheet" href="{{ asset('css/jquery.Jcrop.min.css') }}" type="text/css" />
<script src="{{ asset('js/jquery.Jcrop.min.js') }}"></script>
<script type="text/javascript">


    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
        var size;
        $('#cropbox').Jcrop({
          aspectRatio:1280/1920,
          onSelect: function(c){
           size = {x:c.x,y:c.y,w:c.w,h:c.h};
           $("#crop").css("visibility", "visible");     
          }
        });
     
  $("#crop").click(function(){
            var img = $("#cropbox").attr('src');
            $("#cropped_img").show();
            $.ajax({
              type:'POST',
              url:'{{ route('testImage') }}',
              data:{
                '_token':'{{ csrf_token() }}',

                'x':size.x,
                'y':size.y,
                'w':size.w,
                'h':size.h,
                'img':img
              },
              success:function(data){
                setTimeout(function(){
                  $("#cropped_img").attr('src',data);
                },4000);
                
                console.log(data);
              }
            }).fail(function(){
              console.log('something got wrong route=imageCrop');
            });
        });
</script>
@endsection