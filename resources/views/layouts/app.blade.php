<!DOCTYPE html>
<html lang="en" itemscope itemtype="https://schema.org/WebPage">
<head>
    <!-- Primary Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Primary Meta Tags -->
<title>@yield('title', 'Health Versations | Premium Wellness Products & Personalized Health Coaching')</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="description" content="@yield('meta_description', 'Discover premium wellness products and personalized coaching for holistic well-being.')">
<meta name="keywords" content="@yield('meta_keywords', 'wellness products, health coaching, holistic health, natural supplements, Health Versations')">
<meta name="author" content="@yield('meta_author', 'Health Versations')">
<meta name="robots" content="@yield('meta_robots', 'index, follow')">
<link rel="canonical" href="@yield('canonical_url', request()->url())">

    <link rel="shortcut icon" href="{{ asset('Assets/images/logo.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Favicon -->
<link rel="icon" href="{{ asset('Assets/images/favicon.png') }}" type="image/png">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="Health Versations">
<meta property="og:title" content="@yield('og_title', 'Health Versations | Premium Wellness Products & Personalized Health Coaching')">
<meta property="og:description" content="@yield('og_description', 'Discover premium wellness products and personalized coaching for holistic well-being.')">
<meta property="og:image" content="@yield('og_image', asset('Assets/images/health-versations-social.jpg'))">
<meta property="og:url" content="{{ request()->url() }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@healthversations">
<meta name="twitter:creator" content="@healthversations">
<meta name="twitter:title" content="@yield('twitter_title', 'Health Versations | Premium Wellness Products & Personalized Health Coaching')">
<meta name="twitter:description" content="@yield('twitter_description', 'Discover premium wellness products and personalized coaching for holistic well-being.')">
<meta name="twitter:image" content="@yield('twitter_image', asset('Assets/images/health-versations-social.jpg'))">

    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" as="style">
    <link rel="preload" href="{{asset('Assets/css/styles.css') }}" as="style">
    <link rel="preload" href="Assets/images/logo.png" as="image">

    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">

    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('Assets/css/styles.css') }}">

    <!-- Swiper JS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- JSON-LD: Organization Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Health Versations",
  "url": "https://www.healthversations.com",
  "logo": "https://www.healthversations.com/Assets/images/logo.png",
  "sameAs": [
    "https://www.facebook.com/healthversations",
    "https://twitter.com/healthversations",
    "https://www.instagram.com/healthversations"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+254700000000",
    "contactType": "Customer Service"
  }
}
</script>

<!-- Page-specific breadcrumb structured data -->
@stack('json-ld')

</head>

