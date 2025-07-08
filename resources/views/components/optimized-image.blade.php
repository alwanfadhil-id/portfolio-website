@props([
    'src',
    'alt' => '',
    'class' => '',
    'width' => 400,
    'height' => 300,
    'responsive' => false,
    'loading' => 'lazy'
])

@php
    use App\Helpers\ImageOptimizer;
    
    if ($responsive) {
        $responsiveUrls = ImageOptimizer::getResponsiveImageUrls($src);
        $srcset = collect($responsiveUrls)->map(function($url, $width) {
            return $url . ' ' . $width . 'w';
        })->join(', ');
    } else {
        $optimizedSrc = ImageOptimizer::getOptimizedImageUrl($src, $width, $height);
    }
@endphp

@if($responsive && isset($srcset))
    <img src="{{ $responsiveUrls[400] ?? $src }}" 
         srcset="{{ $srcset }}" 
         sizes="(max-width: 768px) 400px, (max-width: 1200px) 800px, 1200px"
         alt="{{ $alt }}" 
         class="{{ $class }}"
         loading="{{ $loading }}">
@else
    <img src="{{ $optimizedSrc ?? $src }}" 
         alt="{{ $alt }}" 
         class="{{ $class }}"
         loading="{{ $loading }}">
@endif