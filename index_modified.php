<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la sección actual
$section = isset($_GET['section']) ? $_GET['section'] : 'books';

?>

<!DOCTYPE html>
<html lang="en" class="">


<head>
    
<!-- Tailwind CSS integration -->
<script src="https://cdn.tailwindcss.com"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
        }

        function openModal(action, data = {}) {
            const modal = document.getElementById('modal');
            const form = document.getElementById('addForm');
            const title = document.getElementById('modalTitle');
            const submitButton = document.getElementById('submitButton');
            const deleteButton = document.getElementById('deleteButton');

            if (action === 'add') {
                title.textContent = 'Agregar nuevo';
                submitButton.textContent = 'Guardar';
                form.reset();
                form.action = 'add_record.php';
            } else if (action === 'edit') {
                title.textContent = 'Modificar';
                submitButton.textContent = 'Actualizar';
                deleteButton.style.display = 'inline-block';
                form.action = 'update_record.php';
                for (const key in data) {
                    if (form.elements[key]) {
                        form.elements[key].value = data[key];
                    }
                }
            }

            modal.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function submitForm() {
            document.getElementById('addForm').submit();
        }

        function deleteRecord() {
            if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                document.getElementById('addForm').action = 'delete_record.php';
                submitForm();
            }
        }
    </script>
    <title>Control de Inventario de Biblioteca</title>
</head>

