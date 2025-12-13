<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            // drop existing foreign key on user_id if exists
            if (Schema::hasColumn('wallets', 'user_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $sm->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            }
        });

        // Add new column id_coin
        Schema::table('wallets', function (Blueprint $table) {
            if (!Schema::hasColumn('wallets', 'id_coin')) {
                $table->unsignedBigInteger('id_coin')->nullable()->after('id');
            }
        });

        // copy user_id values to id_coin
        DB::table('wallets')->whereNotNull('user_id')->update(['id_coin' => DB::raw('user_id')]);

        Schema::table('wallets', function (Blueprint $table) {
            // drop foreign then drop user_id
            if (Schema::hasColumn('wallets', 'user_id')) {
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // ignore if constraint name differs
                }
                $table->dropColumn('user_id');
            }
        });

        // make id_coin unique and add FK
        Schema::table('wallets', function (Blueprint $table) {
            $table->unsignedBigInteger('id_coin')->change();
            $table->unique('id_coin');
            $table->foreign('id_coin')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            if (Schema::hasColumn('wallets', 'id_coin')) {
                try { $table->dropForeign(['id_coin']); } catch (\Exception $e) {}
                $table->dropUnique(['id_coin']);
                $table->dropColumn('id_coin');
            }
            if (!Schema::hasColumn('wallets', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }
};
