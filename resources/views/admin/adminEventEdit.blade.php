@extends('admin.adminLayout')
@section('link')
	  <meta name="token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
@endsection
@section('main')
<style>

#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
top: 15px;
left: 50px;
  color: red;
  font-size: 40px;
  font-weight: bold;
  transition: 0.2s;
  z-index: 1000;
}

.close:hover,
.close:focus {
  color:darkred;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 90%;
  }
}
</style>

	@foreach ($event as $events)
	<div class="card shadow mb-4">
    <a  class="d-block card-header py-3" >
        <h6 class="m-0 font-weight-bold text-primary">სურათის ატვირთვა ({{$eventImages->count()}})</h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <div class="row">
<div>
	<div class="container">
	  <div class="panel panel-info">
	    <div class="panel-body">
	      <div class="row">
	        <div class="col-md-4 text-center">
	        	<div id="upload-demo"></div>
	        </div>
	        <div class="col-md-4" style="padding:5%;">
		        <strong>Select image for crop:</strong>
		        <input type="hidden" name="tour_id" id="tour_id" value="{{ $events->tour_id }}">
		        <input type="file" id="images" name="image">
		        <button class="btn btn-primary btn-block image-upload" style="margin-top:2%">Upload Image</button>
	        </div>
	        <div class="col-md-4">
	        	<div id="show-crop-image" style="background:#e2e2e2;width:400px;padding:60px 60px;height:400px;"></div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
   <script type="text/javascript">

	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
	  }
	});

	var resize = $('#upload-demo').croppie({
	    enableExif: true,
	    enableOrientation: true,    
	    viewport: { 
	        width: 300,
	        height: 300,
	        type : 'square'
	    },

	    boundary: {
	        width: 300,
	        height: 300
	    }
	});

	$('#images').on('change', function () { 
	  var reader = new FileReader();
	    reader.onload = function (e) {
	      resize.croppie('bind',{
	        url: e.target.result
	      }).then(function(){
	        console.log('success bind image');
	      });

	    }
	    reader.readAsDataURL(this.files[0]);
	});

	$('.image-upload').on('click', function (ev) {
		var tour_id = $('#tour_id').val();
	  resize.croppie('result', {
	    type: 'canvas',
	    size: 'viewport'

	  }).then(function (img) {
	    $.ajax({
	      url: "{{ route('uploadEventImage') }}",
	      type: "POST",
	      data: {"image":img,'_token':'{{csrf_token()}}','tour_id':tour_id},
	      success: function (data) {
	        html = '<img src="' + img + '" />';
	        $("#show-crop-image").html(html);
	      }
	    });
	  });
	});
 </script>	
</div>
	           {{--  @if (\Auth::check())
					<form  method="POST" action="javascript:void(0)" id="uploadEventImageForm" enctype="multipart/form-data">
							@csrf
						<input type="hidden" id="tour_id" name="tour_id" value="{{$events->tour_id}}">
						<div class="input-group control-group increment">
							<input type="file" name="event_image" id="imageInput" accept="image/*"  required="required">
						</div>
						<div class="input-group-btn">
							<button style="background: orange;" id="imageButton" class="btn btn-primary">ატვირთე</button>
						</div>
					</form>	
				@endif
				<div class="disable-form">
						 <img class="file-upload-image" id="yourImage" height="100" src="#" alt="your image"/>
					</div>  --}}
		<div class="collapse hide" id="collapseCardExample">
	        <div class="card-body">
	            <div class="row" >
					<div id="upFile">
						
					</div>
		        </div>
	        </div>
    	</div>
</div>
	        </div>
        </div>
    </div>
</div>
{{-- UPLOADED IMAGES --}}
<div id="success" style="visibility: hidden;" class="alert alert-warning">

</div>
<div id="pictureOutput" class="grid-container">
	
