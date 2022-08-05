<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () { return view("welcome"); });

Route::prefix("/companies")->group(function () {
    Route::get("/", [CompanyController::class, "index"]);
    Route::get("/create", [CompanyController::class, "create"]);
    Route::post("/store", [CompanyController::class, "store"]);
    Route::get("{id}/edit", [CompanyController::class, "edit"]);
    Route::post("/{id}/edit", [CompanyController::class, "update"]);
    Route::post("/{id}/delete", [CompanyController::class, "destroy"]);
});

Route::prefix("/employees")->group(function () {
    Route::get("/", [EmployeeController::class, "index"]);
    Route::get("/create", [EmployeeController::class, "create"]);
    Route::post("/store", [EmployeeController::class, "store"]);
    Route::get("{id}/edit", [EmployeeController::class, "edit"]);
    Route::post("/{id}/edit", [EmployeeController::class, "update"]);
    Route::post("/{id}/delete", [EmployeeController::class, "destroy"]);
});




// Route::resource('companies', CompanyController::class);

// Route::resource('employees', EmployeeController::class);