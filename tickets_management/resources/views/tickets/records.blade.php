@extends('layouts.app')

@section('title', '交易記錄')

@section('content')
    <div class="page-header">
        <h2 class="page-title">📝 交易記錄</h2>
    </div>

    <div class="action-grid" style="grid-template-columns: 1fr 1fr;">
        <a href="{{ route('tickets.index') }}" class="action-card secondary">
            <div class="action-icon">🎫</div>
            <div class="action-text">門票管理</div>
        </a>
        <a href="{{ route('tickets.statistics') }}" class="action-card secondary">
            <div class="action-icon">📊</div>
            <div class="action-text">統計信息</div>
        </a>
    </div>

    @if($transactions->count() > 0)
        <div class="transaction-list">
            @foreach($transactions as $transaction)
                <div class="transaction-card {{ $transaction->type }}">
                    <div class="transaction-header">
                        <div class="transaction-type {{ $transaction->type }}">
                            <span class="type-icon">{{ $transaction->type === 'purchase' ? '📥' : '📤' }}</span>
                            {{ $transaction->type === 'purchase' ? '購入' : '賣出' }}
                        </div>
                        <div class="transaction-time">
                            {{ $transaction->created_at->format('m-d H:i') }}
                        </div>
                    </div>
                    
                    <div class="transaction-body">
                        <div class="transaction-main">
                            <div class="concert-info">
                                <div class="concert-date">📅 {{ $transaction->concert_date->format('Y-m-d') }}</div>
                                <div class="concert-section">{{ $transaction->section }}</div>
                            </div>
                            <div class="transaction-amount">
                                <div class="amount-value">HK${{ number_format($transaction->total_hkd, 2) }}</div>
                            </div>
                        </div>
                        
                        <div class="transaction-details">
                            <div class="detail-item">
                                <span>數量</span>
                                <strong>{{ $transaction->quantity }} 張</strong>
                            </div>
                            <div class="detail-item">
                                <span>單價</span>
                                <strong>
                                    @if($transaction->currency === 'HKD')
                                        HK${{ number_format($transaction->price, 2) }}
                                    @else
                                        ¥{{ number_format($transaction->price, 2) }}
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="transaction-footer">
                        <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" id="deleteTransactionForm-{{ $transaction->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn" onclick="openDeleteTransactionModal(document.getElementById('deleteTransactionForm-{{ $transaction->id }}'))">
                                🗑️ 刪除記錄
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <div class="empty-text">還沒有交易記錄</div>
            <a href="{{ route('tickets.index') }}" class="btn btn-primary">返回門票管理</a>
        </div>
    @endif
@endsection
