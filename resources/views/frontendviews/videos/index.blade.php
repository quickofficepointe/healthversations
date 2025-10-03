@extends('layouts.app')

@section('title', 'Healthversations Video Guides - Learn and Improve Your Health')
@section('meta_description', 'Watch expert-created health and wellness videos on our YouTube channel. Learn about nutrition, fitness, and healthy habits to improve your lifestyle.')
@section('meta_keywords', 'health videos, wellness guides, nutrition tips, fitness videos, healthversations YouTube')
@section('canonical_url', url()->current())

@section('og_title', 'Healthversations Video Guides - Learn and Improve Your Health')
@section('og_description', 'Explore our health and wellness video tutorials to help you achieve better nutrition, fitness, and overall well-being.')
@section('og_image', asset('Assets/images/healthversations-video-thumbnail.jpg'))
@section('og_url', url()->current())

@section('twitter_title', 'Healthversations Video Guides - Learn and Improve Your Health')
@section('twitter_description', 'Watch our expert health and wellness videos to improve your lifestyle today.')
@section('twitter_image', asset('Assets/images/healthversations-video-thumbnail.jpg'))

@section('content')

<div class="container mt-4">
    <h1 class="text-3xl font-bold text-center text-[#0A4040] mb-4">You can also do this on your own</h1>
    <p class="text-center text-xl mb-12">
        We have created videos for you to get started at home on our
        <span class="text-[#FF0000]">
            <a href="https://www.youtube.com/@healthversations/" target="_blank">YouTube channel</a>
        </span>
    </p>

    <!-- Video Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($videos as $video)
        <div class="video-container bg-white rounded-lg shadow-md overflow-hidden cursor-pointer" data-video-id="{{ $video->id }}">
            @php
                // Extract YouTube Video ID
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->link, $matches);
                $videoId = $matches[1] ?? '';
                $embedUrl = $videoId ? "https://www.youtube.com/embed/$videoId" : $video->link;
            @endphp

            <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                alt="{{ $video->title }}" class="w-full play-video" data-video-url="{{ $embedUrl }}">

            <p class="p-4 text-center text-gray-400"><b>{{ $video->title }}</b></p>

            <div class="p-4">
                <div class="flex justify-between mb-4">
                    <button class="bg-[#93C754] text-[#0A4040] px-4 py-2 rounded text-sm play-video"
                            data-video-url="{{ $embedUrl }}">
                        Watch the video now
                    </button>

                    <button class="border border-green-500 text-[#0A4040] px-4 py-2 rounded text-sm share-button"
                            data-video-url="{{ $video->link }}">
                        Share the video
                    </button>
                </div>

                <!-- Subscribe Button -->
                <a href="https://www.youtube.com/@healthversations?sub_confirmation=1"
                   target="_blank" class="block text-center bg-red-600 text-white px-4 py-2 rounded text-sm">
                    Subscribe
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-4 relative w-full max-w-2xl">
        <button class="absolute top-2 right-2 text-gray-600 close-modal">&times;</button>
        <div class="relative w-full h-0" style="padding-bottom: 56.25%;">
            <iframe id="videoPlayer" class="absolute top-0 left-0 w-full h-full" src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<!-- Structured Data (JSON-LD) for Video SEO -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "VideoObject",
    "name": "Healthversations Video Guides",
    "description": "Watch expert-created health and wellness videos covering nutrition, fitness, and lifestyle improvement.",
    "thumbnailUrl": "https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg",
    "uploadDate": "{{ now()->toIso8601String() }}",
    "contentUrl": "{{ $embedUrl }}",
    "publisher": {
        "@type": "Organization",
        "name": "Healthversations",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('Assets/images/healthversations-logo.png') }}"
        }
    }
}
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("videoModal");
        const videoPlayer = document.getElementById("videoPlayer");
        const closeModal = document.querySelector(".close-modal");

        document.querySelectorAll(".play-video").forEach(button => {
            button.addEventListener("click", function() {
                const videoUrl = this.getAttribute("data-video-url");
                videoPlayer.src = videoUrl;
                modal.classList.remove("hidden");
            });
        });

        closeModal.addEventListener("click", function() {
            modal.classList.add("hidden");
            videoPlayer.src = "";
        });

        modal.addEventListener("click", function(event) {
            if (event.target === modal) {
                modal.classList.add("hidden");
                videoPlayer.src = "";
            }
        });

        document.querySelectorAll(".share-button").forEach(button => {
            button.addEventListener("click", function() {
                const videoUrl = this.getAttribute("data-video-url");
                navigator.clipboard.writeText(videoUrl).then(() => {
                    alert("Video link copied to clipboard!");
                });
            });
        });
    });
</script>

@endsection
