<?php
include('../modelo/tipoM.php');
/**
 * 
 */
$controlador = new tipoC();
if(isset($_GET['listar_tipo']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->listar_tipo($parametros);
	echo json_encode($datos);
}
if(isset($_GET['editar']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->editar($parametros);
	echo json_encode($datos);
}

if(isset($_GET['eliminar']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->eliminar($parametros);
	echo json_encode($datos);
}
if(isset($_GET['guardar']))
{
	$parametros = $_POST;
	$datos = $controlador->guardar($parametros);
	echo json_encode($datos);
}


class tipoC
{
	private $modelo;
	function __construct()
	{
		$this->modelo = new tipoM();
	}

	function listar_tipo($parametros)
	{
		$query = $parametros['query'];
		$datos = $this->modelo->listar($query);
		$tr='';
		foreach ($datos as $key => $value) {
			$tr.="<tr>
			<td>".$value['nombre']."</td>
			<td>
			  <button type='button' class='btn btn-sm btn-primary' onclick='editar(".$value['id'].")'><i class='icon fa fa-pen'></i></button>
			  <button type='button' class='btn btn-sm btn-danger' onclick='eliminar_registro(".$value['id'].")'><i class='icon fa fa-trash'></i></button>
			</td>
			</tr>";
		}
		return $tr;
	}

	function editar($parametros)
	{
		return  $this->modelo->listar(false,$parametros['id']);
	}

	function eliminar($parametros)
	{
		return  $this->modelo->eliminar($parametros['id']);
	}


	function guardar($parametros)
	{
		// print_r($parametros);die();
		$datos[0]['campo'] = 'detalle_tipo';
		$datos[0]['dato'] = $parametros['txt_nombre'];

		if($parametros['txt_id']!='')
		{
			$where[0]['campo'] = 'id_tipo';
			$where[0]['dato'] = $parametros['txt_id'];
			return $this->modelo->editar('tipo_usuario',$datos,$where);
		}else{			
			return $this->modelo->guardar('tipo_usuario',$datos);
		}
		
		

	}	
	
}

?>