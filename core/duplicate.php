<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			duplicate.php
//		Description:
//			This file remove duplicate video posts.
//		Copyright:
//			Copyright (c) 2016 Ternstyle LLC.
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

//                                *******************************                                 //
//________________________________** INITIALIZE                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
if(!isset($_GET['page']) or $_GET['page'] !== 'ayvpp-dups') {
	return;
}
//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('init','WP_ayvpp_dups_actions');
//                                *******************************                                 //
//________________________________** ACTIONS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_dups_actions() {
	global $getWP,$WP_ayvpp_options,$wpdb;
	
	if(!isset($_REQUEST['_wpnonce']) or !wp_verify_nonce($_REQUEST['_wpnonce'],'WP_ayvpp_nonce') or !current_user_can('manage_options')) {
		return;
	}
	
	switch($_REQUEST['submit']) {
	
		case 'Cleanup' :
			$videos = $wpdb->get_results("select a.post_id,b.post_id as dup from ".$wpdb->postmeta." as a inner join (select * from ".$wpdb->postmeta." where meta_key='_ayvpp_video' group by meta_value having count(meta_id) > 1) as b on (a.meta_value=b.meta_value) where a.`meta_key` = '_ayvpp_video' and a.meta_id <> b.meta_id and a.post_id in (select ID from ".$wpdb->posts.")");
			foreach((array)$videos as $v) {
				if((int)$v->post_id > (int)$v->dup) {
					if(!wp_delete_post($v->post_id,true)) {
						$getWP->addError('There was an error while deleting a video post "'.get_the_title($v).'". Please try again.');
					}
				}
				else {
					if(!wp_delete_post($v->dup,true)) {
						$getWP->addError('There was an error while deleting a video post "'.get_the_title($v).'". Please try again.');
					}
				}
			}
			break;
		
		default :
			break;
		
	}
	
}
//                                *******************************                                 //
//________________________________** SETTINGS                  **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_duplicate() {
	include(AYVPP_DIR.'/views/dups.php');
}

/****************************************Terminate Script******************************************/
?>