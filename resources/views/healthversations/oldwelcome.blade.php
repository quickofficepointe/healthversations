<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Health Versations - Promoting healthy living through personalized health packages and insightful tips for a better lifestyle.">
    <meta name="keywords" content="health, healthy living, wellness, personalized health packages, lifestyle, fitness, health tips">
    <meta name="author" content="Health Versations">
    <meta name="robots" content="index, follow">
    <title>HEALTH VERSATIONS</title>

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Health Versations - Your Wellness Partner">
    <meta property="og:description" content="Promoting healthy living through personalized health packages and insightful tips for a better lifestyle.">
    <meta property="og:image" content="{{asset ('Assets/images/logo.png') }}">
    <meta property="og:url" content="https://www.healthversations.com">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Health Versations">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Health Versations - Your Wellness Partner">
    <meta name="twitter:description" content="Promoting healthy living through personalized health packages and insightful tips for a better lifestyle.">
    <meta name="twitter:image" content="{{asset ('Assets/images/logo.png') }}">
    <meta name="twitter:site" content="@HealthVersations">
    <meta name="twitter:creator" content="@HealthVersations">

    <!-- Favicon -->
    <link rel="icon" href="{{asset ('Assets/images/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{asset ('Assets/images/logo.png') }}" type="image/png">

    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset ('Assets/style.css') }}">
</head>

<body class="bg-gray-100 text-gray-800">
    <header class="bg-white shadow-md">
        <nav class="container mx-auto flex items-center justify-between py-4 px-6 md:px-12">
            <!-- Logo -->
            <div>
                <a href="#">
                    <img src="{{asset ('Assets/images/logo.png') }}" alt="Health Versations" class="h-20">
                </a>
            </div>

            <!-- Navbar Links -->
            <ul class="hidden md:flex space-x-6 font-medium">
                <li><a href="#" class="hover:text-green-600">Home</a></li>
                <li><a href="#" class="hover:text-green-600">Packaged</a></li>
                <li><a href="#" class="hover:text-green-600">Healthy Living</a></li>
                <li><a href="#" class="hover:text-green-600">Talk to Us</a></li>
                <li><a href="#" class="hover:text-green-600">About Us</a></li>
            </ul>

            <!-- CTA Button -->
            <div>
                <a href="#" class="bg-[#93C754] text-white px-6 py-2 text-sm font-semibold uppercase hover:bg-green-700">Create a package for me</a>
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
                <li><a href="#" class="block text-gray-800 hover:text-green-600">Home</a></li>
                <li><a href="#" class="block text-gray-800 hover:text-green-600">Packaged</a></li>
                <li><a href="#" class="block text-gray-800 hover:text-green-600">Healthy Living</a></li>
                <li><a href="#" class="block text-gray-800 hover:text-green-600">Talk to Us</a></li>
                <li><a href="#" class="block text-gray-800 hover:text-green-600">About Us</a></li>
            </ul>
        </div>
    </header>

    <!-- Promomtional Row Section -->
    <div class="bg-[#93C754] text-black text-center py-2 text-sm font-medium">
        <span class="hidden md:inline text-white">This is why you should trust our products</span>
        <span class="hidden md:inline">&nbsp; &nbsp; Premium Quality | 100% Natural | Tried and Tested | Expertly Created | Nutritional Benefits | Rejuvenate Your Health</span>
        <marquee class="md:hidden text-white">This is why you should trust our products &nbsp; &nbsp; <span class="text-black"> Premium Quality | 100% Natural | Tried and Tested | Expertly Created | Nutritional Benefits | Rejuvenate Your Health </span></marquee>
    </div>

 <!-- Carousel Section -->
