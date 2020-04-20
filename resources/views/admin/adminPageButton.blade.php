@extends('admin.adminLayout')

@section('main')
 <div class="card shadow mb-4" style="margin:auto;width:80%;">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample" style="text-align: center;">
        <h6 class="m-0 font-weight-bold text-primary">ღილაკის დამატება</h6>
    </a>
  <div class="collapse show" id="collapseCardExample">
    <div class="card-body">
      <div class="row">
        <form id="createPageButton" action="javascript:void(0);" style="margin:auto;">
          @csrf
          <div>
            <label><b>სათაური :</b></label>
            <input style="border-radius: 5px;" class="form-control" type="text" value="{{ old('button_title') }}" name="button_title" required="required">
          </div><br>
          <div>
            <label><b>სურათის ლინკი :</b></label>
            <input style="border-radius: 5px;" id="imageInput" class="form-control" accept=".svg" type="file" name="button_image" required="required">
            <img class="file-upload-image" id="yourImage" height="100" src="#">
          </div>
            <br>
            <div>
            	<label><b>გვერდის სახელი:</b></label><br>
            	<select name="params">
            		@foreach ($frames as $frame)
            			<option value="{{ $frame->params }}">{{ $frame->name }}</option>
					@endforeach
            	</select>
            </div>
            <br>
          <div>
            <button onclick="return confirm('Are you sure ?')" class="btn btn-primary">თანხმობა</button>
          </div>
        </form>
      </div>
      <br>
      <div class="row">
        <div class="table-responsive">
          <table class="table">
            
            <thead>
              <tr>
                <th>#</th>
                <th>სახელწოდება</th>
                <th>გვერდის სახელი</th>
                <th>სურათი</th>
              </tr>
            </thead>
            <tbody id="pageButtonOutput">
              
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
	getAllButtons();
$('#yourImage').hide();
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
$('#createPageButton').on('submit',function(){
  var data = new FormData($('#createPageButton')[0]);
  $.ajax({
    type:'POST',
    url:'{{ route('createPageButton') }}',
    enctype: 'multipart/form-data',
    processData: false,
    contentType: false,
    cache: false,
    data:data,
    success:function(){
      getAllButtons();
    }
  }).fail(function(){
    console.log('something went wrong route=createPageButton!');
  });
});
function getAllButtons(){
   $.ajax({
    type:'GET',
    url:'{{ route('getPageButtons') }}',
    success:function(data){
      $('#pageButtonOutput').html(data);
       $('#yourImage').hide();
    } 
  }).fail(function(){
    console.log('failed/route=getAllButtons');
  }); 
}
</script>
@endsection