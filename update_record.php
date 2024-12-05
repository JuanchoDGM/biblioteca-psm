<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$section = $_POST['section'];
$id = $_POST['id'];
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$editorial = $_POST['editorial'];
$estante = $_POST['estante'];
$nivel = $_POST['nivel'];

if ($section == 'books') {
    $ano = $_POST['ano'];
    $sql = "UPDATE libros SET titulo='$titulo', autor='$autor', ano='$ano', editorial='$editorial', estante='$estante', nivel='$nivel' WHERE id=$id";
} elseif ($section == 'theses') {
    $cedula = $_POST['cedula'];
    $fecha = $_POST['fecha'];
    $carrera = $_POST['carrera'];
    $sql = "UPDATE tesis SET titulo='$titulo', autor='$autor', cedula='$cedula', fecha='$fecha', carrera='$carrera', estante='$estante', nivel='$nivel' WHERE id=$id";
} elseif ($section == 'reports') {
    $cedula = $_POST['cedula'];
    $fecha = $_POST['fecha'];
    $carrera = $_POST['carrera'];
    $sql = "UPDATE pasantias SET titulo='$titulo', autor='$autor', cedula='$cedula', fecha='$fecha', carrera='$carrera', estante='$estante', nivel='$nivel' WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?section=$section");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>