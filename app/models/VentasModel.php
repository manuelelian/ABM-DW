<?php

namespace app\models;

use \DataBase;
use \Model;

class VentasModel extends Model
{
	protected $table = "venta";
	protected $primaryKey = "id";

	public static function traer_ventas()
	{
		$model = new static();
		$sql = "SELECT v.*, c.nombre AS cliente, u.nombre AS vendedor FROM ventas AS v
					INNER JOIN clientes AS c
				ON c.id = v.cliente
						INNER JOIN usuarios AS u
				ON u.id_user = v.vendedor
		 		WHERE v.estado = 1";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function agregar_venta($datos, $productos, $vendedor)
	{
	    $model = new static();
	    $sql = [];

	    $cliente = $datos['cliente'];
	    $total_final = $datos['total_final'];
	    $fp = $datos['fp'];

	    $sql[] = "INSERT INTO ventas (vendedor,precio_venta,cliente,estado,descuento)
            VALUES ($vendedor, $total_final, $cliente, 1, 0)";

        $sql[] = "SET @id_venta = LAST_INSERT_ID();";

        // Insertar productos
	    foreach ($productos as $prod) {
	        $id_producto      = $prod['id'];
	        $precio = $prod['precio'];
	        $cantidad    = $prod['cantidad'];
	        $subtotal    = $prod['subtotal'];

	        $sql[] = "
	            INSERT INTO ventas_productos 
	                (id_producto, id_venta, precio_producto, cantidad, subtotal, fecha_venta)
	            VALUES 
	                ('$id_producto', @id_venta, '$precio', '$cantidad', '$subtotal', NOW())
	        ";
	    }

	    $sql[] = "INSERT INTO ventas_pagos (id_venta,metodo_pago,monto)
            VALUES (@id_venta, $fp, $total_final)";
	    // Ejecutar transacciones solo si hay consultas
	    try {
	        if (!empty($sql)) {
	            $resultado = DataBase::transaction($sql);
	            $result['state'] = $resultado['state'];
	            $result['notification'] = $resultado['notification'];
	        } else {
	            $result['state'] = true;
	            $result['notification'] = 'No hay cambios que realizar en los repuestos';
	        }
	    } catch (Exception $e) {
	        $result['notification'] = $e->getMessage();
	        $result['state'] = false;
	    }
	    
	    return $result;
	}
}