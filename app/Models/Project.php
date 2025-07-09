<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ImageOptimizer;
use App\Helpers\CloudinaryHelper;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'image_public_id',
        'tech_stack',
        'link_demo',
        'link_github',
        'status',
        'featured'
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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
     /**
     * Get optimized image URL
     */
    public function getImageUrl($options = [])
    {
        $cloudinary = new CloudinaryHelper();
        
        if ($this->image_public_id) {
            return $cloudinary->getOptimizedUrl($this->image_public_id, $options);
        }
        
        // Fallback untuk gambar lama yang masih menggunakan storage
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        
        return $cloudinary->getPlaceholderUrl(array_merge([
            'text' => $this->title
        ], $options));
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrl($width = 400, $height = 300)
    {
        $cloudinary = new CloudinaryHelper();
        
        if ($this->image_public_id) {
            return $cloudinary->getThumbnailUrl($this->image_public_id, $width, $height);
        }
        
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        
        return $cloudinary->getPlaceholderUrl([
            'width' => $width,
            'height' => $height,
            'text' => $this->title
        ]);
    }

    /**
     * Get hero image URL (larger size)
     */
    public function getHeroImageUrl()
    {
        return $this->getImageUrl([
            'width' => 1200,
            'height' => 600,
            'quality' => 'auto'
        ]);
    }

    /**
     * Get card image URL (for project cards)
     */
    public function getCardImageUrl()
    {
        return $this->getThumbnailUrl(400, 300);
    }

    /**
     * Check if project has image
     */
    public function hasImage()
    {
        return !empty($this->image_public_id) || !empty($this->image);
    }

    /**
     * Get formatted tech stack as badges
     */
    public function getTechBadges()
    {
        if (!$this->tech_stack) {
            return '';
        }

        $badges = '';
        foreach ($this->tech_stack as $tech) {
            $badges .= '<span class="tech-badge">' . htmlspecialchars($tech) . '</span>';
        }

        return $badges;
    }

    /**
     * Get excerpt from description
     */
    public function getExcerpt($limit = 120)
    {
        return \Illuminate\Support\Str::limit($this->description, $limit);
    }

    /**
     * Scope untuk featured projects
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope untuk published projects
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
    