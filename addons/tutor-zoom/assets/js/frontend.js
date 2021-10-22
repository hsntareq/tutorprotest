/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./addons/tutor-zoom/assets/react/frontend.js ***!
  \****************************************************/
(function ($) {
  'use strict';

  $(document).ready(function () {
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    $('.tutor-zoom-meeting-countdown').each(function () {
      var date_time = $(this).data('timer');
      var timezone = $(this).data('timezone');
      var new_date = moment.tz(date_time, timezone);
      $(this).countdown(new_date.toDate(), function (event) {
        $(this).html(event.strftime("<div>\n                        <h3>%D</h3>\n                        <p>".concat(__('Days', 'tutor-pro'), "</p>\n                    </div>\n                    <div>\n                        <h3>%H</h3>\n                        <p>").concat(__('Hours', 'tutor-pro'), "</p>\n                    </div>\n                    <div>\n                        <h3>%M</h3>\n                        <p>").concat(__('Minutes', 'tutor-pro'), "</p>\n                    </div>\n                    <div>\n                        <h3>%S</h3>\n                        <p>").concat(__('Seconds', 'tutor-pro'), "</p>\n                    </div>")));
      });
    });
    $('.tutor-zoom-lesson-countdown').each(function () {
      var date_time = $(this).data('timer');
      var timezone = $(this).data('timezone');
      var new_date = moment.tz(date_time, timezone);
      $(this).countdown(new_date.toDate(), function (event) {
        $(this).html(event.strftime('<span>%D <span>d</span></span> <span>%H <span>h</span></span> <span>%M <span>m</span></span> <span>%S <span>s</span></span>'));
      });
    });
  });
})(jQuery);
/******/ })()
;
//# sourceMappingURL=frontend.js.map