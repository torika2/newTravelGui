@foreach ($color as $colors)
    <div class="col-lg-6 mb-4">
      <div style="background: {{$colors->color}};" class="card text-white shadow">
        <div class="card-body">
        @if ($colors->color != '#ffffff')
          {{$colors->params}}
           	@if ($colors->equiped)
            	<div class="text-white-55 small" >{{$colors->color}} </div>
            	<div style="background: white;text-align: center;width:40%;border-radius: 3px;box-shadow: 5px 5px 5px black;background: gold;">
            		<code>choosen</code>
            	</div>
        @else
          	<div class="text-white-55 small">{{$colors->color}}</div>
        @endif

        @else
            <b style="color: black">{{$colors->params}}</b>
          @if ($colors->equiped)
          	<div class="text-white-55 small" >{{$colors->color}}</div>
          	<div style="background: white;text-align: center;width:40%;border-radius: 3px;background: gold;box-shadow: 5px 5px 5px black;">
            		<code>choosen</code>
            	</div>
          @else
          <div class="text-white-55 small" style="color: black;">{{$colors->color}}</div>
          @endif
        @endif
         @if ($color->count() > 1)
          <form action="javascript:void(0);">
            <input type="hidden" name="params" value="{{ $colors->params }}" id="colorParams{{ $colors->color_id }}">
            <button class="btn btn-danger" onclick="colorDelete({{ $colors->color_id }})">delete</button>
          </form>
          @endif
        </div>
      </div>
    </div>
<script>
function colorDelete(id) {
  if(confirm('დარწმუნებული ხართ?')){
    var params = $('#colorParams{{ $colors->color_id }}').val();
  $.ajax({
    type:'POST',
    url:'{{ route('deleteColor') }}',
    data:{
      _token:'{{ csrf_token() }}',
      'color_id':id,
      'params':params
    },
    success:function(){
      getPageColor();
    }
  }).fail(function(){
    console.log('something get wrong route=deleteColor');
  });  
}
}
</script>
@endforeach

