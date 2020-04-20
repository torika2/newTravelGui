@extends('admin.adminLayout')

@section('main')

<div class="card shadow mb-4">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">პროფილის ინფორმაცია</h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('uploadPhoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                   <div class="col-md-6">
                        <input type="file" name="image_input" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">ატვირთვა</button>
                    </div>
                </form>
            </div>
            <div class="row">
                @if ($profileImage)   
                <div class="grid-container">               
                    @foreach ($profileImage as $profileImages)
                        <div class="grid-item">
                            @if ($profileImages->equiped == 1)
                            <a href="javascript:void(0)">   
                                <img height="120" style="text-align: center;z-index: -1;border:solid 1px black;" src="{{asset($profileImages->image_url)}}" class="thumb-lg img-circle" alt="img">
                            </a>
                            @else
                            <a href="javascript:void(0)">
                                <img height="120" style="text-align: center;z-index: -1;" src="{{asset($profileImages->image_url)}}" class="thumb-lg img-circle" alt="img">
                            </a>   
                            @endif
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div style="width: 50%;margin:auto;">
<form  method="POST" class="form-group" action="{{ route('addAdminProfileInfo') }}">
                    @csrf
                                <div class="form-group">
                                    <label for="forInputName" class="col-md-12">სახელი</label>
                                    <input id="forInputName" class="form-control" type="text" placeholder="{{\Auth::user()->name}}" class="form-control form-control-line" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="forInputLastname" class="col-md-12">გვარი</label>
                                        <input id="forInputLastname" class="form-control" type="text" placeholder="{{\Auth::user()->lastname}}" class="form-control form-control-line" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="forInputLastname" class="col-md-12">მოკლე სახელი</label>
                                        <input id="forInputLastname" class="form-control" type="text" placeholder="{{\Auth::user()->nickname}}" class="form-control form-control-line" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">ფოსტა</label>
                                        <input class="form-control" type="email" name="profile_email" placeholder="{{\Auth::user()->email}}" class="form-control form-control-line"  id="example-email" disabled>
                                </div>
                                @if (App\UserInfo::where('user_id',Auth::user()->id)->count() == 0)
                                    <div class="form-group">
                                        <label class="col-md-12">მობილურის ნომერი</label>
                                            <input class="form-control" type="text" name="profile_mobile" placeholder="მობილურის ნომერი" value="{{ old('profile_mobile') }}" class="form-control form-control-line" min="9" max="9"> 
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">დაბადების თარიღი</label>
                                        <input type="date" value="{{ old('profile_date') }}" name="profile_date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">აირჩიეთ ქვეყანა</label>
                                            <select class="form-control" name="profile_country">
                                                <option value="საქართველო">საქართველო</option>
                                                <option value="ლონდონი">ლონდონი</option>
                                                <option value="აშშ">აშშ</option>
                                                <option value="კანადა">კანადა</option>
                                                <option value="ტაილანდი">ტაილანდი</option>
                                                <option value="რუსეთი">რუსეთი</option>
                                            </select>
                                    </div>
                                @endif
                                @foreach (App\UserInfo::where('user_id',Auth::user()->id)->get() as $user_info)
                                    <div class="form-group">
                                        <label class="col-md-12">მობილურის ნომერი</label>
                                            <input class="form-control" type="text" name="profile_mobile" placeholder="{{ $user_info->phone }}" class="form-control form-control-line" min="9" max="9"> 
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class="col-md-12">გზავნილი</label>
                                            <textarea class="form-control" name="profile_desc" rows="5" class="form-control form-control-line"></textarea>
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="col-md-12">დაბადების თარიღი</label>
                                        <input type="date" value="{{ $user_info->birth_date }}" name="profile_date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">აირჩიეთ ქვეყანა</label>
                                            <select class="form-control" name="profile_country">
                                                <option>{{ $user_info->country }}</option>
                                                <option value="საქართველო">საქართველო</option>
                                                <option value="ლონდონი">ლონდონი</option>
                                                <option value="აშშ">აშშ</option>
                                                <option value="კანადა">კანადა</option>
                                                <option value="ტაილანდი">ტაილანდი</option>
                                                <option value="რუსეთი">რუსეთი</option>
                                            </select>
                                    </div>
                                 @endforeach
                                <div class="form-group">
                                    <label class="col-md-12">დამცავი კოდი (პაროლი)</label>
                                        <input class="form-control" id="pass"type="password" style="border:solid 1px grey " name="profile_password" placeholder="....." class="form-control form-control-line" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-warning">პროფილის განახლება</button>
                                </div>
                            </form>
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger"> 
            @foreach ($errors->all() as $error)
               <li>{{$error}}</li>
            @endforeach    
            
        </div> 
    @endif

                            </div>
@endsection                   
