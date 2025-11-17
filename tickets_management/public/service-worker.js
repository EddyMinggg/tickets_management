const CACHE_NAME = 'ticket-management-v1';
const urlsToCache = [
  '/',
  '/purchase',
  '/batch-purchase',
  '/records',
  '/statistics',
  '/offline.html'
];

// 安裝 Service Worker
self.addEventListener('install', event => {
  console.log('Service Worker 安裝中...');
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      console.log('快取資源中...');
      return cache.addAll(urlsToCache).catch(err => {
        console.log('部分快取失敗:', err);
        // 继续执行，不中断安装
      });
    })
  );
  self.skipWaiting();
});

// 激活 Service Worker
self.addEventListener('activate', event => {
  console.log('Service Worker 激活中...');
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log('刪除舊快取:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// 離線優先策略：先檢查快取，再嘗試網路
self.addEventListener('fetch', event => {
  const { request } = event;
  const url = new URL(request.url);

  // 忽略非 GET 請求和外部資源
  if (request.method !== 'GET') {
    return;
  }

  // API 請求和頁面請求不同處理
  if (url.pathname.startsWith('/api/')) {
    // API 請求：網路優先，回退到快取
    event.respondWith(networkFirst(request));
  } else {
    // 頁面和資源：離線優先
    event.respondWith(cacheFirst(request));
  }
});

// 離線優先策略
async function cacheFirst(request) {
  const cache = await caches.open(CACHE_NAME);
  const cached = await cache.match(request);
  
  if (cached) {
    console.log('從快取返回:', request.url);
    return cached;
  }

  try {
    const response = await fetch(request);
    if (response && response.status === 200) {
      const clone = response.clone();
      cache.put(request, clone);
    }
    return response;
  } catch (err) {
    console.log('獲取失敗，返回離線頁面:', request.url);
    return cache.match('/offline.html');
  }
}

// 網路優先策略
async function networkFirst(request) {
  const cache = await caches.open(CACHE_NAME);
  
  try {
    const response = await fetch(request);
    if (response && response.status === 200) {
      const clone = response.clone();
      cache.put(request, clone);
    }
    return response;
  } catch (err) {
    console.log('網路請求失敗，嘗試快取:', request.url);
    const cached = await cache.match(request);
    return cached || cache.match('/offline.html');
  }
}

// 消息通信：用於檢查更新
self.addEventListener('message', event => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

