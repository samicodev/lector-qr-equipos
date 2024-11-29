<?php 
session_start();
if($_POST){
  include("bd.php");

  $usuario=(isset($_POST["usuario"]))?$_POST["usuario"]:"";
  $password=(isset($_POST["password"]))?$_POST["password"]:"";

  $password=md5($password);

  $sentencia=$conexion->prepare("SELECT *, count(*) as n_usuario
            FROM tbl_usuarios
            WHERE usuario=:usuario
            AND password=:password
            ");
            $sentencia->bindParam(":usuario",$usuario);
            $sentencia->bindParam(":password",$password);
            $sentencia->execute();
            $lista_usuarios=$sentencia->fetch(PDO::FETCH_LAZY);
            $n_usuario=$lista_usuarios["n_usuario"];
            if($n_usuario==1){
              
              $_SESSION["usuario"]=$lista_usuarios["usuario"];
              $_SESSION["logueado"]=true;

              header("Location:index.php");
            }else{
              $mensaje="Usuario o contraseña incorrectos...";
            }

}

?>
<!doctype html>
<html lang="en">

<head>
  <title>Iniciar Sesión</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body style="background-color: #00001b">
  
  <main>

  <div class="container">
    
  <div class="row">
    
    <div class="col-md-4"></div>

    <div class="col-md-4">
        <br><br>
<?php if(isset($mensaje)){?>
        <div
          class="alert alert-danger"
          role="alert"
        >
          <strong>Error:</strong> <?php echo $mensaje;?>
        </div>
<?php } ?>

        <div class="card ">
          <div class="card-header text-center"> <b style="font-size: 30px;">Sistema Lector QR</b> <br>Iniciar Sesión 

          </div>
        <div class="card-body">
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="" class="form-label">Usuario:</label>
                    <input type="text"
                        class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Escribe tu usuario...">
                </div>

                <div class="mb-3">
                <label for="" class="form-label">contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Escribe tu contraseña...">
                </div>

                <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-danger">Ingresar</button>
                </div>


            </form>
          </div>

        </div>

    </div>

    <div class="col-md-4"></div>

  </div>

  </div>


  </main>
  

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

</body>

</html>