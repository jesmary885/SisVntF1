@extends('adminlte::page')

@section('content')

<div class="row mt-6">
@can('ventas.ventas_dashboard_count')
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
  @else

  <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
        
           <h3> . </h3>
          <!-- <h3>20 - $/1500</h3> -->

          <p>.  </p>
         
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

    @can('productos.dashboard_agotar')

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
    @endcan


    @can('productos.dashboard_vencer')
      <div class="col-lg-3 col-6">
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
     @endcan

   
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
@can('ventas.ventas_dashboard')
  <aside class="md:col-span-1 lg:col-span-2">

   @livewire('home.ventas')

  </aside>
  @endcan

  @can('productos.dashboard_vencer')
  <div class="md:col-span-1 lg:col-span-2">
    
    @livewire('home.movimientos')
    
  </div>
  @endcan

</div>
    


    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
