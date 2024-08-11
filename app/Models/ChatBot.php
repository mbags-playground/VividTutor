<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBot extends Model
{
    use HasFactory;

    protected $fillable = ['chapter_id', 'question', 'answer'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
