<?php

/**
 * Class Email Data
 *
 * @package TUTOR
 *
 * @since v.2.0.0
 */

namespace TUTOR_EMAIL;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EmailData {
	public function get_recipients() {
		$email_array = array(
			'email_to_students' => array(
				'course_enrolled'             => array(
					'label'       => __( 'To instructor student completed course', 'tutor-pro' ),
					'template'    => 'to_student_course_enrolled',
					'subject'     => __( 'You are enrolled in a new course', 'tutor-pro' ),
					'heading'     => __( 'You are enrolled in New Course', 'tutor-pro' ),
					'course_name' => __( 'New enrolled Course', 'tutor-pro' ),
					'course_url'  => esc_url( tutor()->url ),
					'message'     => __( 'Welcome to the course <strong>{course_name}</strong> at <strong>{site_url}</strong>. You can start learning.', 'tutor-pro' ),
				),
				'quiz_completed'              => array(
					'label'     => __( 'Quiz Completed', 'tutor-pro' ),
					'template'  => 'to_student_quiz_completed',
					'subject'   => __( 'Your quiz attempt is graded', 'tutor-pro' ),
					'heading'   => __( 'Thank you for attempting the quiz', 'tutor-pro' ),
					'username'  => __( 'Student', 'tutor-pro' ),
					'quiz_name' => __( 'Quiz Name of a course!', 'tutor-pro' ),
					'message'   => __( 'The grade has been submitted for the quiz <strong>{quiz_name}</strong> for the course <strong>{course_name}</strong>.', 'tutor-pro' ),
				),
				'completed_course'            => array(
					'label'         => __( 'Completed a Course', 'tutor-pro' ),
					'template'      => 'to_student_course_completed',
					'subject'       => __( 'Subject on Finishing the Course', 'tutor-pro' ),
					'heading'       => __( 'Congratulations on Finishing the Course', 'tutor-pro' ),
					'message'       => __( 'Congratulations on completing the course The most popular and modern server. We hope that you had a great experience.', 'tutor-pro' ),
					'before-button' => __( 'We would really appreciate it if you can post a review on the course and the instructor. Your valuable feedback would help us improve the content on our site and improve the learning experience.', 'tutor-pro' ),
				),
				'remove_from_course'          => array(
					'label'    => __( 'Remove from Course', 'tutor-pro' ),
					'template' => 'to_student_remove_from_course',
					'subject'  => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'  => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'  => __( 'Welcome to the course {course_name} at {site_url}. You can start learning.', 'tutor-pro' ),
				),
				'assignment_graded'           => array(
					'label'           => __( 'Assignment Graded', 'tutor-pro' ),
					'template'        => 'to_student_assignment_evaluate',
					'subject'         => __( 'Subject for Assignment Graded', 'tutor-pro' ),
					'username'        => __( 'Student', 'tutor-pro' ),
					'heading'         => __( 'Assignment has been Graded', 'tutor-pro' ),
					'course_name'     => __( 'Course Name of ' . get_bloginfo( 'name' ), 'tutor-pro' ),
					'assignment-name' => __( 'Assignment Name', 'tutor-pro' ),
					'message'         => __( 'The grade has been submitted for the assignment <strong>{assignment_name}</strong> for the course <strong>{course_name}</strong>.', 'tutor-pro' ),
					'block-heading'   => __( 'Instructor Note', 'tutor-pro' ),
					'block-content'   => __( 'What does it take to be successful? Ask around and you will find different answers to the formula of success. The truth is, success leaves clues and you can achieve.', 'tutor-pro' ),
				),
				'new_announcement_posted'     => array(
					'label'    => __( 'New Announcement Posted', 'tutor-pro' ),
					'template' => 'to_student_new_announcement_posted',
					'subject'  => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'  => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'  => __( 'Welcome to the course {course_name} at {site_url}. You can start learning.', 'tutor-pro' ),
				),
				'new_announcement_posted'     => array(
					'label'                => __( 'New Announcement Updated', 'tutor-pro' ),
					'template'             => 'to_student_announcement_updated',
					'subject'              => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'              => __( 'The instructor updated the announcement', 'tutor-pro' ),
					'message'              => __( 'The instructor updated the announcement on course -Your Complete Beginner to Advanced Class.', 'tutor-pro' ),
					'announcement_heading' => __( 'Upcomming Exam Notice & Schedule', 'tutor-pro' ),
					'announcement_message' => __( '<p>Assertively incentivize prospective users before alternative imperatives. Quickly strategize best-of-breed testing procedures after high-payoff human capital.</p><p>Seamlessly incentivize diverse quality vectors before clicks-and-mortar collaboration and idea-sharing. Dramatically fashion just in time partnerships without distinctive scenarios. Quickly predominate principle-centered results through corporate alignments.</p>', 'tutor-pro' ),
				),
				'after_question_answered'     => array(
					'label'         => __( 'Q&A Message Answered', 'tutor-pro' ),
					'template'      => 'to_student_question_answered',
					'subject'       => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'answer_by'     => __( 'Answer Author', 'tutor-pro' ),
					'answer_date'   => __( '1 day ago', 'tutor-pro' ),
					'heading'       => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'       => __( 'The instructor has answered your question on the course - {course_name}.', 'tutor-pro' ),
					'question'      => __( 'I help ambitious graphic designers and hand letterers level-up their skills and creativity. Grab freebies + tutorials here! >> https://every-tuesday.com', 'tutor-pro' ),
					'before-button' => __( 'Please click on this link to reply to the question.', 'tutor-pro' ),
				),
				'feedback_submitted_for_quiz' => array(
					'label'         => __( 'Feedback submitted for Quiz Attempt', 'tutor-pro' ),
					'template'      => 'to_student_feedback_submitted_for_quiz',
					'subject'       => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'username'      => __( 'Student', 'tutor-pro' ),
					'heading'       => __( 'Quiz Answers Reviewed', 'tutor-pro' ),
					'message'       => __( 'Welcome to the course {course_name} at {site_url}. You can start learning.', 'tutor-pro' ),
					'block-heading' => __( 'Instructor Note', 'tutor-pro' ),
					'block-content' => __( 'What does it take to be successful? Ask around and you will find different answers to the formula of success. The truth is, success leaves clues and you can achieve.', 'tutor-pro' ),
				),
				'enrollment_expired'          => array(
					'label'    => __( 'Course enrolment expired', 'tutor-pro' ),
					'template' => 'to_student_enrollment_expired',
					'subject'  => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'  => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'  => __( 'Welcome to the course {course_name} at {site_url}. You can start learning.', 'tutor-pro' ),
				),
			),
			'email_to_teachers' => array(
				'a_student_enrolled_in_course'     => array(
					'label'               => __( 'A Student Enrolled in Course', 'tutor-pro' ),
					'template'            => 'to_instructor_course_enrolled',
					'subject'             => __( 'New Student Enroled at The course name', 'tutor-pro' ),
					'heading'             => __( 'New Student Enroled', 'tutor-pro' ),
					'course_name'         => __( 'The course name.', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'student_username'    => __( 'John Doe', 'tutor-pro' ),
					'student_email'       => __( 'student@testmail.com', 'tutor-pro' ),
					'footer-text'         => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
					'message'             => __(
						'A new student has joined  course  <strong>The course name!</strong>  You have earned <strong>9XX USD</strong> from this enrolment. Your current balance is <strong>9XX USD</strong>.',
						'tutor-pro'
					),
				),
				'a_instructor_course_rejected'     => array(
					'label'               => __( 'A Instructor course rejected', 'tutor-pro' ),
					'template'            => 'to_instructor_course_rejected',
					'subject'             => __( 'Course Content Review Request - (course name)', 'tutor-pro' ),
					'heading'             => __( 'Course Content Review Request', 'tutor-pro' ),
					'course_title'        => __( 'Course Content Review Request title.', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'message'             => __(
						'We are sorry to inform you that we are unable to publish this course according to our terms and conditions of the platform. Please review the course and submit again.',
						'tutor-pro'
					),
				),
				'a_student_completed_course'       => array(
					'label'         => __( 'A Student Completed Course', 'tutor-pro' ),
					'template'      => 'to_instructor_course_completed',
					'subject'       => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'       => __( 'Dashonte Clarke Just Completed a Course!', 'tutor-pro' ),
					'message'       => __( 'Your student Dashonte Clarke just completed the course <strong>{course_name}</strong>. This is a great milestone for you as a teacher and we want you to celebrate this moment.', 'tutor-pro' ),
					'before-button' => __( 'You can view the students progress reports and quiz details by clicking the button at the bottom of this email.', 'tutor-pro' ),
					'footer-text'   => __( 'Please click on this button to reply to the question', 'tutor-pro' ),
				),
				'a_student_completed_lesson'       => array(
					'label'    => __( 'A Student Completed Lesson', 'tutor-pro' ),
					'template' => 'to_instructor_lesson_completed',
					'subject'  => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'  => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'  => __( 'Welcome to the course {course_name} at {site_url}. You can start learning.', 'tutor-pro' ),
				),
				'a_student_placed_question'        => array(
					'label'               => __( 'A Student asked a Question in Q&amp;A', 'tutor-pro' ),
					'template'            => 'to_instructor_asked_question_by_student',
					'subject'             => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'             => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'instructor_username' => __( 'Teacher Name', 'tutor-pro' ),
					'course_name'         => __( 'The course name.', 'tutor-pro' ),
					'enroll_time'         => __( '1 days ago', 'tutor-pro' ),
					'message'             => __( 'Welcome to the course {course_name} at {site_url}. You can start learning.', 'tutor-pro' ),
					'question'            => __( 'I help ambitious graphic designers and hand letterers level-up their skills and creativity. Grab freebies + tutorials here! >> https://every-tuesday.com.', 'tutor-pro' ),
					'footer-text'         => __( 'Please click on this button to reply to the question', 'tutor-pro' ),
				),
				'student_submitted_quiz'           => array(
					'label'               => __( 'Student Submitted Quiz', 'tutor-pro' ),
					'template'            => 'to_instructor_quiz_completed',
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'subject'             => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'             => __( 'Student Attempted a Quiz', 'tutor-pro' ),
					'message'             => __( 'New quiz has attempted by <strong>{instructor_name}</strong>.', 'tutor-pro' ),
					'footer-text'         => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'student_submitted_assignment'     => array(
					'label'           => __( 'Student Submitted Assignment', 'tutor-pro' ),
					'template'        => 'to_instructor_student_submitted_assignment',
					'subject'         => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'course_name'     => __( 'Course name', 'tutor-pro' ),
					'assignment-name' => __( 'Assignment name', 'tutor-pro' ),
					'before-button'   => __( 'Review the assignment from your instructor dashboard and submit the score at your earliest convenience.', 'tutor-pro' ),
					'heading'         => __( 'New Assignment Submitted', 'tutor-pro' ),
					'message'         => __( 'You have received a submission for an assignment.', 'tutor-pro' ),
					'footer-text'     => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'student_new_assignment_published' => array(
					'label'            => __( 'Student New Assignment Published', 'tutor-pro' ),
					'template'         => 'to_student_new_assignment_published',
					'subject'          => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'student_name'     => __( 'Student', 'tutor-pro' ),
					'course_name'      => __( 'Course name', 'tutor-pro' ),
					'assignment_title' => __( 'Assignment title', 'tutor-pro' ),
					'before-button'    => __( 'Review the assignment from your instructor dashboard and submit the score at your earliest convenience.', 'tutor-pro' ),
					'heading'          => __( 'New Assignment Submitted', 'tutor-pro' ),
					'message'          => __( 'We are glad to inform you that new lesson added on course <strong>{course_name}</strong>.', 'tutor-pro' ),
					'footer-text'      => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'student_new_lesson_published'     => array(
					'label'            => __( 'Student New Lesson Published', 'tutor-pro' ),
					'template'         => 'to_student_new_lesson_published',
					'subject'          => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'          => __( 'New Lesson  Published', 'tutor-pro' ),
					'message'          => __( 'We are glad to inform you that new lesson added on course <strong>{course_name}</strong>.', 'tutor-pro' ),
					'student_name'     => __( 'Student', 'tutor-pro' ),
					'course_name'      => __( 'Course name', 'tutor-pro' ),
					'assignment_title' => __( 'Assignment title', 'tutor-pro' ),
					'before-button'    => __( 'Review the lesson from your instructor dashboard and submit the score at your earliest convenience.', 'tutor-pro' ),
					'footer-text'      => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'withdrawal_request_approved'      => array(
					'label'           => __( 'Withdrawal Request Approved', 'tutor-pro' ),
					'template'        => 'to_instructor_withdrawal_request_approved',
					'subject'         => __( 'Congratulations! Withdrawal Request Successful', 'tutor-pro' ),
					'heading'         => __( 'Withdrawal Request Successful!', 'tutor-pro' ),
					'withdraw_amount' => __( '9XX USD', 'tutor-pro' ),
					'message'         => __( 'Congratulations! We have sent withdraw amount via <strong>Paypal</strong> at  <strong>20 Sep 2020 , 9:30PM (GMT+06)</strong>.', 'tutor-pro' ),
					'footer-text'     => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'withdrawal_request_rejected'      => array(
					'label'           => __( 'Withdrawal Request Rejected', 'tutor-pro' ),
					'template'        => 'to_instructor_withdrawal_request_rejected',
					'subject'         => __( 'Withdrawal Request Rejected!', 'tutor-pro' ),
					'heading'         => __( 'Withdrawal Request Rejected!', 'tutor-pro' ),
					'withdraw_amount' => __( '20 USD', 'tutor-pro' ),
					'message'         => __( 'We are sorry to inform you that we could not honor the request for withdrawal  via Paypal at  20 Sep 2020 , 9:30PM (GMT+06). Please reply to this email for further details.', 'tutor-pro' ),
					'footer-text'     => __( 'You may reply to this email to communicate with the (site administrator).', 'tutor-pro' ),
				),
				'withdrawal_request_received'      => array(
					'label'               => __( 'Withdrawal Request Received', 'tutor-pro' ),
					'template'            => 'to_instructor_withdrawal_request_received',
					'subject'             => __( 'Congratulations! withdrawal Request Successful!', 'tutor-pro' ),
					'withdraw_amount'     => __( '20 USD', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'instructor_email'    => __( 'instructor@tutor.com', 'tutor-pro' ),
					'heading'             => __( 'Withdrawal Request Successful!', 'tutor-pro' ),
					'message'             => __(
						'We have received a withdrawal request via Paypal at  20 Sep 2020 , 9:30PM (GMT+06). We will process the request very soon. We will notify you via email as soon as we process it.',
						'tutor-pro'
					),
					'footer-text'         => __( 'You may reply to this email to communicate with the (site administrator)', 'tutor-pro' ),
				),
				'instructor_application_accepted'  => array(
					'label'       => __( 'Instructor Application Accepted ', 'tutor-pro' ),
					'template'    => 'to_instructor_become_application_approved',
					'subject'     => __( 'Congratulations! Your Application to Become an Instructor at {site_name} is Approved!', 'tutor-pro' ),
					'heading'     => __( 'Welcome you on Board', 'tutor-pro' ),
					'message'     => __( 'Congratulations! !  Your Application to Become an Instructor at <strong>{site_name}</strong> is Approved!  Your personal dashboard is ready and you can start creating courses right away!', 'tutor-pro' ),
					'footer-text' => __( 'You may reply to this email to communicate with the (site administrator).', 'tutor-pro' ),
				),
				'instructor_application_rejected'  => array(
					'label'       => __( 'Instructor become Application Rejected', 'tutor-pro' ),
					'template'    => 'to_instructor_become_application_rejected',
					'subject'     => __( 'Withdrawal Request Rejected!', 'tutor-pro' ),
					'heading'     => __( 'Withdrawal Request Rejected!', 'tutor-pro' ),
					'message'     => __( 'We are sorry to inform you that we could not honor the request for withdrawal  via Paypal at  20 Sep 2020 , 9:30PM (GMT+06). Please reply to this email for further details.', 'tutor-pro' ),
					'footer-text' => __( 'If you want to  discuss this  decision or want to offer us more details to review your application, please feel free to reply to this email.', 'tutor-pro' ),
				),
				'instructor_application_received'  => array(
					'label'               => __( 'Instructor Application Received', 'tutor-pro' ),
					'template'            => 'to_instructor_become_application_received',
					'subject'             => __( 'Subject for Instructor Application Received', 'tutor-pro' ),
					'heading'             => __( 'Received Application', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'instructor_email'    => __( 'instructor@tutor.com', 'tutor-pro' ),
					'message'             => __( 'We are happy that you have considered <strong>{site_name}</strong> to host your courses. Please allow us some time to review your credentials. If we need any clarification on anything, someone from our team will reach out. Please expect an email from us in a few days!.', 'tutor-pro' ),
					'footer-text'         => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'instructor_course_publish'        => array(
					'label'               => __( 'Instructor Course Published', 'tutor-pro' ),
					'template'            => 'to_instructor_course_accepted',
					'subject'             => __( 'New Student Enroled at The course name', 'tutor-pro' ),
					'heading'             => __( 'Your Course is Published', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'course_title'        => __( 'Course name', 'tutor-pro' ),
					'student_username'    => __( 'John Doe', 'tutor-pro' ),
					'student_email'       => __( 'student@testmail.com', 'tutor-pro' ),
					'message'             => __( 'We are glad to inform you that course is now live at <strong>{site_url}</strong>.', 'tutor-pro' ),
					'footer-text'         => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
			),
			'email_to_admin'    => array(
				'new_instructor_signup'  => array(
					'label'           => __( 'New Instructor Signup', 'tutor-pro' ),
					'template'        => 'to_admin_new_instructor_signup',
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'subject'         => __( 'Subject New Instructor Sign Up', 'tutor-pro' ),
					'heading'         => __( 'New Instructor Sign Up', 'tutor-pro' ),
					'message'         => __( ' A new instructor has signed up to your site <strong>{site_url}</strong>.', 'tutor-pro' ),
					'footer-text'     => __( 'You may reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'new_student_signup'     => array(
					'label'           => __( 'New Student Signup', 'tutor-pro' ),
					'template'        => 'to_admin_new_student_signup',
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'student_name'    => __( 'Student', 'tutor-pro' ),
					'subject'         => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'         => __( 'New Student Sign Up', 'tutor-pro' ),
					'message'         => __( ' A new student has signed up to your site <strong>{site_url}</strong>', 'tutor-pro' ),
					'footer-text'     => __( 'You may reply to this email to communicate with the student.', 'tutor-pro' ),
				),
				'new_course_submitted'   => array(
					'label'           => __( 'New Course Submitted for Review', 'tutor-pro' ),
					'template'        => 'to_admin_new_course_submitted_for_review',
					'subject'         => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'         => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'course_name'     => __( 'Course name', 'tutor-pro' ),
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'message'         => __( 'A new course has been created by <strong>{instructor_name}</strong> on your site <strong>{site_url}</strong> and waiting for approval.', 'tutor-pro' ),
					'footer-text'     => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'new_course_published'   => array(
					'label'           => __( 'New Course Published', 'tutor-pro' ),
					'template'        => 'to_admin_new_course_published',
					'subject'         => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'heading'         => __( 'New Course Published', 'tutor-pro' ),
					'course_name'     => __( 'Course name', 'tutor-pro' ),
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'message'         => __( 'Welcome to the course <strong>{course_name}</strong> at <strong>{site_url}</strong>. You can start learning.', 'tutor-pro' ),
					'footer-text'     => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'course_updated'         => array(
					'label'               => __( 'Course Edited/Updated', 'tutor-pro' ),
					'template'            => 'to_admin_course_updated',
					'subject'             => __( 'New Student Enroled at The course name', 'tutor-pro' ),
					'heading'             => __( 'Your Course is Published', 'tutor-pro' ),
					'course_name'         => __( 'The course name.', 'tutor-pro' ),
					'student_username'    => __( 'Student', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'student_email'       => __( 'student@testmail.com', 'tutor-pro' ),
					'footer-text'         => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
					'message'             => __( 'Instructor <strong>{instructor_name}</strong> has updated a course on <strong>{site_url}</strong>.', 'tutor-pro' ),
				),
				'new_withdrawal_request' => array(
					'label'               => __( 'New Withdrawal Request', 'tutor-pro' ),
					'template'            => 'to_admin_new_withdrawal_request',
					'subject'             => __( 'Subject you are enrolled in New Course', 'tutor-pro' ),
					'withdraw_amount'     => __( '20 USD', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'instructor_email'    => __( 'instructor@tutor.com', 'tutor-pro' ),
					'heading'             => __( 'New Withdrawal Request', 'tutor-pro' ),
					'message'             => __(
						'Instructor <strong>{instructor_username}</strong>  has sent a withdrawal request  to your
					site <strong>{site_url}</strong>',
						'tutor-pro'
					),
					'footer-text'         => __( 'You may reply to this email to communicate with the student.', 'tutor-pro' ),
				),
			),
		);

		return apply_filters( 'tutor_pro/email/list', $email_array );
	}
}

