<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprestimosTable extends Migration {
    
    public function up() {

        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ferramenta_id');
            $table->foreign('ferramenta_id')->references('id')->on('ferramentas');
            $table->string('funcionario');
            $table->integer('quantidade');
            $table->timestamp('dataEmprestimo');
            $table->timestamp('dataDevolucaoPrevista')->nullable();
            $table->timestamp('dataDevolucao')->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('emprestimos');
    }
}
