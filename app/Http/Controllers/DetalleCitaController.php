<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleCita;
use App\Models\Citas;
class DetalleCitaController extends Controller
{
        public function EditarDetalleCita(Request $request){           
            $Total = array_sum($request->SubTotales);
            $TotalServicios = count($request->IdServicios);
            $DetalleCitaFind = DetalleCita::where('IdCita','=',$request->IdCita)->where('Estado','=', 7)->get();
            if(count($DetalleCitaFind) != 0){
                $DetalleCitas = DetalleCita::where('IdCita','=',$request->IdCita)->where('Estado','=', 7)->update(['Estado' => 5]);     
                
            }else{
            for ($i=0; $i < count($request->IdServicios) ; $i++) { 
                $IdServicio = $request->IdServicios[$i];
                $Subtotal = $request->SubTotales[$i];
                           
                    $DetalleCita = new DetalleCita();
                    $DetalleCita->IdCita = $request->IdCita;
                    $DetalleCita->IdServicio = $IdServicio;
                    $DetalleCita->SubTotal = $Subtotal;
                    $DetalleCita->Estado = 5;
                    $DetalleCita->save();
                }


            }
           
                $Cita = Citas::find($request->IdCita);
                $TotalCitaAntiguo = $Cita->TotalCita;
                $NuevoTotalCita = $Total + $TotalCitaAntiguo;
                $Cita->TotalCita = $NuevoTotalCita;
                // Actualizar Total Servicios
                $TotalServiciosAntiguo = $Cita->TotalServicio;
                $NuevoTotalServicios = $TotalServicios + $TotalServiciosAntiguo;
                $Cita->TotalServicio = $NuevoTotalServicios;
                if($Cita->save()){
                    return response()->json($TotalServicios, 200);
                }
            
        }
        public function EliminarServiciosCita(Request $request){
            $IdDetalleCitas = $request->IdDetalleCita;
            $IdCita = $request->IdCita;

            
            for ($i=0; $i<count($IdDetalleCitas) ; $i++) { 
                $IdDetalle = $IdDetalleCitas[$i];
                $DetalleCita = DetalleCita::where('IdDetalleCita','=',$IdDetalle)->update(['Estado' => 7]);                                
                       
            }
            $SubTotalDetalle = 0;
            $DetalleCitaEdit = DetalleCita::where('IdCita', '=', $IdCita)->where('Estado','=', 7)->get();
            for ($a=0; $a <count($DetalleCitaEdit) ; $a++) { 
                $Suma = $SubTotalDetalle +  $DetalleCitaEdit[$a]->SubTotal;
                $SubTotalDetalle = $Suma;
               
            }
            $Cita = Citas::find($IdCita);
            $TotalCitaAtiguo = $Cita->TotalCita;
            if($TotalCitaAtiguo > $SubTotalDetalle){
                $TotalCitaNuevo = $TotalCitaAtiguo -  $SubTotalDetalle;
            }else{
                $TotalCitaNuevo = $SubTotalDetalle - $TotalCitaAtiguo ;
            }
            
            $Cita->TotalCita = $TotalCitaNuevo;
            
            // Calcula Total Servicios
            $TotalServiciosAnti = $Cita->TotalServicio;
            $Cita->TotalServicio =  $TotalServiciosAnti - count($IdDetalleCitas);
            if($Cita->save()){
                return response()->json($Cita, 200);
            }
        }
}
