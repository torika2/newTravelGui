@foreach ($word as $words)
<tr>
    <td>
      {{$words->tf_id}}
    </td>
    <td>
      <input type="hidden" id="word_id{{$words->tf_id}}" value="{{$words->tf_id}}">
      <input type="text" class="form-control" id="words{{$words->tf_id}}" value="{{ $words->field }}" >
    </td>
    @foreach ($translated_word as $translated)
      @if ($translated->filed_id == $words->tf_id)
          <td>
            <input type="text" class="form-control" value="{{ $translated->value }}" name="translated_word" id="translated_word{{$translated->tfv_id}}" value="{{ old('translated_word') }}">
            <input type="hidden"  id="translated_id{{$translated->tfv_id}}" name="translated_id" value="{{$translated->tfv_id}}">
          </td>
          <script>
            $('#translated_word{{$translated->tfv_id}}').on('input',function(){
              var translated_word = $('#translated_word{{$translated->tfv_id}}').val();
              var translated_id = $('#translated_id{{$translated->tfv_id}}').val();
              $.ajax({
                type:'POST',
                url:'{{ route('editTranslatedWord') }}',
                data:{
                  _token:'{{ csrf_token() }}',
                  'translated_id':translated_id,
                  'translated_word':translated_word
                },
              }).fail(function(){
                console.log('problem at route=editTranslatedWord');
              });
            });
          </script>
      @endif
    @endforeach
</tr>
<script>
$('#words{{$words->tf_id}}').on('input',function(){
  var word_value = $('#words{{$words->tf_id}}').val();
  var word_id = $('#word_id{{$words->tf_id}}').val();
  $.ajax({
    type:'POST',
    url:'{{ route('editWord') }}',
    data:{
      _token:'{{ csrf_token() }}',
      'word_value':word_value,
      'tf_id':word_id
    },
  }).fail(function(){
    console.log('problem at route=editWord');
  });
});
</script>
@endforeach
