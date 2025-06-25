<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}



