<?php
if ( ! defined( 'ABSPATH' ) )
exit;

global $wpdb;
// Pagination
$per_page       = 20;
$paged          = max( 1, tutils()->avalue_dot('paged', $_GET) );
$current_page   = sanitize_text_field( tutor_utils()->array_get('sub_page', $_GET, '') );

// Search Filter
$_search    = isset($_GET['search']) ? $_GET['search'] : '';
$_course    = isset($_GET['course']) ? $_GET['course'] : '';
$_date      = isset($_GET['date']) ? tutor_get_formated_date( 'Y-m-d', $_GET['date'] ) : '';
$_filter    = $current_page === 'expired' ? 'expired' : 'active';
$orderby    = ( !isset( $_GET['orderby'] ) || $_GET['orderby'] !== 'post_title' ) ? 'datetime' : 'post_title';
$order      = ( !isset($_GET['order']) || $_GET['order'] !== 'desc' ) ? 'asc' : 'desc';

$user_id = get_current_user_id();
$has_items = count(get_tutor_zoom_meetings(array(
    'author'    =>  sanitize_text_field( $user_id ),
    'filter'    => sanitize_text_field( $_filter )
)));
$total_items = count(get_tutor_zoom_meetings(array(
    'author'    => sanitize_text_field( $user_id ),
    'search'    => sanitize_text_field( $_search ),
    'course_id' => sanitize_text_field( $_course ),
    'date'      => sanitize_text_field( $_date ),
    'filter'    => sanitize_text_field( $_filter ),
)));

$meetings = get_tutor_zoom_meetings(array(
    'author'    => sanitize_text_field( $user_id ),
    'paged'     => sanitize_text_field( $paged ),
    'per_page'  => sanitize_text_field( $per_page ),
    'search'    => sanitize_text_field( $_search ),
    'course_id' => sanitize_text_field( $_course ),
    'date'      => sanitize_text_field( $_date ),
    'filter'    => sanitize_text_field( $_filter ),
    'orderby'   => sanitize_text_field( $orderby ),
    'order'     => sanitize_text_field( $order )
));

$courses = get_posts(array(
    'author'        => sanitize_text_field( $user_id ),
    'numberposts'   => -1,
    'post_type'     => tutor()->course_post_type,
    'post_status'   => 'publish'
));

