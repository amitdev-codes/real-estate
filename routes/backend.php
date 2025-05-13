<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Dashboard
Route::middleware('auth')->group(function () {
    //profile controller
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'view')->name('user.profile');
        // Route::get('/profile-setting', 'edit')->name('user.profile-setting');
        Route::put('/password', 'update')->name('password.update');
    });


});

//Explore Proporties
Route::get('/explore-property', function () {
    return Inertia::render('backend/pages/explore-property');
})->name('explore-property');

//Favorite Proporties
Route::get('/favorite-property', function () {
    return Inertia::render('backend/pages/favorite-property');
})->name('favorite-property');

// Add Properties
Route::get('/add-property', function () {
    return Inertia::render('backend/pages/add-property');
})->name('add-property');

// Property Details
Route::get('/property-details', function () {
    return Inertia::render('backend/pages/property-detail');
})->name('property-details');

//chat
Route::get('/chat', function () {
    return Inertia::render('backend/pages/chat');
})->name('chat');

//user profile
////profile

// Route::get('/profile', function () {
//     return Inertia::render('backend/pages/user-profile/profile');
// })->name('user.profile');

////profile settings

// Route::get('/profile-setting', function () {
//     // return Inertia::render('backend/pages/user-profile/profile-setting');
// })->name('user.profile-setting');

//blog
//// blogs
Route::get('/blog', function () {
    return Inertia::render('backend/pages/blog/blog');
})->name('blog');

//// blogs details
Route::get('/blog-details', function () {
    return Inertia::render('backend/pages/blog/blog-detail');
})->name('blog-details');

//pages
//// starter
Route::get('/starter', function () {
    return Inertia::render('backend/pages/pages/starter');
})->name('starter');

//// faq
Route::get('/faqs', function () {
    return Inertia::render('backend/pages/pages/faqs');
})->name('faqs');

//// pricing
Route::get('/pricing', function () {
    return Inertia::render('backend/pages/pages/pricing');
})->name('pricing');

//// review
Route::get('/review', function () {
    return Inertia::render('backend/pages/pages/review');
})->name('review');

//// privacy policy
Route::get('/privacy-policy', function () {
    return Inertia::render('backend/pages/pages/privacy');
})->name('privacy-policy');

//// terms and conditions
Route::get('/terms-and-condition', function () {
    return Inertia::render('backend/pages/pages/terms');
})->name('terms-and-condition');

// auth
//// login
// Route::get('/login', function () {
//     return Inertia::render('backend/pages/auth-pages/login', [
//         'canResetPassword' => Route::has('password.request'),
//         'status' => session('status'),
//     ]);
// })->name('backend.login');

//Route::post('/login', [AuthenticatedSessionController::class, 'adminLogin'])->name('login-post');


//// signup
// Route::get('/signup', function () {
//     return Inertia::render('backend/pages/auth-pages/signup');
// })->name('backend.signup');

//// forgot-password
// Route::get('/forgot-password', function () {
//     return Inertia::render('backend/pages/auth-pages/forgot-password');
// })->name('backend.password-request');

//// signup success
Route::get('/signup-success', function () {
    return Inertia::render('backend/pages/auth-pages/signup-success');
})->name('backend.signup-success');

//// reset password
Route::get('/reset-password', function () {

    return Inertia::render('backend/pages/auth-pages/reset-password');
})->name('backend.reset-password');

//// lockscreen
Route::get('/lock-screen', function () {
    return Inertia::render('backend/pages/auth-pages/lock-screen');
})->name('backend.lock-screen');

// miscellaneous
//// comingsoon
Route::get('/comingsoon', function () {
    return Inertia::render('backend/pages/miscellaneous/comingsoon');
})->name('comingsoon');

//// maintenance
Route::get('/maintenance', function () {
    return Inertia::render('backend/pages/miscellaneous/maintenance');
})->name('maintenance');

//// error
Route::get('/error', function () {
    return Inertia::render('backend/pages/miscellaneous/error');
})->name('error');

//// tahnk you
Route::get('/thankyou', function () {
    return Inertia::render('backend/pages/miscellaneous/thankyou');
})->name('thankyou');

//fallbackk

// Route::fallback(function () {
//     return Inertia::render('backend/pages/miscellaneous/error');
// });
