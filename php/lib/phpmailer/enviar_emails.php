<?php 
/**
 * 
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


class enviar_emails
{
	// private $mail;
  private $modelo;
	function __construct()
	{
    $this->modelo = new facturacionM();
		
	}


	function enviar_email($empresa,$to_correo,$cuerpo_correo,$titulo_correo,$correo_respaldo='example@example.com',$archivos=false,$nombre='Email envio',$HTML=false)
	{
    $datos_smtp = $empresa;
    $nombre = $empresa[0]['Nombre_Comercial'];
    $host = 'smtp.gmail.com';
    $port =  587;
    $pass = '1722214507ja' ;
    $user =  'ejfc19omoshiroi@gmail.com';
    $secure = 'tls';
    $respuesta = true;

    if(count($datos_smtp)>0)
    {
      if($datos_smtp[0]['smtp_host']!='' && $datos_smtp[0]['smtp_pass'] !='' && $datos_smtp[0]['smtp_usuario'] !='' && $datos_smtp[0]['smtp_secure']!='')
      {
         $host =$datos_smtp[0]['smtp_host'] ;
         $pass =$datos_smtp[0]['smtp_pass'] ;
         $user =$datos_smtp[0]['smtp_usuario'] ;
         $secure = $datos_smtp[0]['smtp_secure'];
         if($datos_smtp[0]['smtp_secure']=='tls')
         {
           $port = 587;
         }else
         {
           $port = 486;
         }
      }
    }

		$to =explode(',', $to_correo);
    // print_r($to);die();
     foreach ($to as $key => $value) {
  		   $mail = new PHPMailer();
         // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
         $mail->isSMTP();                                           
         $mail->Host       = $host;
         $mail->SMTPAuth   = true;                             
         $mail->SMTPSecure = $secure;      
         $mail->Port       = $port;  
         $mail->Username   = $user;   
	       $mail->Password   = $pass;
	       $mail->setFrom($correo_respaldo,$nombre);
         // print_r($value);print_r('2');
         $mail->addAddress($value);
          // $mail->addAddress('ejfc19omoshiroi@gmail.com');     //Add a recipient   
         $mail->Subject = $titulo_correo;
         if($HTML)
         {
          $mail->isHTML(true);
         }
         $mail->Body = $cuerpo_correo; // Mensaje a enviar
         
         if($archivos)
         {
          foreach ($archivos as $key => $value) {
            // print_r(dirname(__DIR__,2).'/TEMP/'.$value);die();
           if(file_exists(dirname(__DIR__,2).'/TEMP/'.$value))
            {
                $mail->AddAttachment(dirname(__DIR__,2).'/TEMP/'.$value);
            }          
          }         
        }

        // print_r($mail);die();
          if (!$mail->send()) 
          {
          	$respuesta = false;
     	    }
    } 

    return $respuesta;
  }  

}
?>