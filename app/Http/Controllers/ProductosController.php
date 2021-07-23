<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Productos;

use Image;

class ProductosController extends Controller
{
    

    // Productos
        // Crear Producto
        public function CrearProducto(Request $request){
            $Producto = new Productos();
            $Producto->IdTipoProducto =  $request->IdTipoP;
            $Producto->IdProveedor =  $request->IdProveedor;
            $Producto->IdSucursal =  $request->IdSucursal;
            $Producto->NombreProducto =  $request->Nombre;
            $Producto->PrecioCompra =  $request->PrecioCompra;
            $Producto->PrecioVenta =  $request->PrecioVenta;
            $Producto->DescripcionProduc =  $request->Desctipcion;
            $Producto->Stok =  0;
            $Producto->Estado =  1;
            if($Producto->save()){
                return response()->json($Producto, 200);
            }
        }
        public function ListadoProductos(Request $request){
            $Productos = Productos::where('Estado','=', 1)->get();
            $ProductosFomato = array();
            $ProductoNew = [];
            foreach($Productos as $Listado){
                $ProductosFomato['IdProducto'] =  $Listado->IdProducto;
                $ProductosFomato['IdTipoProducto'] =  $Listado->IdTipoProducto;
                $ProductosFomato['IdProveedor'] =  $Listado->IdProveedor;
                $ProductosFomato['IdSucursal'] =  $Listado->IdSucursal;
                $ProductosFomato['NombreProducto'] =  $Listado->NombreProducto;
                $ProductosFomato['PrecioCompra'] =  $Listado->PrecioCompra;
                $ProductosFomato['PrecioVenta'] =  $Listado->PrecioVenta;
                $ProductosFomato['DescripcionProduc'] =  $Listado->DescripcionProduc;
                $ProductosFomato['Stok'] =  $Listado->Stok;
                $ProductosFomato['Foto'] =  $Listado->Foto;
                $ProductosFomato['Estado'] =  $Listado->Estado;
                // Descripcion de los id 
                $ProductosFomato['DescripcionTipoProd'] =  $Listado->TipoProdcuto->Descripcion;
                $ProductosFomato['NombreSucursal'] =  $Listado->Sucursal->NombreSucursal;
                $ProductosFomato['NombreProveedor'] =  $Listado->Proveedor->NombreProveedor;
                $ProductosFomato['DescripcionEstado'] =  $Listado->DecEstado->Descripcion;

                array_push($ProductoNew, $ProductosFomato);
            }
            return response()->json($ProductoNew, 200);
        }        
        public function DesabilitarProducto(Request $request){
            $IdProducto = $request->IdProducto;
            $Producto =  Productos::find($IdProducto);
            $Producto->Estado = 2;
            if($Producto->save()){
                return response()->json($Producto, 200);
            }
        }
        public function HabilitarProducto(Request $request){
            $IdProducto = $request->IdProducto;
            $Producto =  Productos::find($IdProducto);
            $Producto->Estado = 1;
            if($Producto->save()){
                return response()->json($Producto, 200);
            }   
        }    
       
