<?php

use App\Http\Controllers\AllyRecruitmentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PlanEventController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', LocaleController::class)
    ->whereIn('locale', ['es', 'en'])
    ->name('locale.switch');

Route::view('/', 'home')->name('home');
Route::view('/design-system', 'design-system')->name('design-system');

Route::view('/terminos-y-condiciones', 'legal.terminos')->name('legal.terms');
Route::view('/cookies', 'legal.cookies')->name('legal.cookies');
Route::view('/politica-de-privacidad', 'legal.privacidad')->name('legal.privacy');

Route::view('/nosotros', 'pages.about')->name('pages.about');
Route::view('/por-que-yucatan', 'pages.why')->name('pages.why');
Route::view('/servicios', 'pages.services')->name('pages.services');
Route::view('/distritos', 'pages.distritos')->name('pages.districts');
Route::view('/conectividad', 'pages.connectivity')->name('pages.connectivity');
Route::redirect('/distrito-cic', '/distrito/cic')->name('pages.distrito-cic');
Route::get('/distrito/{district:slug}', [DistrictController::class, 'show'])
    ->whereIn('district', ['cic', 'siglo-xxi'])
    ->name('pages.distrito');
Route::view('/aliados', 'pages.allies')->name('pages.allies');
Route::view('/blog', 'pages.blog')->name('pages.blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('pages.blog.show');
Route::view('/eventos', 'pages.eventos')->name('pages.events');
Route::view('/apoyos', 'pages.apoyos')->name('pages.apoyos');
Route::view('/fideture', 'pages.fideture')->name('pages.fideture');

Route::get('/registro-aliados', [AllyRecruitmentController::class, 'create'])->name('pages.allies.recruit');
Route::post('/registro-aliados', [AllyRecruitmentController::class, 'store'])->name('pages.allies.recruit.store');
Route::get('/registro-aliados/confirmacion', [AllyRecruitmentController::class, 'confirmation'])->name('pages.allies.recruit.confirmation');

Route::get('/planea-tu-evento', [PlanEventController::class, 'create'])->name('pages.plan');
Route::post('/planea-tu-evento', [PlanEventController::class, 'store'])->name('pages.plan.store');
Route::get('/planea-tu-evento/confirmacion', [PlanEventController::class, 'confirmation'])->name('pages.plan.confirmation');
