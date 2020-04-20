@foreach ($pageImages as $pageImage)
				<div class="grid-item">
				<label>
					<input type="radio" name="image_id"value="{{$pageImage->bg_id}}">
					@if ($pageImage->equiped == 1)
					 	<img class="grid-images" height="100" style="border: solid 2px orange;" src="{{asset($pageImage->link)}}">
					@else
						<img class="grid-images" height="100" style="cursor: pointer; border: solid 2px grey;" src="{{asset($pageImage->link)}}">
					@endif 
				</label>
						{{-- <br>
					<form method="POST" action="{{ route('frameImageSizingPage') }}" style="margin:auto;">
						@csrf
						<input type="hidden" name="image_id" value="{{$pageImage->bg_id}}">
						<button class="editImageButton">სურათის შესახებ</button>
					</form> --}}
				</div>
			@endforeach