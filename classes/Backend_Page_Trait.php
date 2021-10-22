<?php
/**
 * Backend Page Trait to use with existing class
 * contains backend page related reuseable code snippet
 *
 * @package Enrollment List
 * @since v2.0.0
 */

namespace TUTOR_PRO;

/**
 * Trait for backend pages
 * Reuse able methods implemented can be override from child class
 */
trait Backend_Page_Trait {
	/**
	 * Bulk action abstract property.
	 *
	 * @var $bulk_action
	 */
	public $bulk_action = true;

	/**
	 * Bulk action default option
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function bulk_action_default(): array {
		return array(
			'value'  => 'bulk action',
			'option' => __( 'Bulk Action', 'tutor-pro' ),
		);
	}

	/**
	 * Bulk action complete
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function bulk_action_complete(): array {
		return array(
			'value'  => 'complete',
			'option' => __( 'Complete', 'tutor-pro' ),
		);
	}

	/**
	 * Bulk action on hold
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function bulk_action_on_hold(): array {
		return array(
			'value'  => 'on-hold',
			'option' => __( 'On Hold', 'tutor-pro' ),
		);
	}

	/**
	 * Bulk action pending
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function bulk_action_pending(): array {
		return array(
			'value'  => 'pending',
			'option' => __( 'Pending', 'tutor-pro' ),
		);
	}

	/**
	 * Bulk action processing
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function bulk_action_processing(): array {
		return array(
			'value'  => 'processing',
			'option' => __( 'Processing', 'tutor-pro' ),
		);
	}

	/**
	 * Bulk action delete
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function bulk_action_delete(): array {
		return array(
			'value'  => 'delete',
			'option' => __( 'Delete', 'tutor-pro' ),
		);
	}

	/**
	 * Bulk action cancel
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function bulk_action_cancel(): array {
		return array(
			'value'  => 'cancel',
			'option' => __( 'Cancel', 'tutor-pro' ),
		);
	}

	/**
	 * Available filters like: Course | Date | Search | Sort By
	 * to override create same method from child class
	 *
	 * @since v2.0.0
	 */
	public function available_filters() {
		$filters = array(
			array(
				'label'      => __( 'Course', 'tutor' ),
				'field_name' => 'tutor-filter-course',
				'id'         => 'tutor-backend-filter-course',
			),
			array(
				'label'      => __( 'Sort By', 'tutor' ),
				'field_name' => 'tutor-filter-order',
				'id'         => 'tutor-backend-filter-order',
			),
			array(
				'label'      => __( 'Date', 'tutor' ),
				'field_name' => 'tutor-filter-date',
				'id'         => 'tutor-backend-filter-date',
			),
			array(
				'label'      => __( 'Search', 'tutor' ),
				'field_name' => 'tutor-filter-search',
				'id'         => 'tutor-backend-filter-search',
			),
		);
		return $filters;
	}
}
