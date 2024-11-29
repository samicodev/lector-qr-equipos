<?php 
include("bd.php");


if($_POST){

    $txtID=(isset($_POST["txtID"]))?$_POST["txtID"]:"";


    $codigo=(isset($_POST["codigo"]))?$_POST["codigo"]:"";
    $procesador=(isset($_POST["procesador"]))?$_POST["procesador"]:"";
    $arquitectura=(isset($_POST["arquitectura"]))?$_POST["arquitectura"]:"";
    $ram=(isset($_POST["ram"]))?$_POST["ram"]:"";
    $disco_duro=(isset($_POST["disco_duro"]))?$_POST["disco_duro"]:"";
    $sistema_operativo=(isset($_POST["sistema_operativo"]))?$_POST["sistema_operativo"]:"";
    $categoria=(isset($_POST["categoria"]))?$_POST["categoria"]:"";
    $estado=(isset($_POST["estado"]))?$_POST["estado"]:"";
    
    $sentencia=$conexion->prepare(" UPDATE `tbl_equipos`
              SET 
              codigo=:codigo,
              procesador=:procesador,
              arquitectura=:arquitectura,
              ram=:ram,
              disco_duro=:disco_duro,
              sistema_operativo=:sistema_operativo,
              idcategoria=:categoria,
              idestado=:estado
              WHERE ID=:id"
             );
    
    
    $sentencia->bindParam(":codigo",$codigo);
    $sentencia->bindParam(":procesador", $procesador);
    $sentencia->bindParam(":arquitectura",$arquitectura);
    $sentencia->bindParam(":ram",$ram);
    $sentencia->bindParam(":disco_duro",$disco_duro);
    $sentencia->bindParam(":sistema_operativo",$sistema_operativo);
    $sentencia->bindParam(":categoria",$categoria);
    $sentencia->bindParam(":estado",$estado);
    $sentencia->bindParam(":id",$txtID);

    $sentencia->execute();
    header("Location:equipo.php");

}

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET["txtID"]))?$_GET["txtID"]:"";
    $sentencia=$conexion->prepare("SELECT eq.*, ct.ID as 'categoria', es.ID as 'estadoequipo'  FROM tbl_equipos eq
                                INNER JOIN tbl_categorias ct
                                ON eq.idcategoria=ct.ID
                                INNER JOIN tbl_estado es
                                ON eq.idestado=es.ID WHERE eq.ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

     // Recuperación de datos ( asignar al formulario )
     $categoria=$registro["categoria"];
     $estadoequipo=$registro["estadoequipo"];

     $codigo=$registro["codigo"];
     $procesador=$registro["procesador"];
     $arquitectura=$registro["arquitectura"];
     $ram=$registro["ram"];
     $disco_duro=$registro["disco_duro"];
     $sistema_operativo=$registro["sistema_operativo"];


    $sentenciaCategoria=$conexion->prepare("SELECT * FROM tbl_categorias ");
    $sentenciaCategoria->execute();
    $lista_categorias= $sentenciaCategoria->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaEstado=$conexion->prepare("SELECT * FROM tbl_estado ");
    $sentenciaEstado->execute();
    $lista_estado= $sentenciaEstado->fetchAll(PDO::FETCH_ASSOC);
}


include ("templates/header.php"); 
?>

<br/>
<div class="card">
    <div class="card-header">
        Equipos
    </div>
    <div class="card-body">
    
    <form action="" method="post" enctype="multipart/form-data" >

    <div class="mb-3 d-none">
      <label for="" class="form-label">ID:</label>
      <input type="text"
        class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="">
     
    </div>

    <div class="mb-3">
      <label for="codigo" class="form-label">Codigo:</label>
      <input type="text"
        class="form-control" value="<?php echo $codigo;?>" name="codigo" id="codigo" aria-describedby="helpId" placeholder="Cdigo:" required>
    </div>
    <div class="mb-3">
      <label for="procesador" class="form-label">Procesador:</label>
      <input type="text"
        class="form-control" value="<?php echo $procesador;?>" name="procesador" id="procesador" aria-describedby="helpId" placeholder="Procesador:" required>
    </div>
    <div class="mb-3">
      <label for="arquitectura" class="form-label">Arquitectura:</label>
      <input type="text"
        class="form-control" value="<?php echo $arquitectura;?>" name="arquitectura" id="arquitectura" aria-describedby="helpId" placeholder="Arquitectura:" required>
    </div>
    <div class="mb-3">
      <label for="ram" class="form-label">RAM:</label>
      <input type="text"
        class="form-control" value="<?php echo $ram;?>" name="ram" id="ram" aria-describedby="helpId" placeholder="RAM:" required>
    </div>
    <div class="mb-3">
      <label for="disco_duro" class="form-label">Disco Duro:</label>
      <input type="text"
        class="form-control" value="<?php echo $disco_duro;?>" name="disco_duro" id="disco_duro" aria-describedby="helpId" placeholder="Disco Duro:" required>
    </div>
    <div class="mb-3">
      <label for="sistema_operativo" class="form-label">Sistema Operativo:</label>
      <input type="text"
        class="form-control" value="<?php echo $sistema_operativo;?>" name="sistema_operativo" id="sistema_operativo" aria-describedby="helpId" placeholder="Sistema Operativo:" required>
    </div>
    <div class="mb-3">
      <label for="categoria" class="form-label">Categoria:</label>
      <?php
    echo '<select name="categoria" id="categoria"  class="form-control">';
    foreach ($lista_categorias as $categoria) {
        $selected = ($categoria['ID'] == $categoria) ? 'selected' : '';
        echo '<option value="' . $categoria['ID'] . '" ' . $selected . '>' . $categoria['nombre'] . '</option>';
    }
    echo '</select>';

    ?>
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado:</label>
      <?php
    echo '<select name="estado" id="estado"  class="form-control">';
    foreach ($lista_estado as $estado) {
        $selected = ($estado['ID'] == $estado) ? 'selected' : '';
        echo '<option value="' . $estado['ID'] . '" ' . $selected . '>' . $estado['nombre'] . '</option>';
    }
    echo '</select>';

    ?>
    </div>

    <button type="submit" class="btn btn-success">Modificar Estado</button>
        <a name="" id="" class="btn btn-primary" href="equipo.php" role="button">Cancelar</a>




    </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>

<?php include ("templates/footer.php"); ?>