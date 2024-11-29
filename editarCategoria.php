<?php 
include("bd.php");


if($_POST){

    $txtID=(isset($_POST["txtID"]))?$_POST["txtID"]:"";


    $nombre=(isset($_POST["nombre"]))?$_POST["nombre"]:"";
    
    $sentencia=$conexion->prepare(" UPDATE `tbl_categorias`
              SET 
              nombre=:nombre
              WHERE ID=:id"
             );
    
    
    $sentencia->bindParam(":nombre",$nombre);
    $sentencia->bindParam(":id",$txtID);

    $sentencia->execute();
    header("Location:categoria.php");

}

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET["txtID"]))?$_GET["txtID"]:"";
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_categorias` WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

     // Recuperación de datos ( asignar al formulario )
     $nombre=$registro["nombre"];
}


include ("templates/header.php"); 
?>

<br/>
<div class="card">
    <div class="card-header">
        Categoria
    </div>
    <div class="card-body">
    
    <form action="" method="post">

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

    <button type="submit" class="btn btn-success">Modificar categoria</button>
        <a name="" id="" class="btn btn-primary" href="categoria.php" role="button">Cancelar</a>


    </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>

<?php include ("templates/footer.php"); ?>