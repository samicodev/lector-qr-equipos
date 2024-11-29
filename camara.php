<?php include("bd.php") ?>

<?php include("templates/header.php") ?>

<h1 style="text-align: center; " class="text-warning"> Scanner QR </h1>
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <video id="previsualizacion" class="p-1 border w-100" style="max-height: 240px;"></video>
            
        </div>
        <div class="col-md-4">
            <label for="codigo" class="form-label text-warning">Codigo QR escaneado:</label><br>
            <textarea name="codigo" id="codigo" placeholder="Codigo QR Escaneado..." class="form-control" rows="7"></textarea>
        </div>
        <div class="col-md-2"></div>
    </div>
  </div>  

  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>


<script type="text/javascript">
       var sonido = new Audio("pip.mp3");

var scanner = new Instascan.Scanner({
    video: document.getElementById('previsualizacion'),
    scanPeriod: 5,
    mirror: false
});

Instascan.Camera.getCameras().then(function(cameras) {
    if (cameras.length > 0) {
        // Intenta seleccionar la cámara trasera
        var rearCamera = cameras.find(camera => camera.name.toLowerCase().includes('back')) || cameras[0];
        scanner.start(rearCamera);
    } else {
        console.error("No se encontraron cámaras.");
        alert('Cámaras no encontradas.');
    }
}).catch(function(e) {
    console.error("Error al acceder a las cámaras:", e);
    alert("ERROR: " + e);
});

scanner.addListener('scan', function(respuesta) {
    sonido.play();
    document.getElementById("codigo").value = respuesta;
});

    </script>


<?php include("templates/footer.php") ?>
