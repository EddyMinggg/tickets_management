@extends('layouts.app')

@section('title', '交易記錄')

@section('content')
    <div class="section-title">交易記錄</div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('tickets.index') }}" class="btn btn-primary">門票管理</a>
        <a href="{{ route('tickets.statistics') }}" class="btn btn-primary">統計信息</a>
    </div>

    @if($transactions->count() > 0)
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
                @foreach($transactions as $transaction)
                    <tr style="background-color: {{ $transaction->type === 'purchase' ? '#fff3cd' : '#d4edda' }};">
                        <td>{{ $transaction->concert_date->format('Y-m-d') }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
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

        <div style="margin-top: 20px; text-align: center;">
            {{ $transactions->links() }}
        </div>
    @else
        <p class="text-center text-muted">暫無交易記錄</p>
    @endif
@endsection
