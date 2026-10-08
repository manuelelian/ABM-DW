<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\ProductosModel;
use app\models\VentasModel;

class VentasController extends Controller
{

	// Constructor
	public function __construct()
	{
		self::$sessionStatus = SessionController::sessionVerificacion();
	}

	public function actionIndex($var = null)
	{
		SessionController::onlyLogin();		
		$ventas = VentasModel::traer_ventas();
		// var_dump($productos);

		static::path();
		$nombre_de_archivoDeVista = 'ventas';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta" => self::$path,
            "ventas"=>$ventas,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}

	public function actionnueva_venta()
	{
		SessionController::onlyLogin();
		$error = false;
        $mensajeOk = '';
        $mensajeNoOk = '';

        $productos = ProductosModel::traer_productos();

        $error_msg = array(
        	'cantidad' => '',
        	'productos'=>''    	
        );

        $datos['cliente'] = '';
        $datos['fp'] = '';
        $datos['cantidad'] = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	$datos['cliente'] = $_POST['cliente'];
        	$datos['fp'] = $_POST['fp'];

        	if (!isset($_SESSION['productos_ventas']) || empty($_SESSION['productos_ventas'])) {
        		$error_msg['productos'] = 'Tiene que haber minimo un producto cargado';
        		$error = true;
        	}

        	if ($error != true) {
        		$datos['total_final'] = $_SESSION['total_final'];
	            $guardar_venta = VentasModel::agregar_venta($datos, $_SESSION['productos_ventas'],$_SESSION['USER']['id_usuario']);
	            if ($guardar_venta['state'] === true) {
	                $mensajeOk = "Venta Agregada Correctamente";
	                unset($_SESSION['productos_ventas']);
	            } else {
	                $mensajeOkRep = "Error cargando la venta";
	            }
	        }
        }

		static::path();
		$nombre_de_archivoDeVista = 'nueva_venta';
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
            "productos"=>$productos,
            "js" => self::loadJS(["path" => self::$path], 'ventas'),
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}
}