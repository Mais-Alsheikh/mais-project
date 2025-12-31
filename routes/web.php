<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;        //مسؤل عن انشاء وتعديل وحذف الدورات
use App\Models\Course;
use App\Notifications\CourseEnrolledNotification;
use App\Http\Controllers\LessonController;               //مسؤل عن محتوى الدروس




/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|-------------------------------------
| Auth routes (Breeze / Fortify)
|--------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dashboard 
|-----------------------------------
*/
Route::get('/dashboard', function () {
    $users = \App\Models\User::count();
    $courses = \App\Models\Course::count();
    $lessons = \App\Models\Lesson::count();
    $exams = \App\Models\Exam::count();
    return view('dashboard', compact('users','courses','lessons','exams'));
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Courses (All users)
|--------------------------------------------------------------------------
*/
Route::get('/courses', [CourseController::class, 'index'])
    ->middleware('auth')
    ->name('courses.index');

/*
|----------------------------------
| Admin
|------------------
*/
Route::get('/admin/dashboard', function () {
    abort_unless(auth()->user()->hasRole('admin'), 403);
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

/*

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teacher'])->group(function () {

    // لوحة المعلم
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');

    // إضافة دورة جديدة
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');

    // تعديل دورة
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::patch('/courses/{course}', [CourseController::class, 'update'])
        ->name('courses.update')
        ->middleware(['auth', 'role:teacher']);

    // حذف دورة
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    // عرض الدورات التي يدرسها المعلم
    Route::get('/teacher/my-courses', function () {
        $courses = auth()->user()->taughtCourses;
        return view('teacher.courses', compact('courses'));
    })->name('teacher.my-courses');

    // إضافة درس جديد لدورة
    Route::get('/teacher/courses/{course}/lessons/create', [LessonController::class, 'create'])
        ->name('lessons.create');
    Route::post('/teacher/courses/{course}/lessons', [LessonController::class, 'store'])
        ->name('lessons.store');

    // أسئلة الدروس - إدارة الأسئلة من قِبل المعلم
    Route::get('/teacher/questions', [\App\Http\Controllers\QuestionController::class, 'index'])
        ->name('questions.index');

    Route::get('/teacher/lessons/{lesson}/questions', [\App\Http\Controllers\QuestionController::class, 'lessonQuestions'])
        ->name('questions.lesson.index');

    Route::get('/teacher/lessons/{lesson}/questions/create', [\App\Http\Controllers\QuestionController::class, 'create'])
        ->name('questions.create');

    Route::post('/teacher/lessons/{lesson}/questions', [\App\Http\Controllers\QuestionController::class, 'store'])
        ->name('questions.store');

    Route::get('/teacher/lessons/{lesson}/questions/{question}/edit', [\App\Http\Controllers\QuestionController::class, 'edit'])
        ->name('questions.edit');

    Route::patch('/teacher/lessons/{lesson}/questions/{question}', [\App\Http\Controllers\QuestionController::class, 'update'])
        ->name('questions.update');

    Route::delete('/teacher/lessons/{lesson}/questions/{question}', [\App\Http\Controllers\QuestionController::class, 'destroy'])
        ->name('questions.destroy');

    // نماذج الامتحانات من قِبل المعلم
    Route::get('/teacher/exams', [\App\Http\Controllers\ExamController::class, 'index'])
        ->name('exams.index');

    Route::get('/teacher/exams/create', [\App\Http\Controllers\ExamController::class, 'create'])
        ->name('exams.create');

    Route::post('/teacher/exams', [\App\Http\Controllers\ExamController::class, 'store'])
        ->name('exams.store');

    Route::get('/teacher/exams/{exam}', [\App\Http\Controllers\ExamController::class, 'show'])
        ->name('exams.show');

    // Manage questions for an exam
    Route::get('/teacher/exams/{exam}/questions', [\App\Http\Controllers\ExamController::class, 'manageQuestions'])
        ->name('exams.questions.manage');

    Route::patch('/teacher/exams/{exam}/questions', [\App\Http\Controllers\ExamController::class, 'updateQuestions'])
        ->name('exams.questions.update');

    Route::delete('/teacher/exams/{exam}', [\App\Http\Controllers\ExamController::class, 'destroy'])
        ->name('exams.destroy');

});

/* Student */

Route::middleware(['auth', 'role:student'])->group(function () {

    // لوحة الطالب (الدورات المسجل بها)
    Route::get('/student/dashboard', function () {
        $courses = auth()->user()->courses;
        return view('student.dashboard', compact('courses'));
    })->name('student.dashboard');

    // التسجيل في دورة
    Route::post('/courses/{course}/enroll', function (\App\Models\Course $course) {

    $user = auth()->user();

    if ($user->courses()->where('course_id', $course->id)->exists()) {
        return back()->with('error', 'أنت مسجل بهذه الدورة مسبقاً');
    }

    $user->courses()->attach($course->id);

    return back()->with('success', 'تم التسجيل بالدورة بنجاح');
})->name('courses.enroll');

    // Student exams (take and view results)
    Route::get('/student/exams', [\App\Http\Controllers\StudentExamController::class, 'index'])
        ->name('student.exams.index');

    Route::get('/student/exams/{exam}', [\App\Http\Controllers\StudentExamController::class, 'show'])
        ->name('student.exams.show');

    Route::post('/student/exams/{exam}/submit', [\App\Http\Controllers\StudentExamController::class, 'submit'])
        ->name('student.exams.submit');

    Route::get('/student/exams/{exam}/results/{result}', [\App\Http\Controllers\StudentExamController::class, 'result'])
        ->name('student.exams.result');

// صفحة دوراتي
    Route::get('/student/my-courses', function () {
        $courses = auth()->user()->courses;
        return view('student.my-courses', compact('courses'));
    })->name('student.my-courses');

});


/*
 Profile
--------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::resource('/users',UserController::class);
});

Route::get('/', function () {
    return view('frontend.home');
});
