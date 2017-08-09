<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			channels.php
//		Description:
//			This file creates and saves configurable YouTube channels.
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

if(!isset($_GET['page']) or $_GET['page'] !== 'ayvpp-channels') {
	return; 
}

//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('init','WP_ayvpp_channel_actions');
add_action('init','WP_ayvpp_channel_styles');
add_action('init','WP_ayvpp_channel_scripts');
//                                *******************************                                 //
//________________________________** SCRIPTS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_channel_styles() {
	wp_enqueue_style('thickbox');
}
function WP_ayvpp_channel_scripts() {
	wp_enqueue_script('thickbox');
	wp_enqueue_script('ayvpp-channels');
}
//                                *******************************                                 //
//________________________________** ACTIONS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_channel_actions() {
	global $getWP,$ayvpp_options;

	//find action
	if(isset($_REQUEST['action']) or isset($_REQUEST['action2'])) {
		$action = empty($_REQUEST['action']) ? $_REQUEST['action2'] : $_REQUEST['action'];
	}
	
	//return if we shouldn't be doing anything
	if(!isset($_REQUEST['_wpnonce']) or !wp_verify_nonce($_REQUEST['_wpnonce'],'WP_ayvpp_nonce') or !current_user_can('manage_options') or !isset($action)) {
		return false;
	}
	
	//perform action
	switch($action) {
		
		case 'activate' :
			foreach((array)$_REQUEST['items'] as $v) {
				$ayvpp_options['channels'][$v]['activated'] = true;
			}
			$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
			$getWP->addAlert('You have successfully activated your channel.');
			break;
		case 'deactivate' :
			foreach((array)$_REQUEST['items'] as $v) {
				$ayvpp_options['channels'][$v]['activated'] = false;
			}
			$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
			$getWP->addAlert('You have successfully deactivated your channel.');
			break;
		
		case 'delete' :
			foreach((array)$_REQUEST['items'] as $v) {
				unset($ayvpp_options['channels'][$v]);
			}
			$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
			$getWP->addAlert(__('You have successfully deleted your channel/playlist.','ayvpp'));
			break;
			
		case 'add' :
			
			//edit channel
			if(isset($_REQUEST['item']) and (!empty($_REQUEST['item']) or $_REQUEST['item'] === 0 or $_REQUEST['item'] === '0')) {
				$i = $_REQUEST['item'];
			}
			
			//add channel
			else {
				
				if(count($ayvpp_options['channels']) > 0) {
					$getWP->addError('We\'re sorry you can only add one channel with our FREE version. Please upgrade to the PRO version <a href="https://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/purchase" target="_blank">here</a>.');
					return false;
				}
				
				foreach((array)$ayvpp_options['channels'] as $v) {
					if($v['channel'] == $_POST['channel']) {
						$getWP->addError('You have already added the channel: "'.$_POST['channel'].'".');
						break 2;
					}
				}
				if(empty($ayvpp_options['channels'])) {
					$i = 1;
				}
				else {
					$i = array_keys($ayvpp_options['channels']);
					$i = $i[count($i)-1]+1;
				}
			}
			
			//validate channel
			foreach(array('name','channel','type','author') as $v) {
				if(!isset($_POST[$v]) or empty($_POST[$v])) {
					$getWP->addError('Please fill out all the fields for a channel/playlist.');
					return false;
				}
			}
			
			//see if channel exists
			$a = array();
			
			$c = new tern_curl();
			if($_POST['type'] == 'search') {
				
			}
			elseif($_POST['type'] == 'channel') {
				
				$r = $c->get(array(
					'url'		=>	'https://www.googleapis.com/youtube/v3/channels/?part=id,snippet,contentDetails&id='.$_POST['channel'].'&key='.$ayvpp_options['key'],
					'options'	=>	array(
						'RETURNTRANSFER'	=>	true,
						'CAINFO'			=>	AYVPP_SSLCRT,
					),
					'headers'	=>	array(
						'Accept-Charset'	=>	'UTF-8'
					)
				));
				$r = json_decode($r->body);

				if(isset($r->items) and !empty($r->items)) {
					$a['playlist'] = $r->items[0]->contentDetails->relatedPlaylists->uploads;
				}
				else {
					$r = $c->get(array(
						'url'		=>	'https://www.googleapis.com/youtube/v3/channels/?part=id,snippet,contentDetails&forUsername='.$_POST['channel'].'&key='.$ayvpp_options['key'],
						'options'	=>	array(
							'RETURNTRANSFER'	=>	true,
							'CAINFO'			=>	AYVPP_SSLCRT
						),
						'headers'	=>	array(
							'Accept-Charset'	=>	'UTF-8'
						)
					));
					$r = json_decode($r->body);
					if(!isset($r->items) or empty($r->items)) {
						$getWP->addError('This channel cannot be found.'.(isset($r->error->errors[0]->message) ? 'Google API error: '.$r->error->errors[0]->message : ''));
						return;
					}
					else {
						$v = (array)$r->items[0];
						$r = $c->get(array(
							'url'		=>	'https://www.googleapis.com/youtube/v3/channels/?part=id,snippet,contentDetails&id='.$v['id'].'&key='.$ayvpp_options['key'],
							'options'	=>	array(
								'RETURNTRANSFER'	=>	true,
								'CAINFO'			=>	AYVPP_SSLCRT
							),
							'headers'	=>	array(
								'Accept-Charset'	=>	'UTF-8'
							)
						));
						$r = json_decode($r->body);
						$a['playlist'] = $r->items[0]->contentDetails->relatedPlaylists->uploads;
						if(!isset($a['playlist']) or empty($a['playlist'])) {
							$getWP->addError('This channel cannot be found.');
							return;
						}
					}
				}
				
			}
			elseif($_POST['type'] == 'playlist') {
				$r = $c->get(array(
					'url'		=>	'https://www.googleapis.com/youtube/v3/playlistItems/?playlistId='.$_POST['channel'].'&part=id&key='.$ayvpp_options['key'],
					'options'	=>	array(
						'RETURNTRANSFER'	=>	true,
						'CAINFO'			=>	AYVPP_SSLCRT
						//'FOLLOWLOCATION'	=>	true
					),
					'headers'	=>	array(
						'Accept-Charset'	=>	'UTF-8'
					)
				));
				$r = json_decode($r->body);
				if(!isset($r->items) or empty($r->items)) {
					$getWP->addError('This channel cannot be found. Google API error: '.$r->error->errors[0]->message);
					return;
				}
			}
			
			$terms = array();
			$cats = array();
			foreach((array)$_POST['categories'] as $v) {
				$t = explode('|',$v);
				$t[0] = sanitize_text_field($t[0]);
				if(!empty($t[0]) and !empty($t[1])) {
					$terms[$t[0]] = (isset($terms[$t[0]]) and is_array($terms[$t[0]])) ? $terms[$t[0]] : array();
					$terms[$t[0]][] = (int)$t[1];
					
					$cats[] = (int)$t[1];
				}
			}
			
			//save channel
			$ayvpp_options['channels'][$i] = array_merge($a,array(
				'id'						=>	intval($i),
				'name'					=>	sanitize_text_field($_POST['name']),
				'channel'				=>	sanitize_text_field($_POST['channel']),
				'limit'					=>	(isset($_POST['limit']) and !empty($_POST['limit'])) ? (int)$_POST['limit'] : false,
				'post_type'				=>	isset($_POST['publish_type']) ? sanitize_text_field($_POST['publish_type']) : 'post',
				'type'					=>	isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'channel',
				'auto_play'				=>	isset($_POST['auto_play']) ? (int)$_POST['auto_play'] : 0,
				'related_show'			=>	isset($_POST['related_show']) ? (int)$_POST['related_show'] : 0,
				'import_description'	=>	isset($_POST['import_description']) ? (int)$_POST['import_description'] : 1,
				'categories'				=>	$cats,//isset($_POST['categories']) ? $_POST['categories'] : array(),
				'terms'					=>	$terms,
				'author'					=>	isset($_POST['author']) ? (int)$_POST['author'] : 1,
				'publish'				=>	isset($_POST['publish']) ? (int)$_POST['publish'] : 0
			));
			$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
			$getWP->addAlert('You have successfully added your channel.');
			break;
			
		default :
			break;
	}
	
}
//                                *******************************                                 //
//________________________________** CHANNELS                  **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_ayvpp_channels() {
	global $ayvpp_options,$wpdb;
	
	include(AYVPP_DIR.'/views/channels.php');
	include(AYVPP_DIR.'/views/channel_add.php');
	
}

/****************************************Terminate Script******************************************/
?>