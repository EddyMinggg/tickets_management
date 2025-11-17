@extends('layouts.app')

@section('title', '購入門票')

@section('content')
    <div class="section-title">購入新門票</div>

    <form method="POST" action="{{ route('tickets.store.purchase') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="concert_date">演唱會日期 <span style="color: red;">*</span></label>
                <input type="date" id="concert_date" name="concert_date" required value="{{ old('concert_date') }}" inputmode="none">
                @error('concert_date')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="section">座位區域 <span style="color: red;">*</span></label>
                <input type="text" id="section" name="section" maxlength="50" required value="{{ old('section') }}" placeholder="例如：GA5, GA6, VIP等" autocomplete="off" inputmode="text">
                @error('section')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="purchase_price">購入價格 (HK$) <span style="color: red;">*</span></label>
                <input type="number" id="purchase_price" name="purchase_price" step="0.01" min="0.01" required value="{{ old('purchase_price') }}" inputmode="decimal">
                @error('purchase_price')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">購入數量 <span style="color: red;">*</span></label>
                <input type="number" id="quantity" name="quantity" min="1" required value="{{ old('quantity') }}" inputmode="numeric">
                @error('quantity')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="commission">手續費 (HK$) <span style="color: #999;">(可選)</span></label>
                <input type="number" id="commission" name="commission" step="0.01" min="0" value="{{ old('commission', '0') }}" inputmode="decimal">
                @error('commission')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">確認購入</button>
            <a href="{{ route('tickets.purchase.batch') }}" class="btn btn-primary">批量購入</a>
            <a href="{{ route('tickets.index') }}" class="btn btn-primary">返回列表</a>
        </div>
    </form>
@endsection
