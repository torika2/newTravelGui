<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserFollower;
use App\Story;
use App\User;
use App\Lang\Text_filed_value;
use App\Lang\Text_filed;
use App\ApiModels\Storylike;
use App\Api\User_profile;

use App\ApiModels\Favorites;
use App\Http\Controllers\DeleteServiceController;
class UserActionsController extends Controller
{
    function __construct(){
        return $this->middleware('auth:api');
        
    }
    public function SetFollower(Request $request)
    {
    	$this->validate($request,[
    		"owner_id"=>"required|numeric"
    	]);
    	$follower=new UserFollower;
    	$follower->followed_id=$request->input("owner_id");
    	$follower->user_id=$request->user()->id;
    	$follower->save();
    	return json_encode(["errors"=>0],JSON_UNESCAPED_UNICODE);
    }

    public function GetStory(Request $request)
    {
    	$story=Story::where("user_id",$request->user()->id)->get();
    	return json_encode($story,JSON_UNESCAPED_UNICODE);
    }
    public function LikeStory(Request $request)
    {
    	$this->validate($request,[
    		"story_id"=>"required|numeric|min:0",
    		"is_like"=>"required|numeric|min:0|max:1",
    	]);
    	$storylike=new Storylike;
    	$storylike->story_id=$request->input("story_id");
    	$storylike->is_like=$request->input("is_like");
    	$storylike->user_id=$request->user()->id;
    	$storylike->save();
    	return json_encode(["errors"=>0],JSON_UNESCAPED_UNICODE);
    	
    }
    public function MarkFav(Request $request)
    {
    	$this->validate($request,[
    		"user_id"=>"required|numeric|min:0",
    		
    	]);
    	$Favorites=new Favorites;
    	$Favorites->my_fav_is=$request->input("user_id");
    	$Favorites->user_id=$request->user()->id;
    	$Favorites->save();
    	return json_encode(["errors"=>0],JSON_UNESCAPED_UNICODE);
    }
    public function deleteStory(Request $request)
    {
    	$this->validate($request,[
    		"story_id"=>"required|numeric|min:0",
    	]);
    	Story::where("story_id",$request->input("story_id"))->where("user_id",$request->user()->id)->delete();
    	return json_encode(["errors"=>0],JSON_UNESCAPED_UNICODE);
    }
    public function UploadPicture(Request $request)
    {
        $this->validate($request,[
            'photo' => "required|image|mimes:jpeg,png,jpg"
        ]);
        $destinationPath = public_path('uploads/user/profiles');
        $extension = "jpg";
        $uniqid=time().uniqid();
        $fileName = $uniqid.'.'.$extension;
        Input::file('photo')->move($destinationPath, $fileName);
        $user_id=$request->user()->id;
        if(count(User_profile::where("user_id",$user_id)->get())>0){
            $user_img=User_profile::where("user_id",$user_id)->first()['image'];
            try{
                File::delete(public_path('uploads/user/profiles')."/".$user_img);
            }
            catch(Exception $e){
            }
            User_profile::where("user_id",$user_id)->update(["image"=>$fileName]);
            
        }else{
            
            $user_profile=new User_profile;
            $user_profile->user_id=$user_id;
            $user_profile->image=$fileName;
            $user_profile->save();
        }
        return json_encode(["error"=>"0"],JSON_UNESCAPED_UNICODE);


    }
    public function deleteownimage(Request $request)
    {
        /*$user_profile->user_id=$user_id;

        $user_img=User_profile::where("user_id",$user_id)->first()['image'];
        try{
            File::delete(public_path('uploads/user/profiles')."/".$user_img);
        }
        catch(Exception $e){
        }
        User_profile::where("user_id",$user_id)->update(["image"=>NULL]);
        return json_encode(["error"=>0],JSON_UNESCAPED_UNICODE);*/
        $del=new DeleteServiceController;
        return  json_encode($del->deleteownimage($request->user()->id));
            
    }
    public function changeprofile(Request $request){
        $this->validate($request,[
            "bdate"=>"date",/*dd/mm/yy*/
            "gender"=>"numeric|min:0|max:1",
            "country"=>"string",
            "country"=>"string",
            "phone"=>"digits_between:500000000,599999999|numeric",
            "biography"=>"string",
        ]);
        $user_id=$request->user()->id;
        if(count(User_profile::where("user_id",$user_id)->get())>0){
            
            User_profile::where("user_id",$user_id)->update([
                "bdate"=>$request->input("bdate"),
                "gender"=>$request->input("gender"),
                "gender"=>$request->input("gender"),
                "country"=>$request->input("country"),
                "city"=>$request->input("city"),
                "phone_num"=>$request->input("phone_num"),
                "biography"=>$request->input("biography"),

            ]);
        }else{
            User_profile::create([
                "bdate"=>$request->input("bdate"),
                "gender"=>$request->input("gender"),
                "gender"=>$request->input("gender"),
                "country"=>$request->input("country"),
                "city"=>$request->input("city"),
                "phone_num"=>$request->input("phone_num"),
                "biography"=>$request->input("biography"),
                "user_id"=>$user_id,

            ]);
            
        }
        return json_encode(["error"=>0],JSON_UNESCAPED_UNICODE);
    }
    public function getmyprofile(Request $request)
    {
        $user_id=$request->user()->id;
        $userinfo=User::select("username","lastname","email","nickname","bdate","gender","country","city","phone_num","biography")->where("id",$user_id)->join("user_profiles","user_id","id")->get();
        if (!count($userinfo)>0) {
            $userinfo=User::select("username","lastname","email","nickname")->where("id",$user_id)->get();
        }
        return json_encode($userinfo,JSON_UNESCAPED_UNICODE);
        
    }
    public function getstrangerprofileinfo(Request $request)
    {
        $this->validate($request,[
            "user_id"=>"required|numeric",
        ]);
        $user_id=$request->input("user_id");
        $userinfo=User::select("username","lastname","email","nickname","bdate","gender","country","city","phone_num","biography")->where("id",$user_id)->join("user_profiles","user_id","id")->get();
        if (!count($userinfo)>0) {
            $userinfo=User::select("username","lastname","email","nickname")->where("id",$user_id)->get();
        }
        return json_encode($userinfo,JSON_UNESCAPED_UNICODE);
        
    }
    
    public function languageFrame(Request $request)
    {
        $this->validate($request,[
            "language_id"=>"required|numeric"
        ]);
        $data=array();
        $tf=Text_filed::get();
        
        foreach ($tf as $t) {
            $val=Text_filed_value::where("filed_id",$t["tf_id"])->where("language_id",$request->input("language_id"))->first();
            if ($val!==null) {
                $data[$t['field']]=$val["value"];
            }
            else{
                $data[$t['field']]="not added yet";

            }
        }
        return $data;
    }
    public function GetButtonService(Request $request)
    {
        
    }

}
