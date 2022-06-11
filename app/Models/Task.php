<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    protected $fillable = [
        'name',
        'content',
        'category_id',
    ];
    use HasFactory;
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Gategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Files()
    {
        return $this->hasMany(File::class);
    }

}
