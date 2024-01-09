<?php
/**
 * Application Passwords Manager
 *
 * @package   ApplicationPasswordsManager
 * @author    Uriel Wilson
 * @copyright 2020 Uriel Wilson
 * @license   GPL-2.0
 * @link      https://urielwilson.com
 *
 * @wordpress-plugin
 * Plugin Name:       Application Passwords Manager
 * Plugin URI:        https://wpbrisko.com/wordpress-plugins/
 * Description:       This plugin will disable/enable WordPress 5.6 Application Passwords.
 * Version:           0.3.1
 * Requires at least: 5.6
 * Requires PHP:      5.6
 * Author:            uriel
 * Author URI:        https://urielwilson.com
 * Text Domain:       application-passwords-manager
 * Domain Path:       languages
 * License:           GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

  	// deny direct access.
    if ( ! defined( 'WPINC' ) ) {
      	die;
    }

	// plugin directory.
	define( 'APSM_DIR', basename( plugin_dir_path( __FILE__ ) ) );

// -----------------------------------------------------------------------------

	/**
	 * Setup options on activation
	 */
	register_activation_hook( __FILE__, function () {
			if ( false === get_option( 'apsm_status', false ) ) {
				update_option( 'apsm_status', '0' );
			}
		}
	);

	/**
	 *  Load class.
	 */
	require_once plugin_dir_path( __FILE__ ) . '/src/class-application-passwords.php';
	require_once plugin_dir_path( __FILE__ ) . '/src/class-settings.php';

	/**
	 * Application Passwords
	 *
	 * @link https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
	 */
	SwitchWeb\Application_Passwords::init();
