<?php 
include("bd.php");


if(isset($_GET["txtID"])){
    $txtID=(isset($_GET["txtID"]))?$_GET["txtID"]:"";
    $sentencia=$conexion->prepare("DELETE FROM tbl_usuarios WHERE ID=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    header("Location:usuario.php");
}


$sentencia=$conexion->prepare("SELECT * FROM `tbl_usuarios`");
$sentencia->execute();
$lista_usuarios= $sentencia->fetchAll(PDO::FETCH_ASSOC);

include ("templates/header.php"); 
?>
<br>
<div class="card">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="crearUsuario.php" role="button">Agregar registros</a>  
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
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Acciones </th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($lista_usuarios as $registro){ ?>    
            <tr class="">
                <td ><?php echo $registro["ID"];?></td>
                    <td><?php echo $registro["nombre"];?></td>
                    <td><?php echo $registro["usuario"];?></td>
                    <td> 
                        <a name="" id="" class="btn btn-info" href="editarUsuario.php?txtID=<?php echo $registro['ID']; ?>" role="button">Editar</a>
                        <a name="" id="" class="btn btn-danger" href="usuario.php?txtID=<?php echo $registro["ID"];?>" role="button">Borrar</a>
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
include ("templates/footer.php"); 
?>