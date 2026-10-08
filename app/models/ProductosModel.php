<?php

namespace app\models;

use \DataBase;
use \Model;

class ProductosModel extends Model
{
	protected $table = "productos";
	protected $primaryKey = "id";


	public static function traer_productos()
	{
		$model = new static();
		$sql = "SELECT * FROM productos WHERE estado = 1";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function traer_sin_stock()
	{
		$model = new static();
		$sql = "SELECT * FROM productos WHERE estado = 1 AND stock_actual = 0";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function traer_stock_critico()
	{
		$model = new static();
	    $sql = "SELECT * FROM productos WHERE estado = 1 AND stock_actual > 0 AND stock_actual < stock_minimo";
	    $result = DataBase::query($sql);

		return $result;
	}

	public static function traer_productos_x_id($id)
	{
		$model = new static();
		$sql = "SELECT * FROM productos WHERE id = :id";
		$params = [':id'   => $id];
		$result = DataBase::query($sql,$params);

		return $result;
	}

	public static function actualizar_producto($datos)
	{
		$model = new static();

	    $id_producto  = $datos['id_producto'];
	    $cod_barras   = $datos['cod_barras'];
	    $producto     = $datos['producto'];
	    $categoria    = $datos['categoria'];
	    $marca        = $datos['marca'];
	    $precio_costo = $datos['precio_costo'];
	    $precio_venta = $datos['precio_venta'];
	    $unidad       = $datos['unidad'];
	    $stock_actual = $datos['stock_actual'];
	    $stock_minimo = $datos['stock_minimo'];

	    $sql = "UPDATE productos SET 
	                codigo_barras   = :cod_barras,
	                nombre     = :producto,
	                categoria    = :categoria,
	                marca_producto  = :marca,
	                precio_costo = :precio_costo,
	                precio_venta = :precio_venta,
	                unidad_medida  = :unidad,
	                stock_actual = :stock_actual,
	                stock_minimo = :stock_minimo
	            WHERE id = :id_producto";

	    $params = [
	        ':cod_barras'   => $cod_barras,
	        ':producto'     => $producto,
	        ':categoria'    => $categoria,
	        ':marca'        => $marca,
	        ':precio_costo' => $precio_costo,
	        ':precio_venta' => $precio_venta,
	        ':unidad'       => $unidad,
	        ':stock_actual' => $stock_actual,
	        ':stock_minimo' => $stock_minimo,
	        ':id_producto'  => $id_producto
	    ];

	    $result = DataBase::execute($sql,$params);

		return $result;
	}

	public static function guardar_producto($datos)
	{
	    $cod_barras   = $datos['cod_barras'];
	    $producto     = $datos['producto'];
	    $categoria    = $datos['categoria'];
	    $precio_costo = $datos['precio_costo'];
	    $precio_venta = $datos['precio_venta'];
	    $stock_actual = $datos['stock_actual'];
	    $stock_minimo = $datos['stock_minimo'];
	    $unidad       = $datos['unidad'];
	    $marca        = $datos['marca'];

	    $sql = "INSERT INTO productos (
	                codigo_barras,
	                nombre,
	                categoria,
	                precio_costo,
	                precio_venta,
	                stock_actual,
	                stock_minimo,
	                fecha_registro,
	                estado,
	                unidad_medida,
	                marca_producto
	            ) VALUES (
	                :cod_barras,
	                :producto,
	                :categoria,
	                :precio_costo,
	                :precio_venta,
	                :stock_actual,
	                :stock_minimo,
	                NOW(),
	                1,
	                :unidad,
	                :marca
	            )";

	    $params = [
	        ':cod_barras'   => $cod_barras,
	        ':producto'     => $producto,
	        ':categoria'    => $categoria,
	        ':precio_costo' => $precio_costo,
	        ':precio_venta' => $precio_venta,
	        ':stock_actual' => $stock_actual,
	        ':stock_minimo' => $stock_minimo,
	        ':unidad'       => $unidad,
	        ':marca'        => $marca
	    ];

	    $result = DataBase::execute($sql, $params);

	    return $result;
	}

	public static function eliminar_producto($id_producto)
	{
	    $sql = "UPDATE productos SET estado = 0 WHERE id = :id_producto";
	    $params = [':id_producto' => $id_producto];

	    return DataBase::execute($sql, $params);
	}

	public static function traer_productos_codigo($producto)
	{
	    $model = new static();
	    
	    // Usamos LIKE para permitir coincidencias parciales y ordenamos para que los códigos exactos queden primero
	    $sql = "SELECT * FROM productos 
	            WHERE codigo_barras LIKE :codigo_like 
	               OR nombre LIKE :nombre_like 
	            ORDER BY (codigo_barras = :codigo_exacto) DESC 
	            LIMIT 10";
	            
	    $params = [
	        ':codigo_exacto' => $producto,
	        ':codigo_like'   => '%' . $producto . '%',
	        ':nombre_like'   => '%' . $producto . '%'
	    ];

	    $result = DataBase::query($sql, $params);

	    return $result;
	}

}