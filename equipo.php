<?php 
include("bd.php");


if(isset($_GET["txtID"])){
    $txtID=(isset($_GET["txtID"]))?$_GET["txtID"]:"";
    $sentencia=$conexion->prepare("DELETE FROM tbl_equipos WHERE ID=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    header("Location:equipo.php");
}


$sentencia=$conexion->prepare("SELECT eq.*, ct.nombre as 'categoria', es.nombre as 'estadoequipo'  FROM tbl_equipos eq
                                INNER JOIN tbl_categorias ct
                                ON eq.idcategoria=ct.ID
                                INNER JOIN tbl_estado es
                                ON eq.idestado=es.ID
                                ");
$sentencia->execute();
$lista_equipos= $sentencia->fetchAll(PDO::FETCH_ASSOC);

include ("templates/header.php"); 
?>
<br>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <a name="" id="" class="btn btn-primary" href="crearEquipo.php" role="button">Agregar registros</a>  
        <section>
        <a name="" id="" class="btn btn-danger" href="fpdf/reporteGeneral.php" role="button" target="_blank">Reporte PDF</a>
        <a name="" id="" class="btn btn-success" href="fpdf/reporteQR.php" role="button" target="_blank">Generar todos los QR</a>
        </section>  
     </div>
    <div class="card-body">

    <div
        class="table-responsive-sm"
    >
        <table
            class="table"
        >
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Procesador</th>
                    <th scope="col">Arquitectura</th>
                    <th scope="col">RAM</th>
                    <th scope="col">Disco Duro</th>
                    <th scope="col">Sistema Operativo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones </th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($lista_equipos as $registro){ ?>    
            <tr class="">
                <td ><?php echo $registro["ID"];?></td>
                    <td><?php echo $registro["categoria"];?></td>
                    <td><?php echo $registro["codigo"];?></td>
                    <td><?php echo $registro["procesador"];?></td>
                    <td><?php echo $registro["arquitectura"];?></td>
                    <td><?php echo $registro["ram"];?></td>
                    <td><?php echo $registro["disco_duro"];?></td>
                    <td><?php echo $registro["sistema_operativo"];?></td>
                    <td><?php echo $registro["estadoequipo"];?></td>
                    <td> 
                        <a name="" id="" class="btn btn-info" href="editarEquipo.php?txtID=<?php echo $registro['ID']; ?>" role="button">Editar</a>
                        <a name="" id="" class="btn btn-danger" href="equipo.php?txtID=<?php echo $registro["ID"];?>" role="button">Borrar</a>
                        <a  class="btn btn-warning" href="generar_qr.php?id=<?php echo $registro['ID']; ?>" role="button">Descargar QR</a>
                         </td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
    
    
    </div>
    <div class="card-footer text-muted"></div>
</div>




<?php 
include ("/templates/footer.php"); 
?>
