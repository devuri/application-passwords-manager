<?php

namespace SwitchWeb;

if ( ! class_exists( 'SwitchWeb\Settings' ) ) {

	/**
	 * Settings
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_settings_field/
	 */
	class Settings {

		/**
		 * Settings $option_group
		 *
		 * (string) (Required) A settings group name.
		 * Should correspond to an allowed option key name.
		 *
		 * Default allowed option key names include 'general', 'discussion',
		 * 'media', 'reading', 'writing', 'misc', 'options', and 'privacy'.
		 *
		 * @var string $option_group
		 */
		private $option_group = 'general';

		/**
		 * Settings field name
		 *
		 * @var $settings_field
		 */
		private $settings_field = 'apsm_status';

		/**
		 * Settings field name
		 *
		 * (Required) The slug-name of the settings page
		 * on which to show the section (general, reading, writing, ...).
		 *
		 * @var string $page
		 */
		private $page = 'general';

		/**
		 * Application_Passwords::initialize
		 *
		 * @return object
		 */
		public static function init() {
			return new Settings();
		}

		/**
		 * Setup
		 */
		private function __construct() {
	        add_filter( 'admin_init', array( $this, 'register' ) );
			add_filter( 'plugin_action_links', array( $this, 'add_plugin_link' ), 10, 2 );
	    }

		/**
		 * Register the settings and Add Field
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_setting/
		 * @link https://developer.wordpress.org/reference/functions/add_settings_field/
		 */
		public function register() {

			register_setting(
				$this->option_group,
				$this->settings_field,
				array(
					'type'              => 'integer',
					'description'       => 'disable application passwords',
					'sanitize_callback' => 'absint',
					'show_in_rest'      => true,
					'default'           => 0,
				)
			);

	        add_settings_field(
				$this->settings_field,
				__( 'Disable Application Passwords', 'application-passwords-manager' ),
				array( $this, 'render_settings_html' ),
				$this->page,
				'default',
				array(
					'type'        => 'checkbox',
					'name'        => $this->settings_field,
					'label_for'   => $this->settings_field,
					'description' => __( 'Check to Disable Application Passwords', 'application-passwords-manager' ),
				)
			);
	    }

		/**
		 * Callback
		 */
		public function render_settings_html() {
			$this->checkbox_input();
	    }

		/**
		 * Check status
		 */
		private function disable_status() {

			if ( false === get_option( $this->settings_field, false ) ) {
				return false;
			}
			$status = absint( get_option( $this->settings_field ) );
			return boolval( $status );
	    }

		/**
		 * The Checkbox
		 */
		private function checkbox_input() {

			if ( 1 === absint( get_option( $this->settings_field, 0 ) ) ) {
				$checked = 'checked';
			} else {
				$checked = '';
			}

			?><label for="<?php echo esc_attr( $this->settings_field ); ?>">
				<input name="<?php echo esc_attr( $this->settings_field ); ?>" type="checkbox" id="<?php echo esc_attr( $this->settings_field ); ?>" value="1" <?php echo esc_attr( $checked ); ?>>
					<?php esc_html_e( 'Disable Application Passwords.', 'application-passwords-manager' ); ?>
				</label>
			<?php
		}

		/**
		 * Add Settings link.
		 *
		 * @param array  $plugin_actions An array of plugin action links.
		 * @param string $plugin_file    Path to the plugin file relative to the plugins directory.
		 *
		 * @link https://developer.wordpress.org/reference/hooks/plugin_action_links/
		 * @return array $plugin_actions.
		 */
		public function add_plugin_link( $plugin_actions, $plugin_file ) {
			$apsm_actions = array();
			if ( APSM_DIR . '/appsm.php' === $plugin_file ) {
				$setlink = esc_url( admin_url( 'options-general.php#apsm_status' ) );
				$apsm_actions['apm_settings'] = sprintf( __( '<a href="%s">Settings</a>', 'application-passwords-manager' ), $setlink ); // @codingStandardsIgnoreLine
			}
			return array_merge( $apsm_actions, $plugin_actions );
		}

	}

}
