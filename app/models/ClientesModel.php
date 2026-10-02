<?php

namespace app\models;

use \DataBase;
use \Model;

class ClientesModel extends Model
{
	protected $table = "clientes";
	protected $primaryKey = "id";


	public static function traer_clientes()
	{
		$model = new static();
		$sql = "SELECT * FROM clientes WHERE estado = 1";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function traer_clientes_x_id($id)
	{
		$model = new static();
		$sql = "SELECT * FROM clientes WHERE id = :id";
		$params = [':id'   => $id];
		$result = DataBase::query($sql,$params);

		return $result;
	}

	public static function actualizar_cliente($datos)
	{
		$model = new static();

	    $id_cliente  = $datos['id_cliente'];
	    $nombre   = $datos['nombre'];
	    $domicilio     = $datos['domicilio'];

	    $sql = "UPDATE clientes SET 
	                nombre   = :nombre,
	                domicilio     = :domicilio
	            WHERE id = :id_cliente";

	    $params = [
			':id_cliente' => $id_cliente,
	        ':nombre'   => $nombre,
	        ':domicilio'     => $domicilio
	    ];

	    $result = DataBase::execute($sql,$params);

		return $result;
	}

	public static function guardar_cliente($datos)
	{
	    $nombre   = $datos['nombre'];
	    $domicilio     = $datos['domicilio'];

	    $sql = "INSERT INTO clientes (
	                nombre,
	                domicilio
	            ) VALUES (
	                :nombre,
	                :domicilio
	            )";

	    $params = [
	        ':nombre'   => $nombre,
	        ':domicilio'     => $domicilio,
	    ];

	    $result = DataBase::execute($sql, $params);

	    return $result;
	}

	public static function eliminar_cliente($id_cliente)
	{
	    $sql = "UPDATE clientes SET estado = 0 WHERE id = :id_cliente";
	    $params = [':id_cliente' => $id_cliente];

	    return DataBase::execute($sql, $params);
	}
}