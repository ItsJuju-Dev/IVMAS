<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('guest_name');

        $table->foreignId('room_id')
              ->constrained()
              ->onDelete('cascade');

        $table->date('check_in_date');
        $table->date('check_out_date');

        $table->decimal('total_price', 10, 2);

        $table->string('status')->default('confirmed');
        $table->string('source')->default('manual');

        $table->foreignId('handled_by')
              ->nullable()
              ->constrained('users')
              ->onDelete('set null');

        $table->timestamps();
    });
}
};