<body class="bg-gray-100 text-gray-800 font-poppins">
       <body data-cart-url="{{ route('cart.add') }}">

    <!-- Schema.org Breadcrumb Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.healthversation.com"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Products",
          "item": "https://www.healthversation.com/healthversations/products"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Coaching Packages",
          "item": "https://www.healthversation.com/ebooks"
        }
      ]
    }
    </script>

    @if(session('success'))
        <div id="successMessage" data-message="{{ session('success') }}"></div>
    @endif

    @if(session('error'))
        <div id="errorMessage" data-message="{{ session('error') }}"></div>
    @endif



    <header class="bg-white shadow-md">
        <nav class="container mx-auto flex items-center justify-between py-4 px-6 md:px-12">
            <!-- Logo -->
            <div>
                <a href="/">
                    <img src="{{asset ('Assets/images/logo.png') }}" alt="Health Versations" class="h-20">
                </a>
            </div>

            <!-- Navbar Links -->
            <ul class="hidden md:flex space-x-6 font-medium">
                <li><a href="/" class="hover:text-green-600">Home</a></li>
                <li><a href="{{ route('all.products') }}" class="hover:text-green-600">Products</a></li>
                <li><a href="{{route ('ebooks.show') }}" class="hover:text-green-600">Ebooks</a></li>
                <li><a href="{{ route('contact.health') }}" class="hover:text-green-600">Talk to Us</a></li>
                <li><a href="{{ route('about.health') }}" class="hover:text-green-600">About Us</a></li>
                <li><a href="{{ route('frontend.blogs.index') }}" class="block text-gray-800 hover:text-green-600">Articles</a></li>
                <li><a href="{{route ('orders.track') }}" class="hover:underline">Track order</a> </li>
            </ul>

            <!-- CTA Button -->
            <div>
                <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] text-white px-6 py-2 text-sm font-semibold uppercase hover:bg-green-700">Create package</a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="block md:hidden text-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg">
            <ul class="space-y-4 p-6">
                <li><a href="/" class="block text-gray-800 hover:text-green-600">Home</a></li>
                <li><a href="{{ route('all.products') }}" class="block text-gray-800 hover:text-green-600">Products</a></li>
                <li><a href="{{route ('ebooks.show') }}" class="block text-gray-800 hover:text-green-600">Ebooks</a></li>

                <li><a href="{{ route('contact.health') }}" class="block text-gray-800 hover:text-green-600">Talk to Us</a></li>
                <li><a href="{{ route('frontend.blogs.index') }}" class="block text-gray-800 hover:text-green-600">Articles</a></li>
                <li><a href="{{route ('about.health') }}" class="block text-gray-800 hover:text-green-600">About Us</a></li>
                <li><a href="{{route ('orders.track') }}" class="hover:underline">Track order</a> </li>
            </ul>
        </div>
    </header>

    <!-- Promotional Row Section -->
    <div class="bg-[#93C754] text-black text-center py-2 text-sm font-medium">
        <span class="hidden md:inline text-white">This is why you should trust our products</span>
        <span class="hidden md:inline">&nbsp; &nbsp; Premium Quality | 100% Natural | Tried and Tested | Expertly Created | Nutritional Benefits | Rejuvenate Your Health</span>
        <marquee class="md:hidden text-white">This is why you should trust our products &nbsp; &nbsp; <span class="text-black"> Premium Quality | 100% Natural | Tried and Tested | Expertly Created | Nutritional Benefits | Rejuvenate Your Health </span></marquee>
    </div>

        @yield('content')


    </div>
    <!-- Footer Section -->
 <!-- Floating Cart Button -->
    <a href="{{ route('cart.index') }}" id="cart-button" class="fixed bottom-4 right-4 bg-[#93C754] text-white p-4 rounded-full shadow-lg hover:bg-opacity-80 transition flex items-center justify-center">
        <img src="{{ asset('Assets/images/shopping-cart.svg') }}" alt="Cart Icon" class="w-6 h-6">
        <span id="cart-counter" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center">
            {{ array_sum(array_column(session('cart', []), 'quantity')) }}
        </span>
    </a>

    <footer class="bg-teal-800 text-white">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row items-start justify-between gap-8 py-8">

            <!-- Logo and Call to Action -->
            <div class="flex flex-col items-start gap-4">
                <div class="flex items-center gap-2">
                    <img src="{{asset('Assets/images/white logo.png')}}" alt="Health Versations Logo" class="h-16">
                    <span class="text-2xl font-semibold text-green-300">HEALTH VERSATIONS</span>
                </div>
                <a href="{{ route('custompackages.create') }}">
                    <button class="bg-green-500 hover:bg-green-600 text-teal-800 px-6 py-2 font-medium">
                        Create a Custom Package for me
                    </button>
                </a>
            </div>

            <!-- Quick Links -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-semibold text-green-300">Quick Links</h3>
                <a href="#" class="hover:underline">Home</a>

                <a href="{{ route('versation.healthy') }}" class="hover:underline">Healthy Living</a>
                <a href="{{ route('videos.show') }}" class="hover:underline">Videos</a>
                <a href="{{ route('frontend.blogs.index') }}" class="hover:underline">Blogs</a>
                <a href="{{ route('orders.track') }}" class="hover:underline">Track Order</a>
            </div>

            <!-- Support and Information -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-semibold text-green-300">Support</h3>
                <a href="{{ route('contact.health') }}" class="hover:underline">Talk to Us</a>
                <a href="{{ route('about.health') }}" class="hover:underline">About Us</a>
                <a href="{{ route('faq.versation') }}" class="hover:underline">FAQs</a>
                <a href="#" class="hover:underline" id="rateUsButton">Rate Us</a>
            </div>

            <!-- Legal -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-semibold text-green-300">Legal</h3>
                <a href="{{ route('returns.refunds') }}" class="hover:underline">Return and Refund</a>
                <a href="{{ route('terms.versation') }}" class="hover:underline">Terms & Conditions</a>
                <a href="{{ route('privacypolicy.versation') }}" class="hover:underline">Privacy Policy</a>
            </div>

            <!-- Contact Information -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-semibold text-green-300">Contact Us</h3>
                <p>P.O. BOX: <span class="text-sm font-semibold text-[#93C754]"></span></p>
                <p>TELEPHONE: <span class="text-sm font-semibold text-[#93C754]">+254717813291</span></p>
                <p>EMAIL: <span class="text-sm font-semibold text-[#93C754]">info@healthversation.com</span></p>
                <div class="flex gap-4 mt-2">
                    <a href="https://www.facebook.com/share/1D5etZeuVs/" target="_blank" class="hover:opacity-80"><img src="{{asset('Assets/images/facebook.svg')}}" alt="Facebook" class="h-6"></a>
                    <a href="https://wa.me/254717813291" class="hover:opacity-80">
                        <img src="{{asset ('Assets/images/whatsapp.svg')}}" alt="WhatsApp" class="h-6">
                      </a>
                    <a href="https://www.instagram.com/health_versations" target="_blank" class="hover:opacity-80"><img src="{{asset ('Assets/images/instagram.svg')}}" alt="Instagram" class="h-6"></a>
                    <a href="https://www.linkedin.com/in/beatrice-kariuki-bb03b2a1/" target="_blank"  class="hover:opacity-80"><img src="{{asset ('Assets/images/linkedIn.svg')}}" alt="LinkedIn" class="h-6"></a>
                    <a href="https://www.tiktok.com/@healthversations" target="_blank" class="hover:opacity-80"><img src="{{asset ('Assets/images/tiktok.svg')}}" alt="TikTok" class="h-6"></a>
                </div>
            </div>
        </div>

        <hr class="color-white m-4">

        <!-- Copyright Section -->
        <div class="bg-[#0A4040] text-center py-4 text-white">
            <p>&copy; <span id="current-year"></span> HEALTH VERSATIONS. All rights reserved.</p>
