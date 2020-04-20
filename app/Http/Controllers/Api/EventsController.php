<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\Events;
use App\Api\Event_imgs;
use Illuminate\Support\Facades\Input;
class EventsController extends Controller
{
    function __construct(){
        return $this->middleware('auth:api');
    }
    public function storeEvent(Request $request){
    	$this->validate($request,[
    		"title_ge"=>"required|string|max:256",
    		"title_ru"=>"required|string|max:256",
    		"title_en"=>"required|string|max:256",
    		"title_ch"=>"required|string|max:256",
    		"description_ge"=>"required|string|max:1024",
    		"description_en"=>"required|string|max:1024",
    		"description_ru"=>"required|string|max:1024",
    		"description_ch"=>"required|string|max:1024",
    		"city_id"=>"required|numeric",
    		"valute_id"=>"required|numeric",
    		"price"=>"required|numeric|between:0,99999.99",
    		"time"=>"required|numeric",
    		"time_type_id"=>"required|numeric", 
    		"show_bookmark"=>"required|numeric|min:0|max:1", 
    		"book_mark_link"=>'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
    		'photo.*' => "image|mimes:jpeg,png,jpg"
    	]);
    	$events=new Events;
    	$events->title_ge=$request->input("title_ge");
    	$events->title_ru=$request->input("title_ru");
    	$events->title_en=$request->input("title_en");
    	$events->title_ch=$request->input("title_ch");
    	$events->description_ge=$request->input("description_ge");
    	$events->description_en=$request->input("description_en");
    	$events->description_ru=$request->input("description_ru");
    	$events->description_ch=$request->input("description_ch");
    	$events->country_id=$request->input("city_id");
    	$events->valute_id=$request->input("valute_id");
    	$events->price=$request->input("price");
    	$events->time=$request->input("time");
    	$events->time_type_id=$request->input("time_type_id");
    	$events->show_bookmark=$request->input("show_bookmark");
    	$events->book_mark_link=$request->input("book_mark_link");
    	$event_id=$events->id;
    	$events->save();
    	$destinationPath = public_path('uploads/events');
    	$extension = "jpg";
    	$counter=0;
    	foreach (Input::file('photo') as $photo) {
    		$uniqid=time().uniqid();
    		$fileName = $uniqid.'.'.$extension;
    		Input::file('photo')->move($destinationPath, $fileName);
    		$counter+=1;
    		$photos=new Event_imgs;
    		$photos->$fileName;
    		$photos->$event_id."/".$fileName;
    		$photos->save();
    		if ($counter>=10) {
    			break;
    		}
    	}

    }
}
