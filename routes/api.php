<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\AttachmentController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\AnswerController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\QuizAttemptController;
use App\Http\Controllers\API\StudentAnswerController;
use App\Http\Controllers\API\LessonCompletionController;
use App\Http\Controllers\API\CourseProgressController;
use App\Http\Controllers\API\CertificateController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.api')->group(function () {
    

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    
    
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/lessons', [LessonController::class, 'index']);
    Route::get('/quizzes', [QuizController::class, 'index']);
    
    
    Route::middleware('role:Instructor,Admin')->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{id}', [CourseController::class, 'update']);
        Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
        
        Route::post('/lessons', [LessonController::class, 'store']);
        Route::put('/lessons/{id}', [LessonController::class, 'update']);
        Route::delete('/lessons/{id}', [LessonController::class, 'destroy']);
        
        Route::post('/quizzes', [QuizController::class, 'store']);
        Route::put('/quizzes/{id}', [QuizController::class, 'update']);
        Route::delete('/quizzes/{id}', [QuizController::class, 'destroy']);
    });
    
    Route::middleware('role:Admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });
});