<div class="min-h-screen py-10 relative">
    <!-- Main Heading -->
    <h1 id="main-heading" class="text-2xl text-[#0A4040] text-center mb-0 mt-8 transition-opacity duration-500">
        Your wellness is our core concern
    </h1>

    <!-- Carousel Container -->
    <div class="relative overflow-hidden max-w-6xl mx-auto">
        <!-- Slides Container -->
        <div class="flex transition-transform duration-500 ease-in-out" id="slides-container">
            @foreach($products as $product)
                <!-- Slide -->
                <div class="w-full flex-shrink-0">
                    <div class="flex justify-center items-center py-10">
                        <div class="flex flex-col md:flex-row items-center overflow-hidden mx-12">
                            <div class="w-full md:w-2/5">
                                <img src="{{ asset('storage/' . ($product->cover_image ?? 'default.jpg')) }}"
                                     alt="{{ $product->product_name }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="w-full md:w-1/2 p-6 space-y-4">
                                <h2 class="text-4xl font-bold text-[#0A4040]">{{ $product->product_name }}</h2>
                                <p class="text-black">{{ $product->product_description }}</p>
                                <p class="text-[#93C754]">{{ $product->product_tags }}</p>
                                <br>
                                <a href="#" class="inline-block bg-[#93C754] text-white px-6 py-2 text-sm font-semibold uppercase hover:bg-opacity-90 transition-colors">
                                    Order {{ $product->product_name }} Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <button class="absolute left-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-gray-100 focus:outline-none" onclick="moveSlide(-1)">
            <img src="{{ asset('Assets/images/previous-arrow.svg') }}" alt="Right Arrow" class="w-8 h-8">
        </button>
        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-gray-100 focus:outline-none" onclick="moveSlide(1)">
            <img src="{{ asset('Assets/images/next-arrow-forward.svg') }}" alt="Left Arrow" class="w-8 h-8">
        </button>
    </div>
</div>



   <!-- Premium Packages -->
<section id="premium-packages" class="mx-4 pt-8 text-center">
    <h1 class="text-[#0A4040] text-center font-bold" id="premium_title" style="font-family: 'Tangerine', cursive; font-size: 4rem;">Premium</h1>
    <h2 class="text-black text-2xl ">Healthy packages for you</h2>

    <div class="flex flex-wrap justify-center items-stretch gap-4 mt-8">
        @foreach($packages as $package)
        <div class="w-full sm:w-64 md:w-64 lg:w-64 xl:w-64 bg-{{ $package->color ?? '#0A4040' }} text-{{ $package->text_color ?? 'white' }} p-4 text-center flex flex-col">
            <img src="{{ $package->package_image ? asset('storage/' . $package->package_image) : asset('Assets/images/default_package_image.png') }}"
                 alt="{{ $package->package_name }}" class="w-full mb-4" />
            <h2 class="text-xl font-bold mb-2">{{ $package->package_name }}</h2>
            <p>{{ $package->package_description }}</p>
            <button class="bg-white text-[#0A4040] font-bold py-2 px-4 rounded mt-4 hover:bg-green-100">Start my package now</button>
        </div>
        @endforeach
    </div>
