<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Models\TipoUsuario;
use App\Models\Empleados;
use App\Models\User;
use Image;

class EmpleadosController extends Controller
{
    public function ListTipoUsuario(){
        $TipoUsuario = TipoUsuario::where('Estado','=', '1')->get();
        return response()->json($TipoUsuario, 200);
    
    }
    // Crear Cliente Nuevo
    public function CrearEmpleado(Request $request){
        // Variables para crear el usuario 
        $IdTipoUsuario  = $request->SlTipoUser;
        $Correo = $request->Correo;
        $Pass = bcrypt($request->Pass);
        // Variables para crear el Empleado 
        $IdSucursal = $request->SltSucursal;
        $Nombre = $request->Nombres;
        $Apellido = $request->Apellidos;
        $Direccion = $request->Direccion;
        $Telefono = $request->Telefono;

        $User = new User();
        $User->IdTipoUsuario = $IdTipoUsuario;
        $User->email = $Correo;
        $User->password = $Pass;
        $User->Estado = 1;
        IF($User->save()){
            $IdUsuario = $User->IdUsuario;
            $Empleados = new Empleados();
            $Empleados->IdUsuario = $IdUsuario;
            $Empleados->IdSucursal = $IdSucursal;
            $Empleados->Nombre = $Nombre;
            $Empleados->Apellido = $Apellido;
            $Empleados->Direccion = $Direccion;
            $Empleados->Telefono = $Telefono;
            $Empleados->Estado = 1;

            if($Empleados->save()){
                return response()->Json($Empleados, 200);
            }
        }
        
    }
    // Lisatar Todos los Empleados
    public function ListarEmpleados(){
        $Empleados = Empleados::take(15)->get();
        $EmpleadoFormateado = array();

        $EmpleadoNuevo = [];

        foreach($Empleados as $Listado){
            $EmpleadoFormateado['IdEmpleado']= $Listado->IdEmpleado;
            $EmpleadoFormateado['IdUsuario']= $Listado->IdUsuario;
            $EmpleadoFormateado['NombreEmpleado']= $Listado->Nombre;
            $EmpleadoFormateado['Apellido']= $Listado->Apellido;
            $EmpleadoFormateado['Direccion']= $Listado->Direccion;
            $EmpleadoFormateado['Telefono']= $Listado->Telefono;
            $EmpleadoFormateado['Foto']= $Listado->Foto;
            $EmpleadoFormateado['DecUsuario']= $Listado->DecUsuario->email;
            $EmpleadoFormateado['NombreSucursal']= $Listado->Sucursal->NombreSucursal;
            $EmpleadoFormateado['Estado'] = $Listado->Estado;
            $EmpleadoFormateado['DescEstado'] = $Listado->DescEstado->Descripcion;
            

            array_push($EmpleadoNuevo, $EmpleadoFormateado);
        }
        return response()->json($EmpleadoNuevo, 200);
    }
    // Desabilitar Empleado 
    public function DesabilitarEmpleado(Request $request){
        $IdEmpleado = $request->IdEmpleado;
        $Empleado = Empleados::find($IdEmpleado);
        $Empleado->Estado = 2;

        if($Empleado->save()){
            return response()->json($Empleado,200);
        }
    }
    // Habilitar Empleado 
    public function HabilitarEmpleado(Request $request){
        $IdEmpleado = $request->IdEmpleado;
        $Empleado = Empleados::find($IdEmpleado);
        $Empleado->Estado = 1;

        if($Empleado->save()){
            return response()->json($Empleado,200);
        }
    }
    
