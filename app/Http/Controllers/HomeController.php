<?php

namespace App\Http\Controllers;
use App\Api\Story_album;
use App\version;
use App\Story;
use Illuminate\Http\Request;
/*use input;*/
use Auth;
use Image;
use Illuminate\Support\Facades\Input;
class HomeController extends VersionController
{

    function __construct(){

        return $this->middleware('auth:api');

    }
    public function get_first_frame()
    {
        $ver = new VersionController();
        $color = new ColorController();
        $image = new ImageController();
        $text = new TextController();
        // $data2 = json_decode(file_get_contents('php://input'),true);
        $data = [
                'params' => [
                    'logo_link' => $image->get_image('get_first_frame_logo'),
                        // POST REQUEST
                    // 'old_version' => $data2['params']['version'],
                    'bg_link'  => $image->get_image('get_first_frame'),
                    'slogan'   => $text->get_text('get_first_frame_slogan',1),
                    'bg_color' => $color->get_color('get_first_frame'),
                    'Version'  => $ver->get_version('get_first_frame')
                ]
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
    public function index(Request $request){
        $data=[
            $request->user()->id];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function video(Request $request){
        if (Input::file('video')) {
            $this->validate($request,[
                'video' => 'mimes:mp4,mov,ogg,qt,webm',            
            ]); 
            /*generating unique video name and stores it with clients original extenstion*/
            $destinationPath = public_path('uploads/videos');
            $extension = Input::file('video')->getClientOriginalExtension();
            $uniqid=uniqid();
            $fileName =$uniqid .'.'.$extension;
            Input::file('video')->move($destinationPath, $fileName);
            /*creating MKV sequences*/
            exec(public_path().'\ffmpeg\bin\ffmpeg.exe -hide_banner  -err_detect ignore_err -i "'.public_path()."\\uploads\\videos\\".$fileName.'" -r 24 -codec:v libx264  -vsync 1  -codec:a aac  -ac 2  -ar 48k  -f segment   -preset fast  -segment_format mpegts  -segment_time 10 -force_key_frames  "expr: gte(t, n_forced * 0.5)" '.public_path()."\\uploads\\videos\\".$uniqid.'%d.mkv');
            $videos=[];
            /*checking how many sequencs has been created*/
            for ($i=10; $i >=0 ; $i--) { 
                if(file_exists(public_path()."\\uploads\\videos\\".$uniqid.''.$i.'.mkv')){
                    for($j=0;$j<=$i;$j++){
                        /*converting mkvs to mp4*/
                        exec(public_path().'\ffmpeg\bin\ffmpeg.exe'.' -i '.public_path().'\\uploads\\videos\\'.$uniqid.''.$j.'.mkv -codec copy '.public_path().'\\uploads\\videos\\'.$uniqid.$j.'".mp4"');
                        /*deleting converted MKV files*/
                        unlink(public_path().'\\uploads\\videos\\'.$uniqid.''.$j.'.mkv');
                        /*pushs destination of videos*/
                        array_push($videos,asset("/uploads/videos/")."/".$uniqid.''.$j.'.mp4');
                    }
                    break;
                }
            }
            $data=["videos"=>$videos];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        else{
            return 1;   
        }
    }
    
    public function photo(Request $request){
       if (Input::file('photo')) {
            $this->validate($request,[
                'photo' => "image|mimes:jpeg,png,jpg,gif,svg",            
            ]); 
            /*uploading photo end generating unique name*/
            $destinationPath = public_path('uploads/photos');
            $uniqid=uniqid();
            $extension = "jpg";
            $fileName = $uniqid.'.'.$extension;
            Input::file('photo')->move($destinationPath, $fileName);
            /* end uploading photo*/
            $data=[];
            /* thumbnails resolutions $arr*/



            $arr=["1920X1280","1600x960","960x640","480x800","480x320","320x240" ];
            $photos_arr=[];
            /* craeteing thumbnails*/
            foreach ($arr as $resolution) {
                $destinationPath = public_path('\\uploads\\photos');
                $imagelocation=public_path('\\uploads\\photos\\'.$fileName);
                $img = Image::make($imagelocation);

                $resolutions=explode("x", $resolution);
                $width=(int)$resolutions[0];
                $height=(int)$resolutions[1];
                $img->resize($height,$height , function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'\\'.$uniqid."_".$resolution.".jpg");
                array_push($photos_arr, asset("uploads/photos".$uniqid."_".$resolution.".jpg"));
            }
            $data=["images"=>$photos_arr ];
            return json_encode($data,JSON_UNESCAPED_UNICODE); 
        }
        else{

        }
        
    }
    public function createclip(Request $request){
        if (Input::file('photo')) {
            $this->validate($request,[
                'photo.*' => "|image|mimes:jpeg,png,jpg",
                "event_id" =>"numeric",
            ]); 
            /*uploading photo end generating unique name*/
            $new=new Story;
            $new->user_id=$request->user()->id;
            
            $new->event_id=$request->input("event_id");
            $new->save();
            $story_id=$new->id;
            $destinationPath = public_path('uploads/photos');
            $extension = "jpg";
            $counter=0;
            $data=[
                "video"=>[
                    ]
            ];
            $musicname=uniqid().".mp3";
            exec(public_path().'\uploads\photos\rapidapi.exe --track=1109731 --name='.public_path()."\uploads\photos\\".$musicname);
            foreach (Input::file('photo') as $photo) {
                $uniqid=uniqid();
                $fileName = $uniqid.'.'.$extension;

                $photo->move($destinationPath, $fileName);
                $uniqid=time().uniqid();
                $filedestination=public_path().'\uploads\photos'."\\".$fileName;
                exec(public_path().'\ffmpeg\bin\ffmpeg.exe -i '.$filedestination.' -i '.public_path().'\uploads\photos\\'.$musicname.' -vcodec mpeg4 -ss 0 -t 10 '.public_path('uploads\photos').'\\'.$uniqid.'clip.mp4');
                array_push($data["video"], public_path('uploads\photos').'\\'.$uniqid.'clip.mp4');

                /*save story*/
                $story=new Story_album;
                $story->content_link=public_path('uploads\photos').'\\'.$uniqid.'clip.mp4';

                $story->user_id=$request->user()->id;
                $story->story_id=$story_id;

                $story->save();
                if ($counter>=10) {
                    break;
                }
            }
            
            
            /*return video links*/
            return json_encode($data);
            
        }
        else{
            return 1;
        }
    }
    
}


