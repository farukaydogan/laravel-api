<?php

use App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//use App\Models\User;

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::get('/hello', function () {
    return 'Hello RESTful Api';
});

Route::get('/users', function () {
    return User::factory(10)->make();
});
*/

//Route::apiResource('/products', Api\ProductController::class);
//Route::apiResource('/users', Api\UserController::class);

Route::get('categories/custom1', [Api\CategoryController::class, 'custom1'])->middleware('auth:api');
Route::get('categories/report1', [Api\CategoryController::class, 'report1']);
Route::get('products/custom1', [Api\ProductController::class, 'custom1']);
Route::get('products/custom2', [Api\ProductController::class, 'custom2']);
Route::get('products/custom3', [Api\ProductController::class, 'custom3']);
Route::get('products/custom4/{id}', [Api\ProductController::class, 'custom4']);
Route::get('products/listswithcategories', [Api\ProductController::class, 'listsWithCategories']);
Route::get('users/custom1', [Api\UserController::class, 'custom1']);
Route::get('users/custom2', [Api\UserController::class, 'custom2']);

Route::middleware(['api-token', 'throttle:api'])->group(function () {
    Route::apiResources([
        'users' => Api\UserController::class,
        'products' => Api\ProductController::class,
        'categories' => Api\CategoryController::class
    ]);
});

Route::middleware('throttle:5|rate_limit,1')->group(function () {
    Route::get('/throttle-guest', function () {
        return 'Throttle guest access...';
    });
    Route::get('/throttle-user', function () {
        return 'Throttle user access...';
    })->middleware('auth:api');
});


Route::post('auth/login', [Api\AuthController::class, 'login']);

Route::middleware('api-token')->group(function () {
    Route::get('auth/bearer-token', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'name' => $user->name,
            'access_token' => $user->api_token,
            'time' => date('H:i:s'),
        ]);
    });
});

Route::middleware('auth.basic')->get('/user/basic-auth', function (Request $request) {
    return $request->user();
});

Route::post('/upLoad', [Api\UploadController::class, 'upLoad'])->name('upLoad');

