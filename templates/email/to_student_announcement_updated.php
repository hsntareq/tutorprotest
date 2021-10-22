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

		<p><?php _e( 'Dear {username},', 'tutor-pro' ); ?> </p>

		<div data-source="email-additional-message">{email_message}</div>

		</div>

		<div>
		Your score: 80 out of 100 Pass
		</div>

		<div style="
				background: #E9EDFB;
				color: #212327;
				font-weight: 400;
				font-size: 16px;
				margin-top: 30px;
				padding:25px;
				border: 1px solid #95AAED;
				border-radius: 6px;
			">
			<p style="margin-top: 0;" data-source="email-block-heading">{block_heading}</p>
			<p style="margin-bottom: 0;" data-source="email-block-content">{block_content}</p>
		</div>
	</div>
	<!-- /.template-body -->
</div>

