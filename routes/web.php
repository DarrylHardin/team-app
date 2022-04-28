<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/billing-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal();
});


Route::get('/new-customer', function (Request $request) {
    $user = Auth::user();
    $options = [
        'address' => [
            'city' => 'Idaho Falls',
            'country' => 'US',
            'line1' => '332',
            'postal_code' => '83402',
            'state' => 'Idaho',
        ]
    ];
    $stripeCustomer = $user->createAsStripeCustomer($options);
    return $stripeCustomer;
});