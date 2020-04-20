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