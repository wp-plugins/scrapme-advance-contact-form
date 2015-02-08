<?php
/*
 * @package scrap.me
 * @version 1
 */
/*
 Plugin Name: scrap.me
 Plugin URI: http://scrap.me/
 Description: Get an advance contact form for your site and offer site wide deals with additional tools like Deal Bar, Popups, Inline Popups, Social Bar, Leave intent targeting. Before activating the plugin please register an account from http://scrap.me and insert the API key here.
 Version: 1.0
 Author: scrap.me
 Author URI: http://scrap.me
 License: GPLv2
 */
function scrapme_add_data() {
	$scrapme_apikey = trim(get_option('scrapme_api_key'));
	if(isset($scrapme_apikey) && strlen($scrapme_apikey) == 32){
		echo "<!--SCRAP.ME CODE-->".
		"<script type='text/javascript'>var apikey = '". $scrapme_apikey ."';</script>".
		"<script type='text/javascript' src='http://scrap.me/widget/popup/v1/script.js'></script>".
		"<div id='scrapme' class='scrapme'></div>".
		"<!--SCRAP.ME CODE-->";
	}
}
add_action('wp_footer', 'scrapme_add_data');
add_shortcode("scrapmelink", "scrapmelink_function");

function scrapmelink_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "href" => 'scrapme_popup',
      "scrapme_redirect_url" => 'NA',
      "title" => '',
      "style" => ''
   ), $atts));
   return '<a href="'.$href.'" scrapme_redirect_url="'.$scrapme_redirect_url.'" title="'. $title .'" style="'. $style .'">'. $content .'</a>';
}

// create custom plugin settings menu
add_action('admin_menu', 'baw_create_menu');

function baw_create_menu() {

	//create new top-level menu
	add_menu_page('Scrap.me Plugin Settings', 'Scrap.me', 'administrator', __FILE__, 'baw_settings_page','');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'baw-settings-group', 'scrapme_api_key' );
}

function baw_settings_page() {
	?>
<div class="wrap">
<h2>Set Scrap.me API Key</h2>

<form method="post" action="options.php"><?php settings_fields( 'baw-settings-group' ); ?>
	<?php do_settings_sections( 'baw-settings-group' ); ?>
<table class="form-table">
	<tr valign="top">
		<th scope="row">API Key</th>
		<td><input type="text" maxlength="32" style="width: 300px;"
			name="scrapme_api_key"
			value="<?php echo esc_attr( get_option('scrapme_api_key') ); ?>" /></td>
	</tr>

</table>
<div>API Key is 32 bit long. Please do not enter any special characters
or space in the key.</div>
	<?php submit_button(); ?>
<div style="padding: 4px;">You can get the API key by registering from <a
	href="http://scrap.me/register.php" target="_blank"
	style="text-decoration: none">http://scrap.me/register.php</a>. To see
a live demo on your website visit <a
	href="http://scrap.me/show_demo.html" target="_blank"
	style="text-decoration: none">Demo Page</a></div>
</form>
</div>
	<?php } ?>