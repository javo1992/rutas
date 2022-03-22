<?php 
include('pdf/cabecera_pdf.php');
include('pdf/factura_pdf.php');
/**
 * 
 */
$reporte = new Reporte_pdf();

class Reporte_pdf
{
	private $pdf;
	private $factura_pdf;
	function __construct()
	{
		$this->pdf = new cabecera_pdf();
		$this->factura_pdf = new factura_pdf();
	}


	function factura_pdf($datos=false,$lineas=false,$empresa=false,$mostrar=true,$descargar=false)
	{

		// print_r($datos);
		// print_r($lineas);
		// print_r($empresa);
		// die();
		if(is_object($datos[0]['fecha']))
		{
			$datos[0]['fecha'] = $datos[0]['fecha']->format('Y-m-d');
		}
		$logo = $empresa[0]['logo'];

		$tablaHTML = array();
		$tablaHTML[0]['medidas']=array(30,70);
		$tablaHTML[0]['alineado']=array('L','L');
		$tablaHTML[0]['datos']=array('<b>CI/RUC:',$empresa[0]['RUC']);

		$tablaHTML[0]['altoRow'] = 7;
		// $tablaHTML[0]['borde'] = 1;

		$tablaHTML[1]['medidas']=array(30,70);
		$tablaHTML[1]['alineado']=array('L','L');
		$tablaHTML[1]['datos']=array('<b>FACTURA:',$datos[0]['serie'].' '.$this->generar_ceros($datos[0]['num_factura'],9));

		$tablaHTML[1]['altoRow'] = 7;
		// $tablaHTML[1]['borde'] = 1;

		$tablaHTML[2]['medidas']=array(100);
		$tablaHTML[2]['alineado']=array('L');
		$tablaHTML[2]['datos']=array('<B>NUMERO DE AUTORIZACION');
		$tablaHTML[2]['altoRow'] = 7;

		$tablaHTML[3]['medidas']=array(100);
		$tablaHTML[3]['alineado']=array('L');
		$tablaHTML[3]['datos']=array(': '.$datos[0]['Autorizacion'].'');
		$tablaHTML[3]['altoRow'] = 7;

		// $tablaHTML[2]['borde'] = 1;

		$tablaHTML[4]['medidas']=array(70,30);
		$tablaHTML[4]['alineado']=array('L','L');
		$tablaHTML[4]['datos']=array('<B>FECHA Y HORA DE AUTORIZACION: ',$datos[0]['fecha']);

		$tablaHTML[4]['altoRow'] = 7;
		// $tablaHTML[3]['borde'] = 1;

		
		$tablaHTML[5]['medidas']=array(30,70);
		$tablaHTML[5]['alineado']=array('L','L');
		$tablaHTML[5]['datos']=array('<b>AMBIENTE:','PRUEBA');
		if($empresa[0]['Ambiente']!='1')
		{
			$tablaHTML[5]['datos']=array('<b>AMBIENTE:','PRODUCCION');
		}
		$tablaHTML[5]['altoRow'] = 7;
		// $tablaHTML[4]['borde'] = 1;


		$tablaHTML[6]['medidas']=array(30,70);
		$tablaHTML[6]['alineado']=array('L','L');
		$tablaHTML[6]['datos']=array('<b>EMISION:','NORMAL');
		$tablaHTML[6]['altoRow'] = 7;
		// $tablaHTML[5]['borde'] = 1;

		$tablaHTML[7]['medidas']=array(100);
		$tablaHTML[7]['alineado']=array('L');
		$tablaHTML[7]['datos']=array('<B>CLAVE DE ACCESO');

		//-----------------------cuadro izquierda-----------------//
		$altoRow = 5;
		$tablaHTML2 = array();
		$tablaHTML2[0]['medidas']=array(86);
		$tablaHTML2[0]['alineado']=array('L');
		$tablaHTML2[0]['datos']=array($empresa[0]['Nombre_Comercial']);
		// $tablaHTML2[0]['borde'] = 1;
		$tablaHTML2[0]['altoRow'] = $altoRow;

		$tablaHTML2[1]['medidas']=array(86);
		$tablaHTML2[1]['alineado']=array('L');
		$tablaHTML2[1]['datos']=array('<b>Direccion Matriz');
		// $tablaHTML2[1]['borde'] = 1;
		$tablaHTML2[1]['altoRow'] = $altoRow;

		$tablaHTML2[2]['medidas']=array(86);
		$tablaHTML2[2]['alineado']=array('L');
		$tablaHTML2[2]['datos']=array($empresa[0]['Direccion']);
		// $tablaHTML2[2]['borde'] = 1;
		$tablaHTML2[2]['altoRow'] = $altoRow;

		$tablaHTML2[3]['medidas']=array(86);
		$tablaHTML2[3]['alineado']=array('L');
		$tablaHTML2[3]['datos']=array('<b>Direccion Sucursal');
		// $tablaHTML2[3]['borde'] = 1;
		$tablaHTML2[3]['altoRow'] = $altoRow;

		$tablaHTML2[4]['medidas']=array(86);
		$tablaHTML2[4]['alineado']=array('L');
		$tablaHTML2[4]['datos']=array('');
		if($empresa[0]['sucursal']!='')
		{
		 $tablaHTML2[4]['datos']=array($empresa[0]['direccion_s']);
	    }
		// $tablaHTML2[4]['borde'] = 1;
		$tablaHTML2[4]['altoRow'] = 7;

		$tablaHTML2[5]['medidas']=array(30,56);
		$tablaHTML2[5]['alineado']=array('L'.'L');
		  $tablaHTML2[5]['datos']=array('<b>Telefono',$empresa[0]['telefono']);
		if($empresa[0]['sucursal']!='')
		{
		  $tablaHTML2[5]['datos']=array('<b>Telefono',$empresa[0]['telefono_s']);
	    }
		// $tablaHTML2[5]['borde'] = 1;
		$tablaHTML2[5]['altoRow'] = $altoRow;

		$tablaHTML2[6]['medidas']=array(30,56);
		$tablaHTML2[6]['alineado']=array('L','L');
		$tablaHTML2[6]['datos']=array('<b>Email',$empresa[0]['email']);
		if($empresa[0]['sucursal']!='')
		{
		 $tablaHTML2[6]['datos']=array('<b>Email',$empresa[0]['email_s']);
	    }
		// $tablaHTML2[6]['borde'] = 1;
		$tablaHTML2[6]['altoRow'] = $altoRow;

		$tablaHTML2[7]['medidas']=array(50,36);
		$tablaHTML2[7]['alineado']=array('L','L');
		$tablaHTML2[7]['datos']=array('<b>Contribuyente especial Nro',$empresa[0]['contribuyenteEspecial']);
		// $tablaHTML2[7]['borde'] = 1;
		$tablaHTML2[7]['altoRow'] = $altoRow;

		$tablaHTML2[8]['medidas']=array(70,16);
		$tablaHTML2[8]['alineado']=array('L','L');
		$tablaHTML2[8]['datos']=array('<b>OBLIGADO A LLEVAR CONTABILIDAD',$empresa[0]['obligadoContabilidad']);
		// $tablaHTML2[8]['borde'] = 1;
		$tablaHTML2[8]['altoRow'] = $altoRow;

		$tablaHTML2[9]['medidas']=array(86);
		$tablaHTML2[9]['alineado']=array('C');
		$tablaHTML2[9]['datos']=array('****CONTRIBUYENTE REGIMEN MICRO EMPRESA*****');
		// $tablaHTML2[9]['borde'] = 1;
		$tablaHTML2[9]['altoRow'] = $altoRow;

		$tablaHTML2[10]['medidas']=array(86);
		$tablaHTML2[10]['alineado']=array('L');
		$tablaHTML2[10]['datos']=array('<B>AGENTE DE RETENCION SEGUN RESOLUCION NAC-DNCRASC20-0000001');
		// $tablaHTML2[10]['borde'] = 1;
		$tablaHTML2[10]['altoRow'] = $altoRow;

		//----------------------------datos personales---------------------

		$altoRow = 5;
		$tablaHTML3 = array();
		$tablaHTML3[0]['medidas']=array(55,85,50);
		$tablaHTML3[0]['alineado']=array('L','L','L');
		$tablaHTML3[0]['datos']=array('<b>Razon Social / Nombre y Apellido',$datos[0]['nombre'],'<b>Guia de remision');
		// $tablaHTML3[0]['borde'] = 1;
		$tablaHTML3[0]['altoRow'] = $altoRow;

		$tablaHTML3[1]['medidas']=array(23,117,50);
		$tablaHTML3[1]['alineado']=array('L','L','L');
		$tablaHTML3[1]['datos']=array('<b>Telefono:',$datos[0]['telefono'],'');
		// $tablaHTML3[1]['borde'] = 1;
		$tablaHTML3[1]['altoRow'] = $altoRow;

		$tablaHTML3[2]['medidas']=array(20,120,50);
		$tablaHTML3[2]['alineado']=array('L','L','L');
		$tablaHTML3[2]['datos']=array('<b>Email:',$datos[0]['mail'],'');
		// $tablaHTML3[2]['borde'] = 1;
		$tablaHTML3[2]['altoRow'] = $altoRow;

		$tablaHTML3[3]['medidas']=array(45,95,50);
		$tablaHTML3[3]['alineado']=array('L','L','L');
		$tablaHTML3[3]['datos']=array('<b>Identificacion (RUC/C.C):',$datos[0]['ci_ruc'],'');
		// $tablaHTML3[3]['borde'] = 1;
		$tablaHTML3[3]['altoRow'] = $altoRow;

		$tablaHTML3[4]['medidas']=array(30,110,50);
		$tablaHTML3[4]['alineado']=array('L','L','L');
		$tablaHTML3[4]['datos']=array('<b>Fecha Emision',$datos[0]['fecha'],'');
		// $tablaHTML3[4]['borde'] = 1;
		$tablaHTML3[4]['altoRow'] = $altoRow;

		$tablaHTML3[5]['medidas']=array(25,115,50);
		$tablaHTML3[5]['alineado']=array('L','L','L');
		$tablaHTML3[5]['datos']=array('<b>Direccion:',$datos[0]['direccion'],'');
		// $tablaHTML3[5]['borde'] = 1;
		$tablaHTML3[5]['altoRow'] = $altoRow;

		//-------------------------------------lineas de facturas-------------------///

		$altoRow = 5;
		$pos = 1;
		$sub=0;
		$total=0;
		$iva = 0;
		$des = 0;
		$tablaHTML4 = array();
		$tablaHTML4[0]['medidas']=array(25,15,80,27,20,23);
		$tablaHTML4[0]['alineado']=array('L','L','L','R','R','R');
		$tablaHTML4[0]['datos']=array('<b>Cod.Principal','<b>Cant','<b>Descripcion','<b>Precio Unitario','<b>Descuento','<b>Precio Total');
		$tablaHTML4[0]['borde'] = 1;
		$tablaHTML4[0]['altoRow'] = $altoRow;

		foreach ($lineas as $key => $value) {
			// print_r($value);die();
			$tablaHTML4[$pos]['medidas']=$tablaHTML4[0]['medidas'];
		    $tablaHTML4[$pos]['alineado']=$tablaHTML4[0]['alineado'];
		    $tablaHTML4[$pos]['datos']=array($value['referencia'],$value['cantidad'],$value['producto'],$value['precio_uni'],$value['descuento'],$value['total']);
		    $tablaHTML4[$pos]['borde'] = 1;
		    $tablaHTML4[$pos]['altoRow'] = $altoRow;
		    $pos+=1;

		// print_r($value['iva']);die();
		    $sub+=$value['subtotal'];
		    $total+=$value['total'];
		    $iva+= $value['iva'];
		    $des+=$value['descuento'];			
		}


		//-----------------------------fin de lineas -------------------------------------//
		// -----------------------------------tabla totales-------------------------------//

		$altoRow = 5;
		$pos = 1;
		$tablaHTML5 = array();
		$tablaHTML5[0]['medidas']=array(47,23);
		$tablaHTML5[0]['alineado']=array('L','R');
		$tablaHTML5[0]['datos']=array('<b>SUBTOTAL 12%',0);
		$tablaHTML5[0]['borde'] = 1;
		$tablaHTML5[0]['altoRow'] = $altoRow;

		$tablaHTML5[1]['medidas']=$tablaHTML5[0]['medidas'];
		$tablaHTML5[1]['alineado']=$tablaHTML5[0]['alineado'];
		$tablaHTML5[1]['datos']=array('<b>SUB TOTAL 0%',0);
		$tablaHTML5[1]['borde'] = 1;
		$tablaHTML5[1]['altoRow'] = $altoRow;

		$tablaHTML5[2]['medidas']=$tablaHTML5[0]['medidas'];
		$tablaHTML5[2]['alineado']=$tablaHTML5[0]['alineado'];
		$tablaHTML5[2]['datos']=array('<b>SUBTOTAL SIN IMPUESTOS',$sub);
		$tablaHTML5[2]['borde'] = 1;
		$tablaHTML5[2]['altoRow'] = $altoRow;

		$tablaHTML5[3]['medidas']=$tablaHTML5[0]['medidas'];
		$tablaHTML5[3]['alineado']=$tablaHTML5[0]['alineado'];
		$tablaHTML5[3]['datos']=array('<b>DESCUENTOS',$des);
		$tablaHTML5[3]['borde'] = 1;
		$tablaHTML5[3]['altoRow'] = $altoRow;

		$tablaHTML5[4]['medidas']=$tablaHTML5[0]['medidas'];
		$tablaHTML5[4]['alineado']=$tablaHTML5[0]['alineado'];
		$tablaHTML5[4]['datos']=array('<b>IVA 12%',$iva);
		$tablaHTML5[4]['borde'] = 1;
		$tablaHTML5[4]['altoRow'] = $altoRow;

		$tablaHTML5[5]['medidas']=$tablaHTML5[0]['medidas'];
		$tablaHTML5[5]['alineado']=$tablaHTML5[0]['alineado'];
		$tablaHTML5[5]['datos']=array('<b>VALOR TOTAL',$total);
		$tablaHTML5[5]['borde'] = 1;
		$tablaHTML5[5]['altoRow'] = $altoRow;

		//-------------------------fin de totales-------------------------//
		//--------------------------forma de pago--------------------------//
		$altoRow = 5;
		$pos = 1;
		$tablaHTML6 = array();
		$tablaHTML6[0]['medidas']=array(47,23);
		$tablaHTML6[0]['alineado']=array('C','R');
		$tablaHTML6[0]['datos']=array('<b>FORMA DE PAGO','VALOR');
		$tablaHTML6[0]['borde'] = 1;
		$tablaHTML6[0]['altoRow'] = $altoRow;

		$doc = $this->factura_pdf->factura($tablaHTML,$tablaHTML2,$tablaHTML3,$tablaHTML4,$tablaHTML5,$tablaHTML6,$logo,$datos[0]['Autorizacion'],$mostrar,$descargar,$datos[0]['num_factura']);
		// print_r($doc);die(); 
		return $doc;
	}

