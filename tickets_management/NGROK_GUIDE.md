# 🚀 Ngrok 快速部署指南 - 5 分鐘上線

## 📋 什麼是 Ngrok？

Ngrok 是一個安全隧道工具，可以將您的本地應用（localhost:8000）暴露到公開網際網路上，讓任何人都能訪問。

**優點：**
- ✅ 完全免費
- ✅ 5 分鐘設置完成
- ✅ 無需雲伺服器
- ✅ 支援 HTTPS
- ✅ 本地運行，完全控制

---

## 第 1 步：下載 Ngrok

### Windows 用戶

1. **訪問官網**
   - https://ngrok.com/download

2. **下載 Windows 版本**
   - 點擊 "Download for Windows"
   - 下載 `ngrok-v3-stable-windows-amd64.zip`

3. **解壓檔案**
   - 解壓到任意資料夾（例如：`C:\ngrok\`）
   - 無需安裝，直接使用

---

## 第 2 步：啟動 Laravel 應用

在終端執行：

```cmd
cd d:\tickets_management\tickets_management

php artisan serve
```

您會看到：
```
INFO  Server running on [http://127.0.0.1:8000]
```

**保持這個終端運行！** ⚠️

---

## 第 3 步：運行 Ngrok

**打開新的終端（不要關閉 Laravel）**

```cmd
# 進入 Ngrok 目錄
cd C:\ngrok

# 運行 Ngrok
ngrok http 8000
```

---

## 第 4 步：獲得公開 URL

成功後，您會看到：

```
ngrok                                                                   

Session Status                online
Account                       Free (Limit: 40 req/min)
Version                       3.3.0
Region                        United States (us)
Latency                       45ms
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://abc123def456.ngrok-free.app -> http://localhost:8000

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

**複製這個 URL：** `https://abc123def456.ngrok-free.app`

---

## 第 5 步：分享 URL

將 URL 分享給任何人：

```
🌐 https://abc123def456.ngrok-free.app
```

**他們可以：**
- ✅ 在手機瀏覽器訪問
- ✅ 安裝到主屏幕（PWA）
- ✅ 完整使用所有功能
- ✅ 離線模式正常工作

---

## 📱 安裝到手機

### iOS (Safari)
1. 打開 Ngrok URL
2. 點擊分享按鈕 ⬆️
3. 選擇 **"加入主畫面"**
4. 完成！

### Android (Chrome)
1. 打開 Ngrok URL
2. 點擊右上角菜單 ☰
3. 選擇 **"安裝應用"**
4. 完成！

---

## ⚠️ 重要注意事項

### 免費版限制
- ⏱️ **會話限制**：8 小時後斷開（重新運行即可）
- 🔄 **URL 變化**：每次重啟 Ngrok，URL 會改變
- 📊 **流量限制**：每分鐘 40 個請求

### 保持運行
需要**同時運行兩個終端**：
1. **終端 1**：`php artisan serve`（Laravel）
2. **終端 2**：`ngrok http 8000`（Ngrok）

兩個都關閉，應用就無法訪問了。

---

## 🔧 故障排除

### 問題 1：Ngrok 顯示 "ngrok: command not found"
**解決**：確保在 Ngrok 解壓目錄執行，或將 ngrok.exe 路徑加到系統 PATH

### 問題 2：訪問 URL 顯示 404
**解決**：
1. 確認 Laravel 正在運行（終端 1）
2. 確認 Ngrok 顯示 "Session Status: online"
3. 檢查端口是否為 8000

### 問題 3：URL 訪問很慢
**解決**：這是免費版的特性，升級到付費版可改善

### 問題 4：8 小時後斷開
**解決**：重新運行 `ngrok http 8000`，獲取新 URL

---

## 💰 升級到付費版（可選）

### Ngrok Pro - $10/月
- ✅ 固定 URL（不再變化）
- ✅ 無時間限制
- ✅ 自定義域名
- ✅ 更高流量限制

**是否需要？** 對於個人使用，免費版已足夠！

---

## 📊 Ngrok vs 其他方案

| 方案 | 設置時間 | 成本 | 穩定性 | 適合 |
|------|---------|------|--------|------|
| **Ngrok** | 5 分鐘 | 免費 | 中 | 臨時分享 |
| Railway | 20 分鐘 | $5/月 | 高 | 長期使用 |
| AWS | 1 小時+ | $20+/月 | 高 | 企業級 |
| 本地 WiFi | 2 分鐘 | 免費 | 高 | 同網路 |

---

## 🎯 快速命令參考

```cmd
# 啟動 Laravel
cd d:\tickets_management\tickets_management
php artisan serve

# 啟動 Ngrok（新終端）
cd C:\ngrok
ngrok http 8000

# 查看 Ngrok Web UI（瀏覽器）
http://127.0.0.1:4040
```

---

## 💡 使用技巧

### 1. 查看請求日誌
訪問 `http://127.0.0.1:4040` 可以看到所有訪問記錄

### 2. 自定義域名（付費版）
```cmd
ngrok http 8000 --domain=mytickets.ngrok.app
```

### 3. 基本認證（保護應用）
```cmd
ngrok http 8000 --auth="username:password"
```

### 4. 指定地區
```cmd
ngrok http 8000 --region=ap  # 亞太地區
```

---

## ✅ 完成檢查清單

- [ ] 下載並解壓 Ngrok
- [ ] 啟動 Laravel（`php artisan serve`）
- [ ] 運行 Ngrok（`ngrok http 8000`）
- [ ] 複製公開 URL
- [ ] 在手機上測試訪問
- [ ] 安裝到主屏幕（可選）

---

## 🆘 需要幫助？

如果遇到問題：
1. 檢查兩個終端都在運行
2. 確認 Laravel 在 8000 端口
3. 檢查防火牆設置
4. 查看 Ngrok Web UI（http://127.0.0.1:4040）

---

**準備好了嗎？開始下載 Ngrok 吧！** 🚀

完成後您會得到一個類似這樣的 URL：
```
🌐 https://abc123.ngrok-free.app
```

分享給任何人，他們都能立即使用您的應用！
