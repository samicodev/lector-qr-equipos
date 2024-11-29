<?php 
include("bd.php");

if($_POST){
    $nombre=(isset($_POST["nombre"]))?$_POST["nombre"]:"";
    $usuario=(isset($_POST["usuario"]))?$_POST["usuario"]:"";
    $password=(isset($_POST["password"]))?$_POST["password"]:"";
    $password= md5($password);
    
    $sentencia=$conexion->prepare("INSERT INTO 
    `tbl_usuarios` (ID,nombre,usuario,password) 
    VALUES (NULL,:nombre,:usuario,:password)");
    
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password",$password);

    $sentencia->execute();
    header("Location:usuario.php");



}

include ("templates/header.php"); 
?>
<br/>
<div class="card">
    <div class="card-header bg-warning">Usuarios</div>
    <div class="card-body">
    
    <form action="" method="post">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input
                type="text"
                class="form-control"
                name="nombre"
                id="nombre"
                
                placeholder="nombre"
            />
            
        </div>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input
                type="text"
                class="form-control"
                name="usuario"
                id="usuario"
                
                placeholder="Usuario"
            />
            
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Password: </label>
            <input
                type="password"
                class="form-control"
                name="password"
                id="password"
                placeholder="Contraseña"
            />
        </div>


         
        <button type="submit" class="btn btn-success">Agregar usuario </button>
        <a name="" id="" class="btn btn-primary" href="usuario.php" role="button">Cancelar</a>

        
        
        

    </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php 
include ("templates/footer.php"); 
?>