<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TipoProducto;
class TipoProductoController extends Controller
{
    // TipoProducto
        // Listado Tipo Productos
        public function ListarTiposProductos(){
            $TipoProductos = TipoProducto::where('Estado', '=', 1)->get();
            $CategoriaFormato = array();
            $CategoriaNew = [];
            foreach($TipoProductos as $Listado){
                $CategoriaFormato['IdTipoProducto'] = $Listado->IdTipoProducto;
                $CategoriaFormato['Descripcion'] = $Listado->Descripcion;
                $CategoriaFormato['Estado'] = $Listado->Estado;
                $CategoriaFormato['DecEstado'] = $Listado->DecEstado->Descripcion;

                array_push($CategoriaNew,$CategoriaFormato);
            }
            return response()->json($CategoriaNew, 200);
        }
    public function CrearCategoria(Request $request){
        $TipoProducto = new TipoProducto();
        $TipoProducto->Descripcion = $request->NombreCategoria;
        $TipoProducto->Estado = 1;
        if($TipoProducto->save()){
            return response()->json($TipoProducto, 200);
        }
    }

    public function DesabilitarCategoria(Request $request){
        $Categoria = TipoProducto::find($request->IdCategoria);
        $Categoria->Estado = 2;
        if($Categoria->save()){
            return response()->json($Categoria, 200);
        }
    }
    public function HabilitarCategoria(Request $request){
        $Categoria = TipoProducto::find($request->IdCategoria);
        $Categoria->Estado = 1;
        if($Categoria->save()){
            return response()->json($Categoria, 200);
        }
    }
    

    // Filtro 
    public function BuscadorGeneral(Request $request){
        $TipoProductos = TipoProducto::where('Descripcion','LIKE', "%{$request->Data}%")->get();
        $CategoriaFormato = array();
        $CategoriaNew = [];
        foreach($TipoProductos as $Listado){
            $CategoriaFormato['IdTipoProducto'] = $Listado->IdTipoProducto;
            $CategoriaFormato['Descripcion'] = $Listado->Descripcion;
            $CategoriaFormato['Estado'] = $Listado->Estado;
            $CategoriaFormato['DecEstado'] = $Listado->DecEstado->Descripcion;

            array_push($CategoriaNew,$CategoriaFormato);
        }
        return response()->json($CategoriaNew, 200);
    }
    public function BuscarTipoProductoId(Request $request){
        $TipoProducto = TipoProducto::find($request->IdTipo);
        return response()->json($TipoProducto, 200);
    }
    public function EditarCategoria(Request $request){
        $TipoProducto = TipoProducto::find($request->IdCategoria);
        $TipoProducto->Descripcion = $request->NombreCategoria;
        if($TipoProducto->save()){
            return response()->json($TipoProducto, 200);
        }
    }    

    public function FiltradoEstados(Request $request){
        $TipoProductos = TipoProducto::where('Estado','=', $request->Data)->get();
        $CategoriaFormato = array();
        $CategoriaNew = [];
        foreach($TipoProductos as $Listado){
            $CategoriaFormato['IdTipoProducto'] = $Listado->IdTipoProducto;
            $CategoriaFormato['Descripcion'] = $Listado->Descripcion;
            $CategoriaFormato['Estado'] = $Listado->Estado;
            $CategoriaFormato['DecEstado'] = $Listado->DecEstado->Descripcion;

            array_push($CategoriaNew,$CategoriaFormato);
        }
        return response()->json($CategoriaNew, 200);
    }
}
