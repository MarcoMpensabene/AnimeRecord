<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'description',
        'avatar',
        'favorite_characters',
        'last_online'
    ];

    protected $casts = [
        'favorite_characters' => 'array',
        'last_online' => 'datetime',
    ];

    public function user() //1to1 relation with user
    {
        return $this->belongsTo(User::class);
    }
}
