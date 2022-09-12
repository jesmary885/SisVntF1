<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_lotes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('lote');
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            
            $table->date('fecha_vencimiento')->nullable();
            $table->float('precio_entrada');
            $table->float('precio_letal');
            $table->float('precio_mayor');
            $table->float('utilidad_letal');
            $table->float('utilidad_mayor');
            $table->float('margen_letal');
            $table->float('margen_mayor');
            $table->integer('stock');
            $table->string('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_lotes');
    }
}
