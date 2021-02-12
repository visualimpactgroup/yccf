<?php

/* 
 * Sets up the editor button for all TSG tools.
 */

if ( ! function_exists( 'add_tsg_tools_button' ) ) {
	function add_tsg_tools_button( $context ) {

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-accordion' );

		global $post_ID, $temp_ID;
		$iframe_post_id = (int) ( 0 == $post_ID ? $temp_ID : $post_ID );
		$ajax_url       = admin_url( 'admin-ajax.php' );

		//append the icon
		$code = '<a class="button thickbox" data-editor="content" title="TSG Stoage Tools"';
		$code .= 'href="' . $ajax_url . '?action=tsg_shortcodes&&post_id=' . $iframe_post_id . '&width=753' . '"';
		$code .= '><div style="color: #999; padding-top: 3px;" class="dashicons dashicons-lock"></div>Add Storage Tools</a>';

		$context .= $code;

		return $context;
	}

	if ( has_action( 'media_buttons_context', 'add_tsg_tools_button' ) == false ) {
		add_action( 'media_buttons_context', 'add_tsg_tools_button' );
	}
}

if ( ! function_exists( 'display_tsg_shortcodes_form' ) ) {

	function display_tsg_shortcodes_form() {
		$formTabs = array();
		$formTabs = apply_filters( 'TSG_shortcode_button_tabs', $formTabs );

		?>
		<style type="text/css">
			#settingsAccordion {
				margin : 15px 0 15px 0;
			}
			#settingsAccordion .ui-accordion-header {
				display          : block;
				cursor           : pointer;
				position         : relative;
				margin           : 0;
				padding          : .5em .5em .5em .7em;
				min-height       : 0; /* support: IE7 */
				font-size        : 100%;
				border           : 1px solid #aaa;
				background-color : #fafafa;
				color            : #888;
			}
			#settingsAccordion .ui-accordion-header-active {
				background-color : #fff;
				color            : #000;
				border-bottom    : 0;
			}
			#settingsAccordion .ui-accordion-content {
				padding    : 1em 2.2em;
				border     : 1px solid #ccc;
				border-top : 0;
				overflow   : auto;
			}
		</style>
		<script type="text/javascript">
			jQuery(function () {
				jQuery("#settingsAccordion").accordion({
					collapsible: true
				});
			});
			<?php foreach ($formTabs as $tab) {
				echo($tab['script']);
			}?>

			function addCode(code) {
				isVisual = jQuery( "#wp-content-wrap", window.parent.document ).hasClass( "tmce-active" );

				try {
					win.send_to_editor( code );
				} catch ( e ) {

					if (isVisual) {
						tinyMCE.activeEditor.execCommand("mceInsertContent", 0, code);
					} else {
						var currentCode = jQuery( "#content", window.parent.document ).val();
						jQuery( "#content", window.parent.document ).val( currentCode + " " + code );
					}

				}
			}
		</script>
		<div id="settingsAccordion">

			<?php foreach ( $formTabs as $tab ) {
				echo( '<h3><div class="dashicons ' . $tab['icon'] . '"></div>' . $tab['title'] . '</h3>' );
				echo( '<div>' );
				echo( $tab['form'] );
				echo( '</div>' );
			}?>
		</div>

		<?php exit;
	}

	if ( has_action( 'wp_ajax_tsg_shortcodes', 'display_tsg_shortcodes_form' ) == false ) {
		add_action( 'wp_ajax_tsg_shortcodes', 'display_tsg_shortcodes_form' );
	}
}
?>
