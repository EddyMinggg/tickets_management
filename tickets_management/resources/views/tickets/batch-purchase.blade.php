@extends('layouts.app')

@section('title', '批量購入門票')

@section('content')
    <div class="section-title">批量購入門票</div>

    <form method="POST" action="{{ route('tickets.store.batch.purchase') }}">
        @csrf

        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <p style="margin: 0; color: #666;">
                在下方表格中輸入多個購入記錄，每一行代表一筆購入。最後點擊「確認購入」即可一次性保存所有記錄。
            </p>
        </div>

        <div style="overflow-x: auto; margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">演唱會日期</th>
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">座位區域</th>
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">購入價格 (HK$)</th>
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">購入數量</th>
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">手續費 (HK$)</th>
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">小計 (HK$)</th>
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody id="records-tbody">
                    <!-- 動態行會插入這裡 -->
                </tbody>
            </table>
        </div>

        <div style="margin-bottom: 20px; display: flex; gap: 10px;">
            <button type="button" id="add-row-btn" class="btn btn-primary">+ 添加一行</button>
            <button type="button" id="add-multiple-rows-btn" class="btn btn-secondary">+ 添加5行</button>
        </div>

        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: right;">
            <p style="margin: 5px 0;"><strong>總金額：</strong>HK$<span id="total-amount">0.00</span></p>
            <p style="margin: 5px 0;"><strong>總數量：</strong><span id="total-quantity">0</span> 張</p>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">確認購入</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-primary">返回列表</a>
        </div>
    </form>

    <script>
        let rowCount = 0;

        function createRow() {
            rowCount++;
            const rowId = `row-${rowCount}`;
            const row = document.createElement('tr');
            row.id = rowId;
            row.style.borderBottom = '1px solid #ddd';
            
            row.innerHTML = `
                <td style="border: 1px solid #ddd; padding: 10px;">
                    <input type="date" name="concert_date[]" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                </td>
                <td style="border: 1px solid #ddd; padding: 10px;">
                    <input type="text" name="section[]" maxlength="50" required placeholder="例如：GA5, VIP" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                </td>
                <td style="border: 1px solid #ddd; padding: 10px;">
                    <input type="number" name="purchase_price[]" step="0.01" min="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" class="price-input">
                </td>
                <td style="border: 1px solid #ddd; padding: 10px;">
                    <input type="number" name="quantity[]" min="1" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" class="qty-input">
                </td>
                <td style="border: 1px solid #ddd; padding: 10px;">
                    <input type="number" name="commission[]" step="0.01" min="0" value="0" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" class="commission-input">
                </td>
                <td style="border: 1px solid #ddd; padding: 10px; background-color: #f5f5f5; text-align: right;">
                    <span class="subtotal">HK$0.00</span>
                </td>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                    <button type="button" class="btn btn-danger btn-sm remove-row" data-row-id="${rowId}">刪除</button>
                </td>
            `;

            // 添加事件監聽器
            const priceInput = row.querySelector('.price-input');
            const qtyInput = row.querySelector('.qty-input');
            const commissionInput = row.querySelector('.commission-input');
            
            [priceInput, qtyInput, commissionInput].forEach(input => {
                input.addEventListener('input', updateCalculations);
            });

            row.querySelector('.remove-row').addEventListener('click', function() {
                row.remove();
                updateCalculations();
            });

            document.getElementById('records-tbody').appendChild(row);
            updateCalculations();
        }

        function updateCalculations() {
            let totalAmount = 0;
            let totalQty = 0;

            const rows = document.querySelectorAll('#records-tbody tr');
            rows.forEach(row => {
                const priceInput = row.querySelector('.price-input');
                const qtyInput = row.querySelector('.qty-input');
                const commissionInput = row.querySelector('.commission-input');
                const subtotal = row.querySelector('.subtotal');

                const price = parseFloat(priceInput.value) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                const commission = parseFloat(commissionInput.value) || 0;

                const rowTotal = (price + commission) * qty;
                subtotal.textContent = `HK$${rowTotal.toFixed(2)}`;

                totalAmount += rowTotal;
                totalQty += qty;
            });

            document.getElementById('total-amount').textContent = totalAmount.toFixed(2);
            document.getElementById('total-quantity').textContent = totalQty;
        }

        document.getElementById('add-row-btn').addEventListener('click', function(e) {
            e.preventDefault();
            createRow();
        });

        document.getElementById('add-multiple-rows-btn').addEventListener('click', function(e) {
            e.preventDefault();
            for (let i = 0; i < 5; i++) {
                createRow();
            }
        });

        // 初始化：添加一行空白行
        createRow();
    </script>

    <style>
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
    </style>
@endsection
