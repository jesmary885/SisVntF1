<?php

use App\Http\Controllers\Admin\CajasController;
use App\Http\Controllers\Admin\CategoriasController;
use App\Http\Controllers\Admin\ClientesController;
use App\Http\Controllers\Admin\ComprasController;
use App\Http\Controllers\Admin\MarcasController;
use App\Http\Controllers\Admin\MetodosPagoController;
use App\Http\Controllers\Admin\ModelosController;
use App\Http\Controllers\Admin\ProveedoresController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SucursalesController;
use App\Http\Controllers\AjustesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Movimientos\MovimientoController;
use App\Http\Controllers\Productos\FilesController;
use App\Http\Controllers\Productos\MovimientosController;
use App\Http\Controllers\Productos\ProductosController;
use App\Http\Controllers\Productos\ProductosMovController;
use App\Http\Controllers\Productos\ProductosSerialController;
use App\Http\Controllers\Proformas\ProformasController;
use App\Http\Controllers\Reportes\ReportesController;
use App\Http\Controllers\tasaController;
use App\Http\Controllers\Ventas\FacturacionController;
use App\Http\Controllers\Ventas\MostrarVentasController;
use App\Http\Controllers\Ventas\VentasController;
use App\Http\Controllers\Ventas\VentasViewController;
use App\Http\Livewire\Productos\ProductosTraslado;
use App\Http\Livewire\Ventas\VentasPorCliente;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('auth/login');
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::get('/home',[HomeController::class,'index'])->name('home');


Auth::routes();

