<?php

namespace app\controllers;

use app\controllers\UserController;
use app\controllers\EquiposController;
use app\models\UserModel;
use \Controller;
use \Response;
use \DataBase;




class AccountController extends Controller
{
    public function __construct()
    {
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

    public function actionLogin()
    {
        if (self::$sessionStatus === "Online") {
            static::path();
            $ruta = self::$path . 'productos';
            header("Location: $ruta");
            exit;
        }

        static::path();

        $error = false;
        $datos = [
            'email' => $_POST['email'] ?? '',
            'pass'  => $_POST['password'] ?? ''
        ];

        $error_msg = [
            'email' => '',
            'pass'  => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Validación Email
            $email = trim($datos['email']);
            $emailValidation = UserController::checkEmpty($email, 'e-mail', 5, 30);

            if ($emailValidation !== true) {
                $error_msg['email'] = $emailValidation;
                $error = true;
            } else {
                $emailValidation = UserController::checkEmail($email);
                if ($emailValidation !== true) {
                    $error_msg['email'] = $emailValidation;
                    $error = true;
                }
            }

            // Validación Contraseña
            $passwordValidation = UserController::checkEmpty($datos['pass'], 'contraseña', 4, 15);
            if ($passwordValidation !== true) {
                $error_msg['pass'] = $passwordValidation;
                $error = true;
            }

            // Verificación de credenciales en DB si no hay errores previos
            if (!$error) {
                $checkUsuario = UserController::getUser($email);

                if ($checkUsuario === false) {
                    $error = true;
                    $error_msg['email'] = 'Credenciales invalidas!';
                } elseif (!password_verify($datos['pass'], $checkUsuario->password)) {
                    $error = true;
                    $error_msg['pass'] = 'Credenciales invalidas!';
                } else {
                    $emailValidation = UserController::checkActivo($email);
                    if ($emailValidation !== true) {
                        $error_msg['email'] = $emailValidation;
                        $error = true;
                    }
                }
            }

            // Inicio de Sesión y Redirección
            if (!$error) {
                $_POST['email'] = trim($_POST['email']);
                $logueo = SessionController::setSessionData($_POST['email']);

                if ($logueo === true) {
                    static::path();
                    $ruta = self::$path . 'productos';
                    header("Location: $ruta");
                    exit;
                }
            }
        }

        $nombre_de_archivoDeVista = 'login';
        $parametros_de_vista = [
            "head"      => SiteController::head(),
            "ruta"      => self::$path,
            "error"     => $error,
            "error_msg" => $error_msg,
            "datos"     => $datos
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    public function actionSalir(){
        session_destroy();
        static::path();
        $ruta = self::$path.'account/login/';
        $_SESSION['SESSION']['STATUS'] = false;
        header("Location: $ruta");
        $offline = UserModel::offline($_SESSION["USER"]["mail"]);
    }
}