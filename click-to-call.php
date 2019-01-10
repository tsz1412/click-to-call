<?php
/*
Plugin Name: Click to Call

Plugin URI: https://github.com/tsz1412/click-to-call.git

Description: Add a simple click to call bar to the bottom of your page on mobile devices.

Version: 1.5

Author: Tsviel Zaikman

Author URI: http://tsz-dev.com

License: License: GPLv2 or later

Text Domain: click-to-call

Domain Path /languages/

*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//* Updater init *//
add_action( 'init', 'click_to_call_updater_init' );
function click_to_call_updater_init() {
	include_once 'updater.php';
	define( 'WP_GITHUB_FORCE_UPDATE', true );
	
	if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin
		$config = array(
			'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
			'proper_folder_name' => 'click-to-call', // this is the name of the folder your plugin lives in
			'api_url' => 'https://api.github.com/repos/tsz1412/click-to-call', // the GitHub API url of your GitHub repo
			'raw_url' => 'https://raw.github.com/tsz1412/click-to-call/master', // the GitHub raw url of your GitHub repo
			'github_url' => 'https://github.com/tsz1412/click-to-call', // the GitHub url of your GitHub repo
			'zip_url' => 'https://github.com/tsz1412/click-to-call/zipball/master', // the zip url of the GitHub repo
			'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
			'requires' => '3.0', // which version of WordPress does your plugin require?
			'tested' => '3.3', // which version of WordPress is your plugin tested up to?
			'readme' => 'readme.txt', // which file to use as the readme for the version number
			'access_token' => '', // Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed
		);

		new WP_GitHub_Updater( $config );

	}

}
//* Updater init *//


// Add Admin Stuff
add_action( 'admin_menu', 'click_to_call_add_admin_menu' );
add_action( 'admin_init', 'click_to_call_settings_init' );
add_action( 'admin_enqueue_scripts', 'ctc_add_color_picker' );
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

//Add Click To Call Bar to Footer
add_action( 'wp_footer', 'click_to_call_code' );
//Adds Translation to Click to call bar
add_action('plugins_loaded', 'ctc_load_textdomain');
//loads Translation
function ctc_load_textdomain() {
	load_plugin_textdomain( 'click-to-call', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
// admin Panel
include_once 'admin/admin.php';


// Output Code If Enabled
function click_to_call_code() {
    $options = get_option( 'click_to_call_settings' );
		if(isset($options['click_to_call_bg'])){
			echo '<div id="click_to_call_bar" class="ctc_bar" style="direction: ' .$clickToCallDirection = __('ltr', 'click-to-call'). '; background-color:' .$options['click_to_call_bg'] . '; '. $options['click_to_call_customcss'] .'">';
		}
		else{
			echo '<div id="click_to_call_bar" class="ctc_bar" style="direction: ' .$clickToCallDirection = __('ltr', 'click-to-call'). '; background-color: #000000;'. $options['click_to_call_customcss'] .'">';
		}
			if ($options['click_to_call_enable'] == '1') {
				echo "<a href='tel:" . $options['click_to_call_number'] ."' style='padding-right: 21px; padding-left:21px; color:" . $options['click_to_call_color'] . "'>
				<i class='ctc-fa fa " . $options['click_to_call_icon'] . "'></i></span>" . $options['click_to_call_message'] . "</a>";
			}

			if ($options['click_to_contact_enable'] == '1') {
				echo "<a href='" .$options['click_to_contact_link']. "' id='ctc_contact_toggle' style='color:" . $options['click_to_call_color'] . "'><i class='ctc-fa fa " . $options['click_to_contact_icon'] . "'></i> " . $options['click_to_contact_message'] . "</a>";
			}
	
		echo '</div>';
		//Include style.css and fontawasome addon
	    wp_enqueue_style('ctc-styles', plugin_dir_url( __FILE__ ) . 'css/ctc_style.css' );
		wp_enqueue_style('ctc-styles-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' );
}
