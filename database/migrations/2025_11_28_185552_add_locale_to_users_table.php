<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2025_11_28_185552_add_locale_to_users_table.php

public function up()
{
    if (!Schema::hasColumn('users', 'locale')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('locale')->default('ru');
        });
    }
}

public function down()
{
    if (Schema::hasColumn('users', 'locale')) {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
}
};