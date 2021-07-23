<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;
class ClientesController extends Controller
{
    public function CrearClient(Request $request){
        // Tomar Variables
        $NombreCliente = $request->Nombres;
        $ApellidoCliente = $request->Apellidos;
        $Direccion = $request->Direccion;
        $Telefono = $request->Telefono;
    
         $Cliente = new Clientes();
         $Cliente->Nombres = $NombreCliente;
         $Cliente->Apellidos = $ApellidoCliente;
         $Cliente->Direccion = $Direccion;
         $Cliente->Telefono = $Telefono;
         $Cliente->Foto = "";
         $Cliente->Estado = 1;         
         if($Cliente->save()){
                return response()->json($Cliente, 200);
         }
    }
    public function ListarCliente(){
        $Cliente = Clientes::take(15)->get();
        $ClienteFormato = array ();
        $ClienteNuevo = [];

        foreach($Cliente as $Listado){
            $ClienteFormato['IdCliente'] = $Listado->IdCliente;
            $ClienteFormato['Nombres'] = $Listado->Nombres;
            $ClienteFormato['Apellidos'] = $Listado->Apellidos;
            $ClienteFormato['Direccion'] = $Listado->Direccion;
            $ClienteFormato['Telefono'] = $Listado->Telefono;
            $ClienteFormato['Foto'] = $Listado->Foto;
            $ClienteFormato['Estado'] = $Listado->Estado;
            $ClienteFormato['EstadoDec'] = $Listado->DescEstado->Descripcion;

            array_push($ClienteNuevo, $ClienteFormato);
        }

        return response()->json($ClienteNuevo, 200);
    }
    // Desabilitar Cliente 
    public function DesabilitarCliente(Request $request){
        $IdCliente = $request->IdCliente;
        $Cliente = Clientes::find($IdCliente);
        $Cliente->Estado = 2;
        if($Cliente->save()){
            return response()->json($Cliente, 200);
        }
    }
    // Habilitar Cliente
    public function HabilitarCliente(Request $request){
        $IdCliente = $request->IdCliente;
        $Cliente = Clientes::find($IdCliente);
        $Cliente->Estado = 1;
        if($Cliente->save()){
            return response()->json($Cliente, 200);
        }
    }
    // Buscardo 
    public function BuscarCliente(Request $request){
        $Data = $request->DataBuscador;
        $Cliente = Clientes::where('Nombres', 'LIKE', "%{$Data}%")
                            ->orWhere('Apellidos','LIKE', "%{$Data}%")
                            ->orWhere('Telefono','LIKE', "%{$Data}%")
                            ->orWhere('Direccion','LIKE', "%{$Data}%")
                            ->get();

        $ClienteFormato = array ();
        $ClienteNuevo = [];

        foreach($Cliente as $Listado){
            $ClienteFormato['IdCliente'] = $Listado->IdCliente;
            $ClienteFormato['Nombres'] = $Listado->Nombres;
            $ClienteFormato['Apellidos'] = $Listado->Apellidos;
            $ClienteFormato['Direccion'] = $Listado->Direccion;
            $ClienteFormato['Telefono'] = $Listado->Telefono;
            $ClienteFormato['Foto'] = $Listado->Foto;
            $ClienteFormato['Estado'] = $Listado->Estado;
            $ClienteFormato['EstadoDec'] = $Listado->DescEstado->Descripcion;

            array_push($ClienteNuevo, $ClienteFormato);
        }
        return response()->json($ClienteNuevo, 200);
    }
    public function BuscarClienteId(Request $request){
        
        $Cliente = Clientes::where('IdCliente', '=', $request->IdCliente)->get();

        return response()->json($Cliente, 200);
    }
    // Buscador Por Filtro
    public function BuscadorFiltro(Request $request){
        $EstadoFiltro = $request->Estado;
        if($EstadoFiltro != 0){
            $Cliente = Clientes::where('Estado', '=', $EstadoFiltro)->get();
        }else{
            $Cliente = Clientes::take(15)->get();
        }
        

        $ClienteFormato = array ();
        $ClienteNuevo = [];

            foreach($Cliente as $Listado){
                $ClienteFormato['IdCliente'] = $Listado->IdCliente;
                $ClienteFormato['Nombres'] = $Listado->Nombres;
                $ClienteFormato['Apellidos'] = $Listado->Apellidos;
                $ClienteFormato['Direccion'] = $Listado->Direccion;
                $ClienteFormato['Telefono'] = $Listado->Telefono;
                $ClienteFormato['Foto'] = $Listado->Foto;
                $ClienteFormato['Estado'] = $Listado->Estado;
                $ClienteFormato['EstadoDec'] = $Listado->DescEstado->Descripcion;

                array_push($ClienteNuevo, $ClienteFormato);
            }
        return response()->json($ClienteNuevo, 200);

    }
    public function InfoEditCliente(Request $request){
        $Cliente = Clientes::find($request->IdCliente);
        return response()->json($Cliente, 200);
    }
    public function EditarCliente(Request $request){
      
      $Cliente = Clientes::find($request->IdClienteEdit);
      $Cliente->Nombres = $request->NombreEdit;
      $Cliente->Apellidos = $request->ApellidoEdit;
      $Cliente->Direccion = $request->DireccionEdit;
      $Cliente->Telefono = $request->TelefonoEdit;

      if($Cliente->save()){
        return response()->json($Cliente, 200);
      }
      
    }

        // Subir Imagen 
        public function SubirFotoCliente(Request $request, $IdCliente){
            $Foto = $request->file('Foto');
            $NombreImg = uniqid().'.'.$Foto->extension();
     
            $Cliente = Clientes::find($IdCliente);
            $Cliente->Foto = $NombreImg;
     
            $Ruta = Storage_path().'\app\Img/Clientes/'.$NombreImg;
     
            Image::make($Foto)->resize(null, 125, function ($constraint) {
                $constraint->aspectRatio();
            })->save($Ruta);
     
     
            if($Cliente->save()){
                return response()->json($NombreImg, 200);
            }
         }
     
         public function VerImgCliente($NombreImg){
             $File = Storage::disk('ImagenesCliente')->get($NombreImg);
             return new Response($File, 200);
           
         }
}
