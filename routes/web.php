<?php

use App\Http\Controllers\UserMealPlanController;
use App\Http\Controllers\KCBPaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlockedSlotController;
use App\Http\Controllers\BlogcategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartOrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CoachingEnrollmentController;
use App\Http\Controllers\CoachingpackagesController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ConsultTestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustompackageController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\EbookOrderController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ManualorderController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PackagecategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PrivacypolicyController;
use App\Http\Controllers\ProductcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\TermsconditionController;
use App\Http\Controllers\TestmonyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VersationcardController;
use App\Models\product;
use App\Models\Banner;
use App\Models\blog;
use App\Models\blogcategory;
use App\Models\CoachingPackages;
use App\Models\ConsultTestimonial;
use App\Models\package;
use App\Models\testmony;
use App\Models\versationcard;
// ==================== DEFAULT ROUTE ====================
// ==================== DEFAULT ROUTE ====================
Route::get('/', function () {
    $currency = request()->query('currency', 'usd');
    $coachingpackages = CoachingPackages::with('features')->get();

    // Alternate between old and new products (old, new, old, new...)
    $allProducts = Product::with('images')->get();

    $newProducts = $allProducts->filter(function($product) {
        return $product->created_at->diffInDays(now()) <= 30; // Last 30 days
    })->values();

    $oldProducts = $allProducts->filter(function($product) {
        return $product->created_at->diffInDays(now()) > 30;
    })->values();

    // Interleave old and new products
    $products = collect();
    $maxCount = max($newProducts->count(), $oldProducts->count());

    for ($i = 0; $i < $maxCount; $i++) {
        if ($i < $oldProducts->count()) {
            $products->push($oldProducts[$i]); // Old first
        }
        if ($i < $newProducts->count()) {
            $products->push($newProducts[$i]); // Then new
        }
    }

    $packages = package::all();
    $cards = versationcard::all();
    $banners = Banner::active()->ordered()->get();

    // Get all enabled testimonials
    $testimonials = testmony::where('is_enabled', true)
        ->orderBy('created_at', 'desc')
        ->get();

    // Handle testimonials - check if collection is not empty
    if ($testimonials->isNotEmpty()) {
        // Take the latest one
        $latest = $testimonials->shift();

        // Shuffle the rest
        $shuffled = $testimonials->shuffle();

        // Merge back with latest at the top
        $testimonials = collect([$latest])->merge($shuffled);
    } else {
        // If no testimonials, use empty collection
        $testimonials = collect();
    }

    // Get consultation testimonials for before/after
    $consultTestimonials = ConsultTestimonial::with('measurements')
        ->public()
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();

    $blogs = blog::with('category')
        ->latest()
        ->take(6)
        ->get();

    return view('welcome', compact(
        'products',
        'packages',
        'cards',
        'banners',
        'testimonials',
        'coachingpackages',
        'currency',
        'blogs',
        'consultTestimonials'
    ));
});
Route::get('/consultations/available-slots', [ConsultationController::class, 'getAvailableSlots'])->name('consultations.available-slots');
// ==================== AUTHENTICATION ROUTES ====================
Auth::routes(['verify' => true]);

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ==================== VERIFIED & PROFILE UPDATED ROUTES ====================
Route::middleware(['verified', 'check.profile.updated'])->group(function () {
    Route::get('/home', function () {
        $user = Auth::user();
        switch ($user->role) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('user.dashboard');
            case 0:
                return redirect()->route('superadmin.dashboard');
            default:
                return redirect()->route('home');
        }
    })->name('home');
});

// ==================== ROLE-BASED ROUTES ====================
Route::middleware('superuser')->group(function () {
    Route::get('/superadmin/dashboard', [SuperadminController::class, 'dashboard'])->name('superadmin.dashboard');
});

// Add these routes to your web.php file (after the existing routes)

