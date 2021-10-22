<div class="tutor-attachments-metabox">
    <div class="tutor-attachment-cards tutor-course-builder-attachments">
        <?php
            $attachments = tutor_utils()->get_attachments();
            if (is_array($attachments) && count($attachments)) {
                foreach ($attachments as $attachment) { ?>
                <div data-attachment_id="<?php echo $attachment->id; ?>">
                    <div>
                        <a href="<?php echo $attachment->url; ?>" target="_blank">
                            <?php echo $attachment->title; ?>
                        </a>
                        <span class="filesize"><?php _e('Size', 'tutor-pro'); ?>: <?php echo $attachment->size; ?></span>
                        <input type="hidden" name="tutor_attachments[]" value="<?php echo $attachment->id; ?>">
                    </div>
                    <div>
                        <span class="tutor-delete-attachment tutor-icon-line-cross"></span>
                    </div>
                </div>
                <?php 
                }
            }
        ?>
    </div>
    <input type="hidden" name="_tutor_attachments_main_edit" value="true" />    
    <button type="button" class="tutor-btn tutorUploadAttachmentBtn bordered-btn"><i class="tutor-icon-attach"></i><?php _e('Upload Attachment', 'tutor-pro'); ?></button>
</div>