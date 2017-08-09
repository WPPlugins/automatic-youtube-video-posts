=== Automatic Youtube Video Posts Plugin ===
Contributors: mpraetzel
Donate link: http://www.ternstyle.us/donate
Tags: youtube, youtube videos, videos, embed videos, embed youtube videos, video posts, youtube channel, youtube playlist, channel, playlist
Requires at least: 2.8
Tested up to: 4.5.2
Stable tag: 5.1.3

The Automatic Youtube Video Posts Plugin automatically creates posts for YouTube videos from any YouTube account, playlist, or search term.

== Description ==

The Automatic Youtube Video Posts Plugin automatically imports YouTube videos from any YouTube channel, playlist or search term, and creates posts for them and publishes them or creates a post draft according to your settings.

DOWNLOAD THE PRO VERSION HERE: http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/
CHECK OUT THE IMPROVEMENTS HERE: http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/change-log

* Homepage for this plugin: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/`
* Purchase: `https://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/purchase`
* Documentation: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/documentation`
* Working example: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/category/video`
* Change Log: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/change-log`
* Donate: `http://www.ternstyle.us/donate`
* Facebook: `http://www.facebook.com/ternstyle`
* Twitter: `https://twitter.com/ternstyle`

== Installation ==

To install the Automatic YouTube Video Posts plugin simply:

* Unpack the downloaded zipped file
* Upload the "automatic-youtube-video-posts" folder to your /wp-content/plugins directory
* Log into Wordpress
* Go to the "Plugins" page
* Activate the Automatic YouTube Video Posts Plugin

You\'re all set! Now you just have to change some Settings for the plugin.

To change your settings please:

* Log into Wordpress
* Open the "Youtube Posts" tab (which is located at the bottom of the vertical navigation on the left of your Wordpress administration panel.
* Click on the "Settings" option in the "Automatic Video" tab.

== Features ==

* Automatically import YouTube videos into Wordpress Posts from a specified YouTube channel, playlist, or search term.
* Uses YouTube's latest API v3.
* PRO ONLY: Add as many channels, playlists, or searches as you like.
* PRO ONLY: Publish videos as custom post types.
* PRO ONLY: Supports custom taxonomies.
* PRO ONLY: Import EVERY video, even past videos, in your channel or playlist.
* PRO ONLY: One click manual import for retrieving ALL channel, playlist videos.
* Publish posts automatically or save them as drafts for review.
* Add a YouTube video and video meta to any existing post.
* Categorize your videos.
* Automically import video thumbnails for display on your site.
* Responsive videos.
* Sync videos manually after they've been imported if the video has changed on YouTube.
* Duplicate post clean-up tool.

== Resources ==

* Homepage for this plugin: `http://www.ternstyle.us/products/plugins/wordpress/wordpress-automatic-youtube-video-posts`
* Doc* Homepage for this plugin: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/`
* Purchase: `https://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/purchase`
* Documentation: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/documentation`
* Working example: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/category/video`
* Change Log: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/change-log`
* Donate: `http://www.ternstyle.us/donate`
* Facebook: `http://www.facebook.com/ternstyle`
* Twitter: `https://twitter.com/ternstyle`

== Frequently Asked Questions ==

= How do I set up a Google API Key? =

Please read here: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/documentation/settings/google-api-key`

= I get the error "Channel Not Found." Why? =

This is most likely due to your Google API Key not being configured properly. You can read on this here. If you've already followed these instructions, do so again from scratch but make sure to NOT specify an IP address when setting up the API Key.

This may also be due to adding the wrong channel name or ID to the channel field. You'll want to paste the user name from the URL, e.g. "https://www.youtube.com/user/NHLVideo" would be "NHLVideo". Or paste the channel ID from the URL, e.g. "https://www.youtube.com/channel/UCLj5GQ6Q7-1Jca6nt1Kfxkw" would be "UCLj5GQ6Q7-1Jca6nt1Kfxkw".

= Why have my videos stopped importing? =

The main reason for this is that an interruption occurred during import and a key value in the database which tells the plugin an import is taking place has not properly been reset. You can reset it by using the "Reset" tab in the plugin menu. Read more: `http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/documentation/resetting-the-plugin/reset-import-field-in-database`

= Why won't the plugin import all my videos? =

There could be a number of reasons for this.

Firstly, are you paying for cheap shared hosting? Yup. We thought so. This is a powerful plugin and it requires the ability to run for a while. Most likely your server settings timeout before the script can run through a single time. When using the import button, for each channel/playlist you have set up 50 videos at a time are imported. This means 50 videos per channel/playlist need to be retrieved from Google's servers and numerous queries take place per video to create a WordPress™ post. Your server just isn't set up to do this. Try importing from less channels/playlists. Try importing from one channel/playlist at a time. Try upgrading your hosting. We may be able to help host your solution. Contact us.

Did you just upload the video? It takes time for Google to cache your new videos; even up to a day or more.

Are you attempting to import from too many channels? You could be pushing your server to its limits.

= I'm getting this error: "Your API Key is correct but the project it belongs to in your Google API console is not configured properly to use the YouTube® API." =

When you set up your Google API Server Key you need to provide an IP address(es) your hosting server uses to connect out to 3rd party services. Most likely you input an incorrect IP address. Your hosting provider should be able to inform you of what this IP address is if you're not able to find it yourself.

== Changelog ==

`http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/change-log`

== Upgrade Notice ==