// User Dashboard Routes (role = 2)
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [UserController::class, 'myOrders'])->name('orders');
    Route::get('/orders/{id}', [UserController::class, 'orderDetails'])->name('orders.show');
    Route::get('/consultations', [UserController::class, 'myConsultations'])->name('consultations');
    Route::get('/ebooks', [UserController::class, 'myEbooks'])->name('ebooks');
    Route::get('/ebooks/download/{id}', [UserController::class, 'downloadEbook'])->name('ebooks.download');
    Route::get('/coaching', [UserController::class, 'myCoaching'])->name('coaching');
    Route::get('/reviews', [UserController::class, 'myReviews'])->name('reviews');
    Route::get('/profile', [UserController::class, 'profileSettings'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [UserController::class, 'changePasswordForm'])->name('change-password');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password.update');
 Route::prefix('meal-plan')->name('meal-plan.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'mealPlanDashboard'])->name('dashboard');
        Route::get('/current-week', [UserController::class, 'mealPlanCurrentWeek'])->name('current-week');
        Route::get('/weekly-summary', [UserController::class, 'mealPlanWeeklySummary'])->name('weekly-summary');
        Route::post('/save-tracking', [UserController::class, 'saveDailyTracking'])->name('save-tracking');
        Route::post('/save-meal-log', [UserController::class, 'saveMealLog'])->name('save-meal-log');
        Route::post('/submit-assessment', [UserController::class, 'submitWeeklyAssessment'])->name('submit-assessment');
    });
    });

