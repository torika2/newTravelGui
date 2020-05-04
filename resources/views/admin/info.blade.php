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
          <p class="mb-4">{{ __('admin_home.info_page_title') }}</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">{{ __('admin_home.info_page_info_bool') }}</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><b>{{ __('admin_home.info_page_name') }}</b></th>
                      <th>{{ __('admin_home.info_page_category') }}</th>
                      <th>{{ __('admin_home.info_page_info_bool') }} (<code>{{ __('admin_home.info_page_info_was') }}</code>)</th>
                      <th>{{ __('admin_home.info_page_info_bool') }} (<code>{{ __('admin_home.info_page_info_is') }}</code>)</th>
                      <th>{{ __('admin_home.info_page_created_at') }}</th>
                    </tr>
                  </thead>
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
				