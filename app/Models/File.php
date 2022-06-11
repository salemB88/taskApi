<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'task_id',
    ];
    protected $appends=['file_path'];
    use HasFactory, SoftDeletes;

    public function Task(){
     return   $this->belongsTo(Task::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function getFilePathAttribute(){
return config('app.url').Storage::url('tasks/'.$this->task_id.'/'.$this->name);

}
}