	function piezas_compradas($datos=false,$cabecera=false)
	{
		// print_r($cabecera);die();
		$tablaHTML = array();
		$tablaHTML[0]['medidas']=array(18,120);
		$tablaHTML[0]['alineado']=array('L','L');
		$tablaHTML[0]['datos']=array('<b>Cliente:',$cabecera[0]['nombre']);
		$tablaHTML[0]['altoRow'] = 5;
		$tablaHTML[0]['borde'] = 'B';

		$tablaHTML[1]['medidas']=array(25,113);
		$tablaHTML[1]['alineado']=array('L','L');
		$tablaHTML[1]['datos']=array('<b>Dir. Domicilio:',$cabecera[0]['direccion']);
		$tablaHTML[1]['altoRow'] = 5;
		$tablaHTML[1]['borde'] = 'B';

		$tablaHTML[2]['medidas']=array(25,54,20,39);
		$tablaHTML[2]['alineado']=array('L','L','L','L');
		$tablaHTML[2]['datos']=array('<b>Empresa:',$cabecera[0]['nombre_empresa'],'<b>Email:',$cabecera[0]['email']);
		$tablaHTML[2]['altoRow'] = 5;
		$tablaHTML[2]['borde'] = 'B';

		$tablaHTML[3]['medidas']=array(28,110);
		$tablaHTML[3]['alineado']=array('L','L');
		$tablaHTML[3]['datos']=array('<b>dir. Empresa:','');
		$tablaHTML[3]['altoRow'] = 5;
		$tablaHTML[3]['borde'] = 'B';

		 // -----------------TABLA DE TELEFONOS-----------------------


		$tablaHTML2 = array();
		$tablaHTML2[0]['medidas']=array(18,35);
		$tablaHTML2[0]['alineado']=array('L');
		$tablaHTML2[0]['datos']=array(utf8_decode('<b>Cédula'),$cabecera[0]['ci_ruc']);
		$tablaHTML2[0]['altoRow'] = 5;
		$tablaHTML2[0]['borde'] = 'B';


		$tablaHTML2[1]['medidas']=array(20,33);
		$tablaHTML2[1]['alineado']=array('L','L');
		$tablaHTML2[1]['datos']=array('<b>Tel. Dom:',$cabecera[0]['telefono']);
		$tablaHTML2[1]['altoRow'] = 5;
		$tablaHTML2[1]['borde'] = 'B';

		$tablaHTML2[2]['medidas']=array(25,28);
		$tablaHTML2[2]['alineado']=array('L','L');
		$tablaHTML2[2]['datos']=array('<b>Tel. Empresa:','');
		$tablaHTML2[2]['altoRow'] = 5;
		$tablaHTML2[2]['borde'] = 'B';

		$tablaHTML2[3]['medidas']=array(23,30);
		$tablaHTML2[3]['alineado']=array('L','L');
		$tablaHTML2[3]['datos']=array('<b>Tel. Celular:','');
		$tablaHTML2[3]['altoRow'] = 5;
		$tablaHTML2[3]['borde'] = 'B';

		$tablaHTML2[4]['medidas']=array(33,20);
		$tablaHTML2[4]['alineado']=array('L','L');
		$tablaHTML2[4]['datos']=array(utf8_decode('<b>Fecha Cumpleaños:'),'');
		$tablaHTML2[4]['altoRow'] = 5;
		$tablaHTML2[4]['borde'] = 'B';

		$tablaHTML2[5]['medidas']=array(33,20);
		$tablaHTML2[5]['alineado']=array('L','L');
		$tablaHTML2[5]['datos']=array('<b>Fecha Aniversario:','');
		$tablaHTML2[5]['altoRow'] = 5;
		$tablaHTML2[5]['borde'] = 'B';

		// $tablaHTML2[6]['medidas']=array(190);
		// $tablaHTML2[6]['alineado']=array('C');
		// $tablaHTML2[6]['datos']=array('<b>PIEZAS COMPRADAS');
		// $tablaHTML2[6]['altoRow'] = 7;
		// $tablaHTML2[6]['borde'] = 1;
		// $tablaHTML2[6]['color'] ='si';

		
		

		//-------------------------------------lineas de facturas-------------------///

		$altoRow = 5;
		$pos = 1;
		$sub=0;
		$total=0;
		$iva = 0;
		$des = 0;
		$tablaHTML4 = array();
		$tablaHTML4[0]['medidas']=array(10,25,60,25,17);
		$tablaHTML4[0]['alineado']=array('C','L','L','L','R');
		$tablaHTML4[0]['datos']=array('No','<b>FECHA','<b>ITEM','<b>CODIGO','<b>VALOR');
		$tablaHTML4[0]['borde'] = 1;
		$tablaHTML4[0]['altoRow'] = $altoRow;
		$tablaHTML4[0]['color']='si';
		$con = 1;
		foreach ($datos as $key => $value) {
			// print_r($value);die()
			$tablaHTML4[$pos]['medidas']=$tablaHTML4[0]['medidas'];
		    $tablaHTML4[$pos]['alineado']=$tablaHTML4[0]['alineado'];
		    $tablaHTML4[$pos]['datos']=array($con,'2021-05-20',$value['producto'],$value['codigo'],$value['total']);
		    $tablaHTML4[$pos]['borde'] = 1;
		    $tablaHTML4[$pos]['altoRow'] = $altoRow;
		    $pos+=1;

		    $sub+=$value['subtotal'];
		    $total+=$value['total'];
		    $iva+= $value['iva'];
		    $des+=$value['descuento'];
		    $con+=1;			
		}

		//-----------------------------fin de lineas -------------------------------------//
		
		//--------------------------forma de pago--------------------------//
		$altoRow = 5;
		$pos = 1;
		$tablaHTML6 = array();
		$tablaHTML6[0]['medidas']=array(47,23);
		$tablaHTML6[0]['alineado']=array('C','R');
		$tablaHTML6[0]['datos']=array('<b>FORMA DE PAGO','VALOR');
		$tablaHTML6[0]['borde'] = 1;
		$tablaHTML6[0]['altoRow'] = $altoRow;

		$this->factura_pdf->piezas_compradas($tablaHTML,$tablaHTML2,$tablaHTML4,$tablaHTML6);
	}

