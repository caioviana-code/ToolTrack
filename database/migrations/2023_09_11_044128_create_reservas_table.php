<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration {
    
    public function up() {

        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ferramenta_id');
            $table->string('funcionario');
            $table->integer('quantidade');
            $table->timestamp('dataReserva');
            $table->timestamp('dataRetirada')->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('reservas');
    }
}
