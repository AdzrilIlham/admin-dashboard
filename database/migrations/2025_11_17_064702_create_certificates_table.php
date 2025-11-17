<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('certificates', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('portfolio_id');
    $table->string('title');
    $table->string('issuer');
    $table->string('year')->nullable();
    $table->string('file')->nullable();
    $table->timestamps();

    $table->foreign('portfolio_id')
          ->references('id')->on('portfolios')
          ->onDelete('cascade');
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
