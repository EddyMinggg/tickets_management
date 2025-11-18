@extends('layouts.app')

@section('title', '賣出門票')

@section('content')
    <div class="page-header">
        <h2 class="page-title">💰 賣出門票</h2>
    </div>

    <div class="ticket-info-card">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">📅 演唱會日期</span>
                <span class="info-value">{{ $ticket->concert_date->format('Y-m-d') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">🎫 座位區域</span>
                <span class="info-value">{{ $ticket->section }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">💵 購入價格</span>
                <span class="info-value">HK${{ number_format($ticket->purchase_price, 2) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">📦 購入數量</span>
                <span class="info-value">{{ $ticket->quantity }} 張</span>
            </div>
            <div class="info-item">
                <span class="info-label">✅ 已賣出</span>
                <span class="info-value sold">{{ $ticket->sold_quantity }} 張</span>
            </div>
            <div class="info-item">
                <span class="info-label">🎯 可賣出</span>
                <span class="info-value remaining">{{ $remaining }} 張</span>
            </div>
            <div class="info-item">
                <span class="info-label">💳 手續費</span>
                <span class="info-value">HK${{ number_format($ticket->commission, 2) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">💱 人民幣匯率</span>
                <span class="info-value">{{ number_format($ticket->exchange_rate, 4) }}</span>
            </div>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('tickets.store.sale', $ticket) }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="sold_quantity">
                        賣出數量 <span class="required">*</span>
                        <small class="hint">(最多可賣 {{ $remaining }} 張)</small>
                    </label>
                    <input type="number" 
                           id="sold_quantity" 
                           name="sold_quantity" 
                           class="form-control @error('sold_quantity') is-invalid @enderror"
                           min="1" 
                           max="{{ $remaining }}" 
                           required 
                           value="{{ old('sold_quantity') }}" 
                           inputmode="numeric">
                    @error('sold_quantity')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sale_price">售出單價 <span class="required">*</span></label>
                    <input type="number" 
                           id="sale_price" 
                           name="sale_price" 
                           class="form-control @error('sale_price') is-invalid @enderror"
                           step="0.01" 
                           min="0.01" 
                           required 
                           value="{{ old('sale_price') }}" 
                           inputmode="decimal">
                    @error('sale_price')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="currency">幣種 <span class="required">*</span></label>
                    <select id="currency" 
                            name="currency" 
                            class="form-control @error('currency') is-invalid @enderror"
                            required>
                        <option value="HKD" {{ old('currency') == 'HKD' ? 'selected' : '' }}>港幣 (HK$)</option>
                        <option value="CNY" {{ old('currency') == 'CNY' ? 'selected' : '' }}>人民幣 (¥)</option>
                    </select>
                    @error('currency')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>折合港幣</label>
                    <input type="text" 
                           id="total_hk" 
                           class="form-control readonly-field"
                           readonly 
                           value="HK$0.00">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-lg">✅ 確認賣出</button>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-lg">❌ 返回列表</a>
            </div>
        </form>
    </div>

    <script>
        const exchangeRate = {{ $ticket->exchange_rate }};
        
        function updateCalculation() {
            const quantity = parseFloat(document.getElementById('sold_quantity').value) || 0;
            const price = parseFloat(document.getElementById('sale_price').value) || 0;
            const currency = document.getElementById('currency').value;
            
            let totalHK = 0;
            if (currency === 'HKD') {
                totalHK = quantity * price;
            } else if (currency === 'CNY') {
                totalHK = quantity * price * exchangeRate;
            }
            
            document.getElementById('total_hk').value = 'HK$' + totalHK.toFixed(2);
        }
        
        document.getElementById('sold_quantity').addEventListener('input', updateCalculation);
        document.getElementById('sale_price').addEventListener('input', updateCalculation);
        document.getElementById('currency').addEventListener('change', updateCalculation);
        
        // 初始化
        updateCalculation();
    </script>
@endsection

@section('extra_css')
<style>
    .ticket-info-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-label {
        font-size: 13px;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }

    .info-value.sold {
        color: #10b981;
    }

    .info-value.remaining {
        color: #3b82f6;
        font-size: 22px;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .hint {
        color: #999;
        font-weight: 400;
        font-size: 12px;
    }

    .required {
        color: #ea4335;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        font-family: inherit;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background-color: #f8f9ff;
    }

    .form-control.is-invalid {
        border-color: #ea4335;
        background-color: #ffebee;
    }

    .form-control.readonly-field {
        background-color: #f0f0f0;
        cursor: not-allowed;
        color: #666;
        font-weight: 600;
    }

    .error-text {
        color: #ea4335;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-lg {
        padding: 14px 20px;
        font-size: 16px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-secondary {
        background-color: #e0e0e0;
        color: #333;
    }

    .btn-secondary:hover {
        background-color: #d0d0d0;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-card {
            padding: 16px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            grid-template-columns: 1fr;
        }
    }

    /* Dark Mode */
    [data-theme="dark"] .ticket-info-card,
    [data-theme="dark"] .form-card {
        background: #1a1a1a;
        box-shadow: 0 2px 12px rgba(0,0,0,0.3);
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

    [data-theme="dark"] .info-value.remaining {
        color: #60a5fa;
    }

    [data-theme="dark"] .form-group label {
        color: #e4e4e7;
    }

    [data-theme="dark"] .hint {
        color: #71717a;
    }

    [data-theme="dark"] .form-control {
        background-color: #262626;
        border-color: #3f3f46;
        color: #e4e4e7;
    }

    [data-theme="dark"] .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
        background-color: #2d2d2d;
    }

    [data-theme="dark"] .form-control.is-invalid {
        background-color: #5f1814;
        border-color: #ea4335;
    }

    [data-theme="dark"] .form-control.readonly-field {
        background-color: #1f1f1f;
        border-color: #3f3f46;
        color: #a1a1aa;
    }

    [data-theme="dark"] .btn-secondary {
        background-color: #3f3f46;
        color: #e4e4e7;
    }

    [data-theme="dark"] .btn-secondary:hover {
        background-color: #52525b;
    }
</style>
