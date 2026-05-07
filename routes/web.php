<?php
use Illuminate\Support\Facades\Route;

// Controllers Auth
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Controllers Student
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\InternshipController;
use App\Http\Controllers\Student\ApplicationController;
use App\Http\Controllers\Student\InterviewController as StudentInterviewController;
use App\Http\Controllers\Student\StudentProfileController;

// Controllers Company
use App\Http\Controllers\Company\CompanyDashboardController;
use App\Http\Controllers\Company\InternshipManagementController;
use App\Http\Controllers\Company\ApplicationManagementController;
use App\Http\Controllers\Company\InterviewController as CompanyInterviewController;

// Controllers Admin
use App\Http\Controllers\Admin\AdminDashboardController;

// ─── Page d'accueil ───────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ─── Inscription avec choix du rôle ──────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ─── Routes Étudiant ─────────────────────────────────────────────
Route::middleware(['auth', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Offres de stage
        Route::get('/internships', [InternshipController::class, 'index'])->name('internships.index');
        Route::get('/internships/{internship}', [InternshipController::class, 'show'])->name('internships.show');

        // Candidatures
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');

        // Entretiens
        Route::get('/interviews', [StudentInterviewController::class, 'index'])->name('interviews.index');

        // Profil ✅
        Route::get('/profile', [StudentProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    });

// ─── Routes Entreprise ────────────────────────────────────────────
Route::middleware(['auth', 'company'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');

        // Gestion des offres (CRUD complet)
        Route::resource('internships', InternshipManagementController::class);

        // Gestion des candidatures
        Route::get('/applications', [ApplicationManagementController::class, 'index'])->name('applications.index');
        Route::patch('/applications/{application}', [ApplicationManagementController::class, 'update'])->name('applications.update');

        // Planification des entretiens
        Route::post('/interviews', [CompanyInterviewController::class, 'store'])->name('interviews.store');
        Route::patch('/interviews/{interview}', [CompanyInterviewController::class, 'update'])->name('interviews.update');
    });

// ─── Routes Admin ─────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

require __DIR__.'/auth.php';