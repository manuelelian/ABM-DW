<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\ProductosModel;

class ProductosController extends Controller
{

	// Constructor
	public function __construct()
	{
		self::$sessionStatus = SessionController::sessionVerificacion();
	}

	public function actionIndex($var = null)
	{
		SessionController::onlyLogin();		
		$productos = ProductosModel::traer_productos();
		$sin_stock = ProductosModel::traer_sin_stock();
		$stock_critico = ProductosModel::traer_stock_critico();
		// var_dump($productos);

		static::path();
		$nombre_de_archivoDeVista = 'productos';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta" => self::$path,
            "productos"=>$productos,
            "sin_stock"=>$sin_stock,
            "stock_critico"=>$stock_critico,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}

	public function actioneditar_producto($id_producto)
	{
		SessionController::onlyLogin();		
		$error = false;
        $mensajeOk = '';
        $mensajeNoOk = '';
        $productos = ProductosModel::traer_productos_x_id($id_producto);

        $error_msg = array(
        	'cod_barras' => '',
        	'producto' => '',
        	'categoria' => '',
        	'marca' => '',
        	'precio_costo' => '',
        	'precio_venta' => '',
        	'unidad' => '',
        	'stock_actual' => '',
        	'stock_minimo' => ''     	
        );

        $datos['id_producto'] = $id_producto;
        $datos['cod_barras'] = $productos[0]->codigo_barras;
        $datos['producto'] = $productos[0]->nombre;
        $datos['categoria'] = $productos[0]->categoria;
        $datos['marca'] = $productos[0]->marca_producto;
        $datos['precio_costo'] = $productos[0]->precio_costo;
        $datos['precio_venta'] = $productos[0]->precio_venta;
        $datos['unidad'] = $productos[0]->unidad_medida;
        $datos['stock_actual'] = $productos[0]->stock_actual;
        $datos['stock_minimo'] = $productos[0]->stock_minimo;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	$datos['cod_barras'] = $_POST['cod_barras'];
        	$datos['producto'] = $_POST['producto'];
        	$datos['categoria'] = $_POST['categoria'];
        	$datos['marca'] = $_POST['marca'];
        	$datos['precio_costo'] = $_POST['precio_costo'];
        	$datos['precio_venta'] = $_POST['precio_venta'];
        	$datos['unidad'] = $_POST['unidad'];
        	$datos['stock_actual'] = $_POST['stock_actual'];
        	$datos['stock_minimo'] = $_POST['stock_minimo'];

        	$validacionProducto = UserController::checkEmpty($datos['producto'], 'nombre producto');
            if ($validacionProducto !== true) {
                $error_msg['producto'] = $validacionProducto;
                $error = true;
            }

            $validacionPrecioCompra = UserController::checkEmpty($datos['precio_costo'], 'precio compra');
            if ($validacionPrecioCompra !== true) {
                $error_msg['precio_costo'] = $validacionPrecioCompra;
                $error = true;
            }

            $validacionPrecioVenta = UserController::checkEmpty($datos['precio_venta'], 'precio venta');
            if ($validacionPrecioVenta !== true) {
                $error_msg['precio_venta'] = $validacionPrecioVenta;
                $error = true;
            }

            $validacionStockMin = UserController::checkEmpty($datos['stock_minimo'], 'stock minimo');
            if ($validacionStockMin !== true) {
                $error_msg['stock_minimo'] = $validacionStockMin;
                $error = true;
            }

            $validacionStockAct = UserController::checkEmpty($datos['stock_actual'], 'stock actual');
            if ($validacionStockAct !== true) {
                $error_msg['stock_actual'] = $validacionStockAct;
                $error = true;
            }

            if ($error !== true) {
                $editarProducto = ProductosModel::actualizar_producto($datos);
                if ($editarProducto === true) {
                    $mensajeOk = 'Producto editado con éxito!';
                } else {
                    $mensajeNoOk = 'Error editando producto';
                }
            }

        }

