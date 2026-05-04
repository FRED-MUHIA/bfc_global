<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBrandingController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminDonationController;
use App\Http\Controllers\AdminEmailController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProgramRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.store');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminPageController::class, 'dashboard'])->name('dashboard');
    Route::post('/maintenance/toggle', [AdminPageController::class, 'toggleMaintenance'])->name('maintenance.toggle');
    Route::get('/branding', [AdminBrandingController::class, 'edit'])->name('branding.edit');
    Route::put('/branding', [AdminBrandingController::class, 'update'])->name('branding.update');
    Route::get('/donations/settings', [AdminDonationController::class, 'edit'])->name('donations.edit');
    Route::put('/donations/settings', [AdminDonationController::class, 'update'])->name('donations.update');
    Route::get('/emails', [AdminEmailController::class, 'index'])->name('emails.index');
    Route::post('/emails', [AdminEmailController::class, 'store'])->name('emails.store');
    Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
    Route::post('/media', [AdminMediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{media}', [AdminMediaController::class, 'destroy'])->name('media.destroy');
    Route::resource('blog', AdminBlogController::class)->except(['show']);
    Route::resource('books', AdminBookController::class)->except(['show']);
    Route::patch('/events/{event}/toggle-registration', [AdminEventController::class, 'toggleRegistration'])->name('events.toggle-registration');
    Route::resource('events', AdminEventController::class)->except(['show']);
    Route::get('/event-registrations', [EventRegistrationController::class, 'index'])->name('event-registrations.index');
    Route::get('/event-registrations/export', [EventRegistrationController::class, 'export'])->name('event-registrations.export');
    Route::get('/event-registrations/{eventRegistration}', [EventRegistrationController::class, 'show'])->name('event-registrations.show');
    Route::get('/program-registrations', [ProgramRegistrationController::class, 'index'])->name('program-registrations.index');
    Route::get('/program-registrations/export', [ProgramRegistrationController::class, 'export'])->name('program-registrations.export');
    Route::get('/program-registrations/{programRegistration}', [ProgramRegistrationController::class, 'show'])->name('program-registrations.show');
    Route::get('/site-content', [AdminPageController::class, 'editSiteContent'])->name('site-content.edit');
    Route::put('/site-content', [AdminPageController::class, 'updateSiteContent'])->name('site-content.update');
    Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
});

Route::get('/event/register', [EventRegistrationController::class, 'create'])->name('event.register');
Route::post('/event/register', [EventRegistrationController::class, 'store'])->name('event.register.store');
Route::get('/ministry-programs/{program}/register', [ProgramRegistrationController::class, 'create'])->name('program.register');
Route::post('/ministry-programs/{program}/register', [ProgramRegistrationController::class, 'store'])->name('program.register.store');

Route::controller(PageController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/ministry-programs', 'ministryPrograms')->name('ministry-programs');
    Route::get('/ministry-programs/{program}', 'ministryProgram')->name('ministry-programs.show');
    Route::get('/events', 'events')->name('events');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/resources-hub', 'resourcesHub')->name('resources-hub');
    Route::get('/resources-hub/videos', 'programVideos')->name('resources-hub.videos');
    Route::get('/resources-hub/sermons', 'sermons')->name('resources-hub.sermons');
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/shop/{book}', 'bookProduct')->name('shop.book');
    Route::get('/blog', 'blog')->name('blog.index');
    Route::get('/blog/{slug}', 'blogArticle')->name('blog.show');
    Route::get('/get-involved', 'getInvolved')->name('get-involved');
    Route::get('/donate', 'donate')->name('donate');
    Route::get('/contact', 'contact')->name('contact');
});

Route::controller(InquiryController::class)->group(function (): void {
    Route::post('/forms/contact', 'storeContact')->name('forms.contact');
    Route::post('/forms/support', 'storeSupport')->name('forms.support');
    Route::post('/forms/volunteer', 'storeVolunteer')->name('forms.volunteer');
    Route::post('/forms/partnership', 'storePartnership')->name('forms.partnership');
    Route::post('/forms/newsletter', 'storeNewsletter')->name('forms.newsletter');
    Route::post('/forms/donation', 'storeDonation')->name('forms.donation');
});

Route::fallback(function () {
    return response()->view('errors.custom-404', [], 404);
});
