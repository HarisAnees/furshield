<?php

use App\Http\Controllers\Admin\AdminAdoptionController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\Admin\AdminHealthRecordController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPetController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\OwnerPortalController;
use App\Http\Controllers\ShelterPortalController;
use App\Http\Controllers\VetPortalController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Frontend Routes (Matching 16 Design Panels)
|--------------------------------------------------------------------------
*/
Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/about', [WebController::class, 'about'])->name('about');

// Pets
Route::get('/pets', [WebController::class, 'pets'])->name('pets.index');
Route::post('/pets', [WebController::class, 'storePet'])->name('pets.store');
Route::get('/pets/{pet}', [WebController::class, 'petDetail'])->name('pets.show');

// Appointments
Route::get('/appointments', [WebController::class, 'appointments'])->name('appointments.index');
Route::post('/appointments/book', [WebController::class, 'bookAppointment'])->name('appointments.book');

// Adoptions
Route::get('/adoption', [WebController::class, 'adoption'])->name('adoption.index');
Route::post('/adoption/{adoption}/apply', [WebController::class, 'applyAdoption'])->name('adoption.apply');

// Products & E-Commerce
Route::get('/products', [WebController::class, 'products'])->name('products.index');
Route::get('/cart', [WebController::class, 'cart'])->name('cart.index');
Route::post('/cart/add/{product}', [WebController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [WebController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{product}', [WebController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [WebController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/process', [WebController::class, 'processCheckout'])->name('checkout.process');

// Pet Care & Guides
Route::get('/care-tips', [WebController::class, 'careTips'])->name('care-tips.index');

// Contact & Newsletter
Route::get('/contact', [WebController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [WebController::class, 'submitContact'])->name('contact.submit');
Route::post('/newsletter/subscribe', [WebController::class, 'newsletter'])->name('contact.newsletter');
Route::post('/newsletter', [WebController::class, 'newsletter'])->name('newsletter.subscribe');


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Role 1: Platform Administrator Dashboard (Strictly role:admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('users.toggle');

    // Pets
    Route::get('/pets', [AdminPetController::class, 'index'])->name('pets.index');
    Route::post('/pets', [AdminPetController::class, 'store'])->name('pets.store');
    Route::put('/pets/{pet}', [AdminPetController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet}', [AdminPetController::class, 'destroy'])->name('pets.destroy');

    // Appointments
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [AdminAppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::delete('/appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Health Records
    Route::get('/health-records', [AdminHealthRecordController::class, 'index'])->name('health-records.index');
    Route::post('/health-records', [AdminHealthRecordController::class, 'store'])->name('health-records.store');
    Route::delete('/health-records/{healthRecord}', [AdminHealthRecordController::class, 'destroy'])->name('health-records.destroy');

    // Adoptions
    Route::get('/adoptions', [AdminAdoptionController::class, 'index'])->name('adoptions.index');
    Route::post('/adoptions', [AdminAdoptionController::class, 'store'])->name('adoptions.store');
    Route::patch('/adoptions/{adoption}/status', [AdminAdoptionController::class, 'updateStatus'])->name('adoptions.status');
    Route::delete('/adoptions/{adoption}', [AdminAdoptionController::class, 'destroy'])->name('adoptions.destroy');

    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Care Content
    Route::get('/content', [AdminContentController::class, 'index'])->name('content.index');
    Route::post('/content', [AdminContentController::class, 'store'])->name('content.store');
    Route::put('/content/{content}', [AdminContentController::class, 'update'])->name('content.update');
    Route::post('/content/{content}/toggle', [AdminContentController::class, 'togglePublish'])->name('content.toggle');
    Route::delete('/content/{content}', [AdminContentController::class, 'destroy'])->name('content.destroy');

    // Notifications
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');

    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});


/*
|--------------------------------------------------------------------------
| Role 2: Pet Owner Dashboard & Portal (Strictly role:owner)
|--------------------------------------------------------------------------
*/
Route::prefix('owner')->name('owner.')->middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/', OwnerDashboardController::class)->name('dashboard');

    // Connected Portal Pages
    Route::get('/pets', [OwnerPortalController::class, 'pets'])->name('pets');
    Route::post('/pets', [OwnerPortalController::class, 'storePet'])->name('pets.store');
    Route::delete('/pets/{pet}', [OwnerPortalController::class, 'deletePet'])->name('pets.delete');

    Route::get('/appointments', [OwnerPortalController::class, 'appointments'])->name('appointments');
    Route::post('/appointments', [OwnerPortalController::class, 'bookAppointment'])->name('appointments.book');
    Route::post('/appointments/{appointment}/cancel', [OwnerPortalController::class, 'cancelAppointment'])->name('appointments.cancel');

    Route::get('/health-records', [OwnerPortalController::class, 'healthRecords'])->name('health-records');

    Route::get('/products', [OwnerPortalController::class, 'products'])->name('products');
    Route::post('/products/{product}/buy', [OwnerPortalController::class, 'buyProduct'])->name('products.buy');

    Route::get('/care-tips', [OwnerPortalController::class, 'careTips'])->name('care-tips');
    Route::get('/notifications', [OwnerPortalController::class, 'notifications'])->name('notifications');
    Route::get('/profile', [OwnerPortalController::class, 'profile'])->name('profile');
    Route::post('/profile', [OwnerPortalController::class, 'updateProfile'])->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| Role 3: Veterinarian / Clinical Portal (Strictly role:vet)
|--------------------------------------------------------------------------
*/
Route::prefix('vet')->name('vet.')->middleware(['auth', 'role:vet'])->group(function () {
    Route::get('/', [VetPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [VetPortalController::class, 'appointments'])->name('appointments');
    Route::patch('/appointments/{appointment}/status', [VetPortalController::class, 'updateAppointmentStatus'])->name('appointments.status');
    Route::post('/appointments/{appointment}/treatment', [VetPortalController::class, 'logTreatment'])->name('appointments.treatment');
    Route::get('/patient-history/{pet}', [VetPortalController::class, 'medicalHistory'])->name('patients.history');
    Route::get('/profile', [VetPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [VetPortalController::class, 'updateProfile'])->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| Role 4: Animal Shelter Sanctuary Portal (Strictly role:shelter)
|--------------------------------------------------------------------------
*/
Route::prefix('shelter')->name('shelter.')->middleware(['auth', 'role:shelter'])->group(function () {
    Route::get('/', [ShelterPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/listings', [ShelterPortalController::class, 'listings'])->name('listings');
    Route::post('/listings', [ShelterPortalController::class, 'storeListing'])->name('listings.store');
    Route::get('/care-logs', [ShelterPortalController::class, 'careLogs'])->name('care-logs');
    Route::post('/care-logs', [ShelterPortalController::class, 'storeCareLog'])->name('care-logs.store');
    Route::get('/applications', [ShelterPortalController::class, 'applications'])->name('applications');
    Route::patch('/applications/{application}/status', [ShelterPortalController::class, 'updateApplicationStatus'])->name('applications.status');
});


/*
|--------------------------------------------------------------------------
| Universal Dashboard Dispatcher
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return match (Auth::user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'vet' => redirect()->route('vet.dashboard'),
        'shelter' => redirect()->route('shelter.dashboard'),
        default => redirect()->route('owner.dashboard'),
    };
})->name('dashboard');

Route::get('/user', fn () => redirect()->route('dashboard'));
