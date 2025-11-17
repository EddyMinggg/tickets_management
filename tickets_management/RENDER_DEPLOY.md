# 🚀 Render 部署指南 - 完整步驟

## 📋 概述

Render 是一個現代的雲託管平台，完全支持 Laravel。您的應用將部署到他們的全球網路。

**費用：免費層 + $7/月（可選）**

---

## 第 1 步：準備 GitHub

### 1.1 建立 GitHub 帳號（如還沒有）
- 訪問 https://github.com
- 點擊 "Sign up"
- 完成註冊

### 1.2 建立新 Repository

1. 登錄 GitHub
2. 點擊 **"New"** 按鈕
3. Repository 名稱：`ticket-management`
4. 描述：`Concert Ticket Management System`
5. 選擇 **Public**（方便 Render 存取）
6. 點擊 **"Create repository"**

### 1.3 上傳代碼到 GitHub

**在本地電腦上執行：**

```bash
# 進入項目目錄
cd d:\tickets_management\tickets_management

# 初始化 Git
git init

# 添加遠程倉庫（替換 USERNAME 為您的 GitHub 用戶名）
git remote add origin https://github.com/USERNAME/ticket-management.git

# 添加所有文件
git add .

# 第一次提交
git commit -m "Initial commit: Ticket management system"

# 上傳到 GitHub
git branch -M main
git push -u origin main
```

**如果上傳成功**，您會看到：
```
Enumerating objects: XXX, done.
remote: Storing objects: 100% (XXX/XXX), done.
remote: Processing deltas: 100% (XXX/XXX), done.
To https://github.com/USERNAME/ticket-management.git
 * [new branch]      main -> main
```

---

## 第 2 步：在 Render 上部署

### 2.1 訪問 Render

1. 打開 https://render.com
2. 點擊 **"Sign up"** 或 **"Get Started"**
3. 選擇 **"Sign up with GitHub"**
4. 授權 Render 存取您的 GitHub 帳號

### 2.2 建立新 Web 服務

1. 登錄 Render Dashboard
2. 點擊 **"New +"** → **"Web Service"**
3. 選擇您剛上傳的 `ticket-management` Repository
4. 點擊 **"Connect"**

### 2.3 配置部署設置

在 Render 配置頁面填入以下信息：

| 設置項 | 值 |
|--------|-----|
| **Name** | ticket-management |
| **Environment** | PHP |
| **Build Command** | `composer install && npm install` |
| **Start Command** | `php artisan migrate --force && php -S 0.0.0.0:10000 -t public` |
| **Plan** | Free |

### 2.4 設置環境變量

點擊 **"Environment"** 標籤，添加以下變量：

```
APP_KEY=base64:[生成一個隨機字符串]
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=sqlite
```

**如何生成 APP_KEY：**

在本地終端執行：
```bash
php artisan key:generate --show
```

複製輸出的字符串，貼到 Render 的 `APP_KEY`

### 2.5 點擊 Deploy

1. 檢查所有設置無誤
2. 點擊 **"Create Web Service"**
3. Render 開始構建和部署

**部署進度**會顯示在頁面上，通常需要 **3-5 分鐘**。

---

## 第 3 步：驗證部署

### 3.1 檢查部署狀態

在 Render Dashboard：
- 如果看到 **綠色勾** ✅，表示部署成功
- 如果看到 **紅色 X** ❌，檢查構建日誌

### 3.2 存取您的應用

部署完成後，您會看到一個 URL，類似：
```
https://ticket-management-xxxx.onrender.com
```

**點擊該 URL，在瀏覽器中打開應用！**

---

## 第 4 步：自動更新（可選）

每次您推送代碼到 GitHub，Render 會自動重新部署：

```bash
# 編輯文件後

git add .
git commit -m "Fix: Update ticket calculation"
git push origin main

# Render 自動部署新版本！
```

---

## ⚠️ 重要注意事項

### 數據存儲
- 使用 **SQLite 數據庫**（存儲在本地）
- 每次重新部署時，數據可能會丟失
- **解決方案**：使用付費的 PostgreSQL 附加服務（$7-15/月）

### 免費層限制
- 每月 750 小時運行時間（足夠 24/7 運行）
- 15 分鐘無流量後自動休眠（重新訪問時喚醒）
- 無法使用自定義域名

### 升級到付費
如果想保留數據和更好的性能：
- 升級到 **Starter** 方案：$7/月
- 添加 **PostgreSQL 數據庫**：$7-15/月

---

## 🆘 故障排除

### 部署失敗："composer: not found"
- 確保 `composer.json` 在項目根目錄
- 檢查 Build Command 是否正確

### 部署成功但頁面 404
- 檢查 Start Command 是否正確
- 查看 Render 的構建日誌

### 數據在部署後丟失
- 這是 SQLite 的預期行為
- 升級到 PostgreSQL 以持久存儲

### 應用運行緩慢
- 這是免費層的特性（15 分鐘後進入休眠）
- 升級到付費方案解決

---

## 📊 成本比較

| 方案 | 費用 | 特點 |
|------|------|------|
| **Render 免費** | $0 | 免費，但 15 分鐘後休眠，無自定義域名 |
| **Render Starter** | $7/月 | 常駐運行，自定義域名 |
| **+ PostgreSQL** | +$7/月 | 永久數據存儲 |
| **總計（建議）** | $14/月 | 完整的生產方案 |

---

## 🎯 下一步

1. ✅ 上傳代碼到 GitHub
2. ✅ 在 Render 連接並部署
3. ✅ 獲得公開 URL
4. ✅ 分享給朋友使用
5. ✅ （可選）升級到付費方案

---

## 💡 提示

### 部署後立即測試
```
https://your-app.onrender.com
https://your-app.onrender.com/purchase
https://your-app.onrender.com/statistics
```

### 安裝到手機主屏
- iOS：Safari → 分享 → 添加到主屏
- Android：Chrome → 菜單 → 安裝應用

### 自定義域名（需要付費）
如果升級到 Starter 方案，可以：
1. 購買域名（如 GoDaddy、Namecheap）
2. 在 Render 中添加自定義域名
3. 設置 DNS 記錄

---

**部署完成後，您會得到一個類似這樣的 URL：**
```
🌐 https://ticket-management-abcd1234.onrender.com
```

**準備好了嗎？開始上傳代碼吧！** 🚀
