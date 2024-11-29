<?php 
include("bd.php");

if($_POST){
    $codigo=(isset($_POST["codigo"]))?$_POST["codigo"]:"";
    $procesador=(isset($_POST["procesador"]))?$_POST["procesador"]:"";
    $arquitectura=(isset($_POST["arquitectura"]))?$_POST["arquitectura"]:"";
    $ram=(isset($_POST["ram"]))?$_POST["ram"]:"";
    $disco_duro=(isset($_POST["disco_duro"]))?$_POST["disco_duro"]:"";
    $sistema_operativo=(isset($_POST["sistema_operativo"]))?$_POST["sistema_operativo"]:"";
    $categoria=(isset($_POST["categoria"]))?$_POST["categoria"]:"";
    $estado=(isset($_POST["estado"]))?$_POST["estado"]:"";
    
    $sentencia=$conexion->prepare("INSERT INTO 
    `tbl_equipos` (ID,codigo,procesador,arquitectura,ram,disco_duro,sistema_operativo,idcategoria,idestado) 
    VALUES (NULL,:codigo,:procesador,:arquitectura,:ram,:disco_duro,:sistema_operativo,:idcategoria,:idestado)");
    
    $sentencia->bindParam(":codigo", $codigo);
    $sentencia->bindParam(":procesador",$procesador);
    $sentencia->bindParam(":arquitectura",$arquitectura);
    $sentencia->bindParam(":ram",$ram);
    $sentencia->bindParam(":disco_duro",$disco_duro);
    $sentencia->bindParam(":sistema_operativo",$sistema_operativo);
    $sentencia->bindParam(":idcategoria",$categoria);
    $sentencia->bindParam(":idestado",$estado);

    $sentencia->execute();
    header("Location:equipo.php");

}



include ("templates/header.php"); 
?>
<br/>
<div class="card">
    <div class="card-header bg-warning">Equipos</div>
    <div class="card-body">
    
    <form action="crearEquipo.php" method="post">

    <div class="mb-3">
      <label for="codigo" class="form-label">Codigo:</label>
      <input type="text"
        class="form-control" value="" name="codigo" id="codigo" aria-describedby="helpId" placeholder="Codigo:" required>
    </div>
    <div class="mb-3">
      <label for="procesador" class="form-label">Procesador:</label>
      <input type="text"
        class="form-control" value="" name="procesador" id="procesador" aria-describedby="helpId" placeholder="Procesador:" required>
    </div>
    <div class="mb-3">
      <label for="arquitectura" class="form-label">Arquitectura:</label>
      <input type="text"
        class="form-control" value="" name="arquitectura" id="arquitectura" aria-describedby="helpId" placeholder="Arquitectura:" required>
    </div>
    <div class="mb-3">
      <label for="ram" class="form-label">RAM:</label>
      <input type="text"
        class="form-control" value="" name="ram" id="ram" aria-describedby="helpId" placeholder="RAM:" required>
    </div>
    <div class="mb-3">
      <label for="disco_duro" class="form-label">Disco Duro:</label>
      <input type="text"
        class="form-control" value="" name="disco_duro" id="disco_duro" aria-describedby="helpId" placeholder="Disco Duro:" required>
    </div>
    <div class="mb-3">
      <label for="sistema_operativo" class="form-label">Sistema Operativo:</label>
      <input type="text"
        class="form-control" value="" name="sistema_operativo" id="sistema_operativo" aria-describedby="helpId" placeholder="Sistema Operativo:" required>
    </div>
    <div class="mb-3">
      <label for="categoria" class="form-label">Categoria:</label>
      <?php
      $sentenciaCategoria=$conexion->prepare("SELECT * FROM tbl_categorias ");
      $sentenciaCategoria->execute();
      $lista_categorias= $sentenciaCategoria->fetchAll(PDO::FETCH_ASSOC);

    echo '<select name="categoria" id="categoria" class="form-control">';
    echo '<option value="" disabled selected>Seleccione una categoría</option>'; // Opción por defecto
    foreach ($lista_categorias as $categoria) {
        echo '<option value="' . $categoria['ID'] . '">' . $categoria['nombre'] . '</option>';
    }
    echo '</select>';

    ?>
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado:</label>
      <?php
      $sentenciaEstado=$conexion->prepare("SELECT * FROM tbl_estado ");
      $sentenciaEstado->execute();
      $lista_estado= $sentenciaEstado->fetchAll(PDO::FETCH_ASSOC);

      echo '<select name="estado" id="estado" class="form-control">';
      echo '<option value="" disabled selected>Seleccione un estado</option>'; // Opción por defecto
      foreach ($lista_estado as $estado) {
          echo '<option value="' . $estado['ID'] . '">' . $estado['nombre'] . '</option>';
      }
      echo '</select>';
    ?>
    </div>

         
        <button type="submit" class="btn btn-success">Agregar equipo </button>
        <a name="" id="" class="btn btn-primary" href="equipo.php" role="button">Cancelar</a>

        
        
        

    </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php 
include ("templates/footer.php"); 
?>