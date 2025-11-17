<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

// 顯示門票列表
Route::get('/', [TicketController::class, 'index'])->name('tickets.index');

// 統計和記錄
Route::get('/records', [TicketController::class, 'records'])->name('tickets.records');
Route::get('/statistics', [TicketController::class, 'statistics'])->name('tickets.statistics');
Route::delete('/transaction/{transaction}', [TicketController::class, 'destroyTransaction'])->name('transactions.destroy');

// 購入流程
Route::get('/purchase', [TicketController::class, 'createPurchase'])->name('tickets.purchase');
Route::post('/purchase', [TicketController::class, 'storePurchase'])->name('tickets.store.purchase');

// 批量購入流程
Route::get('/batch-purchase', [TicketController::class, 'createBatchPurchase'])->name('tickets.purchase.batch');
Route::post('/batch-purchase', [TicketController::class, 'storeBatchPurchase'])->name('tickets.store.batch.purchase');

// 賣出流程
Route::get('/{ticket}/sale', [TicketController::class, 'createSale'])->name('tickets.sale');
Route::post('/{ticket}/sale', [TicketController::class, 'storeSale'])->name('tickets.store.sale');

// 刪除
Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
