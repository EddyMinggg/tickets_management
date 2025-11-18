@extends('layouts.app')

@section('title', '購入來源詳情')

@section('content')
    <div class="page-header">
        <h2 class="page-title">🔍 購入來源詳情</h2>
        <p class="page-subtitle">演唱會: {{ $ticket->concert_date->format('Y-m-d') }} | 座位: {{ $ticket->section }}</p>
    </div>

    <div class="details-header">
        <a href="{{ route('tickets.sources.add', $ticket) }}" class="btn btn-primary">
            ➕ 添加新的購入來源
        </a>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            ← 返回門票列表
        </a>
    </div>

    @if($ticket->sources->count() > 0)
        <div class="sources-list">
            @foreach($ticket->sources as $source)
                <div class="source-card">
                    <div class="source-header">
                        <div class="source-info">
                            <div class="source-seller">🧑 {{ $source->seller_name }}</div>
                            <div class="source-platform">{{ $source->platform }}</div>
                        </div>
                        <div class="source-actions-mini">
                            <a href="{{ route('tickets.sources.edit', [$ticket, $source]) }}" class="icon-btn edit">✏️</a>
                            <form method="POST" action="{{ route('tickets.sources.destroy', [$ticket, $source]) }}" style="display: inline;" id="deleteSourceForm-{{ $source->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="icon-btn delete" onclick="if(confirm('確定要刪除嗎？')) document.getElementById('deleteSourceForm-{{ $source->id }}').submit();">🗑️</button>
                            </form>
                        </div>
                    </div>

                    <div class="source-body">
                        <div class="source-row">
                            <div class="detail-item">
                                <span class="detail-label">購入數量</span>
                                <span class="detail-value">{{ $source->quantity_purchased }} 張</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">單位價格</span>
                                <span class="detail-value">{{ $source->currency }} ${{ number_format($source->unit_price, 2) }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">總成本</span>
                                <span class="detail-value highlight">{{ $source->currency }} ${{ number_format($source->total_cost, 2) }}</span>
                            </div>
                        </div>

                        @if($source->seller_contact)
                            <div class="source-row">
                                <div class="detail-item">
                                    <span class="detail-label">賣家聯絡</span>
                                    <span class="detail-value">{{ $source->seller_contact }}</span>
                                </div>
                            </div>
                        @endif

                        @if($source->notes)
                            <div class="source-notes">
                                <span class="notes-label">📝 備註</span>
                                <p class="notes-content">{{ $source->notes }}</p>
                            </div>
                        @endif

                        <div class="source-meta">
                            <span class="meta-time">📅 {{ $source->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-card">
            <div class="empty-icon">📭</div>
            <div class="empty-text">還沒有添加購入來源</div>
            <a href="{{ route('tickets.sources.add', $ticket) }}" class="btn btn-primary">添加第一個購入來源</a>
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

    .sources-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .source-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .source-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .source-info {
        flex: 1;
    }

    .source-seller {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .source-platform {
        font-size: 13px;
        opacity: 0.9;
    }

    .source-actions-mini {
        display: flex;
        gap: 8px;
    }

    .icon-btn {
        font-size: 18px;
        background: rgba(255,255,255,0.2);
        border: none;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
        color: white;
    }

    .icon-btn:hover {
        background: rgba(255,255,255,0.3);
    }

    .icon-btn.delete:hover {
        background: #ea4335;
    }

    .source-body {
        padding: 16px;
    }

    .source-row {
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
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .detail-value.highlight {
        color: #667eea;
        font-size: 18px;
    }

    .source-notes {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        margin: 12px 0;
    }

    .notes-label {
        display: block;
        font-size: 13px;
        color: #666;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .notes-content {
        font-size: 14px;
        color: #333;
        line-height: 1.5;
        margin: 0;
    }

    .source-meta {
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

        .source-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .source-actions-mini {
            align-self: flex-end;
        }

        .source-row {
            grid-template-columns: 1fr;
        }
    }

    [data-theme="dark"] .source-card {
        background: #1a1a1a;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    [data-theme="dark"] .page-subtitle {
        color: #a1a1aa;
    }

    [data-theme="dark"] .detail-label {
        color: #a1a1aa;
    }

    [data-theme="dark"] .detail-value {
        color: #e4e4e7;
    }

    [data-theme="dark"] .detail-value.highlight {
        color: #a78bfa;
    }

    [data-theme="dark"] .source-notes {
        background: #262626;
    }

    [data-theme="dark"] .notes-label {
        color: #a1a1aa;
    }

    [data-theme="dark"] .notes-content {
        color: #e4e4e7;
    }

    [data-theme="dark"] .source-meta {
        color: #71717a;
    }

    [data-theme="dark"] .empty-card {
        background: #1a1a1a;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    [data-theme="dark"] .empty-text {
        color: #a1a1aa;
    }
</style>
@endsection
