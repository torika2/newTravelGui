@foreach ($pageImages as $pageImage)
	<div class="grid-item">
	<label>
		@if ($pageImage->equiped == 1)

		 	<img class="grid-images"  height="100" style="border: solid 2px orange;" src="{{asset($pageImage->link)}}">
		 	<form action="javascript:void(0);" id="deletePageImage">
		 		@csrf
				<input type="hidden" id="image_id" name="image_id" value="{{$pageImage->bg_id}}">
				<button onclick="deleteImage({{$pageImage->bg_id}})" id="deletePageImage" class="btn btn-danger">Delete</button>	
			</form>
				
		@else
			<img class="grid-images" height="100" style="cursor: pointer; border: solid 2px grey;" src="{{asset($pageImage->link)}}">
			{{-- <form action="javascript:void(0);" > --}}
				<div>
					<button onclick="deleteImage({{$pageImage->bg_id}})" id="deletePageImage" class="btn btn-danger">Delete</button>
				</div>
			{{-- </form> --}}
		@endif 

		<input type="hidden" id="countedImage" value="{{$pageImages->count()}}">
	</label>
	
			{{-- <br>
		<form method="POST" action="{{ route('frameImageSizingPage') }}" style="margin:auto;">
			@csrf
			<input type="hidden" name="image_id" value="{{$pageImage->bg_id}}">
			<button class="editImageButton">სურათის შესახებ</button>
		</form> --}}
	</div>
@endforeach
<script>
if($('#countedImage').val() == undefined){
	$('#pageImageCount').text('სურათის ატვირთვა (0) 1280x1920');
}else{
	$('#pageImageCount').text('სურათის ატვირთვა ('+$('#countedImage').val()+') 1280x1920');
}
function deleteImage(id) {
	if(confirm('are you sure to delete?!')){
		$.ajax({
        type:'POST',
        url:'{{ route('deletePageImage') }}',
      	data:{
            '_token':"{{ csrf_token() }}",
            'bg_id':id
      	},
    success:function(data){
		getPageImage();
    }
    }).fail(function(){
      	console.log('თქვენი მოთხოვნა ვერ შესრულდა გთხოვთ მიმართოთ საბას:)))!');
	});
	}
}


</script>