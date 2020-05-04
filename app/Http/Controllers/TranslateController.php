<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use redirect;
use App\AdminPanel\TranslateAdmin;
use App\AdminPanel\TranslateAdminKey;

class TranslateController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('admin');
    	// App::setLocale('en');
    }

    public function translate_page()
    {
    	$languages = Language::all();
    	$translate = TranslateAdmin::all();

    	return view('admin.adminTranslatePage',compact('languages','translate'));
    }

    public function add_word(Request $request)
    {
    	$this->validate($request,[
    		'translated_key' => 'required|string',
    		'translated_values.*' => 'required|string',
    		'lang_short_name.*' => 'required|string',
    	]);
    	$checkKeyExist = TranslateAdminKey::where('key',$request->translated_key)->count();
    	if ($checkKeyExist == 0) {
    			$transCat = new TranslateAdminKey;
    			$transCat->key = $request->translated_key;
    			$transCat->save();

    			$key_id = TranslateAdminKey::select('key_id')->orderby('key_id','DESC')->first();
    		for ($i=0; $i < count($request->lang_short_name,COUNT_NORMAL); $i++) { 
    			$trans = new TranslateAdmin;
    			$trans->key_id = $key_id['key_id'];
    			$trans->value = $request->translated_values[$i];
    			$trans->lang_short_name = $request->lang_short_name[$i];
				$trans->save();
    		}
    		return redirect()->route('translate_page');
    	}
		return back();	
    }

    public function translated_word_update(Request $request)
    {
    	$this->validate($request,[
    		'translated_word_id' => 'required|numeric',
    		'translated_word' => 'required|string',
    	]);

    	if (TranslateAdmin::where('key_id',$request->translated_word_id)->count() == 0) {
    		TranslateAdmin::where('translate_id',$request->translated_word_id)->update(['value'=>$request->translated_word]);

    		return 1;
    	}
    }
    public function get_translate_key(Request $request)
    {
    	$this->validate($request,[
    		'key_id' => 'required|numeric',
    		'keyword' => 'required|string',
    	]);

    	if(TranslateAdminKey::where('key_id',$request->key_id)->count() == 1){
    		TranslateAdminKey::where('key_id',$request->key_id)->update(['key'=>$request->keyword]);
    		
    		return 1;
    	}
    }

    public function get_translated()
    {	
    	$languages = Language::all();
    	$translate = TranslateAdmin::all();

    	return view('admin.ajax.get_translated',compact('languages','translate'));
    }
}
