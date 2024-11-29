<?php include("templates/header.php"); ?>
<br/>
<div class="row align-items-md-stretch">
    <div class="col-md-6">
        <div
            class="h-100 p-5 border rounded-3">
            <h2 class="text-warning">Bienvenido al apartado administrador <?php echo $_SESSION["usuario"];?></h2>
            <p class="text-warning">Este espacio es para administrar los equipos de computo mediante tecnologia QR .</p>
            <a class="btn btn-primary" href="equipo.php">Iniciar ahora </a>
        </div>
    </div>
    <div class="col-md-6">
        <img src="./img/laboratorio.jpg" alt="laboratorio">
    </div>
    
</div>

<?php include("templates/footer.php"); ?>
 