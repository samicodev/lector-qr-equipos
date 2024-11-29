<?php 
include("bd.php");


if($_POST){

    $txtID=(isset($_POST["txtID"]))?$_POST["txtID"]:"";


    $nombre=(isset($_POST["nombre"]))?$_POST["nombre"]:"";
    $usuario=(isset($_POST["usuario"]))?$_POST["usuario"]:"";
    $password=(isset($_POST["password"]))?$_POST["password"]:"";
    $password= md5($password);
    
    $sentencia=$conexion->prepare(" UPDATE `tbl_usuarios`
              SET 
              nombre=:nombre,
              usuario=:usuario,
              password=:password
              WHERE ID=:id"
             );
    
    
    $sentencia->bindParam(":nombre",$nombre);
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password",$password);
    $sentencia->bindParam(":id",$txtID);

    $sentencia->execute();
    header("Location:usuario.php");

}

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET["txtID"]))?$_GET["txtID"]:"";
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_usuarios` WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

     // Recuperación de datos ( asignar al formulario )
     $nombre=$registro["nombre"];
     $usuario=$registro["usuario"];
}


include ("templates/header.php"); 
?>

<br/>
<div class="card">
    <div class="card-header">
        Usuario
    </div>
    <div class="card-body">
    
    <form action="" method="post" enctype="multipart/form-data" >

    <div class="mb-3 d-none">
      <label for="" class="form-label">ID:</label>
      <input type="text"
        class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="">
     
    </div>

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre:</label>
      <input type="text"
        class="form-control" value="<?php echo $nombre;?>" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre:" required>
    </div>

    <div class="mb-3">
      <label for="ingredientes" class="form-label">Nombre de usuario:</label>
      <input type="text"
        class="form-control" value="<?php echo $usuario;?>" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Usuario" required>
    </div>

    <div class="mb-3">
            <label for="" class="form-label">Password: </label>
            <input
                type="password"
                class="form-control"
                name="password"
                id="password"
                placeholder=""
                required
            />
        </div>

    <button type="submit" class="btn btn-success">Modificar usario</button>
        <a name="" id="" class="btn btn-primary" href="usuario.php" role="button">Cancelar</a>




    </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>

<?php include ("templates/footer.php"); ?>