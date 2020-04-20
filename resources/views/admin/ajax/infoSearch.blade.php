@foreach ($search as $logs)                                	
    <tr>
	   <td>{{ $logs->name }}</td>
	   @if ($logs->crud_type == 'წაიშალა')
	   	<td style="color:darkred;">{{ $logs->crud_type }}</td>
	   @elseif($logs->crud_type == 'შეიქმნა')
	   	<td style="color:darkgreen;">{{ $logs->crud_type }}</td>
	   @elseif($logs->crud_type == 'შეიქმნა/განახლდა')
	   	<td style="color:darkorange;">{{ $logs->crud_type }}</td>
	   @else
	   	<td>{{ $logs->crud_type }}</td>
	   @endif
	   <td>{{ $logs->info_was }}</td>
	   <td>{{ $logs->info_is }}</td>
	   <td><strong>{{ $logs->created_at->diffForHumans() }}</strong></td> 
    </tr>
@endforeach