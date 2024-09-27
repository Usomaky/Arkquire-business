<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         DB::table('faqs')->insert([
            [
                'faq_header' => 'What is arkquire',
                'faq_content' => 'Arkquire is the best way to sell your business or acquire a new business',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ 
                'faq_header' => 'Arkquire establishment',
                'faq_content' => 'Arkquire is the best way to sell your business or acquire a new business',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_header' => 'How can I advertise on Arkquire',
                'faq_content' => 'Arkquire is the best way to sell your business or acquire a new business',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_header' => 'Arkquire requirements',
                'faq_content' => 'Arkquire is the best way to sell your business or acquire a new business',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_header' => 'Arkquire motivation',
                'faq_content' => 'Arkquire is the best way to sell your business or acquire a new business',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