<p style="color: #93C754;">
    Developed and designed by <a href="https://quickofficepointe.co.ke" target="_blank" style="color: #93C754; text-decoration: underline;">
        Quick Office Pointe
    </a>.
</p>

        </div>
    </footer>

    <!-- FeedBack Modal -->
    <div id="rateUsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <!-- Close Button -->
            <button
                id="closeModal"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800"
            >
                &times;
            </button>

            <!-- Modal Title -->
            <h2 class="text-2xl font-semibold text-emerald-600 text-center mb-6">
                Rate Us
            </h2>
        <!-- Modal Form -->
        <form
        class="space-y-4"
        method="POST"
        action="{{ route('testimonials.store') }}"
        >
        @csrf
        <!-- Full Name -->
        <div>
            <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">
                Full Name
            </label>
            <input
                type="text"
                name="full_name"
                id="fullName"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                placeholder="Enter your full name"
                required
            />
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
            </label>
            <input
                type="email"
                name="email"
                id="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                placeholder="Enter your email"
                required
            />
        </div>
        <!-- Rating (Stars) -->
        <div>
            <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">
                Rating (1-5 Stars)
            </label>
            <select
                name="rating"
                id="rating"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                required
            >
                <option value="" disabled selected>Select Rating</option>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
        </div>

        <!-- Message -->
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                Message
            </label>
            <textarea
                name="message"
                id="message"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                rows="4"
                placeholder="Enter your message"
                required
            ></textarea>
        </div>

        <button
            type="submit"
            class="w-full bg-[#0A4040] text-[#93C754] font-bold py-3 px-4 hover:bg-emerald-700 transition-colors duration-300 font-medium rounded-lg"
        >
            Rate Us
        </button>
        </form>
        </div>
    </div>
