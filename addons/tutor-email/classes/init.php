<?php
namespace TUTOR_EMAIL;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class init {
	public $version = TUTOR_EMAIL_VERSION;
	public $path;
	public $url;
	public $basename;

	// Module
	private $email_notification;

	function __construct() {
		if ( ! function_exists( 'tutor' ) ) {
			return;
		}
		$addonConfig = tutor_utils()->get_addon_config( TUTOR_EMAIL()->basename );
		$isEnable    = (bool) tutor_utils()->avalue_dot( 'is_enable', $addonConfig );
		if ( ! $isEnable ) {
			return;
		}

		$this->path     = plugin_dir_path( TUTOR_EMAIL_FILE );
		$this->url      = plugin_dir_url( TUTOR_EMAIL_FILE );
		$this->basename = plugin_basename( TUTOR_EMAIL_FILE );

		$this->load_TUTOR_EMAIL();
	}

	public function load_TUTOR_EMAIL() {
		/**
		 * Loading Autoloader
		 */

		spl_autoload_register( array( $this, 'loader' ) );
		$this->email_notification = new EmailNotification();

		add_filter( 'tutor/options/attr', array( $this, 'add_options' ), 10 ); // Priority index is important. 'Content Drip' add-on uses 11.
	}

	/**
	 * @param $className
	 *
	 * Auto Load class and the files
	 */
	private function loader( $className ) {
		if ( ! class_exists( $className ) ) {
			$className = preg_replace(
				array( '/([a-z])([A-Z])/', '/\\\/' ),
				array( '$1$2', DIRECTORY_SEPARATOR ),
				$className
			);

			$className = str_replace( 'TUTOR_EMAIL' . DIRECTORY_SEPARATOR, 'classes' . DIRECTORY_SEPARATOR, $className );
			$file_name = $this->path . $className . '.php';

			if ( file_exists( $file_name ) && is_readable( $file_name ) ) {
				require_once $file_name;
			}
		}
	}


	// Run the TUTOR right now
	public function run() {
		register_activation_hook( TUTOR_EMAIL_FILE, array( $this, 'tutor_activate' ) );
	}

	/**
	 * Do some task during plugin activation
	 */
	public function tutor_activate() {
		$version = get_option( 'TUTOR_EMAIL_version' );
		// Save Option
		if ( ! $version ) {
			update_option( 'TUTOR_EMAIL_version', TUTOR_EMAIL_VERSION );
		}
	}

	private function get_recipient_array( $key = null ) {
		$recipients = ( new EmailData() )->get_recipients();

		if ( $key == null ) {
			$new_array = array();
			foreach ( $recipients as $recipient ) {
				$new_array = array_merge( $new_array, $recipient );
			}

			return $new_array;
		}

		$admin_url = admin_url( 'admin.php' );
		$array     = $recipients[ $key ];
		$fields    = array();

		foreach ( $recipients[ $key ] as $event => $mail ) {
			$email_edit_url = add_query_arg(
				array(
					'page'     => 'tutor_settings',
					'tab_page' => 'email_notification',
					'edit'     => $event,
					'to'       => $key,
				),
				$admin_url
			);

			$fields[] = array(
				'key'         => $key . '_' . $event,
				'type'        => 'toggle_switch_button',
				'label'       => $mail['label'],
				'label_title' => '',
				'buttons'     => array(
					'edit' => array(
						'type' => 'anchor',
						'text' => __( 'Edit', 'tutor-pro' ),
						'url'  => $email_edit_url,
					),
				),
			);
		}

		return $fields;
	}

	public function add_options( $attr ) {

		$template_path = isset( $_GET['edit'] ) ? TUTOR_EMAIL()->path . '/views/pages/email-edit.php' : null;

		$template_data = ! isset( $_GET['edit'] ) ? null : array(
			'to'          => sanitize_text_field( $_GET['to'] ),
			'key'         => sanitize_text_field( $_GET['edit'] ),
			'to_readable' => ucwords( str_replace( '_', ' ', $_GET['to'] ) ),
			'mail'        => $this->get_recipient_array()[ sanitize_text_field( $_GET['edit'] ) ],
		);

		$attr['email_notification'] = array(
			'label'           => __( 'Email', 'tutor' ),
			'slug'            => 'email',
			'desc'            => __( 'Email Settings', 'tutor' ),
			'template'        => 'basic',
			'icon'            => __( 'envelop', 'tutor' ),
			'template_path'   => $template_path,
			'edit_email_data' => $template_data,
			'blocks'          => array(
				array(
					'label'      => __( 'Email Meta', 'tutor-pro' ),
					'slug'       => 'email_meta',
					'block_type' => 'uniform',
					'fields'     => array(
						array(
							'key'     => 'email_from_name',
							'type'    => 'text',
							'label'   => __( 'Name', 'tutor' ),
							'default' => get_option( 'blogname' ),
							'desc'    => __( 'The name under which all the emails will be sent', 'tutor' ),
						),
						array(
							'key'     => 'email_from_address',
							'type'    => 'text',
							'label'   => __( 'E-Mail Address', 'tutor' ),
							'default' => get_option( 'admin_email' ),
							'desc'    => __( 'The E-Mail address from which all emails will be sent', 'tutor' ),
						),
						array(
							'key'     => 'email_footer_text',
							'type'    => 'textarea',
							'label'   => __( 'E-Mail Footer Text', 'tutor' ),
							'default' => '',
							'desc'    => __( 'The text to appear in E-Mail template footer', 'tutor' ),
						),
					),
				),
				array(
					'label'      => __( 'Email to Students', 'tutor-pro' ),
					'slug'       => 'e_mail_to_students',
					'block_type' => 'uniform',
					'fields'     => $this->get_recipient_array( 'email_to_students' ),
				),
				array(
					'label'      => __( 'Email to Teachers', 'tutor-pro' ),
					'block_type' => 'uniform',
					'fields'     => $this->get_recipient_array( 'email_to_teachers' ),
				),
				array(
					'label'      => __( 'Email to Admin', 'tutor-pro' ),
					'block_type' => 'uniform',
					'fields'     => $this->get_recipient_array( 'email_to_admin' ),
				),
				array(
					'label'      => __( 'Email Sending', 'tutor-pro' ),
					'block_type' => 'uniform',
					'fields'     => array(
						array(
							'key'     => 'tutor_email_disable_wpcron',
							'label'   => __( 'WP Cron for bulk mailing', 'tutor-pro' ),
							'type'    => 'toggle_switch',
							'default' => 'off',
							'desc'    => __( 'Enable this option to let Tutor LMS use WordPress native scheduler for email sending activities', 'tutor-pro' ),
						),
						array(
							'key'     => 'tutor_email_cron_frequency',
							'label'   => __( 'WP email cron frequency', 'tutor-pro' ),
							'type'    => 'select',
							'default' => '300',
							'options' => array(
								'3600' => __( 'Lowest', 'tutor-pro' ),
								'1800' => __( 'Low', 'tutor-pro' ),
								'900'  => __( 'Normal', 'tutor-pro' ),
								'300'  => __( 'High', 'tutor-pro' ),
							),
							'desc'    => __( 'Select the frequency mode in which the Cron Setup will run', 'tutor-pro' ),
						),
						array(
							'key'     => 'tutor_bulk_email_limit',
							'label'   => __( 'Email per cron execution', 'tutor-pro' ),
							'type'    => 'number',
							'default' => '10',
							'desc'    => __( 'Number of emails you\'d like to send per cron execution', 'tutor-pro' ),
						),
					),
				),
			),
		);

		return $attr;
	}
}
