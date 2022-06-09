<?php

if(!class_exists('PDF_MC_Table'))
{
	require('PDF_MC_Table.php');
}
if (!class_exists('FPDF')) {
    //$mi_clase = new MiClase();
   require('fpdf.php');
}
// require('PDF_EAN13.php');


//include(dirname(__DIR__,2)."/php/db/db.php");
//echo dirname(__DIR__,1);

/**
 * 
 */


class factura_pdf
{
	private $pdf;
	private $conn;
	private $header_cuerpo;

	function __construct()
	{
		$this->pdftable = new PDF_MC1();
		$this->pdftableA5 = new PDF_MC1('L','mm','A5');
		$this->fechafin='';
		$this->fechaini='';
		$this->sizetable ='12';
		
	}

	function factura($tablaHTML,$tablaHTML2,$tablaHTML3,$tablaHTML4,$tablaHTML5,$tablaHTML6,$logo,$barcode=false,$mostrar = true,$descargar=false,$numfactura)
	{
		if($barcode==false)
		{
			$barcode = '123456789123456789123456789'.$numfactura;
		}

		 $this->pdftable->AddPage();

       
		   	$src = dirname(__DIR__,2).'/img/empresa/'.$logo; 
		   	if(!file_exists($src))
		   	{		   		
		   		$src = dirname(__DIR__,2).'/img/empresa/logo.png'; 

		   	}

		  $pos_x = 100;
		 $this->pdftable->Image($src,10,10,65,50);
		 $this->pdftable->SetXY($pos_x,10);
		  $sizetable = 9;

		    $this->pdftable->SetFont('Arial','',$sizetable);
		    foreach ($tablaHTML as $key => $value){
		    	$altoRow = 10;
		    	if(isset($value['estilo']) && $value['estilo']!='')
		    	{
		    		$this->pdftable->SetFont('Arial',$value['estilo'],$sizetable);
		    		$estiloRow = $value['estilo'];
		    	}else
		    	{
		    		$this->pdftable->SetFont('Arial','',$sizetable);
		    		$estiloRow ='';
		    	}
		    	if(isset($value['borde']) && $value['borde']!='0')
		    	{
		    		$borde=$value['borde'];
		    	}else
		    	{
		    		$borde =0;
		    	}
		    	// print_r($value['altoRow']);die();
		    	if(isset($value['altoRow']))
		    	{
		    		$altoRow = $value['altoRow'];
		    	}

		    //print_r($value['medida']);
		       $this->pdftable->SetWidths($value['medidas']);
			   $this->pdftable->SetAligns($value['alineado']);
			   //print_r($value['datos']);
			   $arr= $value['datos'];
			   $this->pdftable->Row($arr,$altoRow,$borde,$estiloRow);	
		       $this->pdftable->SetXY($this->pdftable->GETX()+$pos_x-10,$this->pdftable->GETY());
		    }
		    $this->pdftable->i25($this->pdftable->GETX()+3,$this->pdftable->GETY(),$barcode,0.60,10);
		    $y_fin = $this->pdftable->GETY()+5;
		    $this->pdftable->SetXY($pos_x,10);
		    $this->pdftable->Cell(100,$y_fin,'', 1);
		    //-------------------fin de cuadro de factura-----------//

		    $pos2_x = 10;
		    $pos2_y = 65; 
		    $cell_y = 0;
		    $this->pdftable->SetXY($pos2_x,$pos2_y);
		    $this->pdftable->SetFont('Arial','',$sizetable);
		    foreach ($tablaHTML2 as $key => $value){
		    	$altoRow = 10;
		    	if(isset($value['estilo']) && $value['estilo']!='')
		    	{
		    		$this->pdftable->SetFont('Arial',$value['estilo'],$sizetable);
		    		$estiloRow = $value['estilo'];
		    	}else
		    	{
		    		$this->pdftable->SetFont('Arial','',$sizetable);
		    		$estiloRow ='';
		    	}
		    	if(isset($value['borde']) && $value['borde']!='0')
		    	{
		    		$borde=$value['borde'];
		    	}else
		    	{
		    		$borde =0;
		    	}
		    	// print_r($value['altoRow']);die();
		    	if(isset($value['altoRow']))
		    	{
		    		$altoRow = $value['altoRow'];
		    	}

		    //print_r($value['medida']);
		       $this->pdftable->SetWidths($value['medidas']);
			   $this->pdftable->SetAligns($value['alineado']);
			   //print_r($value['datos']);
			   $arr= $value['datos'];
			   $this->pdftable->Row($arr,$altoRow,$borde,$estiloRow);	
		       $this->pdftable->SetXY($this->pdftable->GETX()+$pos2_x-10,$this->pdftable->GETY());
		       $cell_y = $this->pdftable->GETY();
		    }
		    // print_r($cell_y);die();
		     $this->pdftable->SetXY($pos2_x,$pos2_y);
		     $this->pdftable->Cell(86,$cell_y-$pos2_y,'', 1);

		     //--------------------------------------------datos personales ---------------------



		    $pos3_x = $pos2_x;
		    $pos3_y = $cell_y+3; 
		    $cell_y = 0;
		    $this->pdftable->SetXY($pos3_x,$pos3_y);
		    $this->pdftable->SetFont('Arial','',$sizetable);
		    foreach ($tablaHTML3 as $key => $value){
		    	$altoRow = 10;
		    	if(isset($value['estilo']) && $value['estilo']!='')
		    	{
		    		$this->pdftable->SetFont('Arial',$value['estilo'],$sizetable);
		    		$estiloRow = $value['estilo'];
		    	}else
		    	{
		    		$this->pdftable->SetFont('Arial','',$sizetable);
		    		$estiloRow ='';
		    	}
		    	if(isset($value['borde']) && $value['borde']!='0')
		    	{
		    		$borde=$value['borde'];
		    	}else
		    	{
		    		$borde =0;
		    	}
		    	// print_r($value['altoRow']);die();
		    	if(isset($value['altoRow']))
		    	{
		    		$altoRow = $value['altoRow'];
		    	}

		    //print_r($value['medida']);
		       $this->pdftable->SetWidths($value['medidas']);
			   $this->pdftable->SetAligns($value['alineado']);
			   //print_r($value['datos']);
			   $arr= $value['datos'];
			   $this->pdftable->Row($arr,$altoRow,$borde,$estiloRow);	
		       $this->pdftable->SetXY($this->pdftable->GETX()+$pos3_x-10,$this->pdftable->GETY());
		       $cell_y = $this->pdftable->GETY();
		    }
		    // print_r($cell_y);die();
		     $this->pdftable->SetXY($pos3_x,$pos3_y);
		     $this->pdftable->Cell(140,$cell_y-$pos3_y,'', 1);
		     $this->pdftable->SetXY(140+$pos3_x,$pos3_y);
		     $this->pdftable->Cell(50,$cell_y-$pos3_y,'', 1);

		     //-----------------------fin de datos personales-----------------------//
		     //-------------------------lineas factura --------------------------//


		    $pos4_x = $pos2_x;
		    $pos4_y = $cell_y+3; 
		    $cell_y = 0;
		    $sizetable = 7;
		    $this->pdftable->SetXY($pos4_x,$pos4_y);
		    $this->pdftable->SetFont('Arial','',$sizetable);
		    foreach ($tablaHTML4 as $key => $value){
		    	$altoRow = 10;
		    	if(isset($value['estilo']) && $value['estilo']!='')
		    	{
		    		$this->pdftable->SetFont('Arial',$value['estilo'],$sizetable);
		    		$estiloRow = $value['estilo'];
		    	}else
		    	{
		    		$this->pdftable->SetFont('Arial','',$sizetable);
		    		$estiloRow ='';
		    	}
		    	if(isset($value['borde']) && $value['borde']!='0')
		    	{
		    		$borde=$value['borde'];
		    	}else
		    	{
		    		$borde =0;
		    	}
		    	// print_r($value['altoRow']);die();
		    	if(isset($value['altoRow']))
		    	{
		    		$altoRow = $value['altoRow'];
		    	}

		    //print_r($value['medida']);
		       $this->pdftable->SetWidths($value['medidas']);
			   $this->pdftable->SetAligns($value['alineado']);
			   //print_r($value['datos']);
			   $arr= $value['datos'];
			   $this->pdftable->Row($arr,$altoRow,$borde,$estiloRow);	
		       $this->pdftable->SetXY($this->pdftable->GETX()+$pos4_x-10,$this->pdftable->GETY());
		       $cell_y = $this->pdftable->GETY();
		    }


		//-----------------------------fin de lineas -------------------------------------//
		// -----------------------------------tabla totales-------------------------------//

		    $pos5_x = $pos2_x+120;
		    $pos5_y = $cell_y+3; 
		    $cell_y = 0;
		    $sizetable = 8;
		    $this->pdftable->SetXY($pos5_x,$pos5_y);
		    $this->pdftable->SetFont('Arial','',$sizetable);
		    foreach ($tablaHTML5 as $key => $value){
		    	$altoRow = 10;
		    	if(isset($value['estilo']) && $value['estilo']!='')
		    	{
		    		$this->pdftable->SetFont('Arial',$value['estilo'],$sizetable);
		    		$estiloRow = $value['estilo'];
		    	}else
		    	{
		    		$this->pdftable->SetFont('Arial','',$sizetable);
		    		$estiloRow ='';
		    	}
		    	if(isset($value['borde']) && $value['borde']!='0')
		    	{
		    		$borde=$value['borde'];
		    	}else
		    	{
		    		$borde =0;
		    	}
		    	// print_r($value['altoRow']);die();
		    	if(isset($value['altoRow']))
		    	{
		    		$altoRow = $value['altoRow'];
		    	}

		    //print_r($value['medida']);
		       $this->pdftable->SetWidths($value['medidas']);
			   $this->pdftable->SetAligns($value['alineado']);
			   //print_r($value['datos']);
			   $arr= $value['datos'];
			   $this->pdftable->Row($arr,$altoRow,$borde,$estiloRow);	
		       $this->pdftable->SetXY($this->pdftable->GETX()+$pos5_x-10,$this->pdftable->GETY());
		       $cell_y = $this->pdftable->GETY();
		    }

		    // -----------------------------------tabla totales-------------------------------//

		    $pos6_x = $pos2_x;
		    $pos6_y = $pos5_y; 
		    $cell_y = 0;
		    $sizetable = 8;
		    $this->pdftable->SetXY($pos6_x,$pos6_y);
		    $this->pdftable->SetFont('Arial','',$sizetable);
		    foreach ($tablaHTML6 as $key => $value){
		    	$altoRow = 10;
		    	if(isset($value['estilo']) && $value['estilo']!='')
		    	{
		    		$this->pdftable->SetFont('Arial',$value['estilo'],$sizetable);
		    		$estiloRow = $value['estilo'];
		    	}else
		    	{
		    		$this->pdftable->SetFont('Arial','',$sizetable);
		    		$estiloRow ='';
		    	}
		    	if(isset($value['borde']) && $value['borde']!='0')
		    	{
		    		$borde=$value['borde'];
		    	}else
		    	{
		    		$borde =0;
		    	}
		    	// print_r($value['altoRow']);die();
		    	if(isset($value['altoRow']))
		    	{
		    		$altoRow = $value['altoRow'];
		    	}

		    //print_r($value['medida']);
		       $this->pdftable->SetWidths($value['medidas']);
			   $this->pdftable->SetAligns($value['alineado']);
			   //print_r($value['datos']);
			   $arr= $value['datos'];
			   $this->pdftable->Row($arr,$altoRow,$borde,$estiloRow);	
		       $this->pdftable->SetXY($this->pdftable->GETX()+$pos6_x-10,$this->pdftable->GETY());
		       $cell_y = $this->pdftable->GETY();
		    }

		
		 if($mostrar==true)
	       {
		    $this->pdftable->Output();

	       }else
	       {
		     $this->pdftable->Output('F',dirname(__DIR__,2).'/TEMP/'.$barcode.'.pdf');
	       }

	      if($descargar)
	      {
		    return  $barcode.'.pdf';
	      }

	}
  }


class PDF_MC1 extends PDF_MC_Table
{
	public $fechaini;
	public $fechafin;
	public $titulo;
	public $salto_header_cuerpo;
	public $orientacion;

    function Header()
    {
    	
    }

    function footer()
    {
    	
    }
}

?>