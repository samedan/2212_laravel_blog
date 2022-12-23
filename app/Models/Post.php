<?php

namespace App\Models;

use App\Models\User;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = ['title', 'body', 'user_id'];

    public function toSearchableArray() {
        return [
            'title'=>$this->title,
            'body'=>$this->body
        ];
    }
    public function user() {
        // on the 'User' model look for the 'user_id' column
        return $this->belongsTo(User::class, 'user_id');
    }
}
