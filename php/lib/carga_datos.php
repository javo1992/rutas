<?php 
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
include('../db/db.php');
include('../modelo/marcasM.php');
include('../modelo/estadoM.php');
include('../modelo/generoM.php');
include('../modelo/coloresM.php');
include('../modelo/proyectosM.php');
include('../modelo/localizacionM.php');
include('../modelo/custodioM.php');

$controlador = new carga_datos();
if(isset($_GET['plantilla']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->subir_datos($parametros));
	

	//echo json_encode($controlador->actualizacion());
}

/**
 * 
 */
class carga_datos
{
	private $marcas;
	private $estado;
	private $genero;
	private $color;
	private $proyecto;
	private $localizacion;
	private $custodio;
	private $db;
	
	function __construct()
	{
		$this->marcas = new marcasM();
		$this->estado = new estadoM();
		$this->genero = new generoM();
		$this->color = new coloresM();
		$this->proyecto = new proyectosM();
		$this->localizacion = new  localizacionM();
		$this->custodio = new  custodioM();
		$this->db = new db();
	}

	function actualizacion()
	{
		

		     $nombreArchivo = 'Actualiza.xlsx';	
	         $objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);	
	         $objPHPExcel->setActiveSheetIndex(0);
	         $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	         $sql = '';
	         $sql2 = '';
	         for($j = 2; $j <= $numRows; $j++)
	         	{

	         		$asse = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getCalculatedValue();
	         		$orri = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getCalculatedValue();
	         		$sql.= "UPDATE ASSET SET TAG_ANT = '".$orri."' WHERE TAG_SERIE ='".$asse."';";	         		
	         		$id = $this->marcas->plantilla($asse);
	         		//print_r($id);die();
	         		$sql2 .= "UPDATE PLANTILLA_MASIVA SET ORIG_ASSET = '".$orri."' WHERE ID_ASSET ='".$id[0]['ID_ASSET']."';";	


	            }
	            print_r($sql);
	            print_r('-');
	            print_r($sql2);
	            die();

	}

	function subir_datos($parametros)
	{
		if ($parametros['parte']==1) 
		{
			$nombreArchivo = '';
			if ($parametros['id']==1) {
				$nombreArchivo = 'plantilla_masiva.xlsx';
			}elseif ($parametros['id']==2) {
				$nombreArchivo = 'colores.xlsx';
			}elseif ($parametros['id']==3) {
				$nombreArchivo = 'custodio.xlsx';
			}elseif ($parametros['id']==4) {
				$nombreArchivo = 'estado.xlsx';
			}elseif ($parametros['id']==5) {
				$nombreArchivo = 'genero.xlsx';
			}elseif ($parametros['id']==6) {
				$nombreArchivo = 'emplazamiento.xlsx';
			}elseif ($parametros['id']==7) {
				$nombreArchivo = 'marcas.xlsx';
			}elseif ($parametros['id']==8) {
				$nombreArchivo = 'proyecto.xlsx';
			}
			 	
	        // $nombreArchivo = 'ejemplo.xlsx';
			 $doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			 $objPHPExcel = $doc->load($nombreArchivo);
			 $objPHPExcel->setActiveSheetIndex(0);
			 $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	         $partes = 0;
	         $ini=0;
	         $fin =0;
	         if($numRows > 20000)
	         {
	    	     $partes = ($numRows/20000); 
	         }else
	         {
	         	$partes = 1;
	         }
	         if(is_float($partes))
	          {
	     	     $partes = intval($partes)+1;
	     	     $ini = 2 ;
	     	     $fin = 20002;
	          }else
	          {
	          	$ini = 2 ;
	     	    $fin = $numRows;
	          }
	          if ($parametros['id']==1) {
	          	 $res =  $this->plantilla_masiva($parametros['parte'],$partes,$numRows,$ini,$fin);
	             return $res;
	          }elseif ($parametros['id']==2) {
	          	 $res =  $this->colores($parametros['parte'],$partes,$numRows,$ini,$fin+1);
	             return $res;
	          }elseif ($parametros['id']==3) {
	          	 $res =  $this->custodio($parametros['parte'],$partes,$numRows,$ini,$fin+1);
	             return $res;
	          }elseif ($parametros['id']==4) {
	          	 $res =  $this->estado($parametros['parte'],$partes,$numRows,$ini,$fin+1);
	             return $res;
	          }elseif ($parametros['id']==5) {
	          	 $res =  $this->genero($parametros['parte'],$partes,$numRows,$ini,$fin+1);
	             return $res;
	          }elseif ($parametros['id']==6) {
	          	 $res =  $this->emplazamiento($parametros['parte'],$partes,$numRows,$ini,$fin+1);
	             return $res;
	          }elseif ($parametros['id']==7) {
	          	 $res =  $this->marcas($parametros['parte'],$partes,$numRows,$ini,$fin+1);
	             return $res;
	          }elseif ($parametros['id']==8) {
	          	 $res =  $this->proyectos($parametros['parte'],$partes,$numRows,$ini,$fin+1);
	             return $res;
	          }
	         

		}else
		{
			if($parametros['parte']==$parametros['partes'])
			{
				$ini = $parametros['fin'];
				$fin = $parametros['regis'];
				 if ($parametros['id']==1) 
				 {
				 	$res =  $this->plantilla_masiva($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
				 }elseif ($parametros['id']==2) 
				 {
				 	$res =  $this->colores($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
	             }elseif ($parametros['id']==3) 
				 {
				 	$res =  $this->custodio($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
	             }elseif ($parametros['id']==4) 
				 {
				 	$res =  $this->estado($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
	             }elseif ($parametros['id']==5) 
				 {
				 	$res =  $this->genero($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
	             }elseif ($parametros['id']==6) 
				 {
				 	$res =  $this->emplazamiento($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
	             }elseif ($parametros['id']==7) 
				 {
				 	$res =  $this->marcas($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
	             }elseif ($parametros['id']==8) 
				 {
				 	$res =  $this->proyectos($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin+1);
				 	return $res;
	             }

				
			}else
			{
				$ini = intval($parametros['fin']);
				$fin = intval($parametros['fin'])+20000;
				 if ($parametros['id']==1) 
				 {
				 	$res =  $this->plantilla_masiva($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin);
				 	return $res;
				 }elseif ($parametros['id']==2) 
				 {
				 	$res =  $this->colores($parametros['parte'],$parametros['partes'],$parametros['regis'],$ini,$fin);
				 	return $res;
	             }elseif ($parametros['id']==3) {
	          	 $res =  $this->custodio($parametros['parte'],$partes,$numRows,$ini,$fin);
	             return $res;
	          }elseif ($parametros['id']==4) {
	          	 $res =  $this->estado($parametros['parte'],$partes,$numRows,$ini,$fin);
	             return $res;
	          }elseif ($parametros['id']==5) {
	          	 $res =  $this->genero($parametros['parte'],$partes,$numRows,$ini,$fin);
	             return $res;
	          }elseif ($parametros['id']==6) {
	          	 $res =  $this->emplazamiento($parametros['parte'],$partes,$numRows,$ini,$fin);
	             return $res;
	          }elseif ($parametros['id']==7) {
	          	 $res =  $this->marcas($parametros['parte'],$partes,$numRows,$ini,$fin);
	             return $res;
	          }elseif ($parametros['id']==8) {
	          	 $res =  $this->proyectos($parametros['parte'],$partes,$numRows,$ini,$fin);
	             return $res;
	          }
				

			}

		}
	}

	function plantilla_masiva($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	//ini_set('memory_limit', '44M');
	$datos_localizacion = $this->localizacion->lista_localizacion_todo();
	$datos_custodio = $this->custodio->buscar_custodio_todo();
	$datos_eval1 = $this->marcas->lista_marcas();
	$datos_eval2 = $this->estado->lista_estado();
	$datos_eval3 = $this->genero->lista_genero();
	$datos_eval4 = $this->color->lista_colores();
	$datos_eval5 = $this->proyecto->lista_proyectos_todo();

	$respuesta = '';
	$nombreArchivo = 'plantilla_masiva.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	//$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	//$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	// print_r($numRows);die();
	$campos = " INSERT INTO PLANTILLA_MASIVA  (COMPANYCODE,ID_ASSET,SUBNUMBER,DESCRIPT,DESCRIPT2,MODELO,SERIE,FECHA_INV_DATE,COSTCENTER,RESP_CCTR,LOCATION,PERSON_NO,FUNDS_CTR_APC,PROFIT_CTR,EVALGROUP1,EVALGROUP2,EVALGROUP3,EVALGROUP4,EVALGROUP5,ASSETSUPNO,IMAGEN,RETIRADO,OBSERVACION,QUANTITY,BASE_UOM,ORIG_ASSET,ORIG_ACQ_YR,ORIG_VALUE,CARACTERISTICA) VALUES ";

	$campos2="INSERT INTO ASSET (TAG_UNIQUE,TAG_SERIE,TAG_ANT) VALUES";
	$dato = '';
	$dato2='';
	$count = 0;
	$insert ='';
	$insert2 ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;
		
		$compa = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$asset = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$subnu = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$descr = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
		$desc2 = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
		$model = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$serie = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$rfid_ = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		//$fe_In =  $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$fe_In =  $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		//print_r($fe_In);die();
		if($fe_In == "")
		{
			$fe_In= 'NULL';
		}else
		{
			$fe_In= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fe_In);
			$fe_In = "'".$fe_In->format('Y-m-d')."'";
		//	print_r($fe_In);die();
		}
		//$fe_In= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fe_In);
		

		// $fe_In = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		$canti = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
		$ba_uo = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();		
		// $locat = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
		    $empla = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();

		$org_a = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
		 if($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue()=="")
		 {
		 	$locat = "''";
		 }else
		 {
		 	$lo_vali = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue());
		 	foreach ($datos_localizacion as $key => $value) {
		 		if ($value['EMPLAZAMIENTO']== $lo_vali) {
		 			$locat= $value['ID_LOCATION'];
		 			break;
		 		}else
		 		{
		 			$locat= "''";
		 		}
		 	}
		 	if($locat== "''")
		 	{
		 		$respuesta .= 'Localizacion no registrada en base: '.$empla.' en el articulo:'.$org_a.' /';
		 	}

		 }

		// $perso = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();		 
		  $custo = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
		if($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue()=="")
		 {
		 	$perso = "''";
		 }else
		 {

		 	$cus_val = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue());
		 	foreach ($datos_custodio as $key => $value) {
		 		if ($value['PERSON_NO']==$cus_val) {
		 			$perso= $value['ID_PERSON'];
		 			break;	
		 		}else
		 		{
		 			$perso= "''";
		 		}
		 	}
		 	if($perso== "''")
		 	{
		 		$respuesta .= 'Custodio no encontrado en base: '.$custo.' en el articulo:'.$org_a.' /';
		 	}
		 	
		 }
		 if($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue()=="")
		 {
		 	$eval1 = "''";
		 }else
		 {
		 	$eva1 = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue());
		 	foreach ($datos_eval1 as $key => $value) {
		 		if ($value['DESCRIPCION']==$eva1) {
		 			$eval1= $value['ID_MARCA'];
		 			break;
		 		}else
		 		{
		 			$eval1= "''";
		 		}
		 	}
		 	if ($eval1 =="''") {
		 		$respuesta .= 'Marca no registrada en base: '.$eva1.' en el articulo:'.$org_a.' /';		 		
		 	}
		 
		 }

		 if($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue()=="")
		 {
		 	$eval2 = "''";
		 }else
		 {
		 	$eva2 = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue());
		 	//print_r($eva2);
		 	//print_r($datos_eval2);die();
		 	foreach ($datos_eval2 as $key => $value) {
		 		if (strnatcasecmp($value['DESCRIPCION'], $eva2) === 0) {
		 			$eval2= $value['ID_ESTADO'];	
		 			break;
		 		}else
		 		{
		 			$eval2= "''";
		 		}
		 	}

		 	if($eval2== "''")
		 	{
		 		$respuesta .= 'Estado no registrada en base: '.$eva2.' en el articulo:'.$org_a.' /';
		 	}
		 
		 }

		 if($objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue()=="")
		 {
		 	$eval3 = "''";
		 }else
		 {

		 	$eva3 =$this->validar_datos($objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue());
		 	foreach ($datos_eval3 as $key => $value) {
		 		if ($value['DESCRIPCION']==$eva3) {
		 			$eval3= $value['ID_GENERO'];		
		 			break;
		 		}else
		 		{
		 			$eval3= "''";
		 		}
		 	}

		 	if($eval3== "''")
		 	{
		 		$respuesta .= 'Genero no registrada en base: '.$eva3.'en el articulo:'.$org_a.' /';
		 	}


		 }

		 if($objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue()=="")
		 {
		 	$eval4 = "''";
		 }else
		 {

		 	$eva4 =$this->validar_datos($objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue());
		 	foreach ($datos_eval4 as $key => $value) {
		 		if ($value['DESCRIPCION']==$eva4) {
		 			$eval4= $value['ID_COLORES'];
		 			break;
		 		}else
		 		{
		 			$eval4= "''";
		 		}
		 	}

		 	if($eval4== "''")
		 	{
		 		$respuesta .= 'Color no registrada en base: '.$eva4.'en el articulo:'.$org_a.' /';
		 	}


		 }

		 if($objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue()=="")
		 {
		 	$eval5 = "''";
		 }else
		 {
		 	$eva5 =$this->validar_datos($objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue());
		 	foreach ($datos_eval5 as $key => $value) {
		 		if ($value['pro']==$eva5) {
		 			$eval5= $value['id'];
		 			break;
		 		}else
		 		{
		 			$eval5= "''";
		 		}
		 	}

		 	if($eval5== "''")
		 	{
		 		$respuesta .= 'Proyecto no registrada en base: '.$eva5.' en el articulo:'.$org_a.' /';
		 	}
	
		 }
		// print_r($eval1);die();		
		$ass_n = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();

		//$f_com =  $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$f_com =  $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
		if($f_com == "")
		{
			$f_com= 'NULL';
		}else
		{
			$f_com= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($f_com);
			//print_r($f_com->format('Y-m-d'));die();
			$f_com = "'".$f_com->format('Y-m-d')."'";
			
		}




		$org_v = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
		$carac = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue());
		$img = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();

		
		$dato.= "('".$compa."',".($i-1).",'".$subnu."','".$descr."','".$desc2."','".$model."','".$serie."',".$fe_In.",'','',".$locat.",".$perso.",'','',".$eval1.",".$eval2.",".$eval3.",".$eval4.",".$eval5.",'".$ass_n."','".$img."',0,'',".$canti.",'".$ba_uo."','".$org_a."',".$f_com.",'".$org_v."','".$carac."'),";

		$dato2.="('".$rfid_."','".$asset."','".$org_a."'),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$dato2 = substr($dato2,0,-1);
			$insert2 .= $campos2.' '.$dato2.';';
			$count = 0;
			$dato = '';
			$dato2 = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';

	      $dato2 = substr($dato2,0,-1);
	      $insert2.=$campos2.' '.$dato2.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM PLANTILLA_MASIVA; DBCC CHECKIDENT (PLANTILLA_MASIVA, RESEED, 0); ".$insert;
		   $sql2 = " DELETE FROM ASSET; DBCC CHECKIDENT (ASSET, RESEED, 0); ".$insert2;
		   
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
           $ret2 = $this->db->sql_string($sql2);
		   $ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$ret2 = $this->db->sql_string($insert2);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}

	function colores($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	$respuesta = '';
	$nombreArchivo = 'colores.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	
	$campos = " INSERT INTO COLORES  (CODIGO,DESCRIPCION) VALUES ";
	$dato = '';
	$count = 0;
	$insert ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;
		
		$codigo = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$desc = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());

		
		$dato.= "('".$codigo."','".$desc."'),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$count = 0;
			$dato = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM COLORES; DBCC CHECKIDENT (COLORES, RESEED, 0); ".$insert;
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
			$ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}

	function genero($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	$respuesta = '';
	$nombreArchivo = 'genero.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	
	$campos = " INSERT INTO GENERO  (CODIGO,DESCRIPCION) VALUES ";
	$dato = '';
	$count = 0;
	$insert ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;
		
		$codigo = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$desc = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());

		
		$dato.= "('".$codigo."','".$desc."'),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$count = 0;
			$dato = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM GENERO; DBCC CHECKIDENT (GENERO, RESEED, 0); ".$insert;
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
			$ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}

	function estado($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	$respuesta = '';
	$nombreArchivo = 'estado.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	
	$campos = " INSERT INTO ESTADO (CODIGO,DESCRIPCION) VALUES ";
	$dato = '';
	$count = 0;
	$insert ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;
		
		$codigo = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$desc = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());

		
		$dato.= "('".$codigo."','".$desc."'),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$count = 0;
			$dato = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM ESTADO; DBCC CHECKIDENT (ESTADO, RESEED, 0); ".$insert;
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
			$ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}

	function marcas($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	$respuesta = '';
	$nombreArchivo = 'marcas.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	
	$campos = " INSERT INTO MARCAS (CODIGO,DESCRIPCION) VALUES ";
	$dato = '';
	$count = 0;
	$insert ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;
		
		$codigo = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$desc = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());

		
		$dato.= "('".$codigo."','".$desc."'),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$count = 0;
			$dato = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM MARCAS; DBCC CHECKIDENT (MARCAS, RESEED, 0); ".$insert;
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
			$ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}

