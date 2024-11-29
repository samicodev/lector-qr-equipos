<?php 
session_start();
if(!isset($_SESSION["usuario"])){
  header("Location:login.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Sistema Lector QR</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


    <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->

    <!-- QR -->
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.1/qrcode.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
  



</head>

<body style="background-color: #0a1738;">
  <header>
    <!-- place navbar here -->

    <nav class="navbar navbar-expand navbar-dark " style="background-color: #00001b;">
        <div class="nav navbar-nav ">
            <a class="nav-item nav-link active" href="index.php" aria-current="page">Administrador<span class="visually-hidden">(current)</span></a>
            <a class="nav-item nav-link" href="camara.php">Scanner</a>
            <a class="nav-item nav-link" href="equipo.php">Equipos</a>
            <a class="nav-item nav-link" href="categoria.php">Categorias</a>
            <a class="nav-item nav-link" href="estado.php">Estados</a>
            <a class="nav-item nav-link" href="usuario.php">Usuarios</a>
            <a class="nav-item nav-link" href="cerrar.php">Cerrar sesión</a>


        </div>
    </nav>

  </header>
  <main>
<section class="container">