<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ShortGainStatsController;
use App\Http\Controllers\AttendantController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CardAssignmentController;

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
//Clear Cache using routing
Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return response()->json(['message' => 'Optimization cleared successfully']);
});

// Short/Gain Statistics API endpoint
Route::get('/api/short-gain-stats', [ShortGainStatsController::class, 'getStats'])->name('api.short-gain-stats');

Route::get('/', function () {
     if (Auth::check()) {
        // dd('here');
        return redirect()->route('storage.list');
    } else {
        return redirect()->route('login');
    }
   

});
//Maroutes
Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/user/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('user.logout');
    Route::get('storage/index', [App\Http\Controllers\DataStorageController::class, 'index'])->name('storage.index');
    Route::get('storage/create', [App\Http\Controllers\DataStorageController::class, 'create'])->name('storage.create');
    Route::get('storage/list', [App\Http\Controllers\DataStorageController::class, 'shiftList'])->name('storage.list');
    Route::get('storage/edit/{id}', [App\Http\Controllers\DataStorageController::class, 'edit'])->name('storage.edit');
    Route::post('storage/update/{id}', [App\Http\Controllers\DataStorageController::class, 'update'])->name('storage.update');
    Route::post('storage/csv', [App\Http\Controllers\DataStorageController::class,'importCsv'])->name('storage.import');
    //delete route using GET method
    Route::get('storage/delete/{id}', [App\Http\Controllers\DataStorageController::class, 'delete'])->name('storage.delete');
    //show route using GET method
    Route::post('drops/massdelete', [App\Http\Controllers\DataStorageController::class, 'massDeleteDrops'])->name('drops.mass-delete');

    //attendant
    Route::get('attendant/index', [App\Http\Controllers\AttendantController::class, 'index'])->name('attendant.index');
    Route::get('attendant/create', [App\Http\Controllers\AttendantController::class, 'create'])->name('attendant.create');
    Route::post('attendant/store', [App\Http\Controllers\AttendantController::class, 'store'])->name('attendant.store');
    Route::get('attendant/edit/{id}', [App\Http\Controllers\AttendantController::class, 'edit'])->name('attendant.edit');
    Route::post('attendant/update/{id}', [App\Http\Controllers\AttendantController::class, 'update'])->name('attendant.update');
    Route::get('attendant/delete/{id}', [App\Http\Controllers\AttendantController::class, 'delete'])->name('attendant.delete');
    Route::get('/attendants/{id}', [App\Http\Controllers\AttendantController::class, 'show'])->name('attendant.show');
    Route::get('attendant/performance', [App\Http\Controllers\AttendantController::class, 'attendantPerformance'])->name('attendant.performance');
    //transactions create, store and edit routes
    Route::get('transaction/index', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
    Route::get('transaction/create', [App\Http\Controllers\TransactionController::class, 'create'])->name('transaction.create');
    Route::post('transaction/store', [App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');
    Route::get('transaction/edit/{id}', [App\Http\Controllers\TransactionController::class, 'edit'])->name('transaction.edit');
    Route::post('transaction/update/{id}', [App\Http\Controllers\TransactionController::class, 'update'])->name('transaction.update');
    Route::get('transaction/delete/{id}', [App\Http\Controllers\TransactionController::class, 'delete'])->name('transaction.delete');
  
    Route::post('add-coin/{id}', [App\Http\Controllers\TransactionController::class, 'addCoin'])->name('add-coin');
    Route::post('add-recovery/{id}', [App\Http\Controllers\TransactionController::class, 'addRecovery'])->name('add-recovery');
    //get attendants in a transaction when shift and date is selected
    Route::get('transaction/getAttendants', [App\Http\Controllers\TransactionController::class, 'getAttendants'])->name('transaction.getAttendants');

    //get Attendee Total
    Route::get('/getShortGainData', [\App\Http\Controllers\HomeController::class,'getShortGainData']);
    Route::get('/getTotalForAttendee', [App\Http\Controllers\TransactionController::class, 'getTotalForAttendee'])->name('transaction.getTotalForAttendee');
    Route::get('/datastorage/{attendantId}/{shift}/{date}', [App\Http\Controllers\TransactionController::class, 'showDataStorage'])->name('showDataStorage');
    Route::get('/drop/{attendantId}/{TransactionDate}', [App\Http\Controllers\TransactionController::class, 'showAttendantDrops'])->name('showAttendantDrops');
    // Route::get('/drop/{attendantId}', [App\Http\Controllers\TransactionController::class, 'showAttendantDrops'])->name('showAttendantDrops');
    Route::get('/report/recoveries/{transaction_id}', [App\Http\Controllers\TransactionController::class, "showRecoveries"])->name('showRecoveries');
    Route::post('records/massdelete', [App\Http\Controllers\TransactionController::class, 'massDeleteRecords'])->name('records.mass-delete');

    //Reports
    Route::get('/shift/report', [App\Http\Controllers\ShiftsReportController::class, 'shiftsReport'])->name('reports.transactions');
    Route::get('/shifts/export/{format}', [App\Http\Controllers\ShiftsReportController::class, 'export'])->name('shifts.export');
    Route::get('/periodic/report', [App\Http\Controllers\ShiftsReportController::class, 'shiftsReportTwo'])->name('reports.periodic');

    //users routes
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/show', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::post('users/{id}/update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('users/{id}/destroy', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    //profile
    Route::post('change/password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change.password');
    Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('profile', [App\Http\Controllers\UserController::class, 'update_profile'])->name('profile.update');

    //Short & Gains
    Route::get('differences', [App\Http\Controllers\RecoveryController::class, 'index'])->name('attendants.difference');
    Route::get('{attendantId}/differences', [App\Http\Controllers\RecoveryController::class, 'showAttendantDifferences'])->name('show.attendant.differences');
    Route::get('{transactionId}/record', [App\Http\Controllers\RecoveryController::class, 'showAttendantCashierRecord'])->name('show.attendant.record');

    Route::get('/api/short-gain-stats', [ShortGainStatsController::class, 'getStats'])->name('api.short-gain-stats');

    Route::resource('attendant', AttendantController::class);
    Route::resource('card', CardController::class)->except(['show']);
    Route::resource('card-assignment', CardAssignmentController::class)->except(['show']);
});
Auth::routes();



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
