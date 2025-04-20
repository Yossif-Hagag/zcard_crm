<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\RnewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrintingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\MassengerController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('addresses', AddressController::class);
        Route::resource('cards', CardController::class);
        Route::resource('users', UserController::class);
        // Route::resource('statuses', StatusController::class);
        Route::resource('stages', StageController::class);
        Route::resource('sources', SourceController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('comments', CommentController::class);
        Route::resource('contracts', ContractController::class);
        Route::resource('deals', DealController::class);
        Route::get('deal/archive', [DealController::class, 'archive'])->name('deals.archive');
        // Route::post('/deals/archive', [DealController::class, 'archiveall'])->name('deals.archive.all');
        Route::post('deals/{lead}/store', [DealController::class, 'store'])->name('deals.store');
        Route::post('deals/{deal}/restore', [DealController::class, 'restore'])->name('deals.restore');
        Route::post('deals/{deal}/force-delete', [DealController::class, 'forceDelete'])->name('deals.forceDelete');


        Route::resource('leads', LeadController::class);
        Route::get('/archive', [LeadController::class, 'archive'])->name('leads.archive');
        Route::post('/leads/archive', [LeadController::class, 'archiveall'])->name('leads.archive.all');
        Route::post('leads/{lead}/restore', [LeadController::class, 'restore'])->name('leads.restore');
        Route::post('leads/{lead}/force-delete', [LeadController::class, 'forceDelete'])->name('leads.forceDelete');
        Route::put('leads/{lead}/update-users', [LeadController::class, 'updateUsers'])->name('leads.update-users');
        Route::patch('/deals/{id}/update-status', [DealController::class, 'updateStatus'])->name('deals.updateStatus');
        Route::post('/leads/convert', [LeadController::class, 'convertLeads'])->name('leads.convert');



        Route::post('/Delay/{id}', [ShippingController::class, 'Delay'])->name('Delay');
        Route::get('/export', [LeadController::class, 'export'])->name('export');
        Route::get('/printing/export', [PrintingController::class, 'export'])->name('Printing.export');
        Route::post('/import', [LeadController::class, 'import'])->name('import');
        Route::get('/leads_download_template', [LeadController::class, 'download_template'])->name('leads_download_template');
        //printings
        Route::resource('printings', PrintingController::class);
        Route::post('printings/{print}/to_print', [PrintingController::class, 'to_print'])->name('printings.to_print');
        Route::post('printings/{print}/to_sent', [PrintingController::class, 'to_sent'])->name('printings.to_sent');
        Route::post('printings/{print}/{print_card}/to_confirm', [PrintingController::class, 'to_confirm'])->name('printings.to_confirm');
        Route::post('printings/{print}/update_code', [PrintingController::class, 'update_code'])->name('printings.update_code');
        Route::post('printings/{printcard}/returncancel', [PrintingController::class, 'returncancel'])->name('printings.returncancel');
        //shipping
        Route::resource('shippings', ShippingController::class);
        Route::post('shippings/{shipping}/save_delvery_boy', [ShippingController::class, 'save_delvery_boy'])->name('shippings.save_delvery_boy');
        Route::post('shippings/{shipping}/update_delvery_boy', [ShippingController::class, 'update_delvery_boy'])->name('shippings.update_delvery_boy');
        Route::post('shippings/{shipping}/change_status', [ShippingController::class, 'change_status'])->name('shippings.change_status');
        Route::post('shippings/{shipping}/reason_reject', [ShippingController::class, 'reason_reject'])->name('shippings.reason_reject');
        //pdf
        Route::get('/generate-pdf/{shipping}', [pdfController::class, 'generatePdf'])->name('generatePdf');
        //chat
        Route::resource('chats', MassengerController::class);
        //todo
        Route::resource('todos', TodoController::class);
        //accounting
        Route::resource('accounting', AccountingController::class);
        //Renew
        Route::resource('renew', RnewController::class);
        //income
        Route::get('income', [AccountingController::class,'income'])->name('income');
    });

