<?php

namespace TUTOR_CERT;

if (!defined('ABSPATH'))
    exit;

class Instructor_Signature {
    private $file_name_string = 'tutor_pro_custom_signature_file';
    private $file_id_string = 'tutor_pro_custom_signature_id';
    private $image_meta = 'tutor_pro_custom_signature_image_id';
    private $image_post_identifier = 'tutor_pro_custom_signature_image';

    function __construct($register_handlers = true) {
        if ($register_handlers) {

            add_action('wp_enqueue_scripts', array($this, 'register_script'));

            add_action('tutor_profile_edit_input_after', array($this, 'custom_signature_field'));

            add_action('tutor_profile_update_before', array($this, 'save_custom_signature'));
        }
    }

    public function register_script() {
        if(tutor_utils()->is_tutor_frontend_dashboard('settings')) {
            wp_enqueue_script('tutor-instructor-signature-js', tutor_pro()->url . 'addons/tutor-certificate/assets/js/instructor-signature.js');
            wp_enqueue_style('tutor-instructor-signature-css', tutor_pro()->url . 'addons/tutor-certificate/assets/css/instructor-signature.css');
        }
    }

    public function custom_signature_field($user) {

        if (!tutor_utils()->is_instructor($user->ID)) {
            // It is non instructor user
            return;
        }

        $signature = $this->get_instructor_signature($user->ID);
        $placeholder_signature = tutor_pro()->url . 'addons/tutor-certificate/assets/images/instructor-signature.png';

        include TUTOR_CERT()->path . '/views/signature-field.php';
    }

    public function save_custom_signature($user_id) {

        if (
            isset($_FILES[$this->file_name_string]) &&
            strpos(($_FILES[$this->file_name_string]['type']), 'image/') === 0 &&
            $_FILES[$this->file_name_string]['error'] == 0
        ) {

            $image = $_FILES[$this->file_name_string];

            /* Now process upload and set new thumbnail. */
            $upload = wp_upload_bits($image["name"], null, file_get_contents($image["tmp_name"]));

            $filename = $upload['file'];
            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => ''
            );

            // Create attachment post
            $attach_id = wp_insert_attachment($attachment, $filename);

            require_once(ABSPATH . 'wp-admin/includes/image.php');

            $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
            wp_update_attachment_metadata($attach_id, $attach_data);

            // Set an identifier to the image
            // So we can hide it in dashboard
            update_post_meta($attach_id, $this->image_post_identifier, '1');

            // Delete old signature image
            $this->delete_instructor_signature($user_id);

            // Set the ID as custom signature
            update_user_meta($user_id, $this->image_meta, $attach_id);
        } else if (!is_numeric( tutor_utils()->array_get( $this->file_id_string, $_POST, '' ))) {
            // If image uploaded, it will be assigned
            // Otherwise if image ID also doesn't exist, it means user deleted the image. So remove from server too.
            $this->delete_instructor_signature($user_id);
        }

        if (isset($_FILES[$this->file_name_string])) {

            // Remove the image from array after processing
            unset($_FILES[$this->file_name_string]);
        }
    }

    private function delete_instructor_signature($user_id) {
        $image = $this->get_instructor_signature($user_id);
        
        // Delete file from system
        $image['id'] ? wp_delete_attachment( $image['id'], true ) : 0;

        // Remove associated meta too
        delete_user_meta($user_id, $this->image_meta);
    }

    public function get_instructor_signature($user_id) {
        // Get personal signature image from user meta
        $id = get_user_meta($user_id, $this->image_meta, true);
        $valid = is_numeric($id);

        return [
            'id' => $valid ? $id : null,
            'url' => $valid ? wp_get_attachment_url($id) : null
        ];
    }
}
