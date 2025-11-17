<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="門票管理">
    <meta name="theme-color" content="#1a73e8">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a73e8' width='192' height='192'/><text x='96' y='120' font-size='90' font-weight='bold' fill='white' text-anchor='middle' font-family='Arial'>🎵</text></svg>">
    <title>@yield('title', '演唱會門票管理系統')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #1a73e8;
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        header h1 {
            text-align: center;
            font-size: 28px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        main {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #1a73e8;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1557b0;
        }

        .btn-success {
            background-color: #34a853;
            color: white;
        }

        .btn-success:hover {
            background-color: #2d8e47;
        }

        .btn-warning {
            background-color: #fbbc04;
            color: #333;
        }

        .btn-warning:hover {
            background-color: #f9ab00;
        }

        .btn-danger {
            background-color: #ea4335;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c5221f;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            min-width: 1000px; /* 強制最小寬度，使其超出容器寬度 */
        }

        /* 表格滾動容器 */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 20px;
            border-radius: 8px;
            background: white;
        }

        thead {
            background-color: #f9f9f9;
            border-bottom: 2px solid #ddd;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons a,
        .action-buttons button {
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-muted {
            color: #999;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 10px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #1a73e8;
        }

        .stat-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        /* Mobile First Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 20px;
            }

            .container {
                padding: 12px;
            }

            main {
                padding: 15px;
                margin-top: 10px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .btn {
                padding: 12px 16px;
                font-size: 14px;
                width: 100%;
                text-align: center;
            }

            .btn-group {
                flex-direction: column;
                gap: 8px;
            }

            .section-title {
                font-size: 18px;
                margin-bottom: 15px;
            }

            /* Responsive Table */
            table {
                font-size: 12px;
                min-width: 100%;
            }

            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 8px;
                margin-top: 20px;
                background: white;
            }

            th, td {
                padding: 10px 8px;
                min-width: 90px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            th {
                background-color: #1a73e8;
                color: white;
            }

            tbody tr:hover {
                background-color: transparent;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
                width: 100%;
            }

            .action-buttons a,
            .action-buttons button {
                padding: 8px 10px;
                font-size: 12px;
                width: 100%;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 15px;
                border-left-width: 3px;
            }

            .stat-value {
                font-size: 20px;
            }

            .form-group input,
            .form-group textarea {
                padding: 12px;
                font-size: 16px; /* Prevent iOS zoom */
            }

            /* Modal responsive */
            .modal-content {
                min-width: 90vw;
                max-width: 90vw;
                margin: 20px;
                padding: 20px;
            }

            .modal-buttons {
                display: flex;
                flex-direction: column;
                gap: 10px;
                margin-top: 15px;
            }

            .modal-buttons button {
                width: 100%;
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 18px;
            }

            .container {
                padding: 8px;
            }

            main {
                padding: 12px;
            }

            .btn {
                padding: 10px 12px;
                font-size: 13px;
            }

            th, td {
                padding: 8px 6px;
                min-width: 70px;
                font-size: 11px;
            }

            .stat-label {
                font-size: 11px;
            }

            .stat-value {
                font-size: 18px;
            }

            .modal-content {
                min-width: 95vw;
                max-width: 95vw;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            min-width: 300px;
            max-width: 500px;
            animation: slideIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .modal-body {
            font-size: 15px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-footer .btn {
            padding: 10px 20px;
            font-size: 14px;
        }
    </style>
    @yield('extra_css')
</head>
<body>
    <header>
        <h1>🎵 演唱會門票管理系統</h1>
    </header>

    <div class="container">
        @if($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Confirm Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="confirmModalTitle">確認操作</div>
            <div class="modal-body" id="confirmModalMessage">您確定要繼續嗎？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeConfirmModal()">取消</button>
                <button type="button" class="btn btn-danger" id="confirmModalOkBtn" onclick="confirmModalOk()">確認</button>
            </div>
        </div>
    </div>

    <!-- Delete Transaction Modal -->
    <div id="deleteTransactionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">⚠️ 刪除交易記錄</div>
            <div class="modal-body" id="deleteTransactionMessage">
                確定要刪除此交易記錄嗎？<br>
                <strong>門票數量將被自動調整。</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeDeleteTransactionModal()">取消</button>
                <button type="button" class="btn btn-danger" id="deleteTransactionConfirmBtn" onclick="submitDeleteTransaction()">刪除</button>
            </div>
        </div>
    </div>

    <!-- Delete Ticket Modal -->
    <div id="deleteTicketModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">⚠️ 刪除門票</div>
            <div class="modal-body">
                確定要刪除此門票嗎？<br>
                <strong>相關的所有交易記錄也將被刪除。</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeDeleteTicketModal()">取消</button>
                <button type="button" class="btn btn-danger" id="deleteTicketConfirmBtn" onclick="submitDeleteTicket()">刪除</button>
            </div>
        </div>
    </div>

    <script>
        let confirmModalCallback = null;
        let deleteTransactionForm = null;
        let deleteTicketForm = null;

        // Confirm Modal Functions
        function openConfirmModal(title, message, okCallback) {
            document.getElementById('confirmModalTitle').textContent = title;
            document.getElementById('confirmModalMessage').textContent = message;
            confirmModalCallback = okCallback;
            document.getElementById('confirmModal').classList.add('show');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.remove('show');
            confirmModalCallback = null;
        }

        function confirmModalOk() {
            if (confirmModalCallback) {
                confirmModalCallback();
            }
            closeConfirmModal();
        }

        // Delete Transaction Modal Functions
        function openDeleteTransactionModal(form) {
            deleteTransactionForm = form;
            document.getElementById('deleteTransactionModal').classList.add('show');
        }

        function closeDeleteTransactionModal() {
            document.getElementById('deleteTransactionModal').classList.remove('show');
            deleteTransactionForm = null;
        }

        function submitDeleteTransaction() {
            if (deleteTransactionForm) {
                deleteTransactionForm.submit();
            }
            closeDeleteTransactionModal();
        }

        // Delete Ticket Modal Functions
        function openDeleteTicketModal(form) {
            deleteTicketForm = form;
            document.getElementById('deleteTicketModal').classList.add('show');
        }

        function closeDeleteTicketModal() {
            document.getElementById('deleteTicketModal').classList.remove('show');
            deleteTicketForm = null;
        }

        function submitDeleteTicket() {
            if (deleteTicketForm) {
                deleteTicketForm.submit();
            }
            closeDeleteTicketModal();
        }

        // Close modal when clicking outside the content
        document.getElementById('confirmModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeConfirmModal();
            }
        });

        document.getElementById('deleteTransactionModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteTransactionModal();
            }
        });

        document.getElementById('deleteTicketModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteTicketModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeConfirmModal();
                closeDeleteTransactionModal();
                closeDeleteTicketModal();
            }
        });
    </script>

    <!-- PWA Support -->
    <script>
        // 應用狀態標記
        let isOnline = navigator.onLine;
        let swRegistration = null;

        // 註冊 Service Worker（離線支援核心）
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset("service-worker.js") }}')
                    .then(registration => {
                        swRegistration = registration;
                        console.log('✓ Service Worker 已註冊 - 應用現在支持離線使用');
                        
                        // 檢查更新
                        setInterval(() => {
                            registration.update();
                        }, 60000); // 每分鐘檢查一次

                        // 首次安裝時顯示信息
                        if (registration.installing) {
                            registration.installing.addEventListener('statechange', function() {
                                if (this.state === 'activated') {
                                    showNotification('✓ 應用已更新，現在支持完全離線使用', 'success');
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.log('Service Worker 註冊失敗:', error);
                    });
            });
        }

        // 檢測網路連接狀態
        window.addEventListener('online', () => {
            isOnline = true;
            showNotification('🌐 已連接到網路 - 應用將使用最新數據', 'success');
            console.log('應用已連線');
        });

        window.addEventListener('offline', () => {
            isOnline = false;
            showNotification('📵 已斷開網路連接 - 應用仍可正常使用（離線模式）', 'warning');
            console.log('應用已離線，但可以繼續使用');
        });

        // 初始化時顯示狀態
        document.addEventListener('DOMContentLoaded', () => {
            if (!isOnline) {
                showNotification('📵 您目前處於離線狀態 - 所有功能都可用', 'info');
            }
        });

        // 簡單的通知函數
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background-color: ${type === 'success' ? '#34a853' : type === 'warning' ? '#fbbc04' : '#1a73e8'};
                color: ${type === 'warning' ? '#333' : 'white'};
                border-radius: 5px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease;
                font-size: 14px;
                max-width: 300px;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        // 支援 iOS 主螢幕啟動
        if (window.navigator.standalone === true) {
            console.log('✓ 應用以 PWA 模式運行');
            document.body.classList.add('pwa-standalone');
        } else if (window.navigator.standalone === false) {
            // 用戶通過 Safari 訪問，可以提示添加到主螢幕
            console.log('💡 提示：可以添加到主螢幕以獲得更好的體驗');
        }

        // 禁用不必要的 zoom 在某些事件上
        document.addEventListener('touchmove', function(e) {
            if (e.scale !== 1) {
                e.preventDefault();
            }
        }, { passive: false });
    </script>

    <style>
        @keyframes slideIn {
            from { 
                transform: translateX(400px);
                opacity: 0;
            }
            to { 
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from { 
                transform: translateX(0);
                opacity: 1;
            }
            to { 
                transform: translateX(400px);
                opacity: 0;
            }
        }

        /* 手機優化 */
        @media (max-width: 768px) {
            body {
                padding: 0;
                margin: 0;
                width: 100vw;
                height: 100vh;
                -webkit-user-select: none;
                user-select: none;
                -webkit-touch-callout: none;
            }

            input, button, textarea, select {
                font-size: 16px; /* 防止 iOS 自動縮放 */
            }

            .container {
                padding: 10px;
            }

            main {
                padding: 15px;
                margin-top: 10px;
            }

            table {
                font-size: 12px;
            }

            .btn {
                padding: 12px 16px;
                min-height: 44px; /* iOS 最小觸摸目標 */
                font-size: 16px;
            }

            /* 狀態欄樣式 */
            header {
                padding: 20px 0;
                padding-top: max(20px, env(safe-area-inset-top));
            }

            .container {
                padding-left: max(10px, env(safe-area-inset-left));
                padding-right: max(10px, env(safe-area-inset-right));
                padding-bottom: max(10px, env(safe-area-inset-bottom));
            }
        }
    </style>
</body>
</html>
