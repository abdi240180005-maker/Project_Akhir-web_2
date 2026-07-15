<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            $table->string('country')->after('title');

            $table->enum('risk_level', [
                'Rendah',
                'Sedang',
                'Tinggi'
            ])->after('country');

            $table->renameColumn('content', 'conclusion');

        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            $table->renameColumn('conclusion', 'content');

            $table->dropColumn([
                'country',
                'risk_level'
            ]);

        });
    }
};