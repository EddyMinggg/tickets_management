<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketSourceController;
use App\Http\Controllers\TicketSaleController;

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

// 購入來源管理 - 必須在 {ticket} 之前
Route::get('/{ticket}/sources', [TicketSourceController::class, 'create'])->name('tickets.sources.create');
Route::get('/{ticket}/sources/new', [TicketSourceController::class, 'add'])->name('tickets.sources.add');
Route::post('/{ticket}/sources', [TicketSourceController::class, 'store'])->name('tickets.sources.store');
Route::get('/{ticket}/sources/{source}/edit', [TicketSourceController::class, 'edit'])->name('tickets.sources.edit');
Route::patch('/{ticket}/sources/{source}', [TicketSourceController::class, 'update'])->name('tickets.sources.update');
Route::delete('/{ticket}/sources/{source}', [TicketSourceController::class, 'destroy'])->name('tickets.sources.destroy');

// 售出詳情管理 - 必須在 {ticket}/sale 之前
Route::get('/{ticket}/sales', [TicketSaleController::class, 'create'])->name('tickets.sales.create');
Route::get('/{ticket}/sales/new', [TicketSaleController::class, 'add'])->name('tickets.sales.add');
Route::post('/{ticket}/sales', [TicketSaleController::class, 'store'])->name('tickets.sales.store');
Route::get('/{ticket}/sales/{sale}/edit', [TicketSaleController::class, 'edit'])->name('tickets.sales.edit');
Route::patch('/{ticket}/sales/{sale}', [TicketSaleController::class, 'update'])->name('tickets.sales.update');
Route::patch('/{ticket}/sales/{sale}/status', [TicketSaleController::class, 'updateStatus'])->name('tickets.sales.update.status');
Route::delete('/{ticket}/sales/{sale}', [TicketSaleController::class, 'destroy'])->name('tickets.sales.destroy');

// 賣出流程 - 必須在最後
Route::get('/{ticket}/sale', [TicketController::class, 'createSale'])->name('tickets.sale');
Route::post('/{ticket}/sale', [TicketController::class, 'storeSale'])->name('tickets.store.sale');

// 刪除
Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
