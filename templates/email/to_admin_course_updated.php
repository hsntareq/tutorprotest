<?php

/**
 * @package TutorLMS/Templates
 *
 * @since 2.0
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
		<style>
			.tutor-email-separator{background-image:url(<?php echo TUTOR_EMAIL()->url . 'assets/images/sep.png'; ?>);background-repeat: repeat-x;background-position: center; }
			.tutor-email-button{background-color: #3E64DE;border-color: #3E64DE;color: #fff!important;padding: 10px 34px;cursor: pointer;border-radius: 6px;text-decoration: none;font-weight: 500;border: 1px solid;position: relative;box-sizing: border-box;transition: 0.2s;line-height: 26px;font-size: 16px;display: inline-flex;justify-content: center;}
			.tutor-email-button:hover{background-color: #395BCA;color: #fff;}
			.tutor-email-body{background-color: #EFF1F6;padding: 80px 0;}
			.tutor-email-warning {text-align: right;}
			.tutor-email-warning > * {vertical-align: middle;}
			@media only screen and (max-width: 768px) {
				.tutor-email-body{background-color: #fff;padding: 0;}
			}
		</style>
	</head>
	<body>
<div class="tutor-email-body">
	<div style="background: #ffffff;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.05);border-radius: 10px;max-width: 600px;margin: 0 auto;font-style: normal;font-weight: 400;font-size: 16px;">
		<div style="border-bottom: 1px solid #E0E2EA; padding: 20px 50px;">

		<table width="100%" style="font-size: 16px;">
			<tr>
				<td><a target="_blank" href="{site_url}"><img src="{logo}" alt="" style="display:inline-block;" data-source="email-title-logo"></a></td>
				<td align="right">
					<div class="tutor-email-warning">
						<img src="<?php echo TUTOR_EMAIL()->url . 'assets/images/warning.svg'; ?>" alt="notice">
						<span>This is a test mail</span>
					</div>
				</td>
			</tr>
		</table>

		</div>
		<div style="background: url(<?php echo TUTOR_EMAIL()->url . 'assets/images/heading.png'; ?>) top right no-repeat;padding: 50px;">
			<div style="margin-bottom: 30px">
				<p data-source="email-heading" style="overflow-wrap: break-word;font-weight: 500;font-size: 20px;line-height: 28px;color: #212327;rgb(255 255 255 / 90%)">{email_heading}</p>
			</div>
			<div style="margin-bottom: 40px;">
				<p style="color: #212327; font-weight: 400; font-size: 16px; line-height: 26px;color: #212327;"><?php _e( 'Dear {instructor_username},', 'tutor-pro' ); ?></p>
				<div data-source="email-additional-message" style="font-size: 16px; line-height: 26px;">{email_message}</div>
			</div>
			<table style="margin-bottom: 48px;font-size: 16px;" width=100%S"">
				<tr>
					<td width="38%"><?php echo _e( 'Course Name:', 'tutor-pro' ); ?></td>
					<td><strong>{course_name}</strong></td>
				</tr>
			</table>
			<div style="margin-bottom: 0;">
				<a target="_blank" class="tutor-email-button" href="{site_url}" data-source="email-btn-url"><?php echo __( 'View the Course', 'tutor-pro' ); ?></a>
			</div>

		</div>
		<div class="tutor-email-footer">
			<div class="tutor-email-separator" style="margin-bottom: 14px; position: relative;height:28px; text-align:center;">
				<img style="z-index:9;position:relative;" src="<?php echo esc_url( TUTOR_EMAIL()->url . 'assets/images/email.svg' ); ?>">
			</div>

			<div style="padding: 0 50px 25px">
				<div data-source="email-footer-text" style="color: #757C8E;font-weight: 400;font-size: 16px;line-height: 26px;text-align: center;">{footer_text}</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
