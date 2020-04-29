@extends('admin.adminLayout')

@section('main')
@if(session()->has('success'))
  <div id="success" class="alert alert-success">
    {{ session()->get('success') }}
  </div>
@elseif(session()->has('unsuccess'))
<div id="success" class="alert alert-warning">
    {{ session()->get('unsuccess') }}
  </div>
@endif
<div class="row">
  @if($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $error)      
      <li>{{$error}}</li>
    @endforeach
  </div>
  @endif
</div>
<div class="card shadow mb-4" style="margin:auto;width:80%;">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample" style="text-align: center;">
        <h6 class="m-0 font-weight-bold text-primary">ენის დამატება</h6>
    </a>
  <div class="collapse hide" id="collapseCardExample">
    <div class="card-body">
      <div class="row">
        <form  action="{{ route('addLanguage') }}" method="POST" style="margin:auto;" enctype="multipart/form-data">
          @csrf
          <div>
            <label><b>ენის (შემოკლებული'Geo') დასახელება :</b></label>
            <input style="border-radius: 5px;" class="form-control" type="text" name="half_lang_name" value="{{ old('half_lang_name') }}" required="required">
          </div><br>
          <div>
            <label><b>ენის (სრული 'Georgia')  დასახელება :</b></label>
            <input style="border-radius: 5px;" class="form-control" type="text"  value="{{ old('full_lang_name') }}" name="full_lang_name" required="required">
          </div><br>
          <div>
            <label><b>ენის (მშობლიური შემოკლებული'ქარ') დასახელება :</b></label>
            <input style="border-radius: 5px;" class="form-control" type="text" value="{{ old('native_half_lang_name') }}" name="native_half_lang_name" required="required">
          </div><br>
            <div>
              <label><b>ენის (მშობლიური სრული 'ქართული') დასახელება :</b></label>
              <input style="border-radius: 5px;" class="form-control" type="text" value="{{ old('native_full_lang_name') }}" name="native_full_lang_name" required="required">
          </div><br>
          <div>
            <label><b>დროშის ატვირთვა (SVG) :</b></label>
            <input style="border-radius: 5px;" id="imageInput" class="form-control" accept=".svg" type="file" name="lang_flag" required="required">
            <img class="file-upload-image" id="yourImage" height="100" src="#">
          </div>
            <br>
          <div>
            <button onclick="return confirm('დაემატოს ენა ?')" class="btn btn-primary">თანხმობა </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="card shadow mb-4" style="margin:auto;width: 99%;">
    <a href="#collapseCardExampleEdit" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExampleEdit" style="text-align: center;">
        <h6 class="m-0 font-weight-bold text-primary">ენის ჩამონათვალი</h6>
    </a>
  <div class="collapse show" id="collapseCardExampleEdit" >
    <div class="card-body">
      <div class="row">
       <table class="table">
         <thead>
           <tr>
             <th>#</th>
             <th>ქვეყანა</th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
           </tr>
         </thead>
         <tbody>
           @foreach ($language as $languages)
              <tr>
                <td>{{ $languages->id }}</td>
                <form action="{{ route('editLanguage') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" value="{{ $languages->id }}" name="language_id">
                  <td><input type="text" class="form-control" value="{{ $languages->language_name }}" name="language_name"></td>
                  <td><input type="text" class="form-control" value="{{ $languages->language_short_name }}" name="language_short_name"></td>
                  <td><input type="text" class="form-control" value="{{ $languages->native_half_lang_name }}" name="native_half_lang_name"></td>
                  <td><input type="text" class="form-control" value="{{ $languages->native_full_lang_name }}" name="native_full_lang_name"></td>
                  <td><input type="file" accept=".svg" class="form-control" name="language_edit_image"></td>
                  <td><img src="{{ asset('flagImages') }}/{{ $languages->flag_link }}" height="20"></td>
                  <td ><button class="btn btn-warning">update</button></td>
                </form>
              </tr>
           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>
</div>
<div class="card shadow mb-4 ml-2" style="margin:auto;width: 99%;display: inline-block;">
  <a class="d-block card-header py-3" >
    <h6 class="m-0 font-weight-bold text-secondary" style="text-align: center;">სათარგმნი სიტყვის დამატება</h6>
  </a>
  <div class="collapse show">
    <div class="card-body">
      <div class="row">
        <div class="d-flex">
            <form class="form-data" method="POST" action="{{ route('addWordToTranslate') }}">
              @csrf 
            <div class="table-responsible">
              <table >
                <thead>
                  <tr>
                    <th>
                      Word Key
                    </th>
                    @foreach ($language as $langFlag)
                    <th>
                      <label class="ml-2">{{ $langFlag->language_name }}</label>
                    </th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input type="text" placeholder="Word key..." name="word_key" class="form-control">
                    </td>
                  @foreach ($language as $langFlag)
                    <td>
                      <input value="{{ $langFlag->id }}" type="hidden" name="language_id[]" required="required">
                      <input type="text" class="form-control" name="translated_word[]">
                    </td>
                  @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
            <br>
                <div>
                  <button class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
        </div>
        <hr>
        <div class="row">
          <div class="table-responsive">
          <table class="table"width="100%" cellspacing="0">
            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Word key</th>
                @foreach ($language as $langFlag)
                  <th>{{ $langFlag->language_name }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody id="translatedOutput">

              {{-- Language output!!! --}}

            </tbody>
          </table>
        </div>
        </div>
    </div>
  </div>
</div>
@endsection
@section('script')
	<script>
$(document).ready(function(){
  $('#yourImage').hide();
  $('#success').ready(function(){
    setTimeout(function(){
      $('#success').remove();
    },4000);
  });
  getLanguageInfo();
  // setInterval(function(){
  //   getLanguageInfo();
  // },15000);
});

$('#pageCreateButton').click(function(){
  var translateWord = $('#word_key').val();
  var translated = $('#translated').val();
  var langId = $('#language_id').val();
        $.ajax({
          type:'POST',
          url:'{{ route('addWordToTranslate') }}',
          data:{
            _token:"{{csrf_token()}}",
            'translate_word_id':translateWord,
            'translated_word':translated,
            'language_id':langId
          },
          success:function(){
            alert('წარმატებულად დაემატა!');
            getLanguageInfo();
          }
        }).fail(function(){
            alert('შეავსეთ მონაცემები!');
        });
});

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
function getLanguageInfo() {
  $.ajax({
    type:'GET',
    url:'{{ route('getTranslated') }}',
    data:{
      _token:"{{csrf_token()}}",
    },
    success:function(data){
      $('#translatedOutput').html(data);
    }
  }).fail(function(){
      alert('თქვენი მოთხოვნა ვერ შესრულდა გთხოვთ მიმართოთ საბას:)))!');
  });
}

	</script>
@endsection