<!-- Add this modal HTML at the bottom of your coaching packages section -->
<div id="enrollmentModal" class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
        <!-- Close Button -->
        <button class="close-enrollment-modal absolute top-4 right-4 text-gray-700 text-2xl hover:text-gray-900">
            &times;
        </button>

        <h2 class="text-2xl font-bold text-[#0A4040] mb-6">Enrollment Information</h2>

        <form id="enrollmentForm">
            <input type="hidden" id="packageId" name="package_id">
            <input type="hidden" id="packagePrice" name="package_price">
            <input type="hidden" id="packageCurrency" name="package_currency">

            <div class="mb-4">
                <label for="enrollmentName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" id="enrollmentName" name="name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition duration-300">
            </div>

            <div class="mb-4">
                <label for="enrollmentEmail" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="enrollmentEmail" name="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition duration-300">
            </div>

            <div class="mb-4">
                <label for="enrollmentPhone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="tel" id="enrollmentPhone" name="phone" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition duration-300">
            </div>

            <div class="mb-4">
                <label for="enrollmentCountry" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <input type="text" id="enrollmentCountry" name="country" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition duration-300">
            </div>

            <div class="flex justify-end">
                <button type="button" class="close-enrollment-modal mr-3 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-300">
                    Cancel
                </button>
                <button type="submit" class="bg-[#0A4040] text-white px-6 py-2 rounded-md shadow-md hover:bg-opacity-90 transition duration-300">
                    Proceed to Payment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Structure -->
<div id="paymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Complete Your Purchase</h3>

                <!-- Updated Purchase form -->
                <form id="purchaseForm" name="RequestforDebit" method="post" action="https://portal.host.iveri.com/Lite/Authorise.aspx">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Package Selected:</label>
                        <input type="text" id="packageName" readonly class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2 border">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Amount (KES):</label>
                        <input type="number" id="purchaseAmount" readonly class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2 border">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Your Email:</label>
                        <input type="email" id="customerEmail" placeholder="you@example.com" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                    </div>

                    <!-- Hidden fields updated for purchase -->
                    <input type="hidden" name="Lite_Order_Amount">
                    <input type="hidden" name="Ecom_ConsumerOrderID" value="AUTOGENERATE">
                    <input type="hidden" name="Ecom_BillTo_Online_Email">
                    <input type="hidden" id="packageDescription" name="Lite_Order_LineItems_Product_1" value="Coaching Package">
                    <input type="hidden" name="Lite_Order_LineItems_Quantity_1" value="1">
                    <input type="hidden" name="Lite_Order_LineItems_Amount_1">
                    <input type="hidden" name="Lite_Merchant_ApplicationId" value="C363DD2D-E71A-4487-A1BA-C223A707C20C">
                    <input type="hidden" name="Lite_Website_Successful_Url" value="https://www.imbankgroup.com/ke/payment-success">
                    <input type="hidden" name="Lite_Website_Fail_Url" value="https://www.imbankgroup.com/ke/payment-fail">
                    <input type="hidden" name="Lite_Website_TryLater_Url" value="https://www.imbankgroup.com/ke/payment-try-later">
                    <input type="hidden" name="Lite_Website_Error_Url" value="https://www.imbankgroup.com/ke/payment-error">
                    <input type="hidden" name="Lite_ConsumerOrderID_PreFix" value="COACHING">
                    <input type="hidden" name="Ecom_Payment_Card_Protocols" value="iVeri">
                    <input type="hidden" name="Ecom_TransactionComplete" value="false">

                    <div class="mt-5 sm:mt-6">
                        <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#93C754] text-base font-medium text-white hover:bg-[#7eae47] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Pay Now via Credit Card/Mpesa
                        </button>
                        <button type="button" id="cancelPayment" class="mt-3 inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('paymentModal');
    const cancelBtn = document.getElementById('cancelPayment');
    const purchaseForm = document.getElementById('purchaseForm');
    const purchaseAmount = document.getElementById('purchaseAmount');
    const packageName = document.getElementById('packageName');
    const packageDescription = document.getElementById('packageDescription');
    const customerEmail = document.getElementById('customerEmail');

    function openModalWithPackage(packageElement) {
        const priceText = packageElement.querySelector('span.text-2xl').textContent;
        const packageTitle = packageElement.querySelector('h3.text-xl').textContent;

        const numericPrice = parseFloat(priceText.replace(/[^0-9.]/g, ''));

        // Populate modal fields
        purchaseAmount.value = numericPrice;
        packageName.value = packageTitle;
        packageDescription.value = packageTitle;

        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        purchaseForm.reset();
    }

    cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.querySelectorAll('.coaching-swiper .swiper-slide a').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const packageCard = this.closest('.swiper-slide');
            openModalWithPackage(packageCard);
        });
    });

    purchaseForm.addEventListener('submit', function (e) {
        let emailInput = customerEmail.value.trim();
        let amount = parseFloat(purchaseAmount.value);

        if (!emailInput || !emailInput.includes('@') || isNaN(amount)) {
            alert("Please provide a valid email and ensure package details are correct.");
            e.preventDefault();
            return;
        }

        const finalAmount = amount * 100; // Convert to cents
        const orderId = "COACH-" + Math.floor(100000 + Math.random() * 900000);

        document.querySelector('input[name="Lite_Order_Amount"]').value = finalAmount;
        document.querySelector('input[name="Ecom_BillTo_Online_Email"]').value = emailInput;
        document.querySelector('input[name="Lite_Order_LineItems_Amount_1"]').value = finalAmount;
        document.querySelector('input[name="Ecom_ConsumerOrderID"]').value = orderId;
    });
});
</script>

    <!-- Add Swiper JS at the end of body -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swipers
        document.addEventListener('DOMContentLoaded', function() {
            // Coaching Packages Swiper
            const coachingSwiper = new Swiper('.coaching-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.coaching-swiper .swiper-button-next',
                    prevEl: '.coaching-swiper .swiper-button-prev',
                },
                pagination: {
                    el: '.coaching-swiper .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                }
            });

            // Blog Swiper
            const blogSwiper = new Swiper('.blog-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.blog-swiper .swiper-button-next',
                    prevEl: '.blog-swiper .swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                }
            });

            // Testimonials Swiper
            const testimonialsSwiper = new Swiper('.testimonials-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                pagination: {
                    el: '.testimonials-swiper .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                }
            });
        });
    </script>

