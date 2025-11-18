@extends('layouts.app')

@section('title', '添加售出詳情')

@section('content')
    <div class="page-header">
        <h2 class="page-title">💰 添加售出詳情</h2>
    </div>

    <div class="form-card">
        <form action="{{ route('tickets.sales.store', $ticket) }}" method="POST">
            @csrf

            <div class="form-section">
                <h3 class="section-title">買家信息</h3>

                <div class="form-group">
                    <label for="buyer_name">買家名稱 <span class="required">*</span></label>
                    <input type="text" id="buyer_name" name="buyer_name" 
                           class="form-control @error('buyer_name') is-invalid @enderror"
                           placeholder="如: 張三、微信昵稱等"
                           value="{{ old('buyer_name') }}" required>
                    @error('buyer_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="buyer_contact">買家聯絡方式</label>
                    <input type="text" id="buyer_contact" name="buyer_contact" 
                           class="form-control @error('buyer_contact') is-invalid @enderror"
                           placeholder="如: 微信、QQ、電話等"
                           value="{{ old('buyer_contact') }}">
                    @error('buyer_contact')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="platform">銷售平臺 <span class="required">*</span></label>
                    <select id="platform" name="platform" 
                            class="form-control @error('platform') is-invalid @enderror" required>
                        <option value="">請選擇平臺</option>
                        <option value="58.com" {{ old('platform') === '58.com' ? 'selected' : '' }}>58.com</option>
                        <option value="Xianyu" {{ old('platform') === 'Xianyu' ? 'selected' : '' }}>閒魚</option>
                        <option value="微信朋友圈" {{ old('platform') === '微信朋友圈' ? 'selected' : '' }}>微信朋友圈</option>
                        <option value="小紅書" {{ old('platform') === '小紅書' ? 'selected' : '' }}>小紅書</option>
                        <option value="私人交易" {{ old('platform') === '私人交易' ? 'selected' : '' }}>私人交易</option>
                        <option value="其他" {{ old('platform') === '其他' ? 'selected' : '' }}>其他</option>
                    </select>
                    @error('platform')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">售賣信息</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="quantity_sold">售賣數量 <span class="required">*</span></label>
                        <input type="number" id="quantity_sold" name="quantity_sold" 
                               class="form-control @error('quantity_sold') is-invalid @enderror"
                               min="1" step="1" max="{{ $ticket->remaining_quantity }}"
                               placeholder="最多 {{ $ticket->remaining_quantity }} 張"
                               value="{{ old('quantity_sold') }}" required>
                        @error('quantity_sold')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unit_price">售賣單價 <span class="required">*</span></label>
                        <input type="number" id="unit_price" name="unit_price" 
                               class="form-control @error('unit_price') is-invalid @enderror"
                               min="0" step="0.01" placeholder="0.00"
                               value="{{ old('unit_price') }}" required>
                        @error('unit_price')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="currency">幣種 <span class="required">*</span></label>
                        <select id="currency" name="currency" 
                                class="form-control @error('currency') is-invalid @enderror" required>
                            <option value="HKD" {{ old('currency') === 'HKD' ? 'selected' : '' }}>港幣 (HKD)</option>
                            <option value="CNY" {{ old('currency', 'CNY') === 'CNY' ? 'selected' : '' }}>人民幣 (CNY)</option>
                        </select>
                        @error('currency')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sale_date">售賣日期</label>
                        <input type="date" id="sale_date" name="sale_date" 
                               class="form-control @error('sale_date') is-invalid @enderror"
                               value="{{ old('sale_date') }}">
                        @error('sale_date')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sale_status">售賣狀態 <span class="required">*</span></label>
                        <select id="sale_status" name="sale_status" 
                                class="form-control @error('sale_status') is-invalid @enderror" required>
                            <option value="pending" {{ old('sale_status', 'pending') === 'pending' ? 'selected' : '' }}>⏳ 待確認</option>
                            <option value="confirmed" {{ old('sale_status') === 'confirmed' ? 'selected' : '' }}>✅ 已確認</option>
                            <option value="shipped" {{ old('sale_status') === 'shipped' ? 'selected' : '' }}>📦 已發貨</option>
                            <option value="completed" {{ old('sale_status') === 'completed' ? 'selected' : '' }}>🎉 已完成</option>
                        </select>
                        @error('sale_status')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">郵寄信息</h3>

                <div class="form-group">
                    <label for="shipping_address">郵寄地址</label>
                    <textarea id="shipping_address" name="shipping_address" 
                              class="form-control @error('shipping_address') is-invalid @enderror"
                              placeholder="買家收貨地址"
                              rows="2">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="shipping_method">郵寄方式</label>
                        <select id="shipping_method" name="shipping_method" 
                                class="form-control @error('shipping_method') is-invalid @enderror">
                            <option value="">無</option>
                            <option value="順豐快遞" {{ old('shipping_method') === '順豐快遞' ? 'selected' : '' }}>順豐快遞</option>
                            <option value="中通" {{ old('shipping_method') === '中通' ? 'selected' : '' }}>中通</option>
                            <option value="圓通" {{ old('shipping_method') === '圓通' ? 'selected' : '' }}>圓通</option>
                            <option value="申通" {{ old('shipping_method') === '申通' ? 'selected' : '' }}>申通</option>
                            <option value="郵政" {{ old('shipping_method') === '郵政' ? 'selected' : '' }}>郵政</option>
                            <option value="自提" {{ old('shipping_method') === '自提' ? 'selected' : '' }}>自提</option>
                            <option value="其他" {{ old('shipping_method') === '其他' ? 'selected' : '' }}>其他</option>
                        </select>
                        @error('shipping_method')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tracking_number">物流單號</label>
                        <input type="text" id="tracking_number" name="tracking_number" 
                               class="form-control @error('tracking_number') is-invalid @enderror"
                               placeholder="快遞單號"
                               value="{{ old('tracking_number') }}">
                        @error('tracking_number')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="shipped_date">發貨日期</label>
                        <input type="date" id="shipped_date" name="shipped_date" 
                               class="form-control @error('shipped_date') is-invalid @enderror"
                               value="{{ old('shipped_date') }}">
                        @error('shipped_date')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">備註</h3>
                <div class="form-group">
                    <label for="notes">額外備註</label>
                    <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror"
                              placeholder="如: 特殊要求、優惠、協商事項等"
                              rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">✅ 確認添加</button>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-lg">❌ 返回</a>
            </div>
        </form>
    </div>
@endsection

@section('extra_css')
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        max-width: 700px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5e5e5;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
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

    .error-text {
        color: #ea4335;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .form-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 28px;
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
        .form-card {
            padding: 16px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            grid-template-columns: 1fr;
        }

        .section-title {
            font-size: 15px;
        }
    }

    @media (prefers-color-scheme: dark) {
        .form-card {
            background: #1a1a1a;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }

        .form-section {
            border-bottom-color: #3f3f46;
        }

        .section-title {
            color: #a78bfa;
        }

        .form-group label {
            color: #e4e4e7;
        }

        .form-control {
            background-color: #262626;
            border-color: #3f3f46;
            color: #e4e4e7;
        }

        .form-control:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
            background-color: #2d2d2d;
        }

        .form-control.is-invalid {
            background-color: #5f1814;
            border-color: #ea4335;
        }
    }
</style>
@endsection
