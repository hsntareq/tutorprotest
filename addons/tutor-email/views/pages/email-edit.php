<?php
/**
 * Template for editing email template
 *
 * @since v.2.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Certificate
 * @version 2.0
 */

$email_back_url = add_query_arg(
	array(
		'page'     => 'tutor_settings',
		'tab_page' => 'email_notification',
	),
	admin_url( 'admin.php' )
);
$logo           = esc_url( TUTOR_EMAIL()->url . 'assets/images/logo.svg' );
$get_request    = isset( $_GET ) ? $_GET : null;
$recipient      = $active_tab_data['edit_email_data'];
$recipient_data = $recipient['mail'];
$email_template = $recipient_data['template'];

$option_data = isset( get_option( 'email_template_data' )[ $get_request['to'] ][ $get_request['edit'] ] ) ? get_option( 'email_template_data' )[ $get_request['to'] ][ $get_request['edit'] ] : null;


/*
 if ( isset( $option_data ) ) {
	echo '$option_data';
	pr( $option_data );
}
if ( isset( $recipient_data ) ) {
	echo '$recipient_data';
	pr( $recipient_data );
} */

if ( isset( $option_data ) ) {
	$logo          = isset( $option_data['logo'] ) ? $option_data['logo'] : $logo;
	$label         = isset( $option_data['label'] ) ? $option_data['label'] : null;
	$subject       = isset( $option_data['subject'] ) ? $option_data['subject'] : null;
	$heading       = isset( $option_data['heading'] ) ? $option_data['heading'] : null;
	$message       = isset( $option_data['message'] ) ? $option_data['message'] : null;
	$before_button = isset( $option_data['before-button'] ) ? $option_data['before-button'] : null;
	$footer        = isset( $option_data['footer-text'] ) ? $option_data['footer-text'] : null;
	$block_heading = isset( $option_data['block-heading'] ) ? $option_data['block-heading'] : null;
	$block_content = isset( $option_data['block-content'] ) ? $option_data['block-content'] : null;
} else {
	$label         = isset( $recipient_data['label'] ) ? $recipient_data['label'] : null;
	$subject       = isset( $recipient_data['subject'] ) ? $recipient_data['subject'] : null;
	$heading       = isset( $recipient_data['heading'] ) ? $recipient_data['heading'] : null;
	$message       = isset( $recipient_data['message'] ) ? $recipient_data['message'] : null;
	$before_button = isset( $recipient_data['before-button'] ) ? $recipient_data['before-button'] : null;
	$footer        = isset( $recipient_data['footer-text'] ) ? $recipient_data['footer-text'] : null;
	$block_heading = isset( $recipient_data['block-heading'] ) ? $recipient_data['block-heading'] : null;
	$block_content = isset( $recipient_data['block-content'] ) ? $recipient_data['block-content'] : null;
}


