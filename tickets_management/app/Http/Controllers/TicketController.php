<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * 顯示門票列表
     */
    public function index()
    {
        $tickets = Ticket::orderBy('id', 'desc')->get();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * 顯示購入門票表單
     */
    public function createPurchase()
    {
        return view('tickets.purchase');
    }

    /**
     * 顯示批量購入門票表單
     */
    public function createBatchPurchase()
    {
        return view('tickets.batch-purchase');
    }

    /**
     * 保存購入門票
     */
    public function storePurchase(Request $request)
    {
        $validated = $request->validate([
            'concert_date' => 'required|date',
            'section' => 'required|string|max:50',
            'purchase_price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:1',
            'commission' => 'nullable|numeric|min:0',
        ]);

        $validated['sold_quantity'] = 0;
        $validated['exchange_rate'] = 1.09;
        $validated['commission'] = $validated['commission'] ?? 0;
        $ticket = Ticket::create($validated);

        // 記錄購入交易
        Transaction::create([
            'ticket_id' => $ticket->id,
            'concert_date' => $ticket->concert_date,
            'section' => $ticket->section,
            'type' => 'purchase',
            'quantity' => $validated['quantity'],
            'price' => $validated['purchase_price'],
            'currency' => 'HKD',
            'exchange_rate' => 1.09,
            'total_hkd' => ($validated['purchase_price'] + ($validated['commission'] ?? 0)) * $validated['quantity'],
        ]);

        return redirect()->route('tickets.index')->with('success', '門票已購入');
    }

    /**
     * 批量保存購入門票
     */
    public function storeBatchPurchase(Request $request)
    {
        $validated = $request->validate([
            'concert_date' => 'required|array',
            'concert_date.*' => 'required|date',
            'section' => 'required|array',
            'section.*' => 'required|string|max:50',
            'purchase_price' => 'required|array',
            'purchase_price.*' => 'required|numeric|min:0.01',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'commission' => 'required|array',
            'commission.*' => 'nullable|numeric|min:0',
        ]);

        try {
            $successCount = 0;
            
            // 遍歷每一行數據
            foreach ($validated['concert_date'] as $index => $concertDate) {
                // 跳過空白行
                if (empty($concertDate) || empty($validated['section'][$index])) {
                    continue;
                }

                $ticketData = [
                    'concert_date' => $concertDate,
                    'section' => $validated['section'][$index],
                    'purchase_price' => (float)$validated['purchase_price'][$index],
                    'quantity' => (int)$validated['quantity'][$index],
                    'commission' => (float)($validated['commission'][$index] ?? 0),
                    'sold_quantity' => 0,
                    'exchange_rate' => 1.09,
                ];

                $ticket = Ticket::create($ticketData);

                // 記錄購入交易
                Transaction::create([
                    'ticket_id' => $ticket->id,
                    'concert_date' => $ticket->concert_date,
                    'section' => $ticket->section,
                    'type' => 'purchase',
                    'quantity' => $ticketData['quantity'],
                    'price' => $ticketData['purchase_price'],
                    'currency' => 'HKD',
                    'exchange_rate' => 1.09,
                    'total_hkd' => ($ticketData['purchase_price'] + $ticketData['commission']) * $ticketData['quantity'],
                ]);

                $successCount++;
            }

            if ($successCount === 0) {
                return redirect()->route('tickets.purchase.batch')->with('error', '沒有有效的購入記錄');
            }

            return redirect()->route('tickets.index')->with('success', "成功添加 {$successCount} 筆門票購入記錄");
        } catch (\Exception $e) {
            return redirect()->route('tickets.purchase.batch')->with('error', '批量購入失敗：' . $e->getMessage());
        }
    }

    /**
     * 顯示賣出門票表單
     */
    public function createSale(Ticket $ticket)
    {
        $remaining = $ticket->quantity - $ticket->sold_quantity;
        return view('tickets.sale', compact('ticket', 'remaining'));
    }

    /**
     * 保存賣出門票
     */
    public function storeSale(Request $request, Ticket $ticket)
    {
        $remaining = $ticket->quantity - $ticket->sold_quantity;
        
        $validated = $request->validate([
            'sold_quantity' => 'required|integer|min:1|max:' . $remaining,
            'sale_price' => 'required|numeric|min:0.01',
            'currency' => 'required|in:HKD,CNY',
        ]);

        $ticket->sold_quantity += $validated['sold_quantity'];
        $ticket->save();

        // 計算折合港幣
        $totalHKD = $validated['currency'] === 'HKD' 
            ? $validated['sale_price'] * $validated['sold_quantity']
            : $validated['sale_price'] * $validated['sold_quantity'] * $ticket->exchange_rate;

        // 記錄賣出交易
        Transaction::create([
            'ticket_id' => $ticket->id,
            'concert_date' => $ticket->concert_date,
            'section' => $ticket->section,
            'type' => 'sale',
            'quantity' => $validated['sold_quantity'],
            'price' => $validated['sale_price'],
            'currency' => $validated['currency'],
            'exchange_rate' => $ticket->exchange_rate,
            'total_hkd' => $totalHKD,
        ]);

        return redirect()->route('tickets.index')->with('success', '門票已賣出');
    }

    /**
     * 刪除交易記錄
     */
    public function destroyTransaction(Transaction $transaction)
    {
        $ticket = $transaction->ticket;

        if ($transaction->type === 'purchase') {
            // 刪除購入交易：恢復門票數量
            $ticket->quantity -= $transaction->quantity;
            
            // 如果已賣出數量大於新的購入數量，調整已賣出數量
            if ($ticket->sold_quantity > $ticket->quantity) {
                $ticket->sold_quantity = $ticket->quantity;
            }
        } else {
            // 刪除賣出交易：恢復已賣出數量
            $ticket->sold_quantity -= $transaction->quantity;
        }

        $ticket->save();
        $transaction->delete();

        return redirect()->route('tickets.records')->with('success', '交易記錄已刪除，門票數量已調整');
    }

    /**
     * 刪除門票
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', '門票已刪除');
    }

    /**
     * 顯示交易記錄
     */
    public function records()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(20);
        return view('tickets.records', compact('transactions'));
    }

    /**
     * 顯示統計信息
     */
    public function statistics()
    {
        $totalPurchaseHKD = Transaction::where('type', 'purchase')->sum('total_hkd');
        $totalSaleHKD = Transaction::where('type', 'sale')->sum('total_hkd');
        $profit = $totalSaleHKD - $totalPurchaseHKD;

        $transactions = Transaction::orderBy('created_at', 'desc')->get();

        return view('tickets.statistics', compact('totalPurchaseHKD', 'totalSaleHKD', 'profit', 'transactions'));
    }
}

