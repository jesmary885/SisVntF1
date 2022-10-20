@extends('adminlte::page')

@section('content')

{{-- <div class="flex bg-indigo-500 ">
  <h1 class="text-xl text-sky-600 font-bold mt-6">
    <i class="fas fa-columns"></i> Tablero 
  </h1>
  <p class="text-sm text-gray-600 font-semibold mt-10 ml-2">
    Panel de control
  </p>

</div> --}}


<div class="row mt-6">
  @can('ventas.ventas.index')
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
           <h3>{{$ventas_totales_dia}} - {{ $moneda_simbolo }} {{round(($total_ganancias_dia / $tasa_dia),2)}}</h3>
          <!-- <h3>20 - $/1500</h3> -->

          <p>Ventas del dia</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{route('ventas.ventas.index')}}" class="small-box-footer">Nueva venta <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
  @endcan
    <!-- ./col -->
    @can('productos.productos.index')
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$productos_cant}}</h3>
          <!-- <h3>150</h3> -->

          <p>Productos Registrados</p>
        </div>
        <div class="icon">
          <i class="ion ion-filing"></i>
        </div>
        <a href="{{route('productos.productos.create')}}" class="small-box-footer">Nuevo producto<i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    @endcan
    <!-- ./col -->

   {{-- <div class="col-lg-3 col-6">
      <!-- small box -->
      @if( $total_movimientos_pendientes == 0)
      <div class="small-box bg-info">
      @else
        <div class="small-box bg-danger">
      @endif
      
        <div class="inner">
          <h3>{{$total_movimientos_pendientes}}</h3>
          <p>Tranferencia pendiente por recibir</p>
        </div>
        <div class="icon">
          <i class="ion ion-filing"></i>
        </div>
        <a href="{{route('movimientos.caja.index.pendiente')}}"  class="small-box-footer">Recibir movimiento en caja<i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>--}}

    <div class="col-lg-3 col-6">
      <!-- small box -->
      @if( $productos_agotar == 0)
      <div class="small-box bg-info">
      @else
        <div class="small-box bg-danger">
      @endif
      
        <div class="inner">
          <h3>{{$productos_agotar}}</h3>
          <p>Productos por agotarse</p>
        </div>
        <div class="icon">
          <i class="ion ion-filing"></i>
        </div>
        <a href="{{route('reportes.producto_agotar')}}"  class="small-box-footer">Más detalle <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    {{--<div class="col-lg-3 col-6">
      <!-- small box -->
      @if( $aperturo == 'si')
      <div class="small-box bg-success">
      <div class="inner">
          <h3>Caja aperturada</h3>
          <p>Cierre de caja pendiente</p>
        </div>
        <div class="icon">
          <i class="ion ion-filing"></i>
        </div>
        <a href="{{route('apertura-caja.index')}}"  class="small-box-footer">Cierre de caja <i class="fas fa-arrow-circle-right"></i></a>
      </div>
      @else
        <div class="small-box bg-danger">
        <div class="inner">
        <h3>-</h3>
          <p>Apertura de caja pendiente</p>
        </div>
        <div class="icon">
          <i class="ion ion-filing"></i>
        </div>
        <a href="{{route('apertura-caja.index')}}"  class="small-box-footer"> Aperturar caja <i class="fas fa-arrow-circle-right"></i></a>
      </div>
      @endif
    </div>--}}

    <!-- ./col -->
    {{-- @can('admin.clientes.index') --}}
    {{--<div class="col-lg-3 col-6">
      <!-- small box -->
      @if( $total_traslados_pendientes == 0)
      <div class="small-box bg-info">
      @else
        <div class="small-box bg-danger">
      @endif
      
        <div class="inner">
          <h3>{{$total_traslados_pendientes}}</h3>
          <p>Equipos pendientes por recibir</p>
        </div>
        <div class="icon">
          <i class="ion ion-filing"></i>
        </div>
        <a href="{{route('traslado_recibir.index')}}"  class="small-box-footer">Recibir traslado<i class="fas fa-arrow-circle-right"></i></a>
      </div>--}}

      <div class="col-lg-3 col-6">
      <!-- small box -->
      @if( $productos_vencer == 0)
      <div class="small-box bg-info">
      @else
        <div class="small-box bg-danger">
      @endif
      
        <div class="inner">
          <h3>{{$productos_vencer}}</h3>
          <p>Productos por vencer</p>
        </div>
        <div class="icon">
          <i class="ion ion-filing"></i>
        </div>
        <a href="{{route('reportes.producto_vencer')}}"  class="small-box-footer">Más detalle <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    {{-- @endcan --}}
    <!-- ./col -->
   
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
  
  <aside class="md:col-span-1 lg:col-span-2">

   @livewire('home.ventas')

  </aside>


  <div class="md:col-span-1 lg:col-span-2">
    
    @livewire('home.movimientos')
    
  </div>

</div>
    


    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
