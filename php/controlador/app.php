<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
date_default_timezone_set('America/Guayaquil'); 

include('../modelo/appM.php');
/**
 * 
 */

$controlador = new app();

if(isset($_GET['log']))
{
	// print_r($_POST);die();
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->login($parametros));
}

if(isset($_GET['estados_app']))
{
	$datos = $controlador->estados_app();
	echo json_encode($datos);
}
if(isset($_GET['puntos_app']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->buscar_puntos_app($parametros);
	echo json_encode($datos);
}

if(isset($_GET['detalle_usuario']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->detalle_usuario($parametros);
	echo json_encode($datos);
}

if(isset($_GET['guardar_detalle']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->guardar_detalle($parametros);
	echo json_encode($datos);
}

if(isset($_GET['contenedores']))
{
	// $parametros = $_POST['parametros'];
	$datos = $controlador->contenedores();
	echo json_encode($datos);
}

if(isset($_GET['detalle_contenedores']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->detalle_contenedores($parametros);
	echo json_encode($datos);
}

if(isset($_GET['estadisticas_contenedores']))
{
	$parametros = $_POST['parametros'];
	$datos = $controlador->estadisticas_contenedores($parametros);
	echo json_encode($datos);
}
if(isset($_GET['home_pie']))
{
	// $parametros = $_POST['parametros'];
	$datos = $controlador->home_pai();
	echo json_encode($datos);
}
if(isset($_GET['usuario_home']))
{
	// $parametros = $_POST['parametros'];
	$datos = $controlador->usuario_home();
	echo json_encode($datos);
}
if(isset($_GET['contenedor_home']))
{
	// $parametros = $_POST['parametros'];
	$datos = $controlador->contenedor_home();
	echo json_encode($datos);
}



class app
{
	private $modelo;
	function __construct()
	{
		$this->modelo = new appM();
	}
	

	function login($parametros)
	{
		$datos = $this->modelo->login($parametros['usu'],$parametros['pass']);
		if(count($datos)>0)
		{
			return $datos;
		}else
		{
			return -1;
		}
	}

	function estados_app()
	{
		$datos = $this->modelo->estados();
		$op = "<option value=''>Seleccione</option>";
		foreach ($datos as $key => $value) {
			$op.="<option value='".$value['id']."'>".$value['estado']."</option>";
		}
		return $op;
	}

	function buscar_puntos_app($parametros)
	{
		// print_r($parametros);die();
		ini_set('max_execution_time', '300');
		$estado = $parametros['estado'];
		$puntos = $this->modelo->rutas_optima_app($estado);
		$inicio = '';
		$fin = '';
		$puntos_cont = array();
		$ruta_enviar = array();

		foreach ($puntos as $key => $value) {		   
		    array_push($puntos_cont,array('lo'=>$value['lo'],'la'=>$value['la'],'nombre'=>$value['nombre'],'estado'=>$value['estado']));
		}

		$inicio = array('lo'=>$parametros['lon'],'la'=>$parametros['lat'],'nombre'=>'mi posicion','estado'=>'');
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

		// print_r($ruta_enviar);die();	
		return $ruta_enviar;

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

	function detalle_usuario($parametros)
	{
		// print_r($parametros);die();
		 $datos = $this->modelo->detalle_usuario($parametros['id']);

		 // print_r($datos);die();
		 if(!file_exists('../img/usuario/'.$datos[0]['foto']))
		 {
		 	$datos[0]['foto'] = '';
		 }
		 return $datos;
	}

	function guardar_detalle($parametros)
	{
		$datos[0]['campo'] = 'nombre';
		$datos[0]['dato'] = $parametros['nom'];
		$datos[1]['campo'] = 'ci_ruc';
		$datos[1]['dato'] = $parametros['ci'];
		$datos[2]['campo'] = 'telefono';
		$datos[2]['dato'] = $parametros['tel'];
		$datos[3]['campo'] = 'email';
		$datos[3]['dato'] = $parametros['ema'];
		$datos[4]['campo'] = 'direccion';
		$datos[4]['dato'] = $parametros['dir'];
		$datos[5]['campo'] = 'nick';
		$datos[5]['dato'] = $parametros['usu'];
		$datos[6]['campo'] = 'pass';
		$datos[6]['dato'] = $parametros['pass'];


		$where[0]['campo'] = 'id_usuario';
		$where[0]['dato'] = $parametros['id'];

		return $this->modelo->update('usuario',$datos,$where); 
	}


	function contenedores()
	{
		$datos = $this->modelo->contenedores();
		$op = '';
		foreach ($datos as $key => $value) {
			if($key == 0)
			{
				$op.= '<option value="'.$value['id'].'" selected="">'.$value['nombre'].'</option>';
			}else
			{
				$op.= '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
			}
		}
		return $op;
	}

	function detalle_contenedores($parametros)
	{
		$datos = $this->modelo->contenedores($parametros['id']);
		 if(!file_exists('../img/contenedores/'.$datos[0]['foto']))
		 {
		 	$datos[0]['foto'] = '';
		 }
		return $datos;
	}
	function estadisticas_contenedores($parametros)
	{

		// print_r($parametros);die();
		$fecha = date('Y-m-d');
		$dia_n = date('N');
		$val = array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0);
		for ($i=$dia_n; $i > 0; $i--) { 
			$estado = $this->modelo->estadisticas($parametros['id'] ,$fecha);
			$fecha = date("Y-m-d",strtotime($fecha."- 1 days")); 
			$val[$i] = number_format($estado[0]['pro'],2,'.','');
		}

		$ar = implode(",", $val);

		return $ar;
	}

	function home_pai()
	{
		$lleno = count($this->modelo->contenedores($id=false,$estado =3));
		$medio = count($this->modelo->contenedores($id=false,$estado =2));
		$vacio = count($this->modelo->contenedores($id=false,$estado =1));
		$conte = count($this->modelo->contenedores($id=false,$estado =false));
		return  array('lleno'=>$lleno,'medio'=>$medio,'vacio'=>$vacio,'conte'=>$conte);
	}

	function usuario_home()
	{
		return count($this->modelo->login($usuario=false,$pass = false));
	}
	function contenedor_home()
	{
		$mes = (date('m')-1);
		$year = date('Y');
		$datos = $this->modelo->contenedores();
		$tmp = array();

		$d = array();
		foreach ($datos as $key => $value) {
			$datos1 = $this->modelo->mas_usados($mes,$year,$value['id']);
			$d[] = $datos1[0]['estado'];
			if(count($tmp)==0)
			{
				$tmp = array('id'=>$value['id'],'valor'=>$datos1[0]['estado'],'nombre'=>$value['nombre']);
			}else
			{
				if($datos1[0]['estado'] < $tmp['valor'])
				{
					$tmp =array('id'=>$value['id'],'valor'=>$datos1[0]['estado'],'nombre'=>$value['nombre']);
				}
			}
		}
		$tmp1 = array();
		foreach ($datos as $key => $value) {
			$datos1 = $this->modelo->mas_usados($mes,$year,$value['id']);
			if(count($tmp1)==0)
			{
				$tmp1 = array('id'=>$value['id'],'valor'=>$datos1[0]['estado'],'nombre'=>$value['nombre']);
			}else
			{
				if($datos1[0]['estado'] > $tmp1['valor'])
				{
					$tmp1 = array('id'=>$value['id'],'valor'=>$datos1[0]['estado'],'nombre'=>$value['nombre']);
				}
			}
		}

		return array('max'=>$tmp1,'min'=>$tmp);

		// print_r($tmp);
		// print_r($tmp1);
		// print_r($d);
		// print_r($datos);
		// die();

	}






}

?>