    // Filtros
        // Por Estados
        public function FiltroProducto(Request $request){
           $TipoFiltro = $request->TipoFiltro;
           $Dato = $request->Dato;
           if($TipoFiltro == 2){// 2 == Filtro por Estados Habilitado y Desabilitado
                $Producto = Productos::where("Estado", '=', $Dato)->get();
           }elseif($TipoFiltro == 3){//3 = Filtro por sucursales
            $Producto = Productos::where("IdSucursal", '=', $Dato)->get();
           }elseif($TipoFiltro == 4){// 4 = Filtro por Tipo Producto
            $Producto = Productos::where("IdTipoProducto", '=', $Dato)->get();
           }elseif($TipoFiltro == 5){//5 == Filtro Por Proveedor
            $Producto = Productos::where('IdProveedor','=', $Dato)->get();
           }

           $ProductosFomato = array();
           $ProductoNew = [];
           foreach($Producto as $Listado){
               $ProductosFomato['IdProducto'] =  $Listado->IdProducto;
               $ProductosFomato['IdTipoProducto'] =  $Listado->IdTipoProducto;
               $ProductosFomato['IdProveedor'] =  $Listado->IdProveedor;
               $ProductosFomato['IdSucursal'] =  $Listado->IdSucursal;
               $ProductosFomato['NombreProducto'] =  $Listado->NombreProducto;
               $ProductosFomato['PrecioCompra'] =  $Listado->PrecioCompra;
               $ProductosFomato['PrecioVenta'] =  $Listado->PrecioVenta;
               $ProductosFomato['DescripcionProduc'] =  $Listado->DescripcionProduc;
               $ProductosFomato['Stok'] =  $Listado->Stok;
               $ProductosFomato['Foto'] =  $Listado->Foto;
               $ProductosFomato['Estado'] =  $Listado->Estado;
               // Descripcion de los id 
               $ProductosFomato['DescripcionTipoProd'] =  $Listado->TipoProdcuto->Descripcion;
               $ProductosFomato['NombreSucursal'] =  $Listado->Sucursal->NombreSucursal;
               $ProductosFomato['NombreProveedor'] =  $Listado->Proveedor->NombreProveedor;
               $ProductosFomato['DescripcionEstado'] =  $Listado->DecEstado->Descripcion;

               array_push($ProductoNew, $ProductosFomato);
           }
           return response()->json($ProductoNew, 200);

        }
        // Buscador General
        public function BuscadorProducto(Request $request){
            $Info = $request->Datos;
            $Productos =  Productos::where('NombreProducto','LIKE', "%{$Info}%")->get();
            $ProductosFomato = array();
            $ProductoNew = [];
            foreach($Productos as $Listado){
                $ProductosFomato['IdProducto'] =  $Listado->IdProducto;
                $ProductosFomato['IdTipoProducto'] =  $Listado->IdTipoProducto;
                $ProductosFomato['IdProveedor'] =  $Listado->IdProveedor;
                $ProductosFomato['IdSucursal'] =  $Listado->IdSucursal;
                $ProductosFomato['NombreProducto'] =  $Listado->NombreProducto;
                $ProductosFomato['PrecioCompra'] =  $Listado->PrecioCompra;
                $ProductosFomato['PrecioVenta'] =  $Listado->PrecioVenta;
                $ProductosFomato['DescripcionProduc'] =  $Listado->DescripcionProduc;
                $ProductosFomato['Stok'] =  $Listado->Stok;
                $ProductosFomato['Foto'] =  $Listado->Foto;
                $ProductosFomato['Estado'] =  $Listado->Estado;
                // Descripcion de los id 
                $ProductosFomato['DescripcionTipoProd'] =  $Listado->TipoProdcuto->Descripcion;
                $ProductosFomato['NombreSucursal'] =  $Listado->Sucursal->NombreSucursal;
                $ProductosFomato['NombreProveedor'] =  $Listado->Proveedor->NombreProveedor;
                $ProductosFomato['DescripcionEstado'] =  $Listado->DecEstado->Descripcion;

                array_push($ProductoNew, $ProductosFomato);
            }
            return response()->json($ProductoNew, 200);
        }

        public function BuscarProductosConSucursal(Request $request){
            $Info = $request->Datos;
            $IdSucursal = $request->IdSucursal;
            $Productos =  Productos::where('NombreProducto','LIKE', "%{$Info}%")
                                    ->where('IdSucursal', '=', $IdSucursal)->get();
            $ProductosFomato = array();
            $ProductoNew = [];
            foreach($Productos as $Listado){
                $ProductosFomato['IdProducto'] =  $Listado->IdProducto;
                $ProductosFomato['IdTipoProducto'] =  $Listado->IdTipoProducto;
                $ProductosFomato['IdProveedor'] =  $Listado->IdProveedor;
                $ProductosFomato['IdSucursal'] =  $Listado->IdSucursal;
                $ProductosFomato['NombreProducto'] =  $Listado->NombreProducto;
                $ProductosFomato['PrecioCompra'] =  $Listado->PrecioCompra;
                $ProductosFomato['PrecioVenta'] =  $Listado->PrecioVenta;
                $ProductosFomato['DescripcionProduc'] =  $Listado->DescripcionProduc;
                $ProductosFomato['Stok'] =  $Listado->Stok;
                $ProductosFomato['Foto'] =  $Listado->Foto;
                $ProductosFomato['Estado'] =  $Listado->Estado;
                // Descripcion de los id 
                $ProductosFomato['DescripcionTipoProd'] =  $Listado->TipoProdcuto->Descripcion;
                $ProductosFomato['NombreSucursal'] =  $Listado->Sucursal->NombreSucursal;
                $ProductosFomato['NombreProveedor'] =  $Listado->Proveedor->NombreProveedor;
                $ProductosFomato['DescripcionEstado'] =  $Listado->DecEstado->Descripcion;

                array_push($ProductoNew, $ProductosFomato);
            }
            return response()->json($ProductoNew, 200);
        
        }
    //Editar 
        // InfoEdita
        public function InfoEditarProducto(Request $request){
            $IdProducto = $request->IdProducto;
           
            $Producto = Productos::find($IdProducto);
            return response()->json($Producto,200);
        }

