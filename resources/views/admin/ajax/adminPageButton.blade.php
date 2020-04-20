@isset($button)
  @foreach ($button as $buttons)
   <tr>
    <td>
      {{$buttons->button_id}}
    </td>
    <td>
      {{ $buttons->title }}
    </td>
    <td>
      {{ $buttons->name }}  
    </td>
    <td>
      <img height="30" src="{{ asset('pageButtonImages') }}/{{$buttons->img_link}}">
    </td>
    <td>
      <form action="javascript:void(0);">
        @csrf
        <button class="btn btn-danger" onclick="pageButtonDelete({{ $buttons->button_id }})">delete</button>
      </form>
    </td>
    <td>
      @if ($buttons->enable)
        <input type="hidden" value="{{ $buttons->button_id }}" id="button_id{{ $buttons->button_id }}">
        <input type="hidden" id="is_enable{{ $buttons->button_id }}" value="0">
        <button class="btn btn-success" id="buttonIsEnable{{ $buttons->button_id }}" >enable</button>
      @else
        <input type="hidden" value="{{ $buttons->button_id }}" id="button_id{{ $buttons->button_id }}">
        <input type="hidden" id="is_enable{{ $buttons->button_id }}" value="1">
        <button class="btn btn-warning" id="buttonIsEnable{{ $buttons->button_id }}" >disable</button>
      @endif
     
    </td>
  </tr>
<script>
$('#buttonIsEnable{{ $buttons->button_id }}').on('click',function(){
  var button_id = $('#button_id{{ $buttons->button_id }}').val();
  var is_enable = $('#is_enable{{ $buttons->button_id }}').val();
    if(is_enable == 1 || is_enable == 0){
      $.ajax({
      type:'POST',
      url:'{{ route('is_enable') }}',
      data:{
        _token:'{{ csrf_token() }}',
        'is_enable':is_enable,
        'button_id':button_id
      },
      success:function(){
        getAllButtons();
      }
    }).fail(function(){
      console.log('somthing wrong route=buttonIs_enable');
    });
  }else{
    console.log('incorrect ='+is_enable);
  }
});

function pageButtonDelete(id) {
  if(confirm('Delete entry?')){
      $.ajax({
        type:'GET',
        url:'/admin/page/button/delete/'+id,
        success:function(data){
          getAllButtons();
        }
      }).fail(function(){
        console.log('Something Wrong!');
      });
  }
}
</script>
  @endforeach
@endisset