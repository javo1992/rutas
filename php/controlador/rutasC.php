<?php
include('../modelo/rutasM.php');
/**
 * 
 */

$controlador = new rutasC();

//FUNCION QUE RECIBE DESDE IOT
if(isset($_GET['Identificador']) and isset($_GET['Var']))
{
	$id = $_GET['Identificador'];
	$es = $_GET['Var'];
	$datos = $controlador->editar_estado_IOT($id,$es);
	echo json_encode($datos);

}
//FIN DE FUNCION REIBE IOT
if(isset($_GET['puntos']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->buscar_puntos($parametros);
	echo json_encode($datos);
}

if(isset($_GET['puntos_all']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->puntos_all($parametros);
	echo json_encode($datos);
}
if(isset($_GET['estados']))
{
	$datos = $controlador->estados();
	echo json_encode($datos);
}

if(isset($_GET['pos_rutas']))
{
	// $parametros = $_POST['parametros'];
	// print_r($parametros);die();
	$datos = $controlador->ruta_optima();
	echo json_encode($datos);
}

if(isset($_GET['simular']))
{
	$datos = $controlador->simular();
	echo json_encode($datos);
}
if(isset($_GET['llenos']))
{
	echo json_encode($controlador->contenedores_llenos());
}

class rutasC
{
	private $modelo;
	function __construct()
	{
		$this->modelo = new rutasM();
	}
	
	function buscar_puntos($parametros)
	{
		ini_set('max_execution_time', '300');
		$estado = $parametros['estado'];
		$puntos = $this->modelo->rutas_optima($estado);
		$inicio = '';
		$fin = '';
		$puntos_cont = array();
		$ruta_enviar = array();

		foreach ($puntos as $key => $value) {
		    if($value['inicio']=='1' && $value['fin']=='1')
		    {
		      $inicio = array('lo'=>$value['lo'],'la'=>$value['la'],'nombre'=>$value['nombre'],'estado'=>$value['estado']);
		      $fin = array('lo'=>$value['lo'],'la'=>$value['la'],'nombre'=>$value['nombre'],'estado'=>$value['estado']);
		    }else if($value['inicio']=='1' && $value['fin']=='0')
		    {
		      $inicio = array('lo'=>$value['lo'],'la'=>$value['la'],'nombre'=>$value['nombre'],'estado'=>$value['estado']);
		    }else if($value['inicio']=='0' && $value['fin']=='1')
		    {
		      $fin = array('lo'=>$value['lo'],'la'=>$value['la'],'nombre'=>$value['nombre'],'estado'=>$value['estado']);
		    }else{
		    	array_push($puntos_cont,array('lo'=>$value['lo'],'la'=>$value['la'],'nombre'=>$value['nombre'],'estado'=>$value['estado']));
		    }
		}
		if($inicio=='')
		{
			$pun = $puntos_cont[0];
			unset($puntos_cont[0]);
			$inicio = $pun;
		}
		array_push($ruta_enviar,$inicio);
		while (count($puntos_cont)>0) {

			$posi = array();
			foreach ($puntos_cont as $key => $value) {
				$ini = $inicio['lo'].','.$inicio['la'];
				$nom = $inicio['nombre'];
				$pun = $value['lo'].','.$value['la'];
				$dis = $this->distancia($ini,$pun);
				array_push($posi, ['distancia'=>$dis,'pos'=>$key]);
			}
			sort($posi); //ordena de manera acendente
			$pun = $puntos_cont[$posi[0]['pos']];
			array_push($ruta_enviar,$pun);
			unset($puntos_cont[$posi[0]['pos']]);
			$inicio = $pun;
			
		}
		if($fin!=''){array_push($ruta_enviar,$fin);}		
		return $ruta_enviar;

	}

	function puntos_all($parametros)
	{
		$estado = $parametros['estado'];
		$puntos = $this->modelo->rutas_optima($estado);		
		return $puntos;

	}

	function estados()
	{
		$datos = $this->modelo->estados();
		$op = "<option value=''>Todos</option>";
		foreach ($datos as $key => $value) {
			$op.="<option value='".$value['id']."'>".$value['estado']."</option>";
		}
		return $op;
	}

	function distancia($rutaIni,$rutaFin)
	{
		$url = 'https://router.project-osrm.org/route/v1/driving/'.$rutaIni.';'.$rutaFin.'?overview=false&alternatives=true&steps=true&hints=;'; 
		// print_r($url);die();
		$content = json_decode(file_get_contents($url),true); 
		$distancia = $content['routes'][0]['distance']/100;

		// print_r($distancia);die();
		return $distancia;
	}
	function simular(){
		$puntos = $this->modelo->rutas_optima_simulacion();
		$num = count($puntos);
		$pos = random_int(0, $num-1);
		$punto_up = $puntos[$pos];
		$id = $punto_up['id'];
		$estado=1;
		switch ($punto_up['estado']) {
			case '1':
				$estado = 2;
				break;
			case '2':
				$estado = 3;
				break;
			case '3':
				$estado = 1;
				break;
			
		}

		$datos[0]['campo'] = 'estado'; 
		$datos[0]['dato'] = $estado;

		$where[0]['campo'] = 'id_contenedores'; 		
		$where[0]['dato'] = $id;
		return $this->modelo->update('contenedores',$datos,$where);
		// if ($) {
			# code...
		// }

		print_r($punto_up);
	}

	function editar_estado_IOT($id,$es)
	{
		$datos[0]['campo'] ='estado';
		$datos[0]['dato'] =$es;

		$where[0]['campo'] = 'codigo';
		$where[0]['dato'] =  $id;
		return $this->modelo->update('contenedores',$datos,$where);

	}

	function contenedores_llenos()
	{
		$datos = $this->modelo->buscar_contenedores_estado(3);
		$lista = '';
		foreach ($datos as $key => $value) {
			$lista.= $value['nombre'].'-';
		}
		return $lista;
	}
}

?>