/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./assets/react/admin.js ***!
  \*******************************/
jQuery(document).ready(function ($) {
  'use strict';

  $(document).on('click', '.install-tutor-button', function (e) {
    e.preventDefault();
    var $btn = $(this);
    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: {
        install_plugin: 'tutor',
        action: 'install_tutor_plugin'
      },
      beforeSend: function beforeSend() {
        $btn.addClass('updating-message');
      },
      success: function success(data) {
        $('.install-tutor-button').remove();
        $('#tutor_install_msg').html(data);
      },
      complete: function complete() {
        $btn.removeClass('updating-message');
      }
    });
  });
  /**
   * Import Sample Grade Data
   *
   * @since v.1.4.2
   */

  $(document).on('click', '#import-gradebook-sample-data', function (e) {
    e.preventDefault();
    var $btn = $(this);
    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: {
        action: 'import_gradebook_sample_data'
      },
      beforeSend: function beforeSend() {
        $btn.addClass('updating-icon');
      },
      success: function success(data) {
        if (data.success) {
          location.reload();
        }
      },
      complete: function complete() {
        $btn.removeClass('updating-icon');
      }
    });
  });
  /**
   * Hide cron frequency on wp cron disabling
   * @since v.1.8.7
   */

  $('[name="tutor_option[tutor_email_disable_wpcron]"]').change(function () {
    $('[name="tutor_option[tutor_email_cron_frequency]"]').closest('.tutor-option-field-row')[!$(this).prop('checked') ? 'show' : 'hide']();
  }).trigger('change');
  /**
  * Synchronize zoom meeting
  * 
  * @since 1.9.8
  */

  tutor_zoom_sync();

  function tutor_zoom_sync() {
    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    if (_tutor_pro_object.is_zoom_sync) {} else {
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          timezone: timezone,
          action: 'tutor_zoom_sync'
        },
        success: function success() {}
      });
    }
  }
});
/******/ })()
;
//# sourceMappingURL=admin.js.map