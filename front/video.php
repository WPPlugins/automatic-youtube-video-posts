<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			video.php
//		Description:
//			This file renders videos, video images and video meta.
//		Copyright:
//			Copyright (c) 2016 Ternstyle LLC.
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('the_post','WP_ayvpp_video_init');
add_filter('the_content','WP_ayvpp_content');
//                                *******************************                                 //
//________________________________** RENDER VIDEO              **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_video_init() {
	global $ayvpp_options,$post,$ayvpp_video;
	$ayvpp_video = new youtube_video($ayvpp_options);	
}
function WP_ayvpp_content($c='') {
	global $ayvpp_options,$ayvpp_video;

	if(!isset($ayvpp_video->meta['_ayvpp_video']) or empty($ayvpp_video->meta['_ayvpp_video'])) {
		return $c;
	}

	$v = '';
	if(is_single()) {
		$v = ((isset($ayvpp_options['content_display_meta']) and $ayvpp_options['content_display_meta']) ? $ayvpp_video->video().$ayvpp_video->meta_show() : $ayvpp_video->video());
	}
	elseif(isset($ayvpp_options['video_post_list_show']) and $ayvpp_options['video_post_list_show']) {
		$v = $ayvpp_video->video();
	}
	
	return $ayvpp_options['content_top'] ? $c.$v : $v.$c;
	
}

/****************************************Terminate Script******************************************/
?>