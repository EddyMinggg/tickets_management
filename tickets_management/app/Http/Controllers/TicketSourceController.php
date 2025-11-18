<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketSource;
use Illuminate\Http\Request;

class TicketSourceController extends Controller
{
    public function create(Ticket $ticket)
    {
        return view('tickets.sources.index', compact('ticket'));
    }

    public function add(Ticket $ticket)
    {
        return view('tickets.sources.create', compact('ticket'));
    }

    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'seller_name' => 'required|string|max:255',
            'seller_contact' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'quantity_purchased' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|in:HKD,CNY',
            'notes' => 'nullable|string',
        ]);

        $validated['total_cost'] = $validated['quantity_purchased'] * $validated['unit_price'];

        $ticket->sources()->create($validated);

        return redirect()->route('tickets.sources.create', $ticket)->with('success', '購入來源已添加');
    }

    public function edit(Ticket $ticket, TicketSource $source)
    {
        abort_if($source->ticket_id !== $ticket->id, 403);
        return view('tickets.sources.edit', compact('ticket', 'source'));
    }

    public function update(Request $request, Ticket $ticket, TicketSource $source)
    {
        abort_if($source->ticket_id !== $ticket->id, 403);

        $validated = $request->validate([
            'seller_name' => 'required|string|max:255',
            'seller_contact' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'quantity_purchased' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|in:HKD,CNY',
            'notes' => 'nullable|string',
        ]);

        $validated['total_cost'] = $validated['quantity_purchased'] * $validated['unit_price'];

        $source->update($validated);

        return redirect()->route('tickets.sources.create', $ticket)->with('success', '購入來源已更新');
    }

    public function destroy(Ticket $ticket, TicketSource $source)
    {
        abort_if($source->ticket_id !== $ticket->id, 403);
        $source->delete();
        return redirect()->route('tickets.sources.create', $ticket)->with('success', '購入來源已刪除');
    }
}
