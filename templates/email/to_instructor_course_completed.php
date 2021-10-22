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

		<p><?php _e( 'Dear {instructor_username},', 'tutor-pro' ); ?></p>

		<div data-source="email-additional-message">{email_message}</div>

		</div>

		<div style="display: flex; margin-top:50px;">
			<span style="margin-right: 30px;
			font-size: 16px;
			font-style: normal;
			font-weight: 400;
			line-height: 26px;
			letter-spacing: 0px;
			text-align: left;
			"><?php echo __( 'Student info', 'tutor-pro' ); ?></span>

			<div style="
					display: flex !important;
					border: 1px solid #CDCFD5;
					padding: 10px;
					border-radius: 4px;
				">
				<span style="margin-right: 12px"><img src="<?php echo esc_url( get_avatar_url( wp_get_current_user()->ID ) ); ?>
" alt="author" width="45" height="45" style="border-radius: 50%;"></span>
				<div>
				<p style="
					font-size: 18px;
					font-style: normal;
					font-weight: 500;
					line-height: 28px;
					letter-spacing: 0px;
					text-align: left;
					margin:0;
							">James Andy</p>
				<p style="
					font-size: 13px;
					font-style: normal;
					font-weight: 400;
					line-height: 18px;
					letter-spacing: 0px;
					text-align: left;
					margin:0;
							">demomail45550@email.com</p>
				</div>
			</div>
		</div>

		<div style="text-align: center;margin:10px 0;">
			<div data-source="email-before-button">{before_button}</div>

			<a style="
				display: inline-flex;
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
" href="{course_url}"><svg width="29" height="28" viewBox="0 0 29 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M24.0316 11.723C24.0707 11.856 24.0904 11.994 24.0901 12.1326C24.092 12.2772 24.0599 12.4202 23.9965 12.5501C23.9292 12.6812 23.8452 12.8031 23.7468 12.9129L19.8807 16.6659L20.7936 21.9793C20.823 22.1209 20.823 22.2669 20.7936 22.4085C20.7613 22.5468 20.706 22.6787 20.6297 22.7986C20.5583 22.9229 20.4612 23.0307 20.3449 23.1146C20.1077 23.2845 19.8155 23.3596 19.5257 23.3253C19.387 23.3049 19.2541 23.2558 19.1356 23.1809L14.3371 20.7036L9.55415 23.1809C9.43563 23.2558 9.30273 23.3049 9.16403 23.3253C8.87423 23.3596 8.58204 23.2845 8.34477 23.1146C8.22849 23.0307 8.13141 22.9229 8.05998 22.7986C7.98376 22.6787 7.92837 22.5468 7.89613 22.4085C7.86668 22.2669 7.86668 22.1209 7.89613 21.9793L8.80902 16.6659L4.9273 12.9129C4.82985 12.8049 4.74959 12.6825 4.68932 12.5501C4.6292 12.4185 4.59351 12.277 4.58399 12.1326C4.58372 11.994 4.60343 11.856 4.64251 11.723C4.68395 11.5802 4.75433 11.4474 4.84927 11.3329C4.93707 11.2201 5.04404 11.1237 5.16527 11.0481C5.29658 10.971 5.44294 10.9231 5.5944 10.9077L10.9079 10.1274L13.2876 5.32891C13.3495 5.18846 13.4413 5.06328 13.5568 4.96219C13.671 4.86405 13.8036 4.78977 13.9469 4.74372C14.2158 4.64109 14.513 4.64109 14.7818 4.74372C14.9251 4.78977 15.0578 4.86405 15.1719 4.96219C15.2887 5.07214 15.3817 5.20493 15.445 5.35231L17.7662 10.1274L23.0797 10.9077C23.2322 10.9261 23.3788 10.9781 23.5088 11.0598C23.6338 11.1381 23.7468 11.234 23.8443 11.3446C23.9266 11.4599 23.9899 11.5877 24.0316 11.723ZM16.6193 11.723L14.3371 7.14298L12.0704 11.7347L7.00275 12.4681L10.6621 16.03L9.82334 21.1016L14.3371 18.7101L18.8508 21.1094L18.012 16.0378L21.6714 12.4681L16.6193 11.723Z" fill="white"/>
</svg>
 <?php echo __( 'See Student Report', 'tutor-pro' ); ?></a>
		</div>


		<div data-source="email-footer-text" style="
				color: #41454f;
				font-weight: 400;
				text-align:center;
				font-size: 16px;
				line-height: 162%;
				margin-top: 30px;
			">{footer_text}</div>
	</div>
	<!-- /.template-body -->
</div>
