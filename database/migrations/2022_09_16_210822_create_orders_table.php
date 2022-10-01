<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable()->default('Unconfirmed');
            $table->string('paid_invoice')->nullable();
            $table->string('booked_by')->nullable();
            $table->string('notify_paid')->nullable()->default('0');
            $table->string('notify_start')->nullable()->default('0');
            $table->string('notify_in_progress')->nullable()->default('0');
            $table->string('notify_complete')->nullable()->default('0');
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
        Schema::dropIfExists('orders');
    }
}
