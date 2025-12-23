<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\CertificateController;



// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public course browsing (users can view courses without login)
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{id}', [CourseController::class, 'show']);



Route::middleware('auth:sanctum')->group(function () {
    
    // Auth User Routes
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    
    // Users API - Admin only
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    
    // Courses API - Create/Update/Delete require authentication
    Route::prefix('courses')->group(function () {
        Route::post('/', [CourseController::class, 'store']);
        Route::put('/{id}', [CourseController::class, 'update']);
        Route::delete('/{id}', [CourseController::class, 'destroy']);
    });
    
    // Lessons API - All require authentication
    Route::prefix('lessons')->group(function () {
        Route::get('/', [LessonController::class, 'index']);
        Route::post('/', [LessonController::class, 'store']);
        Route::get('/{id}', [LessonController::class, 'show']);
        Route::put('/{id}', [LessonController::class, 'update']);
        Route::delete('/{id}', [LessonController::class, 'destroy']);
    });
    
    // Quizzes API - All require authentication
    Route::prefix('quizzes')->group(function () {
        Route::get('/', [QuizController::class, 'index']);
        Route::post('/', [QuizController::class, 'store']);
        Route::get('/{id}', [QuizController::class, 'show']);
        Route::put('/{id}', [QuizController::class, 'update']);
        Route::delete('/{id}', [QuizController::class, 'destroy']);
    });
    
    // Enrollments API - All require authentication
    Route::prefix('enrollments')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index']);
        Route::post('/', [EnrollmentController::class, 'store']);
        Route::get('/{id}', [EnrollmentController::class, 'show']);
        Route::put('/{id}', [EnrollmentController::class, 'update']);
        Route::delete('/{id}', [EnrollmentController::class, 'destroy']);
    });
    
    // Certificates API - All require authentication
    Route::prefix('certificates')->group(function () {
        Route::get('/', [CertificateController::class, 'index']);
        Route::post('/', [CertificateController::class, 'store']);
        Route::get('/{id}', [CertificateController::class, 'show']);
        Route::get('/verify/{code}', [CertificateController::class, 'verify']);
        Route::delete('/{id}', [CertificateController::class, 'destroy']);
    });
    
});

