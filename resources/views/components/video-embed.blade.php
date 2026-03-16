@props(['url'])

@php
    $embedUrl = null;

    if ($url) {
        // YouTube
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([\w\-]+)/', $url, $m)) {
            $embedUrl = "https://www.youtube.com/embed/{$m[1]}";
        }
        // Facebook Video
        elseif (preg_match('/facebook\.com\/.*\/videos\//', $url)) {
            $embedUrl = "https://www.facebook.com/plugins/video.php?href=" . urlencode($url) . "&show_text=false";
        }
        // Vimeo
        elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
            $embedUrl = "https://player.vimeo.com/video/{$m[1]}";
        }
        // Dailymotion
        elseif (preg_match('/dailymotion\.com\/video\/([\w]+)/', $url, $m)) {
            $embedUrl = "https://www.dailymotion.com/embed/video/{$m[1]}";
        }
        // TikTok
        elseif (preg_match('/tiktok\.com\/@[\w.]+\/video\/(\d+)/', $url, $m)) {
            $embedUrl = "https://www.tiktok.com/embed/{$m[1]}";
        }
    }
@endphp

@if ($embedUrl)
    <div class="my-6">
        <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.12);">
            <iframe
                src="{{ $embedUrl }}"
                style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                loading="lazy"
            ></iframe>
        </div>
    </div>
@elseif ($url)
    <div class="my-6">
        <a href="{{ $url }}" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
            ▶ Tonton Video
        </a>
    </div>
@endif
