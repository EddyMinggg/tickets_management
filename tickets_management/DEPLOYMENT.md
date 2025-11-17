# 🌐 應用部署指南 - 如何獲得訪問網址

## 方案對比

| 方案 | 成本 | 難度 | 優點 | 適合 |
|------|------|------|------|------|
| **本地網路** | 免費 | 簡單 | 局域網內快速分享 | 同一 WiFi 網路 |
| **Ngrok 隧道** | 免費 | 簡單 | 快速公開網址 | 臨時測試 |
| **Cloudflare Pages** | 免費 | 簡單 | 穩定免費託管 | 長期使用 |
| **Vercel/Netlify** | 免費 | 中等 | 自動部署 | 專業使用 |
| **自己的伺服器** | 有成本 | 較難 | 完全控制 | 企業應用 |

## 🏠 方案 1：本地網路共享（最簡單）

### 步驟

1. **查看您的電腦 IP 位址**

   Windows 命令行：
   ```cmd
   ipconfig
   ```
   
   找到 `IPv4 Address`，例如：`192.168.1.100`

2. **手機連接同一 WiFi**

3. **在手機瀏覽器中訪問**
   ```
   http://192.168.1.100:8000
   ```

### ✅ 優點
- 完全免費
- 不需要任何配置
- 速度最快
- 只需 WiFi 連接

### ❌ 缺點
- 只在同一網路內
- 電腦關閉後無法訪問
- 無法遠程訪問

---

## 🔗 方案 2：Ngrok 隧道（推薦快速分享）

### 步驟

1. **下載 Ngrok**
   - 訪問 https://ngrok.com/download
   - 下載適合您系統的版本

2. **啟動應用**
   
   確保 Laravel 伺服器運行在 8000 端口，然後打開新終端：
   ```cmd
   cd 到ngrok下載目錄
   ngrok http 8000
   ```

3. **獲得公開網址**
   
   您會看到類似：
   ```
   Forwarding  http://abc123def456.ngrok.io -> http://localhost:8000
   ```

4. **分享網址**
   ```
   http://abc123def456.ngrok.io
   ```

### ✅ 優點
- 立即得到公開網址
- 可遠程訪問
- 完全免費
- 設置快速

### ❌ 缺點
- 每次重啟網址會改變
- 免費版有連接限制
- 需要終端持續運行

### 使用 Ngrok

```bash
# 1. 下載後解壓
# 2. 在終端運行
ngrok http 8000

# 3. 複製生成的網址
# 例如: https://abc123.ngrok.io
```

---

## 🚀 方案 3：免費雲託管（推薦長期）

### A. Cloudflare Pages（最簡單）

1. **上傳到 GitHub**
   - 建立 GitHub 帳號
   - 建立新 Repository
   - 上傳您的專案

2. **連接到 Cloudflare**
   - 訪問 https://pages.cloudflare.com
   - 連接 GitHub
   - 授權 Cloudflare
   - 選擇您的 Repository

3. **自動部署**
   - 輸入 Build 命令：`composer install && npm install`
   - 部署完成

4. **獲得網址**
   ```
   https://yourapp.pages.dev
   ```

### B. Heroku（需要信用卡）

1. 訪問 https://www.heroku.com
2. 按照指示部署
3. 獲得免費 `.herokuapp.com` 網址

---

## 🛠️ 方案 4：Docker 容器部署

### 使用 Docker

1. **安裝 Docker**
   - 下載 Docker Desktop

2. **建立 Dockerfile**
   ```dockerfile
   FROM php:8.1-apache
   
   WORKDIR /var/www/html
   COPY . .
   
   RUN docker-php-ext-install pdo pdo_mysql
   RUN apt-get update && apt-get install -y composer
   RUN composer install
   
   EXPOSE 8000
   CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
   ```

3. **執行**
   ```bash
   docker build -t ticket-app .
   docker run -p 8000:8000 ticket-app
   ```

---

## 📋 比較表

| 功能 | 本地網路 | Ngrok | Cloudflare | Heroku | Docker |
|------|---------|-------|-----------|--------|--------|
| 成本 | 免費 | 免費 | 免費 | 免費* | 免費 |
| 設置難度 | 簡單 | 簡單 | 中等 | 中等 | 較難 |
| 穩定性 | 高 | 中 | 高 | 高 | 高 |
| 公開訪問 | ❌ | ✅ | ✅ | ✅ | ✅ |
| 持續運行 | ❌ | ❌ | ✅ | ✅ | ✅ |
| 適合離線 PWA | ✅ | ✅ | ✅ | ✅ | ✅ |

*Heroku 免費層已停用，需付費

---

## 🎯 快速建議

### 如果您想...

**立即分享給朋友**
→ 使用 Ngrok（5 分鐘快速設置）

**長期免費託管**
→ 使用 Cloudflare Pages + GitHub

**本地局域網使用**
→ 直接用 `192.168.x.x:8000`（最簡單）

**企業/生產環境**
→ 自己的伺服器或 VPS

---

## 🔐 安全提示

### 部署到公開網際網路前

- ✅ 隱藏敏感信息
- ✅ 使用 HTTPS
- ✅ 設置強密碼（如需登錄）
- ✅ 定期備份
- ✅ 監控訪問日誌

### 對於此應用

- ✅ 無登錄系統，數據只在用戶設備上
- ✅ 所有交易記錄本地存儲
- ✅ 無需擔心隱私泄露
- ✅ 完全安全部署

---

## 📱 安裝到手機

獲得網址後：

### iOS
1. Safari 打開網址
2. 分享 ⬆️ → 添加到主螢幕
3. 完成！

### Android
1. Chrome 打開網址
2. 菜單 ☰ → 安裝應用
3. 完成！

---

## 💬 我該選哪個？

### 新手用戶
建議：**本地網路 + Ngrok**
- 步驟：1. 連接 WiFi
- 步驟：2. 執行 Ngrok（一行命令）
- 步驟：3. 分享網址

### 想長期使用
建議：**Cloudflare Pages**
- 設置一次，永久免費
- 自動部署
- CDN 加速

### 高級用戶
建議：**自己的 VPS**
- 完全控制
- 最佳性能
- 最大靈活性

---

**準備好了嗎？** 選擇適合您的方案開始吧！
