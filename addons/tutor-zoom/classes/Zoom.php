<?php

/**
 * TutorZoom Class
 * @package TUTOR
 *
 * @since v.1.7.1
 */

namespace TUTOR_ZOOM;

if (!defined('ABSPATH'))
	exit;

class Zoom {

	private $api_key;
	private $settings_key;
	private $zoom_meeting_post_type;
	private $zoom_meeting_base_slug;
	private $zoom_meeting_post_meta;

	function __construct() {
		$this->api_key = 'tutor_zoom_api';
		$this->settings_key = 'tutor_zoom_settings';
		$this->zoom_meeting_post_type = 'tutor_zoom_meeting';
		$this->zoom_meeting_base_slug = 'tutor-zoom-meeting';
		$this->zoom_meeting_post_meta = '_tutor_zm_data';

		add_action('init', array($this, 'register_zoom_post_types'));

		/**
		 * Register all admin scripts
		 * 
		 * use same admin scripts on the front end for zoom
		 * 
		 * @since 1.9.4
		 */
		add_action( 'wp_loaded' , array( $this, 'register_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'admin_scripts_frontend' ) );
		add_action('wp_enqueue_scripts', array($this, 'tutor_script_text_domain'),100);
	
		add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
		add_action('tutor_admin_register', array($this, 'register_menu'));

		add_filter('tutor_course_contents_post_types', array($this, 'tutor_course_contents_post_types'));

		// Saving zoom settings
		add_action('wp_ajax_tutor_save_zoom_api', array($this, 'tutor_save_zoom_api'));
		add_action('wp_ajax_tutor_save_zoom_settings', array($this, 'tutor_save_zoom_settings'));

		// Add meeting button options
		add_action('edit_form_after_editor', array($this, 'add_meetings_metabox'), 9, 0);
		add_action('tutor/frontend_course_edit/after/course_builder', array($this, 'add_meetings_metabox'), 11, 0);
		add_action('tutor_course_builder_after_btn_group', array($this, 'add_meeting_option_in_topic'), 12, 1);

		// Meeting modal form and save action 
		add_action('wp_ajax_tutor_zoom_meeting_modal_content', array($this, 'tutor_zoom_meeting_modal_content'));
		add_action('wp_ajax_tutor_zoom_save_meeting', array($this, 'tutor_zoom_save_meeting'));

		add_action('wp_ajax_tutor_zoom_delete_meeting', array($this, 'tutor_zoom_delete_meeting'));

		add_action('tutor_course/single/before/topics', array($this, 'tutor_zoom_course_meeting'));
		add_filter('template_include', array($this, 'load_meeting_template'), 99);

		/**
		 * Apply filters on tutor nav items add zoom menu
		 * 
		 * Load zoom template from zoom addons
		 * 
		 * @since 1.9.4
		 */
		add_filter( 'tutor_dashboard/instructor_nav_items' , array( $this, 'add_zoom_menu' ) ); 
		add_filter( 'load_dashboard_template_part_from_other_location', array( $this, 'load_zoom_template' ) );

		/**
		 * tutor_zoom_sync
		 * 
		 * @since 1.9.8
		 */
		add_action( 'wp_ajax_tutor_zoom_sync', array( $this, 'tutor_zoom_sync') );

		add_action( 'course-topic/after/modal_wrappers', array($this, 'load_modal_wrapper') );
		add_action( 'tutor_zoom/after/meetings', array($this, 'load_modal_wrapper') );
	}

	public function register_zoom_post_types() {

		$labels = array(
			'name'               => _x('Meetings', 'post type general name', 'tutor-pro'),
			'singular_name'      => _x('Meeting', 'post type singular name', 'tutor-pro'),
			'menu_name'          => _x('Meetings', 'admin menu', 'tutor-pro'),
			'name_admin_bar'     => _x('Meeting', 'add new on admin bar', 'tutor-pro'),
			'add_new'            => _x('Add New', $this->zoom_meeting_post_type, 'tutor-pro'),
			'add_new_item'       => __('Add New Meeting', 'tutor-pro'),
			'new_item'           => __('New Meeting', 'tutor-pro'),
			'edit_item'          => __('Edit Meeting', 'tutor-pro'),
			'view_item'          => __('View Meeting', 'tutor-pro'),
			'all_items'          => __('Meetings', 'tutor-pro'),
			'search_items'       => __('Search Meetings', 'tutor-pro'),
			'parent_item_colon'  => __('Parent Meetings:', 'tutor-pro'),
			'not_found'          => __('No Meeting found.', 'tutor-pro'),
			'not_found_in_trash' => __('No Meetings found in Trash.', 'tutor-pro')
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __('Description.', 'tutor-pro'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array('slug' => $this->zoom_meeting_base_slug),
			'menu_icon'          => 'dashicons-list-view',
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array('title', 'editor'),
			'exclude_from_search' => true,
		);

		register_post_type($this->zoom_meeting_post_type, $args);
	}

	/**
	 * Register all admin scripts so that later
	 * 
	 * we can enqueue on admin_scripts hook or wp_enqueue_scripts hook
	 * 
	 * @since 1.9.4
	 */
	public function register_admin_scripts () {
		wp_register_script('tutor_zoom_timepicker_js', TUTOR_ZOOM()->url . 'assets/js/jquery-ui-timepicker.js', array('jquery', 'jquery-ui-datepicker', 'jquery-ui-slider'), TUTOR_PRO_VERSION, true);
		wp_register_script('tutor_zoom_admin_js', TUTOR_ZOOM()->url . 'assets/js/admin.js', array('jquery'), TUTOR_PRO_VERSION, true);
		wp_register_script('tutor_zoom_common_js', TUTOR_ZOOM()->url . 'assets/js/common.js', array('jquery', 'jquery-ui-datepicker'), TUTOR_PRO_VERSION, true);
		wp_register_style('tutor_zoom_timepicker_css', TUTOR_ZOOM()->url . 'assets/css/jquery-ui-timepicker.css', false, TUTOR_PRO_VERSION);
		wp_register_style('tutor_zoom_common_css', TUTOR_ZOOM()->url . 'assets/css/common.css', false, TUTOR_PRO_VERSION);
		wp_register_style('tutor_zoom_admin_css', TUTOR_ZOOM()->url . 'assets/css/admin.css', false, TUTOR_PRO_VERSION);	
	}
	
	/**
	 * Enqueue admin scripts
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'tutor_zoom_timepicker_js' );
		wp_enqueue_script( 'tutor_zoom_admin_js' );
		wp_enqueue_script( 'tutor_zoom_common_js' );

		wp_enqueue_style( 'tutor_zoom_timepicker_css' );
		wp_enqueue_style( 'tutor_zoom_common_css' );
		wp_enqueue_style( 'tutor_zoom_admin_css' );
	}
	/**
	 * Load admin scripts on the frontend that is need for zoom
	 * 
	 * @since 1.9.4
	 */
	public function admin_scripts_frontend() {
		wp_enqueue_script( 'tutor_zoom_timepicker_js' );
		wp_enqueue_script( 'tutor_zoom_admin_js' );
		wp_enqueue_script( 'tutor_zoom_common_js' );

		wp_enqueue_style( 'tutor_zoom_timepicker_css' );
		wp_enqueue_style( 'tutor_zoom_common_css' );
	}

	/**
	 * Enqueue frontend scripts
	 */
	public function frontend_scripts() {
		global $wp_query;
		$is_frontend_course_builder = tutils()->array_get('tutor_dashboard_page', $wp_query->query_vars) === 'create-course';

		if ($wp_query->is_page && $is_frontend_course_builder) {
			wp_enqueue_script('tutor_zoom_timepicker_js', TUTOR_ZOOM()->url . 'assets/js/jquery-ui-timepicker.js', array('jquery', 'jquery-ui-datepicker', 'jquery-ui-slider'), TUTOR_PRO_VERSION, true);
			wp_enqueue_style('tutor_zoom_timepicker_css', TUTOR_ZOOM()->url . 'assets/css/jquery-ui-timepicker.css', false, TUTOR_PRO_VERSION);
			wp_enqueue_script('tutor_zoom_common_js', TUTOR_ZOOM()->url . 'assets/js/common.js', array('jquery', 'jquery-ui-datepicker'), TUTOR_PRO_VERSION, true);
			wp_enqueue_style('tutor_zoom_common_css', TUTOR_ZOOM()->url . 'assets/css/common.css', false, TUTOR_PRO_VERSION);
		}

		if (is_single_course() || is_single_tutor_zoom_meeting_page()) {
			wp_enqueue_script('tutor_zoom_moment_js', TUTOR_ZOOM()->url . 'assets/js/moment.min.js', array(), TUTOR_PRO_VERSION, true);
			wp_enqueue_script('tutor_zoom_moment_tz_js', TUTOR_ZOOM()->url . 'assets/js/moment-timezone-with-data.min.js', array(), TUTOR_PRO_VERSION, true);
			wp_enqueue_script('tutor_zoom_countdown_js', TUTOR_ZOOM()->url . 'assets/js/jquery.countdown.min.js', array('jquery'), TUTOR_PRO_VERSION, true);
		}

		if ( is_single_course() || is_single_tutor_zoom_meeting_page() || $is_frontend_course_builder || ( isset( $wp_query->query_vars['tutor_dashboard_page'] ) && $wp_query->query_vars['tutor_dashboard_page'] == 'zoom' ) ) {
			wp_enqueue_script('tutor_zoom_frontend_js', TUTOR_ZOOM()->url . 'assets/js/frontend.js', array('jquery'), TUTOR_PRO_VERSION, true);
			wp_enqueue_style('tutor_zoom_frontend_css', TUTOR_ZOOM()->url . 'assets/css/frontend.css', false, TUTOR_PRO_VERSION);
		}
	}

	public function register_menu() {
		add_submenu_page('tutor', __('Zoom', 'tutor-pro'), __('Zoom', 'tutor-pro'), 'manage_tutor_instructor', 'tutor_zoom', array($this, 'tutor_zoom'));
	}

	public function tutor_course_contents_post_types($post_types) {
		$post_types[] = $this->zoom_meeting_post_type;

		return $post_types;
	}

	public function add_meetings_metabox() {
		global $post;
		$user_id    = get_current_user_id();
		$settings   = json_decode(get_user_meta($user_id, $this->api_key, true), true);
		$api_key    = (!empty($settings['api_key'])) ? $settings['api_key'] : '';
		$api_secret = (!empty($settings['api_secret'])) ? $settings['api_secret'] : '';
		if ($post->post_type == tutor()->course_post_type && !empty($api_key) && !empty($api_secret)) {
			$course_id = $post->ID;
			echo '<div id="tutor-zoom-metabox-wrap">';
			include TUTOR_ZOOM()->path . "views/metabox/meetings.php";
			echo '</div>';
		}
	}

	public function add_meeting_option_in_topic($topic_id)
	{
		$user_id    = get_current_user_id();
		$settings   = json_decode(get_user_meta($user_id, $this->api_key, true), true);
		$api_key    = (!empty($settings['api_key'])) ? $settings['api_key'] : '';
		$api_secret = (!empty($settings['api_secret'])) ? $settings['api_secret'] : '';
		if (!empty($api_key) && !empty($api_secret)) {
			?>
			<button class="tutor-btn tutor-is-outline tutor-is-sm tutor-zoom-meeting-modal-open-btn" data-meeting-id="0" data-topic-id="<?php echo $topic_id; ?>" data-click-form="course-builder">
				<i class="tutor-icon-plus-square-button"></i>
				<?php _e('Zoom Live Lesson', 'tutor-pro'); ?>
			</button>
			<?php
		}
	}


	public function tutor_zoom_meeting_modal_content() {
		tutils()->checking_nonce();

		$meeting_id = (int) sanitize_text_field($_POST['meeting_id']);
		$topic_id   = (int) sanitize_text_field($_POST['topic_id']);
		$course_id  = (int) sanitize_text_field($_POST['course_id']);
		$click_form = sanitize_text_field($_POST['click_form']);

		$post = null;
		$meeting_data = null;
		if ($meeting_id) {
			$post = get_post($meeting_id);
			$meeting_start  = get_post_meta($meeting_id, '_tutor_zm_start_datetime', true);
			$meeting_data   = get_post_meta($meeting_id, $this->zoom_meeting_post_meta, true);
			$meeting_data   = json_decode($meeting_data, true);
		}
		
		$start_date     = '';
		$start_time     = '';
		$host_id        = !empty($meeting_data) ? $meeting_data['host_id'] : '';
		$title          = !empty($meeting_data) ? wp_strip_all_tags($meeting_data['topic']) : '';
		$summary        = !empty($post) ? $post->post_content : '';
		$timezone       = !empty($meeting_data) ? $meeting_data['timezone'] : '';
		$duration       = !empty($meeting_data) ? $meeting_data['duration'] : 60;
		$duration_unit  = !empty($post) ? get_post_meta($meeting_id, '_tutor_zm_duration_unit', true) : 'min';
		$password       = !empty($meeting_data) ? $meeting_data['password'] : '';
		$auto_recording = !empty($meeting_data) ? $meeting_data['settings']['auto_recording'] : $this->get_settings('auto_recording');

		if (!empty($meeting_data)) {
			$input_date = \DateTime::createFromFormat('Y-m-d H:i:s', $meeting_start);
			$start_date = $input_date->format('d/m/Y');
			$start_time = $input_date->format('h:i A');
			$duration   = ($duration_unit == 'hr') ? $duration / 60 : $duration;
		}

		ob_start();
		include  TUTOR_ZOOM()->path . 'views/modal/meeting.php';
		$output = ob_get_clean();

		wp_send_json_success(array('output' => $output));
	}

	/**
	 * Save meeting
	 */
	public function tutor_zoom_save_meeting() {
		tutils()->checking_nonce();

		$meeting_id = (int) sanitize_text_field($_POST['meeting_id']);
		$topic_id = (int) sanitize_text_field($_POST['topic_id']);
		$course_id = (int) sanitize_text_field($_POST['course_id']);
		$click_form = sanitize_text_field($_POST['click_form']);

		$user_id    = get_current_user_id();
		$settings   = json_decode(get_user_meta($user_id, $this->api_key, true), true);
		$api_key    = (!empty($settings['api_key'])) ? $settings['api_key'] : '';
		$api_secret = (!empty($settings['api_secret'])) ? $settings['api_secret'] : '';
		if (!empty($api_key) && !empty($api_secret)) {
			$host_id            = !empty($_POST['meeting_host']) ? sanitize_text_field($_POST['meeting_host']) : '';
			$title              = !empty($_POST['meeting_title']) ? sanitize_text_field($_POST['meeting_title']) : '';
			$summary            = !empty($_POST['meeting_summary']) ? sanitize_text_field($_POST['meeting_summary']) : '';
			$timezone           = !empty($_POST['meeting_timezone']) ? sanitize_text_field($_POST['meeting_timezone']) : '';
			$start_date         = !empty($_POST['meeting_date']) ? sanitize_text_field($_POST['meeting_date']) : '';
			$start_time         = !empty($_POST['meeting_time']) ? sanitize_text_field($_POST['meeting_time']) : '';

			$input_duration     = !empty($_POST['meeting_duration']) ? intval($_POST['meeting_duration']) : 60;
			$duration_unit      = !empty($_POST['meeting_duration_unit']) ? $_POST['meeting_duration_unit'] : 'min';
			$password           = !empty($_POST['meeting_password']) ? sanitize_text_field($_POST['meeting_password']) : '';

			$join_before_host   = ($this->get_settings('join_before_host')) ? true : false;
			$host_video         = ($this->get_settings('host_video')) ? true : false;
			$participants_video = ($this->get_settings('participants_video')) ? true : false;
			$mute_participants  = ($this->get_settings('mute_participants')) ? true : false;
			$enforce_login      = ($this->get_settings('enforce_login')) ? true : false;
			$auto_recording     = !empty($_POST['auto_recording']) ? sanitize_text_field($_POST['auto_recording']) : '';

			if ( false === date_create_from_format( 'd/m/Y', $start_date) ) {
				$start_date = tutor_get_formated_date( 'd/m/Y', $start_date );
			}
			$input_date = \DateTime::createFromFormat('d/m/Y h:i A', $start_date . ' ' . $start_time);
			$meeting_start =  $input_date->format('Y-m-d\TH:i:s');

			$duration = ($duration_unit == 'hr') ? $input_duration * 60 : $input_duration;
			$data = array(
				'topic'         => $title,
				'type'          => 2,
				'start_time'    => $meeting_start,
				'timezone'      => $timezone,
				'duration'      => $duration,
				'password'      => $password,
				'settings'      => array(
					'join_before_host'  => $join_before_host,
					'host_video'        => $host_video,
					'participant_video' => $participants_video,
					'mute_upon_entry'   => $mute_participants,
					'auto_recording'    => $auto_recording,
					'enforce_login'     => $enforce_login,
				)
			);

			//save post
			$post_content = array(
				'ID'            => ($meeting_id) ? $meeting_id : 0,
				'post_title'    => $title,
				'post_name'     => sanitize_title($title),
				'post_content'  => $summary,
				'post_type'     => $this->zoom_meeting_post_type,
				'post_parent'   => ($topic_id) ? $topic_id : $course_id,
				'post_status'   => 'publish'
			);

			//save zoom meeting
			if (!empty($api_key) && !empty($api_secret) && !empty($host_id)) {
				
				$post_id      = wp_insert_post($post_content);
				$meeting_data = get_post_meta($post_id, $this->zoom_meeting_post_meta, true);
				$meeting_data = json_decode($meeting_data, true);

				$zoom_endpoint = tutils()->get_package_object( true, '\Zoom\Endpoint\Meetings', $api_key, $api_secret );
				if (!empty($meeting_data) && isset($meeting_data['id'])) {
					$zoom_endpoint->update($meeting_data['id'], $data);
					$saved_meeting = $zoom_endpoint->meeting($meeting_data['id']);
					do_action('tutor_zoom_after_update_meeting', $post_id);
				} else {
					$saved_meeting = $zoom_endpoint->create($host_id, $data);
					update_post_meta($post_id, '_tutor_zm_for_course', $course_id);
					update_post_meta($post_id, '_tutor_zm_for_topic', $topic_id);

					do_action('tutor_zoom_after_save_meeting', $post_id);
				}

				/**
				 * Add _tutor_zm_start_datetime_with_duration meta key
				 * 
				 * UTC date time format with meeting duration
				 * 
				 * @since 1.9.8
				 */
				$timezone = isset( $_POST['timezone'] ) ? sanitize_text_field($_POST['timezone']) : 'UTC';
				$global_format = "Y-m-d H:i:s";
				//set user time with zone
				$user_date = new \DateTime($input_date->format($global_format), new \DateTimeZone($timezone));
				//convert time to UTC 
				$user_date->setTimezone(new \DateTimeZone('UTC'));
				//set interval
				$interval = $duration_unit === 'hr' ? $input_duration.' '.'hour' : $input_duration.' '.'minute'; 
				//add meeting duration with start date time
				$start_datetime_duration = date_add(date_create($user_date->format($global_format)), date_interval_create_from_date_string($interval));

				update_post_meta($post_id, '_tutor_zm_start_datetime_with_duration', $start_datetime_duration->format($global_format));

				update_post_meta($post_id, '_tutor_zm_start_date', $input_date->format('Y-m-d'));
				update_post_meta($post_id, '_tutor_zm_start_datetime', $input_date->format('Y-m-d H:i:s'));
				update_post_meta($post_id, '_tutor_zm_duration', $input_duration);
				update_post_meta($post_id, '_tutor_zm_duration_unit', $duration_unit);
				update_post_meta($post_id, $this->zoom_meeting_post_meta, json_encode($saved_meeting));
			}

			$course_contents = '';
			$selector = '';
			if ($click_form == 'course-builder') {
				ob_start();
				$current_topic_id = $topic_id;
				include  tutor()->path . 'views/metabox/course-contents.php';
				$course_contents = ob_get_clean();
				$selector = '#tutor-course-content-wrap';
			} else if ($click_form == 'metabox') {
				ob_start();
				include  TUTOR_ZOOM()->path . 'views/metabox/meetings.php';
				$course_contents = ob_get_clean();
				$selector = '#tutor-zoom-metabox-wrap';
			}

			wp_send_json(array(
				'success' => true,
				'post_id' => $post_id,
				'msg' => __('Meeting Successfully Saved', 'tutor-pro'),
				'course_contents' => $course_contents,
				'selector' => $selector
			));
		} else {
			wp_send_json(array(
				'success' => false,
				'post_id' => false,
				'msg' => __('Invalid Api Credentials', 'tutor-pro'),
			));
		}
	}

	/**
	 * Delete meeting
	 */
	public function tutor_zoom_delete_meeting() {
		tutils()->checking_nonce();

		$user_id    = get_current_user_id();
		$post_id    = (int) sanitize_text_field($_POST['meeting_id']);
		$settings   = json_decode(get_user_meta($user_id, $this->api_key, true), true);
		$api_key    = (!empty($settings['api_key'])) ? $settings['api_key'] : '';
		$api_secret = (!empty($settings['api_secret'])) ? $settings['api_secret'] : '';
		if (!empty($api_key) && !empty($api_secret)) {
			$meeting_data = get_post_meta($post_id, $this->zoom_meeting_post_meta, true);
			$meeting_data = json_decode($meeting_data, true);

			$zoom_endpoint = tutils()->get_package_object( true, '\Zoom\Endpoint\Meetings', $api_key, $api_secret );
			$zoom_endpoint->remove($meeting_data['id']);

			wp_delete_post($post_id, true);

			do_action('tutor_zoom_after_delete_meeting', $post_id);

			wp_send_json(array(
				'success' => true,
				'post_id' => $post_id,
				'msg' => __('Meeting Successfully Deleted', 'tutor-pro'),
			));
		} else {
			wp_send_json(array(
				'success' => false,
				'post_id' => false,
				'msg' => __('Invalid Api Credentials', 'tutor-pro'),
			));
		}
	}

	private function get_option_data($key, $data) {
		if (empty($data) || !is_array($data)) {
			return false;
		}
		if (!$key) {
			return $data;
		}
		if (array_key_exists($key, $data)) {
			return apply_filters($key, $data[$key]);
		}
	}

	private function get_transient_key() {
		$user_id       = get_current_user_id();
		$transient_key = 'tutor_zoom_users_' . $user_id;
		return $transient_key;
	}

	private function get_api($key = null) {
		$user_id  = get_current_user_id();
		$api_data = json_decode(get_user_meta($user_id, $this->api_key, true), true);
		return $this->get_option_data($key, $api_data);
	}

	private function get_settings($key = null) {
		$user_id       = get_current_user_id();
		$settings_data = json_decode(get_user_meta($user_id, $this->settings_key, true), true);
		return $this->get_option_data($key, $settings_data);
	}

	public function tutor_zoom() {
		include TUTOR_ZOOM()->path . 'views/pages/main.php';
	}

	public function tutor_save_zoom_api() {
		tutils()->checking_nonce();

		$api_data   = (array) isset($_POST[$this->api_key]) ? $_POST[$this->api_key] : array();
		$api_data   = apply_filters('tutor_zoom_api_input', $api_data);

		// Validate before saving
		if(!$this->tutor_check_api_connection($api_data)) {
			wp_send_json_error( array('msg' => __('Please recheck your API Key and Secret Key', 'tutor-pro')) );
			return;
		}
		
		do_action('tutor_save_zoom_api_before');
		$user_id    = get_current_user_id();
		update_user_meta($user_id, $this->api_key, json_encode($api_data));
		do_action('tutor_save_zoom_api_after');
		wp_send_json_success(array('msg' => __('You can now add live classes to any course!', 'tutor-pro')));
	}

	public function tutor_save_zoom_settings() {
		tutils()->checking_nonce();

		do_action('tutor_save_zoom_settings_before');
		$settings = (array) isset($_POST[$this->settings_key]) ? $_POST[$this->settings_key] : array();
		$settings = apply_filters('tutor_zoom_settings_input', $settings);
		$user_id  = get_current_user_id();
		update_user_meta($user_id, $this->settings_key, json_encode($settings));
		do_action('tutor_save_zoom_settings_after');
		wp_send_json_success(array('msg' => __('Settings Updated', 'tutor-pro')));
	}

	private function tutor_check_api_connection($settings) {
		$transient_key = $this->get_transient_key();
		delete_transient($transient_key); //delete temporary cache
		$users = $this->tutor_zoom_get_users($settings);
		return !empty($users);
	}

	/**
	 * Get Zoom Users from Zoom API
	 * @return array
	 */
	public function tutor_zoom_get_users($settings=null) {
		$user_id        = get_current_user_id();
		$transient_key  = $this->get_transient_key();
		$users          = get_transient($transient_key);
		$settings       = $settings ? $settings : json_decode(get_user_meta($user_id, $this->api_key, true), true);

		if (empty($users)) {
			$api_key    = (!empty($settings['api_key'])) ? $settings['api_key'] : '';
			$api_secret = (!empty($settings['api_secret'])) ? $settings['api_secret'] : '';
			if (!empty($api_key) && !empty($api_secret)) {
				$users = array();
				$users_data = tutils()->get_package_object( true, '\Zoom\Endpoint\Users', $api_key, $api_secret );
				$users_list = $users_data->userlist();
				if (!empty($users_list) && !empty($users_list['users'])) {
					$users = $users_list['users'];
					set_transient($transient_key, $users, 36000);
				}
			} else {
				$users = array();
			}
		}
		return $users;
	}

	/**
	 * Get Zoom Users
	 * @return array
	 */
	public function get_users_options() {
		$users = $this->tutor_zoom_get_users();
		if (!empty($users)) {
			foreach ($users as $user) {
				$first_name         = $user['first_name'];
				$last_name          = $user['last_name'];
				$email              = $user['email'];
				$id                 = $user['id'];
				$user_list[$id]   = $first_name . ' ' . $last_name . ' (' . $email . ')';
			}
		} else {
			return array();
		}
		return $user_list;
	}

	/**
	 * Load zoom meeting template
	 * @return array
	 */
	public function tutor_zoom_course_meeting() {
		ob_start();
		tutor_load_template('single.course.zoom-meetings', null, true);
		$output = apply_filters('tutor_course/single/zoom_meetings', ob_get_clean());
		echo $output;
	}

	/**
	 * Load zoom meeting template
	 * @return array
	 */
	public function load_meeting_template($template) {
		global $wp_query, $post;
		if ($wp_query->is_single && !empty($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] === $this->zoom_meeting_post_type) {
			if (is_user_logged_in()) {
				$content_type = (get_post_type($post->post_parent) === tutor()->course_post_type) ? 'topic' : 'lesson';
				$has_content_access = tutils()->has_enrolled_content_access($content_type, $post->ID);
				if ($has_content_access) {
					$template = tutor_get_template('single-zoom-meeting', true);
				} else {
					$template = tutor_get_template('single.lesson.required-enroll'); //You need to enroll first
				}
			} else {
				$template = tutor_get_template('login');
			}
			return $template;
		}
		return $template;
	}

	/**
	 * Add zoom menu on the tutor dashboard (frontend)
	 * 
	 * @return array
	 * 
	 * @since 1.9.4
	 */
	public function add_zoom_menu($nav_items) {
		do_action( 'before_zoom_menu_add_on_frontend' );
		$new_items 	= array( 
			'zoom' =>  array( 'title' => __( 'Zoom', 'tutor-pro' ), 'auth_cap' => tutor()->instructor_role )
		);
		$nav_items 	= array_merge( $nav_items, $new_items );

		return apply_filters( 'after_zoom_menu_add_on_frontend', $nav_items );
	}

	/**
	 * If request is for zoom then load template from addons
	 * 
	 * @param String
	 * 
	 * @return String
	 * 
	 * @since 1.9.4
	 */
	public function load_zoom_template($location) {
		global $wp_query;
		$query_vars = $wp_query->query_vars;

		if ( isset( $query_vars['tutor_dashboard_page'] ) && $query_vars['tutor_dashboard_page'] == 'zoom' ) {
			$location = TUTOR_ZOOM()->path.'/templates/main.php';
		}
		return $location;
	}

	public function tutor_zoom_sync() {
		global $wpdb;
		tutils()->checking_nonce();
		
		$timezone = sanitize_text_field($_POST['timezone']);
		$meetings = $wpdb->get_results(" SELECT post.ID, mt1.meta_value AS start_datetime, mt2.meta_value AS duration, mt3.meta_value AS unit FROM {$wpdb->posts} AS post
			INNER JOIN {$wpdb->postmeta} AS mt1 
				ON mt1.post_id = post.ID AND mt1.meta_key = '_tutor_zm_start_datetime'
			INNER JOIN {$wpdb->postmeta} AS mt2 
				ON mt2.post_id = post.ID AND mt2.meta_key = '_tutor_zm_duration'
			INNER JOIN {$wpdb->postmeta} AS mt3 
				ON mt3.post_id = post.ID AND mt3.meta_key = '_tutor_zm_duration_unit'
			WHERE post_type = 'tutor_zoom_meeting'
			AND post_status = 'publish'
		");
		$success_posts = [];
		foreach($meetings as $meeting) {
			$interval = $meeting->unit == 'hr' ? $meeting->duration.' '.'hour' : $meeting->duration.' '.'minute';
			$global_format = "Y-m-d H:i:s";
			//set user time with zone
			$user_date = new \DateTime($meeting->start_datetime, new \DateTimeZone($timezone));
			//convert time to UTC 
			$user_date->setTimezone(new \DateTimeZone('UTC'));
			//add meeting duration with start date time
			$start_datetime_duration = date_add(date_create($user_date->format($global_format)), date_interval_create_from_date_string($interval));
			$update = update_post_meta($meeting->ID, '_tutor_zm_start_datetime_with_duration', $start_datetime_duration->format($global_format));
			if ($update) {
				array_push($success_posts, $meeting->ID);
			}
		}
		add_option('tutor_zoom_sync', true);
		wp_send_json_success();
	}

	public function tutor_script_text_domain() {
		wp_set_script_translations( 'tutor_zoom_admin_js', 'tutor-pro', tutor_pro()->path.'languages/' );
		wp_set_script_translations( 'tutor_zoom_frontend_js', 'tutor-pro', tutor_pro()->path.'languages/' );
	}

	public function load_modal_wrapper() {
		?>
		<div class="tutor-modal modal-sticky-header-footer tutor-zoom-meeting-modal-wrap">
			<span class="tutor-modal-overlay"></span>
			<div class="tutor-modal-root">
				<div class="tutor-modal-inner">
					<div class="tutor-modal-header">
						<h3 class="tutor-modal-title">
							<?php _e('Zoom Meeting', 'tutor-pro'); ?>
						</h3>
						<button data-tutor-modal-close class="tutor-modal-close">
							<span class="las la-times"></span>
						</button>
					</div>
					<div class="tutor-modal-body-alt modal-container">

					</div>
					<div class="tutor-modal-footer">
						<div class="tutor-bs-row">
							<div class="tutor-bs-col">
								<button type="button" class="tutor-btn update_zoom_meeting_modal_btn">
									<?php _e('Update Meeting', 'tutor-pro'); ?>
								</button>
							</div>
							<div class="tutor-bs-col-auto">
								<button data-tutor-modal-close class="tutor-btn tutor-is-default">
									<?php _e('Cancel', 'tutor-pro'); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