?>
<section class="tutor-backend-settings-page email-manage-page" style="margin-left: 185px-">
	<header class="header-wrapper tutor-px-30 tutor-py-25">
		<a href="<?php echo esc_url( $email_back_url ); ?>" class="prev-page d-inline-flex align-items-center">
			<span class="tutor-v2-icon-test icon-previous-line"></span>
			<span class="text-regular-caption">Back</span>
		</a>
		<div class="header-main d-flex flex-wrap align-items-center justify-content-between">
			<div class="header-left">
				<h4 class="title d-flex align-items-center text-medium-h4 tutor-mt-10">
				<?php echo $recipient_data['label']; ?>
					<label class="tutor-form-toggle tutor-ml-20">
						<input type="checkbox" class="tutor-form-toggle-input" checked="">
						<span class="tutor-form-toggle-control"></span>
					</label>
				</h4>
				<span class="subtitle tutor-mt-5 text-regular-body d-inline-flex">
					<?php
					echo esc_html( ucfirst( str_replace( '_', ' ', $get_request['to'] ) ) );
					echo '<br>' . $email_template;
					?>
				</span>
			</div>

			<div class="header-right d-inline-flex">
				<div style="width: 300px;display:flex;align-items: center;">
					<label class="tutor-form-toggle tutor-ml-20">
						<input type="checkbox" class="tutor-form-toggle-input" id="email-custom">
						<span class="tutor-form-toggle-control"></span>
					</label>

					<input disabled="disabled" type="email" name="email-testing-email" class="tutor-form-control" value="hsntareq@live.com" placeholder="Add your testing email">
				</div>
				<button class="tutor-btn tutor-is-default tutor-is-sm is-text-only" id="send_a_test_email">
					<span class="tutor-v2-icon-test icon-send-filled"></span>
					<span>Send a Test Mail</span>
				</button>
				<button class="tutor-btn tutor-is-sm ml-0 ml-lg-4" form="email_template_form" id="email_template_save">Save Changes</button>
			</div>
		</div>
	</header>

	<!-- .main-content.content-left -->
	<main class="main-content-wrapper d-grid" style="--col: 55%">
		<div class="main-content content-left">
			<header class="tutor-mb-30">
				<div class="title text-medium-h6 tutor-mb-10 d-flex align-items-center">
					<span> Template Content </span>
					<div class="tooltip-wrap tooltip-icon">
						<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders: {site_title},
							{site_address}</span>
					</div>
				</div>
			</header>

			<div class="content-form">
				<form method="POST" id="email_template_form">
					<input type="hidden" name="to" value="<?php echo esc_attr( $recipient['to'] ); ?>">
					<input type="hidden" name="key" value="<?php echo esc_attr( $recipient['key'] ); ?>">
					<input type="hidden" name="action" value="save_email_template">
					<div class="tutor-option-single-item item-logoupload">
						<h4>Title Logo</h4>
						<div class="item-wrapper">
							<div class="tutor-option-field-row tutor-bs-d-block">
								<div class="tutor-option-field-input image-previewer is-selected mt-0">
									<div class="d-flex logo-upload mt-0 p-0">
										<div class="logo-preview">
											<span class="preview-loading"></span>
											<img class="upload_preview" src="<?php echo esc_url( $logo ); ?>" alt="course builder logo">
											<span class="delete-btn"></span>
										</div>
										<div class="logo-upload-wrap">
											<p>
												Size: <strong>200x40 pixels;</strong> File Support:
												<strong>jpg, .jpeg or .png.</strong>
											</p>
											<label for="builder-logo-upload" class="tutor-btn tutor-is-sm tutor-is-outline image_upload_button">
												<input type="hidden" class="input_file" name="email-title-logo" value="<?php echo esc_url( $logo ); ?>">
												<input type="file" id="builder-logo-upload" accept=".jpg, .jpeg, .png, .svg">
												<span class="tutor-btn-icon tutor-v2-icon-test icon-image-filled"></span>
												<span>Upload Image</span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.tutor-option-single-item.item-logoupload -->

					<?php if ( isset( $recipient_data['subject'] ) && null !== $recipient_data['subject'] ) : ?>
						<div class="tutor-option-field-input field-group tutor-mb-30">
							<label class="tutor-form-label d-flex align-items-center">
								<span> Subject</span>
								<div class="tooltip-wrap tooltip-icon">
									<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders:
										{site_title}, {site_address}</span>
								</div>
							</label>
							<input type="text" name="email-subject" value="<?php echo esc_html( $subject ); ?>" class="tutor-form-control" placeholder="[{site_title}]: New order #{order_number}">
						</div>
					<?php endif; ?>

					<?php if ( isset( $recipient_data['heading'] ) && null !== $recipient_data['heading'] ) : ?>
						<div class="tutor-option-field-input field-group tutor-mb-30">
							<label class="tutor-form-label d-flex align-items-center">
								<span>Email heading </span>
								<div class="tooltip-wrap tooltip-icon">
									<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders:
										{site_title}, {site_address}, {site_url}, {order_date}, {order_number}</span>
								</div>
							</label>
							<input type="text" name="email-heading" class="tutor-form-control" placeholder="New Order: #{order_number}" value="<?php echo esc_html( $heading ); ?>">
						</div>
					<?php endif; ?>

					<?php if ( isset( $recipient_data['message'] ) && null !== $recipient_data['message'] ) : ?>
						<div class="tutor-option-field-input field-group tutor-mb-30">
							<label class="tutor-form-label d-flex align-items-start">
								<span> Additional Content </span>
								<div class="tooltip-wrap tooltip-icon">
									<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders:
										{site_title}, {site_address}, {site_url}, {order_date}, {order_number}</span>
								</div>
							</label>

							<?php
							$content   = html_entity_decode( $message );
							$editor_id = 'email-additional-message';

							$args = array(
								'tinymce'       => array(
									'toolbar1' => 'bold,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo,wp_adv,wp_help',
									'toolbar2' => 'italic,underline,separator,pastetext,removeformat,charmap,outdent,indent',
									'toolbar3' => '',
								),
								'media_buttons' => false,
								'quicktags'     => false,
								'elementpath'   => false,
								'statusbar'     => false,
								'editor_height' => 130,
							);
							wp_editor( $content, $editor_id, $args );
							?>
						</div>
					<?php endif; ?>

					<?php if ( isset( $recipient_data['before-button'] ) && null !== $recipient_data['before-button'] ) : ?>
						<div class="tutor-option-field-input field-group tutor-mb-30">
							<label class="tutor-form-label d-flex align-items-center">
								<span><?php echo __( 'Email Before Button', 'tutor-pro' ); ?></span>
								<div class="tooltip-wrap tooltip-icon">
									<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders:
										{site_title}, {site_address}, {site_url}, {order_date}, {order_number}</span>
								</div>
							</label>
							<textarea style="height: 100px; resize:none;" class="tutor-form-control"  name="email-before-button" placeholder="Before button text."><?php echo esc_html( $before_button ); ?></textarea>
						</div>
					<?php endif; ?>

					<?php if ( isset( $recipient_data['footer-text'] ) && null !== $recipient_data['footer-text'] ) : ?>
					<div class="tutor-option-field-input field-group tutor-mb-30">
						<label class="tutor-form-label d-flex align-items-center">
							<span><?php echo __( 'Email Footer Text', 'tutor-pro' ); ?></span>
							<div class="tooltip-wrap tooltip-icon">
								<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders:
									{site_title}, {site_address}, {site_url}, {order_date}, {order_number}</span>
							</div>
						</label>
						<input type="text" name="email-footer-text" class="tutor-form-control" placeholder="Email footer text." value="<?php echo esc_html( $footer ); ?>">
					</div>
					<?php endif; ?>

					<?php if ( isset( $recipient_data['block-heading'] ) && null !== $recipient_data['block-heading'] ) : ?>
					<div class="tutor-option-field-input field-group tutor-mb-30">
						<label class="tutor-form-label d-flex align-items-center">
							<span><?php echo __( 'Email Block Heading', 'tutor-pro' ); ?></span>
							<div class="tooltip-wrap tooltip-icon">
								<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders:
									{site_title}, {site_address}, {site_url}, {order_date}, {order_number}</span>
							</div>
						</label>
						<input type="text" name="email-block-heading" class="tutor-form-control" placeholder="Email block heading." value="<?php echo esc_html( $block_heading ); ?>">
					</div>
					<?php endif; ?>


					<?php if ( isset( $recipient_data['block-content'] ) && null !== $recipient_data['block-content'] ) : ?>
					<div class="tutor-option-field-input field-group tutor-mb-30">
						<label class="tutor-form-label d-flex align-items-center">
							<span><?php echo __( 'Email Block Content', 'tutor-pro' ); ?></span>
							<div class="tooltip-wrap tooltip-icon">
								<span class="tooltip-txt tooltip-right">Text to appear below the main email content. Available placeholders:
									{site_title}, {site_address}, {site_url}, {order_date}, {order_number}</span>
							</div>
						</label>
						<textarea style="height: 100px;" name="email-block-content" class="tutor-form-control" placeholder="Email block content."><?php echo esc_html( $block_content ); ?></textarea>
					</div>
					<?php endif; ?>

				</form>
			</div>
		</div>
		<!-- /.main-content.content-left -->

		<!-- .main-content.content-right -->
		<div class="main-content content-right">
			<header class="d-flex align-items-center justify-content-between flex-wrap tutor-mb-30">
				<div class="mb-3 mb-xxl-0">
					<div class="title text-medium-h6 tutor-mb-10">Template Preview</div>
				</div>
			</header>

			<!-- Email .template-preview -->
			<div class="template-preview position-relative" data-email_template="<?php echo $email_template; ?>">
			<div class="loading-spinner"></div>
				<?php
					\TUTOR_EMAIL\EmailNotification::tutor_load_email_preview( $email_template );
				?>
			</div>
			<!-- Email /.template-preview -->
		</div>
		<!-- /.main-content.content-right -->
	</main>

	<div class="tutor-notification tutor-is-success">
		<div class="tutor-notification-icon">
			<i class="fas fa-check"></i>
		</div>
		<div class="tutor-notification-content">
			<h5>Successful</h5>
			<p>Your file was uploaded</p>
		</div>
		<button class="tutor-notification-close">
			<i class="fas fa-times"></i>
		</button>
	</div>
