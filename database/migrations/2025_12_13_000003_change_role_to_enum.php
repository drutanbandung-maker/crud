<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Use raw statement to alter column to enum (MySQL)
        // Adjust if your DB is different
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('talent','customer') NOT NULL DEFAULT 'customer'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE `users` MODIFY `role` VARCHAR(255) NOT NULL DEFAULT 'customer'");
    }
};
