<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $fillable = [
        'name',
        'image',
        'video',
        'user_id',
        'description',
        'git',
        'status',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
