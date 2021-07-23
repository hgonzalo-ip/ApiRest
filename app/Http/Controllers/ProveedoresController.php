<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedores;
class ProveedoresController extends Controller
{
        // Listar Proveedores------------------------
        public function ListarProveedor(Request $request){
            $Proveedores = Proveedores::all();
            $ProveedoresFormateado = array();
            $ProveedorNuevo = [];
            foreach($Proveedores as $Listado){
                $ProveedoresFormateado['IdProveedor'] = $Listado->IdProveedor;
                $ProveedoresFormateado['NombreProveedor'] = $Listado->NombreProveedor;
                $ProveedoresFormateado['Direccion'] = $Listado->Direccion;
                $ProveedoresFormateado['Telefono'] = $Listado->Telefono;
                $ProveedoresFormateado['EstadoNum'] = $Listado->Estado;
                $ProveedoresFormateado['EstadoDesc'] = $Listado->DescEstado->Descripcion;
                array_push($ProveedorNuevo, $ProveedoresFormateado);
            }
            return response()->json($ProveedorNuevo,200);
        }
        // CrearProveedor ------------------------------------
    public function CrearProveedor(Request $request){
        $request->validate([            
            'NombreProveedor' => 'required|string',
            'Direccion' => 'required|string',
            'Telefono' => 'required|numeric'            
        ]);
        $Proveedores = Proveedores::create([
            'NombreProveedor' => $request->NombreProveedor,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'Estado' => 1 
        ]);
        return response()->json($Proveedores,201);
    }
        // Editar Proveedor ---------------------------------------   
    public function EditarProveedor(Request $request){        
        $IdProveedor = $request->IdProveedor;
        $NombreProveedor = $request->NombreProveedor;
        $Direccion = $request->Direccion;
        $Telefono = $request->Telefono;
        
        $Proveedor = Proveedores::find($IdProveedor);
        $Proveedor->NombreProveedor = $NombreProveedor;
        $Proveedor->Direccion = $Direccion;
        $Proveedor->Telefono = $Telefono;
        if($Proveedor->save()){
            return response()->json([
                'message' => 'Proveedor Editado Correctamente',
                'Proveedor' => $Proveedor
            ],200);
        }
     
    }
    public function DesabilitarProveedor(Request $request){
        $IdProveedor = $request->IdProveedor;
        $Proveedor = Proveedores::find($IdProveedor);
        $Proveedor->Estado = 2;
        if($Proveedor->save()){
            return response()->json($Proveedor,200);
        }
    }
    // Habilitar 
    public function HabilitarProveedor(Request $request){
        $IdProveedor = $request->IdProveedor;
        $Proveedor = Proveedores::find($IdProveedor);
        $Proveedor->Estado = 1;
        if($Proveedor->save()){
            return response()->json($Proveedor,200);
        }
    }
    // Info Editar Proveedor
    public function InfoEditarProveedor(Request $request){
        $Proveedor = Proveedores::find($request->IdProveedor);   
        return response()->json($Proveedor,200);
    }
    public function EditarProoveedor(Request $request){
        $Proveedor = Proveedores::find($request->IdProveedorEdit);
        $Proveedor->NombreProveedor = $request->NombreEdit;
        $Proveedor->Direccion = $request->DireccionEdit;
        $Proveedor->Telefono = $request->TelefonoEdit;

        if($Proveedor->save()){
            return response()->json($Proveedor, 200);
        }
    }
    // Filtros 
    // Buscardor General
    public function BuscarProveedor(Request $request){
        $Info = $request->Datos;
        $Proveedores = Proveedores::where('NombreProveedor','LIKE', "%{$Info}%")
                                    ->orWhere('Direccion', 'LIKE', "%{$Info}%")
                                    ->orWhere('Telefono', 'LIKE', "%{$Info}%")->get();
        $ProveedoresFormateado = array();
        $ProveedorNuevo = [];
        foreach($Proveedores as $Listado){
            $ProveedoresFormateado['IdProveedor'] = $Listado->IdProveedor;
            $ProveedoresFormateado['NombreProveedor'] = $Listado->NombreProveedor;
            $ProveedoresFormateado['Direccion'] = $Listado->Direccion;
            $ProveedoresFormateado['Telefono'] = $Listado->Telefono;
            $ProveedoresFormateado['EstadoNum'] = $Listado->Estado;
            $ProveedoresFormateado['EstadoDesc'] = $Listado->DescEstado->Descripcion;
            array_push($ProveedorNuevo, $ProveedoresFormateado);
        }
        return response()->json($ProveedorNuevo,200);
    }
    public function BuscadorFiltroProvee(Request $request){
        $Estado = $request->Estado;
        if($Estado == 0){
            $Proveedores = Proveedores::all();
        }else{
            $Proveedores = Proveedores::where('Estado','=', $Estado)->get();
        }
        
        $ProveedoresFormateado = array();
        $ProveedorNuevo = [];
        foreach($Proveedores as $Listado){
        $ProveedoresFormateado['IdProveedor'] = $Listado->IdProveedor;
        $ProveedoresFormateado['NombreProveedor'] = $Listado->NombreProveedor;
        $ProveedoresFormateado['Direccion'] = $Listado->Direccion;
        $ProveedoresFormateado['Telefono'] = $Listado->Telefono;
        $ProveedoresFormateado['EstadoNum'] = $Listado->Estado;
        $ProveedoresFormateado['EstadoDesc'] = $Listado->DescEstado->Descripcion;
        array_push($ProveedorNuevo, $ProveedoresFormateado);
        }
        return response()->json($ProveedorNuevo,200);
    }            
}
