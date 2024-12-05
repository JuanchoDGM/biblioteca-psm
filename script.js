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