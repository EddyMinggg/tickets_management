<!DOCTYPE html>
<html lang="zh-Hant" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="門票管理">
    <meta name="theme-color" content="#667eea" id="theme-color-meta">
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px 0;
            box-shadow: 0 2px 16px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header h1 {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            flex: 1;
        }

        .theme-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.4);
            color: white;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
            transform: scale(1.1);
        }

        .theme-toggle:active {
            transform: scale(0.95);
        }

        .theme-icon {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover .theme-icon {
            animation: spin 0.6s linear;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
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
            margin: 0; /* 移除上邊距，讓容器控制 */
            min-width: 1000px; /* 強制最小寬度，使其超出容器寬度 */
            display: table; /* 確保是表格佈局 */
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
                min-width: 800px; /* 手機上表格最小寬度，確保需要滾動 */
                width: max-content;
                display: table;
                table-layout: auto;
            }

            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 8px;
                margin-top: 20px;
                background: white;
                width: 100%;
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

        /* ========== App-Style Mobile Design ========== */
        
        /* Page Header */
        .page-header {
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a73e8;
            margin-bottom: 8px;
        }
        
        /* Action Grid */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .action-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 12px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            min-height: 100px;
        }
        
        .action-card.primary {
            background: linear-gradient(135deg, #34a853 0%, #2d8e47 100%);
            color: white;
        }
        
        .action-card.secondary {
            background: linear-gradient(135deg, #1a73e8 0%, #1557b0 100%);
            color: white;
        }
        
        .action-card:active {
            transform: scale(0.98);
        }
        
        .action-icon {
            font-size: 32px;
            margin-bottom: 8px;
        }
        
        .action-text {
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }
        
        /* Ticket List */
        .ticket-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .ticket-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .ticket-card:active {
            transform: scale(0.99);
        }
        
        .ticket-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .ticket-date {
            color: white;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .date-icon {
            font-size: 16px;
        }
        
        .ticket-section {
            background: rgba(255,255,255,0.25);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
        }
        
        .ticket-body {
            padding: 16px;
        }
        
        .ticket-info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .info-label {
            font-size: 12px;
            color: #666;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .info-value.sold {
            color: #51cf66;
        }
        
        .ticket-summary {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-top: 12px;
        }
        
        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .summary-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        
        .summary-value {
            font-size: 18px;
            font-weight: 700;
        }
        
        .summary-value.remaining {
            color: #ff6b6b;
        }
        
        .summary-value.total {
            color: #1a73e8;
        }
        
        .ticket-actions {
            display: flex;
            gap: 8px;
            padding: 0 16px 16px 16px;
        }
        
        .ticket-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        
        .ticket-btn.success {
            background: #34a853;
            color: white;
        }
        
        .ticket-btn.success:active {
            background: #2d8e47;
        }
        
        .ticket-btn.danger {
            background: #ea4335;
            color: white;
        }
        
        .ticket-btn.danger:active {
            background: #c5221f;
        }

        .ticket-btn.info {
            background: #3b82f6;
            color: white;
        }

        .ticket-btn.info:active {
            background: #2563eb;
        }
        
        /* Transaction List */
        .transaction-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .transaction-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .transaction-card.purchase {
            border-left: 4px solid #ff6b6b;
        }
        
        .transaction-card.sale {
            border-left: 4px solid #51cf66;
        }
        
        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8f9fa;
        }
        
        .transaction-type {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .transaction-type.purchase {
            color: #ff6b6b;
        }
        
        .transaction-type.sale {
            color: #51cf66;
        }
        
        .type-icon {
            font-size: 16px;
        }
        
        .transaction-time {
            font-size: 12px;
            color: #666;
        }
        
        .transaction-body {
            padding: 16px;
        }
        
        .transaction-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .concert-info {
            flex: 1;
        }
        
        .concert-date {
            font-size: 13px;
            color: #666;
            margin-bottom: 4px;
        }
        
        .concert-section {
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }
        
        .transaction-amount {
            text-align: right;
        }
        
        .amount-value {
            font-size: 20px;
            font-weight: 700;
            color: #1a73e8;
        }
        
        .transaction-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }
        
        .detail-item span {
            color: #666;
        }
        
        .detail-item strong {
            color: #333;
        }
        
        .transaction-footer {
            padding: 0 16px 12px 16px;
        }
        
        .delete-btn {
            width: 100%;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            color: #ea4335;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .delete-btn:active {
            background: #e9ecef;
        }
        
        /* Stats Cards Modern */
        .stats-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .stat-card-modern {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        
        .stat-card-modern.purchase {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        }
        
        .stat-card-modern.sale {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
        }
        
        .stat-card-modern.profit {
            background: linear-gradient(135deg, #4c6ef5 0%, #3b5bdb 100%);
        }
        
        .stat-card-modern.loss {
            background: linear-gradient(135deg, #fa5252 0%, #e03131 100%);
        }
        
        .stat-icon {
            font-size: 40px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-card-modern .stat-label {
            color: rgba(255,255,255,0.9);
            font-size: 13px;
            margin-bottom: 4px;
        }
        
        .stat-card-modern .stat-value {
            color: white;
            font-size: 24px;
            font-weight: 700;
        }
        
        /* Summary Section */
        .summary-section {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .section-subtitle {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 16px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .summary-grid .summary-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 12px;
        }
        
        .summary-grid .summary-icon {
            font-size: 28px;
        }
        
        .summary-grid .summary-content {
            flex: 1;
        }
        
        .summary-grid .summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #1a73e8;
            margin-bottom: 2px;
        }
        
        .summary-grid .summary-label {
            font-size: 12px;
            color: #666;
        }
        
        /* Recent Section */
        .recent-section {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .transaction-list.compact {
            gap: 8px;
        }
        
        .transaction-card-compact {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid transparent;
        }
        
        .transaction-card-compact.purchase {
            border-left-color: #ff6b6b;
        }
        
        .transaction-card-compact.sale {
            border-left-color: #51cf66;
        }
        
        .compact-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }
        
        .compact-type {
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .compact-type.purchase {
            color: #ff6b6b;
        }
        
        .compact-type.sale {
            color: #51cf66;
        }
        
        .compact-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .compact-section {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        
        .compact-time {
            font-size: 11px;
            color: #666;
        }
        
        .compact-right {
            text-align: right;
        }
        
        .compact-quantity {
            font-size: 12px;
            color: #666;
            margin-bottom: 2px;
        }
        
        .compact-amount {
            font-size: 15px;
            font-weight: 700;
            color: #1a73e8;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-icon {
            font-size: 80px;
            margin-bottom: 16px;
            opacity: 0.5;
        }
        
        .empty-text {
            font-size: 16px;
            color: #666;
            margin-bottom: 24px;
        }
        
        /* Pagination */
        .pagination-wrapper {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }
        
        /* Mobile Optimization */
        @media (max-width: 768px) {
            body {
                background-color: #f8f9fa;
            }
            
            .container {
                padding: 0;
            }
            
            main {
                border-radius: 0;
                padding: 16px;
                margin-top: 0;
                box-shadow: none;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .action-grid {
                gap: 10px;
            }
            
            .action-card {
                padding: 18px 10px;
                min-height: 90px;
            }
            
            .action-icon {
                font-size: 28px;
            }
            
            .action-text {
                font-size: 13px;
            }
        }
        
        /* ========== Dark Mode ========== */
        /* Dark Mode Styles */
        [data-theme="dark"] body {
            background-color: #0f0f0f;
            color: #e4e4e7;
        }
        
        [data-theme="dark"] header {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            box-shadow: 0 2px 16px rgba(0,0,0,0.4);
        }

        [data-theme="dark"] .theme-toggle {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        [data-theme="dark"] .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        [data-theme="dark"] main {
            background-color: #1a1a1a;
            box-shadow: 0 2px 16px rgba(0,0,0,0.3);
        }
        
        [data-theme="dark"] .container {
            background-color: transparent;
        }
        
        /* Page Elements */
        [data-theme="dark"] .page-title {
            color: #a78bfa;
        }
        
        /* Action Cards */
        [data-theme="dark"] .action-card.primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        [data-theme="dark"] .action-card.secondary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        /* Ticket Cards */
        [data-theme="dark"] .ticket-card {
            background: #262626;
            box-shadow: 0 4px 16px rgba(0,0,0,0.3);
        }
        
        [data-theme="dark"] .ticket-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }
        
        [data-theme="dark"] .ticket-section {
            background: rgba(255,255,255,0.2);
        }
        
        [data-theme="dark"] .info-label {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .info-value {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .info-value.sold {
            color: #34d399;
        }
        
        [data-theme="dark"] .ticket-summary {
            background: #1f1f1f;
        }
        
        [data-theme="dark"] .summary-label {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .summary-value.remaining {
            color: #fb7185;
        }
        
        [data-theme="dark"] .summary-value.total {
            color: #60a5fa;
        }
        
        /* Transaction Cards */
        [data-theme="dark"] .transaction-card {
            background: #262626;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        
        [data-theme="dark"] .transaction-card.purchase {
            border-left-color: #f87171;
        }
        
        [data-theme="dark"] .transaction-card.sale {
            border-left-color: #34d399;
        }
        
        [data-theme="dark"] .transaction-header {
            background: #1f1f1f;
        }
        
        [data-theme="dark"] .transaction-type.purchase {
            color: #fca5a5;
        }
        
        [data-theme="dark"] .transaction-type.sale {
            color: #6ee7b7;
        }
        
        [data-theme="dark"] .transaction-time {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .concert-date {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .concert-section {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .amount-value {
            color: #60a5fa;
        }
        
        [data-theme="dark"] .transaction-details {
            background: #1f1f1f;
        }
        
        [data-theme="dark"] .detail-item span {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .detail-item strong {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .delete-btn {
            background: #1f1f1f;
            border-color: #3f3f46;
            color: #f87171;
        }
        
        [data-theme="dark"] .delete-btn:active {
            background: #262626;
        }
        
        /* Stats Cards */
        [data-theme="dark"] .stat-card-modern.purchase {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.3);
        }
        
        [data-theme="dark"] .stat-card-modern.sale {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
        }
        
        [data-theme="dark"] .stat-card-modern.profit {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        }
        
        [data-theme="dark"] .stat-card-modern.loss {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.3);
        }
        
        /* Summary Section */
        [data-theme="dark"] .summary-section,
        [data-theme="dark"] .recent-section {
            background: #1a1a1a;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        
        [data-theme="dark"] .section-subtitle {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .summary-grid .summary-item {
            background: #262626;
        }
        
        [data-theme="dark"] .summary-grid .summary-value {
            color: #60a5fa;
        }
        
        [data-theme="dark"] .summary-grid .summary-label {
            color: #a1a1aa;
        }
        
        /* Compact Transaction Cards */
        [data-theme="dark"] .transaction-card-compact {
            background: #262626;
        }
        
        [data-theme="dark"] .transaction-card-compact.purchase {
            border-left-color: #f87171;
        }
        
        [data-theme="dark"] .transaction-card-compact.sale {
            border-left-color: #34d399;
        }
        
        [data-theme="dark"] .compact-type.purchase {
            color: #fca5a5;
        }
        
        [data-theme="dark"] .compact-type.sale {
            color: #6ee7b7;
        }
        
        [data-theme="dark"] .compact-section {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .compact-time {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .compact-quantity {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .compact-amount {
            color: #60a5fa;
        }
        
        /* Buttons */
        [data-theme="dark"] .ticket-btn.success {
            background: #10b981;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }
        
        [data-theme="dark"] .ticket-btn.success:active {
            background: #059669;
        }

        [data-theme="dark"] .ticket-btn.info {
            background: #3b82f6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }
        
        [data-theme="dark"] .ticket-btn.info:active {
            background: #2563eb;
        }
        
        [data-theme="dark"] .ticket-btn.danger {
            background: #dc2626;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }
        
        [data-theme="dark"] .ticket-btn.danger:active {
            background: #b91c1c;
        }
        
        [data-theme="dark"] .btn-primary {
            background-color: #3b82f6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }
        
        [data-theme="dark"] .btn-primary:hover {
            background-color: #2563eb;
        }
        
        [data-theme="dark"] .btn-success {
            background-color: #10b981;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }
        
        [data-theme="dark"] .btn-success:hover {
            background-color: #059669;
        }
        
        [data-theme="dark"] .btn-danger {
            background-color: #dc2626;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }
        
        [data-theme="dark"] .btn-danger:hover {
            background-color: #b91c1c;
        }
        
        /* Forms */
        [data-theme="dark"] .form-group label {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .form-control {
            background-color: #262626;
            border-color: #3f3f46;
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .form-control:focus {
            border-color: #8b5cf6;
            background-color: #2d2d2d;
        }
        
        /* Alerts */
        [data-theme="dark"] .alert-success {
            background-color: #064e3b;
            border-color: #059669;
            color: #d1fae5;
        }
        
        [data-theme="dark"] .alert-error {
            background-color: #7f1d1d;
            border-color: #b91c1c;
            color: #fecaca;
        }
        
        /* Modal */
        [data-theme="dark"] .modal {
            background-color: rgba(0, 0, 0, 0.85);
        }
        
        [data-theme="dark"] .modal-content {
            background-color: #1a1a1a;
            box-shadow: 0 8px 32px rgba(0,0,0,0.6);
        }
        
        [data-theme="dark"] .modal-header {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] .modal-body {
            color: #a1a1aa;
        }
        
        /* Tables (if any remain) */
        [data-theme="dark"] table {
            background-color: #1a1a1a;
        }
        
        [data-theme="dark"] thead {
            background-color: #262626;
            border-bottom-color: #3f3f46;
        }
        
        [data-theme="dark"] th {
            color: #e4e4e7;
        }
        
        [data-theme="dark"] td {
            color: #d4d4d8;
            border-bottom-color: #3f3f46;
        }
        
        [data-theme="dark"] tbody tr:hover {
            background-color: #262626;
        }
        
        /* Empty State */
        [data-theme="dark"] .empty-state {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .empty-text {
            color: #71717a;
        }
        
        /* Stats (old style if exists) */
        [data-theme="dark"] .stats .stat-card {
            background: #262626;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        
        [data-theme="dark"] .stat-label {
            color: #a1a1aa;
        }
        
        [data-theme="dark"] .stat-value {
            color: #e4e4e7;
        }
    </style>
    @yield('extra_css')
</head>
<body>
    <header>
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 20px;">
            <h1 style="margin: 0;">🎵 演唱會門票管理系統</h1>
            <button id="themeToggleBtn" class="theme-toggle" title="切換明亮/深色模式">
                <span class="theme-icon">🌙</span>
            </button>
        </div>
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

        // 主題切換功能
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = themeToggleBtn.querySelector('.theme-icon');
        const htmlEl = document.documentElement;
        const themeColorMeta = document.getElementById('theme-color-meta');
        
        // 初始化主題
        function initTheme() {
            // 檢查是否有保存的主題偏好
            const savedTheme = localStorage.getItem('theme-preference');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // 決定使用的主題
            let usesDarkMode = false;
            if (savedTheme === 'dark') {
                usesDarkMode = true;
            } else if (savedTheme === 'light') {
                usesDarkMode = false;
            } else {
                usesDarkMode = prefersDark;
            }
            
            // 應用主題
            applyTheme(usesDarkMode);
        }
        
        // 應用主題
        function applyTheme(isDarkMode) {
            if (isDarkMode) {
                htmlEl.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme-preference', 'dark');
                themeIcon.textContent = '☀️';
                themeToggleBtn.title = '切換至明亮模式';
                themeColorMeta.setAttribute('content', '#7c3aed');
            } else {
                htmlEl.setAttribute('data-theme', 'light');
                localStorage.setItem('theme-preference', 'light');
                themeIcon.textContent = '🌙';
                themeToggleBtn.title = '切換至深色模式';
                themeColorMeta.setAttribute('content', '#667eea');
            }
        }
        
        // 切換主題
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlEl.getAttribute('data-theme');
            const isDarkMode = currentTheme === 'dark';
            applyTheme(!isDarkMode);
        });
        
        // 監聽系統主題變更
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            const savedTheme = localStorage.getItem('theme-preference');
            // 只有在沒有保存偏好時才跟隨系統
            if (!savedTheme) {
                applyTheme(e.matches);
            }
        });
        
        // 頁面加載時初始化主題
        document.addEventListener('DOMContentLoaded', initTheme);
        initTheme();
    </script>

    <!-- PWA Support -->
    <script>
        // 應用狀態標記
        let isOnline = navigator.onLine;
        let swRegistration = null;

        // 暫時禁用 Service Worker 以便開發調試
        // 註冊 Service Worker（離線支援核心）
        /*
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
        */

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
                width: 100%;
                min-height: 100vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
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
