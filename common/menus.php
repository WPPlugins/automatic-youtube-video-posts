<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			menus.php
//		Description:
//			This file initializes menus for the plugin's administrative tasks
//		Copyright:
//			Copyright (c) 2011 Matthew Praetzel.ernstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('admin_menu','WP_ayvpp_menu');
//                                *******************************                                 //
//________________________________** MENUS                     **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_menu() {
	if(function_exists('add_menu_page')) {
		
		//if(WP_ayvpp_is_activated()) {
			add_menu_page('Automatic Video Posts','Automatic Video','manage_options','ayvpp-settings','WP_ayvpp_settings','dashicons-video-alt3',99.99999999999);
			add_submenu_page('ayvpp-settings','Automatic Video Posts','Settings','manage_options','ayvpp-settings','WP_ayvpp_settings');
			add_submenu_page('ayvpp-settings','UPGRADE to PRO Version','UPGRADE',10,'ayvpp-upgrade','WP_ayvpp_upgrade');
			add_submenu_page('ayvpp-settings','Channels/Playlists','Channels/Playlists','manage_options','ayvpp-channels','WP_ayvpp_channels');
			add_submenu_page('ayvpp-settings','Video Posts','Video Posts','manage_options','ayvpp-video-posts','WP_ayvpp_video_posts');
			add_submenu_page('ayvpp-settings','Reset','Reset','manage_options','ayvpp-reset','WP_ayvpp_reset');
			add_submenu_page('ayvpp-settings','Duplicate Post Cleanup','Duplicate Post Cleanup','manage_options','ayvpp-dups','WP_ayvpp_duplicate');
			add_submenu_page('ayvpp-settings','Trouble Shooting','Trouble Shooting','manage_options','ayvpp-trouble','WP_ayvpp_trouble');
		//}
		//else {
		//	add_menu_page('Automatic Video Posts','Automatic Video','manage_options','ayvpp-activate','WP_ayvpp_set_activate','dashicons-video-alt3');
		//}
	}
}

/****************************************Terminate Script******************************************/
?>