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
          <h3>{{$ventas_totales_dia}} - S/{{$total_ganancias_dia}}</h3>

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

    <div class="col-lg-3 col-6">
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
    </div>

    {{-- @can('admin.clientes.index')
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$clientes_cant}}</h3>

          <p>Clientes registrados</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{route('admin.clientes.index')}}" class="small-box-footer">Nuevo cliente <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
  
    @endcan --}}
    {{-- @can('reportes.productos')
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>Reportes</h3>

          <p>de ventas y productos</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{route('reportes.index.productos')}}" class="small-box-footer">Ver reportes<i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    @endcan --}}
    <!-- ./col -->
    {{-- @can('admin.clientes.index') --}}
    <div class="col-lg-3 col-6">
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
