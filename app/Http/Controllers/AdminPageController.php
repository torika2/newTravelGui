<?php

namespace App\Http\Controllers;
use App\Tour;
use App\User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use Image;
use redirect,input;
use App\UserImage;
use App\TourReviews;
use App\TourReviewlikes;
use App\TourReviewReply;
use App\TourImages;
use App\Logger;
use App\Page;
use App\Color;
use App\BgImage;
use App\ImageCrop;
use App\UserInfo;
use App\Post;
use App\Language;
use App\TourImageSorter;
use App\Lang\Text_filed_value;
use App\Lang\Text_filed;
use App\PageLogo;
use App\PageButton;
use App\PageSlogan;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function testPage()
    {
       return view("admin.image");
    }
    public function testImage(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'w' => 'required|numeric',
            'h' => 'required|numeric',
            'img' => 'required',
        ]);

        $img_r = imagecreatefromjpeg($request->img);        
        $dst_r = imagecreatetruecolor($request->w, $request->h);
        
        $rImg = imagecopyresampled($dst_r, $img_r, 0, 0,$request->x, $request->y, $request->w,$request->h,$request->w,$request->h);

   
        ob_start (); 
            header("Content-type: image/jpeg");
            imagejpeg ($dst_r);
            $image_data = ob_get_contents();
            $img = base64_encode($image_data);
            $image_name = uniqid().time().'bgimage.png';
            \File::put(public_path('pageImages').'/'.$image_name ,base64_decode($img));
        ob_end_clean(); 
            if ($image_name) {
                $makeProfile = BgImage::where('params',$request->input('params'))->where('equiped',1)->update(['equiped' => 0]);
                $bg_image = new BgImage;
                $bg_image->params = $request->params;
                $bg_image->link = 'pageImages/'.$image_name;
                $bg_image->image_name = $image_name;
                $bg_image->equiped = 1;
                $bg_image->save();
            }
        exit();
    }
    public function profile()
    {
        // $commentList = TourReviews::join('users','users.id','=','tour_reviews.user_id')->get();
        $profileImage = UserImage::where('user_id',\auth::user()->id)->orderby('equiped','desc')->get();

        return view('admin.adminProfile',compact('profileImage'));
    }
    public function addAdminProfileInfo(Request $request)
    {
        $this->validate($request,[
            'profile_password' => 'required|string|min:8'
        ]); 
        $pwd = $request->input('profile_password');
        $pwd2 =  \Hash::check($pwd , Auth::user()->password, []);
        if ($pwd == $pwd2) {
            $this->validate($request,[
                'profile_date' => 'required|date',
                // 'nickname' => 'required|string|min:4',
                // 'profile_email' => 'required|email|unique',
                'profile_mobile' => 'required|integer|',
                'profile_country' => 'required|string'
            ]);

            if (UserInfo::where('user_id',Auth::user()->id)->count() == 0) {
               $p = new UserInfo;
               $p->user_id = Auth::user()->id;
               $p->country = $request->input('profile_country');
               $p->birth_date = $request->input('profile_date');
               $p->phone = $request->input('profile_mobile');
               $p->save();
            }else{
                $p =  UserInfo::where('user_id',Auth::user()->id)->update([
                    'birth_date' => $request->input('profile_date'),
                    'phone' => $request->input('profile_mobile'),
                    'country' => $request->input('profile_country')
                ]);
            }
            
            if ($p) {
              return back()->with('success','Successfully updated!'); 
            }else{
                return back();
            }  
        }else{
            return back()->withErrors('დამცავი კოდი არასწორია (password)!');
        }
    }
    function buttonPage()
    {
        $frames = Page::all();
        $button = PageButton::all();

        return view('admin.adminPageButton',compact('frames','button'));
    }
    public function editPageSlogan(Request $request)
    {
        $this->validate($request,[
            'edited_slogan' => 'required|string',
            'slogan_id' => 'required|integer'
        ]);
        
        PageSlogan::where('page_slogan_id',$request->slogan_id)->update(['page_slogan' => $request->edited_slogan]);

        return back();
    }
    public function home()
    {
        // $tourComments = Tour::select('name','lastname','image_url','review_content','tours.tour_id as tour_id','tour_reviews.created_at as created_at')->join('tour_reviews','tours.tour_id','=','tour_reviews.tour_id')->join('users','users.id','=','tour_reviews.user_id')->join('user_images','user_images.user_id','=','tour_reviews.user_id')->where('equiped',1)->get();

        $post = Post::join('users','users.id','=','posts.user_id')->get();

        return view('admin.home',compact('post'));
    }
    public function tourPage()
    {
        $event = Tour::selectRaw('*')->orderBy('created_at','desc')->get();

        return view('admin.event',compact('event'));
    }
    public function searchEvent(Request $request)
    {
        if (empty($request->search)) {
           $event = Tour::selectRaw('*')->orderBy('created_at','desc')->get();
        }else{
            $event = Tour::selectRaw('*')->where('tour_name','like',$request->input('search').'%')->orWhere('description','like',$request->input('search').'%')->orWhere('tour_name','like','%'.$request->input('search').'%')->orWhere('description','like','%'.$request->input('search').'%')->orderBy('created_at','desc')->get();
        }

        return view('admin.ajax.eventSearch',compact('event'));
    }
    public function createEvent(Request $request)
    {

        $this->validate($request,[
            'event_name' => 'required|string|max:255|min:5|max:255',
            'event_price' => 'required|integer|min:20',
            'event_member_size' => 'required|integer|min:5',
            'event_description' => 'required|string|max:255|min:20',
            // 'event_image' => 'required|image|mimes:jpeg,png,jpg'
        ]);
        $checkIfExists = Tour::where('tour_name',$request->input('event_name'))->count();
        if ($checkIfExists == 0) {
            $createEvent = new Tour;
            $createEvent->user_id = Auth::user()->id;
            $createEvent->tour_name = $request->input('event_name');
            $createEvent->tour_price = $request->input('event_price');
            $createEvent->description = $request->input('event_description');
            $createEvent->limited_member = $request->input('event_member_size');
            $createEvent->save();

                if ($createEvent) {
                    $log = new Logger;
                    $log->user_id = Auth::user()->id;
                    $log->info_is = 'ღონისძიების სახელი :'.$request->input('event_name')." | ფასი(თითო ადამიანზე) :".$request->input('event_price')." | აღწერა :".$request->input('event_description')." | ხალხის რაოდენობა :".$request->input('event_member_size');
                    $log->info_was = "არსებობს";
                    $log->crud_type = "შეიქმნა";
                    $log->save();
                }
            }
        return redirect('admin/event');
    }
    public function createPage(Request $request)
    {
        $this->validate($request,[
            'page_name' => 'required|string|min:5|max:255',
            'page_desc' => 'required|string|min:5|max:255',
            'params' => 'required|string'
        ]);

        $checkIfExist = Page::where('params',$request->params)->count();
        if ($checkIfExist == 0) {
            $createPage = new Page;
            $createPage->params = $request->input('params');
            $createPage->name = $request->input('page_name');
            $createPage->description = $request->input('page_desc');
            $createPage->save();

            $color = new Color;
            $color->params = $request->input('params');
            $color->color = '#ffffff';
            $color->save();

            if ($createPage && $color) {
                $log = new Logger;
                $log->user_id = Auth::user()->id;
                $log->info_is = 'გვერდი :'.$request->params.' | ფერი : #ffffff';
                $log->info_was = "არსებობს";
                $log->crud_type = "შეიქმნა";
                $log->save();
            }
        }

         $color = Color::where('params',$request->input('params'))->get();
        $logos = PageLogo::where('params',$request->input('params'))->get();
        $pageImages = BgImage::where('params',$request->input('params'))->get();
            $frames = Page::where('pages.params',$request->input('params'))->get();
            $button = PageButton::where('params',$request->input('params'))->get();

        return view('admin.pageEdit',compact('frames','pageImages','logos','color','button'));
    }
    public function editEventPage(Request $request)
    {
        $this->validate($request,[ 
            'tour_id' => 'required|integer' 
        ]);

        $event = Tour::where('tour_id',$request->input('tour_id'))->get();
        $eventImages = TourImages::join('tour_image_sorters','tour_image_sorters.image_url','=','tour_images.image_url')->where('tour_images.tour_id',$request->input('tour_id'))->where('tour_image_sorters.tour_id',$request->input('tour_id'))->orderBy('image_position','desc')->get();
        $eventReviews = TourReviews::select('name','lastname','review_content','tour_reviews.review_id','tour_reviews.created_at as created_at')->join('users','users.id','=','tour_reviews.user_id')->where('tour_id',$request->input('tour_id'))->get();

        return view('admin.adminEventEdit',compact('event','eventImages','eventReviews'));
    }
    public function sortingEventImages(Request $request)
    {
        $this->validate($request,[
            'image_url' => 'required|string',
            'tour_id' => 'required|integer',
            'image_pos' => 'required|integer'
        ]);
// var_dump(TourImageSorter::where('tour_id',$request->tour_id)->where('image_position',$request->image_pos)->get());
//  var_dump('<br><br>');
// var_dump(TourImageSorter::where('tour_id',$request->tour_id)->where('image_position',$request->image_pos+1)->get());
        if ( $request->input('image_pos') > 0 ) {
            TourImageSorter::where('tour_id',$request->input('tour_id'))->where('image_position',$request->input('image_pos')+1)->decrement('image_position');
            TourImageSorter::where('tour_id',$request->input('tour_id'))->where('image_position',$request->input('image_pos'))->where('image_url',$request->input('image_url'))->increment('image_position');
            $l = $request->input('image_pos')+1;
            $log = new Logger;
            $log->user_id = Auth::user()->id;
            $log->info_is = 'ღონისძიების სურათის ადგილმდებარეობის შეცვლა'.'|'.$request->input('image_pos').'->'.$l;
            $log->info_was = 'ღონისძიების სურათის ადგილმდებარეობის შეცვლა'.'|'.$request->input('image_pos').'->'.$request->input('image_pos');
            $log->crud_type = "განახლება";
            $log->save();

            return 'Loading';
        }else{
            dd(Auth::user()->name.' Meeeh Dont Try Again ;)');
        }

        return 'დაფიქსირდა განსხვავებული მოთხოვნა!';        
    }
    public function deleteReviewReply(Request $request)
    {
       $this->validate($request,[
        'tour_id'           =>  'required|integer',
        'review_id'         =>  'required|integer'
       ]);

       $checkIfDeleted = TourReviews::where('review_id',$request->input('review_id'))->delete();

       if ($checkIfDeleted) {
            TourReviewLikes::where('review_id',$request->input('review_id'))->delete();
            TourReviewReply::where('review_id',$request->input('review_id'))->delete();

            $event = Tour::where('tour_id',$request->input('tour_id'))->get();
            $eventImages = TourImages::join('tour_image_sorters','tour_image_sorters.image_url','=','tour_images.image_url')->where('tour_images.tour_id',$request->input('tour_id'))->where('tour_image_sorters.tour_id',$request->input('tour_id'))->orderBy('image_position','desc')->get();
            $eventReviews = TourReviews::select('name','lastname','review_content','tour_reviews.review_id','tour_reviews.created_at as created_at')->join('users','users.id','=','tour_reviews.user_id')->where('tour_id',$request->input('tour_id'))->get();

            $log = new Logger;
            $log->user_id = Auth::user()->id;
            $log->info_is = 'აღარ არსებობს';
            $log->info_was = 'review_id : '.$request->input('review_id').'|'.'event_id'.$request->input('tour_id');
            $log->crud_type = "წაიშალა";
            $log->save();

            return view('admin.adminEventEdit',compact('event','eventImages','eventReviews'));
       }
        return redirect('admin/event');
    }
    public function editEventImage(Request $request)
    {
            $this->validate($request,[
                'event_image' => 'required|image|mimes:jpeg,png,jpg,svg',
                'tour_id'   => 'required|integer'
            ]);
            if($request->hasFile('event_image')) {
                    $image = uniqid().'.'.$request->file('event_image')->getClientOriginalExtension();
                    $checkImageName = TourImages::where('image_url',$image)->count();
                    if ($checkImageName == 0) {
                            $request->event_image->move(public_path('eventImages'),$image);
                            $filePath = 'eventImages/'.$image;

                            $image = new TourImages;
                            $image->image_url = $filePath;
                            $image->tour_id = $request->input('tour_id');
                            $image->user_id = Auth::user()->id;
                            if ($filePath) {
                                $image->save(); 
                            $check = TourImageSorter::where('tour_id',$request->input('tour_id'))->count();
                            $imageSorter = new TourImageSorter;
                            $imageSorter->tour_id = $request->input('tour_id');
                            $imageSorter->image_url = $filePath;
                            if ($check > 0) {
                                foreach (TourImageSorter::where('tour_id',$request->tour_id)->get() as $val) {
                                    if ($val->image_position != 0 && $val->image_position > 0) {
                                       $imageSorter->image_position = $val->image_position + 1;
                                    } 
                                }
                            }else{
                                $imageSorter->image_position = 1;  
                            }
                            $imageSorter->save();
                                if ($image) {
                                    $log = new Logger;
                                    $log->user_id = Auth::user()->id;
                                    $log->info_is = $filePath;
                                    $log->info_was = "არსებობს";
                                    $log->crud_type = "შეიქმნა";
                                    $log->save();
                                    
                                }
                            } 
                            
                    }


                return 'წარმატებით დაემატა!';
            }  

                return 'დაფიქსირდა არასწორი ფაილი!';
    }
    public function getEventImages(Request $request)
    {
        $this->validate($request,[
            'event_id' => 'required|integer',
            // 'image_id' => 'required|integer'
        ]);

       // $eventImages = TourImages::join('tour_image_sorters','tour_image_sorters.image_url','=','tour_images.image_url')->where('tour_images.tour_id',$request->input('event_id'))->where('tour_images.tour_image_id','>',$request->input('image_id'))->orderBy('image_position','desc')->get();
        $eventImages = TourImages::join('tour_image_sorters','tour_image_sorters.image_url','=','tour_images.image_url')->where('tour_images.tour_id',$request->input('event_id'))->orderBy('image_position','desc')->get();
// return $eventImages;
        $event = Tour::where('tour_id',$request->input('event_id'))->get();
// return $event;
        return view('admin.ajax.adminEventPictureSorting',compact('eventImages','event'));
    }
    public function editEvent(Request $request)
    {
        $this->validate($request,[
            'event_name' => 'required|string|min:5|max:255',
            'event_desc' => 'required|string|min:10|max:255'
        ]);
        
        if (Tour::where('tour_id',$request->tour_id)->count() > 0) {
            foreach (Tour::where('tour_id',$request->tour_id)->get() as $tourInfo) {
                $log = new Logger;
                $log->user_id = Auth::user()->id;
                $log->info_is = 'ღონისძიების სახელი:'.$request->event_name.'|'.'ღონისძიების აღწერა:'.$request->event_desc;
                $log->info_was = 'ღონისძიების სახელი:'.$tourInfo->tour_name.'|'.'ღონისძიების აღწერა:'.$tourInfo->description;
                $log->crud_type = "განახლება";
            }
            $log->save();
             Tour::where('tour_id',$request->tour_id)->update([
                'tour_name' => $request->event_name,
                'description' => $request->event_desc
            ]);
        }

        return redirect()->route('tourPage');
    }
    public function deleteEventImage(Request $request)
    {
        $this->validate($request,[
            'tour_id' => 'required|integer',
            'tour_image_id' => 'required|integer',
            'image_url' => 'required|string'
        ]);

        if(TourImages::where('tour_image_id',$request->tour_image_id)->count() > 0){
            TourImages::where('tour_id',$request->tour_id)->where('tour_image_id',$request->tour_image_id)->delete();
            TourImageSorter::where('tour_id',$request->tour_id)->where('image_url',$request->image_url)->delete();
            $log = new Logger;
            $log->user_id = Auth::user()->id;
            $log->info_is = 'ცარიელი';
            $log->info_was = 'ღონისძიების სურათის იდენთიფიკატორი:'.$request->tour_image_id;
            $log->crud_type = "წაიშალა";
            $log->save();
        }
        $event = Tour::where('tour_id',$request->input('tour_id'))->get();
            $eventImages = TourImages::join('tour_image_sorters','tour_image_sorters.image_url','=','tour_images.image_url')->where('tour_images.tour_id',$request->input('tour_id'))->where('tour_image_sorters.tour_id',$request->input('tour_id'))->orderBy('image_position','desc')->get();
            $eventReviews = TourReviews::select('name','lastname','review_content','tour_reviews.review_id','tour_reviews.created_at as created_at')->join('users','users.id','=','tour_reviews.user_id')->where('tour_id',$request->input('tour_id'))->get();

       return view('admin.adminEventEdit',compact('event','eventImages','eventReviews'));
    }

    public function uploadPhoto(Request $request)
    {
        $this->validate($request,[
            'image_input' => 'required|image|mimes:jpeg,png,jpg'
        ]);
        
        if($request->hasFile('image_input')) {
            $image = time().'.'.$request->file('image_input')->getClientOriginalExtension();
            $filePath2 = $request->image_input->move(public_path('uploadedImage'),$image);
            $filePath = 'uploadedImage/'.$image;


            $checkImageName = UserImage::where('image_url',$image)->count();

            if ($checkImageName == 0) {
                $makeProfile = UserImage::where('user_id',Auth::user()->id)->where('equiped',1)->update(['equiped' => 0]);

                    $image = new UserImage;
                    $image->image_url = $filePath;
                    $image->user_id = Auth::user()->id;
                    $image->equiped = 1;
                    if ($filePath) {
                        $image->save(); 
                        if ($image) {
                            $log = new Logger;
                            $log->user_id = Auth::user()->id;
                            $log->info_is = 'სურათის მისამართი :'.$filePath;
                            $log->info_was = "არსებობს";
                            $log->crud_type = "შეიქმნა";
                            $log->save();
                        }
                    } 
            }
        }

        return redirect('/admin/profile');
    }
    public function deleteEvent(Request $request)
    {
        $this->validate($request,['tour_id' => 'required|integer']);

        $first = Tour::where('tour_id',$request->input('tour_id'))->delete();

                $log = new Logger;
                $log->crud_type = "წაიშალა";
                $log->info_was = "ღონისძიების იდენთიფიკატორი : ".$request->input('tour_id');
                $log->info_is = "აღარ არსებობს";
                $log->user_id = Auth::user()->id;
                $log->save();

        foreach (TourImages::select('image_url')->where('tour_id',$request->input('tour_id'))->get() as $images) {
            $image_path = public_path($images->image_url);

            if (\File::exists($image_path)) {
                $file = \File::delete($image_path);
                $second = TourImages::where('tour_id',$request->input('tour_id'))->delete();     
            }
        }
       
        
        return redirect('admin/event')->with('success','Successfully Deleted!');
    }
    public function infoPage()
    {
       $log = Logger::select('users.id as user_id','loggers.crud_type','loggers.info_was','loggers.info_is','loggers.created_at','users.name')->join('users','users.id','=','loggers.user_id')->orderBy('loggers.created_at','desc')->get();
       
        return view('admin.info',compact('log'));
    }

    public function frameControl()
    {
        $frames = Page::all();

       return view('admin.frame' ,compact('frames'));
    }
    public function frameEdit(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string'
        ]);
        $button = PageButton::where('params',$request->input('params'))->get();
        $color = Color::where('params',$request->input('params'))->get();
        $logos = PageLogo::where('params',$request->input('params'))->get();
        $pageImages = BgImage::where('params',$request->input('params'))->get();
        $frames = Page::where('pages.params',$request->input('params'))->get();

        return view('admin.pageEdit',compact('frames','pageImages','logos','color','button'));
    }
    public function getPageLogos(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string'
        ]);
        $logos = PageLogo::where('params',$request->input('params'))->get();
        
        return view('admin.ajax.adminPageLogo',compact('logos'));
    }
    public function getPageImages(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string'
        ]);
        $pageImages = BgImage::where('params',$request->params)->orderby('bg_id','desc')->get();

        return view('admin.ajax.getPageImages',compact('pageImages'));
    }
    public function getPageButtons()
    {
        $button = PageButton::join('pages','pages.params','=','page_buttons.params')->get();

        return view('admin.ajax.adminPageButton',compact('button'));
    }
    public function sloganPage()
    {
       $frames = Page::all();
       $languages = Language::all();
       $slogans = PageSlogan::join('pages','pages.params','=','page_slogans.params')->join('languages','languages.id','=','page_slogans.language_id')->get();

       return view('admin.adminPageSlogan',compact('frames','languages','slogans'));
    }
    public function createPageButton(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string',
            'button_image' => 'required|image|mimes:svg',
            'button_title' => 'required|string' 
        ]);

        if ($request->hasFile('button_image')) {
            $image = uniqid().'.'.$request->file('button_image')->getClientOriginalExtension();
                $request->button_image->move(public_path('pageButtonImages'),$image);
                $button = new PageButton;
                $button->params = $request->input('params');
                $button->title = $request->input('button_title');
                $button->img_link = $image;
                if ($image) {
                    $button->save();
                    if ($button) {
                        $log = new Logger;
                        $log->user_id = Auth::user()->id;
                        $log->info_is = 'ღილაკის სურათის მისამართი გვერდისთვის : '.'pageButtonImages/'.$image;
                        $log->info_was = "არსებობს";
                        $log->crud_type = "შეიქმნა";
                        $log->save();
                    }
                } 
            echo 'success';
        }
        echo 'incorrect file type!';
    }
    public function pageSloganCreate(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string',
            'language_id.*' => 'required|integer',
            'slogan_title.*' => 'required|string'
        ]);

        for ($i=0; $i < count($request->language_id,COUNT_NORMAL); $i++) { 
            $slogan = new PageSlogan;
            $slogan->language_id = $request->language_id[$i];
            $slogan->page_slogan = $request->slogan_title[$i];
            $slogan->params = $request->params;
            $slogan->save();
        }
       return back();
    }
    public function is_enable(Request $request)
    {
        $this->validate($request,[
            'is_enable' => 'required|integer',
            'button_id' => 'required|integer'
        ]);

        $check = PageButton::where('button_id',$request->button_id)->update(['enable'=>$request->is_enable]);
        if ($check) {
            echo 1;
        }
    }   
    public function pageButtonDelete($id)
    {
        foreach (PageButton::where('button_id',$id)->get() as $but) {
            $path = public_path('pageButtonImages/'.$but->img_link);
            if (\File::exists($path)){
                $file = \File::delete($path);
                $a = PageButton::where('button_id',$id)->delete();
                if ($a) {
                    echo 'button deleted!';
                }else{
                    echo "button already deleted!";
                }
            }
        }
    }
    public function index()
    {
        return view('admin.cropper');
    }
    public function deleteColor(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string',
            'color_id'=>'required|string'
        ]);
        $colorCount = Color::all()->count();
        if ($colorCount > 1) {
            if($colorCount == 2){
                Color::where('params',$request->params)->where('color_id','!=',$request->color_id)->update(['equiped'=>1]);
            }
           Color::where('color_id',$request->color_id)->delete();
        }
    }
    public function uploadEventImage(Request $request)
    {
        $this->validate($request,[
            'image' => 'required',
            'tour_id' => 'required|integer'
        ]);
        
            $image = $request->image;
            if ($image) {
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid().time().'.'.'png';
                if ($imageName) {
                    $EventImage = new TourImages;
                    $EventImage->tour_id = $request->tour_id;
                    $EventImage->image_url = $imageName;
                    $EventImage->user_id = Auth::user()->id;
                    if ($EventImage) {
                       $EventImage->save();
                       \File::put('eventImages/' . $imageName, base64_decode($image));

                       $check = TourImageSorter::where('tour_id',$request->input('tour_id'))->count();
                        $imageSorter = new TourImageSorter;
                        $imageSorter->tour_id = $request->input('tour_id');
                        $imageSorter->image_url = $imageName;
                        if ($check > 0) {
                            foreach (TourImageSorter::where('tour_id',$request->tour_id)->get() as $val) {
                                if ($val->image_position != 0 && $val->image_position > 0) {
                                   $imageSorter->image_position = $val->image_position + 1;
                                } 
                            }
                        }else{
                            $imageSorter->image_position = 1;  
                        }
                        $imageSorter->save();
                    }   
                }
            }
            
        return response()->json(['status'=>true]);
    }
    public function frameImage(Request $request)
    {   
        $this->validate($request,[
            'params' => 'required|string',
            'image_input' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        if($request->hasFile('image_input')) {
            $image = uniqid().'.'.$request->file('image_input')->getClientOriginalExtension();
                $filePath = 'pageImages/'.$image;
                $thumbnailImage = Image::make($request->file('image_input'));
                $thumbnailImage->resize(1280,1920);
                $thumbnailImage->save('pageImages/'.$image);
            $checkImageName = BgImage::where('link',$image)->count();

            if ($checkImageName == 0) {
                $makeProfile = BgImage::where('params',$request->input('params'))->where('equiped',1)->update(['equiped' => 0]);
                    $saveImage = new BgImage;
                    $saveImage->link = $filePath;
                    $saveImage->image_name = $image;
                    $saveImage->params = $request->input('params');
                    if ($filePath) {
                        $saveImage->save(); 
                        if ($saveImage) {
                            $log = new Logger;
                            $log->user_id = Auth::user()->id;
                            $log->info_is = 'სურათის მისამართი გვერდისთვის : '.$filePath;
                            $log->info_was = "არსებობს";
                            $log->crud_type = "შეიქმნა";
                            $log->save();
                        }
                    } 
            } 
            
        }
        return 1;
    }

    public function logoUpload(Request $request)
    {
        $this->validate($request,[
            'page_id' => 'required|integer',
            'params' => 'required|string|min:3|max:255',
            'logo_input' => 'required|image|mimes:svg'
        ]);

        if($request->hasFile('logo_input')) {
            $image = uniqid().'.'.$request->file('logo_input')->getClientOriginalExtension();
                $request->logo_input->move(public_path('pageLogos'),$image);
            $checkImageName = PageLogo::where('logo_url',$image)->count();
            if ($checkImageName == 0) {
                    $saveImage = new PageLogo;
                    $saveImage->logo_url = $image;
                    $saveImage->params = $request->input('params');
                    $saveImage->page_id = $request->input('page_id');
                        $saveImage->save(); 
                        if ($saveImage) {
                            $log = new Logger;
                            $log->user_id = Auth::user()->id;
                            $log->info_is = 'ლოგოს მისამართი გვერდისთვის : '.$image;
                            $log->info_was = "არსებობს";
                            $log->crud_type = "შეიქმნა";
                            $log->save();
                        }
            } 
        }
        return 'გუთ';
    }
    public function pageColor(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string',
            'color' => 'required|string'
        ]);

        if (Color::where('params',$request->params)->where('color',$request->color)->count() == 0) {
            Color::where('params',$request->params)->where('equiped',true)->update(['equiped' => false]);
            $addbgcolor = new Color;
            $addbgcolor->params= $request->input('params');
            $addbgcolor->color = $request->input('color');
            $addbgcolor->save();
        }else if(Color::where('params',$request->params)->where('color',$request->color)->count() == 1){
            Color::where('params',$request->params)->where('equiped',true)->update(['equiped' => false]);
            Color::where('params',$request->params)->where('color',$request->color)->update(['equiped' => true]);
        }
        $color = Color::where('params',$request->input('params'))->get();
        $logos = PageLogo::where('params',$request->input('params'))->get();
        $pageImages = BgImage::where('params',$request->input('params'))->get();
            $frames = Page::where('pages.params',$request->input('params'))->get();
            $button = PageButton::where('params',$request->input('params'))->get();
        return view('admin.pageEdit',compact('frames','pageImages','logos','color','button'));
    }
    public function getPageColor($params)
    {
        $color = Color::where('params',$params)->get();

        return view('admin.ajax.adminPageColor',compact('color'));
    }
    public function pageUpdate(Request $request)
    {

        $this->validate($request,[
            'color' => 'required',
            'image_id' => 'required|integer',
            'params' => 'required|string|min:5|max:255',
        ]);
        BgImage::where('params',$request->input('params'))->update(['equiped' => 0]);
        BgImage::where('bg_id',$request->input('image_id'))->where('params',$request->input('params'))->update(['equiped' => 1]);
        if ( Color::where('params',$request->input('params'))->count() == 0) {
            foreach (Color::where('params',$request->params)->get() as $colorInfo) {
                $log = new Logger;
                $log->user_id = Auth::user()->id;
                $log->info_is = 'ფერი : '.$request->input('color')." - გვერდი : ".$request->input('params');
                $log->info_was = 'ფერი : '.$colorInfo->color." - გვერდი : ".$colorInfo->params;
                $log->crud_type = "განახლება";
            }
            $log->save();

            $color = new Color;
            $color->color = $request->input('color');
            $color->params = $request->input('params');
            $color->save();
                       

        }else{
            Color::where('params',$request->input('params'))->update(['color' => $request->input('color')]);
        }

        return redirect('/admin/frame');
    }

    public function deletePage(Request $request)
    {
        $this->validate($request,[
            'params' => 'required|string'
        ]);

        if(Page::where('params',$request->input('params'))->count() != 0){
            Page::where('params',$request->input('params'))->delete();
            BgImage::where('params',$request->input('params'))->delete();
            Color::where('params',$request->input('params'))->delete();

            $log = new Logger;
            $log->user_id = Auth::user()->id;
            $log->info_is = 'ცარიელი';
            $log->info_was = 'გვერდი :'.$request->input('params');
            $log->crud_type = "წაიშალა";
            $log->save();
        }

        return redirect()->route('frameControl');
    }

    public function deletePageImage(Request $request)
    {
        $this->validate($request,[
            'bg_id' => 'required|integer'
        ]);

       if (BgImage::where('bg_id',$request->bg_id)->count() == 1) {
            BgImage::where('bg_id',$request->bg_id)->delete();
       }
       return 'deleted';
    }

    public function searchInfo(Request $request)
    {
        if (empty($request->search)) {
           $search = Logger::select('users.id as user_id','loggers.crud_type','loggers.info_was','loggers.info_is','loggers.created_at','users.name')->join('users','users.id','=','loggers.user_id')->orderBy('loggers.created_at','desc')->get();
        }else{
            $search = Logger::select('users.id as user_id','loggers.crud_type','loggers.info_was','loggers.info_is','loggers.created_at','users.name')->join('users','users.id','=','loggers.user_id')->where('name','like',$request->input('search').'%')->orWhere('name','like','%'.$request->input('search').'%')->orderBy('loggers.created_at','desc')->get();
        }

        return view('admin.ajax.infoSearch',compact('search'));
    }
    public function frameImageSizingPage(Request $request)
    {

        $this->validate($request,[
            'image_id' => 'required|integer'
        ]);

        $images = BgImage::where('bg_id',$request->input('image_id'))->get();
        $imageSize = ImageCrop::where('page_image_id',$request->input('image_id'))->orderBy('image_height','desc')->get();

        return view('admin.imageSize',compact('images','imageSize'));
    }
    public function frameImageSizing(Request $request)
    {

        $this->validate($request,[
            'params' => 'required|string|max:255',
            'image_height' => 'required|integer',
            'image_width' => 'required|integer',
            'image_id' => 'required|integer',
            'image_url' => 'required|string',
            'image_name' => 'required|string'
        ]);


            if (ImageCrop::where('page_image_id',$request->input('image_id'))->where('image_width',$request->input('image_width'))->where('image_height',$request->input('image_height'))->count() == 0) {
                $oldImage = $request->input('image_url');
                $newUrl = 'croppedImages/'.time().$request->input('image_name');

                $image = \File::get($oldImage);
                $thumbnailImage = Image::make($image);
                $thumbnailImage->resize($request->image_width,$request->image_height);
                $thumbnailImage->save($newUrl); 
                
                    $saveImages = new ImageCrop;
                    $saveImages->page_image_id = $request->input('image_id');
                    $saveImages->image_height = $request->input('image_height');
                    $saveImages->image_width = $request->input('image_width');
                    $saveImages->image_url = $newUrl;
                    $saveImages->params = $request->input('params');
                    $saveImages->user_id = Auth::user()->id;
                    $saveImages->save();
                   
                    if($saveImages){
                        $log = new Logger;
                        $log->user_id = Auth::user()->id;
                        $log->info_is = 'სურათის შეცვლილი ზომა : '.$newUrl.'| სიგრძე : '.$request->image_height.'| სიგანე : '.$request->image_width;
                        $log->info_was = "არსებობს";
                        $log->crud_type = "შეიქმნა";
                        $log->save();
                    }
            }
            $images = BgImage::where('bg_id',$request->input('image_id'))->get();
            $imageSize = ImageCrop::where('params',$request->input('params'))->where('page_image_id',$request->input('image_id'))->orderBy('image_height','desc')->get();
        
        return view('admin.imageSize',compact('images','imageSize'));
    }

    public function getTranslated()
    {
        $language = Language::all();
        $word = Text_filed::select('text_fileds.tf_id','text_fileds.field')->groupby('text_fileds.tf_id','text_fileds.field')->orderBy('tf_id','desc')->get();
        // $word = Text_filed::groupby('tf_id')->all(); 
        $translated_word = Text_filed_value::select('tfv_id','value','language_id','filed_id')->groupby('tfv_id','value','language_id','filed_id')->orderby('tfv_id','asc')->get();
        return view('admin.ajax.adminLanguage',compact('language','word','translated_word'));
    }
    public function langPage()
    {
        $language = Language::all();
        $text_filled = Text_filed::all();
        $joinWords = Text_filed::select('text_fileds.tf_id','text_filed_values.value','text_fileds.field','language_id')->join('text_filed_values','text_fileds.tf_id','=','text_filed_values.filed_id')->groupby('text_fileds.tf_id','text_filed_values.value','text_fileds.field','language_id')->get();
        return view('admin.adminLanguage',compact('language','text_filled','joinWords'));
    }
    public function translate(Request $request)
    {

        $this->validate($request,[
            'translate_word_id' => 'required',
            'language_id' => 'required',
            'translated_word' => 'required|string'
        ]);

        if (Text_filed_value::where('value',$request->input('translated_word'))->where('filed_id',$request->input('translate_word_id'))->count() == 0){
           $p = new Text_filed_value;
           $p->filed_id = $request->input('translate_word_id');
           $p->language_id = $request->input('language_id');
           $p->value = $request->input('translated_word');
           $p->save();

            return 1;
        }else{
            return 'ასეთი ვარიანტი უკვე არსებობს!';
        }
       return 'არასწორად შეგყავთ მონაცემები!';
    }
    public function addLanguage(Request $request)
    {
        $this->validate($request,[
            'half_lang_name' => 'required|string',
            'full_lang_name' => 'required|string',
            'native_half_lang_name' => 'required|string',
            'native_full_lang_name' => 'required|string',
            'lang_flag' => 'required|image|mimes:svg',
        ]);

        $checkUniqueOfLanguage = Language::where('language_short_name',$request->input('half_lang_name'))->where('language_name',$request->input('full_lang_name'))->where('native_half_lang_name',$request->input('native_half_lang_name'))->where('native_full_lang_name',$request->input('native_full_lang_name'))->count();

        if ($checkUniqueOfLanguage == 0) {
           $addLanguage = new Language;
           $addLanguage->language_name = $request->input('full_lang_name');
           $addLanguage->language_short_name = $request->input('half_lang_name');
           $addLanguage->native_half_lang_name = $request->input('native_half_lang_name');
           $addLanguage->native_full_lang_name = $request->input('native_full_lang_name');
           if ($request->hasFile('lang_flag')) {
                $image = uniqid().'.'.$request->file('lang_flag')->getClientOriginalExtension();
                $request->lang_flag->move(public_path('flagImages'),$image);
               $addLanguage->flag_link = $image;
               $addLanguage->save();
           }
        }
        return redirect()->route('langPage')->with('success','წარმატებით დაემატა!');
    }
    public function addWordToTranslate(Request $request)
    {
        $this->validate($request,[
            'word' => 'required|string'
        ]);

        if (Text_filed::where('field',$request->input('word'))->count() == 0) {
            $addWord = new Text_filed;
            $addWord->field = $request->input('word');
            $addWord->save();
            return redirect('/admin/lang')->with('success','წარმატებით დაემატა!');
        }else{
            return redirect('/admin/lang')->with('unsuccess','სიტყვა უკვე დამატებულია!');
        }
    }
    public function editTranslatedWord(Request $request)
    {

        $this->validate($request,[
            'translated_id' => 'required|integer',
            'translated_word' => 'required|string',
            'language_id' => 'required|integer'
        ]);

        if (Text_filed_value::where('tfv_id',$request->input('translated_id'))->count() == 1) {

           Text_filed_value::where('tfv_id',$request->input('translated_id'))->update(['value' => $request->input('translated_word'),'language_id' => $request->language_id]);

           return 'წარმატებით დაემატა!';
        }

        return 'ასეთი უკვე არსებობს!';
    }

    public function editNotTranslatedWord(Request $request)
    {
        $this->validate($request,[
            'word' => 'required|string',
            'word_id' => 'required|integer'
        ]);

        $a = Text_filed::where('tf_id',$request->input('word_id'))->update(['field' => $request->input('word')]);
        if ($a) {
           return 'წარმატებით შეიცვალა!';
        }else{
            return 'ფორმა შეცდომით შეივსო!';
        }
    }
    public function editLanguage(Request $request)
    {
        $this->validate($request,[
            'language_id' => 'required|integer',
            'language_name' => 'required|string',
            'language_short_name' => 'required|string',
            'native_half_lang_name' => 'required|string',
            'native_full_lang_name' => 'required|string',
        ]);
        if ($request->language_edit_image) {
            $this->validate($request,[
                'language_edit_image' => 'required|image|mimes:svg'
            ]);
            if ($request->hasFile('language_edit_image')) {
  
                $image = uniqid().'.'.$request->file('language_edit_image')->getClientOriginalExtension();
                $request->language_edit_image->move(public_path('flagImages'),$image);
                foreach (Language::where('id',$request->language_id)->get() as $language) {
                    if (\File::exists('flagImages/'.$language->flag_link) ) {
                        $file = \File::delete('flagImages/'.$language->flag_link);
                        $second = Language::where('id',$request->input('language_id'))->update([
                            'flag_link' => $image,
                            'language_name' => $request->language_name,
                            'language_short_name' => $request->language_short_name,
                            'native_half_lang_name' => $request->native_half_lang_name,
                            'native_full_lang_name' => $request->native_full_lang_name
                        ]);     
                    }
                }
            }
        }else{
            $second = Language::where('id',$request->input('language_id'))->update([
                'language_name' => $request->language_name,
                'language_short_name' => $request->language_short_name,
                'native_half_lang_name' => $request->native_half_lang_name,
                'native_full_lang_name' => $request->native_full_lang_name
            ]);  
        }

        return redirect()->route('langPage');
    }
}