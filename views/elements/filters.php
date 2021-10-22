<?php if ( isset( $data ) ) : ?>
	<div class="tutor-admin-page-filters" style="display: flex; justify-content: space-between;">
		<?php if ( $data['bulk_action'] ) : ?>
			<div class="tutor-admin-bulk-action-wrapper">
				<form action="" method="post">
					<div class="tutor-bulk-action-group">
						<select name="bulk-action" id="tutor-backend-bulk-action">
							<?php foreach( $data['bulk_actions'] as $k => $v) : ?>
								<option value="<?php esc_attr_e( $v['value'] ); ?>">
									<?php esc_html_e( $v['option'] ); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<button type="button" class="tutor-btn">
							<?php esc_html_e( 'Apply', 'tutor-pro' ); ?>
						</button>
					</div>
				</form>
			</div>
		<?php endif; ?>
		<?php if ( isset( $data['filters'] ) ) : ?>
			<div class="tutor-admin-page-filter-wrapper" style="display: flex;">
				<?php foreach ( $data['filters'] as $k => $v ) : ?>
					<div class="tutor-form-group">
						<label for="<?php esc_attr_e( $v['id'] ); ?>">
							<?php esc_html_e( $v['label'] ); ?>
						</label>
						<input type="text" id="<?php esc_attr_e( $v['id'] ); ?>" name="<?php esc_attr_e( $v['field_name'] ); ?>">
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
