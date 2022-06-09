<?php
if (!class_exists('db')) {
include('../db/db.php');
}
/**
 * 
 */
class usuarioM
{
	private $db;
	function __construct()
	{
		// $this->db = new db();
		$this->db = new db();
	}

	function editar($tabla,$datos,$where)
	{
		return $this->db->update($tabla,$datos,$where);
	}
		
	function guardar($tabla,$datos)
	{
		return $this->db->inserts($tabla,$datos);
	}

	function eliminar($id)
	{
		$sql="DELETE FROM usuario where id_usuario=".$id;
		return $this->db->sql_string($sql);
	}

	function listar($query=false,$id=false)
	{
		$sql = "SELECT id_usuario as 'id',nombre,ci_ruc,nick,pass,T.detalle_tipo as 'tipo',direccion,U.id_tipo,email,telefono 
		FROM usuario U
		LEFT JOIN tipo_usuario T ON U.id_tipo = T.id_tipo
		WHERE 1=1";
		if($query)
		{
			$sql.=" AND nombre LIKE '%".$query."%' ";
		}
		if($id)
		{
			$sql.=" AND id_usuario=".$id;
		}
		$sql.=" ORDER BY id_usuario DESC";
		return $this->db->datos($sql);
	}

	function tipo_usuario($query=false,$id=false)
	{
		$sql = "SELECT id_tipo as 'id',detalle_tipo as 'nombre' FROM tipo_usuario
		WHERE 1=1";
		if($query)
		{
			$sql.=" AND detalle_tipo LIKE '%".$query."%' ";
		}
		if($id)
		{
			$sql.=" AND id_tipo=".$id;
		}
		$sql.=" ORDER BY id_tipo DESC";
		return $this->db->datos($sql);
	}

	
}


?>