<!-- SweetAlert2 JS -->
<script src="{{asset ('Assets/js/main.js') }}"></script>
<script src="{{asset ('Assets/js/modal.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuBtn = document.getElementById("menu-btn");
        const mobileMenu = document.getElementById("mobile-menu");

        menuBtn.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".order-now-btn").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                let productName = this.getAttribute("data-product-name");
                document.getElementById("productName").value = productName;
                document.getElementById("trackingID").value = generateTrackingID();
                document.getElementById("orderModal").classList.remove("hidden");
            });
        });

        document.getElementById("deliveryMethod").addEventListener("change", function () {
            document.getElementById("deliveryFields").classList.toggle("hidden", this.value !== "delivery");
        });

        let successMessage = document.getElementById("successMessage");
        if (successMessage) {
            setTimeout(() => successMessage.style.display = "none", 5000);
        }
    });

    function closeModal() {
        document.getElementById("orderModal").classList.add("hidden");
    }

    function generateTrackingID() {
        return "TRK" + Math.floor(100000 + Math.random() * 900000);
    }
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMessage.getAttribute('data-message'),
                confirmButtonText: 'OK'
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage.getAttribute('data-message'),
                confirmButtonText: 'OK'
            });
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    document.querySelectorAll('.increase').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const quantityElement = this.parentElement.querySelector('.quantity');
            quantityElement.textContent = parseInt(quantityElement.textContent) + 1;
        });
    });

    document.querySelectorAll('.decrease').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const quantityElement = this.parentElement.querySelector('.quantity');
            const current = parseInt(quantityElement.textContent);
            if (current > 1) quantityElement.textContent = current - 1;
        });
    });

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();

            const productId = this.getAttribute('data-product-id');
            const productCard = this.closest('.bg-white');
            const quantity = parseInt(productCard.querySelector('.quantity').textContent);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const cartUrl = document.body.getAttribute('data-cart-url');

            const cartIcon = this.querySelector('img');
            cartIcon.classList.add('animate-bounce');

            try {
                const response = await fetch(cartUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();

                if (data.success) {
                    const counter = document.getElementById('cart-counter');
                    if (counter) {
                        counter.textContent = data.cart_count;
                        const floatingCart = document.getElementById('cart-button');
                        floatingCart.classList.add('animate-pulse');
                        setTimeout(() => floatingCart.classList.remove('animate-pulse'), 1000);
                    }

                    showToast('Product added to cart!', 'success');
                } else {
                    showToast(data.message || 'Failed to add to cart', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to add to cart', 'error');
            } finally {
                cartIcon.classList.remove('animate-bounce');
            }
        });
    });

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => toast.remove(), 3000);
    }
});
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Coaching Packages Swiper
    const coachingSwiper = new Swiper('.coaching-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.coaching-swiper .swiper-button-next',
            prevEl: '.coaching-swiper .swiper-button-prev',
        },
        pagination: {
            el: '.coaching-swiper .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            },
        }
    });
});
    </script>
