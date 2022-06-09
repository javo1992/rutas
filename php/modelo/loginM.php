<?php
include('../db/db.php');
/**
 * 
 */
class loginM
{
	private $db;
	function __construct()
	{
		// $this->db = new db();
		$this->db = new db();
	}
	function usuario_exist($parametros)
    {
    $sql = "SELECT * FROM usuario U
	WHERE nick = '".$parametros['usu']."' AND pass='".$parametros['pass']."'";
	$result = $this->db->existente($sql);
	// print_r($result);die();
	 return $result;
    }

    function usuario_datos($parametros)
    {
    $sql = "SELECT * FROM usuario U
	WHERE nick = '".$parametros['usu']."' AND pass='".$parametros['pass']."'";
	$result = $this->db->datos($sql);
	// print_r($result);die();
	 return $result;
    }


    // function notificaciones_usuario($id_empresa,$usuario)
    // {
    // 	$sql = "SELECT * FROM
    // 	(SELECT * FROM notificaciones WHERE empresa = '".$id_empresa."' AND usuario = '".$usuario."' and leido = '0'
    // 	UNION
    // 	SELECT * FROM notificaciones WHERE empresa = '".$id_empresa."' AND usuario is NULL AND leido = 0) AS I ORDER BY I.id_noti DESC "; 
    // 	$result = $this->db->datos($sql,$id_empresa);
    //     return $result;

    // }
	
}


?>