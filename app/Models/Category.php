<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Tasks(){
        return $this->hasMany(Task::class);
    }

    public function File(){
        return $this->hasManyThrough(File::class,Task::class);
    }
}
