<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ventas;
use App\Models\DetalleVenta;
use App\Models\Productos;
use Carbon\Carbon;
use Datetime;
class VentasController extends Controller
{
    public function ListarVentasDelDia(){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d');
        $Ventas = Ventas::where('FechaVenta', 'LIKE', "%{$Fecha}%")->orderBy('FechaVenta', 'DESC')->get();
        $VentaFormato = array();
        $VentasNew = [];
        foreach($Ventas as $Listado){
            $VentaFormato['IdVenta'] = $Listado->IdVenta;
            $VentaFormato['IdCliente'] = $Listado->IdCliente;
            $VentaFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $VentaFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $VentaFormato['IdSucursal'] = $Listado->IdSucursal;
            $VentaFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $VentaFormato['IdUsuario'] = $Listado->IdUsuario;
            $VentaFormato['DecUser'] = $Listado->User->email;
            $VentaFormato['Pago'] = $Listado->Pago;
            $VentaFormato['Vuelto'] = $Listado->Vuelto;
            $VentaFormato['CantidadProducto'] = $Listado->TotalProducto;
            $VentaFormato['TotalVenta'] = $Listado->TotalVenta;
            $VentaFormato['FechaVenta'] =   date_format(new Datetime($Listado->FechaVenta), 'd-M-Y');
            $VentaFormato['Hora'] = date_format(new DateTime($Listado->FechaVenta), "H:i:s");
            $VentaFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $VentaFormato['Estado'] = $Listado->Estado;
                array_push($VentasNew, $VentaFormato);
        }
        return response()->json($VentasNew ,200);
    }
    public function ListarVentasVendedor(Request $request){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d');
        $Ventas = Ventas::where('FechaVenta', 'LIKE', "%{$Fecha}%")->where('IdUsuario','=' ,$request->IdUser)->orderBy('FechaVenta', 'DESC')->get();
        $VentaFormato = array();
        $VentasNew = [];
        foreach($Ventas as $Listado){
            $VentaFormato['IdVenta'] = $Listado->IdVenta;
            $VentaFormato['IdCliente'] = $Listado->IdCliente;
            $VentaFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $VentaFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $VentaFormato['IdSucursal'] = $Listado->IdSucursal;
            $VentaFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $VentaFormato['IdUsuario'] = $Listado->IdUsuario;
            $VentaFormato['DecUser'] = $Listado->User->email;
            $VentaFormato['Pago'] = $Listado->Pago;
            $VentaFormato['Vuelto'] = $Listado->Vuelto;
            $VentaFormato['CantidadProducto'] = $Listado->TotalProducto;
            $VentaFormato['TotalVenta'] = $Listado->TotalVenta;
            $VentaFormato['FechaVenta'] =   date_format(new Datetime($Listado->FechaVenta), 'd-M-Y');
            $VentaFormato['Hora'] = date_format(new DateTime($Listado->FechaVenta), "H:i:s");
            $VentaFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $VentaFormato['Estado'] = $Listado->Estado;
                array_push($VentasNew, $VentaFormato);
        }
        return response()->json($VentasNew ,200);
    }
    public function ListarVentasPorSucursal(Request $request){
        $Ventas = Ventas::where('IdSucursal', '=', $request->IdSucursal)->orderBy('FechaVenta', 'DESC')->get();
        $VentaFormato = array();
        $VentasNew = [];
        foreach($Ventas as $Listado){
            $VentaFormato['IdVenta'] = $Listado->IdVenta;
            $VentaFormato['IdCliente'] = $Listado->IdCliente;
            $VentaFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $VentaFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $VentaFormato['IdSucursal'] = $Listado->IdSucursal;
            $VentaFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $VentaFormato['IdUsuario'] = $Listado->IdUsuario;
            $VentaFormato['DecUser'] = $Listado->User->email;
            $VentaFormato['Pago'] = $Listado->Pago;
            $VentaFormato['Vuelto'] = $Listado->Vuelto;
            $VentaFormato['CantidadProducto'] = $Listado->TotalProducto;
            $VentaFormato['TotalVenta'] = $Listado->TotalVenta;
            $VentaFormato['FechaVenta'] =   date_format(new Datetime($Listado->FechaVenta), 'd-M-Y');
            $VentaFormato['Hora'] = date_format(new DateTime($Listado->FechaVenta), "H:i:s");
            $VentaFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $VentaFormato['Estado'] = $Listado->Estado;
                array_push($VentasNew, $VentaFormato);
        }
        return response()->json($VentasNew ,200);
    }    
    public function GenerarVenta(Request $request){
        //Tomas Datos
        $IdCliente = $request->IdCliente;
        $IdUsuario =  $request->IdUsuario;
        $TotalVenta = $request->TotalVenta;
        $Pago = $request->Pago;
        $Vuelto = $request->Vuelto;
        $IdSucursal = $request->IdSucursal;
        // Detalle 
        $Productos = $request->IdProductos;
        $Cantidades = $request->Cantidades;
        $SubTotales = $request->SubTotales;

        $Venta = new Ventas();
        $Venta->IdCliente = $IdCliente;
        if($IdCliente == null || $IdCliente == ''){
            $Venta->IdCliente = 5;
        }else{
            $Venta->IdCliente = $IdCliente;
        }
        $Venta->IdUsuario = $IdUsuario;
        $Venta->FechaVenta = Carbon::now('America/Guatemala');
        $Venta->TotalProducto = array_sum($request->Cantidades);
        $Venta->TotalVenta = $TotalVenta;
        $Venta->Estado = 4;
        $Venta->Pago = $Pago;
        $Venta->Vuelto = $Vuelto;
        $Venta->IdSucursal = $IdSucursal;

        if($Venta->save()){
            $IdVenta = $Venta->IdVenta;
            for($i = 0; $i < count($Productos); $i++){
                $IdProducto = $Productos[$i];
                $Cantidad = $Cantidades[$i];
                $SubTotal = $SubTotales[$i];

                $DetalleVenta = new DetalleVenta();
                $DetalleVenta->IdVenta = $IdVenta;
                $DetalleVenta->IdProducto = $IdProducto;
                $DetalleVenta->SubTotal = $SubTotal;
                $DetalleVenta->CantProductos = $Cantidad;
                $DetalleVenta->Estado = 4;

                if($DetalleVenta->save()){
                    $ProductosFind = Productos::find($IdProducto);
                    $StokActual = $ProductosFind->Stok;
                    $StokModificado = $StokActual - $Cantidad;
                    $ProductosFind->Stok = $StokModificado;
                    $ProductosFind->save();
                }

            }
        }
        return response()->json($Venta, 200);
    }
    //Filtrado 
    