</section>
<section>
     <!-- Main Products Section -->
     <div class="container mx-auto px-4 py-8 my-10">
        <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6"></div>
        <h2 class="text-3xl font-bold text-center mb-8 text-[#0A4040]">Healthy Living is our middle name</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card Template -->
            <div class="bg-white shadow-md p-4 border border-black mx-4">
                <img src="Assets/images/product_one.png" alt="Sauerkraut" class="w-full mb-4">
                <h3 class="text-lg font-medium mb-2 text-[#0A4040]">Sauerkraut</h3>
                <p class="text-[#93C754] mb-4">Premium quality | 100% natural | Tried and tested</p>
                <div class="flex items-center justify-between">
                    <button class="bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4 ">
                        Order now
                    </button>
                    <img src="Assets/images/shopping-cart.svg" alt="Shopping Cart" class="h-6 w-6">
                </div>
            </div>

            <div class="bg-white shadow-md p-4 border border-black mx-4">
                <img src="Assets/images/product_one.png" alt="Sauerkraut" class="w-full mb-4">
                <h3 class="text-lg font-medium mb-2 text-[#0A4040]">Sauerkraut</h3>
                <p class="text-[#93C754] mb-4">Premium quality | 100% natural | Tried and tested</p>
                <div class="flex items-center justify-between">
                    <button class="bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4 ">
                        Order now
                    </button>
                    <img src="Assets/images/shopping-cart.svg" alt="Shopping Cart" class="h-6 w-6">
                </div>
            </div>


            <div class="bg-white shadow-md p-4 border border-black mx-4">
                <img src="Assets/images/product_one.png" alt="Sauerkraut" class="w-full mb-4">
                <h3 class="text-lg font-medium mb-2 text-[#0A4040]">Sauerkraut</h3>
                <p class="text-[#93C754] mb-4">Premium quality | 100% natural | Tried and tested</p>
                <div class="flex items-center justify-between">
                    <button class="bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4 ">
                        Order now
                    </button>
                    <img src="Assets/images/shopping-cart.svg" alt="Shopping Cart" class="h-6 w-6">
                </div>
            </div>

            <div class="bg-white shadow-md p-4 border border-black mx-4">
                <img src="Assets/images/product_one.png" alt="Sauerkraut" class="w-full mb-4">
                <h3 class="text-lg font-medium mb-2 text-[#0A4040]">Sauerkraut</h3>
                <p class="text-[#93C754] mb-4">Premium quality | 100% natural | Tried and tested</p>
                <div class="flex items-center justify-between">
                    <button class="bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4 ">
                        Order now
                    </button>
                    <img src="Assets/images/shopping-cart.svg" alt="Shopping Cart" class="h-6 w-6">
                </div>
            </div>

            <div class="bg-white shadow-md p-4 border border-black mx-4">
                <img src="Assets/images/product_one.png" alt="Sauerkraut" class="w-full mb-4">
                <h3 class="text-lg font-medium mb-2 text-[#0A4040]">Sauerkraut</h3>
                <p class="text-[#93C754] mb-4">Premium quality | 100% natural | Tried and tested</p>
                <div class="flex items-center justify-between">
                    <button class="bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4 ">
                        Order now
                    </button>
                    <img src="Assets/images/shopping-cart.svg" alt="Shopping Cart" class="h-6 w-6">
                </div>
            </div>

            <div class="bg-white shadow-md p-4 border border-black mx-4">
                <img src="Assets/images/product_one.png" alt="Sauerkraut" class="w-full mb-4">
                <h3 class="text-lg font-medium mb-2 text-[#0A4040]">Sauerkraut</h3>
                <p class="text-[#93C754] mb-4">Premium quality | 100% natural | Tried and tested</p>
                <div class="flex items-center justify-between">
                    <button class="bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4 ">
                        Order now
                    </button>
                    <img src="Assets/images/shopping-cart.svg" alt="Shopping Cart" class="h-6 w-6">
                </div>
            </div>
        </div>
    </div>

</section>

<!-- CTA Section -->
<section id="cta" class="flex flex-col lg:flex-row items-center justify-between px-8 py-4 lg:px-12 lg:py-2 bg-[#0A4040] m-2 lg:m-4">
    @foreach($cards as $card)
    <!-- Text Section -->
    <div class="w-full lg:w-1/2 text-left mb-4 lg:mb-0 lg:mr-4">
        <h1 class="text-4xl lg:text-5xl font-bold text-[#93C754] mb-4">{{ $card->name }}</h1>
        <p class="text-xl mb-4 text-white">{{ $card->description }}</p>
        <button class="bg-green-500 text-[#0A4040] font-bold py-3 px-6 mb-4 hover:bg-green-600 text-lg">Get me started on {{ strtolower($card->name) }}</button>
        <p class="text-base text-[#93C754]">{{ $card->tags }}</p>
    </div>

    <!-- Image Section -->
    <div class="w-full lg:w-1/2 mt-8 lg:mt-0 lg:ml-4">
        <img src="{{ $card->cover_image ? asset('storage/' . $card->cover_image) : asset('Assets/images/default_image.png') }}"
             alt="{{ $card->name }} Image"
             class="w-full lg:h-[70%] object-contain mx-auto">
    </div>
    @endforeach
