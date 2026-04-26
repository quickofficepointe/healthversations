@extends('layouts.app')

@section('title', 'Health & Wellness Video Guides | Health Versations YouTube Channel')
@section('meta_description', 'Watch expert-created health and wellness videos covering nutrition, fitness, gut health, and healthy habits. Subscribe to our YouTube channel for weekly health tips.')
@section('meta_keywords', 'health videos, wellness guides, nutrition tips, fitness videos, healthversations YouTube, healthy lifestyle, wellness education')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('videos.show'))

@section('og_title', 'Health & Wellness Video Guides | Health Versations')
@section('og_description', 'Explore our library of health and wellness video tutorials. Expert advice on nutrition, fitness, and holistic living.')
@section('og_image', asset('Assets/images/healthversations-video-thumbnail.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Video Library')
@section('og_type', 'website')
@section('og:video', 'https://www.youtube.com/@healthversations')
@section('og:video:type', 'text/html')

@section('twitter_title', 'Health & Wellness Video Guides | Health Versations')
@section('twitter_description', 'Watch our expert health and wellness videos to improve your lifestyle today. Subscribe for weekly tips!')
@section('twitter_image', asset('Assets/images/healthversations-video-thumbnail.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VideoGallery",
  "name": "Health Versations Video Library",
  "description": "Expert health and wellness video guides covering nutrition, fitness, gut health, and healthy living.",
  "url": "{{ route('videos.show') }}",
  "publisher": {
    "@type": "Organization",
    "name": "Health Versations",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('Assets/images/logo.png') }}"
    }
  },
  "numberOfItems": {{ $videos->count() }}
}
</script>
@endpush

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Videos",
      "item": "{{ route('videos.show') }}"
    }
  ]
}
</script>
@endpush

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Free Educational Content</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                You Can Also Do This On Your Own
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600 mb-6">
                We've created comprehensive video guides to help you get started with your health journey at home.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="https://www.youtube.com/@healthversations?sub_confirmation=1"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                    <i class="fab fa-youtube mr-2 text-xl"></i>
                    Subscribe to YouTube Channel
                </a>
                <a href="https://www.youtube.com/@healthversations/videos"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105">
                    <i class="fab fa-youtube mr-2 text-xl"></i>
                    View All Videos
                </a>
            </div>
        </div>

        <!-- Channel Stats Bar -->
        <div class="bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-6 mb-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-3xl font-bold text-white">50+</div>
                    <div class="text-sm text-gray-200">Educational Videos</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">10K+</div>
                    <div class="text-sm text-gray-200">Monthly Views</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">1000+</div>
                    <div class="text-sm text-gray-200">Happy Subscribers</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">24/7</div>
                    <div class="text-sm text-gray-200">Free Access</div>
                </div>
            </div>
        </div>

        <!-- Video Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($videos as $video)
            @php
                // Extract YouTube Video ID
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->link, $matches);
                $videoId = $matches[1] ?? '';
                $embedUrl = $videoId ? "https://www.youtube.com/embed/$videoId?autoplay=1&rel=0" : $video->link;
                $youtubeUrl = "https://www.youtube.com/watch?v=" . $videoId;
                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
            @endphp

            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <!-- Thumbnail with Play Button Overlay -->
                <div class="relative cursor-pointer play-video overflow-hidden bg-gray-900"
                     data-video-url="{{ $embedUrl }}"
                     data-video-title="{{ addslashes($video->title) }}">
                    <img src="{{ $thumbnailUrl }}"
                         alt="{{ $video->title }} - Health Versations Video Guide"
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
                         width="400"
                         height="225"
                         loading="lazy">

                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 transition-all flex items-center justify-center">
                        <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                            <i class="fas fa-play text-white text-2xl ml-1"></i>
                        </div>
                    </div>

                    <!-- Duration Badge -->
                    @if(isset($video->duration))
                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                        {{ $video->duration }}
                    </div>
                    @endif
                </div>

                <!-- Video Info -->
                <div class="p-5">
                    <h2 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-[#93C754] transition-colors">
                        {{ $video->title }}
                    </h2>

                    @if(isset($video->description))
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">
                        {{ Str::limit($video->description, 100) }}
                    </p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button class="play-video flex-1 bg-[#93C754] text-[#0A4040] px-4 py-2 rounded-xl text-sm font-semibold hover:bg-[#7eae47] transition-all flex items-center justify-center gap-2"
                                data-video-url="{{ $embedUrl }}"
                                data-video-title="{{ addslashes($video->title) }}">
                            <i class="fas fa-play"></i>
                            Watch Now
                        </button>

                        <button class="share-button flex-1 border-2 border-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold hover:border-[#93C754] hover:text-[#93C754] transition-all flex items-center justify-center gap-2"
                                data-video-url="{{ $youtubeUrl }}"
                                data-video-title="{{ addslashes($video->title) }}">
                            <i class="fas fa-share-alt"></i>
                            Share
                        </button>
                    </div>

                    <!-- YouTube Link -->
                    <a href="{{ $youtubeUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block text-center text-gray-500 text-xs hover:text-red-600 transition-colors">
                        <i class="fab fa-youtube mr-1"></i>
                        Watch on YouTube
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($videos->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-video text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Videos Available</h3>
            <p class="text-gray-500">Check back soon for new health and wellness videos!</p>
            <a href="https://www.youtube.com/@healthversations"
               target="_blank"
               class="inline-block mt-4 text-red-600 hover:text-red-700 font-semibold">
                Visit our YouTube Channel →
            </a>
        </div>
        @endif

        <!-- Featured Playlist Section -->


        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 md:p-12 text-center">
            <div class="max-w-2xl mx-auto">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fab fa-youtube text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Never Miss a Health Tip</h2>
                <p class="text-red-100 mb-6">
                    Subscribe to our YouTube channel for weekly videos on nutrition, fitness, and wellness.
                </p>
                <a href="https://www.youtube.com/@healthversations?sub_confirmation=1"
                   target="_blank"
                   class="inline-flex items-center bg-white text-red-600 px-8 py-3 rounded-xl font-bold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                    <i class="fab fa-youtube mr-2 text-xl"></i>
                    Subscribe Now
                </a>
                <p class="text-red-200 text-sm mt-4">
                    {{ $videos->count() }}+ videos available • New content added weekly
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-4xl w-full relative overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="modalVideoTitle" class="font-semibold text-gray-800">Now Playing</h3>
            <button class="close-modal w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="relative w-full" style="padding-bottom: 56.25%;">
            <iframe id="videoPlayer" class="absolute top-0 left-0 w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>

<!-- Share Toast Notification -->
<div id="shareToast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden z-50 animate-fade-in-up">
    <div class="flex items-center gap-2">
        <i class="fas fa-check-circle"></i>
        <span>Link copied to clipboard!</span>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("videoModal");
    const videoPlayer = document.getElementById("videoPlayer");
    const modalTitle = document.getElementById("modalVideoTitle");
    const closeModal = document.querySelector(".close-modal");
    const toast = document.getElementById("shareToast");

    // Play Video Function
    function showVideoModal(videoUrl, videoTitle) {
        videoPlayer.src = videoUrl;
        if (modalTitle) modalTitle.textContent = videoTitle;
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        document.body.style.overflow = "hidden";
    }

    function closeVideoModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        videoPlayer.src = "";
        document.body.style.overflow = "";
    }

    // Show Toast Function
    function showToast() {
        toast.classList.remove("hidden");
        setTimeout(() => {
            toast.classList.add("hidden");
        }, 2000);
    }

    // Play Video Buttons
    document.querySelectorAll(".play-video").forEach(button => {
        button.addEventListener("click", function(e) {
            e.stopPropagation();
            const videoUrl = this.getAttribute("data-video-url");
            const videoTitle = this.getAttribute("data-video-title") || "Health Versations Video";
            if (videoUrl) showVideoModal(videoUrl, videoTitle);
        });
    });

    // Share Buttons
    document.querySelectorAll(".share-button").forEach(button => {
        button.addEventListener("click", async function(e) {
            e.stopPropagation();
            const videoUrl = this.getAttribute("data-video-url");
            const videoTitle = this.getAttribute("data-video-title");

            if (navigator.share && window.innerWidth < 768) {
                // Use native share on mobile
                try {
                    await navigator.share({
                        title: videoTitle,
                        text: 'Check out this health video from Health Versations',
                        url: videoUrl
                    });
                } catch (err) {
                    console.log('Share cancelled');
                }
            } else {
                // Fallback to clipboard
                try {
                    await navigator.clipboard.writeText(videoUrl);
                    showToast();
                } catch (err) {
                    alert("Unable to copy link. Please copy manually: " + videoUrl);
                }
            }
        });
    });

    // Close modal handlers
    if (closeModal) closeModal.addEventListener("click", closeVideoModal);

    modal.addEventListener("click", function(event) {
        if (event.target === modal) closeVideoModal();
    });

    // Close on escape key
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && !modal.classList.contains("hidden")) {
            closeVideoModal();
        }
    });

    // Track video plays for analytics (optional)
    document.querySelectorAll(".play-video").forEach(button => {
        button.addEventListener("click", function() {
            const videoTitle = this.getAttribute("data-video-title");
            if (typeof gtag !== 'undefined') {
                gtag('event', 'video_play', {
                    'event_category': 'Video',
                    'event_label': videoTitle
                });
            }
        });
    });
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.animate-fade-in-up {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Modal scroll lock */
body.modal-open {
    overflow: hidden;
}
</style>
@endsection
