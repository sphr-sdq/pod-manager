<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/otp' , [RegisteredUserController::class , 'createOTP']);
    Route::post('/verify' , [RegisteredUserController::class , 'verify']);
    Route::post('/register' , [RegisteredUserController::class , 'store']);
//    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

//    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
//        ->name('password.request');
//
//    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
//        ->name('password.email');
//
//    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
//        ->name('password.reset');
//
//    Route::post('reset-password', [NewPasswordController::class, 'store'])
//        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard' , [DashboardController::class , "index" ])
        ->middleware('verified')
        ->name('dashboard');

    Route::get('/dashboard/profile' , [\App\Http\Controllers\Dashboard\ProfileController::class , "index" ])
        ->middleware('verified')
        ->name('dashboard-profile');

    Route::post('/dashboard/profile' , [\App\Http\Controllers\Dashboard\ProfileController::class , "store" ])
        ->middleware('verified');

    Route::get('/dashboard/pod' , [\App\Http\Controllers\Dashboard\Admin\PodController::class , "index" ])
        ->middleware('verified')
        ->name('dashboard-pod');

    Route::post('/dashboard/pod' , [\App\Http\Controllers\Dashboard\Admin\PodController::class , "store"])
        ->middleware(['verified' , 'role:admin']);

    Route::get('/dashboard/tag' , [\App\Http\Controllers\Dashboard\Admin\TagController::class , 'create'])
        ->middleware(['verified' , 'role:admin'])
        ->name('dashboard-tag');

    Route::post('/dashboard/tag' , [\App\Http\Controllers\Dashboard\Admin\TagController::class , 'store'])
        ->middleware(['verified' , 'role:admin']);

    Route::delete('/dashboard/tag/{id}' , [\App\Http\Controllers\Dashboard\Admin\TagController::class ,'destroy'])
        ->middleware(['verified' , 'role:admin']);

    Route::patch('/dashboard/tag/{id}' , [\App\Http\Controllers\Dashboard\Admin\TagController::class ,'update'])
        ->middleware(['verified' , 'role:admin']);

    Route::get('/dashboard/projects' , [\App\Http\Controllers\Dashboard\User\UserProjectController::class ,'create'])
        ->middleware(['verified','role:user']);

    Route::post('/dashboard/get_projects' , [\App\Http\Controllers\Dashboard\User\UserProjectController::class ,'index'])
        ->middleware(['verified','role:user']);

    Route::post('/dashboard/projects' , [\App\Http\Controllers\Dashboard\User\UserProjectController::class ,'store'])
        ->middleware(['verified','role:user']);

    Route::delete('/dashboard/projects/{id}' , [\App\Http\Controllers\Dashboard\User\UserProjectController::class , 'destroy'])
        ->middleware(['verified','role:user']);

    Route::get('/dashboard/project/{slug}' ,[\App\Http\Controllers\Dashboard\User\ProjectsController::class, 'index'])
        ->middleware(['verified','role:user']);

    Route::post('/dashboard/project/{slug}' ,[\App\Http\Controllers\Dashboard\User\ProjectsController::class , 'store'])
        ->middleware(['verified','role:user']);

    Route::post('/dashboard/project/{slug}/store_domain' ,[\App\Http\Controllers\Dashboard\User\ProjectsController::class , 'store_domain'])
        ->middleware(['verified','role:user']);

    Route::delete('/dashboard/project/{slug}/delete_domain/{id}' ,[\App\Http\Controllers\Dashboard\User\ProjectsController::class , 'delete_domain'])
        ->middleware(['verified','role:user']);

    Route::patch('/dashboard/project/{slug}' ,[\App\Http\Controllers\Dashboard\User\ProjectsController::class , 'update_resource'])
        ->middleware(['verified','role:user']);
    Route::get('/dashboard/project/{slug}/certificate' , [\App\Http\Controllers\Dashboard\User\ProjectsController::class , 'certificate'])
        ->middleware(['verified','role:user']);


//    Route::get('verify-email', EmailVerificationPromptController::class)
//        ->name('verification.notice');
//
//    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//        ->middleware(['signed', 'throttle:6,1'])
//        ->name('verification.verify');
//
//    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//        ->middleware('throttle:6,1')
//        ->name('verification.send');
//
//    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
//        ->name('password.confirm');
//
//    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
//
//    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
//
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
