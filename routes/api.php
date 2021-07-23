<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\SucursalesController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\DetalleCitaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::group(['middleware' => ['api', 'cors'],'prefix' => 'api',], function ($router) {
   
// });
Route::group(['prefix' => 'auth'], function (){
    Route::post('/Login', [AuthController::class, 'Login']);
    Route::post('/Register', [AuthController::class, 'Register']);
    
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('logout',[AuthController::class, 'Logout']);
        Route::get('user',[AuthController::class, 'user']);
    });
});
// Proveedores 
Route::group(['prefix' => 'auth'],function(){
    Route::group(['middleware' => 'auth:api'],function(){
        Route::get('ListarProveedor',[ProveedoresController::class, 'ListarProveedor']);
        Route::post('CrearProveedor',[ProveedoresController::class, 'CrearProveedor']);      
        Route::post('EditarProveedor',[ProveedoresController::class, 'EditarProveedor']);
        Route::post('DesabilitarProveedor',[ProveedoresController::class, 'DesabilitarProveedor']);    
        Route::post('HabilitarProveedor',[ProveedoresController::class, 'HabilitarProveedor']);    
        Route::post('EditarProoveedor',[ProveedoresController::class, 'EditarProoveedor']);    
        Route::post('BuscarProveedor',[ProveedoresController::class, 'BuscarProveedor']);    
        Route::post('BuscadorFiltroProvee',[ProveedoresController::class, 'BuscadorFiltroProvee']);    
        
        // Info Editar Proveedor
        Route::post('InfoEditarProveedor',[ProveedoresController::class, 'InfoEditarProveedor']);    
        
    });
});
// Sucursales 
Route::group(['prefix' => 'auth'],function(){
  
    Route::group(['middleware' => 'auth:api'],function(){
        
        Route::get('ListarTodasSucursales',[SucursalesController::class,'ListarTodasSucur']);
        Route::post('ListarTodasSucursalesEstado',[SucursalesController::class,'ListarTodasSucursalesEstado']);
        
        Route::post('LstHoraActual',[SucursalesController::class,'LstHoraActual']);
        Route::post('LstHoraActualTime',[SucursalesController::class,'LstHoraActualTime']);
        
        Route::post('CrearSucursal',[SucursalesController::class,'CrearSucursal']);
        Route::post('DesabilitarSucursal',[SucursalesController::class,'DesabilitarSucursal']);
        Route::post('HabilitarSucursal',[SucursalesController::class,'HabilitarSucursal']);
        Route::post('InfoEditSucursal',[SucursalesController::class,'InfoEditSucursal']);
        Route::post('EditarSucursal',[SucursalesController::class,'EditarSucursal']);
        
    });
});
// Empleads he TipoUsuarios
Route::group(['prefix' => 'auth'],function(){
     Route::get('VerImgEmpleado/{NombreImg}',[EmpleadosController::class,'VerImgEmpleado']);    

    Route::group(['middleware' => 'auth:api'],function(){
        
        Route::get('ListTipoUsuario',[EmpleadosController::class,'ListTipoUsuario']);
        Route::post('CrearEmpleado',[EmpleadosController::class,'CrearEmpleado']);
        Route::get('ListarEmpleados',[EmpleadosController::class,'ListarEmpleados']);
        Route::post('DesabilitarEmpleado',[EmpleadosController::class, 'DesabilitarEmpleado']);
        Route::post('HabilitarEmpleado',[EmpleadosController::class, 'HabilitarEmpleado']);
        Route::post('EditarEmpleado',[EmpleadosController::class, 'EditarEmpleado']);
        Route::post('EditarUsuario',[EmpleadosController::class, 'EditarUsuario']);
        Route::post('SubirFotoEmpleado/{IdEmpleado}',[EmpleadosController::class, 'SubirFotoEmpleado']);
        
        // Listado Empleado Editar
        Route::post('ListEmpleadoEdit',[EmpleadosController::class, 'ListEmpleadoEdit']);
        // Listado Usuario Editar
        Route::post('InfoEditUsuario',[EmpleadosController::class, 'InfoEditUsuario']);
        
        // Buscador 
        Route::post('BuscarEmpleado',[EmpleadosController::class,'BuscarEmpleado']);        
        // Filtrado por sucursal 
        Route::post('FiltroPorSucursal',[EmpleadosController::class,'FiltroPorSucursal']);        
        // ver imagenes 
         
        
    });
});
// Clientes

