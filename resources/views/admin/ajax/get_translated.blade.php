@foreach (App\AdminPanel\TranslateAdminKey::all() as $key)
	<tr>
		<input type="hidden" value="{{ $key->key_id }}" name="key_id" id="key_id{{ $key->key_id }}">
		<td><input class="form-control" id="keyword{{ $key->key_id }}" type="text" value="{{ $key->key }}" name="translated_word_key"></td>
		@foreach (App\AdminPanel\TranslateAdmin::where('key_id',$key->key_id)->get() as $trans)
			<td><input class="form-control" id="translated_word{{$trans->translate_id}}" type="text" value="{{ $trans->value }}" name="translated_word"></td>
				<input type="hidden" value="{{$trans->translate_id}}" id="translated_word_id{{$trans->translate_id}}" name="translated_word_id">
			<script>
			$(document).ready(function(){
				$('#translated_word{{$trans->translate_id}}').on('input',function(){
					var translated_word = $('#translated_word{{$trans->translate_id}}').val();
					var translated_word_id = $('#translated_word_id{{$trans->translate_id}}').val();
					$.ajax({
						type:'POST',
						url:'{{ route('translated_word_update') }}',
						data:{
							_token:'{{ csrf_token() }}',
							'translated_word':translated_word,
							'translated_word_id':translated_word_id
						},
						success:function(data){
							if(data == 1){
								get_translated();
							}
						}
					}).fail(function(){
						console.log('something wrong at route = ');
					});
				});
			});
			</script>
			@endforeach
<script>
$('#keyword{{ $key->key_id }}').on('input',function(){
	var keyword = $('#keyword{{ $key->key_id }}').val();
	var key_id = $('#key_id{{ $key->key_id }}').val();
	$.ajax({
		type:'POST',
		url:'{{ route('get_translate_key') }}',
		data:{
			_token:'{{ csrf_token() }}',
			'keyword':keyword,
			'key_id':key_id
		},
		success:function(data){
			if(data == 1){
				get_translated();
			}
		}
	}).fail(function(){
		console.log('something wrong at route = ');
	});
});

</script>
	</tr>
@endforeach