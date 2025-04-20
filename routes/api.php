<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DealController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\CardLeadsController;
use App\Http\Controllers\Api\UserLeadsController;
use App\Http\Controllers\Api\UserDealsController;
use App\Http\Controllers\Api\DealUsersController;
use App\Http\Controllers\Api\LeadDealsController;
use App\Http\Controllers\Api\LeadUsersController;
use App\Http\Controllers\Api\UserOrdersController;
use App\Http\Controllers\Api\StageLeadsController;
use App\Http\Controllers\Api\OrderUsersController;
use App\Http\Controllers\Api\LeadOrdersController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\AddressLeadsController;
use App\Http\Controllers\Api\AddressUsersController;
use App\Http\Controllers\Api\UserCommentsController;
use App\Http\Controllers\Api\StatusOrdersController;
use App\Http\Controllers\Api\CommentLeadsController;
use App\Http\Controllers\Api\LeadCommentsController;
use App\Http\Controllers\Api\UserAddressesController;
use App\Http\Controllers\Api\ContractLeadsController;
use App\Http\Controllers\Api\LeadAddressesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('addresses', AddressController::class);

        // Address Leads
        Route::get('/addresses/{address}/leads', [
            AddressLeadsController::class,
            'index',
        ])->name('addresses.leads.index');
        Route::post('/addresses/{address}/leads/{lead}', [
            AddressLeadsController::class,
            'store',
        ])->name('addresses.leads.store');
        Route::delete('/addresses/{address}/leads/{lead}', [
            AddressLeadsController::class,
            'destroy',
        ])->name('addresses.leads.destroy');

        // Address Users
        Route::get('/addresses/{address}/users', [
            AddressUsersController::class,
            'index',
        ])->name('addresses.users.index');
        Route::post('/addresses/{address}/users/{user}', [
            AddressUsersController::class,
            'store',
        ])->name('addresses.users.store');
        Route::delete('/addresses/{address}/users/{user}', [
            AddressUsersController::class,
            'destroy',
        ])->name('addresses.users.destroy');

        Route::apiResource('cards', CardController::class);

        // Card Leads
        Route::get('/cards/{card}/leads', [
            CardLeadsController::class,
            'index',
        ])->name('cards.leads.index');
        Route::post('/cards/{card}/leads', [
            CardLeadsController::class,
            'store',
        ])->name('cards.leads.store');

        Route::apiResource('users', UserController::class);

        // User Comments
        Route::get('/users/{user}/comments', [
            UserCommentsController::class,
            'index',
        ])->name('users.comments.index');
        Route::post('/users/{user}/comments', [
            UserCommentsController::class,
            'store',
        ])->name('users.comments.store');

        // User Leads
        Route::get('/users/{user}/leads', [
            UserLeadsController::class,
            'index',
        ])->name('users.leads.index');
        Route::post('/users/{user}/leads/{lead}', [
            UserLeadsController::class,
            'store',
        ])->name('users.leads.store');
        Route::delete('/users/{user}/leads/{lead}', [
            UserLeadsController::class,
            'destroy',
        ])->name('users.leads.destroy');

        // User Deals
        Route::get('/users/{user}/deals', [
            UserDealsController::class,
            'index',
        ])->name('users.deals.index');
        Route::post('/users/{user}/deals/{deal}', [
            UserDealsController::class,
            'store',
        ])->name('users.deals.store');
        Route::delete('/users/{user}/deals/{deal}', [
            UserDealsController::class,
            'destroy',
        ])->name('users.deals.destroy');

        

        // User Addresses
        Route::get('/users/{user}/addresses', [
            UserAddressesController::class,
            'index',
        ])->name('users.addresses.index');
        Route::post('/users/{user}/addresses/{address}', [
            UserAddressesController::class,
            'store',
        ])->name('users.addresses.store');
        Route::delete('/users/{user}/addresses/{address}', [
            UserAddressesController::class,
            'destroy',
        ])->name('users.addresses.destroy');

        Route::apiResource('statuses', StatusController::class);

        // Status Orders
        Route::get('/statuses/{status}/orders', [
            StatusOrdersController::class,
            'index',
        ])->name('statuses.orders.index');
        Route::post('/statuses/{status}/orders', [
            StatusOrdersController::class,
            'store',
        ])->name('statuses.orders.store');

        Route::apiResource('stages', StageController::class);

        // Stage Leads
        Route::get('/stages/{stage}/leads', [
            StageLeadsController::class,
            'index',
        ])->name('stages.leads.index');
        Route::post('/stages/{stage}/leads', [
            StageLeadsController::class,
            'store',
        ])->name('stages.leads.store');

        Route::apiResource('orders', OrderController::class);

        // Order Users
        Route::get('/orders/{order}/users', [
            OrderUsersController::class,
            'index',
        ])->name('orders.users.index');
        Route::post('/orders/{order}/users/{user}', [
            OrderUsersController::class,
            'store',
        ])->name('orders.users.store');
        Route::delete('/orders/{order}/users/{user}', [
            OrderUsersController::class,
            'destroy',
        ])->name('orders.users.destroy');

        Route::apiResource('comments', CommentController::class);

        // Comment Leads
        Route::get('/comments/{comment}/leads', [
            CommentLeadsController::class,
            'index',
        ])->name('comments.leads.index');
        Route::post('/comments/{comment}/leads/{lead}', [
            CommentLeadsController::class,
            'store',
        ])->name('comments.leads.store');
        Route::delete('/comments/{comment}/leads/{lead}', [
            CommentLeadsController::class,
            'destroy',
        ])->name('comments.leads.destroy');

        Route::apiResource('contracts', ContractController::class);

        // Contract Leads
        Route::get('/contracts/{contract}/leads', [
            ContractLeadsController::class,
            'index',
        ])->name('contracts.leads.index');
        Route::post('/contracts/{contract}/leads', [
            ContractLeadsController::class,
            'store',
        ])->name('contracts.leads.store');

        Route::apiResource('deals', DealController::class);

        // Deal Users
        Route::get('/deals/{deal}/users', [
            DealUsersController::class,
            'index',
        ])->name('deals.users.index');
        Route::post('/deals/{deal}/users/{user}', [
            DealUsersController::class,
            'store',
        ])->name('deals.users.store');
        Route::delete('/deals/{deal}/users/{user}', [
            DealUsersController::class,
            'destroy',
        ])->name('deals.users.destroy');

        Route::apiResource('leads', LeadController::class);

        // Lead Deals
        Route::get('/leads/{lead}/deals', [
            LeadDealsController::class,
            'index',
        ])->name('leads.deals.index');
        Route::post('/leads/{lead}/deals', [
            LeadDealsController::class,
            'store',
        ])->name('leads.deals.store');

        // Lead Orders
        Route::get('/leads/{lead}/orders', [
            LeadOrdersController::class,
            'index',
        ])->name('leads.orders.index');
        Route::post('/leads/{lead}/orders', [
            LeadOrdersController::class,
            'store',
        ])->name('leads.orders.store');

        // Lead Comments
        Route::get('/leads/{lead}/comments', [
            LeadCommentsController::class,
            'index',
        ])->name('leads.comments.index');
        Route::post('/leads/{lead}/comments/{comment}', [
            LeadCommentsController::class,
            'store',
        ])->name('leads.comments.store');
        Route::delete('/leads/{lead}/comments/{comment}', [
            LeadCommentsController::class,
            'destroy',
        ])->name('leads.comments.destroy');

        // Lead Users
        Route::get('/leads/{lead}/users', [
            LeadUsersController::class,
            'index',
        ])->name('leads.users.index');
        Route::post('/leads/{lead}/users/{user}', [
            LeadUsersController::class,
            'store',
        ])->name('leads.users.store');
        Route::delete('/leads/{lead}/users/{user}', [
            LeadUsersController::class,
            'destroy',
        ])->name('leads.users.destroy');

        // Lead Addresses
        Route::get('/leads/{lead}/addresses', [
            LeadAddressesController::class,
            'index',
        ])->name('leads.addresses.index');
        Route::post('/leads/{lead}/addresses/{address}', [
            LeadAddressesController::class,
            'store',
        ])->name('leads.addresses.store');
        Route::delete('/leads/{lead}/addresses/{address}', [
            LeadAddressesController::class,
            'destroy',
        ])->name('leads.addresses.destroy');
    });
