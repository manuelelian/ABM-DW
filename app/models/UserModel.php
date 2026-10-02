<?php

namespace app\models;

use \DataBase;
use \Model;

class UserModel extends Model
{
	protected $table = "usuarios";
	protected $primaryKey = "id_usuario";
	protected $secundaryKey = "email";
	public $email;

	public static function getAllUsers()
	{
		$model = new static();
		$sql = "SELECT * FROM usuarios";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function findEmail($email)
	{
		$model = new static();
		$sql = "SELECT * FROM {$model->table} WHERE {$model->secundaryKey} = :email";
		$params = ["email" => $email];
		$result = DataBase::getRecord($sql, $params);
		return $result;
	}

	public static function getUserByEmail($email)
	{
		$model = new static();
		$sql = "SELECT * FROM " . $model->table . " WHERE email = '$email'";
		$result = DataBase::query($sql);

		return $result;
	}
	

}
