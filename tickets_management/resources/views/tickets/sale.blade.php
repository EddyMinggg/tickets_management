@extends('layouts.app')

@section('title', '賣出門票')

@section('content')
    <div class="section-title">賣出門票</div>

    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <p><strong>演唱會日期：</strong>{{ $ticket->concert_date->format('Y-m-d') }}</p>
        <p><strong>座位區域：</strong>{{ $ticket->section }}</p>
        <p><strong>購入價格：</strong>HK${{ number_format($ticket->purchase_price, 2) }}</p>
        <p><strong>購入數量：</strong>{{ $ticket->quantity }}</p>
        <p><strong>已賣出：</strong>{{ $ticket->sold_quantity }}</p>
        <p><strong>可賣出數量：</strong>{{ $remaining }}</p>
        <p><strong>手續費：</strong>HK${{ number_format($ticket->commission, 2) }}</p>
        <p><strong>人民幣匯率：</strong>{{ number_format($ticket->exchange_rate, 4) }}</p>
    </div>

    <form method="POST" action="{{ route('tickets.store.sale', $ticket) }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="sold_quantity">賣出數量 <span style="color: red;">*</span> <small style="color: #999;">(最多可賣 {{ $remaining }} 張)</small></label>
                <input type="number" id="sold_quantity" name="sold_quantity" min="1" max="{{ $remaining }}" required value="{{ old('sold_quantity') }}" inputmode="numeric">
                @error('sold_quantity')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sale_price">售出單價 <span style="color: red;">*</span></label>
                <input type="number" id="sale_price" name="sale_price" step="0.01" min="0.01" required value="{{ old('sale_price') }}" inputmode="decimal">
                @error('sale_price')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="currency">幣種 <span style="color: red;">*</span></label>
                <select id="currency" name="currency" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; font-family: inherit;">
                    <option value="HKD" {{ old('currency') == 'HKD' ? 'selected' : '' }}>港幣 (HK$)</option>
                    <option value="CNY" {{ old('currency') == 'CNY' ? 'selected' : '' }}>人民幣 (¥)</option>
                </select>
                @error('currency')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>折合港幣</label>
                <input type="text" id="total_hk" readonly style="background-color: #f0f0f0; cursor: not-allowed;" value="HK$0.00">
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">確認賣出</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-primary">返回列表</a>
        </div>
    </form>

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
