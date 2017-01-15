<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsHouseTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('options_house_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('transaction_id');
            $table->date('close_date');
            $table->time('close_time');
            $table->string('trade_type');
            $table->string('description');
            $table->float('strike_price');
            $table->string('option_type');
            $table->string('option_side');
            $table->integer('option_quantity')->nullable();
            $table->string('symbol');
            $table->float('price_per_unit')->nullable();
            $table->string('underlier_symbol');
            $table->float('fee');
            $table->float('commission');
            $table->float('amount');
            $table->string('security_type');
            $table->date('expiration')->nullable();
            $table->string('security_description');
            $table->string('position_state');
            $table->string('deliverables');
            $table->string('market_statistics');
            $table->string('trade_journal_notes');
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
        \Schema::dropIfExists('options_house_transaction');
    }
}
