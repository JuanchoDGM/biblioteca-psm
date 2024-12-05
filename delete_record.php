
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

if ($section == 'books') {
    $sql = "DELETE FROM libros WHERE id=$id";
} elseif ($section == 'theses') {
    $sql = "DELETE FROM tesis WHERE id=$id";
} elseif ($section == 'reports') {
    $sql = "DELETE FROM pasantias WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?section=$section");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>