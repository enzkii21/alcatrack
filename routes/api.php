<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PDFListController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\ImageListController;
use App\Http\Controllers\OpenForumController;
use App\Http\Controllers\UploadImageController;
use App\Http\Controllers\AlumniAccountController;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\RegisteredStudentsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('registeredstudents', RegisteredStudentsController::class);

Route::resource('accountsetting', AccountSettingController::class);

Route::resource('alumniaccount', AlumniAccountController::class);

Route::resource('accounts', AccountsController::class);

Route::resource('course', CourseController::class);

Route::resource('imagelist', ImageListController::class);

Route::resource('userlist', UserListController::class);

Route::post('upload',[UploadController::class,'uploadPDF']);

Route::resource('forum',OpenForumController::class);

Route::resource('comment', CommentController::class);

// Route::post('/api/uploadProfilePic',[UploadController::class,'uploadProfile']);

Route::post('uploadProfilePic', [UploadImageController::class, 'uploadProfile']);

Route::resource('pdflist', PDFListController::class);


// Route::get('FetchEmployee', function(){
//     return DB::connection('mysql')->table('alumniaccount')->get();
//     // return dd('Test');
// });