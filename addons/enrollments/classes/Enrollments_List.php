<?php
namespace TUTOR_ENROLLMENTS;

if ( ! defined( 'ABSPATH' ) )
	exit;

if (! class_exists('Tutor_List_Table')){
	include_once tutor()->path.'classes/Tutor_List_Table.php';
}

use TUTOR_PRO\Backend_Page_Trait;

class Enrollments_List extends \Tutor_List_Table {

	/**
	 * Trait for utilities
	 *
	 * @var $page_title
	 */
	use Backend_Page_Trait;
	/**
	 * Page Title
	 *
	 * @var $page_title
	 */
	public $page_title;

	/**
	 * Bulk Action
	 *
	 * @var $bulk_action
	 */
	public $bulk_action = true;

	function __construct() {
		global $status, $page;

		//Set parent defaults
		parent::__construct( array(
			'singular'  => 'enrolment',     //singular name of the listed records
			'plural'    => 'enrolments',    //plural name of the listed records
			'ajax'      => false        //does this table support ajax?
		) );

		$this->page_title = __( 'Enrollment', 'tutor' );
	}

	function column_default($item, $column_name){
		switch($column_name){
			case 'user_email':
			case 'display_name':
				return $item->$column_name;
			default:
				return print_r($item,true); //Show the whole array for troubleshooting purposes
		}
	}