function proyectos($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	$respuesta = '';
	$nombreArchivo = 'proyecto.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	
	$campos = " INSERT INTO PROYECTO (programa_financiacion,entidad_cp,denominacion,descripcion,validez_de,validez_a,expiracion) VALUES ";
	$dato = '';
	$count = 0;
	$insert ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;

		$codigo = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$entidad = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
		$denominacion = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
		$descripcion = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
		$f1 =  $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		if($f1 == "")
		{
			$f1= 'NULL';
		}else
		{
			$f1= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($f1);
			$f1 = "'".$f1->format('Y-m-d')."'";			
		}
		
		$f2 =  $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		if($f2 == "")
		{
			$f2= 'NULL';
		}else
		{
			$f2= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($f2);
			$f2 = "'".$f2->format('Y-m-d')."'";			
		}

		$f3 =  $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		if($f3 == "")
		{
			$f3= 'NULL';
		}else
		{
			$f3= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($f3);
			$f3 = "'".$f3->format('Y-m-d')."'";			
		}
	
		$dato.= "('".$codigo."','".$entidad."','".$denominacion."','".$descripcion."',".$f1.",".$f2.",".$f3."),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$count = 0;
			$dato = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM PROYECTO; DBCC CHECKIDENT (PROYECTO, RESEED, 0); ".$insert;
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
			$ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}