        // Editar Información
        public function EditarProducto(Request $request){
           $Producto = Productos::find($request->IdProductoEdit);
           $Producto->IdTipoProducto = $request->SltTipoProductoEdit;
           $Producto->IdProveedor = $request->SltProveedorEdit;
           $Producto->IdSucursal = $request->SltSucursalEdit;
           $Producto->NombreProducto = $request->NombreProductoEdit;
           $Producto->PrecioCompra = $request->PrecioCompraEdit;
           $Producto->PrecioVenta = $request->PrecioVentaEdit;
           $Producto->DescripcionProduc = $request->DescripcionEdit;

            if($Producto->save()){
                return response()->json($Producto, 200);
            }
        }
    
    // Foto
        // Almacenar Foto 
        public function SubirFotoProducto(Request $request, $IdProducto){
            $Foto = $request->file('Foto');
            $NombreImg = uniqid().'.'.$Foto->extension();

            $Producto = Productos::find($IdProducto);
            $Producto->Foto = $NombreImg;

            $Ruta = Storage_path().'\app\Img\Productos/'.$NombreImg;

            Image::make($Foto)->resize(null, 125, function ($constraint) {
                $constraint->aspectRatio();
            })->save($Ruta);

            if($Producto->save()){
                return response()->json($NombreImg, 200);
            }
        }
        // Listar Fotos
        public function VerImgProducto($NombreImg){
            $File = Storage::disk('ImagenesProducto')->get($NombreImg);
            return new Response($File, 200);          
        }
        //Listar Producto Sin Foto
        public function VerImgSinFoto($ImgSinFoto){
            $File = Storage::disk('ImagenesSinFoto')->get($ImgSinFoto);
            return new Response($File, 200);     
        }
        // Listar Productos para Comprar 

        public function ListarProductosIdSucursal(Request $request){
            $Productos = Productos::where('IdSucursal','=', $request->IdSucursal)
                                    ->where('Estado','=', 1)
                                    ->get();
            $ProductosFomato = array();
            $ProductoNew = [];
            foreach($Productos as $Listado){
                $ProductosFomato['IdProducto'] =  $Listado->IdProducto;
                $ProductosFomato['IdTipoProducto'] =  $Listado->IdTipoProducto;
                $ProductosFomato['IdProveedor'] =  $Listado->IdProveedor;
                $ProductosFomato['IdSucursal'] =  $Listado->IdSucursal;
                $ProductosFomato['NombreProducto'] =  $Listado->NombreProducto;
                $ProductosFomato['PrecioCompra'] =  $Listado->PrecioCompra;
                $ProductosFomato['PrecioVenta'] =  $Listado->PrecioVenta;
                $ProductosFomato['DescripcionProduc'] =  $Listado->DescripcionProduc;
                $ProductosFomato['Stok'] =  $Listado->Stok;
                $ProductosFomato['Foto'] =  $Listado->Foto;
                $ProductosFomato['Estado'] =  $Listado->Estado;
                // Descripcion de los id 
                $ProductosFomato['DescripcionTipoProd'] =  $Listado->TipoProdcuto->Descripcion;
                $ProductosFomato['NombreSucursal'] =  $Listado->Sucursal->NombreSucursal;
                $ProductosFomato['NombreProveedor'] =  $Listado->Proveedor->NombreProveedor;
                $ProductosFomato['DescripcionEstado'] =  $Listado->DecEstado->Descripcion;

                array_push($ProductoNew, $ProductosFomato);
            }
            return response()->json($ProductoNew, 200);
        }
        
        // Agregar al carro
        public function BuscarProductoId(Request $request){
            $Productos = Productos::where('IdProducto','=', $request->IdProducto)
                                    ->where('Estado','=', 1)
                                    ->get();
         
            return response()->json($Productos, 200);
        }
}