		static::path();
		$nombre_de_archivoDeVista = 'editar_producto';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta" => self::$path,
            "datos"=>$datos,
            "error_msg" => $error_msg,
            "error" => $error,
            "mensajeOk" => $mensajeOk,
            "mensajeNoOk" => $mensajeNoOk,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}

	public function actionagregar_producto()
	{
		SessionController::onlyLogin();		
		$error = false;
        $mensajeOk = '';
        $mensajeNoOk = '';

        $error_msg = array(
        	'cod_barras' => '',
        	'producto' => '',
        	'categoria' => '',
        	'marca' => '',
        	'precio_costo' => '',
        	'precio_venta' => '',
        	'unidad' => '',
        	'stock_actual' => '',
        	'stock_minimo' => ''     	
        );

        $datos['cod_barras'] = '';
        $datos['producto'] = '';
        $datos['categoria'] = '';
        $datos['marca'] = '';
        $datos['precio_costo'] = '';
        $datos['precio_venta'] = '';
        $datos['unidad'] = '';
        $datos['stock_actual'] = '0';
        $datos['stock_minimo'] = '5';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	$datos['cod_barras'] = $_POST['cod_barras'];
        	$datos['producto'] = $_POST['producto'];
        	$datos['categoria'] = $_POST['categoria'];
        	$datos['marca'] = $_POST['marca'];
        	$datos['precio_costo'] = $_POST['precio_costo'];
        	$datos['precio_venta'] = $_POST['precio_venta'];
        	$datos['unidad'] = $_POST['unidad'];
        	$datos['stock_actual'] = $_POST['stock_actual'];
        	$datos['stock_minimo'] = $_POST['stock_minimo'];

        	$validacionProducto = UserController::checkEmpty($datos['producto'], 'nombre producto');
            if ($validacionProducto !== true) {
                $error_msg['producto'] = $validacionProducto;
                $error = true;
            }

            $validacionPrecioCompra = UserController::checkEmpty($datos['precio_costo'], 'precio compra');
            if ($validacionPrecioCompra !== true) {
                $error_msg['precio_costo'] = $validacionPrecioCompra;
                $error = true;
            }

            $validacionPrecioVenta = UserController::checkEmpty($datos['precio_venta'], 'precio venta');
            if ($validacionPrecioVenta !== true) {
                $error_msg['precio_venta'] = $validacionPrecioVenta;
                $error = true;
            }

            $validacionStockMin = UserController::checkEmpty($datos['stock_minimo'], 'stock minimo');
            if ($validacionStockMin !== true) {
                $error_msg['stock_minimo'] = $validacionStockMin;
                $error = true;
            }

            $validacionStockAct = UserController::checkEmpty($datos['stock_actual'], 'stock actual');
            if ($validacionStockAct !== true) {
                $error_msg['stock_actual'] = $validacionStockAct;
                $error = true;
            }

            if ($error !== true) {
                $editarProducto = ProductosModel::guardar_producto($datos);
                if ($editarProducto === true) {
                    $mensajeOk = 'Producto agregado con éxito!';
                } else {
                    $mensajeNoOk = 'Error agregando producto';
                }
            }

        }

		static::path();
		$nombre_de_archivoDeVista = 'agregar_producto';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta" => self::$path,
            "datos"=>$datos,
            "error_msg" => $error_msg,
            "error" => $error,
            "mensajeOk" => $mensajeOk,
            "mensajeNoOk" => $mensajeNoOk,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}

	public function actioneliminar_producto($id_producto)
	{
		SessionController::onlyLogin();
		$productos = ProductosModel::traer_productos_x_id($id_producto);

		$eliminar_producto = ProductosModel::eliminar_producto($id_producto);		

		static::path();
		$nombre_de_archivoDeVista = 'eliminar_producto';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta" => self::$path,
            "producto"=>$productos,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}

    public function actionagregar_producto_lista()
    {    
        $producto = ProductosModel::traer_productos_x_id($_POST['id_producto']);

        $idProducto_para_agregar = $_POST['id_producto'];

        $_SESSION['productos_ventas'][$idProducto_para_agregar]['id'] = $idProducto_para_agregar;
        $_SESSION['productos_ventas'][$idProducto_para_agregar]['nombre'] = $producto[0]->nombre;
        $_SESSION['productos_ventas'][$idProducto_para_agregar]['codigo'] = $producto[0]->codigo_barras;
        $_SESSION['productos_ventas'][$idProducto_para_agregar]['cantidad'] = $_POST['cantidad'];
        $_SESSION['productos_ventas'][$idProducto_para_agregar]['precio'] = $producto[0]->precio_venta;
        $_SESSION['productos_ventas'][$idProducto_para_agregar]['subtotal'] = $_POST['cantidad'] * $producto[0]->precio_venta;

        $resultado['status'] = true;

        echo json_encode($resultado);
    }

    public static function actionlistar_productos(){
        $listaProductos = '';
        $total = 0;
        if (isset($_SESSION['productos_ventas'])) {
            if (count($_SESSION['productos_ventas'])) {
                foreach ($_SESSION['productos_ventas'] as $id => $datos) {
                    $total += $datos['subtotal'];
                    $listaProductos .= '
                        <tr>
                            <td class="ps-3 fw-medium text-dark">
                              ' . $datos['nombre'] . '
                              <div class="small text-muted font-monospace">' . $datos['codigo'] . '</div>
                            </td>
                            <td class="text-center">
                              <span class="badge bg-light text-dark border px-2 py-1 font-monospace fw-bold">
                                '.$datos['cantidad'].'
                              </span>
                            </td>
                            <td class="text-end font-monospace text-secondary">$'.number_format($datos['precio'],2,',','.').'</td>
                            <td class="text-end font-monospace fw-bold text-dark">$'.number_format($datos['subtotal'],2,',','.').'</td>
                            <td class="pe-3 text-center">
                              <button type="button" class="btn btn-outline-danger btn-sm rounded-3 px-2 py-1" title="Eliminar ítem" onclick="eliminar_de_lista(\''.$id.'\')">
                                <i class="fa-solid fa-trash-can"></i>
                              </button>
                            </td>
                      </tr>';
                }

            }
        }

        $array['productos_lista'] = $listaProductos;
        $_SESSION['total_final'] = $total;
        $array['total'] = '$' .number_format($total, 2, ',', '.');
        echo json_encode($array);
    }

    public function actioneliminar_lista(){
        // $_SESSION['sub_compra']['productos']
        $idProducto_para_eliminar = $_POST['id_producto'];

        unset($_SESSION['productos_ventas'][$idProducto_para_eliminar]);

        $resultado['status'] = true;

        echo json_encode($resultado);
    }

}