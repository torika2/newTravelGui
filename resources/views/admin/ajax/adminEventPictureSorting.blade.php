
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
			@foreach ($event as $events)
				@foreach ($eventImages as $eventImage)
					<td height ="100%">
					<div class="grid-item">
						<img height="100" src="{{ asset('eventImages') }}\{{$eventImage->image_url}}"id="myImg" >
						<div id="myModal" class="modal">
						  <span class="close">&times;</span>
						  	<img class="modal-content" id="img">
						  <div id="caption"></div>
						</div>
						<div style="margin-top: -20%">
					@if ($eventImages->first()->image_url == $eventImage->image_url  && $eventImages->first()->image_position >! $eventImage->image_position)
			         @else
			         	<form method="POST" id="imageSorting{{$eventImage->tour_image_id}}" action="javascript:void(0)" >
			            	@csrf
			            	<input type="hidden" name="tour_image_id" value="{{$eventImage->tour_image_id}}">
			            	<input type="hidden" id="image_url{{$eventImage->tour_image_id}}" name="image_url" value="{{$eventImage->image_url}}">
			            	<input type="hidden" id="image_pos{{$eventImage->tour_image_id}}" name="image_pos" value="{{ $eventImage->image_position }}">
			            	<input type="hidden" id="tour_id" name="tour_id" value="{{ $events->tour_id }}">
			            	<button id="sortingButton{{$eventImage->tour_image_id}}" class="btn btn-success"><</button>
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
<script>
$(document).ready(function(){
	$('#sortingButton{{$eventImage->tour_image_id}}').click(function(){
	var image_url = $('#image_url{{$eventImage->tour_image_id}}').val();
	var image_pos = $('#image_pos{{$eventImage->tour_image_id}}').val();
	var event_id = $('#tour_id').val();
		$.ajax({
		    type:'POST',
		    url:'{{ route('sortingEventImages') }}',
		    data:{
		    	_token:"{{csrf_token()}}",
		    	'image_url':image_url ,
		    	'image_pos':image_pos ,
		    	'tour_id':event_id
		    },
		success:function(data){
		  	$('#success').css('visibility','visible');
		  	$('#success').text(data);
		  	setInterval(function(){
		  		$('#success').css('visibility','hidden');
		  	},2000);
		}
			}).fail(function(data){
		  alert(data);
		});
	});
});	
</script>
				@endforeach
			@endforeach
				</tr>
			</thead>
		</table>
	</div>

