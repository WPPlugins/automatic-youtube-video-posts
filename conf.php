<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			conf.php
//		Description:
//			This file configures the Wordpress Plugin - Automatic Video Posts Plugin
//		Copyright:
//			Copyright (c) 2016 Ternstyle LLC.
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

if ( ! defined( 'ABSPATH' ) ) exit;

//                                *******************************                                 //
//________________________________** INITIALIZE VARIABLES      **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

define('AYVPP_URL',plugin_dir_url(__FILE__));
define('AYVPP_ROOT',get_bloginfo('wpurl'));
define('AYVPP_DIR',dirname(__FILE__));
define('AYVPP_STDERR',WP_CONTENT_DIR.'/cache/ayvpp_stderr.txt');
define('AYVPP_SSLCRT',AYVPP_DIR.'/tools/ESCA.crt');
$ayvpp_version = array(5,1,3);

$WP_ayvpp_options = array(
	'updater_checked'			=>	0,
	'key'						=>	'',
	'channels'					=>	array(),
	'cron'						=>	6,
	'last_import'				=>	'',
	'content_display_meta'		=>	1,
	'content_truncate'			=>	1,
	'content_truncate_after'	=>	20,
	'content_top'				=>	0,
	'video_responsive'			=>	1,
	'video_responsive_ratio'	=>	'16:9',
	'video_dims'				=>	array(506,304),
	'video_related_show'		=>	0,
	'video_post_list_show'		=>	0,
	'thumbs_show'				=>	1,
	'verified'					=>	false,
	'serial'					=>	'',
	'admin_import'				=>	1,
	'import_thumbnails'			=>	1,
	'import_date'				=>	0
);

//                                *******************************                                 //
//________________________________** FILE CLASS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
require_once(dirname(__FILE__).'/class/file.php');
$getFILE = new fileClass;
//                                *******************************                                 //
//________________________________** LOAD CLASSES              **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
$l = $getFILE->directoryList(array(
	'dir'	=>	dirname(__FILE__).'/class/',
	'rec'	=>	true,
	'flat'	=>	true,
	'depth'	=>	1
));
if(is_array($l)) {
	foreach($l as $k => $v) {
		require_once($v);
	}
}
//                                *******************************                                 //
//________________________________** LOAD CORE FILES           **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

$l = $getFILE->directoryList(array(
	'dir'	=>	dirname(__FILE__).'/common/',
	'rec'	=>	true,
	'flat'	=>	true,
	'depth'	=>	1,
	'ext'	=>	array('php')
));
foreach((array)$l as $k => $v) {
	require_once($v);
}

if(is_admin()) {
	$l = $getFILE->directoryList(array(
		'dir'	=>	dirname(__FILE__).'/core/',
		'rec'	=>	true,
		'flat'	=>	true,
		'depth'	=>	1,
		'ext'	=>	array('php')
	));
}
else {
	$l = $getFILE->directoryList(array(
		'dir'	=>	dirname(__FILE__).'/front/',
		'rec'	=>	true,
		'flat'	=>	true,
		'depth'	=>	1,
		'ext'	=>	array('php')
	));
}
foreach((array)$l as $k => $v) {
	require_once($v);
}
unset($l,$k,$v);
//                                *******************************                                 //
//________________________________** CHECK DIRECTORIES         **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

if(!is_file(AYVPP_STDERR) and !$getFILE->createFile('ayvpp_stderr.txt','',WP_CONTENT_DIR.'/cache')) {
	
}

//                                *******************************                                 //
//________________________________** INITIALIZE PLUGIN         **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('init','WP_ayvpp_init',-9999);
function WP_ayvpp_init() {
	global $getWP,$WP_ayvpp_options,$ayvpp_options;
	$ayvpp_options = $getWP->getOption('ayvpp_settings',$WP_ayvpp_options);
}

/****************************************Terminate Script******************************************/
?>