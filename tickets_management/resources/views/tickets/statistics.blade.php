@extends('layouts.app')

@section('title', '統計信息')

@section('content')
    <div class="section-title">統計信息</div>

    <div style="margin-bottom: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
        <a href="{{ route('tickets.index') }}" class="btn btn-primary">門票管理</a>
        <a href="{{ route('tickets.records') }}" class="btn btn-primary">交易記錄</a>
    </div>

    <div class="stats">
        <div class="stat-card" style="border-left-color: #ff6b6b;">
            <div class="stat-label">總購入額</div>
            <div class="stat-value" style="color: #ff6b6b;">HK${{ number_format($totalPurchaseHKD, 2) }}</div>
        </div>

        <div class="stat-card" style="border-left-color: #51cf66;">
            <div class="stat-label">總賣出額</div>
            <div class="stat-value" style="color: #51cf66;">HK${{ number_format($totalSaleHKD, 2) }}</div>
        </div>

        <div class="stat-card" style="border-left-color: {{ $profit >= 0 ? '#4c6ef5' : '#ff6b6b' }};">
            <div class="stat-label">{{ $profit >= 0 ? '總利潤' : '總虧損' }}</div>
            <div class="stat-value" style="color: {{ $profit >= 0 ? '#4c6ef5' : '#ff6b6b' }};">
                HK${{ number_format(abs($profit), 2) }}
                {{ $profit >= 0 ? '✓' : '✗' }}
            </div>
        </div>
    </div>

    <div style="background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 15px; border-bottom: 2px solid #1a73e8; padding-bottom: 10px;">最近交易</h3>
        
        @if($transactions->count() > 0)
            <div class="table-wrapper">
                <table>
                <thead>
                    <tr>
                        <th>演唱會日期</th>
                        <th>日期時間</th>
                        <th>座位區域</th>
                        <th>類型</th>
                        <th>數量</th>
                        <th>單價</th>
                        <th>幣種</th>
                        <th>折合港幣</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions->take(10) as $transaction)
                        <tr style="background-color: {{ $transaction->type === 'purchase' ? '#fffbea' : '#f1fce4' }};">
                            <td>{{ $transaction->concert_date->format('Y-m-d') }}</td>
                            <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                            <td><strong>{{ $transaction->section }}</strong></td>
                            <td>
                                <span class="badge" style="padding: 5px 10px; border-radius: 3px; font-weight: bold; color: white; background-color: {{ $transaction->type === 'purchase' ? '#ff6b6b' : '#51cf66' }};">
                                    {{ $transaction->type === 'purchase' ? '購入' : '賣出' }}
                                </span>
                            </td>
                            <td>{{ $transaction->quantity }} 張</td>
                            <td>
                                @if($transaction->currency === 'HKD')
                                    HK${{ number_format($transaction->price, 2) }}
                                @else
                                    ¥{{ number_format($transaction->price, 2) }}
                                @endif
                            </td>
                            <td>{{ $transaction->currency === 'HKD' ? '港幣' : '人民幣' }}</td>
                            <td><strong>HK${{ number_format($transaction->total_hkd, 2) }}</strong></td>
                            <td>
                                <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" style="display:inline;" id="deleteTransactionForm-{{ $transaction->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteTransactionModal(document.getElementById('deleteTransactionForm-{{ $transaction->id }}'))">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted">暫無交易記錄</p>
        @endif
    </div>

    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px;">
        <h3 style="margin-bottom: 10px;">統計摘要</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 8px;">📊 <strong>購入交易數：</strong> {{ $transactions->where('type', 'purchase')->count() }} 筆</li>
            <li style="margin-bottom: 8px;">💰 <strong>賣出交易數：</strong> {{ $transactions->where('type', 'sale')->count() }} 筆</li>
            <li style="margin-bottom: 8px;">📈 <strong>平均購入價：</strong> HK${{ $transactions->where('type', 'purchase')->count() > 0 ? number_format($totalPurchaseHKD / $transactions->where('type', 'purchase')->count(), 2) : '0.00' }}</li>
            <li>📉 <strong>平均賣出價：</strong> HK${{ $transactions->where('type', 'sale')->count() > 0 ? number_format($totalSaleHKD / $transactions->where('type', 'sale')->count(), 2) : '0.00' }}</li>
        </ul>
    </div>
@endsection
