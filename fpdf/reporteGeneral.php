<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $this->Image('logo.JPG', 20, 5, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Times', 'BU', 18); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(120); // Movernos a la derecha
      $this->SetTextColor(11, 12, 19); //color
      //creamos una celda o fila
      $this->Cell(30, 15, utf8_decode('UNIDAD EDUCATIVA SIMÓN BOLIVAR'), 0, 0, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(30); // Salto de línea
      $this->SetTextColor(50); //color

   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
   }
}



$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$pdf->SetFont('Times', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde


include_once "../bd.php"; //llamamos a la conexion BD

      $sentencia = $conexion->prepare("SELECT eq.*, ct.nombre as 'categoria', es.nombre as 'estadoequipo'  FROM tbl_equipos eq
                                INNER JOIN tbl_categorias ct
                                ON eq.idcategoria=ct.ID
                                INNER JOIN tbl_estado es
                                ON eq.idestado=es.ID 
      ");
      $sentencia->execute();
      $lista_equipos= $sentencia->fetchAll(PDO::FETCH_ASSOC);
      


   /* TITULO DE LA TABLA 1 */
      //color
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFillColor(254,173,38); //colorFondo
      $pdf->SetDrawColor(58,50,50); //colorBorde
      $pdf->Cell(0.01); // mover a la derecha
      $pdf->SetFont('Times', 'B', 12);
      $pdf->Cell(275, 7, utf8_decode("LISTADO DE EQUIPOS DE COMPUTO"), 1, 1, 'C',1);
      $pdf->Ln(0);

      /* CAMPOS DE LA TABLA 1 */
      //color
      $pdf->SetFillColor(254,173,38); //colorFondo
      $pdf->SetTextColor(0, 0, 0); //colorTexto
      $pdf->SetDrawColor(58,50,50); //colorBorde
      $pdf->SetFont('Times', 'B', 9);
      $pdf->Cell(10, 7, utf8_decode('N°'), 1, 0, 'C', 1);
      $pdf->Cell(20, 7, utf8_decode('CODIGO'), 1, 0, 'C', 1);
      $pdf->Cell(55, 7, utf8_decode('PROCESADOR'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('ARQUITECTURA'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('RAM'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('DISCO DURO'), 1, 0, 'C', 1);
      $pdf->Cell(40, 7, utf8_decode('SISTEMA OPERATIVO'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('TIPO DE EQUIPO'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('ESTADO'), 1, 1, 'C', 1);

      /* REGISTROS TABLA 1 */

      $i = 0;
   if(!empty($lista_equipos)){
      foreach($lista_equipos as $k=>$v){
         $i++;
         /* TABLA */
         $pdf->SetFont('Times', '', 9);
         $pdf->Cell(10, 7, utf8_decode($i), 1, 0, 'C', 0);
         $pdf->Cell(20, 7, utf8_decode($v['codigo']), 1, 0, 'C', 0);
         $pdf->Cell(55, 7, utf8_decode($v['procesador']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['arquitectura']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['ram']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['disco_duro']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['sistema_operativo']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['categoria']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['estadoequipo']), 1, 1, 'C', 0);

      };
   }else{
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(277, 7, utf8_decode("No se tiene registros"), 1, 1, 'C', 0);
   }

      $pdf->Ln(5);

date_default_timezone_set('America/La_Paz');
$fecha_actual=date('Y-m-d');
$nombre_archivo='reporte quipos de computo ue simon bolivar '.$fecha_actual.'.pdf';
$pdf->Output($nombre_archivo, 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)

?>

