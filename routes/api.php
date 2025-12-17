<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\CertificateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Learning Platform REST API Routes
|--------------------------------------------------------------------------
| All CRUD operations for the Learning Management System
|
*/

// Users API - CRUD Operations
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

// Courses API - CRUD Operations
Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);           // GET /api/courses - Read all
    Route::post('/', [CourseController::class, 'store']);          // POST /api/courses - Create
    Route::get('/{id}', [CourseController::class, 'show']);        // GET /api/courses/{id} - Read one
    Route::put('/{id}', [CourseController::class, 'update']);      // PUT /api/courses/{id} - Update
    Route::delete('/{id}', [CourseController::class, 'destroy']);  // DELETE /api/courses/{id} - Delete
});

// Lessons API - CRUD Operations
Route::prefix('lessons')->group(function () {
    Route::get('/', [LessonController::class, 'index']);
    Route::post('/', [LessonController::class, 'store']);
    Route::get('/{id}', [LessonController::class, 'show']);
    Route::put('/{id}', [LessonController::class, 'update']);
    Route::delete('/{id}', [LessonController::class, 'destroy']);
});

// Quizzes API - CRUD Operations
Route::prefix('quizzes')->group(function () {
    Route::get('/', [QuizController::class, 'index']);
    Route::post('/', [QuizController::class, 'store']);
    Route::get('/{id}', [QuizController::class, 'show']);
    Route::put('/{id}', [QuizController::class, 'update']);
    Route::delete('/{id}', [QuizController::class, 'destroy']);
});

// Enrollments API - CRUD Operations
Route::prefix('enrollments')->group(function () {
    Route::get('/', [EnrollmentController::class, 'index']);
    Route::post('/', [EnrollmentController::class, 'store']);
    Route::get('/{id}', [EnrollmentController::class, 'show']);
    Route::put('/{id}', [EnrollmentController::class, 'update']);
    Route::delete('/{id}', [EnrollmentController::class, 'destroy']);
});

// Certificates API - CRUD Operations
Route::prefix('certificates')->group(function () {
    Route::get('/', [CertificateController::class, 'index']);
    Route::post('/', [CertificateController::class, 'store']);
    Route::get('/{id}', [CertificateController::class, 'show']);
    Route::get('/verify/{code}', [CertificateController::class, 'verify']); // Special verification endpoint
    Route::delete('/{id}', [CertificateController::class, 'destroy']);
});

