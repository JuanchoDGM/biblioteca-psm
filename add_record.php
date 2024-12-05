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
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$estante = $_POST['estante'];
$nivel = $_POST['nivel'];

if ($section == 'books') {
    $editorial = $_POST['editorial'];
    $ano = $_POST['ano'];
    $sql = "INSERT INTO libros (titulo, autor, ano, editorial, estante, nivel) VALUES ('$titulo', '$autor', '$ano', '$editorial', '$estante', '$nivel')";
} elseif ($section == 'theses') {
    $cedula = $_POST['cedula'];
    $fecha = $_POST['fecha'];
    $carrera = $_POST['carrera'];
    $sql = "INSERT INTO tesis (titulo, autor, cedula, fecha, carrera, estante, nivel) VALUES ('$titulo', '$autor', '$cedula', '$fecha', '$carrera', '$estante', '$nivel')";
} elseif ($section == 'reports') {
    $cedula = $_POST['cedula'];
    $fecha = $_POST['fecha'];
    $carrera = $_POST['carrera'];
    $sql = "INSERT INTO pasantias (titulo, autor, cedula, fecha, carrera, estante, nivel) VALUES ('$titulo', '$autor', '$cedula', '$fecha', '$carrera', '$estante', '$nivel')";
}

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?section=$section");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>