	function reporte_trabajo($datos,$estado)
	{
		// print_r($datos);
		// print_r($estado);die();
		$tablaHTML = array();
		
		$tablaHTML[0]['medidas']=array(40,57,40,58);
		$tablaHTML[0]['alineado']=array('L','L','L','L');
		$tablaHTML[0]['datos']=array('<b>CODIGO DE JOLLA',$datos[0]['cod'],'<b>FECHA DE INGRESO:',$datos[0]['fecha']->format('Y-m-d'));
		$tablaHTML[0]['borde'] = 1;
		

		$tablaHTML[1]['medidas']=array(50,145);
		$tablaHTML[1]['alineado']=array('L','L');
		$tablaHTML[1]['datos']=array('<B>NOMBRE DEL CLIENTE:',$datos[0]['cliente']);
		$tablaHTML[1]['borde'] = 1;
		// $tablaHTML[0]['estilo']='BI';

		$tablaHTML[2]['medidas']=array(30,165);
		$tablaHTML[2]['alineado']=$tablaHTML[1]['alineado'];
		$tablaHTML[2]['datos']=array('<B>JOLLA:',$datos[0]['nombre']);
		$tablaHTML[2]['borde'] = 1;
		// $tablaHTML[1]['estilo']='I';

		// $tablaHTML[4]['estilo']='BI';

		$tablaHTML[3]['medidas']=array(35,55,30,40,20,15);
		$tablaHTML[3]['alineado']=array('L','L','L','L','L','L');
		$tablaHTML[3]['datos']=array('<b>TIPO DE JOLLA',$datos[0]['tipo'],'<B>MATERIAL',$datos[0]['material'],'<b>PESO',$datos[0]['peso'].'Kg');
		$tablaHTML[3]['borde'] = 1;
		// $tablaHTML[3]['estilo']='I';


		$tablaHTML[4]['medidas']=array(195);
		$tablaHTML[4]['alineado']=array('L');
		$tablaHTML[4]['datos']=array('TRABAJO A REALIZAR:');
		$tablaHTML[4]['estilo']='BI';
		$tablaHTML[4]['borde'] = 1;

		$tablaHTML[5]['medidas']=$tablaHTML[4]['medidas'];
		$tablaHTML[5]['alineado']=$tablaHTML[4]['alineado'];
		$tablaHTML[5]['datos']=array($datos[0]['trabajo']);
		$tablaHTML[5]['estilo']='I';
		$tablaHTML[5]['borde'] = 1;

		$tablaHTML[6]['medidas']=array(195);
		$tablaHTML[6]['alineado']=array('L');
		$tablaHTML[6]['datos']=array('PROCESOS REALIZADOS:');
		$tablaHTML[6]['estilo']='BI';
		// $tablaHTML[6]['borde'] = 1;

		$co = 7;
		foreach ($estado as $key => $value) {
			$tablaHTML[$co]['medidas']=array(40,40,115);
		    $tablaHTML[$co]['alineado']=array('L','L','L');
		    $tablaHTML[$co]['datos']=array($value['fecha']->format('Y-m-d'),$value['estado'],$value['observacion']);
		    $tablaHTML[$co]['estilo']='I';	
		    $tablaHTML[$co]['borde'] = 'B';
		    $co+=1;		
		}

		// $tablaHTML[9]['medidas']=$tablaHTML[0]['medidas'];
		// $tablaHTML[9]['alineado']=$tablaHTML[0]['alineado'];
		// $tablaHTML[9]['datos']=array($datos[0]['trabajo']);
		// $tablaHTML[9]['estilo']='I';

		// $tablaHTML[8]['medidas']=array(195);
		// $tablaHTML[8]['alineado']=array('L');
		// $tablaHTML[8]['datos']=array('TRABAJO REALIZADO AL INICIAR:');
		// $tablaHTML[8]['estilo']='BI';

		// $tablaHTML[9]['medidas']=$tablaHTML[0]['medidas'];
		// $tablaHTML[9]['alineado']=$tablaHTML[0]['alineado'];
		// $tablaHTML[9]['datos']=array('obseservacion de prueba');
		// $tablaHTML[9]['estilo']='I';


		$this->pdf->cabecera_reporte_MC($titulo='INFORME DE TRABAJO REALIZADO',$tablaHTML,$contenido=false,$image=false,false,false,$sizetable=9,true,$sal_hea_body=30);
	}

