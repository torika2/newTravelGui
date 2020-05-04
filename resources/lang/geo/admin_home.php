<?php
$array = [];
foreach (App\AdminPanel\TranslateAdmin::where('lang_short_name',auth::user()->user_lang)->get() as $value){
	 $array += [$value->key => $value->value];
}
return $array;
// return [
// // LAYOUT ----------------
// 		// menu
// 	'interface_title' => 'ინტერფეისი',
// 	'controller' => 'მენიუ',
// 	'list' => 'ჩამონათვალი',
// 	'menu' => [
// 		'event' => 'ღონისძიება',
// 		'page' => 'გვერდი',
// 		'info' => 'ინფორმაცია',
// 		'text' => 'ტექსტი',
// 		'page_button' => 'გვერდის ღილაკები',
// 		'page_slogan' => 'გვერდის სლოგანი'
// 	],
// // ADMIN HOMEPAGE ----------------
// 	'counted_events' => 'ღონისძიების რაოდენობა',
// 	'done_info' => 'პროფილის ინფორმაცია შეავსო',  
// 		// user info
// 	'user' => 'მომხმარებელი',
// 	'user_info' => [
// 		'name' => 'სახელი',
// 		'email' => 'ელ-ფოსტა',
// 		'language_short_name' => 'ენა',
// 		'country' => 'ქვეყანა',
// 		'b_day' => 'დაბადების თარიღი',
// 		'mobile' => 'მობილურის ნომერი',
// 		'event' => 'ღონისძიება',
// 		'event_like' => 'ღონისძიება მოეწონა',
// 		'event_share' => 'ღონისძიება გააზიარა',
// 		'post' => 'პოსტი',
// 		'post_like' => 'პოსტი მოიწონა',
// 		'post_share' => 'პოსტი გააზიარა',
// 		'post_fav' => 'პოსტის საუკეთესოდ მონიშვნა',
// 		'event_author' => 'ღონისძიების ავტორი',
// 	],
// 	'color' => 'ფერი',
// 	'change' => 'შეცვლა',
// //ADMIN EVENTPAGE
// 	'event_create' => [
// 		'title' => 'ღონისძიების შექმნა',
// 		'name' => 'ღონისძიების სახელი...',
// 		'price' => 'ღონისძიების ფასი,მაგალითად 50ლ',
// 		'members' => 'მონაწილეთა რაოდენობა',
// 		'desc' => 'ღონისძიების აღწერა',
// 		'submit' => 'დაეთანხმეთ შექმნას',	
// 	],
// 	'event_list' => [
// 		'name' => 'ღონისძიების სახელი',
// 		'desc' => 'აღწერა',
// 		'member' => 'მონაწილე',
// 		'price' => 'ფასი თითო ადამიანზე',
// 		'comment' => 'კომენტარი',
// 		'share' => 'გაზიარება',
// 		'like' => 'მოიწონა',
// 		'dislike' => 'არ მოიწონა',
// 		'picture' => 'სურათი',
// 		'created_at' => 'შექმნის თარიღი',
// 	],
// //ADMIN INFOPAGE
// 	'info_page' => [
// 		'title' => 'როდესაც მომხმარებელი შექმნის/შეცვლის ან წაშლის ინფორმაციას აქ იქნება განთავსებული.',
// 		'show' => 'მანახე',
// 		'entries' => 'ცალი',
// 		'name' => 'სახელი',
// 		'category' => 'კატეგორია',
// 		'info_bool' => 'ინფორმაცია',
// 		'info_was' => 'იყო',
// 		'info_is' => 'არის',
// 		'created_at' => 'აღწერის დრო',
// 	],
// ];