<body class="font-poppins bg-gray-200 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md">
        <a href="?section=books" class="float-left text-gray-500 text-center py-4 px-6 no-underline hover:bg-blue-700 hover:text-white dark:text-white <?php echo $section == 'books' ? 'bg-blue-600 text-white' : ''; ?>">Libros</a>
        <a href="?section=theses" class="float-left text-gray-500 text-center py-4 px-6 no-underline hover:bg-blue-700 hover:text-white dark:text-white <?php echo $section == 'theses' ? 'bg-blue-600 text-white' : ''; ?>">Tesis</a>
        <a href="?section=reports" class="float-left text-gray-500 text-center py-4 px-6 no-underline hover:bg-blue-700 hover:text-white dark:text-white <?php echo $section == 'reports' ? 'bg-blue-600 text-white' : ''; ?>">Pasantías</a>

        <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition" onclick="toggleDarkMode()" class="float-left text-gray-500 text-center py-4 px-6 no-underline hover:bg-blue-700 hover:text-white dark:text-white"><svg class="w-6 h-6 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M13 3a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0V3ZM6.343 4.929A1 1 0 0 0 4.93 6.343l1.414 1.414a1 1 0 0 0 1.414-1.414L6.343 4.929Zm12.728 1.414a1 1 0 0 0-1.414-1.414l-1.414 1.414a1 1 0 0 0 1.414 1.414l1.414-1.414ZM12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm-9 4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H3Zm16 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2ZM7.757 17.657a1 1 0 1 0-1.414-1.414l-1.414 1.414a1 1 0 1 0 1.414 1.414l1.414-1.414Zm9.9-1.414a1 1 0 0 0-1.414 1.414l1.414 1.414a1 1 0 0 0 1.414-1.414l-1.414-1.414ZM13 19a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0v-2Z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>


    <div class="p-5">
        <?php if ($section == 'books'): ?>
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Libros</h2>
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition" onclick="openModal('add')" class="bg-blue-600 text-white py-2 px-4 mb-4 rounded hover:bg-blue-700">Agregar libro</button>



            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Título
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Autor
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Año
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Editorial
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estante
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nivel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <!-- agrega funcionalidad a los botones de acción (editar y eliminar), para que modifiquen y eliminen los elementos de la tabla y de la base de datos -->
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM libros";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700'>";
                                echo "<th class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" . $row["titulo"] . "</th>";
                                echo "<td class='px-6 py-4'>" . $row["autor"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["ano"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["editorial"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["estante"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["nivel"] . "</td>";
                                echo '<td class="px-6 py-4 flex gap-2">
                                    <a href="#" onclick="openModal(\'edit\', {id: ' . $row["id"] . ', titulo: \'' . $row["titulo"] . '\', autor: \'' . $row["autor"] . '\', ano: \'' . $row["ano"] . '\', editorial: \'' . $row["editorial"] . '\', estante: \'' . $row["estante"] . '\', nivel: \'' . $row["nivel"] . '\'})" ><svg class="w-6 h-6 text-gray-800 hover:text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <a href="#" id="deleteButton" onclick="deleteRecord()"><svg class="w-6 h-6 text-gray-800 hover:text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </a>
                                </td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='px-6 py-4 text-center'>No hay libros disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($section == 'theses'): ?>
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Tesis</h2>
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition" onclick="openModal('add')" class="bg-blue-600 text-white py-2 px-4 mb-4 rounded hover:bg-blue-700">Añadir tesis</button>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Titulo</th>
                            <th scope="col" class="px-6 py-3">Autor</th>
                            <th scope="col" class="px-6 py-3">Cédula</th>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                            <th scope="col" class="px-6 py-3">Carrera</th>
                            <th scope="col" class="px-6 py-3">Estante</th>
                            <th scope="col" class="px-6 py-3">Nivel</th>
                            <th scope="col" class="px-6 py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tesis";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700'>";
                                echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" . $row["titulo"] . "</th>";
                                echo "<td class='px-6 py-4'>" . $row["autor"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["cedula"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["fecha"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["carrera"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["estante"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["nivel"] . "</td>";
                                echo '<td class="px-6 py-4 flex gap-2">
                                    <a href="#" onclick="openModal(\'edit\', {id: ' . $row["id"] . ', titulo: \'' . $row["titulo"] . '\', autor: \'' . $row["autor"] . '\', cedula: \'' . $row["cedula"] . '\', fecha: \'' . $row["fecha"] . '\', carrera: \'' . $row["carrera"] . '\', estante: \'' . $row["estante"] . '\', nivel: \'' . $row["nivel"] . '\'})"><svg class="w-6 h-6 text-gray-800 hover:text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <a href="#" id="deleteButton" onclick="deleteRecord()"><svg class="w-6 h-6 text-gray-800 hover:text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </a>
                                </td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='px-6 py-4 text-center'>No hay tesis disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($section == 'reports'): ?>
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Pasantías</h2>
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition" onclick="openModal('add')" class="bg-blue-600 text-white py-2 px-4 mb-4 rounded hover:bg-blue-700">Añadir pasantía</button>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Titulo</th>
                            <th scope="col" class="px-6 py-3">Autor</th>
                            <th scope="col" class="px-6 py-3">Cédula</th>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                            <th scope="col" class="px-6 py-3">Carrera</th>
                            <th scope="col" class="px-6 py-3">Estante</th>
                            <th scope="col" class="px-6 py-3">Nivel</th>
                            <th scope="col" class="px-6 py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM pasantias";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700'>";
                                echo "<th class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" . $row["titulo"] . "</th>";
                                echo "<td class='px-6 py-4'>" . $row["autor"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["cedula"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["fecha"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["carrera"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["estante"] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row["nivel"] . "</td>";
                                echo '<td class="px-6 py-4 flex gap-2">
                                    <a href="#" onclick="openModal(\'edit\', {id: ' . $row["id"] . ', titulo: \'' . $row["titulo"] . '\', autor: \'' . $row["autor"] . '\', cedula: \'' . $row["cedula"] . '\', fecha: \'' . $row["fecha"] . '\', carrera: \'' . $row["carrera"] . '\', estante: \'' . $row["estante"] . '\', nivel: \'' . $row["nivel"] . '\'})"><svg class="w-6 h-6 text-gray-800 hover:text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <a href="#" id="deleteButton" onclick="deleteRecord()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </a>
                                </td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='px-6 py-4 text-center'>No hay pasantías disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div id="modal" class="modal hidden">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle" class="text-xl font-bold mb-4"></h2>
            <form class="space-y-4 bg-white p-6 rounded-lg shadow-md max-w-md mx-auto" id="addForm" method="POST">
                <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="hidden" name="section" value="<?php echo $section; ?>">
                <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="hidden" name="id" id="id">
                <div class="mb-4">
                    <label for="titulo" class="block text-gray-700 dark:text-gray-200">Título</label>
                    <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="text" id="titulo" name="titulo" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="autor" class="block text-gray-700 dark:text-gray-200">Autor</label>
                    <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="text" id="autor" name="autor" class="w-full px-3 py-2 border rounded" required>
                </div>
                <?php if ($section == 'books'): ?>
                    <div class="mb-4">
                        <label for="editorial" class="block text-gray-700 dark:text-gray-200">Editorial</label>
                        <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="text" id="editorial" name="editorial" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="ano" class="block text-gray-700 dark:text-gray-200">Año</label>
                        <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="text" id="ano" name="ano" class="w-full px-3 py-2 border rounded" required>
                    </div>
                <?php endif; ?>
                <?php if ($section == 'theses' || $section == 'reports'): ?>
                    <div class="mb-4">
                        <label for="cedula" class="block text-gray-700 dark:text-gray-200">Cédula</label>
                        <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="text" id="cedula" name="cedula" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="fecha" class="block text-gray-700 dark:text-gray-200">Fecha</label>
                        <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="date" id="fecha" name="fecha" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="carrera" class="block text-gray-700 dark:text-gray-200">Carrera</label>
                        <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="text" id="carrera" name="carrera" class="w-full px-3 py-2 border rounded" required>
                    </div>
                <?php endif; ?>
                <div class="mb-4">
                    <label for="estante" class="block text-gray-700 dark:text-gray-200">Estante</label>
                    <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="number" id="estante" name="estante" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="nivel" class="block text-gray-700 dark:text-gray-200">Nivel</label>
                    <input class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" type="number" id="nivel" name="nivel" class="w-full px-3 py-2 border rounded" required>
                </div>
                <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition" type="button" id="submitButton" onclick="submitForm()" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Guardar</button>
            </form>
        </div>
    </div>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>

<!--  -->