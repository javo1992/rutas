<?php
if (!class_exists('db')) {
include('../db/db.php');
}
/**
 * 
 */
class appM
{
	private $db;
	function __construct()
	{
		// $this->db = new db();
		$this->db = new db();
	}

	function login($usuario=false,$pass = false)
	{
		$sql = "SELECT * FROM usuario WHERE 1=1 ";
		if($usuario!=false and $pass !=false )
			{
				$sql.=" AND nick = '".$usuario."' AND pass='".$pass."'";
			}
		return $this->db->datos($sql);
	}

	function update($tabla,$datos,$where)
	{
		return $this->db->update($tabla,$datos,$where);
	}
	function estados()
	{
		$sql= "SELECT id_estado as 'id',nombre_estado as 'estado' FROM estado_contenedor";
		return $this->db->datos($sql);
	}

	function rutas_optima_app($estado=false,$id=false,$query=false)
	{
		$sql ="SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE inicio=0 AND fin = 0 ";
		if($estado)
		{
			$sql.=" AND estado=".$estado;
		}
		if($id)
		{
			$sql.=" AND id_contenedores=".$id;
		}
		if($query)
		{
			$sql.=" AND nombre_contenedores like '%".$query."%'";
		}
		return $this->db->datos($sql);

	}

	function detalle_usuario($id)
	{
		$sql = "SELECT id_usuario as 'id',nombre,ci_ruc,telefono,direccion,nick,pass,foto,T.detalle_tipo,email 
				FROM usuario U
				INNER JOIN tipo_usuario T ON U.id_tipo = T.id_tipo 
				WHERE id_usuario = '".$id."'";
		return $this->db->datos($sql);

	}

	function contenedores($id=false,$estado = false)
	{
		$sql = "SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,foto,inicio,fin,largo,alto,ancho,descripcion
		FROM contenedores C 
		LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado
		 WHERE 1=1";
		 if($id)
		 {
		 	$sql.=" AND id_contenedores = '".$id."'";
		 } 
		 if($estado)
		 {
		 	$sql.=" AND estado = '".$estado."'";
		 } 
		 $sql.=" AND inicio=0 AND fin = 0 ";
		return $this->db->datos($sql);
	}

	function estadisticas($sensor,$fecha)
	{
		$sql = "SELECT AVG(estado) as 'pro'
		        FROM historial
		        wHERE sensor = '".$sensor."' AND fecha = '".$fecha."';";
		        // print_r($sql);
		return $this->db->datos($sql);
		
	}

	function mas_usados($mes,$year,$sensor)
	{
		$sql="SELECT AVG(estado) as estado FROM historial WHERE MONTH(fecha) ='".$mes."'  AND YEAR(fecha) = '".$year."' AND sensor = '".$sensor."'";
		return $this->db->datos($sql);

	}

}


?>