{{-- <div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				@foreach ($eventImages as $eventImage)
				<input type="hidden" id="tour_image_id" name="image_id" value="{{$eventImages->first()->tour_image_id}}">
					<td height ="100%">
					<div class="grid-item">
						<img height="100" src="{{ asset($eventImage->image_url) }}"id="myImg" >
						<div id="myModal" class="modal">
						  <span class="close">&times;</span>
						  	<img class="modal-content" id="img">
						  <div id="caption"></div>
						</div>
						<div style="margin-top: -20%">
					@if ($eventImages->first()->image_url == $eventImage->image_url  && $eventImages->first()->image_position >! $eventImage->image_position)
			         @else
			         	<form method="POST" id="imageSorting" action="javascript:void(0)" >
			            	@csrf
			            	
			            	<input type="hidden" id="image_url" name="image_url" value="{{$eventImage->image_url}}">
			            	<input type="hidden" id="image_pos" name="image_pos" value="{{ $eventImage->image_position }}">
			            	<input type="hidden" id="tour_id" name="tour_id" value="{{ $events->tour_id }}">
			            	<button id="sortingButton" class="btn btn-success"><</button>
			            </form> 	
			        @endif    
						<form method="POST" action="{{ route('deleteEventImage') }}">
			            	@csrf
			            	@method('delete')
			            	<input type="hidden" name="tour_image_id" value="{{$eventImage->tour_image_id}}">
			            	<input type="hidden" name="tour_id" value="{{ $events->tour_id }}">
			            	<input type="hidden" name="image_url" value="{{$eventImage->image_url}}">
			            	<button class="btn btn-danger">x</button>
			            </form>
			            </div>
					</div>	
					</td>
				@endforeach

				</tr>
			</thead>
		</table>
	</div> --}}


