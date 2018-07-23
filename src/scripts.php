<?php
/*
Plugin Name: fdls Plugin
Plugin URI:
Description: Add functions needed by fdls
Version: 1.0.1
Author: Yann Pelud
Author URI: 
License: MIT
*/

/**
 * Never worry about cache again!
 */
function fdls_scripts($hook) {
 
    // create my own version codes
    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'fdls.js' ));
    wp_enqueue_script( 'fdls_js', plugins_url( 'fdls.js', __FILE__ ), array(), $my_js_ver );

    $options = get_option('fdls'); 
    // Localize the script with new data
    $opts_array = array(
        'hideclass' => $options['hideclass']
    );
    wp_localize_script( 'fdls_js', 'opts_fdls', $opts_array );
}

add_action('wp_enqueue_scripts', 'fdls_scripts');


add_action('admin_init', 'fdls_init' );
add_action('admin_menu', 'fdls_add_page');

// Init plugin options to white list our options
function fdls_init(){
	register_setting( 'fdls_options', 'fdls', 'fdls_validate' );
}

// Add menu page
function fdls_add_page() {
	add_options_page('fdls Options', 'fdls', 'manage_options', 'fdls', 'fdls_do_page');
}

// Draw the menu page itself
function fdls_do_page() {
	?>
	<div class="wrap">
		<h2>fdls Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('fdls_options'); ?>
			<?php $options = get_option('fdls'); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row">Classes ou ids (css) à cacher</th>
					<td><input type="text" name="fdls[hideclass]" value="<?php echo $options['hideclass']; ?>" /></td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function fdls_validate($input) {

	// Say our second option must be safe text with no HTML tags
	$input['hideclass'] =  wp_filter_nohtml_kses($input['hideclass']);
	
	return $input;
}

?>