<?php
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

//call now enabler
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

//call function fields
    add_settings_field(
        'click_to_call_message',
        __( 'Your Click to Call Message', 'click-to-call' ),
        'click_to_call_message_render',
        'ctc_plugin_page',
        'click_to_call_ctc_plugin_page_section'
    );

	
//contact us fields
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