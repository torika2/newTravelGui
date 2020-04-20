@extends('admin.adminLayout')

@section('main')
@foreach ($images as $image)
	<div id="page-wrapper">
	            <div class="container-fluid">
	                
	                @if($errors->any())
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)      
        <li>{{$error}}</li>
      @endforeach
    </div>
@endif
	                <!-- /row -->
	                <div class="row">
	                    <div class="col-sm-12">
	                    	<div class="white-box" style="text-align: center;">
	                    		<p>Choosen Picture</p>
	                    		<img style="box-shadow: 5px 5px 5px 0px;" height="200" src="{{ asset($image->link) }}">
                                <hr>
                                <form action="{{ route('frameImageSizing') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="image_id" value="{{ $image->bg_id }}">
                                    <input type="hidden" name="params" value="{{ $image->params }}">
                                    <input type="hidden" name="image_url" value="{{ $image->link }}">
                                    <input type="hidden" name="image_name" value="{{ $image->image_name }}">
                                    <div>
                                        <label>სურათის სიმაღლე :</label>
                                        <input type="number" name="image_height" required/>
                                    </div>
                                    <div>
                                        <label>სურათის სიგანე :</label>
                                        <input type="number" name="image_width" required/>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning">შექმენი სასურველი სურათის ზომა</button>
                                    </div>
                                </form>
                                <hr>
	                    	</div>
	                        <div class="white-box">
	                        	<div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><b style= "color:orange;">სურათების რაოდენობა({{$imageSize->count()}})</b></th>
                                            <th>სურათის სიმაღლე</th>
                                            <th>სურათის სიგანე</th>
                                        </tr>
                                    </thead>
                                     @foreach ($imageSize as $imageSizes)     
                                    	<tbody>
                                                             
	                                           <td>
                                                <img src="{{ asset($imageSizes->image_url) }}">   
                                               </td>
                                                <td>
                                                    {{$imageSizes->image_height}}
                                                </td>
                                                <td>
                                                    {{$imageSizes->image_width}}
                                                </td>
                                           
                                    	</tbody>
                                         @endforeach
                                </table>
                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!-- /.row -->
	            </div>
 @endforeach
@endsection
				