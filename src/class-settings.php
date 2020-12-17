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
		private $settings_field = 'sim_disable_application_passwords';

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
					'default'           => 1,
				),
			);

	        add_settings_field(
				$this->settings_field,
				esc_attr__( 'Disable Application Passwords', 'disable-app-passwords' ),
				array( $this, 'field_output' ),
				$this->page,
				'default',
				array(
					'label_for' => $this->settings_field,
				),
			);
	    }

		/**
		 * Callback
		 */
		public function field_output() {
			$this->checkbox_input();
	    }

		/**
		 * Check status
		 */
		private function disable_status() {

			if ( false === get_option( $this->settings_field, false ) ) {
				return false;
			}
			$status = get_option( $this->settings_field );
			return boolval( $status );
	    }

		/**
		 * The Checkbox
		 */
		private function checkbox_input() {

			if ( true === $this->disable_status() ) {
				$checked = 'checked';
			} else {
				$checked = '';
			}

			?><label for="sim_disable_application_passwords">
				<input name="sim_disable_application_passwords" type="checkbox" id="sim_disable_application_passwords" value="1" <?php echo esc_attr( $checked ); ?>>
					<?php echo esc_attr__( 'Disable Application Passwords.', 'disable-app-passwords' ); ?>
				</label>
			<?php
		}

	}

}