	function detalle_de_transaccion($datos)
	{
		$tablaHTML = array();
// 		Codigo	24
// Fecha	03/09/12
// Descripcion	COMPRA PROVEEDOR NRO 15
// Tipo Movimiento	INGRESO BODEGA
// USUARIO	mpaz
// USUARIO	Monica Paz
// Bodega	CARMEN ELENA PEÑA
// Transferencia Codigo	0
// Transferencia Descripcion	

// print_r($datos['documento_datos']);die();

		
		$tablaHTML[0]['medidas']=array(50,50);
		$tablaHTML[0]['alineado']=array('L','L');
		$tablaHTML[0]['datos']=array('<b>CODIGO DE JOLLA','');
		// $tablaHTML[0]['borde'] = 1;
		$tablaHTML[1]['medidas']=array(40,50);
		$tablaHTML[1]['alineado']=array('L','L');
		$tablaHTML[1]['datos']=array('<b>Fecha',$datos['documento_datos'][0]['fecha_factura']->format('Y-m-d'));
		// $tablaHTML[0]['borde'] = 1;
		$tablaHTML[2]['medidas']=array(40,200);
		$tablaHTML[2]['alineado']=array('L','L');
		$tablaHTML[2]['datos']=array('<b>Descripcion',$datos['documento_datos'][0]['documento'].' '.$datos['documento_datos'][0]['nombre']);
		// $tablaHTML[0]['borde'] = 1;
		$tablaHTML[3]['medidas']=array(40,50);
		$tablaHTML[3]['alineado']=array('L','L');
		$tablaHTML[3]['datos']=array('<b>Tipo de movimiento',$datos['documento_datos'][0]['detalle_transaccion']);
		// $tablaHTML[0]['borde'] = 1;
		$tablaHTML[4]['medidas']=array(40,200);
		$tablaHTML[4]['alineado']=array('L','L');
		$tablaHTML[4]['datos']=array('<b>usuario',$_SESSION['INICIO']['USUARIO_LOG']);
		// $tablaHTML[0]['borde'] = 1;
		$tablaHTML[5]['medidas']=array(40,70,40,70);
		$tablaHTML[5]['alineado']=array('L','L','L','L');
		$tablaHTML[5]['datos']=array('<b>Bodega salida',$datos['documento_datos'][0]['salida'],'<b>Bodega Entrada',$datos['documento_datos'][0]['entrada']);
		// $tablaHTML[0]['borde'] = 1;
		$tablaHTML[6]['medidas']=array(40,40,20,50,20,20);
		$tablaHTML[6]['alineado']=array('L','L','L','L','R','R');
		$tablaHTML[6]['datos']=array('CODIGO DE JOYA','NOTA','PESO','FOTO','PVP','Precio');
		$tablaHTML[6]['borde'] = 1;
		$tablaHTML[6]['estilo'] = 'B';

		$con = 7;

// print_r($datos['lines_documentos']);die();
		foreach ($datos['lines_documentos'] as $key => $value) {
			$tablaHTML[$con]['medidas']=$tablaHTML[6]['medidas'];
		    $tablaHTML[$con]['alineado']=$tablaHTML[6]['alineado'];
		    $tablaHTML[$con]['datos']=array($value['codigo_ref'],$value['producto'],$value['peso'],$value['foto'],$value['precio_uni'],$value['precio_uni']);
		    $tablaHTML[$con]['borde'] = 1;
		    $tablaHTML[$con]['tipo'] = array('CON_IMAGEN',array('4','2')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;

		    $tablaHTML[$con]['altoRow'] = 40;
		    $con=$con+1;

		}
		

		$this->pdf->cabecera_reporte_MC($titulo='TRANSACCION REALIZADA',$tablaHTML,$contenido=false,$image=false,false,false,$sizetable=10,true,$sal_hea_body=30);

	}

	function orden_trabajo_nuevo($cabecera,$detalle,$detalle_di = false)
	{
		 if($cabecera[0]['boceto']==0)
		 {
		 	$titulo='Orden de trabajo Producto terminado';
		 }
		 else
		 {
		 	$titulo= utf8_decode('Orden de trabajo (Nuevo Diseño)');
		 }
  	// print_r($detalle_di);die();
		$tablaHTML[0]['medidas']=array(19,30,30,50,33,25);
		$tablaHTML[0]['alineado']=array('L','L','L','L','L','L');
		$tablaHTML[0]['datos']=array('<b>CODIGO',$cabecera[0]['codigo'],'<b>RESPONSABLE',$cabecera[0]['Encargado'],'<b>FECHA INGRESO',$cabecera[0]['fecha_orden']->format('Y-m-d'));
		$tablaHTML[0]['altoRow'] = 5;

		$tablaHTML[0]['borde']=1;
		$tablaHTML[1]['medidas']=array(19,30,30,50,33,25);
		$tablaHTML[1]['alineado']=array('L','L','L','L','L','L');
		$tablaHTML[1]['datos']=array('<b>DESDE',$cabecera[0]['nombre_punto'],'<b>PARA MAESTRO',$cabecera[0]['maestro'],'<b>FECHA ENTREGA',$cabecera[0]['fecha_exp']->format('Y-m-d'));
		$tablaHTML[1]['borde']=1;
		$tablaHTML[1]['altoRow'] = 5;

		if($cabecera[0]['boceto']==1)
		{
		$tablaHTML[2]['medidas']=array(25,68,25,69);
		$tablaHTML[2]['alineado']=array('L','L','L','L');
		$tablaHTML[2]['datos']=array('<b>MODELO',$detalle_di[0]['modelo'],'<b>MATERIAL',$detalle_di[0]['nombre_material']);
		$tablaHTML[2]['borde']=1;
		$tablaHTML[2]['altoRow'] = 5;

		$tablaHTML[3]['medidas']=array(25,25,35,102);
		$tablaHTML[3]['alineado']=array('L','L','L','L');
		$tablaHTML[3]['datos']=array('<b>MEDIA',$detalle_di[0]['medida'],'<b>OBSERVACIONES',$detalle_di[0]['observacion']);
		$tablaHTML[3]['borde']=1;
		$tablaHTML[3]['altoRow'] = 5;

		$tablaHTML[4]['medidas']=array(187);
		$tablaHTML[4]['alineado']=array('L');
		$tablaHTML[4]['datos']=array('');
		

		$tablaHTML[5]['medidas']=array(93,94,);
		$tablaHTML[5]['alineado']=array('L','L');
		$tablaHTML[5]['datos']=array($detalle_di[0]['foto1'],$detalle_di[0]['foto2']);
		$tablaHTML[5]['borde']=1;
		$tablaHTML[5]['tipo'] = array('CON_IMAGEN',array('1','1')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;
		$tablaHTML[5]['altoRow'] = 85;

		if($detalle_di[0]['foto3']!='' || $detalle_di[0]['foto4']!='')
		{
		   $tablaHTML[6]['medidas']=array(93,94,);
		   $tablaHTML[6]['alineado']=array('L','L');
		   $tablaHTML[6]['datos']=array($detalle_di[0]['foto3'],$detalle_di[0]['foto4']);
		   $tablaHTML[6]['borde']=1;
		   $tablaHTML[6]['tipo'] = array('CON_IMAGEN',array('1','1')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;
		   $tablaHTML[6]['altoRow'] = 85;
	    }

	    if($detalle_di[0]['foto5']!='' || $detalle_di[0]['foto6']!='')
		{
		   $tablaHTML[7]['medidas']=array(93,94,);
		   $tablaHTML[7]['alineado']=array('L','L');
		   $tablaHTML[7]['datos']=array($detalle_di[0]['foto6'],$detalle_di[0]['foto6']);
		   $tablaHTML[7]['borde']=1;
		   $tablaHTML[7]['tipo'] = array('CON_IMAGEN',array('1','1')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;
		   $tablaHTML[7]['altoRow'] = 94;
	    } 


	    }



		$pos =count($tablaHTML);
		foreach ($detalle as $key => $value) {
			$tablaHTML[$pos]['medidas']=array(187);
		    $tablaHTML[$pos]['alineado']=array('L');
		    $tablaHTML[$pos]['datos']=array('<b>PRODUCTO:'.$value['producto']);
		    $tablaHTML[$pos]['borde']=1;
		    $tablaHTML[$pos]['altoRow'] = 8;
		    $pos+=1;
		    $tablaHTML[$pos]['medidas']=array(93,94);
		    $tablaHTML[$pos]['alineado']=array('L','L');
		    $tablaHTML[$pos]['datos']=array('<b>CODIGO REF: '.$value['codigo_ref'],'<B>OBSERVACIONES');
		    $tablaHTML[$pos]['borde']=1;
		    $tablaHTML[$pos]['altoRow'] = 8;
		    $pos+=1;
			// print_r($value);die();
			$tablaHTML[$pos]['medidas']=array(93,94);
		    $tablaHTML[$pos]['alineado']=array('L','L');
		    $tablaHTML[$pos]['datos']=array($value['foto'],$value['linea_detalle']);
		    $tablaHTML[$pos]['tipo'] = array('CON_IMAGEN',array('1','1')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;

		    // $tablaHTML[0]['estilo']='BI';
		    $tablaHTML[$pos]['borde'] = '1';
		    $tablaHTML[$pos]['altoRow'] = 80;

		    $pos+=1;
			
		}



		$this->pdf->cabecera_reporte_MC($titulo,$tablaHTML,$contenido=false,$image=false,false,false,$sizetable=false,true);
	}

	function trabajo_joya_nuevo($cabecera,$detalle)
	{
		 
  	   // print_r($cabecera);
       // print_r($detalle);
  	   // die();
	   $tablaHTML[0]['medidas']=array(19,30,30,50,33,25);
		$tablaHTML[0]['alineado']=array('L','L','L','L','L','L');
		$tablaHTML[0]['datos']=array('<b>CODIGO',$cabecera[0]['referencia_producto'],'<b>CLIENTE',$cabecera[0]['nombre'],'<b>FECHA INGRESO',$cabecera[0]['fecha_ingreso']->format('Y-m-d'));
		$tablaHTML[0]['borde']=1;
		$tablaHTML[0]['altoRow'] = 5;

		$tablaHTML[1]['medidas']=array(25,30,25,49,33,25);
		$tablaHTML[1]['alineado']=array('L','L','L','L','L','L');
		$tablaHTML[1]['datos']=array('<b>PUNTO VENTA',$cabecera[0]['nombre_punto'],'<b>PARA BODEGA',$cabecera[0]['detalle_bodega'],'<b>FECHA ENTREGA','');
		$tablaHTML[1]['borde']=1;
		$tablaHTML[1]['altoRow'] = 5;

		$tablaHTML[2]['medidas']=array(25,68,25,69);
		$tablaHTML[2]['alineado']=array('L','L','L','L');
		$tablaHTML[2]['datos']=array('<b>MODELO',$cabecera[0]['detalle_producto'],'<b>MATERIAL',$cabecera[0]['detalle_material']);
		$tablaHTML[2]['borde']=1;
		$tablaHTML[2]['altoRow'] = 5;

		$tablaHTML[3]['medidas']=array(25,25,35,102);
		$tablaHTML[3]['alineado']=array('L','L','L','L');
		$tablaHTML[3]['datos']=array('<b>ESTADO',$cabecera[0]['detalle_estado'],'<b>OBSERVACIONES',$cabecera[0]['descripcion_trabajo']);
		$tablaHTML[3]['borde']=1;
		$tablaHTML[3]['altoRow'] = 5;

		$tablaHTML[4]['medidas']=array(187);
		$tablaHTML[4]['alineado']=array('L');
		$tablaHTML[4]['datos']=array('');

		$tablaHTML[5]['medidas']=array(93,94,);
		$tablaHTML[5]['alineado']=array('L','L');
		$tablaHTML[5]['datos']=array($cabecera[0]['foto_producto'],$cabecera[0]['foto1']);
		$tablaHTML[5]['borde']=1;
		$tablaHTML[5]['tipo'] = array('CON_IMAGEN',array('1','1')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;
		$tablaHTML[5]['altoRow'] = 85;

		if($cabecera[0]['foto2']!='' || $cabecera[0]['foto3']!='' )
		{

		$tablaHTML[6]['medidas']=array(93,94,);
		$tablaHTML[6]['alineado']=array('L','L');
		$tablaHTML[6]['datos']=array($cabecera[0]['foto2'],$cabecera[0]['foto3']);
		$tablaHTML[6]['borde']=1;
		$tablaHTML[6]['tipo'] = array('CON_IMAGEN',array('1','1')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;
		$tablaHTML[6]['altoRow'] = 85;

		}
		if($cabecera[0]['foto4']!='' || $cabecera[0]['foto5']!='' )
		{

		$tablaHTML[7]['medidas']=array(93,94,);
		$tablaHTML[7]['alineado']=array('L','L');
		$tablaHTML[7]['datos']=array($cabecera[0]['foto4'],$cabecera[0]['foto5']);
		$tablaHTML[7]['borde']=1;
		$tablaHTML[7]['tipo'] = array('CON_IMAGEN',array('1','1')); // SEGUNDO PARAMETRO LA POSICION DE LA IMAGEN;
		$tablaHTML[7]['altoRow'] = 85;

		}
		
		$this->pdf->cabecera_reporte_MC('Trabajo en joyas',$tablaHTML,$contenido=false,$image=false,false,false,$sizetable=7,true);
	}

	function generar_ceros($num,$long)
	{
		$num_l = strlen($num);
		$num_C = $long-$num_l;
		$ceros = str_repeat('0', $num_C);
		return $ceros.$num;

	}
}
?>