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
        'favorite_characters'
    ];

    protected $casts = [
        'favorite_characters' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
