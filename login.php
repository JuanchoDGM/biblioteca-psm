<?php
// login.php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = $row['role']; // Assuming 'role' column exists in 'users' table
        header('Location: index.php');
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/output.css">
    <link rel="icon" href="img/logo-psm.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body class="font-poppins bg-blue-800">

    <div class="flex items-center justify-center h-screen">
        <form class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm" method="POST">
            <div class="flex items-center justify-center gap-4 mb-4">
                <img src="img/image.png" alt="Institution Logo" class="h-12">
                <h2 class="text-2xl font-bold text-blue-800">Biblioteca PSM</h2>
            </div>
            <?php if (isset($error)): ?>
                <p class="text-red-600 mb-4"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Usuario</label>
                <input class=" w-full border border-blue-400 rounded-md p-2 focus:ring-2 focus:ring-blue-800 focus:outline-none" type="text" id="username" name="username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input class=" w-full border border-blue-400 rounded-md p-2 focus:ring-2 focus:ring-blue-800 focus:outline-none" type="password" id="password" name="password" required>
            </div>
            <button class="bg-blue-800 text-white py-2 px-4 rounded-lg hover:bg-blue-950 transition w-full" type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>

</html>