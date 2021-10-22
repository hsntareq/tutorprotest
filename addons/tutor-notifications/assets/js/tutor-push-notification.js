/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************************************!*\
  !*** ./addons/tutor-notifications/assets/react/tutor-push-notification.js ***!
  \****************************************************************************/
var cachedStorage;

function getStorage() {
  if (!cachedStorage) {
    cachedStorage = createStore('meta_data', 'client');
  }

  return cachedStorage;
}

function getReqPromise(request) {
  return new Promise(function (resolve, reject) {
    request.oncomplete = request.onsuccess = function () {
      return resolve(request.result);
    };

    request.onabort = request.onerror = function () {
      return reject(request.error);
    };
  });
}

function createStore(dbName, storeName) {
  var request = indexedDB.open(dbName);

  request.onupgradeneeded = function () {
    return request.result.createObjectStore(storeName);
  };

  var dbp = getReqPromise(request);
  return function (txMode, callback) {
    return dbp.then(function (db) {
      return callback(db.transaction(storeName, txMode).objectStore(storeName));
    });
  };
}

function getData(key) {
  var customStore = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : getStorage();
  return customStore('readonly', function (store) {
    return getReqPromise(store.get(key));
  });
}

function setData(key, value) {
  var customStore = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : getStorage();
  return customStore('readwrite', function (store) {
    store.put(value, key);
    return getReqPromise(store.transaction);
  });
}

self.addEventListener('push', function (event) {
  if (!self.registration) {
    console.warn('Notification not Registered.');
    return;
  }

  var payload = event.data.json();
  getData('client_id').then(function (client_id) {
    getData('browser_key').then(function (browser_key) {
      var invalid_client = !payload.client_id || !client_id || payload.client_id != client_id;
      var invalid_browser = !payload.browser_key || !browser_key || payload.browser_key != browser_key;

      if (invalid_browser || invalid_client) {
        return;
      }

      self.registration.showNotification(payload.title, payload);
    });
  });
});
self.addEventListener('notificationclick', function (e) {
  if (e.notification.data.url) {
    // Open the specified URL on notification click
    clients.openWindow(e.notification.data.url);
  }

  e.notification.close();
});
self.addEventListener('message', function (event) {
  var data = JSON.parse(event.data);
  setData('client_id', data.client_id).then(function () {})["catch"](function (err) {
    return console.warn('Client ID saving failed!', err);
  });
  setData('browser_key', data.browser_key).then(function () {})["catch"](function (err) {
    return console.warn('Browser ID saving failed!', err);
  });
});
/******/ })()
;
//# sourceMappingURL=tutor-push-notification.js.map