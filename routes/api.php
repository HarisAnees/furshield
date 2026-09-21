<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,PetController,AppointmentController,VetController,ShelterController,AdoptionController,ProductController,CartController,CareContentController,HealthRecordController,FamilyController,InsuranceController,ReminderController,AvailabilityController,MedicalDocumentController,RatingController,AdminController};
Route::prefix('v1')->name('api.')->group(function(){
 Route::post('/auth/register',[AuthController::class,'register']); Route::post('/auth/login',[AuthController::class,'login']);
 Route::get('/care-content',[CareContentController::class,'index']); Route::get('/products',[ProductController::class,'index']); Route::get('/products/{product}',[ProductController::class,'show']); Route::get('/vets',[VetController::class,'index']); Route::get('/vets/{vet}',[VetController::class,'show']); Route::get('/vets/{vet}/availability',[AvailabilityController::class,'index']); Route::get('/shelters',[ShelterController::class,'index']); Route::get('/adoptions',[AdoptionController::class,'index']); Route::get('/adoptions/{listing}',[AdoptionController::class,'show']); Route::get('/ratings',[RatingController::class,'index']);
 Route::middleware('auth:sanctum')->group(function(){
  Route::post('/auth/logout',[AuthController::class,'logout']); Route::get('/auth/me',[AuthController::class,'me']);
  Route::apiResource('pets',PetController::class);
  Route::get('/pets/{pet}/medical-documents',[MedicalDocumentController::class,'index']); Route::post('/medical-documents',[MedicalDocumentController::class,'store']); Route::get('/medical-documents/{document}/download',[MedicalDocumentController::class,'download']); Route::delete('/medical-documents/{document}',[MedicalDocumentController::class,'destroy']);
  Route::apiResource('health-records',HealthRecordController::class);
  Route::apiResource('insurance-policies',InsuranceController::class)->except(['show','create','edit']); Route::get('/pets/{pet}/insurance-policies',[InsuranceController::class,'index']);
  Route::apiResource('appointments',AppointmentController::class)->except(['create','edit']);
  Route::post('/adoptions/{listing}/interest',[AdoptionController::class,'interest']); Route::patch('/adoption-interests/{interest}',[AdoptionController::class,'updateInterest']);
  Route::get('/cart',[CartController::class,'show']); Route::post('/cart/items',[CartController::class,'add']); Route::patch('/cart/items/{item}',[CartController::class,'update']); Route::delete('/cart/items/{item}',[CartController::class,'remove']); Route::post('/cart/checkout',[CartController::class,'checkout']);
  Route::get('/orders',[CartController::class,'orders']); Route::get('/orders/{order}',[CartController::class,'order']);
  Route::apiResource('reminders',ReminderController::class)->except(['show','create','edit']); Route::post('/reminders/{reminder}/complete',[ReminderController::class,'complete']);
  Route::get('/family',[FamilyController::class,'index']); Route::post('/family',[FamilyController::class,'store']); Route::patch('/family/{familyMember}',[FamilyController::class,'update']); Route::delete('/family/{familyMember}',[FamilyController::class,'destroy']);
  Route::post('/ratings',[RatingController::class,'store']);
  Route::middleware('role:vet')->group(function(){Route::post('/vet/availability',[AvailabilityController::class,'store']); Route::patch('/vet/availability/{availability}',[AvailabilityController::class,'update']); Route::delete('/vet/availability/{availability}',[AvailabilityController::class,'destroy']);});
  Route::middleware('role:shelter')->group(function(){Route::post('/adoptions',[AdoptionController::class,'store']); Route::patch('/adoptions/{listing}',[AdoptionController::class,'update']); Route::post('/adoptions/{listing}/care-logs',[AdoptionController::class,'careLog']);});
  Route::middleware('role:admin')->group(function(){Route::get('/admin/dashboard',[AdminController::class,'dashboard']); Route::get('/admin/users',[AdminController::class,'users']); Route::patch('/admin/users/{user}',[AdminController::class,'updateUser']); Route::post('/products',[ProductController::class,'store']); Route::patch('/products/{product}',[ProductController::class,'update']); Route::delete('/products/{product}',[ProductController::class,'destroy']); Route::post('/care-content',[CareContentController::class,'store']); Route::patch('/care-content/{careContent}',[CareContentController::class,'update']); Route::delete('/care-content/{careContent}',[CareContentController::class,'destroy']);});
 });
});
