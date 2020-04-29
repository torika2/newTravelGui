@foreach ($word as $words)
<tr>
    <th>{{$words->tf_id}}</th>
    <form id="wordForm" method="POST">
      @csrf
      <input type="hidden" id="word_id{{$words->tf_id}}" value="{{$words->tf_id}}">
      <td><input type="text" class="form-control" id="words{{$words->tf_id}}" value="{{ $words->field }}" ></td>
      {{-- <td><button id="wordAddButton{{$words->tf_id}}" class="btn btn-warning">Save</button></td> --}}
    </form>
    <form id="translatedWordForm" method="POST">
       @csrf
    @foreach ($translated_word as $translated)
        @if($words->tf_id == $translated->filed_id)
      <td>
        <input type="text" class="form-control" value="{{ $translated->value }}" id="translated_word{{$translated->tfv_id}}" value="{{ old('translated_word') }}">
        <input type="hidden"  id="translated_id{{$translated->tfv_id}}" name="translated_id" value="{{$translated->tfv_id}}">
      </td>
        @endif
    @endforeach

{{-- <input type="text" class="form-control" name=""> --}}

     {{--  <td>
        <button class="btn btn-success" id="translatedWordButton{{$translated->tfv_id}}">Save</button>
      </td> --}}
    </form>
<script>
setTimeout(function(){
  console.clear();
},3000);
$('#translatedWordButton{{$translated->tfv_id}}').click(function(){
  var translated_word = $('#translated_word{{$translated->tfv_id}}').val();
  var language_id = $('#language_id{{$translated->tfv_id}} option:selected').val();
  var translated_id = $('#translated_id{{$translated->tfv_id}}').val();

  $.ajax({
    type:'POST',
    url:'{{ route('editTranslatedWord') }}',
    data:{
      _token:"{{csrf_token()}}",
      'translated_id':translated_id,
      'translated_word':translated_word,
      'language_id':language_id
    },
    success:function(data){
      getLanguageInfo();
      alert(data);
    }
  }).fail(function(data){
      alert(data);

  });
});

</script>

<script>
  $('#wordAddButton{{$words->tf_id}}').click(function(){
  var word = $('#words{{$words->tf_id}}').val();
  var word_id = $('#word_id{{$words->tf_id}}').val();
console.log(word);
console.log(word_id);
  $.ajax({
    type:'POST',
    url:'{{route('editNotTranslatedWord')}}',
    data:{
      _token:"{{csrf_token()}}",
      'word':word,
      'word_id':word_id
    },
    success:function(data){
      getLanguageInfo();
      alert(data);
    }
  }).fail(function(data){
      alert(data);

  });
});
</script>
</tr>
@endforeach
