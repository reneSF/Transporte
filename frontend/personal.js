const API_URL = 'http://localhost:8888/api/personal'; // Ajusta según tu configuración

// Obtener todos los registros de personal al cargar la página
document.addEventListener('DOMContentLoaded', obtenerPersonal);

const formulario = document.getElementById('personal-form');

// Guardar personal (crear o actualizar)
formulario.addEventListener('submit', async (e) => {
    e.preventDefault();

    const personal_id = document.getElementById('personal_id').value;
    const personalData = {
        nombre: document.getElementById('nombre').value,
        apellidos: document.getElementById('apellidos').value,
        tipo_identificacion: document.getElementById('tipo_identificacion').value,
        numero_documento: document.getElementById('numero_documento').value,
        genero: document.getElementById('genero').value,
        fecha_nacimiento: document.getElementById('fecha_nacimiento').value,
        numero_celular: document.getElementById('numero_celular').value,
        direccion: document.getElementById('direccion').value,
        perfil: document.getElementById('perfil').value,
    };

    if (personal_id) {
        personalData.personal_id = personal_id;
        await actualizarPersonal(personalData);
    } else {
        await crearPersonal(personalData);
    }

    formulario.reset();
    obtenerPersonal();
});

// Función para obtener el listado de personal
async function obtenerPersonal() {
    try {
        const response = await fetch(`${API_URL}/obtener`);
        const personalList = await response.json();

        const tbody = document.getElementById('personal-list');
        tbody.innerHTML = '';

        personalList.forEach((personal) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${personal.personal_id}</td>
                <td>${personal.nombre}</td>
                <td>${personal.apellidos}</td>
                <td>${personal.tipo_identificacion}</td>
                <td>${personal.numero_documento}</td>
                <td>${personal.perfil}</td>
                <td>
                    <button class="editar" onclick="editarPersonal(${personal.personal_id})">Editar</button>
                    <button class="eliminar" onclick="eliminarPersonal(${personal.personal_id})">Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error al obtener el personal:', error);
    }
}

// Función para crear un personal
async function crearPersonal(data) {
    try {
        const response = await fetch(`${API_URL}/crear`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Indica que los datos son JSON
            },
            body: JSON.stringify(data), // Convertir el objeto JavaScript a JSON
        });
        if (!response.ok) throw new Error('Error al crear personal');
    } catch (error) {
        console.error('Error al crear el personal:', error);
    }
}

// Función para editar un personal
async function editarPersonal(id) {
    try {
        const response = await fetch(`${API_URL}/${id}`);
        const personal = await response.json();

        document.getElementById('personal_id').value = personal.personal_id;
        document.getElementById('nombre').value = personal.nombre;
        document.getElementById('apellidos').value = personal.apellidos;
        document.getElementById('tipo_identificacion').value = personal.tipo_identificacion;
        document.getElementById('numero_documento').value = personal.numero_documento;
        document.getElementById('genero').value = personal.genero;
        document.getElementById('fecha_nacimiento').value = personal.fecha_nacimiento;
        document.getElementById('numero_celular').value = personal.numero_celular;
        document.getElementById('direccion').value = personal.direccion;
        document.getElementById('perfil').value = personal.perfil;
    } catch (error) {
        console.error('Error al editar personal:', error);
    }
}

// Función para actualizar un personal
async function actualizarPersonal(data) {
    try {
        const response = await fetch(`${API_URL}/actualizar`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json', // Indica que los datos son JSON
            },
            body: JSON.stringify(data), // Convertir el objeto JavaScript a JSON
        });
        if (!response.ok) throw new Error('Error al actualizar personal');
    } catch (error) {
        console.error('Error al actualizar el personal:', error);
    }
}

// Función para eliminar un personal
async function eliminarPersonal(id) {
    try {
        const response = await fetch(`${API_URL}/eliminar`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json', // Indica que los datos son JSON
            },
            body: JSON.stringify({ personal_id: id }), // Enviar el ID del personal como JSON
        });
        if (!response.ok) throw new Error('Error al eliminar personal');
        obtenerPersonal(); // Actualizar la lista después de eliminar
    } catch (error) {
        console.error('Error al eliminar el personal:', error);
    }
}