//Gestion administrativa
Route::middleware(['auth'])->group(function()
{

Route::resource('roles', RoleController::class)->only('index','edit','update','destroy','create','store')->names('admin.roles');
Route::resource('clientes', ClientesController::class)->only('index')->names('admin.clientes');
Route::resource('proveedores', ProveedoresController::class)->only('index')->names('admin.proveedores');
Route::resource('sucursales', SucursalesController::class)->only('index')->names('admin.sucursales');

Route::resource('categorias', CategoriasController::class)->only('index','store')->names('admin.categorias');
Route::resource('marcas', MarcasController::class)->only('index','store')->names('admin.marcas');
Route::resource('modelos', ModelosController::class)->only('index','store')->names('admin.modelos');
Route::resource('tasa', tasaController::class)->only('index','edit')->names('admin.tasa');
Route::get('cajas', [CajasController::class, 'index'])->name('admin.index.cajas');
Route::get('metodos_pago', [MetodosPagoController::class, 'index'])->name('admin.index.metodos');

Route::resource('productos', ProductosController::class)->only('index','create','edit','store')->names('productos.productos');
Route::get('productos_lotes',[MovimientosController::class,'productos_lotes'])->name('productos.lotes.index');
Route::resource('Ventas', VentasController::class)->only('create','index','update','show','edit')->names('ventas.ventas');
Route::resource('Mostrar_ventas', MostrarVentasController::class)->only('create','index','edit','update','show')->names('ventas.mostrar_ventas');
Route::get('compras',[ComprasController::class,'index'])->name('admin.compras.index');
Route::get('ventas/{sucursal}/{proforma}',[VentasController::class,'edit'])->name('ventas.ventas.edits');
Route::post('compras_import',[ComprasController::class,'store'])->name('admin.compras.store');

Route::get('facturacion/{sucursal}/{proforma}',[FacturacionController::class,'facturacion'])->name('facturacion');

Route::get('recibir_productos',[MovimientosController::class,'index_recibir'])->name('traslado_recibir.index');
Route::get('enviar_productos',[MovimientosController::class,'index_enviar'])->name('traslado_enviar.index');
Route::get('recibir_productos/{sucursal}',[MovimientosController::class,'select'])->name('productos.traslado.select');
Route::get('enviar_productos/{sucursal}',[MovimientosController::class,'select_enviar'])->name('productos.traslado.select.enviar');
Route::get('traslado/{sucursal}/{producto}',[MovimientosController::class,'select_serial'])->name('productos.traslado.serial');

//Mostrar ventas al contado y a credito
Route::get('Mostrar_ventas/{sucursal}/{tipo}',[MovimientosController::class,'mostrar_ventas'])->name('mostrar.ventas');


Route::get('devolucion',[MovimientosController::class,'devolucion'])->name('devolucion.index');
Route::get('devolucion_registro',[MovimientosController::class,'devolucion_create'])->name('devolucion.create');

//Proformas

Route::get('Proforma',[ProformasController::class,'index'])->name('proformas.proformas.index');
Route::get('Proforma_lista',[ProformasController::class,'view'])->name('proformas.view');
Route::get('Ventas/{sucursal}/{proforma}',[ProformasController::class,'seleccio'])->name('ventas.seleccio');

//Movimientos en caja

Route::get('Movimientos_caja',[MovimientoController::class,'index'])->name('movimiento.caja.index');
Route::get('Movimientos_caja_pendiente',[MovimientoController::class,'index_pendiente'])->name('movimientos.caja.index.pendiente');
Route::get('Nuevo_movimiento_caja/{sucursal}',[MovimientoController::class,'view'])->name('movimiento.caja.view');
Route::get('Nuevo_movimiento_pendiente_caja/{sucursal}',[MovimientoController::class,'view_pendiente'])->name('movimiento.caja_pendiente.view');



//Reportes

//reportes de historial de productos
Route::get('historial_modalidad',[MovimientosController::class,'select_modalidad'])->name('movimientos.modalidad');
Route::post('historial_modalidad',[MovimientosController::class,'buscar'])->name('movimientos.buscar');
Route::get('historial_modalidad/productos_cod_barra',[MovimientosController::class,'historial'])->name('movimientos.historial');
Route::get('historial_modalidad/productos_serial',[MovimientosController::class,'historial_prod_serial'])->name('movimientos.historial_prod_serial');
Route::get('historial_modalidad/{vista}/{producto}/{fecha_inicio}/{fecha_fin}',[MovimientosController::class,'historial_detalle'])->name('movimientos.historial.detalle');

//reporte de productos mas vendidos
Route::get('reporte_poducto',[ReportesController::class,'index_producto'])->name('reportes.index.productos');
Route::get('reportes_productos/{sucursal_id}/{fecha_inicio}/{fecha_fin}',[ReportesController::class,'productos'])->name('productos.reportes');
//reporte de ventas
Route::get('reporte_venta',[ReportesController::class,'index_venta'])->name('reportes.index.ventas');
Route::get('reportes_ventas/{sucursal_id}/{fecha_inicio}/{fecha_fin}',[ReportesController::class,'ventas'])->name('ventas.reportes');

//Mostrar ventas por clientes
Route::get('ventas_clientes',[VentasViewController::class,'index'])->name('ventas.clientes');
Route::get('ventas_clientes/{sucursal}',[VentasViewController::class,'view'])->name('ventas.clientes.view');
//reporte de traslados
Route::get('reporte_traslados',[ReportesController::class,'index_traslados'])->name('reportes.index.traslados'); 
Route::get('reportes_traslados/{fecha_inicio}/{fecha_fin}',[ReportesController::class,'traslados'])->name('traslados.reportes');

//reporte de productos desactivados
Route::get('reporte_desactivados',[ReportesController::class,'index_desactivados'])->name('reportes.index.desactivados'); 


//reporte movimientos en caja
Route::get('reporte_caja',[ReportesController::class,'index_caja'])->name('reportes.index.caja');
Route::get('reportes_caja/{sucursal_id}/{fecha_inicio}/{fecha_fin}',[ReportesController::class,'cajas'])->name('cajas.reportes');
//reporte de kardex
Route::get('reporte_kardex',[ReportesController::class,'index_kardex'])->name('reportes.index.kardex');
Route::get('reportes_kardex/{fecha_inicio}/{fecha_fin}',[ReportesController::class,'kardex'])->name('kardex.reportes');



// livewire

//Route::get('productos/{sucursal}/traslado', ProductosTraslado::class)->name('reportes.index.traslados');

//Cargar imagen de producto
Route::post('productos/{product}/files', [FilesController::class, 'files'])->name('productos.files');

//productos por serial

// Route::get('productos_serial',[ProductosSerialController::class,'index'])->name('productos.serial.index');
// Route::post('productos_serial',[ProductosSerialController::class,'store'])->name('productos.serial.store');
// Route::get('productos_serial/{sucursal}',[ProductosSerialController::class,'view'])->name('productos.serial.view');

//Ajustes

Route::get('cambiar_contrasena',[AjustesController::class,'ccontrasena'])->name('ajustes.ccontrasena');
Route::get('sobre_empresa',[AjustesController::class,'empresa'])->name('ajustes.empresa');
Route::get('cambiar_moneda',[AjustesController::class,'moneda'])->name('cambiar-moneda');
Route::get('aperturar_caja',[AjustesController::class,'aperturaCaja'])->name('apertura-caja.index');

});

