/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./assets/react/instructor-rate.js ***!
  \*****************************************/
jQuery(document).ready(function ($) {
  $('#tutor_pro_instructor_amount_type_field').change(function () {
    var type = $(this).val();
    var method = type == 'default' ? 'hide' : 'show';
    $('#tutor_pro_instructor_amount_field')[method]();
  }).trigger('change');
});
/******/ })()
;
//# sourceMappingURL=instructor-rate.js.map