	function column_cb($item){
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("enrolment")
			/*$2%s*/ $item->enrol_id                //The value of the checkbox should be the record's id
		);
	}

	function column_student($item){
		$student_url = tutils()->profile_url($item->student_id);
		$student = "<a href='{$student_url}' target='_blank'>{$item->display_name}</a> <span style='color:silver'>(enrol_id:{$item->enrol_id})</span>  <br /> <small>{$item->user_email}</small>";

		$cancel_enrollment_text		= __( 'Cancel Enrollment', 'tutor-pro' );
		$complete_enrollment_text	= __( 'Complete', 'tutor-pro' );
		$delete_enrollment_text		= _x( 'Delete', 'tutor enrollment delete', 'tutor-pro' );

		$actions = array();

		if ($item->status === 'completed'){
			$actions['cancel'] = sprintf('<a href="?page=%s&action=%s&enrol_id=%s">'.$cancel_enrollment_text.'</a>',$_REQUEST['page'],'cancel',$item->enrol_id);
		}else{
			$actions['complete'] = sprintf('<a href="?page=%s&action=%s&enrol_id=%s">'.$complete_enrollment_text.'</a>',$_REQUEST['page'],'complete',$item->enrol_id);
		}
		$actions['delete'] = sprintf('<a href="?page=%s&action=%s&enrol_id=%s">'.$delete_enrollment_text.'</a>',$_REQUEST['page'],'delete',$item->enrol_id);

		$student .= $this->row_actions($actions);


		return $student;
	}

	function column_course($item){
		$student = "<strong><a href='".get_permalink($item->course_id)."' target='_blank'>{$item->course_title}</a> </strong> <br />";
		$student .= sprintf(__('Date : %s', 'tutor-pro'), date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($item->enrol_date)));

		return $student;
	}

	function column_order($item){
		$order_id = get_post_meta($item->enrol_id, '_tutor_enrolled_by_order_id', true);
		if ($order_id){
			$order_edit_url = admin_url("post.php?post={$order_id}&action=edit");
			$order = "<a href='{$order_edit_url}' target='_blank'> #{$order_id} </a> ";
			return $order;
		}
		return '';
	}

	function column_status($item){
		$enrollment_status = array(
			'pending'	=> __( 'Pending', 'tutor-pro' ),
			'cancel'	=> __( 'Cancel', 'tutor-pro' ),
			'completed'	=> __( 'Completed', 'tutor-pro' ),
		);
		$status_text = isset( $enrollment_status[$item->status] ) ? $enrollment_status[$item->status] : $item->status;
		return "<span class='tutor-status-context tutor-status-{$item->status}'>".$status_text."</span>";
	}

	function get_columns(){
		$columns = array(
			//'cb'                => '<input type="checkbox" />', //Render a checkbox instead of text
			'student'      => __('Student', 'tutor-pro'),
			'course'      => __('Course', 'tutor-pro'),
			'order'      => __('Order', 'tutor-pro'),
			'status'      => __('Enrollment Status', 'tutor-pro'),
		);
		return $columns;
	}

	function get_bulk_actions() {
		$actions = array(
			//'delete'    => 'Delete'
		);
		return $actions;
	}

	function process_bulk_action() {
		global $wpdb;

		$enrol_id 		= tutils()->array_get('enrol_id', $_REQUEST);
		/**
		 * @since 1.8.0
		 * get post 
		 * check if post already have same status
		 * if not then update 
		 */
		$url = admin_url('/admin.php?page=enrollments');
		$post 			= get_post($enrol_id);
		$post_status 	= $post? $post->post_status : ''; 
		
		$enrolment = $wpdb->get_row($wpdb->prepare(
			"SELECT post_author as student_id, post_parent as course_id 
			FROM {$wpdb->posts} 
			WHERE post_type = 'tutor_enrolled' AND 
				ID = %d", 
			$enrol_id
		));
			
		//Detect when a bulk action is being triggered...
		if( 'complete' === $this->current_action() AND $post_status != 'complete' ) {
			$wpdb->update($wpdb->posts, array('post_status' => 'completed'), array('ID' => $enrol_id));
			do_action('tutor_after_enrolled', $enrolment->course_id, $enrolment->student_id, $enrol_id);
			if ( wp_redirect( $url ) ) {
				exit;
			}
		}
		if( 'cancel' === $this->current_action() AND $post_status != 'cancel' ) {
			$wpdb->update($wpdb->posts, array('post_status' => 'cancel'), array('ID' => $enrol_id));

			do_action('tutor_enrollment/after/cancel', $enrol_id);
			do_action( 'tutor_enrollment_cancelled', $enrolment->course_id, $enrolment->student_id, $enrol_id );
			
			if ( wp_redirect( $url ) ) {
				exit;
			}
		}

		if( 'delete' === $this->current_action() AND $post_status != 'delete' ) {
			
			do_action('tutor_enrollment/before/delete', $enrol_id);

			// Delete course progress
			tutor_utils()->delete_course_progress($enrolment->course_id, $enrolment->student_id);

			// Delete enrollemnt
			$wpdb->delete($wpdb->posts, array('ID' => $enrol_id, 'post_type' => 'tutor_enrolled' ));

			delete_post_meta($enrol_id, '_tutor_enrolled_by_order_id');
			delete_post_meta($enrol_id, '_tutor_enrolled_by_product_id');

			do_action('tutor_enrollment/after/delete', $enrol_id);
			
			if ( wp_redirect( $url ) ) {
				exit;
			}
		}
	}

	function prepare_items() {
		$per_page = 20;

		$search_term = '';
		if (isset($_REQUEST['s'])){
			$search_term = sanitize_text_field($_REQUEST['s']);
		}

		$columns = $this->get_columns();
		$hidden = array();

		$this->_column_headers = array($columns, $hidden);
		$this->process_bulk_action();

		$current_page = $this->get_pagenum();

		$total_items = tutor_utils()->get_total_enrolments($search_term);
		$this->items = tutor_utils()->get_enrolments(($current_page-1)*$per_page, $per_page, $search_term);

		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		) );
	}

	/**
	 * Get Enrollment List to display on table
	 * by using search terms & filters
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function get_enrollment_lists(): array {
		$limit;
		return array(
			'list'			=> tutor_utils()->get_enrolments(),
			'total_items'	=> tutor_utils()->get_enrolments()
		);
	}
	/**
	 * Available tabs that will visible on the right side of page navbar
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function tabs_key_value(): array {
		$data = $this->tabs_data();
		$tabs = array(
			array(
				'key'	=> 'all',
				'title' => __( 'All', 'tutor-pro' ),
				'value' => $data['all'],
				'url'   => '?page=enrollments&data=all',
			),
			array(
				'key'	=> 'approved',
				'title' => __( 'Approved', 'tutor-pro' ),
				'value' => $data['approved'],
				'url'   => '?page=enrollments&data=approved',
			),
			array(
				'key'	=> 'cancelled',
				'title' => __( 'Cancelled', 'tutor-pro' ),
				'value' => $data['cancelled'],
				'url'   => '?page=enrollments&data=cancelled',
			)
		);
		return $tabs;
	}

	/**
	 * Provide data for tabs
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function tabs_data() {
		return array(
			'all'       => 100,
			'approved'  => 100,
			'cancelled' => 100
		);
	}	

	/**
	 * Prepare bulk actions that will show on dropdown options
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function prpare_bulk_actions(): array {
		$actions = array(
			$this->bulk_action_default(),
			$this->bulk_action_complete(),
			$this->bulk_action_pending()
		);
		return $actions;
	}
}