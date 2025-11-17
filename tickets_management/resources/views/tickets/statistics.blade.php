@extends('layouts.app')

@section('title', '統計信息')

@section('content')
    <div class="page-header">
        <h2 class="page-title">📊 統計分析</h2>
    </div>

    <div class="action-grid" style="grid-template-columns: 1fr 1fr;">
        <a href="{{ route('tickets.index') }}" class="action-card secondary">
            <div class="action-icon">🎫</div>
            <div class="action-text">門票管理</div>
        </a>
        <a href="{{ route('tickets.records') }}" class="action-card secondary">
            <div class="action-icon">📝</div>
            <div class="action-text">交易記錄</div>
        </a>
    </div>

    <div class="stats-cards">
        <div class="stat-card-modern purchase">
            <div class="stat-icon">💸</div>
            <div class="stat-content">
                <div class="stat-label">總購入額</div>
                <div class="stat-value">HK${{ number_format($totalPurchaseHKD, 2) }}</div>
            </div>
        </div>

        <div class="stat-card-modern sale">
            <div class="stat-icon">💰</div>
            <div class="stat-content">
                <div class="stat-label">總賣出額</div>
                <div class="stat-value">HK${{ number_format($totalSaleHKD, 2) }}</div>
            </div>
        </div>

        <div class="stat-card-modern {{ $profit >= 0 ? 'profit' : 'loss' }}">
            <div class="stat-icon">{{ $profit >= 0 ? '📈' : '📉' }}</div>
            <div class="stat-content">
                <div class="stat-label">{{ $profit >= 0 ? '總利潤' : '總虧損' }}</div>
                <div class="stat-value">HK${{ number_format(abs($profit), 2) }}</div>
            </div>
        </div>
    </div>

    <div class="summary-section">
        <h3 class="section-subtitle">📋 交易摘要</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-icon">📥</div>
                <div class="summary-content">
                    <div class="summary-value">{{ $transactions->where('type', 'purchase')->count() }}</div>
                    <div class="summary-label">購入交易</div>
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-icon">📤</div>
                <div class="summary-content">
                    <div class="summary-value">{{ $transactions->where('type', 'sale')->count() }}</div>
                    <div class="summary-label">賣出交易</div>
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-icon">💵</div>
                <div class="summary-content">
                    <div class="summary-value">HK${{ $transactions->where('type', 'purchase')->count() > 0 ? number_format($totalPurchaseHKD / $transactions->where('type', 'purchase')->count(), 2) : '0.00' }}</div>
                    <div class="summary-label">平均購入價</div>
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-icon">💴</div>
                <div class="summary-content">
                    <div class="summary-value">HK${{ $transactions->where('type', 'sale')->count() > 0 ? number_format($totalSaleHKD / $transactions->where('type', 'sale')->count(), 2) : '0.00' }}</div>
                    <div class="summary-label">平均賣出價</div>
                </div>
            </div>
        </div>
    </div>

    @if($transactions->count() > 0)
        <div class="recent-section">
            <h3 class="section-subtitle">⏱️ 最近交易</h3>
            <div class="transaction-list compact">
                @foreach($transactions->take(10) as $transaction)
                    <div class="transaction-card-compact {{ $transaction->type }}">
                        <div class="compact-left">
                            <div class="compact-type {{ $transaction->type }}">
                                {{ $transaction->type === 'purchase' ? '📥 購入' : '📤 賣出' }}
                            </div>
                            <div class="compact-info">
                                <div class="compact-section">{{ $transaction->section }}</div>
                                <div class="compact-time">{{ $transaction->created_at->format('m-d H:i') }}</div>
                            </div>
                        </div>
                        <div class="compact-right">
                            <div class="compact-quantity">{{ $transaction->quantity }} 張</div>
                            <div class="compact-amount">HK${{ number_format($transaction->total_hkd, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">📊</div>
            <div class="empty-text">還沒有交易數據</div>
            <a href="{{ route('tickets.index') }}" class="btn btn-primary">開始記錄</a>
        </div>
    @endif
@endsection
