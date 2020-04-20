@extends('admin.adminLayout')

@section('main')
<style type="text/css">
    #pageCreateButton:hover{
       border: solid 1px grey;
       background: darkgrey;
       color: white;
    }
</style>
	<div id="page-wrapper">
	            <div class="container-fluid">
	                <div class="row bg-title">
	                <!-- /row -->
<div class="card shadow mb-4">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">გვერდის შექმნა</h6>
    </a>
    <div class="collapse hide" id="collapseCardExample">
        <div class="card-body">
            <div class="row">
                @if($errors->any())
                <div class="alert alert-danger">
                  @foreach ($errors->all() as $error)      
                    <li>{{$error}}</li>
                  @endforeach
                </div>
                @endif
            </div>
            <div class="row">
                <form  action="{{ route('createPage') }}" method="POST">
                    @csrf
                    <div>
                        <label><b>გვერდის სახელი :</b></label>
                        <input style="border-radius: 5px;" class="form-control" placeholder="პირველი გვერდი." type="search" name="page_name" value="{{ old('page_name') }}" required="required">
                    </div><br>
                    <div>
                        <label><b>გვერდის შესაფერისი პარამეტრი (params) :</b></label>
                        <input style="border-radius: 5px;" class="form-control" type="text" placeholder="პირველი გვერდისთვის : get_first_frame" value="{{ old('params') }}" name="params" required="">
                    </div><br>
                    <div>
                        <label><b>გვერდის აღწერა :</b></label>
                        <input style="border-radius: 5px;" class="form-control" type="text" placeholder="ამ გვერდზე განთავსებულია სარეგისტრაციო ფორმა." value="{{ old('page_desc') }}" name="page_desc" required="required">
                    </div><br>
                    <div>
                        <button onclick="return confirm('შეიქმნას გვერდი ?')" class="btn btn-primary" id="pageCreateButton"> თანხმობა </button>
                    </div>
                </form>
                @if($errors->any())
                <div class="alert alert-danger">
                  @foreach ($errors->all() as $error)      
                    <li>{{$error}}</li>
                  @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <a class="d-block card-header py-3">
        <h6 class="m-0 font-weight-bold text-secondary">გვერდები</h6>
    </a>
        <div class="card-body">
            <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><b>სახელი</b></th>
                                    <th>აღწერა</th>
                                    <th>პარამეტრები(params)</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($frames as $frame)
                                        <tr>
                                            <td>
                                                {{$frame->name}}
                                            </td>
                                            <td>
                                                {{$frame->description}}
                                            </td>
                                            <td>
                                                {{$frame->params}}
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('frameEdit') }}">
                                                    @csrf
                                                    <input type="hidden" name="params" value="{{ $frame->params }}">
                                                    <button class="btn btn-primary">></button>
                                                </form>
                                            </td>
                                                {{-- <td>
                                                    <form method="POST" action="{{ route('deletePage') }}">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="params" value="{{ $frame->params }}">
                                                        <button style="background: darkred;border:none;border-radius: 5px;" onclick="return confirm('დარწმუნებული ხარ? გვერდის წაშლის შემთხვევაში წაიშლება ყველაფერი რა ინფორმაციასაც გვერდი შეიცავდა!')" class="btn btn-danger">წაშლა</button>
                                                    </form>
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
            </div>
        </div>
</div>
</div>
                    
@endsection
