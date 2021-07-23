<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\DetalleCita;
use Carbon\Carbon;
use Datetime;
use PDF;
class CitasController extends Controller
{
    public function ListarCitasDelDia(){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d');        
        $Citas = Citas::where('FechaCita','=', $Fecha)->get();

        $CitasFormato = array();
        $CitasNew = [];
        foreach($Citas as $Listado){
            $CitasFormato['IdCita'] = $Listado->IdCita;
            $CitasFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $CitasFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $CitasFormato['IdSucursal'] = $Listado->IdSucursal;
            $CitasFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $CitasFormato['IdUsuario'] = $Listado->IdUsuario;
            $CitasFormato['DecUser'] = $Listado->User->email;         
            $CitasFormato['FechaCita'] = date_format(new Datetime($Listado->FechaCita), 'd-M-Y');
            $CitasFormato['FechaFinCita'] = date_format(new Datetime($Listado->FechaFinCita), 'd-m-y H:i');                
            $CitasFormato['Hora'] = date_format(new Datetime($Listado->Hora), 'H:i');
            $CitasFormato['DescripcionCita'] = $Listado->DescripcionCita;
            $CitasFormato['TotalServicios'] = $Listado->TotalServicio;
            $CitasFormato['TotalCita'] = $Listado->TotalCita;
            $CitasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $CitasFormato['Estado'] = $Listado->Estado;

            array_push($CitasNew, $CitasFormato);
        }


        return response($CitasNew, 200);
    }

    public function ListarCitasIdSucursal(Request $request){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d');        
        $Citas = Citas::where('FechaCita','=', $Fecha)
                        ->where('IdSucursal','=', $request->IdSucursal)->get();

        $CitasFormato = array();
        $CitasNew = [];
        foreach($Citas as $Listado){
            $CitasFormato['IdCita'] = $Listado->IdCita;
            $CitasFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $CitasFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $CitasFormato['IdSucursal'] = $Listado->IdSucursal;
            $CitasFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $CitasFormato['IdUsuario'] = $Listado->IdUsuario;
            $CitasFormato['DecUser'] = $Listado->User->email;         
            $CitasFormato['FechaCita'] = date_format(new Datetime($Listado->FechaCita), 'd-M-Y');
            $CitasFormato['Hora'] = date_format(new Datetime($Listado->Hora), 'H:i');
            $CitasFormato['DescripcionCita'] = $Listado->DescripcionCita;
            $CitasFormato['TotalServicios'] = $Listado->TotalServicio;
            $CitasFormato['TotalCita'] = $Listado->TotalCita;
            $CitasFormato['FechaFinCita'] = date_format(new Datetime($Listado->FechaFinCita), 'd-m-y H:i');     
            $CitasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $CitasFormato['Estado'] = $Listado->Estado;

            array_push($CitasNew, $CitasFormato);
        }
        return response($CitasNew, 200);
    }
    public function ListarCitasPorEstados(Request $request){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d');        
        if($request->IdSucursal == "null"){
            $Citas = Citas::where('FechaCita','=', $Fecha)
            ->where('Estado','=', $request->Estado)->get();
           
        }else{
            $Citas = Citas::where('FechaCita','=', $Fecha)
            ->where('IdSucursal', '=', $request->IdSucursal)
            ->where('Estado','=', $request->Estado)->get();
        }
        $CitasFormato = array();
        $CitasNew = [];
        foreach($Citas as $Listado){
            $CitasFormato['IdCita'] = $Listado->IdCita;
            $CitasFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $CitasFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $CitasFormato['IdSucursal'] = $Listado->IdSucursal;
            $CitasFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $CitasFormato['IdUsuario'] = $Listado->IdUsuario;
            $CitasFormato['DecUser'] = $Listado->User->email;      
            $CitasFormato['FechaFinCita'] = date_format(new Datetime($Listado->FechaFinCita), 'd-m-y H:i');       
            $CitasFormato['FechaCita'] = date_format(new Datetime($Listado->FechaCita), 'd-M-Y');
            $CitasFormato['Hora'] = date_format(new Datetime($Listado->Hora), 'H:i');
            $CitasFormato['DescripcionCita'] = $Listado->DescripcionCita;
            $CitasFormato['TotalServicios'] = $Listado->TotalServicio;
            $CitasFormato['TotalCita'] = $Listado->TotalCita;
            $CitasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $CitasFormato['Estado'] = $Listado->Estado;

            array_push($CitasNew, $CitasFormato);
        }
        return response($CitasNew, 200);
    }
    public function ListarCitasPorFecha(Request $request){
         
   
        if($request->Estado == "null"){
            $Citas = Citas::where('FechaCita','LIKE', "%{$request->FechaCita}%")
                            ->where('IdSucursal','=', $request->IdSucursal)->get();    
        }
        else{
            $Citas = Citas::where('FechaCita','LIKE', "%{$request->FechaCita}%")
            ->where('IdSucursal','=', $request->IdSucursal)->where('Estado', '=', $request->Estado)->get(); 
        }
        $CitasFormato = array();
        $CitasNew = [];
        foreach($Citas as $Listado){
            $CitasFormato['IdCita'] = $Listado->IdCita;
            $CitasFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $CitasFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $CitasFormato['IdSucursal'] = $Listado->IdSucursal;
            $CitasFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $CitasFormato['IdUsuario'] = $Listado->IdUsuario;
            $CitasFormato['DecUser'] = $Listado->User->email;    
            $CitasFormato['FechaFinCita'] = date_format(new Datetime($Listado->FechaFinCita), 'd-m-y H:i');     
            $CitasFormato['FechaCita'] = date_format(new Datetime($Listado->FechaCita), 'd-M-Y');
            $CitasFormato['Hora'] = date_format(new Datetime($Listado->Hora), 'H:i');
            $CitasFormato['DescripcionCita'] = $Listado->DescripcionCita;
            $CitasFormato['TotalServicios'] = $Listado->TotalServicio;
            $CitasFormato['TotalCita'] = $Listado->TotalCita;
            $CitasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $CitasFormato['Estado'] = $Listado->Estado;

            array_push($CitasNew, $CitasFormato);
        }
        return response($CitasNew, 200);
    }

