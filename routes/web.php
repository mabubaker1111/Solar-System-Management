<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Worker\WorkerController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ClientRequestController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Business\QueryController as BusinessQueryController;
use App\Http\Controllers\Client\QueryController as ClientQueryController;
use App\Http\Controllers\AllDashboardController;
use App\Http\Controllers\Worker\PaymentController;
use App\Http\Controllers\Business\BusinessWorkerController;


// Unified login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Frontend public pages
Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/services', [FrontendController::class, 'services'])->name('frontend.services');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');

// CLIENT ROUTES
Route::prefix('client')->name('client.')->group(function () {

    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/register', [ClientController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [ClientController::class, 'register'])->name('register.submit');

        Route::get('/login', [ClientController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ClientController::class, 'login'])->name('login.submit');
    });

    // Authenticated routes
    Route::middleware(['auth', 'role:client'])->group(function () {
        Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        Route::get('/businesses', [ClientController::class, 'browseBusinesses'])->name('businesses');
        Route::get('/business/{id}', [ClientController::class, 'businessDetails'])->name('business.details');


        Route::get('/notifications', [ClientController::class, 'notifications'])->name('notifications.index');
        Route::post('/notifications/mark-all-read', [ClientController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');
        //query
        Route::get('/query/{business_id}/create', [ClientQueryController::class, 'create'])->name('query.create');
        Route::post('/query/store', [ClientQueryController::class, 'store'])->name('query.store');
        Route::get('/query/{id}', [ClientQueryController::class, 'show'])->name('query.show');


        // Service request routes
        Route::get('/request/service/{id}', [ClientRequestController::class, 'create'])->name('request.service');
        Route::post('/request/service', [ClientRequestController::class, 'store'])->name('request.store');

        // View client requests
        Route::get('/requests', [ClientController::class, 'requests'])->name('requests');

        Route::post('/logout', [ClientController::class, 'logout'])->name('logout');
    });
});

// BUSINESS ROUTES
Route::prefix('business')->name('business.')->group(function () {

    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/register', [BusinessController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [BusinessController::class, 'register'])->name('register.submit');

        Route::get('/login', [BusinessController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [BusinessController::class, 'login'])->name('login.submit');
    });



    // Authenticated business routes
    Route::middleware(['auth', 'role:business'])->group(function () {
        Route::get('/dashboard', [BusinessController::class, 'dashboard'])->name('dashboard');


        // Workers list
        Route::get('/business/workers', [BusinessWorkerController::class, 'index'])
            ->name('business.workers');

        // Show all shifts for all workers
        Route::get('/workers/shifts', [BusinessWorkerController::class, 'allShifts'])
            ->name('workers.shifts');

        // Show form to add a shift
        Route::get('/workers/{worker}/shift/add', [BusinessWorkerController::class, 'addShift'])
            ->name('workers.shift.add');

        // Store new shift
        Route::post('/workers/{worker}/shifts', [BusinessWorkerController::class, 'storeShift'])
            ->name('workers.shifts.store');

        // Edit a shift
        Route::get('/workers/shift/{shift}/edit', [BusinessWorkerController::class, 'editShift'])
            ->name('workers.shift.edit');

        // Update shift
        Route::put('/business/workers/shift/{id}/update', [BusinessWorkerController::class, 'updateShift'])
            ->name('workers.shift.update');



        Route::delete('/workers/shift/{shift}', [BusinessWorkerController::class, 'deleteShift'])
            ->name('workers.shift.delete');

        // Assign shift to client request
        Route::post('/workers/shift/assign', [BusinessWorkerController::class, 'assignShift'])
            ->name('workers.shifts.assign');

        Route::get('/workers/assign-shift/{requestId}', [BusinessWorkerController::class, 'showAddShiftForm'])
            ->name('workers.assign.shift.form');



        Route::get('/payments', [\App\Http\Controllers\Business\BusinessPaymentController::class, 'index'])->name('payments.index');

        // Update payment status
        Route::post('/payments/{id}/update-status', [\App\Http\Controllers\Business\BusinessPaymentController::class, 'updateStatus'])->name('payments.updateStatus');
        // Add client form
        Route::get('clients/add', [BusinessController::class, 'showAddClientForm'])
            ->name('clients.add');

        // Store client
        Route::post('clients/store', [BusinessController::class, 'storeClient'])
            ->name('clients.store');

        // Route::get('/clients', [BusinessController::class, 'clientsList'])->name('clients.list');

        Route::get('/business/workers', [BusinessController::class, 'workers'])->name('business.workers');

        //test

        Route::get('/business/workers', [App\Http\Controllers\Business\BusinessWorkerController::class, 'index'])
            ->name('business.workers')
            ->middleware('auth', 'business');

        // Complete request
        Route::post('/request/complete/{id}', [BusinessController::class, 'completeRequest'])->name('request.complete');

        // Completed requests page
        Route::get('/completed-requests', [BusinessController::class, 'completedRequests'])->name('completed.requests');

        // Client requests
        Route::get('/client-requests', [BusinessController::class, 'clientRequests'])->name('client.requests');

        Route::get('/notifications', [BusinessController::class, 'notifications'])->name('notifications.index');
        Route::post('/notifications/mark-all-read', [BusinessController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');
        //query
        Route::get('/queries', [BusinessQueryController::class, 'index'])->name('query.index');
        Route::get('/query/{id}', [BusinessQueryController::class, 'show'])->name('query.show');
        Route::post('/query/reply/{id}', [BusinessQueryController::class, 'reply'])->name('query.reply');


        // Approve / Reject POST methods
        Route::post('/request/accept/{id}', [BusinessController::class, 'acceptRequest'])->name('request.accept');
        Route::post('/request/reject/{id}', [BusinessController::class, 'rejectRequest'])->name('request.reject');

        // View assigned requests (business view)
        Route::get('/assigned-requests', [BusinessController::class, 'assignedRequests'])->name('business.assigned.requests');
        // Assign worker
        Route::post('/assign-worker', [BusinessController::class, 'assignWorker'])->name('assign.worker');

        // Workers
        Route::get('/workers', [BusinessController::class, 'workers'])->name('workers');
        Route::get('/workers/requests', [BusinessController::class, 'workersRequests'])->name('workers.requests');
        Route::get('/workers/approve/{id}', [BusinessController::class, 'approveWorker'])->name('workers.approve');
        Route::get('/workers/reject/{id}', [BusinessController::class, 'rejectWorker'])->name('workers.reject');

        // Services
        Route::get('/services', [BusinessController::class, 'services'])->name('services');
        Route::post('/services/add', [BusinessController::class, 'addService'])->name('services.add');
        Route::delete('/services/delete/{id}', [BusinessController::class, 'deleteService'])->name('services.delete');
        Route::get('/services/edit/{id}', [BusinessController::class, 'editService'])->name('services.edit');
        Route::put('/services/update/{id}', [BusinessController::class, 'updateService'])->name('services.update');

        Route::post('/logout', [BusinessController::class, 'logout'])->name('logout');
    });
});

// WORKER ROUTES
Route::prefix('worker')->name('worker.')->group(function () {

    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/register', [WorkerController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [WorkerController::class, 'register'])->name('register.submit');

        Route::get('/login', [WorkerController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [WorkerController::class, 'login'])->name('login.submit');
    });

    // Authenticated routes
    Route::middleware(['auth', 'role:worker'])->group(function () {




        Route::post('/worker/payments/{service_request}/store', [PaymentController::class, 'store'])->name('worker.payments.store');

        // Payments index
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/{service_request}/store', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/my-requests', [WorkerController::class, 'myRequests'])->name('my_requests');
        Route::post('/worker/request/{id}/complete', [WorkerController::class, 'completeRequest'])->name('worker.request.complete');


        Route::get('/completed-requests', [WorkerController::class, 'completedRequests'])
            ->name('completed.requests');

        Route::post('/worker/request/{id}/complete', [WorkerController::class, 'completeRequest'])->name('worker.request.complete');

        Route::post('request/{id}/complete', [WorkerController::class, 'completeRequest'])->name('request.complete');
        // Route::get('completed-requests', [WorkerController::class, 'completedRequests'])->name('requests.completed');


        // Accept request
        Route::post('/request/accept/{id}', [\App\Http\Controllers\Worker\WorkerController::class, 'acceptRequest'])->name('request.accept');

        // Cancel request
        Route::post('/request/cancel/{id}', [\App\Http\Controllers\Worker\WorkerController::class, 'cancelRequest'])->name('request.cancel');


        Route::get('/dashboard', [WorkerController::class, 'dashboard'])->name('dashboard');
        Route::get('/notifications', [WorkerController::class, 'notifications'])->name('notifications');

        //Worker my requests route
        Route::get('/my-requests', [WorkerController::class, 'myRequests'])->name('my_requests');

        // Worker profile
        Route::get('/profile/{id}', [WorkerController::class, 'profile'])->name('profile');

        Route::get('/assigned-requests', [WorkerController::class, 'assignedRequests'])->name('assigned.requests');

        Route::post('/logout', [WorkerController::class, 'logout'])->name('logout');
    });
});

