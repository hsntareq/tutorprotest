<?php
namespace TUTOR_GB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class init {
	public $version = TUTOR_GB_VERSION;
	public $path;
	public $url;
	public $basename;

	// Module
	public $multi_instructors;

	function __construct() {
		if ( ! function_exists( 'tutor' ) ) {
			return;
		}
		$addonConfig = tutor_utils()->get_addon_config( TUTOR_GB()->basename );
		$isEnable    = (bool) tutils()->array_get( 'is_enable', $addonConfig );

		if ( ! $isEnable ) {
			return;
		}

		$this->path     = plugin_dir_path( TUTOR_GB_FILE );
		$this->url      = plugin_dir_url( TUTOR_GB_FILE );
		$this->basename = plugin_basename( TUTOR_GB_FILE );

		$this->load_TUTOR_GB();
	}

	public function load_TUTOR_GB() {
		/**
		 * Loading Autoloader
		 */

		spl_autoload_register( array( $this, 'loader' ) );
		$this->multi_instructors = new GradeBook();

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

			$className = str_replace( 'TUTOR_GB' . DIRECTORY_SEPARATOR, 'classes' . DIRECTORY_SEPARATOR, $className );
			$file_name = $this->path . $className . '.php';

			if ( file_exists( $file_name ) && is_readable( $file_name ) ) {
				require_once $file_name;
			}
		}
	}

	// Run the TUTOR right now
	public function run() {
		register_activation_hook( TUTOR_GB_FILE, array( $this, 'tutor_activate' ) );
	}

	/**
	 * Do some task during plugin activation
	 */
	public function tutor_activate() {
		$version = get_option( 'TUTOR_GB_version' );
		// Save Option
		if ( ! $version ) {
			update_option( 'TUTOR_GB_version', TUTOR_GB_VERSION );
		}
	}

	/**
	 * @desc Add Greadbook Settings in Option Panel
	 * @since v 1.0.0
	 */
	public function add_options( $attr ) {
		$attr['tutor_gradebook'] = array(
            'label'    => __( 'Gradebook', 'tutor' ),
            'slug'     => 'gradebook',
            'desc'     => __('Gradebook Settings', 'tutor-pro'),
            'template' => 'basic',
            'icon'     => __( 'filter', 'tutor' ),
            'blocks'   => array(
				array(
					'label'      => __( 'Settings', 'tutor' ),
					'slug'       => 'g_settings',
					'block_type' => 'uniform',
					'fields'     => array(
						array(
							'key'		  => 'gradebook_enable_grade_point',
							'type'        => 'toggle_switch',
							'label'       => __( 'Grade Point', 'tutor-pro' ),
							'default'     => 'off',
							'desc'        => __( 'Enable this option for the database to calculate in grade points instead of division.', 'tutor-pro' ),
						),
						array(
							'key'		  => 'gradebook_show_grade_scale',
							'type'        => 'toggle_switch',
							'label'       => __( 'Grade Scale', 'tutor-pro' ),
							'default'     => 'off',
							'desc'        => sprintf( __( 'Display the final grade point to everyone such as 3.8%s', 'tutor-pro' ), '<code>/4.0</code>' ),
						),
						array(
							'key'	  => 'gradebook_scale_separator',
							'type'    => 'text',
							'label'   => __( 'Grade scale separator', 'tutor-pro' ),
							'default' => '/',
							'desc'    => __( 'Input the separator text or symbol to display. Example: Insert ???/??? to display 3.8/4.0 or ???out of??? 3.8 out of 4.', 'tutor-pro' ),
						),
						array(
							'key'	  => 'gradebook_scale',
							'type'    => 'text',
							'label'   => __( 'Grade Scale', 'tutor-pro' ),
							'default' => '4.0',
							'desc'    => __( 'Insert the grade point out of which the final results will be calculated.', 'tutor-pro' ),
						)
					)
				)
			)
		);

		return $attr;
	}
}
