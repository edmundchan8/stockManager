<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_data', function (Blueprint $table) {
            $table->id();
            $table->string('tickerSymbol');
            $table->decimal('fiftyDayAverage', 10, 2);
            $table->decimal('twoHundredDayAverage', 10, 2);
            $table->decimal('regularMarketPrice', 10, 2);
            $table->decimal('regularMarketPreviousClose', 10, 2);
            $table->decimal('forwardPE', 10, 2)->nullable();
            $table->decimal('trailingAnnualDividendRate', 10, 2)->nullable();
            $table->string('averageAnalystRating')->nullable();
            $table->string('averageAnalystOpinion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_data');
    }
}
