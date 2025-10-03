<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contact Group</title>
    <!-- Include Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <nav class="w-1/4 bg-white p-6">
                <div class="text-center">
                    <img src="/path-to-your-logo.png" alt="Logo" class="w-24 mx-auto">
                </div>
                <ul class="mt-6">
                    <li class="mb-4">
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800">Dashboard</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-gray-600 hover:text-blue-800">Homepage</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-gray-600 hover:text-blue-800">Bulk SMS</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-gray-600 hover:text-blue-800">Bulk Email</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-gray-600 hover:text-blue-800">Inbox</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-gray-600 hover:text-blue-800">Address Book</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
