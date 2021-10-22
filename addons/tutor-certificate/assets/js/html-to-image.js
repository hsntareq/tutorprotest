/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************************!*\
  !*** ./addons/tutor-certificate/assets/react/html-to-image.js ***!
  \****************************************************************/
jQuery(document).ready(function ($) {
  var match = window.navigator.userAgent.match(/Firefox\/([0-9]+)\./);
  var is_firefox = match ? parseInt(match[1]) : 0;
  var is_safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
  var is_chrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x,
      _n = _wp$i18n._n,
      _nx = _wp$i18n._nx;
  $('body').append('<svg id="tutor_svg_font_id" width="0" height="0" style="background-color:white;"></svg>');

  var loadFont = function loadFont(course_id, callback) {
    var request = new XMLHttpRequest();
    request.open("get", "?tutor_action=get_fonts&course_id=" + course_id);
    request.responseType = "text";
    request.send();

    request.onloadend = function () {
      //(2)find all font urls.
      var css = request.response;
      var fontURLs = css.match(/https?:\/\/[^ \)]+/g);
      var loaded = 0;
      fontURLs.forEach(function (url) {
        //(3)get each font binary.
        var request = new XMLHttpRequest();
        request.open("get", url);
        request.responseType = "blob";

        request.onloadend = function () {
          //(4)conver font blob to binary string.
          var reader = new FileReader();

          reader.onloadend = function () {
            //(5)replace font url by binary string.
            css = css.replace(new RegExp(url), reader.result);
            loaded++; //check all fonts are replaced.

            if (loaded == fontURLs.length) {
              $('#tutor_svg_font_id').prepend("<style>".concat(css, "</style>"));
              callback();
            }
          };

          reader.readAsDataURL(request.response);
        };

        request.send();
      });
    };
  };

  var getDataUrl = function getDataUrl(img) {
    // Create canvas
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d'); // Set width and height

    canvas.width = img.naturalWidth;
    canvas.height = img.naturalHeight; // Draw the image

    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL('image/png');
  };

  var loadImageDataUrl = function loadImageDataUrl(iframe, callback) {
    var images = iframe.getElementsByTagName('img');
    var index = 0;

    function convert() {
      if (index >= images.length) {
        callback();
        return;
      }

      images[index].onload = convert;
      images[index].src = getDataUrl(images[index]);
      index = index + 1;
    }

    convert();
  }; // HTML to Images related functionalities


  var image = function image(course_id, cert_hash, view_url) {
    var _this = this;

    // Open the data url in new window
    this.view = function (url) {
      window.location.assign(view_url);
    }; // Convert data url to octet stream
    // and Show image download dialogue


    this.download = function (url, width, height) {
      var doc = new window.jsPDF(width > height ? 'l' : 'p', 'px', [width, height]);
      doc.addImage(url, 'jpeg', 0, 0, width - .249 * width, height - .249 * height);
      doc.save('certificate-' + new Date().getTime() + '.pdf');
    };

    this.reload = function () {
      window.location.reload();
    };

    this.dataURItoBlob = function (dataURI, mimeString) {
      // convert base64 to raw binary data held in a string
      var byteString = atob(dataURI.split(',')[1]); // write the bytes of the string to an ArrayBuffer

      var ab = new ArrayBuffer(byteString.length);
      var ia = new Uint8Array(ab);

      for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
      }

      return new Blob([ab], {
        type: mimeString
      });
    };

    this.store_certificate = function (data_url, callback) {
      var nonce = tutor_get_nonce_data(true);
      var form_data = new FormData();
      form_data.append('action', 'tutor_store_certificate_image');
      form_data.append('cert_hash', cert_hash);
      form_data.append('certificate_image', _this.dataURItoBlob(data_url, 'image/jpeg'), 'certificate.jpg');
      form_data.append(nonce.key, nonce.value);
      $.ajax({
        url: window._tutorobject.ajaxurl,
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function success(response) {
          var message = (response.data || {}).message;
          callback(response && response.success, message);
        },
        error: function error() {
          callback(false);
        }
      });
    }; // Call various method like image converter and after action


    this.dispatch_conversion_methods = function (action, iframe_document, callback) {
      var body = iframe_document.getElementsByTagName('body')[0];
      var water_mark = iframe_document.getElementById('watermark');
      var width = water_mark.offsetWidth;
      var height = water_mark.offsetHeight; // Now set this dimension body

      body.style.display = 'inline-block';
      body.style.overflow = 'hidden';
      body.style.width = width + 'px';
      body.style.height = height + 'px';
      body.style.padding = '0px';
      body.style.margin = '0px'; // Now capture the iframe using library

      var container = iframe_document.getElementsByTagName('body')[0];
      var configs = {
        scale: 3,
        letterRendering: true,
        logging: true,
        foreignObjectRendering: is_chrome,
        allowTaint: true,
        useCORS: true,
        x: 0,
        y: 0,
        width: width,
        height: height,
        windowWidth: width,
        windowHeight: height
      };
      loadImageDataUrl(iframe_document, function () {
        html2canvas(container, configs).then(function (canvas) {
          var data_url = canvas.toDataURL('image/jpeg', 1.0); // Store the blob on server

          _this.store_certificate(data_url, function (success, message) {
            // Show error if fails
            !success ? alert(message || __('Something Went Wrong', 'tutor-pro')) : 0; // Execute other actions

            success && typeof _this[action] == 'function' ? _this[action](data_url, canvas.width, canvas.height) : 0; // Execute callback if callable

            typeof callback == 'function' ? callback(success) : 0;
          });
        });
      });
    };

    this.load_certificate_builder = function (certificate_builder_url) {
      var iframe = document.createElement('iframe');
      iframe.width = '1920';
      iframe.height = '1080';
      iframe.style.position = 'absolute';
      iframe.style.left = '-999999px';
      iframe.src = certificate_builder_url;
      document.getElementsByTagName('body')[0].appendChild(iframe);
    }; // Fetch certificate html from server
    // and initialize converters


    this.init_render_certificate = function (action, callback) {
      var request_data = {
        action: 'tutor_generate_course_certificate',
        course_id: course_id,
        certificate_hash: cert_hash || '',
        format: action == 'download' ? 'pdf' : 'jpg'
      }; // Get the HTML from server

      $.ajax({
        url: window._tutorobject.ajaxurl,
        type: 'POST',
        data: request_data,
        success: function success(response) {
          // Open certificate builder if made by builder
          var certificate_builder_url = response.data.certificate_builder_url;

          if (certificate_builder_url) {
            window.tutor_certificate_after_build = function () {
              return callback(true);
            };

            _this.load_certificate_builder(certificate_builder_url);

            return;
          } // Backward compatibile certificate rendering


          var html = response.success ? response.data.html : ''; // We need to put the html into iframe to make the certificate styles isolated from parent document
          // Otherwise style might be overridden/influenced

          var iframe = document.createElement('iframe');

          var write_content = function write_content(iframe_document) {
            iframe_document.write(html);
            iframe_document.write($('<div></div>').append($('#tutor_svg_font_id').clone()).html());

            if (is_firefox) {
              // Increase word spacing, other wise firefox compresses texts.
              var style = window.document.createElement('style');
              style.innerHTML = '*{word-spacing:3px !important; letter-spacing:2px !important;}';
              iframe_document.getElementsByTagName('head')[0].appendChild(style);
            }
          };

          if (is_firefox || is_safari) {
            iframe.addEventListener('load', function () {
              var iframe_document = iframe.contentWindow || iframe.contentDocument.document || iframe.contentDocument;
              iframe_document = iframe_document.document;
              write_content(iframe_document); // Load font and then call dispatcher

              loadFont(course_id, function () {
                return _this.dispatch_conversion_methods(action, iframe_document, callback);
              });
            });
          } else {
            loadFont(course_id, function () {
              var iframe_document = iframe.contentWindow || iframe.contentDocument.document || iframe.contentDocument;
              iframe_document = iframe_document.document; // Render the html in iframe

              iframe_document.open();
              write_content(iframe_document);
              iframe_document.close();

              iframe.onload = function () {
                return _this.dispatch_conversion_methods(action, iframe_document, callback);
              };
            });
          }

          iframe.style.position = 'absolute';
          iframe.style.left = '-999999px';
          document.getElementsByTagName('body')[0].appendChild(iframe);
        }
      });
    };
  }; // Instantiate image processor for this scope


  var downloader_btn = $('#tutor-download-certificate-pdf');
  var downloader_btn_from_preview = $('#tutor-pro-certificate-download-pdf');
  var downloader = downloader_btn.length > 0 ? downloader_btn : downloader_btn_from_preview; // Configure working state

  var loading_ = $('<img class="tutor_progress_spinner" style="display:inline;margin-left:5px" src="' + window._tutorobject.loading_icon_url + '"/>');
  var viewer_button = $('#tutor-view-certificate-image');
  var course_id = downloader.data('course_id');
  var cert_hash = downloader.data('cert_hash');
  var view_url = viewer_button.data('href');
  var image_processor = new image(course_id, cert_hash, view_url); // register event listener for course page

  downloader_btn.add(viewer_button).add(downloader_btn_from_preview).click(function (event) {
    var _this2 = this;

    // Prevent default action
    event.preventDefault();

    if ($(this).hasClass('tutor-cert-view-page')) {
      $(this).find('.tutor_progress_spinner').length == 0 ? $(this).append(loading_) : 0;
      var action = $(this).attr('id') == 'tutor-view-certificate-image' ? 'view' : 'download';
      image_processor.init_render_certificate(action, function () {
        $(_this2).find('.tutor_progress_spinner').remove();
      });
      return;
    } //show tutorDotloader @since 1.9.7


    var button = document.getElementById("tutor-download-certificate-pdf");
    button.classList.add('active');
    var buttonHtml = button.innerHTML;
    button.innerHTML = window.tutorDotLoader(); // Invoke the render method according to action type 

    var action = $(this).attr('id') == 'tutor-view-certificate-image' ? 'view' : 'download';
    image_processor.init_render_certificate(action, function () {
      button.innerHTML = buttonHtml;
      button.classList.remove('active');
    });
  }); // Download image directly without further processing (in individual certificate page)

  var image_downloader = $('#tutor-pro-certificate-download-image');
  image_downloader.click(function () {
    var downloader = $('#tutor-pro-certificate-preview');
    var a = document.createElement('A');
    a.href = downloader.attr('src');
    a.download = 'certificate-' + new Date().getTime() + '.jpg';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }); // Regenerate certificate image (in individual page)

  if (image_downloader.length > 0 && $('#tutor-pro-certificate-preview').data('is_generated') == 'no') {
    image_processor.init_render_certificate('', function () {
      window.location.reload();
    });
  }
});
/******/ })()
;
//# sourceMappingURL=html-to-image.js.map