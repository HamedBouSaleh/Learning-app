<?php

use Illuminate\Support\Facades\Route;
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

Route::apiResource('users', UserController::class);
Route::apiResource('courses', CourseController::class);
Route::apiResource('lessons', LessonController::class);
Route::apiResource('attachments', AttachmentController::class);
Route::apiResource('quizzes', QuizController::class);
Route::apiResource('questions', QuestionController::class);
Route::apiResource('answers', AnswerController::class);
Route::apiResource('enrollments', EnrollmentController::class);
Route::apiResource('quiz-attempts', QuizAttemptController::class);
Route::apiResource('student-answers', StudentAnswerController::class);
Route::apiResource('lesson-completions', LessonCompletionController::class);
Route::apiResource('course-progress', CourseProgressController::class);
Route::apiResource('certificates', CertificateController::class);