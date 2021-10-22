<?php

/**
 * Grade Book
 *
 * @since v.1.4.2
 * @author themeum
 * @url https://themeum.com
 */

$course_id = get_the_ID();

$gradebooks = tutils()->get_gradebooks();
if(!tutils()->count($gradebooks)) {
	?>
    <div class="tutor-no-announcements">
        <h2><?php _e('No grading system found.', 'tutor-pro'); ?></h2>
        <p> <?php _e('No grading system has been defined to manage student grades. Please contact instructor or site administrator.', 'tutor-pro'); ?> </p>
    </div>
	<?php
	return;
}

$grades = get_generated_gradebook('all', $course_id);
$final_grade = get_generated_gradebook('final', $course_id);
$assignment_grade = get_assignment_gradebook_by_course($course_id);
$quiz_grade = get_quiz_gradebook_by_course($course_id);

if($quiz_grade) {
	?>
	<table class="course-single-gradebooks">
		<tr>
			<th><?php _e('Quiz', 'tutor-pro'); ?></th>
			<th><?php _e('Assignments', 'tutor-pro'); ?></th>
			<th><?php _e('Final Grade', 'tutor-pro'); ?></th>
		</tr>
		<tr>
			<td><?php echo tutor_generate_grade_html($quiz_grade); ?></td>
			<td><?php echo tutor_generate_grade_html($assignment_grade); ?></td>
			<td><?php echo tutor_generate_grade_html($final_grade, 'outline'); ?></td>
		</tr>
	</table>
	<?php
} else {
	_e( 'No data to generate gradebook!', 'tutor-pro');
}

if (tutils()->count($grades)){
	?>
    <table class="course-single-gradebooks">

        <thead>
        <tr>
            <th><?php _e('Title', 'tutor-pro'); ?></th>
            <th><?php _e('Grade', 'tutor-pro'); ?></th>
            <th><?php _e('Status', 'tutor-pro'); ?></th>
        </tr>
        </thead>
		<?php

		foreach ($grades as $grade){
			?>
            <tr>
                <td>
                    <p class="course-item-title">
						<?php
						echo "<span class='gradebook-result-for-label'>".ucwords($grade->result_for)."</span> <br />";

						if ($grade->result_for === 'quiz'){
							echo "<a href='".get_permalink($grade->quiz_id)."' target='_blank'>".get_the_title($grade->quiz_id)."</a>";
						}elseif($grade->result_for === 'assignment'){
							echo "<a href='".get_permalink($grade->assignment_id)."' target='_blank'>".get_the_title($grade->assignment_id)."</a>";
						}
						?>
                    </p>
                </td>
                <td><?php echo tutor_generate_grade_html($grade, 'outline'); ?></td>

                <td>
					<?php
					if ($grade->result_for === 'quiz'){

						$attempt = tutils()->get_quiz_attempt($grade->quiz_id);
						if ($attempt){
							$passing_grade = tutor_utils()->get_quiz_option($grade->quiz_id, 'passing_grade', 0);
							$earned_percentage = $attempt->earned_marks > 0 ? ( number_format(($attempt->earned_marks * 100) / $attempt->total_marks)) : 0;

							echo $earned_percentage >= $passing_grade ? "<span class='text-label submitted-assignment-grade-pass'>".__('Passed', 'tutor-pro')."</span>" :"<span class='submitted-assignment-grade-failed'>".__('Failed', 'tutor-pro')."</span>";

						}else{
							echo "<span class='text-label submitted-assignment-grade-failed'> ".__('Failed', 'tutor-pro')."</span>";
						}

					}elseif($grade->result_for === 'assignment'){

						$submitted = tutils()->is_assignment_submitted($grade->assignment_id);
						if ($submitted){
							$pass_mark = tutor_utils()->get_assignment_option($grade->assignment_id, 'pass_mark');
							$given_mark = get_comment_meta($submitted->comment_ID, 'assignment_mark', true);
							echo $given_mark >= $pass_mark ? "<span class='text-label submitted-assignment-grade-pass'>".__('Passed', 'tutor-pro')."</span>" :"<span class='submitted-assignment-grade-failed'>".__('Failed', 'tutor-pro')."</span>";
						}else{
							echo "<span class='text-label submitted-assignment-grade-failed'> ".__('Failed', 'tutor-pro')."</span>";
						}

					}
					?>

                </td>
            </tr>
			<?php
		}
		?>
    </table>

	<?php
}