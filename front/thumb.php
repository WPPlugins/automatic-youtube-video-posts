<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			thumb.php
//		Description:
//			This file imports the thumbnail for a post if it needs to be displayed and hasn't been imported.
//		Copyright:
//			Copyright (c) 2015 Ternstyle LLC.ernstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

//                                *******************************                                 //
//________________________________** INITIALIZE VARIABLES      **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
if(isset($GLOBALS['pagenow']) and $GLOBALS['pagenow'] != 'admin-ajax.php') {
	add_action('the_post','WP_ayvpp_add_post_thumbnail');
}
//                                *******************************                                 //
//________________________________** IMPORT VIDEOS             **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_add_post_thumbnail() {
	global $getWP,$ayvpp_options,$post;
	
	if(!isset($ayvpp_options['import_thumbnails']) or $ayvpp_options['import_thumbnails'] != 1) {
		return;
	}
	
	$v = get_post_meta($post->ID,'_ayvpp_video',true);
	
	if($v) {
		
		$x = get_post_thumbnail_id($post->ID);
		
		if(!has_post_thumbnail($post->ID) or !preg_match("/^[0-9]+$/",$x)) {
			
			//get file path
			$y = new youtube_video;
			$f = $y->thumb('*');
			if(!$f) {
				return false;
			}
			
			//get the contents of the file
			//$i = file_get_contents($f);
			$c = new tern_curl;
			$r = $c->get(array(
				'url'		=>	$f,
				'options'	=>	array(
					'RETURNTRANSFER'	=>	true,
					'CAINFO'			=>	AYVPP_SSLCRT
					//'FOLLOWLOCATION'	=>	true
				),
				'headers'	=>	array(
					'Accept-Charset'	=>	'UTF-8'
				)
			));
			
			if($r->headers['Content-Type'] != 'image/jpeg' or empty($r->body)) {
				return false;
			}
			$i = $r->body;
			
			//name the file
			$n = $v.'.jpg';
			
			//upload the file
			$r = wp_upload_bits($n,NULL,$i);
			
			if(isset($r['file']) and (!isset($r['error']) or !$r['error'])) {
				
				//get upload directory
				$u = wp_upload_dir();
				
				//create thumbnail post
				$p = wp_insert_attachment(array(
					'guid'				=>	$r['url'], 
					'post_mime_type'	=>	'image/jpeg',
					'post_title'		=>	$n,
					'post_content'		=>	'',
					'post_status'		=>	'inherit'
				),$r['file'],$post->ID);
				
				//include image processing
				require_once(ABSPATH.'wp-admin/includes/image.php');
				
				//generate image metadata
				$d = wp_generate_attachment_metadata($p,$r['file']);
				wp_update_attachment_metadata($p,$d);
				
				//set the thumbnail for the post
				set_post_thumbnail($post->ID,$p);
				
			}
			
		}
	}
	
	
	
}

/****************************************Terminate Script******************************************/
?>