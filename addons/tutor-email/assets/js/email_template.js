/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./addons/tutor-email/assets/react/admin-dashboard/lib.js":
/*!****************************************************************!*\
  !*** ./addons/tutor-email/assets/react/admin-dashboard/lib.js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "element": () => (/* binding */ element),
/* harmony export */   "elements": () => (/* binding */ elements),
/* harmony export */   "notice_message": () => (/* binding */ notice_message),
/* harmony export */   "json_download": () => (/* binding */ json_download),
/* harmony export */   "elementByName": () => (/* binding */ elementByName),
/* harmony export */   "validateEmail": () => (/* binding */ validateEmail)
/* harmony export */ });
var element = function element(selector) {
  return document.querySelector(selector);
};

var elements = function elements(selector) {
  return document.querySelectorAll(selector);
};

var elementByName = function elementByName(selector) {
  return document.getElementsByName(selector);
};

var notice_message = function notice_message() {
  var message = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  var noticeElement = element(".tutor-notification");
  noticeElement.classList.add("show");

  if (message) {
    noticeElement.querySelector(".tutor-notification-content p").innerText = message;
  }

  setTimeout(function () {
    noticeElement.classList.remove("show");
  }, 4000);
};
/**
 * Function to download json file
 * @param {json} response
 * @param {string} fileName
 */


var json_download = function json_download(response, fileName) {
  var fileToSave = new Blob([response], {
    type: "application/json"
  });
  var el = document.createElement("a");
  el.href = URL.createObjectURL(fileToSave);
  el.download = fileName;
  el.click();
};

var validateEmail = function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
};



/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***********************************************************!*\
  !*** ./addons/tutor-email/assets/react/email_template.js ***!
  \***********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./admin-dashboard/lib */ "./addons/tutor-email/assets/react/admin-dashboard/lib.js");

var email_custom = (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.element)("#email-custom");
var email_testing_email = (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.element)("[name='email-testing-email']");

var email_custom_checked = function email_custom_checked(checkbox, element) {
  checkbox.checked ? element.disabled = false : element.disabled = true;
};

email_custom_checked(email_custom, email_testing_email);

email_custom.onchange = function () {
  email_custom_checked(email_custom, email_testing_email);
};

var loading_spinner = (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.element)(".loading-spinner");
document.addEventListener("readystatechange", function (event) {
  if (event.target.readyState === "complete") {
    if (loading_spinner) {
      loading_spinner.remove();
    }

    if (typeof tinymce != "undefined" && tinymce.activeEditor) {
      tinymce.activeEditor.on("change", function (e) {
        var dataBody = document.querySelector(".email-manage-page [data-source=".concat(e.target.id, "]"));
        dataBody.innerHTML = tinymce.activeEditor.getContent();
        tinymce.triggerSave();
      });
    }
  }
});
var send_a_test_email = (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.element)("#send_a_test_email");
var template_preview = (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.element)(".template-preview");
var testing_email = document.querySelector("[name='email-testing-email']");

if (send_a_test_email) {
  send_a_test_email.onclick = function (e) {
    if ("" !== testing_email.value && true !== (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.validateEmail)(testing_email.value)) {
      console.log("not valid");
      (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.notice_message)("Email is not valid!");
      testing_email.style.border = "1px solid #f00";
      setTimeout(function () {
        testing_email.style.border = "1px solid #bababa";
      }, 1000);
      return false;
    }

    var send_testing_email = testing_email.disabled == true ? "" : testing_email.value;
    e.preventDefault();
    var formData = new FormData();
    formData.append("action", "send_test_email_ajax");
    formData.append("email_to", (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.elementByName)("to")[0].value);
    formData.append("email_key", (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.elementByName)("key")[0].value);
    formData.append("email_template", template_preview.dataset.email_template);
    formData.append("testing_email", send_testing_email);
    formData.append(_tutorobject.nonce_key, _tutorobject._tutor_nonce);
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", _tutorobject.ajaxurl, true);
    xhttp.send(formData);

    xhttp.onreadystatechange = function (e) {
      if (xhttp.readyState === 4) {
        (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.notice_message)((0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.elementByName)("key")[0].value + " email has been sent Successfully!"); // console.log(JSON.parse(xhttp.response));
      }
    };
  };
}

var email_template_save = (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.element)("#email_template_save");
var email_template_form = (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.element)("#email_template_form");

if (email_template_save) {
  email_template_save.onclick = function (e) {
    e.preventDefault();
    var formData = new FormData(email_template_form);
    formData.append("action", "save_email_template");
    formData.append(_tutorobject.nonce_key, _tutorobject._tutor_nonce);
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", _tutorobject.ajaxurl, true);
    xhttp.send(formData);

    xhttp.onreadystatechange = function (e) {
      if (xhttp.readyState === 4) {
        (0,_admin_dashboard_lib__WEBPACK_IMPORTED_MODULE_0__.notice_message)("Email template updated Successfully!");
        console.log(JSON.parse(xhttp.response));
      }
    };
  };
}

var emailManagePageInputs = document.querySelectorAll('.email-manage-page input[type="hidden"], .email-manage-page input[type="text"], .email-manage-page textarea');
emailManagePageInputs.forEach(function (input) {
  var name = input.name,
      value = input.value;
  window.addEventListener("DOMContentLoaded", function () {
    var dataSourceEl = document.querySelector(".email-manage-page [data-source=".concat(name, "]"));

    if (dataSourceEl) {
      if (dataSourceEl.src) {
        dataSourceEl.src = value;
      } else {
        dataSourceEl.innerHTML = value;
      }
    }
  });
  input.addEventListener("input", function (e) {
    var _e$target = e.target,
        name = _e$target.name,
        value = _e$target.value;
    var dataSourceEl = document.querySelector(".email-manage-page [data-source=".concat(name, "]"));

    if (dataSourceEl) {
      if (dataSourceEl.src) {
        dataSourceEl.src = value;
      } else {
        dataSourceEl.innerHTML = value;
      }
    }
  });
});
})();

/******/ })()
;
//# sourceMappingURL=email_template.js.map