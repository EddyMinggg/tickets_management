@extends('layouts.app')

@section('title', '售出詳情')

@section('content')
    <div class="page-header">
        <h2 class="page-title">💰 售出詳情</h2>
        <p class="page-subtitle">演唱會: {{ $ticket->concert_date->format('Y-m-d') }} | 座位: {{ $ticket->section }}</p>
    </div>

    <div class="details-header">
        <a href="{{ route('tickets.sales.add', $ticket) }}" class="btn btn-primary">
            ➕ 添加新的售賣記錄
        </a>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            ← 返回門票列表
        </a>
    </div>

    @if($ticket->sales->count() > 0)
        <div class="sales-list">
            @foreach($ticket->sales as $sale)
                <div class="sale-card">
                    <div class="sale-header">
                        <div class="sale-status {{ $sale->sale_status }}">
                            @switch($sale->sale_status)
                                @case('pending')
                                    ⏳ 待確認
                                    @break
                                @case('confirmed')
                                    ✅ 已確認
                                    @break
                                @case('shipped')
                                    📦 已發貨
                                    @break
                                @case('completed')
                                    🎉 已完成
                                    @break
                            @endswitch
                        </div>
                        <div class="sale-buyer">{{ $sale->buyer_name }}</div>
                        <div class="sale-actions-mini">
                            <a href="{{ route('tickets.sales.edit', [$ticket, $sale]) }}" class="icon-btn edit">✏️</a>
                            <form method="POST" action="{{ route('tickets.sales.destroy', [$ticket, $sale]) }}" style="display: inline;" id="deleteSaleForm-{{ $sale->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="icon-btn delete" onclick="if(confirm('確定要刪除嗎？')) document.getElementById('deleteSaleForm-{{ $sale->id }}').submit();">🗑️</button>
                            </form>
                        </div>
                    </div>

                    <div class="sale-body">
                        <div class="sale-row">
                            <div class="detail-item">
                                <span class="detail-label">售賣平臺</span>
                                <span class="detail-value">{{ $sale->platform }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">售賣數量</span>
                                <span class="detail-value">{{ $sale->quantity_sold }} 張</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">單價</span>
                                <span class="detail-value">{{ $sale->currency }} ${{ number_format($sale->unit_price, 2) }}</span>
                            </div>
                        </div>

                        <div class="sale-row">
                            <div class="detail-item">
                                <span class="detail-label">總收入</span>
                                <span class="detail-value highlight profit">{{ $sale->currency }} ${{ number_format($sale->total_revenue, 2) }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">售賣日期</span>
                                <span class="detail-value">{{ $sale->sale_date ? $sale->sale_date->format('Y-m-d') : '未設定' }}</span>
                            </div>
                        </div>

                        @if($sale->shipping_method)
                            <div class="sale-row">
                                <div class="detail-item">
                                    <span class="detail-label">郵寄方式</span>
                                    <span class="detail-value">{{ $sale->shipping_method }}</span>
                                </div>
                                @if($sale->tracking_number)
                                    <div class="detail-item">
                                        <span class="detail-label">物流單號</span>
                                        <span class="detail-value">{{ $sale->tracking_number }}</span>
                                    </div>
                                @endif
                                @if($sale->shipped_date)
                                    <div class="detail-item">
                                        <span class="detail-label">發貨日期</span>
                                        <span class="detail-value">{{ $sale->shipped_date->format('Y-m-d') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($sale->shipping_address)
                            <div class="sale-address">
                                <span class="address-label">📍 郵寄地址</span>
                                <p class="address-content">{{ $sale->shipping_address }}</p>
                            </div>
                        @endif

                        @if($sale->buyer_contact)
                            <div class="sale-row">
                                <div class="detail-item">
                                    <span class="detail-label">買家聯絡</span>
                                    <span class="detail-value">{{ $sale->buyer_contact }}</span>
                                </div>
                            </div>
                        @endif

                        @if($sale->notes)
                            <div class="sale-notes">
                                <span class="notes-label">📝 備註</span>
                                <p class="notes-content">{{ $sale->notes }}</p>
                            </div>
                        @endif

                        <div class="sale-meta">
                            <span class="meta-time">📅 {{ $sale->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-card">
            <div class="empty-icon">📭</div>
            <div class="empty-text">還沒有添加售出記錄</div>
            <a href="{{ route('tickets.sales.add', $ticket) }}" class="btn btn-primary">添加第一個售出記錄</a>
        </div>
    @endif
@endsection

@section('extra_css')
<style>
    .page-subtitle {
        color: #666;
        font-size: 14px;
        margin-top: 8px;
    }

    .details-header {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .sales-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sale-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-left: 4px solid #10b981;
    }

    .sale-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        background: #f8f9fa;
        gap: 12px;
        flex-wrap: wrap;
    }

    .sale-status {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        min-width: 80px;
    }

    .sale-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .sale-status.confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .sale-status.shipped {
        background: #dbeafe;
        color: #0c2d6b;
    }

    .sale-status.completed {
        background: #c7d2fe;
        color: #3730a3;
    }

    .sale-buyer {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        flex: 1;
    }

    .sale-actions-mini {
        display: flex;
        gap: 8px;
    }

    .icon-btn {
        font-size: 16px;
        background: #e5e7eb;
        border: none;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
        color: #333;
    }

    .icon-btn:hover {
        background: #d1d5db;
    }

    .icon-btn.delete:hover {
        background: #ea4335;
        color: white;
    }

    .sale-body {
        padding: 16px;
    }

    .sale-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .detail-label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        text-transform: uppercase;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #333;
    }

    .detail-value.highlight {
        font-size: 18px;
    }

    .detail-value.highlight.profit {
        color: #10b981;
    }

    .sale-address,
    .sale-notes {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        margin: 12px 0;
    }

    .address-label,
    .notes-label {
        display: block;
        font-size: 13px;
        color: #666;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .address-content,
    .notes-content {
        font-size: 14px;
        color: #333;
        line-height: 1.5;
        margin: 0;
    }

    .sale-meta {
        display: flex;
        justify-content: flex-end;
        margin-top: 12px;
        font-size: 12px;
        color: #999;
    }

    .empty-card {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
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

    @media (max-width: 768px) {
        .details-header {
            flex-direction: column;
        }

        .details-header .btn {
            width: 100%;
            text-align: center;
        }

        .sale-header {
            padding: 12px;
        }

        .sale-buyer {
            width: 100%;
            order: -1;
        }

        .sale-row {
            grid-template-columns: 1fr;
        }
    }

    @media (prefers-color-scheme: dark) {
        .sale-card {
            background: #1a1a1a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .sale-header {
            background: #262626;
        }

        .sale-buyer {
            color: #e4e4e7;
        }

        .page-subtitle {
            color: #a1a1aa;
        }

        .detail-label {
            color: #a1a1aa;
        }

        .detail-value {
            color: #e4e4e7;
        }

        .detail-value.highlight.profit {
            color: #34d399;
        }

        .sale-address,
        .sale-notes {
            background: #262626;
        }

        .address-label,
        .notes-label {
            color: #a1a1aa;
        }

        .address-content,
        .notes-content {
            color: #e4e4e7;
        }

        .sale-meta {
            color: #71717a;
        }

        .icon-btn {
            background: #3f3f46;
            color: #e4e4e7;
        }

        .icon-btn:hover {
            background: #52525b;
        }

        .empty-card {
            background: #1a1a1a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .empty-text {
            color: #a1a1aa;
        }
    }
</style>
@endsection
