<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\NoticeController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Move the register route outside of the auth middleware group
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('teams', TeamController::class);
    });

    // School Management Routes
    Route::resources([
        'students' => StudentController::class,
        'teachers' => TeacherController::class,
        'classes' => ClassRoomController::class,
        'subjects' => SubjectController::class,
        'parents' => ParentController::class,
        'attendances' => AttendanceController::class,
        'grades' => GradeController::class,
        'assignments' => AssignmentController::class,
        'notices' => NoticeController::class,
    ]);

    Route::get('/get-students-by-class', [AttendanceController::class, 'getStudentsByClass'])
        ->name('attendances.get-students');
});

// Add this temporary route to check roles
Route::get('/debug-roles', function() {
    return response()->json([
        'roles' => \Spatie\Permission\Models\Role::all()->toArray()
    ]);
});

Route::get('/check-roles', function() {
    // Check roles table structure
    $tableInfo = DB::select('DESCRIBE roles');
    
    // Get all roles
    $roles = \Spatie\Permission\Models\Role::all();
    
    // Check if roles table exists and has correct permissions
    $tablesExist = [
        'roles' => Schema::hasTable('roles'),
        'permissions' => Schema::hasTable('permissions'),
        'model_has_roles' => Schema::hasTable('model_has_roles'),
    ];
    
    return response()->json([
        'table_info' => $tableInfo,
        'roles' => $roles->toArray(),
        'tables_exist' => $tablesExist,
        'connection' => config('database.default'),
        'database' => config('database.connections.mysql.database')
    ]);
});

// Add this temporary route
Route::get('/debug-roles', function() {
    $roles = \Spatie\Permission\Models\Role::all();
    dd([
        'count' => $roles->count(),
        'roles' => $roles->toArray(),
        'tables_exist' => [
            'roles' => \Illuminate\Support\Facades\Schema::hasTable('roles'),
            'permissions' => \Illuminate\Support\Facades\Schema::hasTable('permissions'),
        ]
    ]);
});
