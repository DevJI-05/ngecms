<?php

use App\Http\Controllers\Gas\AboutController;
use App\Http\Controllers\Gas\CertificationController;
use App\Http\Controllers\Gas\ContactController;
use App\Http\Controllers\Gas\HomeController;
use App\Http\Controllers\Gas\InquiryController;
use App\Http\Controllers\Gas\PortfolioController;
use App\Http\Controllers\Gas\ServicesController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/home', HomeController::class)->name('home.alias');
Route::get('/about', AboutController::class)->name('about');
Route::get('/sertifikasi', CertificationController::class)->name('certifications');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/portofolio', PortfolioController::class)->name('portfolio');
Route::get('/services', ServicesController::class)->name('services');
Route::get('/inquiry', InquiryController::class)->name('inquiry');
