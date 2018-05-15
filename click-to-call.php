<?php



/*

Plugin Name: Click to Call

Plugin URI: https://github.com/tsz1412/click-to-call.git

Description: Add a simple click to call bar to the bottom of your page on mobile devices.

Version: 1.0.0

Author: Tsviel Zaikman

Author URI: http://tsz-dev.com

License: License: GPLv2 or later

Text Domain: click-to-call

Domain Path /languages/

*/

//Updater
/*
include_once(plugin_dir_path( __FILE__ ) . 'update.php');
$updater = new ClickToCallUpdater( __FILE__ ); // instantiate our class
$updater->set_username( 'tsz1412' ); // set username
$updater->set_repository( 'click-to-call' ); // set Repo name
$updater->initialize(); // initialize the updater
*/

// Add Admin Stuff
include_once(plugin_dir_path( __FILE__ ) . 'updater.php');
add_action( 'init', 'github_ClickToCall_updater_init' );
function github_ClickToCall_updater_init() {
	include_once 'updater.php';
	define( 'WP_GITHUB_FORCE_UPDATE', true );
	if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'github-updater',
			'api_url' => 'https://github.com/tsz1412/click-to-call.git',
			'raw_url' => 'https://github.com/tsz1412/click-to-call.git',
			'github_url' => 'https://github.com/tsz1412/click-to-call.git',
			'zip_url' => 'https://github.com/tsz1412/click-to-call.git',
			'sslverify' => true,
			'requires' => '3.0',
			'tested' => '3.3',
			'readme' => 'README.md',
			'access_token' => 'c5513e206d443240a8fab736a22ad685e71f8f3f',
		);
		new WP_GitHub_Updater( $config );
	}
}

add_action( 'admin_menu', 'click_to_call_add_admin_menu' );

add_action( 'admin_init', 'click_to_call_settings_init' );

add_action( 'admin_enqueue_scripts', 'ctc_add_color_picker' );



//Add Click To Call Bar to Footer



add_action( 'wp_footer', 'click_to_call_code' );

//Adds Translation to Click to call bar

add_action('plugins_loaded', 'ctc_load_textdomain');



//loads Translation

function ctc_load_textdomain() {

	load_plugin_textdomain( 'click-to-call', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );

}





// Load Color Picker



