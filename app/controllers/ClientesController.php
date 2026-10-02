<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\ClientesModel;

class ClientesController extends Controller
{

	// Constructor (verificar si tenemos sesion activa)
	public function __construct()
	{
		self::$sessionStatus = SessionController::sessionVerificacion();
	}

	public function actionIndex($var = null)
	{
		SessionController::onlyUsers();		
		$clientes = ClientesModel::traer_clientes();
		// var_dump($productos);

		static::path();
		$nombre_de_archivoDeVista = 'clientes';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta" => self::$path,
            "clientes"=>$clientes,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}

	public function actioneditar_cliente($id_cliente)
	{
		SessionController::onlyUsers();		
		$error = false;
        $mensajeOk = '';
        $mensajeNoOk = '';
        $clientes = ClientesModel::traer_clientes_x_id($id_cliente);

        $error_msg = array(
        	'nombre' => '',
        	'domicilio' => ''  	
        );

		$datos['id_cliente'] = $id_cliente;
        $datos['nombre'] = $clientes[0]->nombre;
        $datos['domicilio'] = $clientes[0]->domicilio;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	$datos['nombre'] = $_POST['nombre'];
        	$datos['domicilio'] = $_POST['domicilio'];

        	$validacionCliente = UserController::checkEmpty($datos['nombre'], 'nombre');
            if ($validacionCliente !== true) {
                $error_msg['nombre'] = $validacionCliente;
                $error = true;
            }

			$validacionDomicilio = UserController::checkEmpty($datos['domicilio'], 'domicilio');
            if ($validacionDomicilio !== true) {
                $error_msg['domicilio'] = $validacionDomicilio;
                $error = true;
            }

            if ($error !== true) {
                $editarCliente = ClientesModel::actualizar_cliente($datos);
                if ($editarCliente === true) {
                    $mensajeOk = 'Cliente editado con éxito!';
                } else {
                    $mensajeNoOk = 'Error editando cliente';
                }
            }

        }

		static::path();
		$nombre_de_archivoDeVista = 'editar_cliente';
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

	public function actionagregar_cliente()
	{
		SessionController::onlyUsers();		
		$error = false;
        $mensajeOk = '';
        $mensajeNoOk = '';

        $error_msg = array(
        	'nombre' => '',
        	'domicilio' => ''    	
        );

        $datos['nombre'] = '';
        $datos['domicilio'] = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	$datos['nombre'] = $_POST['nombre'];
        	$datos['domicilio'] = $_POST['domicilio'];

        	$validacionNombre = UserController::checkEmpty($datos['nombre'], 'nombre');
            if ($validacionNombre !== true) {
                $error_msg['nombre'] = $validacionNombre;
                $error = true;
            }

            $validacionDomicilio = UserController::checkEmpty($datos['domicilio'], 'domicilio');
            if ($validacionDomicilio !== true) {
                $error_msg['domicilio'] = $validacionDomicilio;
                $error = true;
            }

            if ($error !== true) {
                $agregarCliente = ClientesModel::guardar_cliente($datos);
                if ($agregarCliente === true) {
                    $mensajeOk = 'Cliente agregado con éxito!';
                } else {
                    $mensajeNoOk = 'Error agregando cliente';
                }
            }

        }

		static::path();
		$nombre_de_archivoDeVista = 'agregar_cliente';
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

	public function actioneliminar_cliente($id_cliente)
	{
		SessionController::onlyUsers();
		$clientes = ClientesModel::traer_clientes_x_id($id_cliente);

		$eliminar_cliente = ClientesModel::eliminar_cliente($id_cliente);		

		static::path();
		$nombre_de_archivoDeVista = 'eliminar_cliente';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta" => self::$path,
            "cliente"=>$clientes,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}
}