</section>



    <!-- Testimonials Section -->
    <section class="py-16 px-4 max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6"></div>
            <h2 class="text-3xl md:text-4xl font-bold text-[#0A4040]">
                This is what our clients think about us
            </h2>
        </div>

        <!-- Testimonials Slider -->
        <div class="testimonials-container">
            <div class="testimonials-track animate-scroll">
                <!-- Original Cards -->
                <div class="testimonial-card p-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#93C754]">Hellen Muda</h3>
                                <div class="flex text-emerald-500">★★★★★</div>
                            </div>
                        </div>
                        <p class="text-gray-600">Working with health-conscious is nothing short of amazing. Their attention to detail and commitment to excellence has definitely gone unmatched here.</p>
                    </div>
                </div>

                <div class="testimonial-card p-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#93C754]">Sarah Johnson</h3>
                                <div class="flex text-emerald-500">★★★★★</div>
                            </div>
                        </div>
                        <p class="text-gray-600">The level of professionalism and care they provide is exceptional. I couldn't be happier with the results and ongoing support.</p>
                    </div>
                </div>

                <div class="testimonial-card p-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#93C754]">Michael Chen</h3>
                                <div class="flex text-emerald-500">★★★★★</div>
                            </div>
                        </div>
                        <p class="text-gray-600">Their innovative approach to health and wellness has transformed my lifestyle. The results speak for themselves!</p>
                    </div>
                </div>

                <!-- Duplicate Cards for Seamless Loop -->
                <div class="testimonial-card p-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#93C754]">Hellen Muda</h3>
                                <div class="flex text-emerald-500">★★★★★</div>
                            </div>
                        </div>
                        <p class="text-gray-600">Working with health-conscious is nothing short of amazing. Their attention to detail and commitment to excellence has definitely gone unmatched here.</p>
                    </div>
                </div>

                <div class="testimonial-card p-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#93C754]">Sarah Johnson</h3>
                                <div class="flex text-emerald-500">★★★★★</div>
                            </div>
                        </div>
                        <p class="text-gray-600">The level of professionalism and care they provide is exceptional. I couldn't be happier with the results and ongoing support.</p>
                    </div>
                </div>

                <div class="testimonial-card p-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#93C754]">Michael Chen</h3>
                                <div class="flex text-emerald-500">★★★★★</div>
                            </div>
                        </div>
                        <p class="text-gray-600">Their innovative approach to health and wellness has transformed my lifestyle. The results speak for themselves!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row gap-8 items-stretch">
            <div class="flex flex-col w-full md:w-1/2">
                <!-- Contact Form -->
                <div class="bg-[#D9D9D9] shadow-lg p-6 flex flex-col justify-between flex-grow">
                    <h2 class="text-xl font-bold mb-4 text-center text-black">Contact us</h2>
                    <!-- Modal Form -->
<form class="space-y-4" method="POST" action="{{ route('contact.store') }}">
    @csrf <!-- Include CSRF token for security -->

    <!-- Full Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
            Full Name
        </label>
        <input
            type="text"
            id="name"
            name="name"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
            placeholder="Enter your full name"
            required
        />
    </div>

    <!-- Phone Number (Optional) -->
    <div>
        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">
            Phone Number (Optional)
        </label>
        <input
            type="text"
            id="phone_number"
            name="phone_number"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
            placeholder="Enter your phone number"
        />
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            Email Address
        </label>
        <input
            type="email"
            id="email"
            name="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
            placeholder="Enter your email address"
            required
        />
    </div>

    <!-- Message -->
    <div>
        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
            Message
        </label>
        <textarea
            id="message"
            name="message"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
            rows="4"
            placeholder="Enter your message"
            required
        ></textarea>
    </div>

    <!-- Submit Button -->
    <button
        type="submit"
        class="w-full bg-[#0A4040] text-[#93C754] font-bold py-3 px-4 hover:bg-emerald-700 transition-colors duration-300 font-medium rounded-lg"
    >
        Submit
    </button>
