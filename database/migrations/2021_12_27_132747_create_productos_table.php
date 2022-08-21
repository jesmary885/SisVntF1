<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('precio_entrada')->nullable();
            $table->string('precio_letal')->nullable();
            $table->string('precio_mayor')->nullable();
            $table->string('cod_barra');
            $table->enum('estado',['Habilitado','Deshabilitado'])->default('Habilitado');
            $table->integer('cantidad');
            $table->string('observaciones')->nullable();
            $table->enum('presentacion',['Unidad','Libra','Kg','Caja','Paquete','Lata','Galon','Botella','Tira','Sobre','Saco','Tarjeta','Otro'])->default('Unidad');
            $table->integer('stock_minimo');
            $table->integer('descuento')->nullable();
            $table->enum('vencimiento',['Si','No'])->default('No');
            $table->integer('unidad_tiempo_garantia')->nullable();
            $table->enum('tipo_garantia',['N/A','Dias','Semanas','Mes','Meses','Año','Años'])->default('N/A');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->unsignedBigInteger('modelo_id');
            $table->foreign('modelo_id')->references('id')->on('modelos');
            $table->unsignedBigInteger('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
