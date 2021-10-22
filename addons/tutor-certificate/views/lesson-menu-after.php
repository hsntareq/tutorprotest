<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

$course_id = get_the_ID();
$show_certificate = (bool) tutils()->get_option('tutor_course_certificate_view');
$disable_certificate = get_post_meta($course_id, '_tutor_disable_certificate', true); // This setting is no more. But used here in favour of backward compatibillity
$certificate_template = get_post_meta($course_id, 'tutor_course_certificate_template', true);

if($certificate_template=='none' || (!$certificate_template && $disable_certificate == 'yes')) {
	/* 
		Conditions when not to show certificate section in course
		-------
		1. If certificate template explicitly set as off (After certificate builder release)
		2. No certificate template is set for the course and old setting is off
	*/
	return;
}

?>

<a 
	id="tutor-download-certificate-pdf" 
	data-course_id="<?php echo $course_id; ?>" 
	data-cert_hash="<?php echo $certificate_hash; ?>" 
	href="#" 
	class="dot-loader-button certificate-download-btn tutor-btn tutor-is-outline">

	<i class="tutor-icon-mortarboard"></i> <?php _e('Download Certificate', 'tutor-pro'); ?>
</a>

<?php if ($show_certificate) { ?>
	<style>
		.tutor-view-certificate { text-align:center; margin-top:10px; font-size:16px; text-transform:uppercase; }
	</style>
	<div class="tutor-view-certificate">
		<a id="tutor-view-certificate-image" href="#" data-href="<?php echo $certificate_url; ?>"><i class="tutor-icon-detail-link"></i> <?php _e('View Certificate', 'tutor-pro'); ?></a>
	</div>
<?php } ?>