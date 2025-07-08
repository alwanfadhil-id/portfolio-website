<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ImageOptimizer;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'tech_stack',
        'link_demo',
        'link_github',
    ];

    protected $casts = [
        'tech_stack' => 'array',
    ];
    
    // Accessor untuk handle data legacy
    public function getTechStackAttribute($value)
    {
        if (is_array($value)) return $value;
        if (is_string($value)) {
            return json_decode($value, true) ?? explode(',', $value);
        }
        return [];
    }
    
    // Accessor untuk gambar yang dioptimasi
    public function getOptimizedImageAttribute($width = 400, $height = 300)
    {
        return ImageOptimizer::getOptimizedImageUrl($this->image, $width, $height);
    }
    
    // Accessor untuk thumbnail
    public function getThumbnailAttribute()
    {
        return ImageOptimizer::getThumbnail($this->image);
    }
    
    // Accessor untuk responsive images
    public function getResponsiveImagesAttribute()
    {
        return ImageOptimizer::getResponsiveImageUrls($this->image);
    }
}