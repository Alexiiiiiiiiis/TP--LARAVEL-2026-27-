<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Connexion / déconnexion
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'loginform'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Espace client (titulaire d'un compte)
|--------------------------------------------------------------------------
*/

Route::middleware('role:client')->group(function () {
    Route::controller(ClientController::class)->group(function () {
        Route::get('/home', 'home')->name('home');
        Route::get('/accounts', 'accounts')->name('accounts');
        Route::get('/statements', 'statements')->name('statements');
        Route::get('/notice', 'notice')->name('notice');
        Route::get('/feedback', 'feedback')->name('feedback');
    });

    // Transfert de fonds : recherche du compte destinataire puis virement
    Route::controller(TransferController::class)->group(function () {
        Route::get('/transfer', 'transfer')->name('transfer');
        Route::get('/transfer/search', 'searchaccount');
        Route::post('/transfer/send', 'sendtransfer');
    });

    // Envoi d'un feedback à la banque
    Route::post('/savefeedback', [FeedbackController::class, 'savefeedback']);
});

/*
|--------------------------------------------------------------------------
| Espace manager
|--------------------------------------------------------------------------
*/

Route::prefix('manager')->middleware('role:manager')->group(function () {
    Route::controller(ManagerController::class)->name('manager.')->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/addaccount', 'addaccount')->name('addaccount');
        Route::get('/feedback', 'feedback')->name('feedback');
    });

    // Comptes clients : création, détails, suppression
    Route::controller(AccountController::class)->group(function () {
        Route::post('/saveaccount', 'saveaccount');
        Route::get('/showaccount/{id}', 'showaccount');
        Route::delete('/deleteaccount/{id}', 'deleteaccount');
    });

    // Caissiers : CRUD
    Route::controller(StaffController::class)->group(function () {
        Route::get('/staff', 'index')->name('manager.staff');
        Route::post('/savecashier', 'savecashier');
        Route::put('/updatecashier/{id}', 'updatecashier');
        Route::delete('/deletecashier/{id}', 'deletecashier');
    });

    // Notifications envoyées à un client
    Route::controller(NoticeController::class)->group(function () {
        Route::get('/notice/{id}', 'noticeform');
        Route::post('/sendnotice/{id}', 'sendnotice');
    });

    // Suppression d'un feedback
    Route::delete('/deletefeedback/{id}', [FeedbackController::class, 'deletefeedback']);
});

/*
|--------------------------------------------------------------------------
| Espace caissier
|--------------------------------------------------------------------------
*/

Route::prefix('cashier')->middleware('role:cashier')->controller(CashierController::class)->group(function () {
    Route::get('/', 'home')->name('cashier.home');
    Route::post('/search', 'searchaccount');
    Route::get('/account/{id}', 'account');
    Route::post('/withdraw/{id}', 'withdraw');
    Route::post('/deposit/{id}', 'deposit');
});
