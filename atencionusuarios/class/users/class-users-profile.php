<?php
/**
 * Extendemos la funcionalidad del Perfil del usuario.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'Users_Profile' ) ) {
	/**
	 * Class User Profile.
	 */
	class Users_Profile {
		/**
		 * Static accessor.
		 *
		 * @var Users_Profile
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'show_user_profile', array( $this, 'render_profile_fields' ) );
			add_action( 'edit_user_profile', array( $this, 'render_profile_fields' ) );
			add_action( 'personal_options_update', array( $this, 'save_profile_field' ) );
			add_action( 'edit_user_profile_update', array( $this, 'save_profile_field' ) );
		}
		/**
		 * Undocumented function
		 *
		 * @param WP_User $user Objeto del usuario.
		 * @return void
		 */
		public function render_profile_fields( $user ) {
			wp_nonce_field( 'lp_user_profile', 'lp_user_profile' );
			?>
			<h2>Informacion adicional</h2>
			<table class="form-table" role="presentation">
				<tbody>
					<?php
					$user_dni = get_user_meta( $user->ID, 'dni', true );
					$this->render_textfield(
						array(
							'slug'  => 'dni',
							'name'  => 'DNI',
							'value' => $user_dni,
						)
					);
					$user_telefono = get_user_meta( $user->ID, 'telefono', true );
					$this->render_textfield(
						array(
							'slug'  => 'telefono',
							'name'  => 'Teléfono',
							'value' => $user_telefono,
						)
					);
					$user_direccion = get_user_meta( $user->ID, 'direccion', true );
					$this->render_textfield(
						array(
							'slug'  => 'direccion',
							'name'  => 'Dirección',
							'value' => $user_direccion,
						)
					);
					?>
				</tbody>
			</table>
			<?php
		}
		/**
		 * Test
		 *
		 * @param Array $params Paramegros.
		 */
		private function render_textfield( $params ) {
			?>
			<tr class="user-<?php echo esc_attr( $params['slug'] ); ?>-wrap">
				<th>
					<label for="<?php echo esc_attr( $params['slug'] ); ?>"><?php echo esc_html( $params['name'] ); ?></label></th>
				<td>
					<input type="text" name="<?php echo esc_attr( $params['slug'] ); ?>" id="<?php echo esc_attr( $params['slug'] ); ?>" aria-describedby="<?php echo esc_attr( $params['slug'] ); ?>-description" value="<?php echo esc_attr( $params['value'] ); ?>" class="regular-text ltr" />
				</td>
			</tr>
			<?php
		}
		/**
		 * Guardamos los datos del usuario enviados desde el front de wordpress.
		 *
		 * @param Int $user_id ID del usuario que se esta grabando.
		 */
		public function save_profile_field( $user_id ) {
			if ( ! current_user_can( 'edit_user', $user_id ) ) {
				return false;
			}

			$user_dni       = $_POST['dni'];
			$user_telefono  = $_POST['telefono'];
			$user_direccion = $_POST['direccion'];

			update_user_meta( $user_id, 'dni', $user_dni );
			update_user_meta( $user_id, 'telefono', $user_telefono );
			update_user_meta( $user_id, 'direccion', $user_direccion );
		}

		/**
		 * Static accessor.
		 *
		 * @return Users_Profile singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Users_Profile();
			}
			return self::$instance;
		}
	}
	Users_Profile::instance();
}
