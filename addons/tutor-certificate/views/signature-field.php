<div class="tutor-bs-row">
    <div class="tutor-bs-col-12">
        <div class="tutor-form-group">
            <label><?php _e('Certificate Signature', 'tutor-pro'); ?></label>
            <div id="tutor-instructor-signature-upload">
                <div>
                    <img src="<?php echo $signature['url'] ? $signature['url'] : $placeholder_signature; ?>" />
                    <input type="hidden" id="<?php echo $this->file_id_string; ?>" name="<?php echo $this->file_id_string; ?>" value="<?php echo $signature['id'] ? $signature['id'] : ''; ?>" />
                    <input type="file" id="<?php echo $this->file_name_string; ?>" name="<?php echo $this->file_name_string; ?>" accept="image/*" style="display:none"/>
                    <span class="tutor-icon-garbage" id="tutor_pro_custom_signature_file_deleter" <?php echo !$signature['url'] ? 'style="display:none"' : '';?>></span>
                </div>
                <div>
                    <button id="tutor_pro_custom_signature_file_uploader" class="tutor-btn tutor-option-media-upload-btn">
                        <?php _e('Upload Signature', 'tutor-pro'); ?>
                    </button>
                    <br/>
                    <br/>
                    <p>
                        <?php _e('Guidelines', 'tutor-pro'); ?>: <b>700x430 <?php _e('pixels', 'tutor-pro'); ?>;</b><br/>
                        <?php _e('File Support', 'tutor-pro'); ?>: <b>jpg, jpeg, gif, or png.</b> <?php _e('no text on the image', 'tutor-pro'); ?>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>