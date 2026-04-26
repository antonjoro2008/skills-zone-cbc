/**
 * Gravity CBC — minimal service worker for PWA installability.
 * Network-first; extend with caching if you need offline assessment shells later.
 */
self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', (event) => {
    event.respondWith(fetch(event.request));
});
