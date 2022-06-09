<?php
if (!class_exists('db')) {
include('../db/db.php');
}
/**
 * 
 */
class rutasM
{
	private $db;
	function __construct()
	{
		// $this->db = new db();
		$this->db = new db();
	}

	function update($tabla,$datos,$where)
	{
		return $this->db->update($tabla,$datos,$where);
	}

	function add($tabla,$datos)
	{
		return $this->db->inserts($tabla,$datos);
	}

	function buscar_contenedores($estado=false,$id=false,$query=false,$codigo=false)
	{
		$sql = "SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin,codigo,largo,ancho,alto,descripcion as 'des' FROM contenedores C
		LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado
		WHERE 1= 1";
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
		if($codigo)
		{
			$sql.=" AND codigo = '".$codigo."'";
		}
		$sql.=" ORDER BY id_contenedores DESC ";
		return $this->db->datos($sql);

	}

	function buscar_contenedores_estado($estado=false,$id=false,$query=false)
	{
		$sql = "SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin,codigo FROM contenedores C
		LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado
		WHERE 1= 1 and inicio !=1 and fin !=1";
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
		$sql.=" ORDER BY id_contenedores DESC ";
		return $this->db->datos($sql);

	}

	function estados()
	{
		$sql= "SELECT id_estado as 'id',nombre_estado as 'estado' FROM estado_contenedor";
		return $this->db->datos($sql);
	}

	function  rutas_optima($estado=false,$id=false,$query=false)
	{
		$sql ="SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE inicio =1
		UNION ALL
		SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE inicio=0 AND fin = 0 ";
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
		$sql.=" UNION ALL
		SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin  FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE fin =1";
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

	function  rutas_optima_simulacion($estado=false,$id=false,$query=false)
	{
		$sql ="SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE inicio =1
		UNION ALL
		SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE inicio=0 AND fin = 0 AND Codigo is null ";
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
		$sql.=" UNION ALL
		SELECT id_contenedores as 'id', nombre_contenedores as 'nombre',latitud as 'la',longitud as 'lo',EC.nombre_estado,estado,EC.imagen,inicio,fin  FROM contenedores C LEFT JOIN estado_contenedor EC ON C.estado = EC.id_estado WHERE fin =1 ";
		return $this->db->datos($sql);

	}

}


?>