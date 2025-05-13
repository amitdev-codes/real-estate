<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\PropertyEnquiryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// // Landing Pages ////
// home index 1
// Route::get('/', function () {
//     return Inertia::render('frontend/pages/home/index', [
//         'meta' => [
//             'title' => 'Find Your Dream Home With Us',
//             'meta_key' => 'Real Estate, Property & Homes, Land, Rent, Buy, Sell',
//             'meta_description' => 'Search for Real Estate, Property & Homes',
//             'og_title' => 'Find Your Dream Home With Us',
//             'og_description' => 'We buy sell homes',
//             'og_type' => 'website',
//             'og_image' => resource_path('assets/frontend/images/logo-light.png'),
//         ],
//     ]);
// })->name('index-one');

Route::middleware('auth')->group(function () {
    // profile controller
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'view')->name('user.profile');
        // Route::get('/profile-setting', 'edit')->name('user.profile-setting');
        Route::put('/password', 'update')->name('password.update');
    });

    Route::get('inquiry', [PropertyEnquiryController::class, 'index'])->name('inquiry.index');
    Route::post('inquiry', [PropertyEnquiryController::class, 'store'])->name('inquiry.store');

});

Route::get('/', [HomeController::class, 'index'])->name('index-one');
Route::get('/search/categories', [HomeController::class, 'getCategories']);
Route::get('/project/{slug}', [ProjectController::class, 'show'])->name('project.show');


// home index 2
Route::get('/index-two', function () {
    // return Inertia::render('frontend/pages/index/index-two');
    return Inertia::render('frontend/pages/index/index-two', [
        'meta' => [
            'title' => 'Find Your Dream Home With Us Index',
            'meta_key' => 'Real Estate, Property & Homes, Land, Rent, Buy, Sell',
            'meta_description' => 'Search for Real Estate, Property & Homes',
            'og_title' => 'Find Your Dream Home With Us',
            'og_description' => 'We buy sell homes',
            'og_type' => 'website',
            'og_image' => resource_path('assets/frontend/images/logo-dark.png'),
        ],
    ]);
})->name('index-two');

// home index 3
Route::get('/index-three', function () {
    return Inertia::render('frontend/pages/index/index-three');
})->name('index-three');

// home index 4
Route::get('/index-four', function () {
    return Inertia::render('frontend/pages/index/index-four');
})->name('index-four');

// home index 5
Route::get('/index-five', function () {
    return Inertia::render('frontend/pages/index/index-five');
})->name('index-five');

// home index 6
Route::get('/index-six', function () {
    return Inertia::render('frontend/pages/index/index-six');
})->name('index-six');

// home index 7
Route::get('/index-seven', function () {
    return Inertia::render('frontend/pages/index/index-seven');
})->name('index-seven');

// home index 8
Route::get('/index-eight', function () {
    return Inertia::render('frontend/pages/index/index-eight');
})->name('index-eight');

// /// Pages ////
// Buy
Route::get('/buy', function () {
    return Inertia::render('frontend/pages/buy');
})->name('buy');

// Sell
Route::get('/sell', function () {
    return Inertia::render('frontend/pages/sell');
})->name('sell');

// About Us
Route::get('/about-us', function () {
    return Inertia::render('frontend/pages/about-us');
})->name('about-us');

// features
Route::get('/features', function () {
    return Inertia::render('frontend/pages/features');
})->name('features');

// Pricing
Route::get('/pricing', function () {
    return Inertia::render('frontend/pages/pricing');
})->name('pricing');

// FAQs
Route::get('/faqs', function () {
    return Inertia::render('frontend/pages/faqs');
})->name('faqs');

// Contact
Route::get('/contact', function () {
    return Inertia::render('frontend/pages/contact');
})->name('contact');

// // Listings ////
// Grid
Route::get('/grid', function () {
    return Inertia::render('frontend/pages/listing/grid-view/grid');
})->name('grid');

// Grid Sidebar
Route::get('/grid-sidebar', function () {
    return Inertia::render('frontend/pages/listing/grid-view/grid-sidebar');
})->name('grid-sidebar');

// Grid Map
Route::get('/grid-map', function () {
    return Inertia::render('frontend/pages/listing/grid-view/grid-map');
})->name('grid-map');

// List
Route::get('/list', function () {
    return Inertia::render('frontend/pages/listing/list-view/list');
})->name('list');

// List Sidebar
Route::get('/list-sidebar', function () {
    return Inertia::render('frontend/pages/listing/list-view/list-sidebar');
})->name('list-sidebar');

// List Map
Route::get('/list-map', function () {
    return Inertia::render('frontend/pages/listing/list-view/list-map');
})->name('list-map');

// Property Details One
Route::get('/property-detail-one', function () {
    return Inertia::render('frontend/pages/listing/property-detail/property-detail');
})->name('property-detail-one');

// Property Details Two
Route::get('/property-detail-two', function () {
    return Inertia::render('frontend/pages/listing/property-detail/property-detail-two');
})->name('property-detail-two');

// // Agents and Agency /////
// Agents
Route::get('/agents', function () {
    return Inertia::render('frontend/pages/agents/agents');
})->name('agents');

// Agent Profile
Route::get('/agent-profile', function () {
    return Inertia::render('frontend/pages/agents/agent-profile');
})->name('agent-profile');

// Agencies
Route::get('/agencies', function () {
    return Inertia::render('frontend/pages/agencies/agencies');
})->name('agencies');

// Agency Profile
Route::get('/agency-profile', function () {
    return Inertia::render('frontend/pages/agencies/agency-profile');
})->name('agency-profile');

// // Frontend Auth /////
// Login
// Route::get('/auth-login', function () {
//     return Inertia::render('frontend/pages/auth-pages/auth-login');
// })->name('auth-login');

// Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login-post');

// Signup
// Route::get('/auth-signup', function () {
//     return Inertia::render('frontend/pages/auth-pages/auth-signup');
// })->name('auth-signup');

// Reset Password
Route::get('/auth-reset-password', function () {
    return Inertia::render('frontend/pages/auth-pages/auth-re-password');
})->name('auth-reset-password');

// // Utility ////
// Terms and Condition
Route::get('/terms', function () {
    return Inertia::render('frontend/pages/utility/terms');
})->name('terms');

// Privacy Policy
Route::get('/privacy', function () {
    return Inertia::render('frontend/pages/utility/privacy');
})->name('privacy');

// // Blogs Section////
// Blogs
Route::get('/blogs', function () {
    return Inertia::render('frontend/pages/blog/blogs');
})->name('blogs');

// Blog Details
Route::get('/blog-detail', function () {
    return Inertia::render('frontend/pages/blog/blog-detail');
})->name('blog-detail');

// Blogs Sidebar
Route::get('/blog-sidebar', function () {
    return Inertia::render('frontend/pages/blog/blog-sidebar');
})->name('blog-sidebar');

// // Special Pages ////
// Coming Soon
Route::get('/coming-soon', function () {
    return Inertia::render('frontend/pages/special-pages/coming-soon');
})->name('coming-soon');

// Maintenance
Route::get('/maintenance', function () {
    return Inertia::render('frontend/pages/special-pages/maintenance');
})->name('maintenance');

// 404 Page
Route::get('/404', function () {
    return Inertia::render('frontend/pages/special-pages/404');
})->name('404');
