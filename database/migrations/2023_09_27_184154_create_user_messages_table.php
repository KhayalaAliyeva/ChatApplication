<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('message_id');
            $table->unsignedInteger("sender_id");
            $table->unsignedInteger('receiver_id');
            $table->tinyInteger('type')->default(0)
                    ->comment('1:group, 0:personal');
            $table->tinyInteger('seen_status')->default(0)
                    ->comment('1:seen, 0:unseen');
            $table->tinyInteger("deliver_status")->default(0)
            ->comment('1:delivered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_messages');
    }
};
