@extends('layouts.app')

@section('title', '門票列表')

@section('content')
    <div class="page-header">
        <h2 class="page-title">🎫 我的門票</h2>
    </div>

    <div class="action-grid">
        <a href="{{ route('tickets.purchase') }}" class="action-card primary">
            <div class="action-icon">➕</div>
            <div class="action-text">購入門票</div>
        </a>
        <a href="{{ route('tickets.purchase.batch') }}" class="action-card primary">
            <div class="action-icon">📦</div>
            <div class="action-text">批量購入</div>
        </a>
        <a href="{{ route('tickets.records') }}" class="action-card secondary">
            <div class="action-icon">📝</div>
            <div class="action-text">交易記錄</div>
        </a>
        <a href="{{ route('tickets.statistics') }}" class="action-card secondary">
            <div class="action-icon">📊</div>
            <div class="action-text">統計信息</div>
        </a>
    </div>

    @if($tickets->count() > 0)
        <div class="ticket-list">
            @foreach($tickets as $ticket)
                <div class="ticket-card">
                    <div class="ticket-header">
                        <div class="ticket-date">
                            <span class="date-icon">📅</span>
                            {{ $ticket->concert_date->format('Y-m-d') }}
                        </div>
                        <div class="ticket-section">{{ $ticket->section }}</div>
                    </div>
                    
                    <div class="ticket-body">
                        <div class="ticket-info-row">
                            <div class="info-item">
                                <span class="info-label">購入價</span>
                                <span class="info-value">HK${{ number_format($ticket->purchase_price, 2) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">手續費</span>
                                <span class="info-value">HK${{ number_format($ticket->commission, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="ticket-info-row">
                            <div class="info-item">
                                <span class="info-label">購入數量</span>
                                <span class="info-value">{{ $ticket->quantity }} 張</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">已賣出</span>
                                <span class="info-value sold">{{ $ticket->sold_quantity }} 張</span>
                            </div>
                        </div>
                        
                        <div class="ticket-summary">
                            <div class="summary-item">
                                <span class="summary-label">剩餘</span>
                                <span class="summary-value remaining">{{ $ticket->quantity - $ticket->sold_quantity }} 張</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">總成本</span>
                                <span class="summary-value total">HK${{ number_format($ticket->purchase_price * $ticket->quantity + $ticket->commission * $ticket->quantity, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ticket-actions">
                        @if($ticket->quantity - $ticket->sold_quantity > 0)
                            <a href="{{ route('tickets.sale', $ticket) }}" class="ticket-btn success">
                                💰 賣出
                            </a>
                        @endif
                        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" style="flex: 1;" id="deleteTicketForm-{{ $ticket->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="ticket-btn danger" onclick="openDeleteTicketModal(document.getElementById('deleteTicketForm-{{ $ticket->id }}'))">
                                🗑️ 刪除
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🎭</div>
            <div class="empty-text">還沒有門票記錄</div>
            <a href="{{ route('tickets.purchase') }}" class="btn btn-primary">立即購入</a>
        </div>
    @endif
@endsection
