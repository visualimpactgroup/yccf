<?php
/**
 * Plugin Name: Clickandstor Shortcode Loader
 * Plugin URI: http://www.storageinternetmarketing.com
 * Description: This adds the [cas] shortcode to the site. Use it to include Clickandstor on any page.
 * Version: 1.0.4
 * Author: The Storage Group
 * Author URI: http://www.storageinternetmarketing.com
 * License: For private use only.
 */

define( 'CAS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CAS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Plugin Update Checker.
require_once( CAS_PLUGIN_PATH . 'plugin-updates/plugin-update-checker.php' );
$MyUpdateChecker = PucFactory::buildUpdateChecker( 'http://skynet-updates.tsg-dev.com/plugins/clickandstor-shortcode/info.json', __FILE__, 'clickandstor-shortcode' );

// Include tools button code.
$settings = get_option( 'cas-plugin-settings', array(
	'show-button' => 'yes',
) );
if ( $settings['show-button'] == 'yes' ) {
	require_once( CAS_PLUGIN_PATH . 'tsg-tools-button.php' );
}

/*
 * Main Plugin Class
 */

class Clickandstor_Shortcode {

	static $add_cas_script = array();

	static function init() {
		add_shortcode( 'cas', array( __CLASS__, 'handle_shortcode' ) );
		add_action( 'admin_menu', array( __CLASS__, 'cas_admin_menu_create' ) );
		add_filter( 'TSG_shortcode_button_tabs', array( __CLASS__, 'cas_shortcode_btn_code' ) );
		add_action('init', array(__CLASS__, 'register_script'));
		add_action('wp_footer', array(__CLASS__, 'print_cas_scripts'));
		add_action('init', array(__CLASS__, 'cas_query_vars'));
	}

	static function register_script() {
		wp_register_script( 'cas-script', 'https://www.clickandstor.com/CAS_API/init.js', array(), '2.0' );
	}

	static function cas_query_vars() {
		global $wp;
		$wp->add_query_var('form');
		$wp->add_query_var('casMode');
		$wp->add_query_var('casmode');
	}

	static function handle_shortcode( $atts ) {

		$settings = get_option( 'cas-plugin-settings', array(
			'facility-id' => 38,
		) );
		if($settings['facility-id'] == '38'){
			$facility = '';
		}else{
			$facility = $settings['facility-id'];
		}
		extract( shortcode_atts( array(
			'mode'     => 'movein',
			'facility' => $facility,
			'getURL' => true,
			'width' => '100%',
			'height' => '100px'
		), $atts ) );

		if ($getURL) {
			$mode = get_query_var('casmode', $mode);
			$mode = get_query_var('casMode', $mode);
		}

		$divID = ( ( $mode == 'login' ) ? 'casLoginDiv' : 'casRentDiv' ) . count(self::$add_cas_script);



		$code = '<div class="divSelector casdiv"></div>';
		$code .= '<div id="'. $divID .'" class="targetContainer" style="">';
		$code .= '<div class = "demoLabel"></div>';
		$code .= '</div>';

		self::$add_cas_script[] .= '{
			"fid": ' . $facility . ',
			"mode":"' . ( ( $mode == 'login' ) ? 'unit-ledger-form' : 'unit-table-p' ) . '",
			"target":"'. $divID .'",
			"width":"'. $width .'",
			"height":"'. $height .'"
		}';

		return $code;
	}

	static function print_cas_scripts() {
		if ( empty(self::$add_cas_script) )
			return;

		wp_print_scripts('cas-script');

		echo('<script type="text/javascript">');

		echo('var lsInit = {"livestor": [');
		foreach (self::$add_cas_script as $i => $data) {
			if ($i > 0) {
				echo (',');
			}
			echo($data);
		}
		echo(']}; initLS(lsInit); ');
		echo('</script>');

	}

	static function cas_admin_menu_create() {
		add_options_page( 'ClickandStor Shortcode Settings', 'ClickandStor Shortcode', 'manage_options', 'cas-shortcode-admin', array(
				__CLASS__,
				'cas_options_page'
			) );
		add_action( 'admin_init', array( __CLASS__, 'register_cas_settings' ) );
	}

	static function register_cas_settings() {
		register_setting( 'cas-plugin-settings', 'cas-plugin-settings', array( __CLASS__, 'validate_options' ) );
	}

	static function cas_options_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		}
		?>
		<div class="wrap">
			<h2>ClickandStor Shortcode Options</h2>

			<p>To add ClickandStor to any page, simply add the shortcode [cas} to the content of any page.</p>

			<?php if ( false !== $_REQUEST['updated'] ) {
				echo( '<div><p><strong>Options saved</strong></p></div>' );
			}?>

			<form method="post" action="options.php">
				<?php

				$settings = get_option( 'cas-plugin-settings', array(
					'facility-id' => 38,
					'show-button' => 'yes',
				) );

				settings_fields( 'cas-plugin-settings' );
				do_settings_sections( 'cas-plugin-settings' );
				?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="facility-id">Default Facility ID</label></th>
						<td>
							<input type="text" id="facility-id" name="cas-plugin-settings[facility-id]" value="<?php echo $settings['facility-id']; ?>"/>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="show-button">Add "Storage Tools" button to editor</label></th>
						<td>
							<select id="show-button" name="cas-plugin-settings[show-button]">
								<option style="padding-right: 10px;" value="no" <?php if ( $settings['show-button'] == 'no' ) {
									echo( 'selected="selected"' );
								} ?>>No
								</option>
								<option style="padding-right: 10px;" value="yes" <?php if ( $settings['show-button'] == 'yes' ) {
									echo( 'selected="selected"' );
								} ?>>Yes
								</option>
							</select>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php
	}

	static function validate_options( $input ) {

		$prevSettings = get_option( 'cas-plugin-settings', array(
			'facility-id' => 38,
			'show-button' => 'yes',
		) );

		$input['facility-id'] = wp_filter_nohtml_kses( $input['facility-id'] );
		if ( ( $input['show-button'] != 'yes' ) && ( $input['show-button'] != 'no' ) ) {
			$input['show-button'] = $prevSettings['show-button'];
		}

		return $input;
	}

	function cas_shortcode_btn_code( $input ) {
		$page['title']  = 'ClickandStor';
		$page['icon']   = 'dashicons-list-view';
		$page['script'] = '
	jQuery( "#cas-settiings-form" ).submit(function( event ) {
			var code = "[cas";

			var fac = jQuery( "#cas-fac-id" ).val();
			if (fac.length) {
				code += " facility="+fac;
			}
			var mode = jQuery( "#cas-mode" ).val();
			if (mode.length) {
				code += " mode="+mode;
			}
			code += "]";
			addCode(code);
			tb_remove();
			event.preventDefault();
		});';
		$page['form']   = '<form ID="cas-settiings-form" action="#" >
		<table class="form-table">

            <tr valign="top">
            <th scope="row">Facility ID:</th>
            <td><input type="text" name="cas-fac-id" id="cas-fac-id" /><br /><small>Leave blank to use default setting.</td>
            </tr>

            <tr valign="top">
            <th scope="row">Display Mode:</th>
            <td>
				<select name="cas-mode" id="cas-mode">
					<option style="padding-right: 10px;" value="movein" selected="selected">Move In</option>
					<option style="padding-right: 10px;" value="login">Login / Pay</option>
				</select>
			</td>
            </tr>

		</table>
        <input type="submit" value="Add Form">
        </form>
';

		$input[] = $page;

		return $input;
	}
}

Clickandstor_Shortcode::init();

?>