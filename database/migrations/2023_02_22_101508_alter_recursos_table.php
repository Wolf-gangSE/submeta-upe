<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recursos', function (Blueprint $table) {
            $table->integer('tituloRecurso')->nullable()->change();
            $table->integer('corpoRecurso')->nullable()->change();
            $table->integer('statusAvaliacao')->nullable()->change();
            $table->integer('trabalhoId')->nullable()->change();
            $table->integer('comissaoId')->nullable()->change();
            $table->renameColumn('comissaoId', 'userId');
            $table->string('pdfRecurso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recursos', function (Blueprint $table) {
            $table->string('tituloRecurso')->nullable(false)->change();
            $table->text('corpoRecurso')->nullable(false)->change();
            $table->boolean('statusAvaliacao')->nullable(false)->change();
            $table->integer('trabalhoId')->nullable(false)->change();
            $table->integer('comissaoId')->nullable(false)->change();
            $table->renameColumn('userId', 'comissaoId');
            $table->dropColumn('pdfRecurso');
        });
    }
}
