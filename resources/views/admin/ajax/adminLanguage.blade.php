@foreach ($word as $words)
<tr>
    <th>{{$words->tf_id}}</th>
    <form id="wordForm" method="POST">
      @csrf
      <input type="hidden" id="word_id{{$words->tf_id}}" value="{{$words->tf_id}}">
      <td><input type="text" id="words{{$words->tf_id}}" value="{{ $words->field }}" ></td>
      <td><button id="wordAddButton{{$words->tf_id}}" class="btn btn-warning">Save</button></td>
    </form>
  <td>
    <a href="#collapseCardExample{{ $words->tf_id }}" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample" style="text-align: center;">
      <h6 class="m-0 font-weight-bold text-primary">({{App\Lang\Text_filed_value::where('filed_id',$words->tf_id)->count()}})</h6>
    </a>
  </td>
  <td>
    @foreach ($translated_word as $translated)
        @if($words->tf_id == $translated->filed_id)
    <tr class="collapse hide" id="collapseCardExample{{ $words->tf_id }}">
{{--     <td><code>{{ $translated->tfv_id }}</code></td> --}}
    {{-- <form method="POST" action="{{ route('editTranslatedWord') }}">
      @csrf --}}
      
     <form id="translatedWordForm" method="POST">
       @csrf
      <td><input type="text" value="{{ $translated->value }}" id="translated_word{{$translated->tfv_id}}" value="{{ old('translated_word') }}"></td>
      <input type="hidden" id="translated_id{{$translated->tfv_id}}" name="translated_id" value="{{$translated->tfv_id}}">
      <td>
        <select id="language_id{{$translated->tfv_id}}" >
          @foreach ($language as $langFlag)
            @if ($langFlag->id == $translated->language_id)
              <option value="{{ $langFlag->id }}" selected>{{ $langFlag->language_short_name }}</option>
            @else
              <option value="{{ $langFlag->id }}">{{ $langFlag->language_short_name }}</option>
            @endif
          @endforeach
        </select>  
      </td>
      @foreach ($language as $langFlag)
      @if ($langFlag->id == $translated->language_id)
      <td>
        {{$langFlag->language_name }}
      </td>
      <td>
        {{$langFlag->native_half_lang_name }}
      </td>
      <td>
        {{$langFlag->native_full_lang_name }}
      </td>
      <td>
        <img src="{{ asset('flagImages') }}/{{$langFlag->flag_link}}" height="30">
      </td>
       @endif
      @endforeach
      <td>
        <button class="btn btn-success" id="translatedWordButton{{$translated->tfv_id}}">Save</button>
      </td>
      </tr>
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
@endif
      @endforeach
  </td>
</tr>
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
@endforeach
