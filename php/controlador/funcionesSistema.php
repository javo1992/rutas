<?php
include('../modelo/loginM.php');
/**
 * 
 */
$controlador = new funcionesC();
if(isset($_GET['lista']))
{
	$query = '';
	$datos = $controlador->lista_bodega($query);
	echo json_encode($datos);
}
if(isset($_GET['login']))
{
    $parametros = $_POST['parametros'];
    echo json_encode($controlador->session($parametros));
}
if(isset($_GET['cerrar_session']))
{
    // $parametros = $_POST['parametros'];
    echo json_encode($controlador->cerrar_session());
}
if(isset($_GET['notificaciones']))
{
    $parametros = $_POST['parametros'];
    echo json_encode($controlador->notificaciones($parametros));
}

class funcionesC
{
	private $modelo;
	function __construct()
	{
		$this->modelo = new loginM();
	}
	

  function session($parametros)
    {
    	// print_r($parametros);die();
      $result = $this->modelo->usuario_exist($parametros);
      if($result==true)
      {
        $datos = $this->modelo->usuario_datos($parametros);
	       $_SESSION['INICIO']['USUARIO']=$datos[0]['nick'];
         $_SESSION['INICIO']['NOMBRE']=$datos[0]['nombre'];
	       $_SESSION['INICIO']['ID_USUARIO']=$datos[0]['id_usuario'];
	       $_SESSION['INICIO']['PASS']=$datos[0]['pass'];
         $_SESSION['INICIO']['TIPO_U']=$datos[0]['id_tipo'];
        return array('res'=>$result,'datos'=>$datos);
      }
      return array('res'=>$result,'datos'=>'');
    }

   function cerrar_session()
   {
   	 session_destroy();
   	 return 1;
   }

  function notificaciones($parametros)
  {
    $usuario = $this->modelo->notificaciones_usuario($parametros['empresa'],$parametros['usuario']);

    $noti = '<h6 class="dropdown-header">
                Centro de alertas
            </h6>';
    $num = 0;
    foreach ($usuario as $key => $value) {
    if(is_object($value['fecha']))
    {
        $value['fecha'] = $value['fecha']->format('Y-m-d');
    }
      $noti.= '
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">'.$value['fecha'].'</div>
                    <span class="font-weight-bold">'.$value['titulo'].'</span>
                </div>
            </a>';
            $num=$num+1;
    }

    $datos = array('noti'=>$noti,'num'=>$num);
    return $datos;

  } 
}

?>