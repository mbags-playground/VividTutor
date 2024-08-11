<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'content', 'order', 'completed', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function chatBots()
    {
        return $this->hasMany(ChatBot::class);
    }
}
