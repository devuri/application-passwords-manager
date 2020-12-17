<?php

namespace SwitchWeb;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SwitchWeb\Application_Passwords' ) ) {

	/**
	 * Application_Passwords
	 */
	final class Application_Passwords {
		/**
		 * Application_Passwords::initialize
		 *
		 * @return object
		 */
		public static function init() {
			return new Application_Passwords();
		}

		/**
		 * Theme Setup
		 */
		private function __construct() {

			// Application Passwords check.
			if ( $this->is_available() ) {
				$this->disable();
			}
		}

		/**
		 * Disbale Application Passwords if set
		 *
		 * @return void
		 */
		private function disable() {
			if ( $this->is_disabled() ) {
				add_filter( 'wp_is_application_passwords_available', '__return_false' );
			}
		}

		/**
	     * Check if the user has disabled application passwords
	     *
	     * @return bool
	     */
	    private function is_disabled() {

			// get the current status.
			$status = get_option( 'wpap_status', 1 );

			// set to bool.
			$status = boolval( $status );

	    	if ( true === $status ) {
	        	return true;
	      	} else {
	        	return false;
	      	}
	    }

	    /**
	     * Checks if Application Passwords is globally available.
	     *
	     * @return bool
	     * @link https://developer.wordpress.org/reference/functions/wp_is_application_passwords_available/
	     */
	    private function is_available() {
		 	return wp_is_application_passwords_available();
		}

	}
}