Route::put('/custom-packages/{id}/update-status', [CustomPackageController::class, 'updateStatus'])->name('custompackages.updateStatus');
// ==================== ADMIN ROUTES ====================
Route::middleware('admin')->group(function () {
    // Dashboard
    // Blocked Slots Management
    // Add this inside your admin middleware group
Route::get('/admin/blocked-slots/count', [BlockedSlotController::class, 'getCount'])->name('admin.blocked-slots.count');
Route::get('/admin/blocked-slots', [BlockedSlotController::class, 'index'])->name('admin.blocked-slots.index');
Route::post('/admin/blocked-slots', [BlockedSlotController::class, 'store'])->name('admin.blocked-slots.store');
Route::delete('/admin/blocked-slots/{id}', [BlockedSlotController::class, 'destroy'])->name('admin.blocked-slots.destroy');
    // In your admin routes group
Route::get('/admin/reviews', [ReviewController::class, 'adminIndex'])->name('admin.reviews.index');
Route::post('/admin/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
Route::delete('/admin/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('admin.reviews.reject');
Route::post('/admin/reviews/bulk-action', [ReviewController::class, 'bulkAction'])->name('admin.reviews.bulk-action');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/reviews/pending-count', [ReviewController::class, 'getPendingCount'])->name('admin.reviews.pending-count');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('consult/testimonials', [ConsultTestimonialController::class, 'index'])
    ->name('consult.admin.testimonials.index');

// Store new testimonial
Route::post('consult/testimonials', [ConsultTestimonialController::class, 'store'])
    ->name('consult.testimonials.store');

// Update testimonial
Route::put('consult/testimonials/{id}', [ConsultTestimonialController::class, 'update'])
    ->name('consult.testimonials.update');

// Delete testimonial
Route::delete('consult/testimonials/{id}', [ConsultTestimonialController::class, 'destroy'])
    ->name('consult.testimonials.destroy');

// Toggle featured status
Route::post('consult/testimonials/{consultTestimonial}/toggle-featured', [ConsultTestimonialController::class, 'toggleFeatured'])
    ->name('consult.testimonials.toggle-featured');

// Bulk actions
Route::post('consult/testimonials/bulk-action', [ConsultTestimonialController::class, 'bulkAction'])
    ->name('consult.testimonials.bulk-action');
    // Update a user
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

    // Delete a user
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    // Product Categories
    Route::get('/productcategories', [ProductcategoryController::class, 'index'])->name('productcategories.index');
    Route::post('/productcategories', [ProductCategoryController::class, 'store'])->name('productcategories.store');
   Route::get('/admin/productcategories/{productCategory}/edit', [ProductCategoryController::class, 'edit'])->name('productcategories.edit');
    Route::put('/productcategories/{productCategory}', [ProductCategoryController::class, 'update'])->name('productcategories.update');
    Route::delete('/productcategories/{productCategory}', [ProductCategoryController::class, 'destroy'])->name('productcategories.destroy');
// Add discount update route
Route::put('/admin/products/{id}/discount', [ProductController::class, 'updateDiscount'])->name('products.update.discount');
    // Products
    Route::get('/allproducts', [ProductController::class, 'index'])->name('products.index');
    Route::post('/allproducts', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
   // To this:
Route::put('/allproducts/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/allproducts/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/admin/products/{product}/variants', [ProductController::class, 'getVariants'])->name('products.variants');
    Route::delete('/admin/products/variants/{variant}', [ProductController::class, 'deleteVariant'])->name('variants.destroy');
    Route::delete('/admin/products/images/{image}', [ProductController::class, 'deleteImage'])->name('images.destroy');

    // Product Variants
    Route::get('/{product}/variant', [ProductController::class, 'viewVariants'])->name('product.variants');
    Route::post('/{product}/variants', [ProductController::class, 'storeVariant'])->name('products.variants.store');
    Route::put('/variants/{variant}', [ProductController::class, 'updateVariant'])->name('products.variants.update');
    Route::delete('/variants/{variant}', [ProductController::class, 'destroyVariant'])->name('products.variants.destroy');

    // Package Categories
    Route::get('packagecategories', [PackagecategoryController::class, 'index'])->name('packagecategories.index');
    Route::post('packagecategories', [PackageCategoryController::class, 'store'])->name('packagecategories.store');
    Route::get('packagecategories/{id}', [PackageCategoryController::class, 'show'])->name('packagecategories.show');
    Route::put('packagecategories/{id}', [PackageCategoryController::class, 'update'])->name('packagecategories.update');
    Route::delete('packagecategories/{id}', [PackageCategoryController::class, 'destroy'])->name('packagecategories.destroy');

    // Packages
    Route::get('all/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create');
    Route::post('post/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::put('packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('destroy/packages/{id?}', [PackageController::class, 'destroy'])->name('packages.destroy');

    // Orders Management
     Route::get('consultationorders/', [ConsultationController::class, 'show'])->name('admin.const-orders.index');
    Route::put('ebooksorder/{id}', [EbookOrderController::class, 'update'])->name('admin.ebook-orders.update');
    Route::get('cart/order', [CartOrderController::class, 'index'])->name('admin.cart-orders.index');
    Route::put('cartorder/{id}', [CartOrderController::class, 'update'])->name('admin.cart-orders.update');

    // Banners
    Route::get('/admin/banners', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/admin/banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/admin/banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/admin/banners/{id}', [BannerController::class, 'show'])->name('admin.banners.show');
    Route::get('/admin/banners/{id}/edit', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('/admin/banners/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/admin/banners/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    Route::post('/admin/banners/update-order', [BannerController::class, 'updateOrder'])->name('admin.banners.update-order');
    Route::post('/admin/banners/{id}/toggle-status', [BannerController::class, 'toggleStatus'])->name('admin.banners.toggle-status');

    // Coaching Packages
    Route::get('/coaching-packages', [CoachingpackagesController::class, 'index'])->name('admin.coaching-packages.index');
    Route::post('/coaching-packages', [CoachingpackagesController::class, 'store'])->name('admin.coaching-packages.store');
    Route::put('/coaching-packages/{coachingPackage}', [CoachingpackagesController::class, 'update'])->name('admin.coaching-packages.update');
    Route::delete('/coaching-packages/{coachingPackage}', [CoachingpackagesController::class, 'destroy'])->name('admin.coaching-packages.destroy');
    Route::post('/coaching-packages/update-order', [CoachingpackagesController::class, 'updateOrder'])->name('admin.coaching-packages.update-order');

    // Versation Cards
    Route::get('versationcards', [VersationcardController::class, 'index'])->name("versation.index");
    Route::post('versationcards', [VersationCardController::class, 'store'])->name('versation.store');
    Route::get('versationcards/{id}', [VersationCardController::class, 'show'])->name('versation.show');
    Route::put('versationcards/{id}', [VersationCardController::class, 'update'])->name('versation.update');
    Route::delete('versationcards/{id}', [VersationCardController::class, 'destroy'])->name('versation.destroy');

    // Blog Categories
    Route::get('/blogcategory', [BlogcategoryController::class, 'index'])->name('blogcategories.index');
    Route::post('/blogcategory', [BlogcategoryController::class, 'store'])->name('blogscategory.store');
    Route::put('/blogcategory/{category}', [BlogcategoryController::class, 'update'])->name('blogscategory.update');
    Route::delete('/blogcategory/{category}', [BlogcategoryController::class, 'destroy'])->name('blogscategory.destroy');

    // Blogs
    Route::get('admin/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::post('post/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::put('update/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('destroy/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

    // Privacy Policy
    Route::get('/privacy-policy', [PrivacypolicyController::class, 'index'])->name('privacy.index');
    Route::post('/privacy-policy/store', [PrivacyPolicyController::class, 'store'])->name('privacy.store');
    Route::post('/privacy-policy/update', [PrivacyPolicyController::class, 'update'])->name('privacy.update');
    Route::delete('/privacy-policy', [PrivacyPolicyController::class, 'destroy'])->name('privacy.destroy');

    // Terms and Conditions
    Route::get('/terms-and-condition', [TermsconditionController::class, 'index'])->name('terms.index');
    Route::post('/terms-and-conditions/store', [TermsconditionController::class, 'store'])->name('terms.store');
    Route::post('/terms-and-conditions/update', [TermsconditionController::class, 'update'])->name('terms.update');
    Route::delete('/terms-and-conditions/{id}', [TermsconditionController::class, 'destroy'])->name('terms.destroy');

    // Newsletter & Testimonials
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('admin.newsletter.index');
    Route::put('/newsletter/{id}', [NewsletterController::class, 'update'])->name('newsletter.update');
    Route::delete('/newsletter/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('/testimonials', [TestmonyController::class, 'index'])->name('admin.testimonials.index');
    Route::put('/testimonials/{id}', [TestmonyController::class, 'update'])->name('admin.testimonials.update');

    // Ebooks
    Route::get('/vies/ebooks', [EbookController::class, 'index'])->name('admin.ebook.index');
    Route::post('/post/ebooks', [EbookController::class, 'store'])->name('admin.ebooks.store');
    Route::put('/ebooks/{ebook}', [EbookController::class, 'update'])->name('admin.ebooks.update');
    Route::delete('/ebooks/{ebook}', [EbookController::class, 'destroy'])->name('admin.ebooks.destroy');

    // Messages & Quotes
    Route::get('/allmessages', [ContactController::class, 'show'])->name('all.messages');
    Route::get('/customqoutes', [CustompackageController::class, 'index'])->name('custom.qoutes');
Route::prefix('meal-plans')->name('admin.meal-plans.')->group(function () {
    Route::get('/', [UserMealPlanController::class, 'index'])->name('index');
    Route::get('/create', [UserMealPlanController::class, 'create'])->name('create');
    Route::post('/', [UserMealPlanController::class, 'store'])->name('store');
    Route::get('/{userMealPlan}', [UserMealPlanController::class, 'show'])->name('show');
    Route::get('/{userMealPlan}/edit', [UserMealPlanController::class, 'edit'])->name('edit');
    Route::put('/{userMealPlan}', [UserMealPlanController::class, 'update'])->name('update');
    Route::delete('/{userMealPlan}', [UserMealPlanController::class, 'destroy'])->name('destroy');
    Route::post('/{userMealPlan}/week/{weekNumber}/content', [UserMealPlanController::class, 'uploadWeeklyContent'])->name('upload-week');
    Route::post('/{userMealPlan}/week/{weekNumber}/complete', [UserMealPlanController::class, 'completeWeek'])->name('complete-week');
    Route::get('/{userMealPlan}/tracking', [UserMealPlanController::class, 'viewTracking'])->name('tracking');
    Route::get('/{userMealPlan}/assessments', [UserMealPlanController::class, 'viewAssessments'])->name('assessments');
    Route::post('/{userMealPlan}/week/{weekNumber}/feedback', [UserMealPlanController::class, 'addAssessmentFeedback'])->name('add-feedback');
    Route::patch('/{userMealPlan}/status', [UserMealPlanController::class, 'updateStatus'])->name('update-status');
});

    });

// ==================== PUBLIC ROUTES ====================
// Form Submissions
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/product/{productId}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe.store');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('store/testimonial', [TestmonyController::class, 'store'])->name('testimonials.store');

// Product & Package Views
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/healthversations/packages', [PackageController::class, 'allpackages'])->name('premiumpackages');
Route::get('/healthversations/products', [ProductController::class, 'allproducts'])->name('all.products');
Route::get('/premium-packages', [PackageController::class, 'premiumpackages'])->name('packages.premium');
Route::get('/all-packages', [PackageController::class, 'allpackages'])->name('packages.all');

// Content Pages
Route::get('/articles', [BlogController::class,'blogview'])->name('article.versation');
Route::get('/healthliving', [PackageController::class,'healthyliving'])->name('versation.healthy');
Route::get('/aboutus', [BlogController::class,'aboutus'])->name('about.versation');
Route::get('/privacypolicy', [PrivacypolicyController::class,'privacy'])->name('privacypolicy.versation');
Route::get('/termsandconditions', [TermsconditionController::class,'terms'])->name('terms.versation');
Route::get('/faqs', [FaqController::class,'faqs'])->name('faq.versation');
Route::get('/terms-and-conditions', [TermsconditionController::class, 'terms'])->name('terms.frontend');
Route::get('/aboutus', [ContactController::class, 'aboutus'])->name('about.health');
Route::get('/talktous', [ContactController::class, 'index'])->name('contact.health');
Route::get('/returns-and-refunds', [ContactController::class, 'refundndreturn'])->name('returns.refunds');

// Blogs
Route::get('/blogs', [BlogController::class, 'blogs'])->name('frontend.blogs.index');
Route::get('/article/{slug}', [BlogController::class, 'show'])->name('frontend.blogs.show');

// FAQ Management
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
Route::put('/faqs/{id}', [FaqController::class, 'update'])->name('faqs.update');
Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('faqs.destroy');
Route::get('/faqs/versation', [FaqController::class, 'versation'])->name('faq.versation');

// Orders
Route::post('/order/submit', [OrderController::class, 'store'])->name('order.submit');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/order/{slug}', [OrderController::class, 'showOrderPage'])->name('order.page');
Route::get('/track-order', [OrderController::class, 'track'])->name('orders.track');

// Videos
Route::get('/videos', [VideoController::class, 'showVideos'])->name('videos.show');
Route::get('videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('videos/show', [VideoController::class, 'showVideos'])->name('videos.show');
Route::post('videos', [VideoController::class, 'store'])->name('videos.store');
Route::get('videos/{id}/edit', [VideoController::class, 'edit'])->name('videos.edit');
Route::put('videos/{video}', [VideoController::class, 'update'])->name('videos.update');
Route::delete('videos/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');

// Custom Packages
Route::post('/orders/store', [ManualorderController::class, 'store'])->name('order.store');
Route::get('/custompackages/create', [CustompackageController::class, 'create'])->name('custompackages.create');
Route::post('/custompackages', [CustomPackageController::class, 'store'])->name('custompackages.store');

// Cart
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');

// Consultations
Route::get('/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');

// Ebooks
  Route::get('ebookorders/', [EbookOrderController::class, 'index'])->name('admin.ebook-orders.index');
Route::get('/ebooks', [EbookController::class, 'show'])->name('ebooks.show');
Route::post('/ebooks/purchase', [EbookController::class, 'purchase'])->name('ebooks.purchase');
Route::get('/ebook/download/{order}/{token}', [EbookOrderController::class, 'download'])->name('ebook.download');

// Payment Processing
Route::post('/payments/initialize', [PaymentController::class, 'initialize']);
Route::post('/payment/token', [PaymentController::class, 'generateToken'])->name('payment.token');
Route::match(['get', 'post'], '/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::match(['get', 'post'], '/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::match(['get', 'post'], '/payment/try-later', [PaymentController::class, 'tryLater'])->name('payment.try');
Route::match(['get', 'post'], '/payment/error', [PaymentController::class, 'error'])->name('payment.error');
Route::get('/payment/retry', [PaymentController::class, 'retry'])->name('payment.retry');

// Order Processing
Route::post('/ebook/process-order', [EbookOrderController::class, 'process'])->name('ebook.order.process');
Route::get('/ebook/payment/success', [EbookOrderController::class, 'success'])->name('ebook.payment.success');
Route::get('/ebook/payment/fail', [EbookOrderController::class, 'fail'])->name('ebook.payment.fail');
Route::post('/cart/process-order', [CartOrderController::class, 'process'])->name('cart.order.process');
Route::post('/coaching/enroll', [CoachingEnrollmentController::class, 'process'])->name('coaching.process');
Route::post('/consultation/payment/process', [ConsultationController::class, 'processPayment'])->name('consultation.payment.process');

// Public routes (for website visitors)
Route::get('/testimonials/coaching', [ConsultTestimonialController::class, 'publicIndex'])
    ->name('testimonials.index');



// Order Processing
Route::post('/cart/add-delivery', [CartController::class, 'addDelivery'])->name('cart.add-delivery');

// KCB Payment Routes - NEW UNIFIED APPROACH
Route::prefix('kcb-payment')->group(function () {
    // Single endpoint for ALL payment types
    Route::post('/initiate', [KCBPaymentController::class, 'initiateKcbPayment'])->name('kcb.payment.initiate');

    // Single callback for ALL payment types
    Route::post('/callback', [KCBPaymentController::class, 'handleKcbCallback'])->name('kcb.payment.callback');

    // Status check - KEEP (same route)
    Route::post('/status', [KCBPaymentController::class, 'checkPaymentStatus'])->name('kcb.payment.status');

    // Test endpoint - KEEP (same route)
    Route::get('/test-auth', [KCBPaymentController::class, 'testKcbAuth'])->name('kcb.test.auth');
});
Route::get('/admin/cart-orders/{id}/details', [CartOrderController::class, 'showDetails'])->name('admin.cart-orders.details');
Route::get('/consultations/{consultation}/process-payment', [ConsultationController::class, 'processPayment'])->name('consultations.process-payment');
Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
// In routes/web.php - Add the full namespace
Route::get('/testimonials/{slug}', [App\Http\Controllers\ConsultTestimonialController::class, 'show'])
    ->name('testimonials.show');

    // KCB Payment Routes
Route::get('/payment/kcb/success', [KCBPaymentController::class, 'showSuccess'])->name('kcb.payment.success');
Route::get('/payment/kcb/failure', [KCBPaymentController::class, 'showFailure'])->name('kcb.payment.failure');
Route::get('/product/{product}/quick-view', [App\Http\Controllers\ProductController::class, 'quickView'])->name('product.quick-view');
