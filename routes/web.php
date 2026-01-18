<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\LessonController as InstructorLessonController;
use App\Http\Controllers\Instructor\QuizController as InstructorQuizController;
use App\Http\Controllers\Instructor\StudentController as InstructorStudentController;
use App\Http\Controllers\Instructor\AnalyticsController as InstructorAnalyticsController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\CertificateController as StudentCertificateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect /dashboard based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }
    
    $role = strtolower($user->role);
    return match($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'instructor' => redirect()->route('instructor.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => redirect()->route('student.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Student Dashboard
Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:student'])
    ->name('student.dashboard');

// Instructor Dashboard
Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:instructor'])
    ->name('instructor.dashboard');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.dashboard');

// Redirect old course routes to student routes
Route::middleware('auth')->group(function () {
    Route::get('/courses/browse', function () {
        return redirect()->route('student.courses.browse');
    })->name('courses.browse');

    Route::get('/courses', function () {
        return redirect()->route('student.courses.browse');
    })->name('courses.index');

    Route::get('/courses/{id}', function ($id) {
        return redirect()->route('student.courses.show', $id);
    })->name('courses.show');

    Route::get('/lessons/{id}', function ($id) {
        return redirect()->route('student.lessons.show', $id);
    })->name('lessons.show');
});

// Quiz Routes
Route::middleware('auth')->group(function () {
    Route::get('/quizzes/{id}/take', function ($id) {
        return Inertia::render('Quizzes/Take', [
            'quiz' => [
                'id' => $id,
                'title' => 'HTML Basics Quiz',
                'time_limit' => 600
            ],
            'course' => [
                'id' => 1,
                'title' => 'Web Development Fundamentals'
            ],
            'questions' => [
                [
                    'id' => 1,
                    'question' => 'What does HTML stand for?',
                    'answers' => [
                        ['id' => 1, 'answer' => 'Hyper Text Markup Language'],
                        ['id' => 2, 'answer' => 'High Tech Modern Language'],
                        ['id' => 3, 'answer' => 'Home Tool Markup Language'],
                        ['id' => 4, 'answer' => 'Hyperlinks and Text Markup Language']
                    ]
                ],
                [
                    'id' => 2,
                    'question' => 'Which HTML tag is used for the largest heading?',
                    'answers' => [
                        ['id' => 5, 'answer' => '<h1>'],
                        ['id' => 6, 'answer' => '<h6>'],
                        ['id' => 7, 'answer' => '<heading>'],
                        ['id' => 8, 'answer' => '<head>']
                    ]
                ]
            ]
        ]);
    })->name('quizzes.take');

    Route::get('/quizzes/{id}/results', function ($id) {
        return Inertia::render('Quizzes/Results', [
            'quiz' => [
                'id' => $id,
                'title' => 'HTML Basics Quiz',
                'passing_score' => 70,
                'allow_retake' => true
            ],
            'course' => [
                'id' => 1,
                'title' => 'Web Development Fundamentals'
            ],
            'result' => [
                'score' => 85,
                'total_score' => 100,
                'correct_answers' => 8,
                'wrong_answers' => 2,
                'time_taken' => '8 min',
                'questions' => [
                    [
                        'id' => 1,
                        'question' => 'What does HTML stand for?',
                        'user_answer' => 'Hyper Text Markup Language',
                        'correct_answer' => 'Hyper Text Markup Language',
                        'is_correct' => true,
                        'explanation' => 'HTML stands for Hyper Text Markup Language.'
                    ]
                ]
            ],
            'nextLesson' => ['id' => 3, 'title' => 'JavaScript Basics']
        ]);
    })->name('quizzes.results');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - Only accessible by Admin role
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Instructor Routes - Only accessible by Instructor and Admin
Route::middleware(['auth', 'verified', 'role:instructor,admin'])->prefix('instructor')->name('instructor.')->group(function () {
    // Course Management
    Route::get('/courses', [InstructorCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [InstructorCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{id}', [InstructorCourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{id}/edit', [InstructorCourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{id}', [InstructorCourseController::class, 'update'])->name('courses.update');
    Route::put('/courses/{id}/publish', [InstructorCourseController::class, 'publish'])->name('courses.publish');
    Route::delete('/courses/{id}', [InstructorCourseController::class, 'destroy'])->name('courses.destroy');
    
    // Lesson Management
    Route::get('/courses/{courseId}/lessons/create', [InstructorLessonController::class, 'create'])->name('lessons.create');
    Route::post('/courses/{courseId}/lessons', [InstructorLessonController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{id}/edit', [InstructorLessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{id}', [InstructorLessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{id}', [InstructorLessonController::class, 'destroy'])->name('lessons.destroy');
    
    // Quiz Management
    Route::get('/lessons/{lessonId}/quizzes', [InstructorQuizController::class, 'index'])->name('quizzes.index');
    Route::get('/lessons/{lessonId}/quizzes/create', [InstructorQuizController::class, 'create'])->name('quizzes.create');
    Route::post('/lessons/{lessonId}/quizzes', [InstructorQuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{id}', [InstructorQuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{id}/edit', [InstructorQuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/quizzes/{id}', [InstructorQuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{id}', [InstructorQuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quiz-attempts/{attemptId}/grade', [InstructorQuizController::class, 'gradeAttempt'])->name('quizzes.grade');
    
    // Student Analytics
    Route::get('/students', [InstructorStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [InstructorStudentController::class, 'show'])->name('students.show');
    
    // Quiz Analytics
    Route::get('/analytics', [InstructorAnalyticsController::class, 'index'])->name('analytics.index');
});

// Student Routes - Only accessible by Student and Admin
Route::middleware(['auth', 'verified', 'role:student,admin'])->prefix('student')->name('student.')->group(function () {
    // Course Browsing & Enrollment
    Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/browse', [StudentCourseController::class, 'browse'])->name('courses.browse');
    Route::get('/courses/{id}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{id}/enroll', [StudentCourseController::class, 'enroll'])->name('courses.enroll');
    
    // Lesson Viewing
    Route::get('/lessons/{id}', [StudentLessonController::class, 'show'])->name('lessons.show');
    Route::post('/lessons/{id}/complete', [StudentLessonController::class, 'complete'])->name('lessons.complete');
    
    // Quiz Taking
    Route::get('/quizzes/{id}', [StudentQuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{id}/start', [StudentQuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quiz-attempts/{attemptId}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quiz-attempts/{attemptId}/results', [StudentQuizController::class, 'results'])->name('quizzes.results');
    
    // Certificates
    Route::get('/certificates', [StudentCertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{id}', [StudentCertificateController::class, 'show'])->name('certificates.show');
    Route::get('/certificates/{id}/download', [StudentCertificateController::class, 'download'])->name('certificates.download');
});

require __DIR__.'/auth.php';
