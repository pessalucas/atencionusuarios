<?php
/**
 * Base de clases
 *
 * @package atencionusuarios
 */

if ( ! class_exists( 'Base' ) ) {
	/**
	 * Class Base
	 */
	class Base {
		/**
		 * Static accessor.
		 *
		 * @var Base
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

		}

		/**
		 * Static accessor.
		 *
		 * @return Base singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Base();
			}
			return self::$instance;
		}
	}
	Base::instance();
}
