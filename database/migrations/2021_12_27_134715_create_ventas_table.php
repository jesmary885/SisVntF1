<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('fecha');
          
            $table->string('tipo_pago');
            $table->string('estado_entrega');
            $table->float('descuento');
            $table->float('subtotal');
            $table->float('total');
            $table->float('impuesto');
            $table->float('exento');
            $table->float('total_pagado_cliente');
            $table->float('deuda_cliente')->nullable();
            $table->string('estado');
            $table->float('vuelto')->nullable();      

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');

            $table->unsignedBigInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('cajas');

            $table->unsignedBigInteger('metodo_pago_vuelto_id')->nullable();
            $table->foreign('metodo_pago_vuelto_id')->references('id')->on('metodo_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
