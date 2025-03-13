<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Profile;

return new class extends Migration
{
    public function up()
    {
        // Get all users without profiles
        $users = User::whereDoesntHave('profile')->get();

        // Create profiles for these users
        foreach ($users as $user) {
            Profile::create([
                'user_id' => $user->id,
                'username' => $user->name,
                'description' => null,
                'favorite_characters' => []
            ]);
        }
    }

    public function down()
    {
        // No need to do anything in down method
    }
};
