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
        Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
    $table->string('title');
    $table->text('content');
    
    // أضيفي هذا السطر هنا لتوفير العمود الذي يبحث عنه السييدر
    $table->string('excerpt')->nullable(); 

    $table->string('slug')->unique();
    $table->string('cover_image')->nullable();
    $table->enum('status', ['draft', 'published'])->default('draft');
    $table->unsignedBigInteger('views')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
