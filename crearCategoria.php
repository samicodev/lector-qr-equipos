<?php 
include("bd.php");

if($_POST){
    $nombre=(isset($_POST["nombre"]))?$_POST["nombre"]:"";
    
    $sentencia=$conexion->prepare("INSERT INTO 
    `tbl_categorias` (ID,nombre) 
    VALUES (NULL,:nombre);");
    
    $sentencia->bindParam(":nombre",$nombre);

    $sentencia->execute();
    header("Location:categoria.php");



}

include ("templates/header.php"); 
?>
<br/>
<div class="card">
    <div class="card-header bg-warning">Categoria</div>
    <div class="card-body">
    
    <form action="" method="post">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de categoria</label>
            <input
                type="text"
                class="form-control"
                name="nombre"
                id="nombre"
                
                placeholder="Categoria"
            />
            
        </div>

        <button type="submit" class="btn btn-success">Agregar categoria </button>
        <a name="" id="" class="btn btn-primary" href="categoria.php" role="button">Cancelar</a>

        
        
        

    </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php 
include ("templates/footer.php"); 
?>