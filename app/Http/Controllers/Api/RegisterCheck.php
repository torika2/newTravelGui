<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class RegisterCheck extends Controller
{
    
	public function isunique($nickname)
	{
		if (count(User::where("nickname",$nickname)->get())>0) {
    		return false;

    	}
    	return true;
	}
	public function generateNickname($name,$surname,
		$nickname){
		$vars=[
			$name.$surname,
			$nickname.mt_rand(0,100),
			$nickname."_".mt_rand(0,1000),
			$name.".".$surname,
			$name[0].$surname,
			$name[0].".".$surname,
			$name.$surname[0],
			$name.".".$surname[0],
			$name[0].$surname.mt_rand(0,999),
			$name[0].$surname.mt_rand(0,999),
			$name[0].$surname.mt_rand(0,999),
			$name[0].$surname.mt_rand(0,999),
			$name[0].$surname.mt_rand(0,999),
			$name[0].$surname.mt_rand(0,999),
			$name[0].$surname.mt_rand(0,999),
			$name[0].$surname.mt_rand(0,999),

		];
		$av_nicks=[];
		$c=0;
		foreach ($vars as $nicktooffer) {
			if ($this->isunique($nicktooffer)) {
				$c+=1;
				$av_nicks[$c]=$nicktooffer;
			}
		}
		return$av_nicks;
	}
    public function checknickname(Request $request)
    {
    	$this->validate($request,[
    		"nickname"=>"required|string|max:16",
    		"name"=>"required|string|max:16",
    		"surname"=>"required|string|max:26",

    	]);
    	$data=[];
    	$nickname=$request->input("nickname");
    	$name=$request->input("name");
    	$surname=$request->input("surname");
    	if (!$this->isunique($nickname)) {
    		$data["error"]=["status"=>1,"message"=>"user aready exsists"];
    		$data["nicknames_to_offer"]=$this->generateNickname($name,$surname,$nickname);
    		

    	}
    	else{

    		$data["error"]=["status"=>"0","message"=>"username is free"];    		
    	}
    	return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function Registration(Request $request)
    {
    	$this->validate($request,[
    		"nickname"=>"required|string|max:16",
    		"name"=>"required|string|max:16",
    		"surname"=>"required|string|max:26",
    		'img' => "required|image|mimes:jpeg,png,jpg", 
    		'email' => "required|string|email|max:255",
    		"phone"=>"required|digits_between:500000000,599999999|numeric",
    		'password' => "required|string|min:8|confirmed",
    	]);
    	$destinationPath = public_path('uploads/users/photos');
        $uniqid=time().uniqid();
        $extension = "jpg";
        $fileName = $uniqid.'.'.$extension;
        Input::file('photo')->move($destinationPath, $fileName);
        $nuser=new User;
        $nuser->name=$request->input("name");
        $nuser->surname=$request->input("surname");
        $nuser->nickname=$request->input("nickname");
        $nuser->email=$request->input("email");
        /*$nuser->phone=$request->input("phone");*/
        $nuser->password=bcrypt($request->input("password"));
        /*$nuser->img=$request->input("img");*/
        $nuser->save();
        return json_encode(["error"=>0],JSON_UNESCAPED_UNICODE);
    }
    public function checkemail(Request $request){
    	$this->validate($request,[
    		'email' => "required|string|email|max:255",
    	]);
    	$isexsists=0;
    	if (count(User::where("email",$request->input("email"))->get())>0) {
    		$isexsists=124;

    	}

    	return json_encode(["error"=>$isexsists],JSON_UNESCAPED_UNICODE);
    }
}
