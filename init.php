<?php
/*
Plugin Name: Automatic YouTube Video Posts
Plugin URI: http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/
Description: Add YouTube&reg; video posts automatically to your WordPress blog.
Author: Ternstyle LLC
Version: 5.1.3
Author URI: http://www.ternstyle.us/
*/

////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			init.php
//		Description:
//			This file initializes the WordPress Plugin - Automatic Video Posts
//		Version:
//			5.1.3
//		Copyright:
//			Copyright (c) 2016 Ternstyle LLC.
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

if ( ! defined( 'ABSPATH' ) ) exit;

//                                *******************************                                 //
//________________________________** INCLUDES                  **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
require_once(dirname(__FILE__).'/conf.php');

//                                *******************************                                 //
//________________________________** ACTIVATION                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
register_activation_hook(__FILE__,'WP_ayvpp_activate_plugin');
function WP_ayvpp_activate_plugin() {
	
	global $WP_ayvpp_options,$wpdb;
	
	$o = get_option('tern_wp_youtube');
	
	if(!empty($o)) {
		$WP_ayvpp_options['cron'] = $o['cron'];
		$WP_ayvpp_options['content_truncate_after'] = $o['words'];
		$WP_ayvpp_options['video_dims'] = $o['dims'];
		$WP_ayvpp_options['content_display_meta'] = $o['display_meta'];
		$WP_ayvpp_options['video_post_list_show'] = $o['inlist'];
		
		$c = 0;
		foreach((array)$o['channels'] as $v) {
			$WP_ayvpp_options['channels'][] = array(
				'id'			=>	$c,
				'name'			=>	$v['name'],
				'channel'		=>	$v['channel'],
				'post_type'		=>	'post',
				'type'			=>	$v['type'],
				'auto_play'		=>	0,
				'related_show'	=>	0,
				'categories'	=>	$v['categories'],
				'author'		=>	$v['author'],
				'publish'		=>	$o['publish']
			);
			$c++;
		}

		update_option('ayvpp_settings',$WP_ayvpp_options);
		
		$wpdb->query("update $wpdb->postmeta set meta_key='_ayvpp_video' where meta_key='_tern_wp_youtube_video'");
		$wpdb->query("update $wpdb->postmeta set meta_key='_ayvpp_published' where meta_key='_tern_wp_youtube_published");
		$wpdb->query("update $wpdb->postmeta set meta_key='_ayvpp_author' where meta_key='_tern_wp_youtube_author");
		
		delete_option('tern_wp_youtube');
		
	}
	
}

/****************************************Terminate Script******************************************/
?>