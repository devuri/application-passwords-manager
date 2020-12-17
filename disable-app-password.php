<?php
/**
 * Disable App Passwords
 *
 * @package   DisableAppPasswords
 * @author    Uriel Wilson
 * @copyright 2020 Uriel Wilson
 * @license   GPL-2.0
 * @link      https://urielwilson.com
 *
 * @wordpress-plugin
 * Plugin Name:       Disable App Passwords
 * Plugin URI:        https://switchwebdev.com/wordpress-plugins/
 * Description:       This plugin will disable WordPress 5.6 Application Passwords.
 * Version:           0.0.4
 * Requires at least: 5.6
 * Requires PHP:      5.6
 * Author:            SwitchWebdev.com
 * Author URI:        https://switchwebdev.com
 * Text Domain:       disable-app-passwords
 * Domain Path:       languages
 * License:           GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

  	// deny direct access.
    if ( ! defined( 'WPINC' ) ) {
      	die;
    }

// -----------------------------------------------------------------------------

	/**
	 *  Load the main class.
	 */
	require_once plugin_dir_path( __FILE__ ) . '/src/class-application-passwords.php';

	/**
	 * Application Passwords
	 *
	 * @link https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
	 */
	SwitchWeb\Application_Passwords::init();