    public function FiltroVentas(Request $request){
        $FechaFiltro = $request->DatosFiltro;
        // Pendiden arreglar Fecha Compra
        if($request->TipoFiltro == 3){//Entre Fechas, Fecha Inicial y Fecha Final
            $Ventas = Ventas::where('FechaVenta', '>=', $request->FechaInicial)
            ->where('FechaVenta','<=', $request->FechaFinal)
            ->where('IdSucursal', '=', $request->IdSucursal)->orderBy('FechaVenta', 'DESC')->get();

        }else if($request->TipoFiltro == 2 || $request->TipoFiltro == 4){
            // Buscar Por Mes 
          
            $Ventas = Ventas::where('FechaVenta', 'LIKE', "%{$FechaFiltro}%")
            ->where('IdSucursal', '=', $request->IdSucursal)->orderBy('FechaVenta', 'DESC')->get();
        }
        $VentaFormato = array();
        $VentasNew = [];
        foreach($Ventas as $Listado){
            $VentaFormato['IdVenta'] = $Listado->IdVenta;
            $VentaFormato['IdCliente'] = $Listado->IdCliente;
            $VentaFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $VentaFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $VentaFormato['IdSucursal'] = $Listado->IdSucursal;
            $VentaFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $VentaFormato['IdUsuario'] = $Listado->IdUsuario;
            $VentaFormato['DecUser'] = $Listado->User->email;
            $VentaFormato['Pago'] = $Listado->Pago;
            $VentaFormato['Vuelto'] = $Listado->Vuelto;
            $VentaFormato['CantidadProducto'] = $Listado->TotalProducto;
            $VentaFormato['TotalVenta'] = $Listado->TotalVenta;
            $VentaFormato['FechaVenta'] =   date_format(new Datetime($Listado->FechaVenta), 'd-M-Y');
            $VentaFormato['Hora'] = date_format(new DateTime($Listado->FechaVenta), "H:i:s");
            $VentaFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $VentaFormato['Estado'] = $Listado->Estado;
                array_push($VentasNew, $VentaFormato);
        }
        return response()->json($VentasNew ,200);
    }
    // Ver Detalle Venta
    public function VerDetalleVenta(Request $request){
        $DetalleVenta = DetalleVenta::where('IdVenta', '=' , $request->IdVenta)->get();
        $VentaFormato = array();
        $VentasNew = [];
        foreach($DetalleVenta as $Listado){
            $VentaFormato['IdDetalleVenta']  = $Listado->IdDetalleVenta;
            $VentaFormato['NombreProducto']  = $Listado->Productos[0]->NombreProducto;
            $VentaFormato['Cantidad']  = $Listado->CantProductos;
            $VentaFormato['SubTotal']  = $Listado->SubTotal;
            // Sucursal
            $VentaFormato['NombreSucursal']  = $Listado->Ventas->Sucursal->NombreSucursal;
            // Usuario
            $VentaFormato['Empleado']  = $Listado->Ventas->User->DecEmpleado[0]->Nombre;
            $VentaFormato['EmpleaApellido']  = $Listado->Ventas->User->DecEmpleado[0]->Apellido;            
            $VentaFormato['Usuario']  = $Listado->Ventas->User->email;
            $VentaFormato['FechaVenta']  =  date_format(new Datetime($Listado->Ventas->FechaVenta), 'd-M-Y'); 
            $VentaFormato['Hora']  =  date_format(new Datetime($Listado->Ventas->FechaVenta), 'H:i:s'); 
            // Cliente
            $VentaFormato['NombreCliente']  = $Listado->Ventas->Clientes->Nombres;
            $VentaFormato['ApellidoCliente']  = $Listado->Ventas->Clientes->Apellidos;  
            $VentaFormato['TotalVenta']  = $Listado->Ventas->TotalVenta;
            $VentaFormato['Pago']  = $Listado->Ventas->Pago;
            $VentaFormato['Vuelto']  = $Listado->Ventas->Vuelto;
            array_push($VentasNew, $VentaFormato);
        }
        return response()->json($VentasNew, 200);
    }

    // listar las ultminas compras
    public function UltimasVentasMes(Request $request){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('m');
        $Ventas = Ventas::whereMonth('FechaVenta', '>=', $Fecha)->where('IdSucursal','=', $request->IdSucursal)->get();
        $TotalVentas = 0;
        for ($i=0; $i < count($Ventas) ; $i++) { 
            $TotalVentas = $TotalVentas + $Ventas[$i]->TotalVenta;
        }
        return response()->json($TotalVentas, 200);
    }    
}