</section>

<!-- <select id="email_temlplates"> -->
<?php
	/*
	foreach ( $fields_by_type as $field ) : ?>
		<option <?php echo $get_request['edit'] == $field['key'] ? 'selected' : ''; ?> value="<?php echo $field['key']; ?>"><?php echo $field['label']; ?></option>
	<?php endforeach;  */
?>
<!-- </select> -->
<script>
	let email_temlplates = document.getElementById('email_temlplates');
	let url = new URL(window.location.href);
	if(email_temlplates){
		email_temlplates.onchange = function(e){
			url.searchParams.set('edit',e.target.value);
			window.location.href = url;
		};
	}
</script>

<style>

	.tutor-notification {
		position: fixed;
		bottom: 40px;
		right: 40px;
		z-index: 999;
		opacity: 0;
		visibility: hidden;
	}

	.tutor-notification.show {
		opacity: 1;
		visibility: visible;
	}

	.tutor-notification .tutor-notification-close{
		transition: unset;
	}
	.mce-path {
		display: none ! important;
	}
	.image-previewer{
		width: 100%;
		overflow: hidden;
	}
	.mce-container-body .mce-resizehandle i.mce-i-resize{display: none;}
	.mce-container-body .mce-resizehandle{
		margin: auto;
		left: 0;
		height: 4px;
		width: 40px;
		border-radius: 6px;
		bottom: 0;
		background: #C0C3CB;
		transition: all .2s;
		opacity: 0;
		visibility: hidden;
	}
	.wp-editor-container .mce-container-body .mce-resizehandle:active,
	.wp-editor-container:hover .mce-container-body .mce-resizehandle{
		visibility: visible;
		opacity: 1;
		bottom: 10px;
	}
	input:disabled{
		background: rgba(255,255,255,.5)!important;
		border-color: rgba(220,220,222,.75)!important;
		box-shadow: inset 0 1px 2px rgb(0 0 0 / 4%)!important;
		color: rgba(44,51,56,.5)!important;
	}
</style>
