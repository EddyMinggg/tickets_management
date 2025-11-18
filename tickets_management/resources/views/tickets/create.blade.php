@extends('layouts.app')

@section('title', '新增門票')

@section('content')
    <div class="page-header">
        <h2 class="page-title">➕ 新增門票</h2>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf

            <div style="background: #f0f0f0; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <h3 style="margin: 0 0 8px 0; font-size: 14px; color: #333;">📋 基本信息</h3>
            </div>

            <div class="form-group">
                <label for="concert_date">演唱會日期 <span class="required">*</span></label>
                <input type="date" id="concert_date" name="concert_date" 
                       class="form-control @error('concert_date') is-invalid @enderror"
                       value="{{ old('concert_date') }}" required>
                @error('concert_date')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="section">座位區域 <span class="required">*</span></label>
                <input type="text" id="section" name="section" 
                       class="form-control @error('section') is-invalid @enderror"
                       placeholder="如: A區、VIP 等"
                       value="{{ old('section') }}" required>
                @error('section')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="quantity">購入數量 <span class="required">*</span></label>
                    <input type="number" id="quantity" name="quantity" 
                           class="form-control @error('quantity') is-invalid @enderror"
                           min="1" step="1" 
                           value="{{ old('quantity') }}" required>
                    @error('quantity')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="purchase_price">購入價格 <span class="required">*</span></label>
                    <input type="number" id="purchase_price" name="purchase_price" 
                           class="form-control @error('purchase_price') is-invalid @enderror"
                           step="0.01" min="0" 
                           value="{{ old('purchase_price') }}" required>
                    @error('purchase_price')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="commission">手續費 <span class="required">*</span></label>
                    <input type="number" id="commission" name="commission" 
                           class="form-control @error('commission') is-invalid @enderror"
                           step="0.01" min="0" 
                           value="{{ old('commission', '0.00') }}" required>
                    @error('commission')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="background: #f0f0f0; padding: 12px; border-radius: 8px; margin: 20px 0 20px 0;">
                <h3 style="margin: 0 0 8px 0; font-size: 14px; color: #333;">🛒 購入來源信息</h3>
                <p style="margin: 0; font-size: 12px; color: #666;">選填 - 可以稍後在「購入來源」編輯</p>
            </div>

            <div class="form-group">
                <label for="seller_name">賣家名稱/平臺</label>
                <input type="text" id="seller_name" name="seller_name" 
                       class="form-control @error('seller_name') is-invalid @enderror"
                       placeholder="如: 蝦皮賣家、Carousell 用戶名等"
                       value="{{ old('seller_name') }}">
                @error('seller_name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="seller_contact">賣家聯絡方式</label>
                <input type="text" id="seller_contact" name="seller_contact" 
                       class="form-control @error('seller_contact') is-invalid @enderror"
                       placeholder="如: WhatsApp、微信號、電話等"
                       value="{{ old('seller_contact') }}">
                @error('seller_contact')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="platform">購入平臺</label>
                <select id="platform" name="platform" class="form-control @error('platform') is-invalid @enderror">
                    <option value="">-- 請選擇 --</option>
                    <option value="蝦皮" {{ old('platform') === '蝦皮' ? 'selected' : '' }}>蝦皮</option>
                    <option value="Carousell" {{ old('platform') === 'Carousell' ? 'selected' : '' }}>Carousell</option>
                    <option value="eBay" {{ old('platform') === 'eBay' ? 'selected' : '' }}>eBay</option>
                    <option value="雅虎" {{ old('platform') === '雅虎' ? 'selected' : '' }}>雅虎拍賣</option>
                    <option value="其他" {{ old('platform') === '其他' ? 'selected' : '' }}>其他</option>
                </select>
                @error('platform')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">備註</label>
                <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror"
                          placeholder="購買過程、折扣、額外費用等備註"
                          rows="2">{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">✅ 保存門票</button>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-lg">❌ 返回列表</a>
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
        max-width: 600px;
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

    .error-text {
        color: #ea4335;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
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

    @media (prefers-color-scheme: dark) {
        .form-card {
            background: #1a1a1a;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
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

        h3 {
            color: #e4e4e7 !important;
        }

        div[style*="background: #f0f0f0"] {
            background: #262626 !important;
        }

        div[style*="color: #333"] {
            color: #e4e4e7 !important;
        }

        div[style*="color: #666"] {
            color: #a1a1aa !important;
        }
    }
</style>
@endsection
