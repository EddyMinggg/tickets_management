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

// 賣出流程
Route::get('/{ticket}/sale', [TicketController::class, 'createSale'])->name('tickets.sale');
Route::post('/{ticket}/sale', [TicketController::class, 'storeSale'])->name('tickets.store.sale');

// 購入來源管理
Route::get('/{ticket}/sources', [TicketSourceController::class, 'create'])->name('tickets.sources.create');
Route::post('/{ticket}/source', [TicketSourceController::class, 'store'])->name('tickets.sources.store');
Route::get('/{ticket}/source/new', [TicketSourceController::class, 'add'])->name('tickets.sources.add');
Route::get('/{ticket}/source/{source}/edit', [TicketSourceController::class, 'edit'])->name('tickets.sources.edit');
Route::patch('/{ticket}/source/{source}', [TicketSourceController::class, 'update'])->name('tickets.sources.update');
Route::delete('/{ticket}/source/{source}', [TicketSourceController::class, 'destroy'])->name('tickets.sources.destroy');

// 售出詳情管理
Route::get('/{ticket}/sales', [TicketSaleController::class, 'create'])->name('tickets.sales.create');
Route::post('/{ticket}/sale-detail', [TicketSaleController::class, 'store'])->name('tickets.sales.store');
Route::get('/{ticket}/sale-detail/new', [TicketSaleController::class, 'add'])->name('tickets.sales.add');
Route::get('/{ticket}/sale-detail/{sale}/edit', [TicketSaleController::class, 'edit'])->name('tickets.sales.edit');
Route::patch('/{ticket}/sale-detail/{sale}', [TicketSaleController::class, 'update'])->name('tickets.sales.update');
Route::patch('/{ticket}/sale-detail/{sale}/status', [TicketSaleController::class, 'updateStatus'])->name('tickets.sales.update.status');
Route::delete('/{ticket}/sale-detail/{sale}', [TicketSaleController::class, 'destroy'])->name('tickets.sales.destroy');

// 刪除
Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
