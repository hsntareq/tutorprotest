/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************************************!*\
  !*** ./addons/quiz-import-export/assets/react/quiz-import-export.js ***!
  \**********************************************************************/
jQuery(document).ready(function ($) {
  'use strict';
  /**
   * Quiz CSV export action
   *
   * @since 
   */

  $(document).on('click', '.btn-csv-download', function (event) {
    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        quiz_id: $(this).data('id'),
        'action': 'quiz_export_data'
      },
      beforeSend: function beforeSend() {// $that.addClass('updating-icon');
      },
      success: function success(arr) {
        if (arr.success) {
          var csvContent = "data:text/csv;charset=utf-8,";
          arr.data.output_quiz_data.forEach(function (rowArray) {
            var row = rowArray.join(",");
            csvContent += row + "\r\n";
          });
          var encodedUri = encodeURI(csvContent);
          var link = document.createElement("a");
          link.setAttribute("href", encodedUri);
          link.setAttribute("download", "tutor-quiz-" + arr.data.title + ".csv");
          document.body.appendChild(link);
          link.click();
        }
      },
      complete: function complete() {// $that.removeClass('updating-icon');
      }
    });
  });
  /**
   * Quiz CSV import action
   *
   * @since 
   */

  $(document).on('change', '.tutor-add-quiz-button-wrap input[name="csv_file"]', function (e) {
    var _file = $(this).parent().find("input[name='csv_file']").prop('files');

    var that = $(this);

    if (_file[0]) {
      if (_file[0].size > 0) {
        var nonce = tutor_get_nonce_data(true);
        var formData = new FormData();
        formData.append('action', 'quiz_import_data');
        formData.append('csv_file', _file[0]);
        formData.append('topic_id', $(this).parent().find("input[name='csv_file']").data('topic'));
        formData.append(nonce.key, nonce.value);
        $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function success(data) {
            if (data.success) {
              that.val('');
              that.closest('.tutor-topics-body').find('.tutor-lessons').append(data.data.output_quiz_row);
            }
          }
        });
      } else {
        alert('File is Empty.');
      }
    } else {
      alert('No File Selected.');
    }
  });
  $(document).on('click', '.tutor-import-quiz-button button', function (e) {
    e.preventDefault();
    $(this).parent().find('.tutor-csv-file').click();
  });
});
/******/ })()
;
//# sourceMappingURL=quiz-import-export.js.map