    public function ListarPorMes(Request $request){
        
        $Citas = Citas::where('FechaCita','LIKE', "%{$request->FechaMes}%")->get();
      
        $CitasFormato = array();
        $CitasNew = [];
        foreach($Citas as $Listado){
            $CitasFormato['IdCita'] = $Listado->IdCita;
            $CitasFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $CitasFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $CitasFormato['IdSucursal'] = $Listado->IdSucursal;
            $CitasFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $CitasFormato['IdUsuario'] = $Listado->IdUsuario;
            $CitasFormato['DecUser'] = $Listado->User->email;      
            $CitasFormato['FechaFinCita'] = date_format(new Datetime($Listado->FechaFinCita), 'd-m-y H:i');       
            $CitasFormato['FechaCita'] = date_format(new Datetime($Listado->FechaCita), 'd-M-Y');
            $CitasFormato['Hora'] = date_format(new Datetime($Listado->Hora), 'H:i');
            $CitasFormato['DescripcionCita'] = $Listado->DescripcionCita;
            $CitasFormato['TotalServicios'] = $Listado->TotalServicio;
            $CitasFormato['TotalCita'] = $Listado->TotalCita;
            $CitasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $CitasFormato['Estado'] = $Listado->Estado;

            array_push($CitasNew, $CitasFormato);
        }
        return response($CitasNew, 200);
    }
    public function GenerarCita(Request $request){
        // Tomar datos
        $IdCliente = $request->IdCliente;
        $IdUsuario = $request->IdUsuario;
        $IdSucursal = $request->IdSucursal;
        $FechaCita = $request->Fecha;
        $Hora = $request->Hora;
        $DescripcionCita = $request->DescripcionCita;
        // Detalle Cita
        $IdServicios = $request->IdServicios;
        $SubTotales = $request->SubTotales;
        

        $Cita = new Citas();
        $Cita->IdCliente = $IdCliente;
        $Cita->IdUsuario = $IdUsuario;
        $Cita->IdSucursal = $IdSucursal;
        $Cita->FechaCita = $FechaCita;
        $Cita->Hora = $Hora;
        $Cita->TotalServicio = count($IdServicios);
        $Cita->TotalCita = array_sum($SubTotales);
        $Cita->DescripcionCita = $DescripcionCita;
        $Cita->Estado = 5;
        if($Cita->save()){
            $IdCita = $Cita->IdCita;
            for($i = 0; $i<count($IdServicios); $i++){                
                $IdServicio = $IdServicios[$i];
                $SubTotal = $SubTotales[$i];

                $DetalleCita = new DetalleCita();
                $DetalleCita->IdCita = $IdCita;
                $DetalleCita->IdServicio = $IdServicio;
                $DetalleCita->SubTotal = $SubTotal;
                $DetalleCita->Estado = 5;
                $DetalleCita->save();
            }

            return response()->json($Cita, 200);
        }            
    }
    public function FinalizarCita(Request $request){

        $Cita = Citas::find($request->IdCita);
        $Cita->FechaFinCita =  Carbon::now('America/Guatemala');
        $Cita->Estado = 6;
        if($Cita->save()){
         return response()->json($Cita, 200);
        }
    }
    // Ver Detalle Cita
    public function VerDetalleCita(Request $request){
        $DetalleCita = DetalleCita::where('IdCita','=',$request->IdCita)->where('Estado','=', 5)->get();
        $DetalleFormato = array();
        $DetalleNew = [];
        foreach($DetalleCita as $Listado){

            $DetalleFormato['FechaCita'] = date_format(new Datetime($Listado->Citas->FechaCita), 'd-M-Y');
            $DetalleFormato['Hora'] = date_format(new Datetime($Listado->Citas->Hora), 'H:i');
            $DetalleFormato['IdDetalleCita']  = $Listado->IdDetalleCita;
            $DetalleFormato['IdCita']  = $Listado->Citas->IdCita;
            $DetalleFormato['Empleado']  = $Listado->Citas->User->DecEmpleado[0]->Nombre;
            $DetalleFormato['TotalCita'] =  $Listado->Citas->TotalCita;
            $DetalleFormato['NombreCliente'] = $Listado->Citas->Clientes->Nombres;
            $DetalleFormato['ApellidoCliente'] = $Listado->Citas->Clientes->Apellidos;
            $DetalleFormato['Sucursal'] = $Listado->Citas->Sucursal->NombreSucursal;
            $DetalleFormato['Direccion'] = $Listado->Citas->Sucursal->Direccion;
            $DetalleFormato['SubTotal'] = $Listado->SubTotal;
            
            $DetalleFormato['NombreServicio'] = $Listado->Servicios[0]->NombreServicio;
            array_push($DetalleNew, $DetalleFormato);
        }
        return response()->json($DetalleNew, 200);
    }
// Prueba de Pd 
    public function PDFCita(){
        $pdf = PDF::loadView('PDFCita');       
        return $pdf->stream('CitaSalonBerta.pdf');
    }


// FIn Prueba Pdf 
    public function InfoEditarCita(Request $request){
        $Cita = Citas::find($request->IdCita);
        return response()->json($Cita, 200);
    }
    public function EditarCita(Request $request){
        $Cita = Citas::find($request->IdCitaEdit);
        $Cita->FechaCita = $request->FechaEdit;
        $Cita->Hora = $request->HoraEdit;

        if($Cita->save()){
            return response()->json($Cita, 200);
        }
    }
    public function BuscarGeneralF(Request $request){           
        $Citas = Citas::where('FechaCita','LIKE', "%{$request->FechaMes}%")
                        ->where('IdCliente', '=',$request->IdCliente)->get();      
        $CitasFormato = array();
        $CitasNew = [];
        foreach($Citas as $Listado){
            $CitasFormato['IdCita'] = $Listado->IdCita;
            $CitasFormato['NombreCliente'] = $Listado->Clientes->Nombres;
            $CitasFormato['ApellidoCliente'] = $Listado->Clientes->Apellidos;
            $CitasFormato['IdSucursal'] = $Listado->IdSucursal;
            $CitasFormato['Sucursal'] = $Listado->Sucursal->NombreSucursal;
            $CitasFormato['IdUsuario'] = $Listado->IdUsuario;
            $CitasFormato['DecUser'] = $Listado->User->email;      
            $CitasFormato['FechaFinCita'] = date_format(new Datetime($Listado->FechaFinCita), 'd-m-y H:i');       
            $CitasFormato['FechaCita'] = date_format(new Datetime($Listado->FechaCita), 'd-M-Y');
            $CitasFormato['Hora'] = date_format(new Datetime($Listado->Hora), 'H:i');
            $CitasFormato['DescripcionCita'] = $Listado->DescripcionCita;
            $CitasFormato['TotalServicios'] = $Listado->TotalServicio;
            $CitasFormato['TotalCita'] = $Listado->TotalCita;
            $CitasFormato['DecEstado'] = $Listado->DecEstado->Descripcion;
            $CitasFormato['Estado'] = $Listado->Estado;

            array_push($CitasNew, $CitasFormato);
        }
        return response($CitasNew, 200);
    }


    public function CitasPendienteDelDia(Request $request){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d'); 

        $Citas = Citas::where('FechaCita','=', $Fecha)->where('Estado','=', 5)->where('IdSucursal','=', $request->IdSucursal)->get();
        $TotalCitas = count($Citas);
        return response()->json($TotalCitas, 200);
    }
    public function CitasFinalizadasDelDia(Request $request){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d'); 

        $Citas = Citas::where('FechaCita','=', $Fecha)->where('Estado','=', 6)->where('IdSucursal','=', $request->IdSucursal)->get();
        $TotalCitas = count($Citas);
        return response()->json($TotalCitas, 200);
    }
}