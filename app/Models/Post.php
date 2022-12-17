<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'user_id'];

    public function getUserData() {
        // on the 'User' model look for the 'user_id' column
        return $this->belongsTo(User::class, 'user_id');
    }
}