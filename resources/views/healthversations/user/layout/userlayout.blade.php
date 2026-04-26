{{-- resources/views/healthversations/user/layout/userlayout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Health Versation - User Dashboard')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Assets/images/logo.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
        }

        .sidebar {
            background: linear-gradient(180deg, #166534 0%, #15803d 100%);
            transition: transform 0.3s ease;
        }

        .sidebar-link {
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-link.active {
            background-color: #ffffff;
            color: #166534;
        }

        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending { background: #FEF3C7; color: #92400E; }
        .status-processing { background: #DBEAFE; color: #1E40AF; }
        .status-completed { background: #D1FAE5; color: #065F46; }
        .status-cancelled { background: #FEE2E2; color: #991B1B; }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1000;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 font-poppins">

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

    <!-- Sidebar -->
    <aside class="sidebar fixed left-0 top-0 h-full w-64 text-white z-50 overflow-y-auto" id="sidebar">
        <div class="p-4">
            <!-- Logo -->
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('user.dashboard') }}" class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-2">
                        <img src="{{ asset('Assets/images/logo.png') }}" alt="Logo" class="h-6">
                    </div>
                    <span class="font-bold text-lg">Health Versation</span>
                </a>
                <button class="md:hidden text-white" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="flex items-center mb-8 p-3 bg-white bg-opacity-10 rounded-lg">
                <div class="relative mr-3">
                    @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                        <img src="{{ Storage::url(Auth::user()->profile->profile_picture) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                    @endif
                    <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 ring-2 ring-primary-700"></span>
                </div>
                <div class="flex-1">
                    <h6 class="font-medium text-sm">{{ Auth::user()->name }}</h6>
                    <p class="text-xs opacity-75">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1">
                <a href="{{ route('user.dashboard') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 mr-3"></i> Dashboard
                </a>
<!-- Add this after My Reviews or before the divider -->
<a href="{{ route('user.meal-plan.dashboard') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.meal-plan.*') ? 'active' : '' }}">
    <i class="fas fa-apple-alt w-5 mr-3"></i> My Meal Plan
</a>
                <a href="{{ route('user.orders') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag w-5 mr-3"></i> My Orders
                </a>

                <a href="{{ route('user.consultations') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.consultations*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check w-5 mr-3"></i> Consultations
                </a>

                <a href="{{ route('user.ebooks') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.ebooks*') ? 'active' : '' }}">
                    <i class="fas fa-book-open w-5 mr-3"></i> My Ebooks
                </a>

                <a href="{{ route('user.coaching') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.coaching*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap w-5 mr-3"></i> Coaching
                </a>

                <a href="{{ route('user.reviews') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.reviews*') ? 'active' : '' }}">
                    <i class="fas fa-star w-5 mr-3"></i> My Reviews
                </a>

                <hr class="my-4 border-white border-opacity-20">

                <a href="{{ route('user.profile') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle w-5 mr-3"></i> Profile
                </a>

                <a href="{{ route('user.change-password') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm rounded-md {{ request()->routeIs('user.change-password*') ? 'active' : '' }}">
                    <i class="fas fa-lock w-5 mr-3"></i> Change Password
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="sidebar-link w-full flex items-center px-3 py-2.5 text-sm rounded-md text-left text-red-300 hover:bg-red-500 hover:text-white">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="md:ml-64 min-h-screen">
        <!-- Top Navbar -->
        <nav class="bg-white shadow-sm sticky top-0 z-30">
            <div class="px-4 sm:px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="openSidebar" class="text-gray-600 md:hidden mr-3">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="text-gray-800">
                            <h1 class="text-xl font-semibold">@yield('page-title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="notificationBtn" class="text-gray-600 hover:text-primary-600">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    0
                                </span>
                            </button>
                        </div>

                        <div class="relative">
                            <button id="userMenuBtn" class="flex items-center space-x-2 focus:outline-none">
                                @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                                    <img src="{{ Storage::url(Auth::user()->profile->profile_picture) }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                        <i class="fas fa-user text-primary-600"></i>
                                    </div>
                                @endif
                                <span class="hidden md:inline text-gray-700">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-500 text-sm hidden md:inline"></i>
                            </button>

                            <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden z-50">
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> My Profile
                                </a>
                                <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-shopping-bag mr-2"></i> My Orders
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-4 sm:p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        // User Menu Dropdown
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');

        if (userMenuBtn) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', () => {
                userMenu.classList.add('hidden');
            });
        }

        // Flash messages with SweetAlert
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
