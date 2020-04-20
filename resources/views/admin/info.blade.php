@extends('admin.adminLayout')

@section('main')
@if($errors->any())
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)      
        <li>{{$error}}</li>
      @endforeach
    </div>
@endif
      <div class="container-fluid">

          <!-- Page Heading -->
          <p class="mb-4">როდესაც მომხმარებელი შექმნის/შეცვლის ან წაშლის ინფორმაციას აქ იქნება განთავსებული.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">ინფორმაცია</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><b>სახელი</b></th>
                      <th>კატეგორია</th>
                      <th>ინფორმაცია (<code>იყო</code>)</th>
                      <th>ინფორმაცია (<code>არის</code>)</th>
                      <th>ინფორმაციის შექმნის დრო</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th><b>სახელი</b></th>
                      <th>კატეგორია</th>
                      <th>ინფორმაცია (<code>იყო</code>)</th>
                      <th>ინფორმაცია (<code>არის</code>)</th>
                      <th>ინფორმაციის შექმნის დრო</th>
                    </tr>
                  </tfoot>
                  <tbody>
                     @foreach ($log as $logs)                                 
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

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
@endsection
				