<script>
    // Banner Carousel
    document.addEventListener('DOMContentLoaded', function() {
        // Banner carousel
        const bannerContainer = document.querySelector('.banner-container');
        const bannerSlides = document.querySelectorAll('.banner-container > div');
        const bannerDotsContainer = document.querySelector('.banner-dots');
        let currentBannerIndex = 0;

        // Create dots
        bannerSlides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.className = `w-3 h-3 rounded-full ${index === 0 ? 'bg-white' : 'bg-white/50'}`;
            dot.addEventListener('click', () => {
                goToBannerSlide(index);
            });
            bannerDotsContainer.appendChild(dot);
        });

        const bannerDots = document.querySelectorAll('.banner-dots button');

        function goToBannerSlide(index) {
            currentBannerIndex = index;
            const offset = -currentBannerIndex * 100;
            bannerContainer.style.transform = `translateX(${offset}%)`;

            // Update dots
            bannerDots.forEach((dot, i) => {
                dot.className = `w-3 h-3 rounded-full ${i === currentBannerIndex ? 'bg-white' : 'bg-white/50'}`;
            });
        }

        // Auto-rotate banners
        let bannerInterval = setInterval(() => {
            currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
            goToBannerSlide(currentBannerIndex);
        }, 5000);

        // Navigation buttons
        document.querySelector('.banner-prev').addEventListener('click', () => {
            clearInterval(bannerInterval);
            currentBannerIndex = (currentBannerIndex - 1 + bannerSlides.length) % bannerSlides.length;
            goToBannerSlide(currentBannerIndex);
            bannerInterval = setInterval(() => {
                currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
                goToBannerSlide(currentBannerIndex);
            }, 5000);
        });

        document.querySelector('.banner-next').addEventListener('click', () => {
            clearInterval(bannerInterval);
            currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
            goToBannerSlide(currentBannerIndex);
            bannerInterval = setInterval(() => {
                currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
                goToBannerSlide(currentBannerIndex);
            }, 5000);
        });

        // Wellness products slider
        const wellnessContainer = document.getElementById('wellness-slides-container');
        const wellnessSlides = document.querySelectorAll('#wellness-slides-container > div');
        let currentWellnessIndex = 0;
        const slidesToShow = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;

        function updateWellnessSlider() {
            const offset = -currentWellnessIndex * (100 / slidesToShow);
            wellnessContainer.style.transform = `translateX(${offset}%)`;
        }

        document.querySelector('.wellness-prev').addEventListener('click', () => {
            currentWellnessIndex = Math.max(0, currentWellnessIndex - 1);
            updateWellnessSlider();
        });

        document.querySelector('.wellness-next').addEventListener('click', () => {
            currentWellnessIndex = Math.min(
                wellnessSlides.length - slidesToShow,
                currentWellnessIndex + 1
            );
            updateWellnessSlider();
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            const newSlidesToShow = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
            if (newSlidesToShow !== slidesToShow) {
                currentWellnessIndex = 0;
                updateWellnessSlider();
            }
        });
    });
</script>
    <style>
    .animate-bounce {
        animation: bounce 0.5s;
    }

    .animate-pulse {
        animation: pulse 1s;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    </style>
</body>
</html>
