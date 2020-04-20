@extends('admin.adminLayout')

@section('main')
    <div class="card shadow mb-4" style="width: 95%;margin:auto;">
    <a  class="d-block card-header py-3" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-secondary">ღონისძიების შექმნა</h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
                <form action="{{ route('createEvent') }}" class="form-group" method="POST">
                    @csrf
                    <div>
                        <input type="text" placeholder="ღონისძიების სახელი.." class="form-control {{ $errors->has('event_name') ? 'alert-danger' : '' }}" name="event_name" value="{{ old('event_name') }}">
                    </div> 
                    <br>
                    <div>
                        <input type="number" min="20" max="2000" step="1" placeholder="ღონისძიების ფასი,მაგალითად 50ლ" class="form-control {{ $errors->has('event_price') ? 'alert-danger':'' }}" name="event_price" required="required" value="{{ old('event_price') }}">
                    </div>
                    <br>
                    <div>
                        <input min="5" placeholder="მონაწილეთა რაოდენობა.." class="form-control {{ $errors->has('event_member_size') ? 'alert-danger':'' }}" type="number" name="event_member_size" step="1" required="required" value="{{ old('event_member_size') }}">
                    </div>
                    <br>
                    <div>
                        <textarea name="event_description" class="form-control {{ $errors->has('event_description') ? 'alert-danger':'' }}" placeholder="ღონისძიების აღწერა..." style="max-height: 20%;max-width: 100%;min-height: 10%;min-width: 100%">{{ old('event_description') }}</textarea>
                    </div>
                    <br>
                    <div>
                        <button class="btn btn-primary">დაეთანხმეთ შექმნას</button> 
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
<div class="table-responsive">
<table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ღონისძიების სახელი</th>
                                            <th>აღწერა</th>
                                            <th>მონაწილეები</th>
                                            <th>ფასი თითო ადამიანზე</th>
                                            <th>კომენტარი</th>
                                            <th>გაზიარება</th>
                                            <th>მოწონება</th>
                                            <th>არ მოსწონს</th>
                                            <th>სურათები</th>
                                            <th>შექმნის დრო</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablssss">
                                        @foreach ($event as $events)
                                            <tr>
                                                <td>{{$events->tour_id}}</td>
                                                <td>{{$events->tour_name}}</td>
                                                <td>{{$events->description}}</td>
                                                <td>{{$events->limited_member}}</td>
                                                <td>{{$events->tour_price}}$</td>
                                                <td>{{ App\TourReviews::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{ App\UserTourShare::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{ App\TourLikes::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{ App\TourUnlike::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{App\TourImageSorter::where('tour_id',$events->tour_id)->count()}}</td>
                                                @php
                                                    $dt = new DateTime('Asia/Tbilisi');
                                                @endphp
                                               <td>{{ $events->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('editEventPage') }}">
                                                        @csrf
                                                        <input type="hidden" name="tour_id" value="{{$events->tour_id}}">
                                                        <button  class="btn btn-primary">></button>
                                                    </form>
                                                </td>
                                                {{-- <td>
                                                    <form method="POST" action="{{ route('deleteEvent') }}">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="tour_id" value="{{$events->tour_id}}">
                                                        <button id="delete" style="background: darkred;border:none;border-radius: 5px;" class="btn btn-danger" onclick="return confirm('დარწმუნებული ხარ? ღონისძიების წაშლის შემთხვევაში წაიშლება ყველაფერი რა ინფორმაციასაც ღონისძიება შეიცავდა!')">წაშლა</button>
                                                    </form>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
@endsection
{{-- <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ღონისძიების სახელი</th>
                                            <th>აღწერა</th>
                                            <th>მონაწილეები</th>
                                            <th>ფასი თითო ადამიანზე</th>
                                            <th>კომენტარი</th>
                                            <th>გაზიარება</th>
                                            <th>მოწონება</th>
                                            <th>არ მოსწონს</th>
                                            <th>სურათები</th>
                                            <th>შექმნის დრო</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablssss">
                                        @foreach ($event as $events)
                                            <tr>
                                                <td>{{$events->tour_id}}</td>
                                                <td>{{$events->tour_name}}</td>
                                                <td>{{$events->description}}</td>
                                                <td>{{$events->limited_member}}</td>
                                                <td>{{$events->tour_price}}$</td>
                                                <td>{{ App\TourReviews::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{ App\UserTourShare::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{ App\TourLikes::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{ App\TourUnlike::where('tour_id',$events->tour_id)->count() }}</td>
                                                <td>{{App\TourImages::where('tour_id',$events->tour_id)->count()}}</td>
                                                @php
                                                    $dt = new DateTime('Asia/Tbilisi');
                                                @endphp
                                               <td>{{ $events->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('editEventPage') }}">
                                                        @csrf
                                                        <input type="hidden" name="tour_id" value="{{$events->tour_id}}">
                                                        <button style="background: orange;border:none;border-radius: 5px;" class="btn btn-warning">ნახვა</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('deleteEvent') }}">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="tour_id" value="{{$events->tour_id}}">
                                                        <button id="delete" style="background: darkred;border:none;border-radius: 5px;" class="btn btn-danger" onclick="return confirm('დარწმუნებული ხარ? ღონისძიების წაშლის შემთხვევაში წაიშლება ყველაფერი რა ინფორმაციასაც ღონისძიება შეიცავდა!')">წაშლა</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <h3 class="box-title">ღონისძიების შექმნა</h3>
                         --}}