<?php 
$array = [];
foreach (App\AdminPanel\TranslateAdmin::select('translate_admin_keys.key','translate_admins.value')->join('translate_admin_keys','translate_admins.key_id','=','translate_admin_keys.key_id')->where('lang_short_name',auth::user()->user_lang)->get() as $value){
	 $array += [$value->key => $value->value];
}
return $array;
// LAYOUT ----------------
		// menu
// 	'interface_title' => 'INTERFACE',
// 	'controller' => 'Menu',
// 	'list' => 'List',
// 	'menu' => [
// 		'event' => 'Event',
// 		'page' => 'Page',
// 		'info' => 'Info',
// 		'text' => 'Text',
// 		'page_button' => 'Page buttons',
// 		'page_slogan' => 'Page slogan'
// 	],
// // ADMIN HOMEPAGE ----------------
// 	'counted_events' => 'Counted Events',
// 	'done_info' => 'Profile Info Filled By',
// 		// user info
// 	'user' => 'User',
// 	'user_info' => [
// 		'name' => 'Name',
// 		'email' => 'Email',
// 		'language_short_name' => 'Language',
// 		'country' => 'Country',
// 		'b_day' => 'Birthday',
// 		'mobile' => 'Mobile number',
// 		'event' => 'Event',
// 		'event_like' => 'Event likes',
// 		'event_share' => 'Event shares',
// 		'post' => 'Post',
// 		'post_like' => 'Post likes',
// 		'post_share' => 'Post shares',
// 		'post_fav' => 'Post Rating',
// 		'event_author' => 'Event author'
// 	],
// 	'color' => 'Color',
// 	'change' => 'Change',
// //ADMIN EVENTPAGE
// 	'event_create' => [
// 		'title' => 'Create Event',
// 		'name' => 'Event name',
// 		'price' => 'Event price (Example 30$)',
// 		'members' => 'Number of participants',
// 		'desc' => 'Event Description...',
// 		'submit' => 'Create',	
// 	],
// 	'event_list' => [
// 		'name' => 'Event Name',
// 		'desc' => 'Description',
// 		'member' => 'Participants',
// 		'price' => 'Price per person',
// 		'comment' => 'Comments',
// 		'share' => 'Shares',
// 		'like' => 'Likes',
// 		'dislike' => 'Dislike',
// 		'picture' => 'Images',
// 		'created_at' => 'Creation date',
// 	],
// //ADMIN INFOPAGE

// 	'info_page' => [
// 		'title' => "If user will create/update or delete information,it places here.",
// 		'show' => 'show',
// 		'entries' => 'entries',
// 		'name' => 'Name',
// 		'category' => 'Category',
// 		'info_bool' => 'Information',
// 		'info_was' => 'was',
// 		'info_is' => 'is',
// 		'created_at' => 'Updated at',
// 	],

