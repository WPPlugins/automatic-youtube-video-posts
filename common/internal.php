<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			internal.php
//		Description:
//			This file is responsible for internal functions.
//		Copyright:
//			Copyright (c) 2010 Matthew Praetzel.ernstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

//                                *******************************                                 //
//________________________________** ACTIONS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

add_action('init','WP_ayvpp_check');

//                                *******************************                                 //
//________________________________** FUNCTIONS                 **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_check($p='') {
	global $getWP,$ayvpp_options;
	
	if(count($ayvpp_options['channels']) > 0) {
		$ayvpp_options['channels'] = array_slice($ayvpp_options['channels'],0,1);
		$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
	}
	
}

/****************************************Terminate Script******************************************/
?>