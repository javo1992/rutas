<?php
include('../modelo/nuevo_contenedorM.php');
include('../modelo/rutasM.php');
/**
 * 
 */
$controlador = new nuevo_contenedorC();
if(isset($_GET['nuevo']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->nuevo($parametros);
	echo json_encode($datos);
}
if(isset($_GET['puntos_mapa']))
{
	$datos = $controlador->puntos_mapa();
	echo json_encode($datos);
}
if(isset($_GET['lista_contenedores']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->lista_contenedores($parametros);
	echo json_encode($datos);
}
if(isset($_GET['editar']))
{
	$id = $_POST['id'];
	$datos = $controlador->editar($id);
	echo json_encode($datos);
}
if(isset($_GET['eliminar']))
{
	$id = $_POST['id'];
	$datos = $controlador->eliminar($id);
	echo json_encode($datos);
}
if(isset($_GET['revisar']))
{
	$datos = $controlador->revisar();
	echo json_encode($datos);
}

class nuevo_contenedorC
{
	private $modelo;
	private $rutas;
	function __construct()
	{
		$this->modelo = new nuevo_contenedorM();
		$this->rutas = new rutasM();
	}

	function nuevo($parametros)
	{
		// print_r($parametros);die();
		$datos[0]['campo'] = 'longitud';
		$datos[0]['dato'] = $parametros['lon'];
		$datos[1]['campo'] = 'latitud';
		$datos[1]['dato'] = $parametros['lat'];
		$datos[2]['campo'] = 'nombre_contenedores';
		$datos[2]['dato'] = $parametros['nom'];
		$datos[3]['campo'] = 'codigo';
		$datos[3]['dato'] = $parametros['cod'];

		$datos[4]['campo'] = 'largo';
		$datos[4]['dato'] = $parametros['la'];

		$datos[5]['campo'] = 'ancho';
		$datos[5]['dato'] = $parametros['an'];

		$datos[6]['campo'] = 'alto';
		$datos[6]['dato'] = $parametros['al'];

		$datos[7]['campo'] = 'descripcion';
		$datos[7]['dato'] = $parametros['des'];

		if($parametros['ini']=='true' && $parametros['fin']=='true')
		{
			$datos[8]['campo'] = 'inicio';
			$datos[8]['dato'] = 1;

			$datos[9]['campo'] = 'fin';
			$datos[9]['dato'] = 1;
		}else if($parametros['ini']=='true' && $parametros['fin']=='false')
		{
			$datos[8]['campo'] = 'inicio';
			$datos[8]['dato'] = 1;

		}else if($parametros['ini']=='false' && $parametros['fin']=='true')
		{
			$datos[8]['campo'] = 'fin';
			$datos[8]['dato'] = 1;
		}

		if($parametros['id']=='')
		{
			return $this->modelo->insertar('contenedores',$datos);			
		}else
		{
			$where[0]['campo'] = 'id_contenedores';
			$where[0]['dato'] = $parametros['id'];
			return $this->modelo->update('contenedores',$datos,$where);
		}

	}

	function puntos_mapa(){
		$datos = $this->rutas->rutas_optima();		
		return $datos;
	}

	function lista_contenedores($parametros){
		$datos = $this->rutas->buscar_contenedores(false,false,$parametros['query']);
		$tr = '';
		foreach ($datos as $key => $value) {
			$tr.='<tr>
			<td>'.$value['codigo'].'</td>
			<td>'.$value['nombre'].'</td>
			<td>'.number_format($value['la'],6,'.',',').'</td>
			<td>'.number_format($value['lo'],6,'.',',').'</td>
			<td>'.$value['largo'].'</td>
			<td>'.$value['ancho'].'</td>
			<td>'.$value['alto'].'</td>
			<td>'.$value['des'].'</td>
			<td><button class="btn btn btn-sm btn-primary" onclick="editar(\''.$value["id"].'\')"><i class="fa fa-fw fa-pen"></i></button>
			<button class="btn btn btn-sm btn-danger" onclick="delete_contenedor(\''.$value["id"].'\')"><i class="fa fa-fw fa-trash"></i></button>
			</td>
			</tr>';
		}
		return $tr;
	}


	function editar($id)
	{
		return $this->rutas->buscar_contenedores($estado=false,$id);
	}
	function eliminar($id)
	{
		return $this->modelo->eliminar($id);
	}

	function revisar()
	{
		$inicio = $this->modelo->inicio();
		$fin = $this->modelo->fin();

		return array('inicio'=>$inicio,'fin'=>$fin);
	}
	
	
}

?>