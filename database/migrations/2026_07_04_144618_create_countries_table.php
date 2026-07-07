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
    Schema::create('countries', function (Blueprint $table) {

        $table->id();

        $table->string('name');
        $table->string('iso2', 2)->nullable();
        $table->string('iso3', 3)->nullable();

        $table->string('capital')->nullable();

        $table->string('region')->nullable();

        $table->string('subregion')->nullable();

        $table->string('currency')->nullable();

        $table->bigInteger('population')->nullable();

        $table->decimal('latitude', 10, 6)->nullable();

        $table->decimal('longitude', 10, 6)->nullable();

        $table->text('flag')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