function ctc_add_color_picker( $hook ) {



    if( is_admin() ) {



        // Add Color Picker CSS

        wp_enqueue_style( 'wp-color-picker' );



        // Include Color Picker JS

        wp_enqueue_script( 'custom-script-handle', plugins_url( 'js/ctc.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

    }

}



// Add to Menu > Tools



function click_to_call_add_admin_menu() {



    add_submenu_page( 'options-general.php', 'Click to Call', __('Click to Call', 'click-to-call'), 'manage_options', 'click_to_call', 'click_to_call_options_page' );



}



// Adding Settings



function click_to_call_settings_init() {



    register_setting( 'ctc_plugin_page', 'click_to_call_settings' );

	$ctcPluginDescription = __( 'A simple plugin that adds click to call functionality to your WordPress site on mobile devices.', 'click-to-call' );

    add_settings_section(

        'click_to_call_ctc_plugin_page_section',

        $ctcPluginDescription,

        'click_to_call_settings_section_callback',

        'ctc_plugin_page'

    );

	//call

    add_settings_field(

        'click_to_call_enable',

        __( 'Enable Click to Call', 'click-to-call' ),

        'click_to_call_enable_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );

	//contact

	add_settings_field(

        'click_to_contact_enable',

        __( 'Enable Click to Contact', 'click-to-call' ),

        'click_to_contact_enable_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );



	//call

    add_settings_field(

        'click_to_call_message',

        __( 'Your Click to Call Message', 'click-to-call' ),

        'click_to_call_message_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );

	

	//contact

	add_settings_field(

        'click_to_contact_message',

        __( 'Your Click to Contact Message', 'click-to-call' ),

        'click_to_contact_message_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );

	

	add_settings_field(

        'click_to_contact_link',

        __( 'Your Click to Contact link', 'click-to-call' ),

        'click_to_contact_link_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );



    add_settings_field(

        'click_to_call_number',

        __( 'Your Click to Call Number', 'click-to-call' ),

        'click_to_call_number_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );



    add_settings_field(

        'click_to_call_color',

        __( 'Click to Call Text Color', 'click-to-call' ),

        'click_to_call_color_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );



    add_settings_field(

        'click_to_call_bg',

        __( 'Click to Call Background Color', 'click-to-call' ),

        'click_to_call_bg_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );

	add_settings_field(

        'click_to_call_customcss',

        __( 'Click to Call custom css', 'click-to-call' ),

        'click_to_call_customcss_render',

        'ctc_plugin_page',

        'click_to_call_ctc_plugin_page_section'

    );

}



// Render Admin Input



function click_to_call_enable_render() {



    $options = get_option( 'click_to_call_settings' );

    ?>

    <input name="click_to_call_settings[click_to_call_enable]" type="hidden" value="0" />

    <input name="click_to_call_settings[click_to_call_enable]" type="checkbox" value="1" <?php checked( '1', $options['click_to_call_enable'] ); ?> />



    <?php



}



function click_to_contact_enable_render() {



    $options = get_option( 'click_to_call_settings' );

    ?>

    <input name="click_to_call_settings[click_to_contact_enable]" type="hidden" value="0" />

    <input name="click_to_call_settings[click_to_contact_enable]" type="checkbox" value="1" <?php checked( '1', $options['click_to_contact_enable'] ); ?> />



    <?php



}





function click_to_call_message_render() {

    $options = get_option( 'click_to_call_settings' );

    ?>

    <input type='text' placeholder="ex. Call Now!" name='click_to_call_settings[click_to_call_message]' value='<?php echo $options['click_to_call_message']; ?>'>

    <?php



}





function click_to_call_number_render() {



    $options = get_option( 'click_to_call_settings' );

    ?>

    <input type='text' placeholder="ex. 5555555555" name='click_to_call_settings[click_to_call_number]' value='<?php echo $options['click_to_call_number']; ?>'>

    <?php



}





function click_to_call_color_render() {



    $options = get_option( 'click_to_call_settings' );

    ?>

    <input type='text' class="color-field"  name='click_to_call_settings[click_to_call_color]' value='<?php echo $options['click_to_call_color']; ?>'>

    <?php



}





function click_to_call_bg_render() {



    $options = get_option( 'click_to_call_settings' );

    ?>

    <input type='text' class="color-field" name='click_to_call_settings[click_to_call_bg]' value='<?php echo $options['click_to_call_bg']; ?>'>

    <?php



}



function click_to_call_customcss_render() {



    $options = get_option( 'click_to_call_settings' );

    ?>

	<textarea name='click_to_call_settings[click_to_call_customcss]'><?php echo $options['click_to_call_customcss']; ?></textarea>

    <?php



}





function click_to_contact_message_render() {

    $options = get_option( 'click_to_call_settings' );

    ?>

    <input type='text' placeholder="We will call you back" name='click_to_call_settings[click_to_contact_message]' value='<?php echo $options['click_to_contact_message']; ?>'>

    <?php



}



function click_to_contact_link_render() {

    $options = get_option( 'click_to_call_settings' );

    ?>

    <input type='text' placeholder="'<?php __('leave # for Effect') ?>" name='click_to_call_settings[click_to_contact_link]' value='<?php echo $options['click_to_contact_link']; ?>'>

    <?php



}

function click_to_call_settings_section_callback() {

    echo __( 'Enter your information in the fields below. If you don\'t enter anything into the message area a phone icon will still show. Google Analytics event tracking is added and will show under the events section as \'Phone\'. The plugin will only show on devices with a screen width under 736px. ', 'click_to_call' );



}



// Output Code If Enabled



function click_to_call_code() {

    $options = get_option( 'click_to_call_settings' );

    

        /*

		echo '<a href="tel:' . $options['click_to_call_number'] . '" onclick="ga(\'send\',\'event\',\'Phone\',\'Click To Call\', \'Phone\')"; style="color:' . $options['click_to_call_color'] . ' !important; background-color:' . $options['click_to_call_bg'] . ';" class="ctc_bar" id="click_to_call_bar""> <span class="icon  ctc-icon-phone"></span>' . $options['click_to_call_message'] . '</a>'

			

		;*/
		if(isset($options['click_to_call_bg'])){
			echo '<div id="click_to_call_bar" class="ctc_bar" style="direction: ' .$clickToCallDirection = __('ltr', 'click-to-call'). '; background-color:' .$options['click_to_call_bg'] . '; '. $options['click_to_call_customcss'] .'">';	
		}
		else{
			echo '<div id="click_to_call_bar" class="ctc_bar" style="direction: ' .$clickToCallDirection = __('ltr', 'click-to-call'). '; background-color: #000000;'. $options['click_to_call_customcss'] .'">';
		}
		

			if ($options['click_to_call_enable'] == '1') {

				echo "<a href='tel:" . $options['click_to_call_number'] ."' onclick='ga(\"send\",\"event\",\"Phone\",\"Click To Call\", \"Phone\")'; style='padding-right: 21px; padding-left: 21; color:" . $options['click_to_call_color'] . "' !important;>

				<i class='ctc-fa fa fa-phone'></i></span>" . $options['click_to_call_message'] . "</a>";

			}

	

			if ($options['click_to_contact_enable'] == '1') {

				echo "<a href='" .$options['click_to_contact_link']. "' id='ctc_contact_toggle' style='color:" . $options['click_to_call_color'] . "' !important;>

				<i class='ctc-fa fa fa-plane'></i> " . $options['click_to_contact_message'] . "</a>";



			}

		echo '</div>';

	    wp_enqueue_style('ctc-styles', plugin_dir_url( __FILE__ ) . 'css/ctc_style.css' );

		wp_enqueue_style('ctc-styles', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css' );



}



// Display Admin Form



function click_to_call_options_page() {



    ?>

    <form action='options.php' method='post'>



        <h1><?php _e('Click to Call', 'click-to-call') ?></h1>



        <?php

        settings_fields( 'ctc_plugin_page' );

        do_settings_sections( 'ctc_plugin_page' );

        submit_button();

        ?>



    </form>

    <?php



}



?>

