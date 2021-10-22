/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./addons/tutor-zoom/assets/react/common.js ***!
  \**************************************************/
(function ($) {
  'use strict';

  $(document).ready(function () {
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx; // init datepicker for search meetings

    $(".tutor_zoom_datepicker").datepicker({
      dateFormat: _tutorobject.wp_date_format
    });
    $(document).on('click', '.tutor-zoom-meeting-modal-open-btn', function (e) {
      e.preventDefault();
      var $that = $(this);
      var modal = $('.tutor-modal.tutor-zoom-meeting-modal-wrap');
      var meeting_id = $that.attr('data-meeting-id');
      var topic_id = $that.attr('data-topic-id');
      var click_form = $that.attr('data-click-form');
      var course_id = $('#post_ID').val();

      if (typeof course_id == 'undefined') {
        course_id = $that.attr('data-course-id');
      }

      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
          meeting_id: meeting_id,
          topic_id: topic_id,
          course_id: course_id,
          click_form: click_form,
          action: 'tutor_zoom_meeting_modal_content'
        },
        beforeSend: function beforeSend() {
          $that.addClass('tutor-updating-message');
        },
        success: function success(data) {
          modal.find('.modal-container').html(data.data.output);
          modal.attr('data-topic-id', topic_id).addClass('tutor-is-active');
        },
        complete: function complete() {
          $that.removeClass('tutor-updating-message');
          $('.tutor_zoom_timepicker').timepicker({
            timeFormat: 'hh:mm TT'
          });
          $(".tutor_zoom_datepicker").datepicker({
            dateFormat: _tutorobject.wp_date_format,
            minDate: 0
          });
        }
      });
    });
    $(document).on('click', '.update_zoom_meeting_modal_btn', function (e) {
      e.preventDefault();
      var $btn = $(this);
      var modal = $btn.closest('.tutor-modal');
      var data = modal.find(':input').serializeObject();
      data.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
      console.log(data);

      for (var k in data) {
        if (!data[k]) {
          alert(__('Please fill all the fields', 'tutor-pro'));
          console.log(k);
          return;
        }
      }

      $.ajax({
        url: window._tutorobject.ajaxurl,
        type: 'POST',
        data: data,
        beforeSend: function beforeSend() {
          $btn.addClass('tutor-updating-message');
        },
        success: function success(data) {
          data.success ? tutor_toast(__('Success', 'tutor-pro'), __('Meeting Updated', 'tutor-pro'), 'success') : tutor_toast(__('Update Error', 'tutor-pro'), __('Meeting Update Failed', 'tutor-pro'), 'error');

          if (data.course_contents) {
            $(data.selector).html(data.course_contents);

            if (data.selector == '#tutor-course-content-wrap') {
              enable_sorting_topic_lesson();
            } //Close the modal


            modal.removeClass('tutor-is-active');
          } else {
            location.reload();
          }
        },
        complete: function complete() {
          $btn.removeClass('tutor-updating-message');
        }
      });
    });
    $(document).on('click', '.tutor-zoom-meeting-delete-btn', function (e) {
      e.preventDefault();

      if (!confirm('Are you sure?')) {
        return;
      }

      var $that = $(this);
      var meeting_id = $that.attr('data-meeting-id');
      $.ajax({
        url: window._tutorobject.ajaxurl,
        type: 'POST',
        data: {
          meeting_id: meeting_id,
          action: 'tutor_zoom_delete_meeting'
        },
        beforeSend: function beforeSend() {
          $that.addClass('tutor-updating-message');
        },
        success: function success(data) {
          if (data.success) {
            $that.closest('.tutor-zoom-meeting-item').remove();
          }
        },
        complete: function complete() {
          $that.removeClass('tutor-updating-message');
        }
      });
    });
    /*
    * Readonly field
    */

    $(document).on('keydown', '.readonly', function (e) {
      e.preventDefault();
    });
  });
})(jQuery);
/******/ })()
;
//# sourceMappingURL=common.js.map