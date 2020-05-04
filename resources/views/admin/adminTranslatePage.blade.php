@extends('admin.adminLayout')
@section('main')
<div class="card shadow mb-4" style="margin:auto;width:95%;">
  <div class="collapse show" id="sloganCardExample">
    <div class="card-body">
        @if ($languages->count() > 0)
        <form  action="{{ route('add_word') }}" method="POST" style="margin:auto;">
          @csrf
            <input type="text" name="translated_key" value="{{ old('translated_key[]') }}" placeholder="Translate key here..." class="form-control col-md-4">
	        <div class="row mt-3">
		        @foreach ($languages as $language)
		        <div class="col-md-4">
		          <div>
		            <label class="ml-2"><b>Word : {{ $language->language_short_name }}</b></label>
		            <input style="border-radius: 5px;" class="form-control" type="text" value="{{ old('translated_values[]') }}" name="translated_values[]" required="required">
		          </div>
		          <div>
		            <input type="hidden" value="{{ $language->language_short_name }}" name="lang_short_name[]" required="required">
		          </div>
		        </div>
		        @endforeach
		    </div>
          <br>
          <div>
            <button class="btn btn-success" id="" style="display:block;margin:auto;">Save</button>
          </div>
        </form>
      @else
        <h6 style="text-align: center;">დაამატეთ ენა რომ გამოგიჩნდეთ შესავსები ფორმა!</h6>
      @endif
      </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Key</th>
                @foreach ($languages as $lang)
                	<th>{{ $lang->language_name }}</th>
                @endforeach
              </tr>
            </thead>
            {{-- TRANSLATE OUTPUT (VIEW) --}}
            <tbody id="translate_output">
            	
            </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function(){
  get_translated();
});
function get_translated(){
  $.ajax({
    type:'GET',
    url:'{{ route('get_translated') }}',
    data:{
      _token:'{{ csrf_token() }}',
    },
    success:function(data){
      $('#translate_output').html(data);
    },
  }).fail(function(){
    console.log('problem with route = get_translated');
  });
}


</script>	
@endsection