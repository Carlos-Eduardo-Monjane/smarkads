
'use strict';

self.addEventListener('push', function(event) {
  console.log('[Service Worker] Push Received.');
  console.log(`[Service Worker] Push had this data: "${event.data.text()}"`);
  let data = JSON.parse(event.data.text());

  console.log(data);
  event.waitUntil(self.registration.showNotification(data.title, data.options));
});


self.addEventListener('notificationclick', function(event) {
  console.log(event);
  event.notification.close();
  event.waitUntil(
    clients.openWindow(event.notification.data.url)
  );
});
