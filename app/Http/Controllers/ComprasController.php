<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compras;
use App\Models\DetalleCompra;
use App\Models\Productos;
use Carbon\Carbon;
use DateTime;
class ComprasController extends Controller
{
    // ListarCompras del Dia 
    public function ListarComprasDelDia(){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d');
        $Compras = Compras::where('FechaCompra', 'LIKE', "%{$Fecha}%")->get();
        $ComprasFormato = array();
        $ComprasNew = [];
        foreach($Compras as $Listado){
            $ComprasFormato['IdCompra'] = $Listado->IdCompra;
            $ComprasFormato['IdSucursal'] = $Listado->IdSucursal;
            $ComprasFormato['IdUsuario'] = $Listado->IdUsuario;
            $ComprasFormato['DecSucursal'] = $Listado->DecSucursal->NombreSucursal;
            $ComprasFormato['DecUser'] = $Listado->DecUser[0]->email;
            $ComprasFormato['FechaCompra'] = date_format(new DateTime($Listado->FechaCompra), "d-M-Y");
           
            $ComprasFormato['TotalProductos'] = $Listado->TotalProductos;
            $ComprasFormato['TotalCompra'] = $Listado->TotalCompra;
            $ComprasFormato['Estado'] = $Listado->Estado;
            $ComprasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;


            array_push($ComprasNew, $ComprasFormato);
            
        }
        return response()->json($ComprasNew ,200);
    }

    // Generar Compra 
    public function GuardarCompra(Request $request){
        // Tomando Datos de la Request
        
        $IdSucursal = $request->IdSucursal;
        $TotalCompra = $request->TotalCompra;
        $IdUsuario = $request->IdUsuario;

        $IdProductos = $request->IdProductos;
        $Cantidades = $request->Cantidades;
        $SubTotales = $request->Subtotales;
        // Fecha
        // $Fecha = 
        // $Fecha = $Fecha->format('Y-m-d');
        $Compra = new Compras();
        $Compra->IdSucursal = $IdSucursal;
        $Compra->IdUsuario = $IdUsuario;
        $Compra->TotalCompra = $TotalCompra;
        $Compra->TotalProductos = array_sum($Cantidades);
        $Compra->FechaCompra = Carbon::now('America/Guatemala');
        $Compra->Estado = 3;
        if($Compra->save()){
            $IdCompra = $Compra->IdCompra;
            for($i = 0 ; $i< count($IdProductos); $i++){            
                $IdProducto = $IdProductos[$i];
                $Cantidad = $Cantidades[$i];
                $SubTotal =$SubTotales[$i];


                $DetalleCompra = new DetalleCompra();
                $DetalleCompra->IdCompra = $IdCompra;
                $DetalleCompra->IdProducto = $IdProducto;
                $DetalleCompra->SubTotalCompra = $SubTotal;
                $DetalleCompra->SubTotalProduc = $Cantidad;
                $DetalleCompra->Estado = 3; 
                if($DetalleCompra->save()){
                    $Producto = Productos::find($IdProducto);
                    $StokAcutal = $Producto->Stok;
                    $StokAcutalizado = $StokAcutal + $Cantidad;
                    $Producto->Stok = $StokAcutalizado;
                    $Producto->save();
                       
                    
                }
            }
        }        
        return response()->json($Compra, 200);
    }

    // Filtrado
        // Por Sucursales
     
    public function ListarComprasIdSucursal(Request $request){
       
        $Compras = Compras::where('IdSucursal', '=', $request->IdSucursal)->orderBy('FechaCompra', 'DESC')->get();
        $ComprasFormato = array();
        $ComprasNew = [];
        foreach($Compras as $Listado){
            $ComprasFormato['IdCompra'] = $Listado->IdCompra;
            $ComprasFormato['IdSucursal'] = $Listado->IdSucursal;
            $ComprasFormato['IdUsuario'] = $Listado->IdUsuario;
            $ComprasFormato['DecSucursal'] = $Listado->DecSucursal->NombreSucursal;
            $ComprasFormato['DecUser'] = $Listado->DecUser[0]->email;
            $ComprasFormato['FechaCompra'] = date_format(new DateTime($Listado->FechaCompra), "d-M-Y");
            $ComprasFormato['TotalProductos'] = $Listado->TotalProductos;
            $ComprasFormato['TotalCompra'] = $Listado->TotalCompra;
            $ComprasFormato['Estado'] = $Listado->Estado;
            $ComprasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;


            array_push($ComprasNew, $ComprasFormato);
            
        }
        return response()->json($ComprasNew ,200);
    }

