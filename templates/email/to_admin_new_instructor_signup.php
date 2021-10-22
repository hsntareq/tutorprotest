<?php
/**
 * @package TutorLMS/Templates
 * @since 2.0
 */

?>

<div style="
		background: #ffffff;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.05);
		border-radius: 10px;
		max-width: 600px;
		margin: 0 auto;
		font-family: 'SF Pro Display', sans-serif;
		font-style: normal;
		font-weight: 400;
		font-size: 13px;
		line-height: 138%;
	">
	<div style="border-bottom: 1px solid #e0e2ea; padding: 20px 50px">
		<img src="{logo}" alt="" style="width: 107.39px;" data-source="email-title-logo">
	</div>
	<div style="background: url(<?php echo esc_url( tutor()->v2_img_dir ); ?>email-heading.svg) top right no-repeat;padding: 50px;">
		<div style="margin-bottom: 50px">
			<h6 data-source="email-heading" style="
					overflow-wrap: break-word;
					font-weight: 500;
					font-size: 20px;
					line-height: 140%;
					color: #212327;
				">{email_heading}</h6>
		</div>
		<div style="color: #212327; font-weight: 400; font-size: 16px; line-height: 162%">

		<p><?php _e( 'Dear {instructor_name},', 'tutor-pro' ); ?></p>

		<div data-source="email-additional-message">{email_message}</div>

		</div>

		<table style="margin: 20px 0;">
			<tr>
				<td><?php echo __( 'Instructor Name:', 'tutor-pro' ); ?></td>
				<td><strong>{instructor_name}</strong></td>
			</tr>
			<tr>
				<td><?php echo __( 'Email Address:', 'tutor-pro' ); ?></td>
				<td><strong>{instructor_email}</strong></td>
			</tr>
		</table>
		<div style="
				color: #41454f;
				font-weight: 400;
				font-size: 16px;
				line-height: 162%;
				margin-top: 30px;
			">
			<a href="{course_url}" data-source="email-btn-url" style="
					background-color: #fff;
					border-color: #1973aa;
					color: #1973aa;
					padding: 10px 34px;
					cursor: pointer;
					border-radius: 6px;
					text-decoration: none;
					font-weight: 500;
					border-radius: 3px;
					border: 1px solid;
					position: relative;
					box-sizing: border-box;
					transition: 0.2s;
					line-height: 26px;
					font-size: 16px;
					display: inline-flex;
					justify-content: center;
				"><?php echo __( 'Reject the Application', 'tutor-pro' ); ?></a>

			<a href="{course_url}" data-source="email-btn-url" style="
					background-color: #1973aa;
					border-color: #1973aa;
					color: #fff;
					padding: 10px 34px;
					cursor: pointer;
					border-radius: 6px;
					text-decoration: none;
					font-weight: 500;
					border-radius: 3px;
					border: 1px solid;
					position: relative;
					box-sizing: border-box;
					transition: 0.2s;
					line-height: 26px;
					font-size: 16px;
					display: inline-flex;
					margin-left: 20px;
					justify-content: center;
				"><?php echo __( 'Approve the Instructor', 'tutor-pro' ); ?></a>
		</div>

		<hr style="margin: 30px 0;">

		<div data-source="email-footer-text" style="
				color: #41454f;
				font-weight: 400;
				font-size: 16px;
				line-height: 162%;
				text-align: center;
			">{footer_text}</div>
	</div>
	<!-- /.template-body -->
</div>
