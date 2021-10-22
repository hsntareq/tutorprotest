<?php
$post_id = get_the_ID();
if ( ! empty($_POST['lesson_id'])){
	$post_id = sanitize_text_field($_POST['lesson_id']);
}

$_is_preview = get_post_meta($post_id, '_is_preview', true);
?>


<div class="tutor-mb-30">
    <div class="tutor-input-group">
        <div class="tutor-form-check tutor-mb-15">
            <div class="tutor-form-check tutor-mb-15">
                <input id="_enable_preview_course" type="checkbox" class="tutor-form-check-input" name="_is_preview" value="1"  <?php checked(1, $_is_preview); ?>/>
                <label for="_enable_preview_course">Select Option</label>
            </div>
        </div>
    </div>
    <p class="tutor-input-feedback tutor-has-icon">
        <i class="tutor-v2-icon-test icon-info-circle-outline-filled tutor-input-feedback-icon"></i>
        <?php _e('If checked, any users/guest can view this lesson without enroll course', 'tutor-pro'); ?>
    </p>
</div>