function emplazamiento($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	$respuesta = '';
	$nombreArchivo = 'emplazamiento.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	
	$campos = " INSERT INTO LOCATION (CENTRO,EMPLAZAMIENTO,DENOMINACION,FAMILIA,SUBFAMILIA) VALUES ";
	$dato = '';
	$count = 0;
	$insert ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;

		$centro = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$emplazamiento = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
		$denominacion = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
		$fami = substr($emplazamiento, 0,5);
		$subfami = substr($emplazamiento, 5);
		
	
		$dato.= "('".$centro."','".$emplazamiento."','".$denominacion."','".$fami."','".$subfami."'),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$count = 0;
			$dato = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM LOCATION; DBCC CHECKIDENT (LOCATION, RESEED, 0); ".$insert;
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
			$ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}

	function custodio($part,$partes,$totalReg,$ini,$fin)
	{
	ini_set('memory_limit', '-1');
	$respuesta = '';
	$nombreArchivo = 'custodio.xlsx';	
	$doc = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$objPHPExcel = 	$doc->load($nombreArchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	
	$campos = " INSERT INTO PERSON_NO (PERSON_NO,PERSON_NOM,PERSON_CI,PERSON_CORREO,PUESTO,UNIDAD_ORG) VALUES ";
	$dato = '';
	$count = 0;
	$insert ='';
	for($i = $ini; $i < $fin; $i++)
	{
		$count = $count+1;

		$NO = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$CI = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
		$NOM = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
		$PUE = $this->validar_datos($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
		$UNI =$this->validar_datos($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
		$COR = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
	
		$dato.= "('".$NO."','".$NOM."','".$CI."','".$COR."','".$PUE."','".$UNI."'),";
		if($count == 1000)
		{
			$dato = substr($dato,0,-1);
			$insert .= $campos.' '.$dato.';';
			$count = 0;
			$dato = '';
		}

	   }
	   if($dato !='')
	   {
	   	  $dato = substr($dato,0,-1);
	      $insert.=$campos.' '.$dato.';';
	   }

		if($part==1)
		{
		   $sql = " DELETE FROM PERSON_NO; DBCC CHECKIDENT (PERSON_NO, RESEED, 0); ".$insert;
		   //print_r($sql);die();
           $ret = $this->db->sql_string($sql);
			$ret = 1;
           $res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }else
        {
        	//print_r($insert);die();
        	$ret = $this->db->sql_string($insert);
        	$res = array('parte' => $part,'partes'=>$partes,'TotalReg'=>$totalReg,'respuesta'=>$ret,'observaciones'=>$respuesta,'fin'=>$fin);
		   return $res;
        }
    
	}


	function validar_datos($texto)
	{
		$buscar = array('á','é','í','ó','ú','ñ','Ñ','Á','É','Í','Ó','Ú',',',':',';',"'",'"' );
		$remplazar = array('a','e','i','o','u','n','N','A','E','I','O','U','','','','','' );
		$texto_new = str_replace($buscar,$remplazar,$texto);
		return $texto_new;
	}
}
?>