<?php
/*
Plugin Name: click to Call

Plugin URI: https://github.com/tsz1412/click-to-call.git

Description: Add a simple click to call bar to the bottom of your page on mobile devices.

Version: 2.0.0

Author: Tsviel Zaikman

Author URI: http://introweb.co.il

License: License: GPLv2 or later

Text Domain: click-to-call

Domain Path /languages/

*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! defined( 'PLUGIN_DIR' ) ){
	define('PLUGIN_DIR' , plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'PLUGIN_DIR_FILE' ) ){
	define('PLUGIN_DIR_FILE' , basename( dirname( __FILE__ ) ) );
}

//* Include & Require: *//
// admin Panel
include_once 'admin/admin.php';
//Contact Form

require 'updater/plugin-update-checker.php';
	$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/tsz1412/click-to-call',
	__FILE__,
	'click-to-call'
);



//Donation section, Do not remove please so we can invest your donations for upgrading the plugin
add_action('wp_dashboard_setup', 'ctc_dashboard_widgets');
  
//* Include & Require: *//
function ctc_load_plugin_style()
{
	//Include style.css and fontawasome addon
	    wp_enqueue_style('ctc-styles', PLUGIN_DIR . 'css/ctc_style.min.css' );
		wp_enqueue_style('ctc-styles-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' );
		wp_enqueue_style('ctc-styles-bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css' );
		
		wp_enqueue_script('ctc-script-jquery' , 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
		wp_enqueue_script('ctc-script-bootstrap' , 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');
		
	// Add Admin Stuff
}
add_action( 'admin_menu', 'click_to_call_add_admin_menu' );
add_action( 'admin_init', 'click_to_call_settings_init' );
add_action( 'admin_enqueue_scripts', 'ctc_add_color_picker' );
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
//Add Click To Call Bar to Footer
add_action( 'wp_footer' , 'ctc_load_plugin_style');
add_action( 'wp_footer', 'click_to_call_code' );
//Adds Translation to Click to call bar
add_action('plugins_loaded', 'ctc_load_textdomain');
//loads Translation
function ctc_load_textdomain() {
	load_plugin_textdomain( 'click-to-call', false, PLUGIN_DIR_FILE . '/languages' );
}

function click_to_call_code() {
    $options = get_option( 'click_to_call_settings' );
	if(!isset($options['click_to_call_sticky_enable'])){
		$options['click_to_call_sticky_enable'] = 0;
	}
	if($options['click_to_call_sticky_enable'] == '1'){
		if($options['click_to_contact_link'] == "#ContactUsNow"){
			echo '<div data-spy="affix" data-offset-top="197" ><div class="accordion-body collapse" id="ContactUsNow" style="direction: ' .$clickToCallDirection = __('ltr', 'click-to-call'). '; background-color: #000000;"';
			echo '<span style="color: #ffffff">';
			echo "<a data-toggle='collapse' data-target='#ContactUsNow' href='#' id='ctc_contact_toggle'><i class='fa fa-chevron-down' style='color #fff'></i></a>";
			echo do_shortcode( $options['click_to_contact_shortcode'] );
			echo '</span>';
			echo '</div></div>';
		}
		if(isset($options['click_to_call_bg'])){
			echo '<div data-spy="affix" data-offset-top="197" id="click_to_call_bar" class="ctc_bar sticky-bottom" style="direction: ' .$clickToCallDirection = __('ltr', 'click-to-call'). '; background-color:' .$options['click_to_call_bg'] . ';">';
		}
		else{
			echo '<div data-spy="affix" data-offset-top="197" id="click_to_call_bar" class="ctc_bar" style="direction: ' .$clickToCallDirection = __('ltr', 'click-to-call'). '; background-color: #000000;">';
		}
		
		
			if ($options['click_to_call_enable'] == '1') {
				echo "<a href='tel:" . $options['click_to_call_number'] ."' style='padding-right: 21px; padding-left:21px; color:" . $options['click_to_call_color'] . "'>
				<i class='ctc-fa fa " . $options['click_to_call_icon'] . "'></i></span>" . $options['click_to_call_message'] . "</a>";
			}

			if ($options['click_to_contact_enable'] == '1') {
				echo "<a data-toggle='collapse' data-target='".$options['click_to_contact_link']."'  id='ctc_contact_toggle' style='color:" . $options['click_to_call_color'] . "'><i class='ctc-fa fa " . $options['click_to_contact_icon'] . "'></i> " . $options['click_to_contact_message'] . "</a>";
			}
	
		echo '</div>';
	}
	else{
		
	}
		
}