    public function FiltroCompras(Request $request){
        $FechaFiltro = $request->DatosFiltro;
        // Pendiden arreglar Fecha Compra
        if($request->TipoFiltro == 3){
            $Compras = Compras::where('FechaCompra', '>=', $request->FechaInicial)
            ->where('FechaCompra','<=', $request->FechaFinal)
            ->where('IdSucursal', '=', $request->IdSucursal)->orderBy('FechaCompra', 'DESC')->get();

        }else if($request->TipoFiltro == 2 || $request->TipoFiltro == 4){
            // Buscar Por Mes 
          
            $Compras = Compras::where('FechaCompra', 'LIKE', "%{$FechaFiltro}%")
            ->where('IdSucursal', '=', $request->IdSucursal)->orderBy('FechaCompra', 'DESC')->get();
        }

        $ComprasFormato = array();
        $ComprasNew = [];
        foreach($Compras as $Listado){
            
            $ComprasFormato['IdCompra'] = $Listado->IdCompra;
            $ComprasFormato['IdSucursal'] = $Listado->IdSucursal;
            $ComprasFormato['IdUsuario'] = $Listado->IdUsuario;
            $ComprasFormato['DecSucursal'] = $Listado->DecSucursal->NombreSucursal;
            $ComprasFormato['DecUser'] = $Listado->DecUser[0]->email;
            $ComprasFormato['FechaCompra'] = date_format(new DateTime($Listado->FechaCompra), "d-M-Y");
            $ComprasFormato['TotalProductos'] = $Listado->TotalProductos;
            $ComprasFormato['TotalCompra'] = $Listado->TotalCompra;
            $ComprasFormato['Estado'] = $Listado->Estado;
            $ComprasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;


            array_push($ComprasNew, $ComprasFormato);
            
        }
        return response()->json($ComprasNew ,200);
    }


    // -------------------------------------------------------------------------------------------------------
    // Detalle Compra

    public function VerDetalleCompra(Request $request){
        $DetalleCompra = DetalleCompra::where('IdCompra','=', $request->IdCompra)->get();
        $DetalleCompraFormat = array();
        $DetalleNew = [];

        foreach($DetalleCompra as $Listado){
            $DetalleCompraFormat['IdDetalleCompra'] = $Listado->IdDetalleCompra;
            $DetalleCompraFormat['IdCompra'] = $Listado->IdCompra;
            // $DetalleCompraFormat['Usuario'] = $Listado->Compra->DecUser[0]->email;
            $DetalleCompraFormat['Empleado'] = $Listado->Compra->DecUser[0]->DecEmpleado[0]->Nombre;
            $DetalleCompraFormat['FechaCompra'] =  date_format(new DateTime($Listado->Compra->FechaCompra), "d-M-Y");
            $DetalleCompraFormat['TotalCompra'] = $Listado->Compra->TotalCompra;
            
            $DetalleCompraFormat['TotalProductos'] = $Listado->Compra->TotalProductos;
            $DetalleCompraFormat['NombreSucursal'] = $Listado->Compra->DecSucursal->NombreSucursal;
            $DetalleCompraFormat['Direccion'] = $Listado->Compra->DecSucursal->Direccion;
            // DetalleCompta
            $DetalleCompraFormat['IdProducto'] = $Listado->IdProducto;
            $DetalleCompraFormat['SubTotalCompra'] = $Listado->SubTotalCompra;
            $DetalleCompraFormat['SubTotalProduc'] = $Listado->SubTotalProduc;
            $DetalleCompraFormat['NombreProducto'] = $Listado->Productos[0]->NombreProducto;
            $DetalleCompraFormat['NombreProveedor'] = $Listado->Productos[0]->Proveedor->NombreProveedor;
            
            array_push($DetalleNew, $DetalleCompraFormat);
        }
        return response()->json($DetalleNew, 200);
    }

    public function UltimasComprasMes(Request $request){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('m');
        $Compras = Compras::whereMonth('FechaCompra', '>=', $Fecha)->where('IdSucursal','=', $request->IdSucursal)->get();
        $TotlaCompras = 0;
        for ($i=0; $i < count($Compras) ; $i++) { 
            $TotlaCompras = $TotlaCompras + $Compras[$i]->TotalCompra;
        }
        return response()->json($TotlaCompras, 200);
    }    


}