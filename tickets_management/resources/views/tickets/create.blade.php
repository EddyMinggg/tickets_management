@extends('layouts.app')

@section('title', '新增門票')

@section('content')
    <div class="section-title">新增門票</div>

    <form method="POST" action="{{ route('tickets.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="purchase_date">購入時間 <span style="color: red;">*</span></label>
                <input type="datetime-local" id="purchase_date" name="purchase_date" required value="{{ old('purchase_date') }}">
                @error('purchase_date')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="purchase_price">購入價格 (¥) <span style="color: red;">*</span></label>
                <input type="number" id="purchase_price" name="purchase_price" step="0.01" min="0" required value="{{ old('purchase_price') }}">
                @error('purchase_price')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="quantity">購入數量 <span style="color: red;">*</span></label>
                <input type="number" id="quantity" name="quantity" min="1" required value="{{ old('quantity') }}">
                @error('quantity')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="exchange_rate">人民幣兌換價格 <span style="color: red;">*</span></label>
                <input type="number" id="exchange_rate" name="exchange_rate" step="0.0001" min="0.01" required value="{{ old('exchange_rate', '1.0000') }}">
                @error('exchange_rate')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">保存門票</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-primary">返回列表</a>
        </div>
    </form>
@endsection
