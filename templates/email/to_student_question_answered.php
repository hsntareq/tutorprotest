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
	<div style="background-image: url(<?php echo esc_url( tutor()->v2_img_dir ); ?>email-heading.svg);background-position: top right;background-repeat: no-repeat;padding: 50px;">
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

		<p><?php _e( 'Hi,', 'tutor-pro' ); ?></p>

			<div data-source="email-additional-message">{email_message}</div>

		</div>

		<div style="font-weight: 400; font-size: 16px; line-height: 162%">
			<p style="color: #41454f; margin-bottom: 30px">
				Here is the answer-
			</p>
			<div style="
					display: flex !important;
					border-top: 1px solid #e0e2ea;
					border-bottom: 1px solid #e0e2ea;
					padding-top: 30px;
					padding-bottom: 30px;
				">
				<span style="margin-right: 12px"><img src="<?php echo esc_url( get_avatar_url( wp_get_current_user()->ID ) ); ?>
" alt="author" width="45" height="45" style="border-radius: 50%;"></span>
				<div>
					<div style="
							margin-bottom: 20px;
							display: flex !important;
							justify-content: space-between !important;
						">
						<span style="
								color: #212327;
								font-weight: 500;
								font-size: 16px;
								line-height: 162%;
							">{answer_by}</span>
						<span  style="
								color: #5b616f;
								font-weight: 400;
								font-size: 15px;
								line-height: 160%;
							">{answer_date}</span>
					</div>
					<p  style="color: #41454f">{question}</p>
				</div>
			</div>
		</div>

		<div style="
				color: #41454f;
				font-weight: 400;
				font-size: 16px;
				line-height: 162%;
				margin-top: 30px;
				text-align: center;
			">
			<div data-source="email-before-button">{before_button}</div>
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
					margin-top: 30px;
					display: inline-flex;
					justify-content: center;
					align-items: center;
				">Reply Q&amp;A</a>
		</div>
	</div>
	<!-- /.template-body -->
</div>

