<?php
include('../db/db.php');
/**
 * 
 */
class nuevo_contenedorM
{
	private $db;
	function __construct()
	{
		// $this->db = new db();
		$this->db = new db();
	}

	function insertar($tabla,$datos)
	{
		return $this->db->inserts($tabla,$datos);
	}
	function update($tabla,$datos,$where)
	{
		return $this->db->update($tabla,$datos,$where);
	}
	function eliminar($id)
	{
		$sql='DELETE FROM contenedores where id_contenedores='.$id;
		return $this->db->sql_string($sql);
	}

	function inicio(){
		$sql="SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin  FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE inicio =1";
		return $this->db->existente($sql);
	}

		function fin(){
		$sql="SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin  FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE fin =1";
		return $this->db->existente($sql);
	}


	
	
	
}


?>