<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Health Versation Admin Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Assets/images/logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        gray: {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        }
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8F9FA;
        }

        .sidebar {
            background: linear-gradient(180deg, #166534 0%, #15803d 100%);
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background-color: #FFFFFF !important;
            color: #166534 !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-poppins">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-30 bg-primary-700 shadow-sm h-16">
        <div class="flex items-center justify-between h-full px-4">
            <div class="flex items-center">
                <button class="mr-4 text-white md:hidden" id="mobileSidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="flex items-center" href="{{ route('admin.dashboard') }}">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-2">
                        <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versation Logo" class="h-6">
                    </div>
                    <span class="font-bold text-white text-xl">Health Versation</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="flex items-center text-white focus:outline-none" id="userDropdown">
                        @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                            <img src="{{ Storage::url(Auth::user()->profile->profile_picture) }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                                <i class="fas fa-user-tie text-white"></i>
                            </div>
                        @endif
                        <span class="ml-2 hidden md:inline font-medium">{{ Auth::user()->name }}</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="fixed top-16 left-0 bottom-0 w-64 text-white z-20 overflow-y-auto sidebar hidden md:block"
        id="sidebar">
        <div class="p-4">
            <!-- User Profile -->
            <div class="flex items-center mb-6 p-3 bg-white bg-opacity-10 rounded-lg">
                <div class="relative mr-3">
                    @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                        <img src="{{ Storage::url(Auth::user()->profile->profile_picture) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-user-tie text-white"></i>
                        </div>
                    @endif
                    <span
                        class="absolute bottom-0 right-0 block h-3 w-3 rounded-full bg-green-400 ring-2 ring-primary-700"></span>
                </div>
                <div>
                    <h6 class="font-medium">{{ Auth::user()->name }}</h6>
                    <p class="text-xs opacity-75">Admin</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link active">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </li>

                <li class="mt-4">
                    <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white text-opacity-70">
                        Website Content</p>
                </li>
                <li>
                    <a href="{{ route('admin.banners.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-image mr-3"></i> Banners
                    </a>
                </li>
                <li>
                    <a href="{{ route('blogs.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-blog mr-3"></i> Blog Posts
                    </a>
                </li>
                <li>
                    <a href="{{ route('videos.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-play-circle mr-3"></i> Videos
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ebook.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-book-open mr-3"></i> Ebooks
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ebook-orders.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-shopping-cart mr-3"></i> Ebook Orders
                    </a>
                </li>
<!-- Add this after Versation Cards or before User Interactions -->
<li class="mt-4">
    <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white text-opacity-70">
        Meal Plans
    </p>
</li>
<li>
    <a href="{{ route('admin.meal-plans.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link {{ request()->routeIs('admin.meal-plans.*') ? 'active' : '' }}">
        <i class="fas fa-utensils mr-3"></i> Meal Plans
    </a>
</li>
                <li class="mt-4">
                    <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white text-opacity-70">
                        Services & Products</p>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-box mr-3"></i> Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.cart-orders.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-shopping-bag mr-3"></i> Product Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.coaching-packages.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-graduation-cap mr-3"></i> Coaching Packages
                    </a>
                </li>
                <li>
                    <a href="{{ route('versation.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-credit-card mr-3"></i> Versation Cards
                    </a>
                </li>

                <!-- NEW SECTIONS ADDED HERE -->
                <li class="mt-4">
                    <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white text-opacity-70">
                        User Interactions</p>
                </li>
                <li>
                    <a href="{{ route('all.messages') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-envelope mr-3"></i> Contact Messages
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1" id="unreadMessagesCount">

                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.const-orders.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-receipt mr-3"></i> Consultation Orders
                        <span class="ml-auto bg-yellow-500 text-white text-xs rounded-full px-2 py-1" id="pendingOrdersCount">

                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('consult.admin.testimonials.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-star mr-3"></i> Testimonials
                        <span class="ml-auto bg-orange-500 text-white text-xs rounded-full px-2 py-1" id="pendingTestimonialsCount">

                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.testimonials.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-comment mr-3"></i> Testimonial (Alternative)
                    </a>
                </li>
                <li>
                    <a href="{{ route('custom.qoutes') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-comment-dollar mr-3"></i> Custom Quotes
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.newsletter.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-users mr-3"></i> Subscribers
                        <span class="ml-auto bg-green-500 text-white text-xs rounded-full px-2 py-1">

                        </span>
                    </a>
                </li>

                <li class="mt-4">
                    <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white text-opacity-70">
                        Settings</p>
                </li>
                <li>
                    <a href="{{ route('faqs.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link {{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle mr-3"></i>
                        FAQs Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('terms.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link {{ request()->routeIs('terms.index') ? 'active' : '' }}">
                        <i class="fas fa-file-contract mr-3"></i>
                        Terms and Conditions
                    </a>
                </li>
                <li>
                    <a href="{{ route('privacy.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-shield-alt mr-3"></i>
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="flex items-center px-3 py-3 text-sm rounded-md nav-link">
                        <i class="fas fa-users-cog mr-3"></i>
                        User Management
                    </a>
                </li>

                <li class="mt-4">
                    <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white text-opacity-70">
                        Account</p>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-3 py-3 text-sm rounded-md nav-link text-left">
                            <i class="fas fa-sign-out-alt mr-3"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content ml-0 md:ml-64 mt-16 p-4 min-h-screen" id="mainContent">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Initialize Summernote
        $(document).ready(function() {
            // Initialize on any textarea with class 'summernote'
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        // Toggle sidebar on mobile
        document.getElementById('mobileSidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('hidden');
        });

        // Set active navigation link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-link').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Display flash messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>

    @yield('scripts')
</body>
</html>
