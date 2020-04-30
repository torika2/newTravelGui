@extends('admin.adminLayout')
@section('main')
<style>
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto ;
  padding: 10px;
}
#grid-item {
  padding: 10px;
  font-size: 30px;
  text-align: center;
  border:solid 4px black;
}

#grid-item,img:hover{
	opacity: 0.7;
}
#grid-item,input:hover{
	opacity: 1;
	z-index: 999;
}

.editImageButton{
	background: orange;
	border: none;
}
label input{
	position: absolute;
}
.grid-images{
	box-shadow: 5px 5px 5px 0px;
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
body {
    font-family: Arial;
}
</style>
@foreach ($frames as $frame)
<input type="hidden" id="page_params" value="{{ $frame->params }}">
<div class="card shadow mb-4">
    <a class="d-block card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" id="pageImageCount">    </h6>
    </a>
    <div class="collapse show" >
        <div class="card-body">
          <div class="d-block" >
            @if (\Auth::check())
              <div class="input-group control-group increment">
                <form id="imageInputForm" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="params" value="{{ $frame->params }}">
                  <input type="file" class="form-control" name="bg_image" accept="image/jpeg"  required="required">
                </form>
              </div>
              <hr>
                <div id="cropbox_div">
                  @foreach (App\Photo\ForBgCrop::where('params',$frame->params)->get() as $img)
                    <img src="{{ asset('forBackgroundImage') }}/{{ $img->image_url }}" {{-- height="350" --}} class="image_cropped" id="cropbox" class="img" /><br/>
                  @endforeach
                    
                </div>
                <div id="btn">
                    <input type='button' id="crop" value='CROP'>
                </div>
						@if($errors->any())
            <div class="alert alert-danger">
              @foreach ($errors->all() as $error)      
                <li>{{$error}}</li>
              @endforeach
            </div>
            @endif
					  @endif
	            </div>
<br>		
					{{-- Uploaded image place --}}
			<div id="imageOutputDiv" class="grid-container">
        	
			</div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <a class="d-block card-header py-3">
        <h6 class="m-0 font-weight-bold text-warning" id="countedLogos"> </h6>
    </a>
    <div class="collapse show" >
        <div class="card-body">
          	<form {{-- action="{{ route('logoUpload') }}" --}} id="logoForm" {{-- method="POST"  --}} {{-- enctype="multipart/form-data" --}}>
          		@csrf
          			<input type="hidden" id="logo_page_id" name="page_id" value="{{ $frame->page_id }}">
					<input type="hidden" id="logo_params" name="params" value="{{ $frame->params }}">
					<input type="file" id="logo_svg" accept=".svg" name="logo_input" required="required">
{{-- 				<button class="btn btn-warning">ლოგოს ატვირთვა</button> --}}
          	</form>  
          	<div id="logoOutput" class="grid-container">
        	
			</div>
        </div>
    </div>
</div>
  <div class="card shadow mb-4">
    <a class="d-block card-header py-3">
        <h6 class="m-0 font-weight-bold text-secondary">ფონისთვის ფერის დამატება</h6>
    </a>
    <div class="collapse show" >
        <div class="card-body">
            <div class="row">
				<form action="javascript:void(0);">
          <input type="color" id="color" name="color" style="width: 100px;">
          <td><button onclick="createPageColor()">დააჭირე</button></td>
				</form>
      </div>
      {{-- COLOR OUTPUT --}}
                <div class="row" id="colorOutput">
				
                </div>
            </div>
        </div>
    </div>
</div>
	@endforeach
@endsection
@section('script')
<script>
$('#cropbox').hide();
$('#imageInputForm').on('change',function(){
  var data = new FormData($('#imageInputForm')[0]);
  $.ajax({
    type:'POST',
    url:'{{ route('forBgCrop') }}',
    processData: false,
    contentType: false,
    cache: false,
    data:data,
    success:function(data){
      location.reload();
    }
  }).fail(function(){
    console.log('something wrong at route = forBgCrop');
  });
});
function getPageColor() {
  var params = $('#page_params').val();
  $.ajax({
    type:'GET',
    url:'/admin/page/color/get/'+params,
    data:{
      _token:'{{ csrf_token() }}',
      'params':params
    },
    success:function(data){
       $('#colorOutput').html(data);
    }
  }).fail(function(){
    console.log('something wrong route=getPageColor');
  });
}
function createPageColor(){
   var params = $('#page_params').val();
   var color = $('#color').val();
   $.ajax({
    type:'POST',
    url:'{{ route('pageColor') }}',
    data:{
      _token:'{{ csrf_token() }}',
      'params':params,
      'color':color
    },
    success:function(){
      getPageColor();
    }
   });  
}
var countedImage = $('#countedImage').val();
function getPageImage(){
  var params = $('#page_params').val();
  	$.ajax({
        type:'POST',
        url:'{{ route('getPageImages') }}',
      	data:{
            _token:"{{ csrf_token() }}",
            'params':params
      	},
    success:function(data){
		$('#imageOutputDiv').html(data);
		// $('#pageImageCount').text('სურათის ატვირთვა () 1280x1920');
    }
    }).fail(function(){
      	console.log('წარუმატებლად დასრულდა!');
    });
}

function getLogo(){
	var params = $('#logo_params').val();		
	$.ajaxSetup({
    	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
        type:'POST',
        url:'{{ route('getPageLogos') }}',
      	data:{
      		'params':params
      	},
    success:function(data){
    	$('#logoOutput').html(data);
    }
    }).fail(function(){
    	console.log('failed!');
    });
}
$(document).ready(function(){
	getPageImage();
	getLogo();
  getPageColor();
	
$('#pageImageCount').text('სურათის ატვირთვა ({{$pageImages->count()}}) 1280x1920');
	$('#pageImageButton').change(function(){
		$('#pageImageButton').append('<label class="text-success" id="loader">Uploading...</>');
  		var data = new FormData($(this)[0]);		
  		$.ajaxSetup({
  	    	headers: {
  	        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			}
  		});
  		$.ajax({
        type:'POST',
        url:'{{ route('frameImage') }}',
        // enctype: 'multipart/form-data',
  		  processData: false,
        contentType: false,
        cache: false,
  	    data:data,
    success:function(){
    	$('#loader').text('Done');
    	getPageImage();
    	setTimeout(function(){
    		$('#loader').remove();
    	},1200);
    }
    }).fail(function(){
        $('#loader').remove();
      	$('#pageImageButton').append('<label class="text-warning" id="failed">Failed to upload this type of file!</>');
    	getPageImage();
    	setTimeout(function(){
    		$('#failed').remove();
    	},1500);
    });
	});
});
$('#logoForm').change(function(){
	$('#logoForm').append('<label class="text-success" id="loader">Uploading...</>');
	var data = new FormData($(this)[0]);		
	$.ajaxSetup({
    	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
        type:'POST',
        url:'{{ route('logoUpload') }}',
        // enctype: 'multipart/form-data',
		    processData: false,
        contentType: false,
        cache: false,
      	data:data,
    success:function(){
    	$('#loader').text('Done');
    	getLogo();
    	setTimeout(function(){
    		$('#loader').remove();
    	},1200);
    }
    }).fail(function(){
    	console.log('failed!');
    });

});
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

// var data = new FormData($('#file-upload')[0]);
</script>
<link rel="stylesheet" href="{{ asset('css/jquery.Jcrop.min.css') }}" type="text/css" />
<script src="{{ asset('js/jquery.Jcrop.min.js') }}"></script>
<script>
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
      var params = $('#page_params').val();
      $("#cropped_img").show();
      $.ajax({
        type:'POST',
        url:'{{ route('testImage') }}',
        data:{
          '_token':'{{ csrf_token() }}',
          'params':params,
          'x':size.x,
          'y':size.y,
          'w':size.w,
          'h':size.h,
          'img':img
        },
        success:function(data){
           $("#cropped_img").attr('src',data);
           getPageImage();
        }
      }).fail(function(){
        console.log('something got wrong route=imageCrop');
      });
  });
</script>
@endsection
