<?php 
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include('../modelo/ArticulosM.php');
include('../modelo/localizacionM.php');
include('../modelo/marcasM.php');
include('../modelo/custodioM.php');
include('../modelo/proyectosM.php');
include('../modelo/estadoM.php');
include('../modelo/generoM.php');
include('../modelo/coloresM.php');

/**
 * 
 */
$reporte = new Reporte_excel();
if(isset($_GET['reporte_sap']))
{
	$reporte->Reporte_sap($_GET['query'],$_GET['loc'],$_GET['cus'],$_GET['desde'],$_GET['hasta']);
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_normal']))
{
	$reporte->Reporte_normal($_GET['query'],$_GET['loc'],$_GET['cus']);
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_emplazamiento']))
{
	$reporte->reporte_localizacion();
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_marca']))
{
	$reporte->reporte_marca();
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_custodio']))
{
	$reporte->reporte_custodio();
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_proyecto']))
{
	$reporte->reporte_proyecto();
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_estado']))
{
	$reporte->reporte_estado();
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_genero']))
{
	$reporte->reporte_genero();
	// $reporte-> ejemplo();
}
if(isset($_GET['reporte_colores']))
{
	$reporte->reporte_color();
	// $reporte-> ejemplo();
}


class Reporte_excel
{
	private $articulos;
	
	function __construct()
	{
		$this->articulos = new ArticulosM();
		$this->localizacion = new localizacionM();
		$this->marcas = new marcasM();
		$this->custodio = new custodioM();
		$this->proyectos = new proyectosM();

		$this->estado = new estadoM();
		$this->genero = new generoM();
		$this->colores = new coloresM();		
	}

	function Reporte_sap($query,$loc,$cus,$desde,$hasta)
	{
		//$tipoString = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
		$ruta='';
		if($query == 'null')
		{
			$query ='';
		}
		if($loc == 'null')
		{
			$loc ='';
		}
		if($cus == 'null')
		{
			$cus ='';
		}
		

		$datos = $this->articulos->lista_articulos_sap_codigos($query,$loc,$cus,false,false,1,$desde,$hasta);
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getStyle('W')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
		$sheet->getStyle('I')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
		
		$sheet->setCellValue('A1','BUKRS');
		$sheet->setCellValue('B1','ANLN1');
		$sheet->setCellValue('C1','ANLN2');
		$sheet->setCellValue('D1','TXT50');
		$sheet->setCellValue('E1','TXTA50');
		$sheet->setCellValue('F1','ANLHTXT');		
		$sheet->setCellValue('G1','SERNR');		
		$sheet->setCellValue('H1','INVNR');
		$sheet->setCellValue('I1','IVDAT');
		$sheet->setCellValue('J1','MERGE');
		$sheet->setCellValue('K1','MEINS');
		$sheet->setCellValue('L1','STORT');
		$sheet->setCellValue('M1','KTEXT');
		$sheet->setCellValue('N1','PERNR');
		$sheet->setCellValue('O1','PERNP_TXT');
		$sheet->setCellValue('P1','ORD41');
		$sheet->setCellValue('Q1','ORD42');
		$sheet->setCellValue('R1','ORD43');
		$sheet->setCellValue('S1','ORD44');
		$sheet->setCellValue('T1','GDLGRP');
		$sheet->setCellValue('U1','ANLUE');
		$sheet->setCellValue('V1','AIBN1');
		$sheet->setCellValue('W1','AKTIV');
		$sheet->setCellValue('X1','URWRT');
		$sheet->setCellValue('Y1','');		
		$sheet->setCellValue('Z1','NOTE1');
		$sheet->setCellValue('AA1','IMAGEN');
		$sheet->setCellValue('AB1','ACTUALIZADO POR');
		$count = 2;

		foreach ($datos as $key => $value) {
			//print_r($value);die();
		// $fecha = $value['FECHA_INV_DATE']->format('Y-m-d');
		    $fecha='';
			if($value['FECHA_INV_DATE'] !='')
			{
				$fecha =$value['FECHA_INV_DATE']->format('Y-m-d');
				$fecha = new DateTime($fecha);
				$fecha = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fecha);
			}
			$fechaC='';
			if($value['ORIG_ACQ_YR'] !='')
			{
				$fechaC =$value['ORIG_ACQ_YR']->format('Y-m-d'); 
				$fechaC = new DateTime($fechaC);
				$fechaC = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fechaC);

			}


		$sheet->setCellValue('A'.$count,$value['COMPANYCODE']);
		$sheet->setCellValue('B'.$count,$value['TAG_SERIE']);
		$sheet->setCellValue('C'.$count,$value['SUBNUMBER']);
		$sheet->setCellValue('D'.$count,utf8_decode($value['DESCRIPT']));
		$sheet->setCellValue('E'.$count,$value['DESCRIPT2']);
		$sheet->setCellValue('F'.$count,$value['MODELO']);		
		$sheet->setCellValue('G'.$count,$value['SERIE']);		
		$sheet->setCellValue('H'.$count,$value['TAG_UNIQUE']);
		$sheet->setCellValue('I'.$count,$fecha);
		$sheet->setCellValue('J'.$count,$value['QUANTITY']);
		$sheet->setCellValue('K'.$count,$value['BASE_UOM']);
		$sheet->setCellValue('L'.$count,$value['EMPLAZAMIENTO']);
		$sheet->setCellValue('M'.$count,utf8_encode($value['DENOMINACION']));
		$sheet->setCellValue('N'.$count,$value['PERSON_NO']);
		$sheet->setCellValue('O'.$count,utf8_decode($value['PERSON_NOM']));
		$sheet->setCellValue('P'.$count,$value['marca']);
		$sheet->setCellValue('Q'.$count,$value['estado']);
		$sheet->setCellValue('R'.$count,$value['genero']);
		$sheet->setCellValue('S'.$count,$value['color']);
		$sheet->setCellValue('T'.$count,$value['criterio']);
		$sheet->setCellValue('U'.$count,$value['ASSETSUPNO']);
		$sheet->setCellValue('V'.$count,$value['ORIG_ASSET']);
		$sheet->setCellValue('W'.$count,$fechaC);
		$sheet->setCellValue('X'.$count,$value['ORIG_VALUE']);
		$sheet->setCellValue('Y'.$count,$value['OBSERVACION']);		
		$sheet->setCellValue('Z'.$count,utf8_decode($value['CARACTERISTICA']));
		$sheet->setCellValue('AA'.$count,$value['IMAGEN']);
		$sheet->setCellValue('AB'.$count,$value['ACTU_POR']);
		$count = $count+1;
	  }


	    $write = new Xlsx($spreadsheet);
		$write->save('Reporte_activos.xlsx');
		echo "<meta http-equiv='refresh' content='0;url=Reporte_activos.xlsx'/>";
		exit;
		
		

	      // NOMBRE DEL ARCHIVO Y CHARSET
	      //header("Content-type: application/vnd.ms-excel");
         // header("Content-Disposition: attachment; filename=INVENTARIO.xls");
         // header("Pragma: no-cache");
          //header("Expires: 0");


          // $salida=fopen('php://output', 'w');

    }


	function Reporte_normal($query,$loc,$cus)
	{
		if($query == 'null')
		{
			$query ='';
		}
		if($loc == 'null')
		{
			$loc ='';
		}
		if($cus == 'null')
		{
			$cus ='';
		}

	  // NOMBRE DEL ARCHIVO Y CHARSET
	    header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=INVENTARIO.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

          // $salida=fopen('php://output', 'w');

          $salida = '<table class="table table-striped">
	  <thead>
		<th>Tag</th>
		<th>Decripcion</th>
		<th>Modelo</th>
		<th>Serie</th>
		<th>Localizacion</th>
		<th>Custodio</th>
		<th>Marca</th>
		<th>Estado</th>
		<th>Genero</th>
		<th>Color</th>
		<th>Observacion</th>
		<th>Fecha inventario</th>
	  </thead>
	  <tbody>';
	  $datos =  $this->articulos->lista_articulos($query,$loc,$cus);
	  // print_r($datos);die();
	  foreach ($datos as $key => $value) {
		// $fecha = $value['FECHA_INV_DATE']->format('Y-m-d');
		$fecha='';
			if($value['fecha_in'] !='')
			{
				$fecha =$value['fecha_in']->format('Y-m-d'); 
			}

	  $salida.='<tr><td>'.$value['tag'].'</td>'.
	  '<td>'.$value['nom'].'</td>'.
	  '<td>'.$value['modelo'].'</td>'.
	  '<td>'.$value['serie'].'</td>'.
	  '<td>'.$value['localizacion'].'</td>'.
	  '<td>'.$value['custodio'].'</td>'.
	  '<td>'.$value['marca'].'</td>'.
	  '<td>'.$value['estado'].'</td>'.
	  '<td>'.$value['genero'].'</td>'.
	  '<td>'.$value['color'].'</td>'.
	  '<td>'.$value['OBSERVACION'].'</td>'.
	  '<td>'.$fecha.'</td>';
	  }
	  $salida.='</tbody>
       </table>';
      echo $salida;
    }

    function reporte_localizacion()
    {
    	$datos = $this->localizacion->lista_localizacion_todo();
    	//print_r($datos);die();
    	$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1','Centro');
		$sheet->setCellValue('B1','Emplazamiento');
		$sheet->setCellValue('C1','Denominacion');
		$count = 2;
		foreach ($datos as $key => $value) {
			$sheet->setCellValue('A'.$count,$value['CENTRO']);
		    $sheet->setCellValue('B'.$count,$value['EMPLAZAMIENTO']);
		    $sheet->setCellValue('C'.$count,$value['DENOMINACION']);
		    $count = $count+1;
		}
		 $write = new Xlsx($spreadsheet);
		 $write->save('Reporte_emplazamiento.xlsx');
		 echo "<meta http-equiv='refresh' content='0;url=Reporte_emplazamiento.xlsx'/>";
		 exit;
		


    }

     function reporte_marca()
    {
    	$datos = $this->marcas->lista_marcas();
    	//print_r($datos);die();
    	$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1','CODIGO SAP');
		$sheet->setCellValue('B1','DESCRIPCION SAP');
		$count = 2;
		foreach ($datos as $key => $value) {
			$sheet->setCellValue('A'.$count,$value['CODIGO']);
		    $sheet->setCellValue('B'.$count,$value['DESCRIPCION']);
		    $count = $count+1;
		}
		 $write = new Xlsx($spreadsheet);
		 $write->save('Reporte_MARCAS.xlsx');
		 echo "<meta http-equiv='refresh' content='0;url=Reporte_MARCAS.xlsx'/>";
		 exit;
		


    }

     function reporte_custodio()
    {
    	$datos = $this->custodio->buscar_custodio_todo();
    	//print_r($datos);die();
    	$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->setCellValue('A1','ID Externo del Personal');
		$sheet->setCellValue('B1','Numero de Identificacion');
		$sheet->setCellValue('C1','Apellidos y Nombres');
		$sheet->setCellValue('D1','Codigo de Puesto (Label)');
		$sheet->setCellValue('E1','Unidad Organizacional (Label)');
		$sheet->setCellValue('F1','Correo Electronico');
		$count = 2;
		foreach ($datos as $key => $value) {
			$sheet->setCellValue('A'.$count,$value['PERSON_NO']);
		    $sheet->setCellValue('B'.$count,$value['PERSON_CI']);
		    $sheet->setCellValue('C'.$count,$value['PERSON_NOM']);
		    $sheet->setCellValue('D'.$count,$value['PUESTO']);
		    $sheet->setCellValue('E'.$count,$value['UNIDAD_ORG']);
		    $sheet->setCellValue('F'.$count,$value['PERSON_CORREO']);
		    $count = $count+1;
		}
		 $write = new Xlsx($spreadsheet);
		 $write->save('Reporte_CUSTODIO.xlsx');
		 echo "<meta http-equiv='refresh' content='0;url=Reporte_CUSTODIO.xlsx'/>";
		 exit;
		


    }

     function reporte_proyecto()
    {
    	$datos = $this->proyectos->lista_proyectos_todo();
    	//print_r($datos);die();
    	$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->getStyle('E')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
		$sheet->getStyle('F')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
		$sheet->getStyle('G')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->setCellValue('A1','Programa de financiación');
		$sheet->setCellValue('B1','Entidad CP');
		$sheet->setCellValue('C1','Denominación');
		$sheet->setCellValue('D1','Descripción');
		$sheet->setCellValue('E1','Validez de');
		$sheet->setCellValue('F1','Validez a');
		$sheet->setCellValue('F1','Fecha de expiración');
		$count = 2;
		foreach ($datos as $key => $value) {
			$sheet->setCellValue('A'.$count,$value['pro']);
		    $sheet->setCellValue('B'.$count,$value['enti']);
		    $sheet->setCellValue('C'.$count,$value['deno']);
		    $sheet->setCellValue('D'.$count,$value['desc']);
		    $sheet->setCellValue('E'.$count,$value['valde']);
		    $sheet->setCellValue('F'.$count,$value['vala']);
		    $sheet->setCellValue('G'.$count,$value['exp']);
		    $count = $count+1;
		}
		 $write = new Xlsx($spreadsheet);
		 $write->save('Reporte_proyecto.xlsx');
		 echo "<meta http-equiv='refresh' content='0;url=Reporte_proyecto.xlsx'/>";
		 exit;
		


    }

     function reporte_estado()
    {
    	$datos = $this->estado->lista_estado();
    	//print_r($datos);die();
    	$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->setCellValue('A1','CODIGO');
		$sheet->setCellValue('B1','DESCRIPCION');
		$count = 2;
		foreach ($datos as $key => $value) {
			$sheet->setCellValue('A'.$count,$value['CODIGO']);
		    $sheet->setCellValue('B'.$count,$value['DESCRIPCION']);
		    $count = $count+1;
		}
		 $write = new Xlsx($spreadsheet);
		 $write->save('Reporte_estado.xlsx');
		 echo "<meta http-equiv='refresh' content='0;url=Reporte_estado.xlsx'/>";
		 exit;
		


    }

     function reporte_color()
    {
    	$datos = $this->colores-> lista_colores();
    	//print_r($datos);die();
    	$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1','CODIGO');
		$sheet->setCellValue('B1','DESCRIPCION');
		$count = 2;
		foreach ($datos as $key => $value) {
			$sheet->setCellValue('A'.$count,$value['CODIGO']);
		    $sheet->setCellValue('B'.$count,$value['DESCRIPCION']);
		    $count = $count+1;
		}
		 $write = new Xlsx($spreadsheet);
		 $write->save('Reporte_color.xlsx');
		 echo "<meta http-equiv='refresh' content='0;url=Reporte_color.xlsx'/>";
		 exit;
		


    }

     function reporte_genero()
    {
    	$datos = $this->genero->lista_genero();
    	//print_r($datos);die();
    	$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1','CODIGO');
		$sheet->setCellValue('B1','DESCRIPCION');
		$count = 2;
		foreach ($datos as $key => $value) {
			$sheet->setCellValue('A'.$count,$value['CODIGO']);
		    $sheet->setCellValue('B'.$count,$value['DESCRIPCION']);
		    $count = $count+1;
		}
		 $write = new Xlsx($spreadsheet);
		 $write->save('Reporte_genero.xlsx');
		 echo "<meta http-equiv='refresh' content='0;url=Reporte_genero.xlsx'/>";
		 exit;
		


    }



 


}
?>
