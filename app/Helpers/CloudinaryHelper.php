<?php

namespace App\Helpers;

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Quality;
use Cloudinary\Transformation\Format;

class CloudinaryHelper
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
                'secure' => config('services.cloudinary.secure', true),
            ],
        ]);
    }

    /**
     * Upload image to Cloudinary
     */
    public function uploadImage($file, $folder = 'projects')
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => $folder,
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto'
                ]
            ]);

            return [
                'success' => true,
                'public_id' => $result['public_id'],
                'url' => $result['secure_url'],
                'width' => $result['width'],
                'height' => $result['height']
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate optimized image URL
     */
    public function getOptimizedUrl($publicId, $options = [])
    {
        if (!$publicId) {
            return $this->getPlaceholderUrl($options);
        }

        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 600;
        $quality = $options['quality'] ?? 'auto';
        $format = $options['format'] ?? 'auto';

        return $this->cloudinary->image($publicId)
            ->resize(Resize::fill($width, $height))
            ->quality(Quality::auto())
            ->format(Format::auto())
            ->toUrl();
    }

    /**
     * Generate thumbnail URL
     */
    public function getThumbnailUrl($publicId, $width = 400, $height = 300)
    {
        if (!$publicId) {
            return $this->getPlaceholderUrl(['width' => $width, 'height' => $height]);
        }

        return $this->cloudinary->image($publicId)
            ->resize(Resize::fill($width, $height))
            ->quality(Quality::auto())
            ->format(Format::auto())
            ->toUrl();
    }

    /**
     * Generate placeholder URL
     */
    public function getPlaceholderUrl($options = [])
    {
        $width = $options['width'] ?? 400;
        $height = $options['height'] ?? 300;
        $text = $options['text'] ?? 'No Image';
        $bgColor = $options['bg_color'] ?? '667eea';
        $textColor = $options['text_color'] ?? 'ffffff';

        return "https://via.placeholder.com/{$width}x{$height}/{$bgColor}/{$textColor}?text=" . urlencode($text);
    }

    /**
     * Delete image from Cloudinary
     */
    public function deleteImage($publicId)
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId);
            return $result['result'] === 'ok';
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get image info
     */
    public function getImageInfo($publicId)
    {
        try {
            return $this->cloudinary->adminApi()->asset($publicId);
        } catch (\Exception $e) {
            return null;
        }
    }
}