Route::group(['prefix' => 'auth'],function(){
    Route::get('VerImgCliente/{NombreImg}',[ClientesController::class,'VerImgCliente']);        
    Route::group(['middleware' => 'auth:api'],function(){
        Route::post('CrearClient', [ClientesController::class, 'CrearClient']);
        Route::get('ListarCliente',[ClientesController::class,'ListarCliente']);
        Route::post('DesabilitarCliente',[ClientesController::class,'DesabilitarCliente']);
        Route::post('HabilitarCliente',[ClientesController::class,'HabilitarCliente']);
        Route::post('BuscarCliente',[ClientesController::class,'BuscarCliente']);
        Route::post('BuscadorFiltro',[ClientesController::class,'BuscadorFiltro']);
        Route::post('EditarCliente',[ClientesController::class,'EditarCliente']);
        Route::post('SubirFotoCliente/{IdCliente}',[ClientesController::class, 'SubirFotoCliente']);

        // Listado Info Editar Cliente
        Route::post('InfoEditCliente',[ClientesController::class,'InfoEditCliente']);
        Route::post('BuscarClienteId',[ClientesController::class,'BuscarClienteId']);
        
    });
});
// Rutas de Productos 
Route::group(['prefix' => 'auth'], function(){
    Route::get('VerImgProducto/{NombreImg}',[ProductosController::class,'VerImgProducto']);        
    Route::get('VerImgSinFoto/{ImgSinFoto}',[ProductosController::class,'VerImgSinFoto']);        
    
    Route::group(['middleware' => 'auth:api'], function(){
        // TipoProducto
       
        // Productos        
        Route::get('ListadoProductos', [ProductosController::class, 'ListadoProductos']);
        Route::post('ListarProductosIdSucursal', [ProductosController::class, 'ListarProductosIdSucursal']);        
        Route::post('CrearProducto', [ProductosController::class, 'CrearProducto']);
        Route::post('DesabilitarProducto', [ProductosController::class, 'DesabilitarProducto']);
        Route::post('HabilitarProducto', [ProductosController::class, 'HabilitarProducto']);
        // Info Editar
        Route::post('InfoEditarProducto', [ProductosController::class, 'InfoEditarProducto']);
        Route::post('EditarProducto', [ProductosController::class, 'EditarProducto']);
        Route::post('SubirFotoProducto/{IdProducto}', [ProductosController::class, 'SubirFotoProducto']);        
        // Filtros        
        Route::post('FiltroProducto', [ProductosController::class, 'FiltroProducto']);
        Route::post('BuscadorProducto', [ProductosController::class, 'BuscadorProducto']);
        Route::post('BuscarProductoId', [ProductosController::class, 'BuscarProductoId']);
        Route::post('BuscarProductosConSucursal', [ProductosController::class, 'BuscarProductosConSucursal']);
        
    });
});
//  Tipo Producto
Route::group(['prefix' => 'auth'],function(){   
    Route::group(['middleware' => 'auth:api'],function(){
        Route::get('ListarTiposProductos', [TipoProductoController::class, 'ListarTiposProductos']);
        Route::post('CrearCategoria',[TipoProductoController::class,'CrearCategoria']);
        Route::post('DesabilitarCategoria',[TipoProductoController::class,'DesabilitarCategoria']);
        Route::post('HabilitarCategoria',[TipoProductoController::class,'HabilitarCategoria']);
        // Buscar Para devolver la info de editar
        Route::post('BuscarTipoProductoId',[TipoProductoController::class,'BuscarTipoProductoId']);
        Route::post('EditarCategoria',[TipoProductoController::class,'EditarCategoria']);
        
        // Buscador 
        Route::post('BuscadorGeneral',[TipoProductoController::class,'BuscadorGeneral']);
        Route::post('FiltradoEstados',[TipoProductoController::class,'FiltradoEstados']);
        
    });
});
// Servicios
Route::group(['prefix' => 'auth'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('ListadoServicios', [ServiciosController::class, 'ListadoServicios']);
        Route::post('CrearServicio', [ServiciosController::class, 'CrearServicio']);
        Route::post('DesabilitarServicio', [ServiciosController::class, 'DesabilitarServicio']);
        Route::post('HabilitarServicio', [ServiciosController::class, 'HabilitarServicio']);
        Route::post('InfoEditarServicio', [ServiciosController::class, 'InfoEditarServicio']);
        Route::post('EditarServicio', [ServiciosController::class, 'EditarServicio']);
        
        // Filtros
        Route::post('FiltroEstados', [ServiciosController::class, 'FiltroEstados']);
        Route::post('BuscardorGeneralSv', [ServiciosController::class, 'BuscardorGeneralSv']);
        Route::post('FiltroSucursales', [ServiciosController::class, 'FiltroSucursales']);
        Route::post('ListadoServiciosId', [ServiciosController::class, 'ListadoServiciosId']);
        Route::post('ListadoServiciosIdEditarCita', [ServiciosController::class, 'ListadoServiciosIdEditarCita']);
        
       
    });
});
// Compras
Route::group(['prefix' => 'auth'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
    //    Listado Compras
    Route::get('ListarComprasDelDia', [ComprasController::class, 'ListarComprasDelDia']);    
        Route::post('GuardarCompra', [ComprasController::class, 'GuardarCompra']);        
        // Filtrado 
        Route::post('ListarComprasIdSucursal', [ComprasController::class, 'ListarComprasIdSucursal']);
        Route::post('FiltroCompras', [ComprasController::class, 'FiltroCompras']);
        // Detalle Compra
        Route::post('VerDetalleCompra', [ComprasController::class, 'VerDetalleCompra']);
        Route::post('UltimasComprasMes', [ComprasController::class, 'UltimasComprasMes']);
        
    });
});
// Ventas
Route::group(['prefix' => 'auth'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('GenerarVenta', [VentasController::class, 'GenerarVenta']);        
        Route::get('ListarVentasDelDia', [VentasController::class, 'ListarVentasDelDia']);        
        Route::post('ListarVentasVendedor', [VentasController::class, 'ListarVentasVendedor']);        
        
        Route::post('ListarVentasPorSucursal', [VentasController::class, 'ListarVentasPorSucursal']);                
        // Ver Detalle Venta
        Route::post('VerDetalleVenta', [VentasController::class, 'VerDetalleVenta']);                
        // Filtrado 
        Route::post('FiltroVentas', [VentasController::class, 'FiltroVentas']);    
                    // Ultimas Ventas Del Mes
                    
        Route::post('UltimasVentasMes', [VentasController::class, 'UltimasVentasMes']);    
    });
});
// Citas
Route::group(['prefix' => 'auth'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
        // Listado Citas del Dia        
        Route::get('ListarCitasDelDia', [CitasController::class, 'ListarCitasDelDia']);        
        Route::post('ListarCitasIdSucursal', [CitasController::class, 'ListarCitasIdSucursal']);
        Route::post('ListarCitasPorEstados', [CitasController::class, 'ListarCitasPorEstados']);
        Route::post('ListarCitasPorFecha', [CitasController::class, 'ListarCitasPorFecha']);        
        Route::post('GenerarCita', [CitasController::class, 'GenerarCita']);        
        Route::post('VerDetalleCita', [CitasController::class, 'VerDetalleCita']);        
        Route::post('FinalizarCita', [CitasController::class, 'FinalizarCita']);        
        Route::post('InfoEditarCita', [CitasController::class, 'InfoEditarCita']);        
        Route::post('EditarCita', [CitasController::class, 'EditarCita']);        
        Route::post('ListarPorMes', [CitasController::class, 'ListarPorMes']);        
        Route::post('BuscarGeneralF', [CitasController::class, 'BuscarGeneralF']);        
        // Citas Pendiendtes Cnatidad
        Route::post('CitasPendienteDelDia', [CitasController::class, 'CitasPendienteDelDia']);        
        Route::post('CitasFinalizadasDelDia', [CitasController::class, 'CitasFinalizadasDelDia']);        
        
        // Detalle Cita 
        Route::post('EditarDetalleCita', [DetalleCitaController::class, 'EditarDetalleCita']);        
        // Eliminar Detalle Cita osea Servicio
        Route::post('EliminarServiciosCita', [DetalleCitaController::class, 'EliminarServiciosCita']);                
        // Prueba pdf 
        Route::get('PDFCita', [CitasController::class, 'PDFCita']);        
        
    });
});




