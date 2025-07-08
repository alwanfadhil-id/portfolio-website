<?php

namespace App\Helpers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageOptimizer
{
    /**
     * Generate optimized image URL
     */
    public static function getOptimizedImageUrl($imageUrl, $width = 400, $height = 300, $quality = 'auto')
    {
        if (!$imageUrl) return null;
        
        // Jika sudah URL Cloudinary, tambahkan transformation
        if (strpos($imageUrl, 'cloudinary.com') !== false) {
            $transformation = "c_fill,w_{$width},h_{$height},q_{$quality},f_auto";
            return str_replace('/upload/', "/upload/{$transformation}/", $imageUrl);
        }
        
        return $imageUrl;
    }
    
    /**
     * Generate responsive image URLs
     */
    public static function getResponsiveImageUrls($imageUrl, $breakpoints = [400, 800, 1200])
    {
        $urls = [];
        
        foreach ($breakpoints as $width) {
            $urls[$width] = self::getOptimizedImageUrl($imageUrl, $width, null, 'auto');
        }
        
        return $urls;
    }
    
    /**
     * Generate thumbnail
     */
    public static function getThumbnail($imageUrl, $size = 150)
    {
        return self::getOptimizedImageUrl($imageUrl, $size, $size, 'auto');
    }
    
    /**
     * Upload image to Cloudinary
     */
    public static function uploadImage($file, $folder = 'portfolio')
    {
        try {
            $result = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'use_filename' => true,
                'unique_filename' => true,
                'overwrite' => true,
                'quality' => 'auto',
                'fetch_format' => 'auto'
            ]);
            
            return $result->getSecurePath();
        } catch (\Exception $e) {
            throw new \Exception('Failed to upload image: ' . $e->getMessage());
        }
    }
}