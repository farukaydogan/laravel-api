<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;

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
//    return redirect()->route('category.show',['slug'=>'kitaplar']);
});

//Route::prefix('basics')->group(function () {
//    Route::get('/merhaba-json', function() {
//        return ['message'=>'Bu bir json'];
//    });
//
//    Route::get('/merhaba-json2',function () {
//        return response(['message'=>'response ile veri'],200)->header('Content-Type','text/plain');
//    });
//
//    Route::get('/merhaba-json3',function () {
//        return response(['message'=>'response ile veri'],200)->header('Content-Type','application/json');
//    });
//
//    Route::get('/merhaba-json4',function () {
//        return response()->json(['message'=>'json() fonk. ile mesaj']);
//    });
//
//    Route::get('/merhaba/{id}/{type?}', function ($id,$r_type='None') {
//        return "Kullanıcı ID: $id - Ürün Tipi: ".ucfirst($r_type);
//    });
//
//    Route::get('category/{slug}',function ($slug) {
//        return "Category Slug: $slug";
//    })->name('category.show');
//});

//Route::get('/product/{id}/{type?}',[ProductController::class,'show'])->name('product.show');

//Route::resource('/products', ProductController::class);
//Route::resource('/products', ProductController::class)->only('index', 'show');
Route::resource('/products', ProductController::class)->except('destroy');

Route::middleware('auth')->get('/secured', function () {
    return 'You are authenticated!';
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/requests', function () {
    return view('requests');
});
Route::get('/getRequest', function () {
    if (Request::ajax()) {
        return 'getRequest has loaded completely.';
    }
});
Route::post('/register', function () {
    if (Request::ajax()) {
        // return var_dump(Response::json(Request::all()));
        return Response::json(Request::all());
    }
});

Route::get('/upload', [HomeController::class, 'upload_form'])->name('upload_form');
Route::get('/downLoad/{fileName}', [HomeController::class, 'downLoad']);

Route::get('instaRequest', function () { return view('instarequest'); });
Route::get('instaCurlRequest', function () { return view('instacurl'); });


