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
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['tiktok', 'instagram']);
            $table->string('post_id');
            $table->integer('likes')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('views')->default(0);
            $table->integer('saves')->default(0);
            $table->integer('reach')->default(0);
            $table->integer('engagement')->default(0);
            $table->date('date');
            $table->timestamps();

            $table->index(['platform', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};
