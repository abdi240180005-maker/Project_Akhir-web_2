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
        Schema::table('countries', function (Blueprint $table) {
            $table->boolean('un_member')->default(false)->after('flag');
            $table->boolean('independent')->default(false)->after('un_member');
            $table->double('gdp')->nullable()->after('independent');
            $table->double('inflation_rate')->nullable()->after('gdp');
            $table->integer('risk_score')->nullable()->after('inflation_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn(['un_member', 'independent', 'gdp', 'inflation_rate', 'risk_score']);
        });
    }
};
