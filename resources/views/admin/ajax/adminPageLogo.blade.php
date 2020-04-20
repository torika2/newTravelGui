@foreach ($logos as $logo)
	<div class="grid-item">
		{{-- <input type="radio" name="image_id"value="{{$logo->logo_id}}"> --}}
		{{-- @if ($logo->equiped == 1) --}}
	 	<img class="grid-images" height="100" style="border: solid 2px black;" src="{{ asset('pageLogos') }}/{{$logo->logo_url}}">
	{{-- 					@else
			<img class="grid-images" height="100" style="cursor: pointer; border: solid 2px grey;" src="pageLogos/{{asset($logo->logo_url)}}">
		@endif  --}}
	</div>

@endforeach	
<script>
	$('#countedLogos').ready(function(){
		$('#countedLogos').text('ლოგოს დამატება '+'('+{{$logos->count()}}+')'+ ' .SVG');
	});
</script>