</form>

                </div>
            </div>

            <!-- Wrapper to maintain equal height and width -->
            <div class="flex flex-col w-full md:w-1/2">
                <!-- Google Maps Area -->
                <div class="bg-white shadow-lg flex-grow">
                    <!-- FIXME: ADD THE ACTUAL MAP -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15955.30959006591!2d36.9095031!3d-1.2071505!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zLTEuMjA3MTUwNSwgMzYuOTA5NTAzMQ!5e0!3m2!1sen!2sus!4v1615227611123!5m2!1sen!2sus"
                        width="100%"
                        height="100%"
                        allowfullscreen=""
                        loading="lazy"
                        class="h-full"
                    ></iframe>
                </div>
            </div>
        </div>
    </section>

<!-- Newsletter Section -->
<section class="flex flex-col md:flex-row items-center gap-4 p-4 mx-8 md:mx-20">
    <span class="text-lg font-bold flex-1 text-center md:text-left">
        Subscribe to our newsletter
    </span>

    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col md:flex-row flex-1 items-center w-full gap-4">
        @csrf <!-- CSRF token for security -->

        <!-- Email Input -->
        <input
            type="email"
            name="email"
            placeholder="Please enter your email"
            class="flex-1 px-4 py-2 border border-[#0A4040] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A4040]"
            required
        />

        <!-- Submit Button -->
        <button
            type="submit"
            class="flex-1 px-6 py-2 text-white bg-teal-800 hover:bg-teal-700 font-bold rounded-lg"
        >
            Subscribe Now
        </button>
    </form>
</section>


    <!-- Footer Section -->
    <footer class="bg-teal-800 text-white">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row items-start justify-between gap-8 py-8">
          <div class="flex flex-col items-start gap-4">
            <div class="flex items-center gap-2">
              <img src="Assets/images/white logo.png" alt="Health Versations Logo" class="h-16">
              <span class="text-2xl font-semibold text-green-300">HEALTH VERSATIONS</span>
            </div>
            <button class="bg-green-500 hover:bg-green-600 text-teal-800 px-6 py-2 font-medium">
              Create a custom Package for me
            </button>
          </div>

          <div class="flex flex-col gap-2">
            <a href="#" class="hover:underline">Home</a>
            <a href="#" class="hover:underline">Packages</a>
            <a href="#" class="hover:underline">Healthy living</a>
            <a href="#" class="hover:underline">Talk to us</a>
            <a href="#" class="hover:underline">About us</a>
            <a href="#" class="hover:underline" id="rateUsButton">Rate Us</a>
          </div>

          <!-- Contact Information -->
          <div class="flex flex-col gap-2">
            <!-- FIXME:ADD ACTUAL DATA HERE -->
            <p>P.O. BOX: <span class="text-sm font-semibold text-[#93C754]">@Izooh add actual data here</span></p>
            <p>TELEPHONE NUMBER: <span class="text-sm font-semibold text-[#93C754]">@Izooh add actual data here</span></p>
            <p>EMAIL: <span class="text-sm font-semibold text-[#93C754]">@Izooh add actual data here</span></p>
            <div class="flex gap-4 mt-2">
              <a href="#" class="hover:opacity-80"><img src="Assets/images/facebook.svg" alt="Facebook" class="h-6"></a>
              <a href="#" class="hover:opacity-80"><img src="Assets/images/whatsapp.svg" alt="WhatsApp" class="h-6"></a>
              <a href="#" class="hover:opacity-80"><img src="Assets/images/instagram.svg" alt="Instagram" class="h-6"></a>
              <a href="#" class="hover:opacity-80"><img src="Assets/images/linkedIn.svg" alt="LinkedIn" class="h-6"></a>
              <a href="#" class="hover:opacity-80"><img src="Assets/images/tiktok.svg" alt="TikTok" class="h-6"></a>
            </div>
          </div>
        </div>

        <hr class="color-white m-4">

        <!-- Copyright Section -->
        <div class="bg-[#0A4040] text-center py-4 text-white">
          <p>&copy; <span id="current-year"></span> HEALTH VERSATIONS. All rights reserved.</p>
          <p style="color: #93C754;">Developed and designed by Quick Office Pointe.</p>
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


    <script src="{{asset ('Assets/js/main.js') }}"></script>
    <script src="{{asset ('Assets/js/modal.js') }}"></script>
</body>
</html>
