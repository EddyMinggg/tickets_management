@extends('layouts.app')

@section('title', '門票列表')

@section('content')
    <div class="section-title">門票管理</div>

    <div style="margin-bottom: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
        <a href="{{ route('tickets.purchase') }}" class="btn btn-success">+ 購入門票</a>
        <a href="{{ route('tickets.purchase.batch') }}" class="btn btn-success">+ 批量購入</a>
        <a href="{{ route('tickets.records') }}" class="btn btn-primary">交易記錄</a>
        <a href="{{ route('tickets.statistics') }}" class="btn btn-primary">統計信息</a>
    </div>

    @if($tickets->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>演唱會日期</th>
                        <th>座位區域</th>
                        <th>購入價格</th>
                        <th>購入數量</th>
                        <th>手續費</th>
                        <th>已賣出</th>
                        <th>剩餘數量</th>
                        <th>人民幣匯率</th>
                        <th>總購入價格</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->concert_date->format('Y-m-d') }}</td>
                            <td><strong>{{ $ticket->section }}</strong></td>
                            <td>HK${{ number_format($ticket->purchase_price, 2) }}</td>
                            <td>{{ $ticket->quantity }}</td>
                            <td>HK${{ number_format($ticket->commission, 2) }}</td>
                            <td>{{ $ticket->sold_quantity }}</td>
                            <td><strong>{{ $ticket->quantity - $ticket->sold_quantity }}</strong></td>
                            <td>{{ number_format($ticket->exchange_rate, 4) }}</td>
                            <td>HK${{ number_format($ticket->purchase_price * $ticket->quantity + $ticket->commission * $ticket->quantity, 2) }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if($ticket->quantity - $ticket->sold_quantity > 0)
                                        <a href="{{ route('tickets.sale', $ticket) }}" class="btn btn-success">賣出</a>
                                    @endif
                                    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" style="display:inline;" id="deleteTicketForm-{{ $ticket->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="openDeleteTicketModal(document.getElementById('deleteTicketForm-{{ $ticket->id }}'))">刪除</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-muted">暫無門票記錄</p>
    @endif
@endsection
