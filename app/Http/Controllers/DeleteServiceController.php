<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\User_profile;

class DeleteServiceController extends Controller
{
    public function deleteownimage($user_id)
    {
      $user_profile=User_profile::where("user_id",$user_id)->first();
     	if ($user_profile===null) {
     		return ["error"=>0];
     		exit();
     	}
    	if (isset($user_profile["image"])) {
    		$user_img=$user_profile['image'];
    		try{
          File::delete(public_path('uploads/user/profiles')."/".$user_img);
        }
        catch(Exception $e){
        }
        User_profile::where("user_id",$user_id)->update(["image"=>NULL]);
    	}
      return ["error"=>0]; 
    }
    public function FunctionName($value='')
    {
      
    }
}
