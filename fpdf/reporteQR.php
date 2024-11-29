<?php
include('../bd.php');
include '../phpqrcode/qrlib.php';
require('fpdf.php');

// Preparar la consulta para obtener múltiples registros
$sentencia = $conexion->prepare("SELECT eq.*, ct.nombre as 'categoria', es.nombre as 'estadoequipo'  
                                  FROM tbl_equipos eq
                                  INNER JOIN tbl_categorias ct ON eq.idcategoria=ct.ID
                                  INNER JOIN tbl_estado es ON eq.idestado=es.ID");

$sentencia->execute();
$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Crear un array para almacenar temporalmente las rutas de los archivos QR generados
$qrFiles = [];

// Ruta a la fuente TrueType (.ttf)
$fuente = __DIR__ . '/../fuente-ttf/Roboto-Regular.ttf'; // Asegúrate de que esta fuente esté en la carpeta correcta

foreach ($registros as $registro) {
    $cod = $registro['codigo'];
    $textoQR = 'Codigo:' . $cod . '; Tipo:' . $registro['categoria'] . '; Procesador:' . $registro['procesador'] . '; Arquitectura:' . $registro['arquitectura'] . '; RAM:' . $registro['ram'] . '; Disco Duro:' . $registro['disco_duro'] . '; Sistema Operativo:' . $registro['sistema_operativo'] . '; Estado del Equipo:' . $registro['estadoequipo'];

    // Generar el código QR temporalmente
    $archivoQR = 'Codigo_' . $cod . '.png';
    QRcode::png($textoQR, $archivoQR, 'L', 10, 2);

    // Crear una imagen a partir del código QR generado
    $qrImage = imagecreatefrompng($archivoQR);

    // Obtener las dimensiones de la imagen QR
    $qrWidth = imagesx($qrImage);
    $qrHeight = imagesy($qrImage);

    // Definir el texto que quieres mostrar debajo del QR
    $texto = "U.E. Simón Bolivar - Código: $cod";

    // Establecer el tamaño de la fuente
    $tamañoFuente = 20;

    // Obtener el tamaño del cuadro de texto
    $bbox = imagettfbbox($tamañoFuente, 0, $fuente, $texto);
    $textoAncho = abs($bbox[4] - $bbox[0]);
    $textoAlto = abs($bbox[5] - $bbox[1]);

    // Calcular el tamaño de la imagen final que incluirá el texto
    $nuevaAltura = $qrHeight + $textoAlto + 10; // Altura del QR + altura del texto + un margen
    $nuevaImagen = imagecreatetruecolor($qrWidth, $nuevaAltura);

    // Colores (blanco de fondo, negro para el texto)
    $blanco = imagecolorallocate($nuevaImagen, 255, 255, 255);
    $negro = imagecolorallocate($nuevaImagen, 0, 0, 0);

    // Rellenar el fondo con color blanco
    imagefilledrectangle($nuevaImagen, 0, 0, $qrWidth, $nuevaAltura, $blanco);

    // Copiar el QR en la nueva imagen
    imagecopy($nuevaImagen, $qrImage, 0, 0, 0, 0, $qrWidth, $qrHeight);

    // Calcular la posición del texto centrado
    $textoX = ($qrWidth - $textoAncho) / 2;
    $textoY = $qrHeight + $textoAlto; // Colocar el texto debajo del QR

    // Escribir el texto en la nueva imagen
    imagettftext($nuevaImagen, $tamañoFuente, 0, $textoX, $textoY, $negro, $fuente, $texto);

    // Guardar la nueva imagen con el texto
    $nuevaRutaQR = 'Codigo_' . $cod . '_con_texto.png';
    imagepng($nuevaImagen, $nuevaRutaQR);

    // Liberar memoria
    imagedestroy($qrImage);
    imagedestroy($nuevaImagen);

    // Guardar la ruta del archivo generado
    $qrFiles[] = $nuevaRutaQR;
}

$tituloDocumento = 'Lista de Códigos QR - U.E. Simón Bolivar';

// Crear el PDF con los QR y el texto
$pdf = new FPDF('P', 'mm', 'Letter'); // Cambiado a tamaño carta
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 16); // Fuente Arial, en negrita (B), tamaño 16

// Agregar un título centrado
$pdf->Cell(0, 10, utf8_decode( $tituloDocumento), 0, 1, 'C');

// Espacio debajo del título antes de empezar a agregar los códigos QR
$pdf->Ln(10);

// Definir el número de columnas y filas
$columnas = 4;
$filas = 5;
$anchoQR = 40;  // Ancho de cada QR
$altoQR = 50;   // Alto de cada QR incluyendo el texto
$espacioEntreColumnas = 12; // Espacio horizontal entre columnas
$espacioEntreFilas = 10;    // Espacio vertical entre filas

// Contador para controlar la posición del QR
$contador = 0;

// Recorrer los archivos QR generados y agregarlos al PDF
foreach ($qrFiles as $archivoQR) {
    // Calcular la posición X y Y de la imagen en función del contador
    $x = ($contador % $columnas) * ($anchoQR + $espacioEntreColumnas) + 10; // 10 es el margen izquierdo
    $y = floor($contador / $columnas) * ($altoQR + $espacioEntreFilas) + 20; // 10 es el margen superior

    // Agregar el QR al PDF en la posición calculada
    $pdf->Image($archivoQR, $x, $y, $anchoQR, $altoQR - 10); // Ajustar el tamaño para el texto

    $contador++;

    // Si completamos las 4 columnas y 5 filas, agregar una nueva página
    if ($contador % ($columnas * $filas) == 0) {
        $pdf->AddPage();
    }
}

// Eliminar los archivos temporales de QR
foreach ($qrFiles as $archivoQR) {
    unlink($archivoQR);
}

// Mostrar el PDF en el navegador
$pdf->Output('I', 'CodigosQR_con_texto.pdf');


?>