</div>
	<div id="page-wrapper" style="margin-top: 5%;">
	            <div class="container-fluid">
	                <div class="row bg-title">
	                <!-- /row -->
	                <div class="row">
	                    <div class="col-sm-12">
	                        <div class="row" >
	                        	 <h3 class="box-title"></h3>
	                        	
	                        </div>
	                        <div class="row">
	                        	<div class="table-responsive">
	                                <table class="table">
	                                    <thead>
	                                        <tr>
	                                           <th>სახელი</th>
	                                           <th>აღწერა</th>
	                                           <th>ხალხის რაოდენობა</th>
	                                           <th>ფასი თითო ადამიანზე</th>
	                                           <th>შექმნის დრო</th>
	                                           <th>კომენტარი</th>
	                                           <th>გაზიარება</th>
	                                           <th>მოწონება</th>
	                                           <th>არ მოსწონს</th>
	                                           <th>სურათი</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    	<form method="POST" action="{{ route('editEvent') }}">
	                                    		@csrf
	                                    		<input type="hidden" name="tour_id" value="{{ $events->tour_id }}">
	                                   		<td>
	                                   			<input   type="text" value="{{ $events->tour_name }}" name="event_name" id="event_name" required="required">
	                                   		</td>
	                                   		<td>
	                                   			<input   type="textarea" name="event_desc" id="event_desc"  value="{{ $events->description }}" required="required">
	                                   		</td>
	                                   		
	                                   		<td>{{$events->limited_member}}</td>
	                                   		<td>{{$events->tour_price}}$</td>
	                                   		<td>{{$events->created_at->diffForHumans()}}</td>
	                                   		<td>{{ App\TourReviews::where('tour_id',$events->tour_id)->count() }}</td>
                                            <td>{{ App\UserTourShare::where('tour_id',$events->tour_id)->count() }}</td>
                                            <td>{{ App\TourLikes::where('tour_id',$events->tour_id)->count() }}</td>
                                            <td>{{ App\TourUnlike::where('tour_id',$events->tour_id)->count() }}</td>
                                            <td>{{App\TourImageSorter::where('tour_id',$events->tour_id)->count()}}</td>
	                                    </tbody>
		                                    <tr>
	                                   			<td>
	                                   				<button type="submit" class="btn btn-primary" id="agreeButton">თანხმობა</button>
	                                   			</td>
		                                    </tr>
	                                    </form>
	                                </table>
	                            </div>
	                        </div>
	                        <div class="white-box">
	                        	<h4 style="margin: auto;">Comments ({{count($eventReviews)}})</h4>
	                        	<div class="table-responsive">
	                            	<table class="table">
	                            		<thead>
	                            			<tr>
		                                    	<td><code>User Name</code></td>
		                                    	<td><code>Comment Content</code></td>
		                                    	<td><code>Creation Date</code></td>
		                                    	<td><code>Comment Replys</code></td>
		                                    	<td><code>Likes</code></td>
	                                    	</tr>
	                                    </thead>
	                                    <tbody>
	                                    	@foreach ($eventReviews as $eventReview)
		                                    	<tr>
		                                    		<td>{{ $eventReview->name.' '.$eventReview->lastname}}</td>
		                                    		<td>{{ $eventReview->review_content }}</td>
		                                    		@if ($eventReview->created_at != null)
		                                    			<td>{{ $eventReview->created_at->diffForHumans() }}</td>
		                                    		@endif
		                                    		<td>{{ App\TourReviewReply::where('review_id',$eventReview->review_id)->count() }}</td>
		                                    		<td>{{ App\TourReviewLikes::where('review_id',$eventReview->review_id)->count() }}</td>
		                                    		 <td>
                                                    <form method="POST" action="{{ route('deleteReviewReply') }}">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="tour_id" value="{{$events->tour_id}}">
                                                        <input  type="hidden" name="review_id" value="{{$eventReview->review_id}}" >
                                                        <button id="delete" style="background: darkred;border:none;border-radius: 5px;" class="btn btn-danger" onclick="return confirm('დარწმუნებული ხარ? კომენტარის წაშლის შემთხვევაში წაიშლება ყველაფერი რა ინფორმაციასაც კომენტარი შეიცავდა!')">წაშლა</button>
                                                    </form>
                                                </td>
		                                    	</tr>
	                                    	@endforeach
	                                    </tbody>
	                            	</table>
	                            </div>
							</div>
	                    </div>
	                </div>
	            </div>
	@endforeach
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
	$('#yourImage').hide();
	getAllImages();
	setInterval(function(){
		getAllImages();
	},2000);
	function getAllImages(){
		var event_id = $('#tour_id').val();
		// var image_id = $('#tour_image_id').val();
		$.ajax({
		    type:'POST',
		    url:'{{route('getEventImages')}}',
		    data:{
		    	_token:'{{csrf_token()}}',
		    	'event_id':event_id,
		    	// 'image_id':image_id
		    },
	    success:function(data){
	    	// if(data){
	    		if(data){
					$('#pictureOutput').html(data);
	    		}
	    	// }
		}
	  	}).fail(function(data){
	      alert(data);
		});

		// getEventImages
	}
$('#yourImage').ready(function(){
 $('#imageInput').change(function(){
  if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('.image-upload-wrap').hide();
        $('.file-upload-image').attr('src', e.target.result);
        $('.file-upload-content').show();
      };
      reader.readAsDataURL(this.files[0]);
      $('#yourImage').show();
    } else {
      removeUpload();
    }
  }); 
});
	$('#uploadEventImageForm').change(function(){
		$(this).submit(function(){
			var formData = new FormData($('#uploadEventImageForm')[0]);
			$.ajax({
			    type:'POST',
			    url:'{{ route('editEventImage') }}',
			    processData: false,
		      	contentType: false,
		      	cache: false,
			    data:formData,
		    success:function(data){
		      $('#pictureOutput').html(data);
		      getAllImages();
	    	}
		  	}).fail(function(data){
		      alert(data);
			});
		});
	});
});
</script>
 
@endsection
