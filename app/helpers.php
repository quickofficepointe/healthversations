<?php

if (!function_exists('convertToEmbedUrl')) {
    function convertToEmbedUrl($url) {
        // Convert YouTube URLs to embed format
        if (preg_match('/watch\?v=([^&]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $url;
    }
}

if (!function_exists('getYoutubeVideoId')) {
    function getYoutubeVideoId($url) {
        // Extract the YouTube video ID
        if (preg_match('/watch\?v=([^&]+)/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