    // Buscar Empleado 
    public function BuscarEmpleado(Request $request){        
        $InfoEmpelado = $request->DataBuscador;
        
        $Empleado = Empleados::orwhere('Nombre', 'LIKE', "%{$InfoEmpelado}%")
                                ->orWhere('Apellido','LIKE', "%{$InfoEmpelado}%")
                                ->orWhere('Telefono','LIKE', "%{$InfoEmpelado}%")
                                ->get();
        $EmpleadoFormateadoBusca = array();

        $EmpleadoNuevoBusca = [];

        foreach($Empleado as $ListadoBuscar){
            $EmpleadoFormateadoBusca['IdEmpleado']= $ListadoBuscar->IdEmpleado;
            $EmpleadoFormateadoBusca['NombreEmpleado']= $ListadoBuscar->Nombre;
            $EmpleadoFormateadoBusca['Apellido']= $ListadoBuscar->Apellido;
            $EmpleadoFormateadoBusca['Direccion']= $ListadoBuscar->Direccion;
            $EmpleadoFormateadoBusca['Telefono']= $ListadoBuscar->Telefono;
            $EmpleadoFormateadoBusca['Foto']= $ListadoBuscar->Foto;
            $EmpleadoFormateadoBusca['DecUsuario']= $ListadoBuscar->DecUsuario->email;
            $EmpleadoFormateadoBusca['NombreSucursal']= $ListadoBuscar->Sucursal->NombreSucursal;
            $EmpleadoFormateadoBusca['Estado'] = $ListadoBuscar->Estado;
            $EmpleadoFormateadoBusca['DescEstado'] = $ListadoBuscar->DescEstado->Descripcion;
            array_push($EmpleadoNuevoBusca, $EmpleadoFormateadoBusca);
        }
        return response()->json($EmpleadoNuevoBusca, 200);
    }
    // Listado Editar 
    public function ListEmpleadoEdit(Request $request){
        $IdEmpleado =  $request->IdEmpleado;
  
        $Empleado = Empleados::where('IdEmpleado','=',$IdEmpleado)->get();
       
        return response()->json($Empleado, 200);
    }


// Editar
    // Info para Editar
    public function EditarEmpleado(Request $request){
        $Empleado = Empleados::find($request->IdEmpleado);
        $Empleado->IdSucursal = $request->IdSucursal;
        $Empleado->Nombre = $request->NombreEmpleado;
        $Empleado->Apellido = $request->Apellido;
        $Empleado->Direccion = $request->Direccion;
        $Empleado->Telefono = $request->Telefono;
        if($Empleado->save()){
            return response()->json($Empleado, 200);
        }        
    }

//Filtros 
    // Filtro por sucursales (Empleaddos)
    public function FiltroPorSucursal(Request $request){
       
        if($request->IdSucursal == 0){
            $Empleado = Empleados::take(15)->get();
        }else{
            $Empleado = Empleados::where('IdSucursal','=', $request->IdSucursal)->get();
        }
        $EmpleadoFormateado = array();

        $EmpleadoNuevo = [];

        foreach($Empleado as $Listado){
            $EmpleadoFormateado['IdEmpleado']= $Listado->IdEmpleado;
            $EmpleadoFormateado['IdUsuario']= $Listado->IdUsuario;
            $EmpleadoFormateado['NombreEmpleado']= $Listado->Nombre;
            $EmpleadoFormateado['Apellido']= $Listado->Apellido;
            $EmpleadoFormateado['Direccion']= $Listado->Direccion;
            $EmpleadoFormateado['Telefono']= $Listado->Telefono;
            $EmpleadoFormateado['Foto']= $Listado->Foto;
            $EmpleadoFormateado['DecUsuario']= $Listado->DecUsuario->email;
            $EmpleadoFormateado['NombreSucursal']= $Listado->Sucursal->NombreSucursal;
            $EmpleadoFormateado['Estado'] = $Listado->Estado;
            $EmpleadoFormateado['DescEstado'] = $Listado->DescEstado->Descripcion;
            

            array_push($EmpleadoNuevo, $EmpleadoFormateado);
        }
        return response()->json($EmpleadoNuevo, 201);
        
    }
    // USUARIOS----------------------------------------------------------------------------
    public function InfoEditUsuario(Request $request){
        $Usuario = User::find($request->IdUsuario);         
        return response()->json($Usuario, 200);        
    }
    public function EditarUsuario(Request $request){
        $Usuario = User::find($request->IdUsuario);         
        if($request->PasswordNew == "" || $request->PasswordNew == null){
            $Usuario->IdTipoUsuario = $request->IdTipoUsuario;
            $Usuario->email = $request->Correo;
        }else{
           
            $Usuario->IdTipoUsuario = $request->IdTipoUsuario;
            $Usuario->email = $request->Correo;
            $Usuario->password = bcrypt($request->PasswordNew);
        }

        if($Usuario->save()){
            return response()->json($Usuario, 200);
        }
    }
    // Subir Imagen 
    public function SubirFotoEmpleado(Request $request, $IdEmpleado){
       $Foto = $request->file('Foto');
       $NombreImg = uniqid().'.'.$Foto->extension();

       $Empleado = Empleados::find($IdEmpleado);
       $Empleado->Foto = $NombreImg;

       $Ruta = Storage_path().'\app\Img/Empleados/'.$NombreImg;

       Image::make($Foto)->resize(null, 125, function ($constraint) {
           $constraint->aspectRatio();
       })->save($Ruta);


       if(  $Empleado->save()){
           return response()->json($NombreImg, 200);
       }
    }

    public function VerImgEmpleado($NombreImg){
        $File = Storage::disk('ImagenesEmpleados')->get($NombreImg);
        return new Response($File, 200);
      
    }
}
