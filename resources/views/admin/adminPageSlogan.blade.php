@extends('admin.adminLayout')
@section('main')
<div class="card shadow mb-4" style="margin:auto;width:80%;">
    <a href="#sloganCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="sloganCardExample" style="text-align: center;">
        <h6 class="m-0 font-weight-bold text-primary">Slogan</h6>
    </a>
  <div class="collapse show" id="sloganCardExample">
    <div class="card-body">
      {{-- <div class="row"> --}}
        @if ($languages->count() > 0 && $frames->count() > 0)
        <form  action="{{ route('pageSloganCreate') }}" method="POST" style="margin:auto;" enctype="multipart/form-data">
          @csrf
            <select name="params" class="form-control col-md-4">
            @foreach($frames as $frame)
                <option value="{{$frame->params}}">{{$frame->name}}</option>
            @endforeach
            </select>
{{--             <div id="grid-container" > --}}
          <div class="row mt-3">
            @foreach ($languages as $language)
          {{-- <div id="grid-item"style="font-size: 15px;display: inline-block;"> --}}
            <div class="col-md-4">
          <div>
            <label class="ml-2"><b>slogan : {{ $language->language_short_name }}</b></label>
            <input style="border-radius: 5px;" class="form-control" type="text" value="{{ old('slogan_title') }}" name="slogan_title[]" required="required">
          </div>
          <div>
            <input type="hidden" value="{{ $language->id }}"  name="language_id[]">
          </div>
          </div>
          {{-- </div> --}}
         @endforeach
        </div>
         {{-- </div> --}}
          <br>
          <div>
            <button class="btn btn-success" id="" style="display:block;margin:auto;">Save</button>
          </div>
        </form>
      @else
        <h6 style="text-align: center;">შექმენით გვერდი და ენა რომ გამოგიჩნდეთ შესავსები ფორმა!</h6>
      @endif
      </div>
      {{-- <div class="row"> --}}
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>slogan</th>
                <th>language</th>
                <th>page name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($slogans as $slogan)
                 <tr>
                    <td>
                      {{$slogan->id}}
                    </td>
                    <td>
                      <div class="form-group">
                    <form action="{{ route('editPageSlogan') }}" method="POST">
                      @csrf
                        <input type="text" class="form-control" style="width: 90%;" name="edited_slogan" value="{{ $slogan->page_slogan }}" />
                        <input type="hidden" value="{{ $slogan->page_slogan_id }}" name="slogan_id">
                      </div>
                    </td>
                    <td>
                        <label>{{$slogan->language_short_name}}</label>
                    </td>
                    <td>
                      {{$slogan->name}}
                    </td>
                    <td>
                      <button class="btn btn-warning">Update</button>
                    </td>
                  </tr>
                </form>
                @endforeach
            </tbody>
          </table>
        </div>
      {{-- </div> --}}
    </div>
  </div>
</div>
@endsection