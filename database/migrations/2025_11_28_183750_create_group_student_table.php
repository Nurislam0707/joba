<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2025_11_28_183750_create_group_student_table.php

public function up()
{
    Schema::create('group_student', function (Blueprint $table) {
        $table->id();
        $table->foreignId('group_id')->constrained('groups')->onDelete('cascade'); // 'groups' кестесіне сілтеме
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
        
        $table->unique(['group_id', 'user_id']);
    });
}

    public function down()
    {
        Schema::dropIfExists('group_student');
    }
};