if ($has_items > 0) { ?>
    <div class="tutor-zoom-page-title">
        <h3><?php _e('Meeting List', 'tutor-pro') ?></h3>
    </div>
    <div class="tutor-admin-search-box-container">

        <div style="flex:1"> 
            <div class="menu-label"><?php _e('Search', 'tutor-pro'); ?></div>
            <div>
                <input type="text" class="tutor-report-search" value="<?php echo $_search; ?>" autocomplete="off" placeholder="<?php _e('Search in here.', 'tutor-pro'); ?>" />
                <button class="tutor-zoom-search-action tutor-report-search-btn"><i class="tutor-icon-magnifying-glass-1"></i></button>
            </div>
        </div>

        <div class="tutor-zoom-course-date-wrapper">
            <div>
                <div class="menu-label"><?php _e('Course', 'tutor-pro'); ?></div>
                <div>
                    <select class="tutor-zoom-course">
                        <option value=""><?php _e('All', 'tutor-pro'); ?></option>
                        <?php
                        if (!empty($courses)) {
                            foreach ($courses as $key => $course) {
                                echo '<option '.($_course == $course->ID ? "selected" : "").' value="'.$course->ID.'">'.$course->post_title.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div>
                <div class="menu-label"><?php _e('Date', 'tutor-pro'); ?></div>
                <div class="date-range-input">
                    <input type="text" class="tutor_zoom_datepicker tutor-zoom-date" value="<?php echo $_date != '' ? tutor_get_formated_date( get_option( 'date_format'), $_date ) : ''; ?>" autocomplete="off" placeholder="<?php echo __( get_option( 'date_format' ), 'tutor-pro' ); ?>" />
                    <i class="tutor-icon-calendar"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="tutor-list-wrap tutor-zoom-meeting-list">
        <?php 
        if (!empty($meetings)) { 
            
            $sort_order = array('order' => $order=='asc' ? 'desc' : 'asc');

            $time_sort = http_build_query(array_merge($_GET, ( $orderby=='datetime' ? $sort_order : array() ), array( 'orderby' => 'datetime' )));
            $name_sort = http_build_query(array_merge($_GET, ( $orderby=='post_title' ? $sort_order : array() ), array( 'orderby' => 'post_title' )));
            
            $time_icon = $orderby=='datetime' ? (strtolower( $order ) == 'asc' ? 'up' : 'down') : 'up';
            $name_icon = $orderby=='post_title' ? (strtolower( $order ) == 'asc' ? 'up' : 'down') : 'up';

            ?>
            <table class="tutor-list-table">
                <thead>
                    <tr>
                        <th>
                            <?php _e('Start Time', 'tutor-pro'); ?>
                            <a href="?<?php echo $time_sort; ?>" style="position: relative; top: 6px;">
                                <img src="<?php echo tutor_pro()->url; ?>addons/tutor-zoom/assets/images/order-<?php echo $time_icon; ?>.svg"/>
                            </a>
                        </th>
                        <th>
                            <?php _e('Meeting Name', 'tutor-pro'); ?>
                            <a href="?<?php echo $name_sort; ?>" style="position: relative; top: 6px;">
                                <img src="<?php echo tutor_pro()->url; ?>addons/tutor-zoom/assets/images/order-<?php echo $name_icon; ?>.svg"/>
                            </a>
                        </th>
                        <th><?php _e('Meeting ID', 'tutor-pro'); ?></th>
                        <th><?php _e('Password', 'tutor-pro'); ?></th>
                        <th><?php _e('Host Email', 'tutor-pro'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    $current_time = time();
                    $i = 0;
                    foreach ($meetings as $key => $meeting) { 
                       
                        if ( $current_page == 'expired' ) {
                            if ( !$meeting->is_expired ) {
                                continue;
                            }
                        } else {
                            if ( $meeting->is_expired ) {
                                continue;
                            }
                        }
                        $i++;
                        $tzm_start      = get_post_meta($meeting->ID, '_tutor_zm_start_datetime', true);
                        $meeting_data   = get_post_meta($meeting->ID, $this->zoom_meeting_post_meta, true);
                        $meeting_data   = json_decode($meeting_data, true);
                        $input_date     = \DateTime::createFromFormat('Y-m-d H:i:s', $tzm_start);
                        $start_date     = $input_date->format('j M, Y,<\b\r>h:i A');
                        $course_id      = get_post_meta($meeting->ID, '_tutor_zm_for_course', true);
                        $topic_id       = get_post_meta($meeting->ID, '_tutor_zm_for_topic', true);

                        $duration       = get_post_meta($meeting->ID, '_tutor_zm_duration', true);
                        $unit           = get_post_meta($meeting->ID, '_tutor_zm_duration_unit', true);
                        $duration       = $unit == 'hr' ? $duration * 60 : $duration;
                        $is_past        = $current_time >= ($input_date->getTimestamp() + ($duration * 60));
                        if ( !is_null($meeting_data) ):
                        ?>
                        <tr class="tutor-zoom-meeting-item">
                            <td>
                                <?php echo $start_date; ?> 
                            </td>
                            <td style="max-width:280px; word-break:break-all;">
                                <span><?php echo $meeting->post_title; ?></span>
                                <p><?php echo __('Course:', 'tutor-pro').' '.get_the_title($course_id); ?></p>
                            </td>
                            <td><?php echo $meeting_data['id']; ?></td>
                            <td><?php echo $meeting_data['password']; ?></td>
                            <td><?php echo $meeting_data['host_email']; ?></td>
                            <td class="col-action">
                                <div class="details-button">
                                    <?php
                                        $button_text    = 'Start Meeting';
                                        $button_class   = 'button-fill';
                                        if ( $meeting->is_expired ) {
                                            $button_text  = 'Expired';
                                            $button_class = 'button-disabled';
                                        } elseif ( $meeting->is_started ) {
                                            $button_text  = 'Join Now';
                                            $button_class = 'button-outlined'; 
                                        }
                                    ?>
                                    <a href="<?php echo !$is_past ? $meeting_data['start_url'] : 'javascript:void(0)'; ?>" class="tutor-btn bordered-btn <?php esc_attr_e( $button_class );?>" target="<?php echo !$is_past ? '_blank' : ''; ?>"> 
                                        <i class="tutor-icon-zoom"></i>
                                        <?php _e( $button_text, 'tutor-pro' ); ?>
                                    </a>

                                    <a href="javascript:void(0);" class="tutor-zoom-meeting-modal-open-btn edit" data-meeting-id="<?php echo $meeting->ID; ?>" data-topic-id="<?php echo $topic_id; ?>" data-course-id="<?php echo $course_id; ?>" data-click-form="0"><i class="tutor-icon-pencil"></i></a>
                                    <a href="javascript:void(0);" class="tutor-zoom-meeting-delete-btn delete" data-meeting-id="<?php echo $meeting->ID; ?>"><i class="tutor-icon-garbage"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endif;?>
                    <?php } ?>
                </tbody>
            </table>
        <?php
        } else { ?>
            <div class="no-data-found">
                <img src="<?php echo tutor_pro()->url."addons/tutor-report/assets/images/empty-data.svg"?>" alt="">
                <span><?php _e('No Zoom meetings found', 'tutor-pro'); ?></span>
            </div>
        <?php } if ( count($meetings) ): ?>
        <div class="tutor-list-footer">
            <div class="tutor-report-count">
                <?php 
                    $item = _n( 'item', 'items', $i, 'tutor-pro' ); 
                    if($total_items > 0){
                        printf( __('Showing <strong> %s </strong> of <strong> %s </strong> '.$item.' '), $i, $total_items );
                    }
                ?>
            </div>
            <div class="tutor-pagination">
                <?php
                echo paginate_links( array(
                    'base' => str_replace( 1, '%#%', "admin.php?page=tutor_zoom&sub_page=$current_page&paged=%#%" ),
                    'current' => sanitize_text_field( $paged ),
                    'total' => ceil($total_items/$per_page)
                ) );
                ?>
            </div>
        </div>
        <?php endif;?>
    </div>
<?php 
} else { ?>
    <div class='tutor-alert tutor-alert-info'>
        <?php _e('To add a new meeting, please open a course in editing mode.', 'tutor-pro'); ?>
    </div>
    <div class="tutor-zoom-data-found">
        <img src="<?php echo TUTOR_ZOOM()->url.'assets/images/empty-meeting.png'; ?>" alt="" />
        <p><?php _e('Not enough data to show', 'tutor-pro'); ?></p>
    </div>
<?php 
} ?>

<?php do_action('tutor_zoom/after/meetings'); ?>