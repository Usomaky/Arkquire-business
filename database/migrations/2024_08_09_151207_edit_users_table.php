<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected static ?string $password;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            [
                'fullname' => 'Mary Doe',
                'email' => 'marydoe@example.com',
                'phone' => '1234567890',
                'state' => 'Lagos',
                'lga' => 'Ikeja',
                'avatar' => fake()->imageUrl(320, 320, 'people', true),               
                'bio' => 'This is a default user bio.',
                'status' => 'active',
                'auction_verified' => false,
                'password' => static::$password ??= Hash::make('password'),
                'usertype' => 'admin',
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'fullname' => 'Man Doe',
                'email' => 'mandoe@example.com',
                'phone' => '1234567891',
                'state' => 'Lagos',
                'lga' => 'Ikeja',
                'avatar' => fake()->imageUrl(320, 320, 'people', true),
                'bio' => 'This is a default user bio.',
                'status' => 'active',
                'auction_verified' => false,
                'password' => static::$password ??= Hash::make('password'),
                'usertype' => 'customer',
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more users if needed
        ]);

        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