// SUPERADMIN ROUTES
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');


    Route::get('/notifications', [SuperAdminController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/mark-all-read', [SuperAdminController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');


    // Complete a client request
    Route::post('/request/complete/{id}', [SuperAdminController::class, 'markRequestComplete'])->name('request.complete');

    // View all completed requests
    Route::get('/requests/completed', [SuperAdminController::class, 'completedRequests'])->name('requests.completed');
    // Clients
    Route::get('/clients', [SuperAdminController::class, 'clients'])->name('clients');
    Route::get('/client/view/{id}', [SuperAdminController::class, 'viewClient'])->name('client.view');
    Route::delete('/client/delete/{id}', [SuperAdminController::class, 'deleteClient'])->name('client.delete');

    // Businesses
    Route::get('/businesses', [SuperAdminController::class, 'businesses'])->name('businesses');
    Route::get('/business/view/{id}', [SuperAdminController::class, 'viewBusiness'])->name('business.view');
    Route::delete('/business/delete/{id}', [SuperAdminController::class, 'deleteBusiness'])->name('business.delete');

    // Pending Businesses
    Route::get('/businesses/pending', [SuperAdminController::class, 'pendingBusinesses'])->name('businesses.pending');
    Route::post('/business/approve/{id}', [SuperAdminController::class, 'approveBusiness'])->name('business.approve');
    Route::post('/business/reject/{id}', [SuperAdminController::class, 'rejectBusiness'])->name('business.reject');

    // Workers
    Route::get('/workers', [SuperAdminController::class, 'workers'])->name('workers');
    Route::post('/worker/approve/{id}', [SuperAdminController::class, 'approveWorker'])->name('worker.approve');
    Route::post('/worker/reject/{id}', [SuperAdminController::class, 'rejectWorker'])->name('worker.reject');

    // Requests
    Route::get('/requests/clients', [SuperAdminController::class, 'clientRequests'])->name('requests.client');
    Route::get('/requests/workers', [SuperAdminController::class, 'workerRequests'])->name('requests.worker');

    // Logout
    Route::post('/logout', [SuperAdminController::class, 'logout'])->name('logout');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/alldashboard', [AllDashboardController::class, 'index'])->name('alldashboard.index');
});
