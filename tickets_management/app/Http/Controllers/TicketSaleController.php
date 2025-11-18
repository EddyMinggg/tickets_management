<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketSale;
use Illuminate\Http\Request;

class TicketSaleController extends Controller
{
    public function create(Ticket $ticket)
    {
        return view('tickets.sales.index', compact('ticket'));
    }

    public function add(Ticket $ticket)
    {
        return view('tickets.sales.create', compact('ticket'));
    }

    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_contact' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'quantity_sold' => 'required|integer|min:1|max:' . $ticket->remaining_quantity,
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|in:HKD,CNY',
            'sale_status' => 'required|in:pending,confirmed,shipped,completed',
            'shipping_address' => 'nullable|string|max:500',
            'shipping_method' => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
            'sale_date' => 'nullable|date',
            'shipped_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['total_revenue'] = $validated['quantity_sold'] * $validated['unit_price'];

        $sale = $ticket->sales()->create($validated);

        // 更新 ticket 的售出數量
        $ticket->increment('sold_quantity', $validated['quantity_sold']);

        return redirect()->route('tickets.sales.create', $ticket)->with('success', '售賣記錄已添加，門票數量已更新');
    }

    public function edit(Ticket $ticket, TicketSale $sale)
    {
        abort_if($sale->ticket_id !== $ticket->id, 403);
        return view('tickets.sales.edit', compact('ticket', 'sale'));
    }

    public function update(Request $request, Ticket $ticket, TicketSale $sale)
    {
        abort_if($sale->ticket_id !== $ticket->id, 403);

        $validated = $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_contact' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'quantity_sold' => 'required|integer|min:1|max:' . ($ticket->remaining_quantity + $sale->quantity_sold),
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|in:HKD,CNY',
            'sale_status' => 'required|in:pending,confirmed,shipped,completed',
            'shipping_address' => 'nullable|string|max:500',
            'shipping_method' => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
            'sale_date' => 'nullable|date',
            'shipped_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['total_revenue'] = $validated['quantity_sold'] * $validated['unit_price'];

        // 計算數量變化
        $quantityDifference = $validated['quantity_sold'] - $sale->quantity_sold;
        if ($quantityDifference !== 0) {
            $ticket->increment('sold_quantity', $quantityDifference);
        }

        $sale->update($validated);

        return redirect()->route('tickets.sales.create', $ticket)->with('success', '售賣記錄已更新');
    }

    public function destroy(Ticket $ticket, TicketSale $sale)
    {
        abort_if($sale->ticket_id !== $ticket->id, 403);

        // 恢復售出數量
        $ticket->decrement('sold_quantity', $sale->quantity_sold);

        $sale->delete();
        return redirect()->route('tickets.sales.create', $ticket)->with('success', '售賣記錄已刪除');
    }

    public function updateStatus(Request $request, Ticket $ticket, TicketSale $sale)
    {
        abort_if($sale->ticket_id !== $ticket->id, 403);

        $validated = $request->validate([
            'sale_status' => 'required|in:pending,confirmed,shipped,completed',
            'tracking_number' => 'nullable|string|max:255',
            'shipped_date' => 'nullable|date',
        ]);

        $sale->update($validated);

        return response()->json(['success' => true, 'message' => '狀態已更新']);
    }
}
