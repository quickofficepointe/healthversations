<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Health Versation Admin Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Assets/images/logo.png') }}">

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

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

    <!-- Summernote -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }

        /* Sidebar styling */
        .sidebar {
            width: 280px;
            transition: all 0.3s ease;
            background: linear-gradient(to bottom, #166534, #15803d);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            transition: all 0.3s ease;
            margin-left: 280px;
            width: calc(100% - 280px);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                height: 100vh;
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }

            .sidebar.active + .overlay {
                display: block;
            }
        }

        /* Navigation items */
        .nav-item {
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .nav-item.active i {
            color: white;
        }

        /* Submenu animation */
        .submenu {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }

        .submenu.active {
            max-height: 500px;
        }

        /* Card styling */
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            background: white;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Summernote styling fixes */
        .note-editor.note-frame {
            margin: 0 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .note-editor.note-frame .note-editing-area .note-editable {
            padding: 1rem !important;
            min-height: 200px;
        }

        /* DataTables styling */
        .dataTables_wrapper {
            padding: 1rem;
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.5rem;
            margin-left: 0.5rem;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.375rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            margin-left: 0.25rem;
            background: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #16a34a;
            color: white !important;
            border: 1px solid #16a34a;
        }

        /* Button styling for DataTables */
        .dt-buttons .dt-button {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            margin-right: 0.5rem;
            color: #374151;
            transition: all 0.2s;
        }

        .dt-buttons .dt-button:hover {
            background-color: #e5e7eb;
            color: #111827;
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>

    @yield('styles')
</head>
<body class="bg-gray-50 font-poppins">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-40 h-16 flex items-center px-4 md:px-6">
        <div class="flex items-center justify-between w-full">
            <!-- Left section: Logo and toggle button -->
            <div class="flex items-center">
                <button id="mobileSidebarToggle" class="lg:hidden text-gray-600 mr-4 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versation Logo" class="h-10">
                    <span class="ml-3 font-bold text-primary-800 hidden md:inline">Health Versation</span>
                </a>
            </div>

            <!-- Right section: Search, notifications, and user menu -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="relative hidden md:block">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent w-64">
                </div>

                <!-- Notifications -->
                <div class="relative">
                    <button class="text-gray-600 hover:text-primary-600 focus:outline-none relative p-2 rounded-full hover:bg-gray-100">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 h-5 w-5 rounded-full bg-red-500 text-xs text-white flex items-center justify-center">3</span>
                    </button>
                </div>

                <!-- User menu -->
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none p-2 rounded-lg hover:bg-gray-100">
                        @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                            <img src="{{ Storage::url(Auth::user()->profile->profile_picture) }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <span class="hidden md:inline font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs hidden md:inline"></i>
                    </button>

                    <!-- User dropdown menu -->
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-user-cog mr-3 text-gray-400"></i> Edit Profile
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-cog mr-3 text-gray-400"></i> Settings
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar and Main Content -->
    <div class="flex pt-16 h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed top-16 left-0 bottom-0 overflow-y-auto lg:static text-white">
            <div class="p-5">
                <!-- User Profile -->
                <div class="flex items-center mb-6 p-3 bg-white/10 rounded-lg backdrop-blur-sm">
                    @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                        <img src="{{ Storage::url(Auth::user()->profile->profile_picture) }}" class="w-10 h-10 rounded-full mr-3 object-cover border-2 border-white/30">
                    @else
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white mr-3 border-2 border-white/30">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <div>
                        <p class="font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-white/70">Administrator</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-white/90 hover:text-white hover:bg-white/10 nav-item active">
                        <i class="fas fa-grid-2 mr-3 text-white/80"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Content Management -->
                    <div class="group">
                        <div class="flex items-center justify-between px-4 py-3 rounded-lg text-white/90 hover:text-white hover:bg-white/10 cursor-pointer nav-item">
                            <div class="flex items-center">
                                <i class="fas fa-newspaper mr-3 text-white/80"></i>
                                <span>Content</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform group-[.active]:rotate-180"></i>
                        </div>
                        <div class="submenu pl-4">
                            <a href="{{ route('admin.banners.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-image mr-3 text-white/70"></i>
                                <span>Banners</span>
                            </a>
                            <a href="{{ route('blogs.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-blog mr-3 text-white/70"></i>
                                <span>Blog Posts</span>
                            </a>
                            <a href="{{ route('videos.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-play-circle mr-3 text-white/70"></i>
                                <span>Videos</span>
                            </a>
                            <a href="{{ route('admin.ebook.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-book-open mr-3 text-white/70"></i>
                                <span>Ebooks</span>
                            </a>
                            <a href="{{ route('admin.ebook-orders.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-shopping-cart mr-3 text-white/70"></i>
                                <span>Ebook Orders</span>
                            </a>
                        </div>
                    </div>

                    <!-- Products & Services -->
                    <div class="group">
                        <div class="flex items-center justify-between px-4 py-3 rounded-lg text-white/90 hover:text-white hover:bg-white/10 cursor-pointer nav-item">
                            <div class="flex items-center">
                                <i class="fas fa-boxes mr-3 text-white/80"></i>
                                <span>Services</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform group-[.active]:rotate-180"></i>
                        </div>
                        <div class="submenu pl-4">
                            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-box mr-3 text-white/70"></i>
                                <span>Products</span>
                            </a>
                            <a href="{{ route('admin.cart-orders.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-shopping-bag mr-3 text-white/70"></i>
                                <span>Product Orders</span>
                            </a>
                            <a href="{{ route('admin.coaching-packages.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-graduation-cap mr-3 text-white/70"></i>
                                <span>Coaching Packages</span>
                            </a>
                            <a href="{{ route('versation.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-credit-card mr-3 text-white/70"></i>
                                <span>Versation Cards</span>
                            </a>
                        </div>
                    </div>

                    <!-- Sales & Orders -->
                    <div class="group">
                        <div class="flex items-center justify-between px-4 py-3 rounded-lg text-white/90 hover:text-white hover:bg-white/10 cursor-pointer nav-item">
                            <div class="flex items-center">
                                <i class="fas fa-chart-line mr-3 text-white/80"></i>
                                <span>Sales & Orders</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform group-[.active]:rotate-180"></i>
                        </div>
                        <div class="submenu pl-4">
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-receipt mr-3 text-white/70"></i>
                                <span>All Orders</span>
                            </a>
                            <a href="{{ route('custom.qoutes') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-comment-dollar mr-3 text-white/70"></i>
                                <span>Custom Quotes</span>
                            </a>
                        </div>
                    </div>

                    <!-- Communication -->
                    <div class="group">
                        <div class="flex items-center justify-between px-4 py-3 rounded-lg text-white/90 hover:text-white hover:bg-white/10 cursor-pointer nav-item">
                            <div class="flex items-center">
                                <i class="fas fa-comments mr-3 text-white/80"></i>
                                <span>Communication</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform group-[.active]:rotate-180"></i>
                        </div>
                        <div class="submenu pl-4">
                            <a href="{{ route('all.messages') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-envelope mr-3 text-white/70"></i>
                                <span>Messages</span>
                            </a>
                            <a href="{{ route('admin.testimonials.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-star mr-3 text-white/70"></i>
                                <span>Testimonials</span>
                            </a>
                            <a href="{{ route('admin.newsletter.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-mail-bulk mr-3 text-white/70"></i>
                                <span>Subscribers</span>
                            </a>
                        </div>
                    </div>

                    <!-- System & Settings -->
                    <div class="group">
                        <div class="flex items-center justify-between px-4 py-3 rounded-lg text-white/90 hover:text-white hover:bg-white/10 cursor-pointer nav-item">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-3 text-white/80"></i>
                                <span>System & Settings</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform group-[.active]:rotate-180"></i>
                        </div>
                        <div class="submenu pl-4">
                            <a href="{{ route('faqs.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-question-circle mr-3 text-white/70"></i>
                                <span>FAQs</span>
                            </a>
                            <a href="{{route ('terms.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-file-contract mr-3 text-white/70"></i>
                                <span>Terms & Conditions</span>
                            </a>
                            <a href="{{ route('privacy.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-shield-alt mr-3 text-white/70"></i>
                                <span>Privacy Policy</span>
                            </a>
                            <a href="{{route ('users.index') }}" class="flex items-center px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 nav-item">
                                <i class="fas fa-users-cog mr-3 text-white/70"></i>
                                <span>User Management</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Overlay for Mobile -->
        <div id="overlay" class="overlay"></div>

        <!-- Main Content -->

            @yield('content')
   
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 px-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-600">&copy; {{ date('Y') }} Health Versation. All rights reserved.</p>
            <p class="text-sm text-gray-600 mt-2 md:mt-0">v1.0.0 | <span id="datetime"></span></p>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Scripts -->
    <script>
        // Toggle sidebar on mobile
        document.getElementById('mobileSidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        });

        // Close sidebar when clicking overlay
        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            this.classList.remove('active');
        });

        // Toggle user dropdown
        document.getElementById('userMenuButton').addEventListener('click', function() {
            document.getElementById('userMenu').classList.toggle('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#userMenuButton') && !event.target.closest('#userMenu')) {
                document.getElementById('userMenu').classList.add('hidden');
            }
        });

        // Toggle submenus
        document.querySelectorAll('.group > div:first-child').forEach(button => {
            button.addEventListener('click', function() {
                const group = this.parentElement;
                const submenu = this.nextElementSibling;

                group.classList.toggle('active');
                submenu.classList.toggle('active');

                const icon = this.querySelector('.fa-chevron-down');
                icon.classList.toggle('rotate-180');
            });
        });

        // Update date and time in footer
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.getElementById('datetime').textContent = now.toLocaleDateString('en-US', options);
        }
        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute

        // Initialize DataTables
        $(document).ready(function() {
            // Initialize DataTables
            $('.data-table').each(function() {
                $(this).DataTable({
                    responsive: true,
                    dom: "<'flex flex-col md:flex-row md:items-center md:justify-between p-4'<'mb-4 md:mb-0'l><'flex flex-col sm:flex-row sm:items-center'<'mb-2 sm:mb-0 sm:mr-4'f><'dt-buttons'B>>>" +
                         "<'w-full overflow-x-auto'tr>" +
                         "<'flex flex-col md:flex-row md:items-center md:justify-between p-4'<'mb-4 md:mb-0'i><'p'>>",
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search...",
                    },
                    buttons: [
                        {
                            extend: 'copy',
                            className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
                        },
                        {
                            extend: 'csv',
                            className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
                        },
                        {
                            extend: 'excel',
                            className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
                        },
                        {
                            extend: 'pdf',
                            className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
                        },
                        {
                            extend: 'print',
                            className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
                        },
                        {
                            extend: 'colvis',
                            className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700'
                        }
                    ]
                });
            });

            // Initialize Summernote
            $('.summernote').each(function() {
                $(this).summernote({
                    height: 300,
                    dialogsInBody: true,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onChange: function(contents) {
                            // Trigger change event for form validation
                            $(this).val(contents).trigger('change');
                        }
                    }
                });
            });
        });

        // Handle logout confirmation
        document.querySelector('form[action="{{ route('logout') }}"]').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Ready to Leave?',
                text: "Are you sure you want to logout?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#166534',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Display flash messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#f0fdf4',
                iconColor: '#16a34a'
            });
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ $error }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    background: '#fef2f2',
                    iconColor: '#dc2626'
                });
            @endforeach
        @endif

        // Initialize charts
        function initCharts() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart');
            if (salesCtx) {
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [{
                            label: 'Sales',
                            data: [12000, 19000, 3000, 5000, 2000, 3000, 4500],
                            backgroundColor: 'rgba(22, 163, 74, 0.2)',
                            borderColor: 'rgba(22, 163, 74, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Orders Chart
            const ordersCtx = document.getElementById('ordersChart');
            if (ordersCtx) {
                new Chart(ordersCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [{
                            label: 'Orders',
                            data: [12, 19, 3, 5, 2, 3, 8],
                            backgroundColor: 'rgba(22, 163, 74, 0.7)',
                            borderColor: 'rgba(22, 163, 74, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', initCharts);
    </script>

    @yield('scripts')
</body>
</html>
