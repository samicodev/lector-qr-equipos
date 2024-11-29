<?php
include('bd.php');
include './phpqrcode/qrlib.php'; // Asegúrate de que la biblioteca esté correctamente ubicada

/* BUSCAR POR CODIGO DE PROYECTO */
$cod = '';
$pdf = ''; // Definir la variable $pdf antes de usarla

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL con parámetros
    $sentencia=$conexion->prepare("SELECT eq.*, ct.nombre as 'categoria', es.nombre as 'estadoequipo'  FROM tbl_equipos eq
                                  INNER JOIN tbl_categorias ct
                                  ON eq.idcategoria=ct.ID
                                  INNER JOIN tbl_estado es
                                ON eq.idestado=es.ID WHERE eq.ID=:id");

    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $cod =$registro["codigo"];

    $textoQR= 'Codigo:'.$cod .';'. ' Tipo:'. $registro["categoria"] .';' . ' Procesador:'. $registro["procesador"] .';' . ' Arquitectura:'. $registro["arquitectura"] .';'. ' RAM:'. $registro["ram"] .';'. ' Disco Duro:'. $registro["disco_duro"] .';'. ' Sistema Operativo:'. $registro["sistema_operativo"] .';'. ' Estado del Equipo:'. $registro["estadoequipo"];

}

if (empty($textoQR)) {
    die("Error: El texto del QR está vacío.");
}

// Especificar el contenido del código QR
$contenido = $textoQR;  // Cambia este enlace si es necesario

// Nombre del archivo temporal que contendrá el código QR
$archivoQR = 'Codigo_' . $cod . '.png'; // Nombre del archivo QR que se descargará con el código como parte del nombre

// Opciones de tamaño y corrección de errores
$tamaño = 10; // Tamaño del QR (puedes ajustar el valor)
$nivelCorreccion = 'L'; // Nivel de corrección de errores ('L','M','Q','H')

// Generar el código QR
QRcode::png($contenido, $archivoQR, $nivelCorreccion, $tamaño, 2);

// Verificar si el archivo QR se generó correctamente antes de intentar descargarlo
if (!file_exists($archivoQR)) {
    die("Error al generar el código QR.");
}

// ------------- Agregar texto debajo del QR usando imagettftext ------------------

// Crear una imagen a partir del código QR generado
$qrImage = imagecreatefrompng($archivoQR);

// Obtener las dimensiones de la imagen QR
$qrWidth = imagesx($qrImage);
$qrHeight = imagesy($qrImage);

// Definir el texto que quieres mostrar debajo del QR
$texto = "U.E. Simón Bolivar - Código: $cod";

// Ruta a una fuente TrueType (.ttf)
$fuente = __DIR__ . '/fuente-ttf/Roboto-Regular.ttf'; // Asegúrate de que esta fuente esté en la carpeta correcta

// Establecer el tamaño de la fuente
$tamañoFuente = 16; // Puedes ajustar el tamaño de la fuente

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
$nuevaRutaQR = 'Codigo_' . $cod . '.png';
imagepng($nuevaImagen, $nuevaRutaQR);

// Liberar memoria
imagedestroy($qrImage);
imagedestroy($nuevaImagen);

// Preparar la imagen para descarga
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="' . $nuevaRutaQR . '"');
header('Content-Length: ' . filesize($nuevaRutaQR));

// Leer el archivo y enviarlo al navegador para que se descargue
readfile($nuevaRutaQR);

// Eliminar el archivo temporal (opcional)
unlink($archivoQR);
unlink($nuevaRutaQR);

?>
