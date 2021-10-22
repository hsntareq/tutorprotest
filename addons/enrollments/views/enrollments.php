<?php
/**
 * Enrollment List Template.
 *
 * @package Enrollment List
 */

use TUTOR_ENROLLMENTS\Enrollments_List;
$enrollments = new Enrollments_List();

/**
 * Short able params
 */
$course_id = isset( $_GET['course-id'] ) ? $_GET['course-id'] : '';
$order     = isset( $_GET['order'] ) ? $_GET['order'] : '';
$date      = isset( $_GET['date'] ) ? $_GET['date'] : '';
$search    = isset( $_GET['search'] ) ? $_GET['search'] : '';

/**
 * Determine active tab
 */
$active_tab = isset( $_GET['data'] ) && $_GET['data'] !== '' ? esc_html__( $_GET['data'] ) : 'all';

/**
 * Pagination data
 */
$paged    = ( isset( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) && $_GET['paged'] >= 1 ) ? $_GET['paged'] : 1;
$per_page = 3;
$offset   = ( $per_page * $paged ) - $per_page;

$enrollments_list = $enrollments->get_enrollment_lists()['list'];
$total            = $enrollments->get_enrollment_lists()['total_items'];

/**
 * Navbar data to make nav menu
 */
$navbar_data = array(
	'page_title' => $enrollments->page_title,
	'tabs'       => $enrollments->tabs_key_value( $course_id, $order, $date, $search ),
	'active'     => $active_tab,
);

/**
 * Bulk action & filters
 */
// $filters = array(
// 'bulk_action'   => $enrollments->bulk_action,
// 'bulk_actions'  => $enrollments->prpare_bulk_actions(),
// 'search_filter' => true,
// );
$filters = array(
	'bulk_action'  => $enrollments->bulk_action,
	'bulk_actions' => $enrollments->prpare_bulk_actions(),
	'filters'      => $enrollments->available_filters(),
);

?>
<div class="tutor-admin-page-wrapper">
	<?php
		/**
		 * Load Templates with data.
		 */
		$navbar_template  = esc_url( tutor_pro()->path . 'views/elements/navbar.php' );
		$filters_template = esc_url( tutor_pro()->path . 'views/elements/filters.php' );
		tutor_load_template_from_custom_path( $navbar_template, $navbar_data );
		tutor_load_template_from_custom_path( $filters_template, $filters );
	?>

	<div class="tutor-admin-page-content-wrapper">
		<div class="tutor-table-responsive">
			<table class="tutor-table">
				<thead class="tutor-text-sm tutor-text-400">
					<tr>
						<th>
							<?php esc_html_e( 'Date', 'tutor-pro' ); ?>
						</th>
						<th>
							<?php esc_html_e( 'Course', 'tutor-pro' ); ?>
						</th>
						<th>
							<?php esc_html_e( 'Name', 'tutor-pro' ); ?>
						</th>
						<th>
							<?php esc_html_e( 'Status', 'tutor-pro' ); ?>
						</th>
					</tr>
				</thead>
				<tbody class="tutor-text-500">
					<?php foreach ( $enrollments_list as $list ) : ?>
						<tr>
							<td>
								<?php esc_html_e( tutor_get_formated_date( get_option( 'date_format' ) . get_option( 'time_format' ), $list->enrol_date ) ); ?>
							</td>
							<td>
								<?php esc_html_e( $list->course_title ); ?>
							</td>
							<td>
								<p>
									<?php esc_html_e( $list->user_nicename ); ?>
								</p>
								<p>
									<?php esc_html_e( $list->user_email ); ?>
								</p>
							</td>
							<td>
								<span>
								<?php esc_html_e( $list->status ); ?>
								</span>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="tutor-admin-page-pagination-wrapper">
		<?php
			/**
			 * Prepare pagination data & load template
			 */
			$pagination_data     = array(
				'total_items' => count( $total ),
				'per_page'    => $per_page,
				'paged'       => $paged,
			);
			$pagination_template = esc_url( tutor_pro()->path . 'views/elements/pagination.php', $pagination_data );
			tutor_load_template_from_custom_path( $pagination_template, $pagination_data );
			?>
	</div>
</div>
