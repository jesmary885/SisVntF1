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
            $table->enum('tipo_pago',['Debito','Credito'])->default('Debito');
            $table->enum('metodo_pago',['Tarjeta de Debito',
                                        'Tarjeta de Credito',
                                        'Efectivo',
                                        'Transferencia',
                                        'Pago movil',
                                        'Biopago',
                                        'Binance',
                                        'Zelle',
                                        'PayPal',
                                        'Otro']);
            $table->string('Observaciones');
            $table->string('estado_entrega');
            $table->float('descuento');
            $table->float('subtotal');
            $table->float('total');
            $table->float('impuesto');
            $table->float('total_pagado_cliente');
            $table->float('deuda_cliente')->nullable();
            $table->enum('estado',['Activo','Inactivo'])->default('Activo');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
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
