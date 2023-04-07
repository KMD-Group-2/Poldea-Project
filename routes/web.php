<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ReportManagementController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'login');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [LandingController::class, 'index']);

    Route::as('admin.')->group(function () {
        Route::get('admin_dashboard', [LandingController::class, 'adminDashboard'])->name('dashboard');

        // Staff Routes
        Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
        Route::post('staff', [StaffController::class, 'store'])->name('staff.store');
        Route::post('staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
        Route::post('staff/mass/destroy', [StaffController::class, 'massDestroy'])->name('staff.massDestroy');

        // User Routes
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::post('user', [UserController::class, 'store'])->name('user.store');
        Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('user/mass/destroy', [UserController::class, 'massDestroy'])->name('user.massDestroy');

        // Academic Routes
        Route::get('academic_year', [AcademicYearController::class, 'index'])->name('academic-year.index');
        Route::post('academic_year', [AcademicYearController::class, 'store'])->name('academic-year.store');
        Route::put('academic_year/{academic_year}', [AcademicYearController::class, 'update'])->name('academic-year.update');
        Route::delete('academic_year/{academic_year}', [AcademicYearController::class, 'destroy'])->name('academic-year.destroy');

        // Reports
        Route::get('admin/idea_report', [ReportManagementController::class, 'adminIdeaReport'])->name('idea_report');
    });

    Route::as('qa_c.')->group(function () {
        Route::get('qa_coordinator_dashboard', [LandingController::class, 'QACoordinatorDashboard'])->name('dashboard');
        
        Route::get('staff_list', [StaffController::class, 'StaffList'])->name('staff.list');
        Route::get('staff/{staff}/ideas', [StaffController::class, 'StaffIdeaList'])->name('staff.idea.list');

        Route::get('qa_coordinator/idea_report', [ReportManagementController::class, 'qaCoordinatorReport'])->name('idea_report');
    });

    Route::as('qa_m.')->group(function () {
        Route::get('qa_manager_dashboard', [LandingController::class, 'QAManagerDashboard'])->name('dashboard');

        // Category Routes
        Route::get('category', [CategoryController::class, 'index'])->name('category.index');
        Route::post('category', [CategoryController::class, 'store'])->name('category.store');
        Route::put('category/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::post('category/mass/destroy', [CategoryController::class, 'massDestroy'])->name('category.massDestroy');

        Route::get('qa_manager/academic_year_report', [AcademicYearController::class, 'index'])->name('academic-year.report');

        Route::get('qa_manager/idea_report', [ReportManagementController::class, 'qaManagerReport'])->name('idea_report');
    });
    
    Route::as('staff.')->group(function () {
        Route::get('staff_dashboard', [LandingController::class, 'StaffDashboard'])->name('dashboard');

        Route::get('ideas', [IdeaController::class, 'ideas'])->name('ideas');
        Route::get('add_information/{idea?}', [IdeaController::class, 'addInformationView'])->name('idea.add-info');
        Route::get('upload_files/{idea}', [IdeaController::class, 'uploadFilesView'])->name('idea.upload-file');
        Route::get('preview_idea/{idea}', [IdeaController::class, 'previewIdeaView'])->name('idea.preview-idea');
        Route::post('add_information', [IdeaController::class, 'storeInfo'])->name('idea.add-info.store');
        Route::post('upload_files', [IdeaController::class, 'uploadFiles'])->name('idea.upload-file.store');
        Route::post('delete_file', [IdeaController::class, 'deleteFile'])->name('idea.upload-file.delete');
        Route::post('publish_idea', [IdeaController::class, 'publishIdea'])->name('idea.publish');

        Route::get('publish_idea', [IdeaController::class, 'publishedIdeaView'])->name('idea.publishView');
        Route::get('draft_idea', [IdeaController::class, 'draftIdeaView'])->name('idea.draftView');

        Route::post('add_comment', [IdeaController::class, 'addComment'])->name('idea.add-comment');
        Route::get('get_comment/{page}/{ideaid}', [IdeaController::class, 'getComments'])->name('idea.get-comments');

        Route::post('add_like', [IdeaController::class, 'addLike'])->name('idea.add-like');
        Route::post('increase_view_count', [IdeaController::class, 'increaseViewCount'])->name('idea.increase-view-count');
    });

    Route::get('idea_detail/{id}', [IdeaController::class, 'show'])->name('idea.detail');

    Route::post('idea_report/export-file',[ReportManagementController::class, 'ReportExport'])->name('idea_report.export-file');
    Route::post('idea_report/export-zip',[ReportManagementController::class, 'ZipExport'])->name('idea_report.export-zip');
    Route::get('my_profile',[ProfileController::class, 'index'])->name('acoount.my_profile');
    Route::post('my_profile/change-password',[ProfileController::class, 'ChangePassword'])->name('account.change_password');
});

require __DIR__ . '/auth.php';
