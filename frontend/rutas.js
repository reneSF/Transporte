const API_URL = 'http://localhost:8000/api/rutas'; // Ajusta según tu configuración

// Obtener todas las rutas al cargar la página
document.addEventListener('DOMContentLoaded', obtenerRutas);

const formulario = document.getElementById('ruta-form');

// Guardar ruta (crear o actualizar)
formulario.addEventListener('submit', async (e) => {
    e.preventDefault();

    const ruta_id = document.getElementById('ruta_id').value;
    const rutaData = {
        origen: document.getElementById('origen').value,
        destino: document.getElementById('destino').value,
    };

    if (ruta_id) {
        rutaData.ruta_id = ruta_id;
        await actualizarRuta(rutaData);
    } else {
        await crearRuta(rutaData);
    }

    formulario.reset();
    obtenerRutas();
});

// Obtener el listado de rutas
async function obtenerRutas() {
    try {
        const response = await fetch(`${API_URL}/obtener`);
        const rutas = await response.json();

        const tbody = document.getElementById('rutas-lista');
        tbody.innerHTML = '';

        rutas.forEach((ruta) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${ruta.ruta_id}</td>
                <td>${ruta.origen}</td>
                <td>${ruta.destino}</td>
                <td>
                    <button class="editar" onclick="editarRuta(${ruta.ruta_id})">Editar</button>
                    <button class="eliminar" onclick="eliminarRuta(${ruta.ruta_id})">Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error al obtener las rutas:', error);
    }
}

// Crear una nueva ruta
async function crearRuta(data) {
    try {
        const response = await fetch(`${API_URL}/crear`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Error al crear la ruta');
    } catch (error) {
        console.error('Error al crear la ruta:', error);
    }
}

// Editar una ruta
async function editarRuta(id) {
    try {
        const response = await fetch(`${API_URL}/${id}`);
        const ruta = await response.json();

        document.getElementById('ruta_id').value = ruta.ruta_id;
        document.getElementById('origen').value = ruta.origen;
        document.getElementById('destino').value = ruta.destino;
    } catch (error) {
        console.error('Error al editar la ruta:', error);
    }
}

// Actualizar una ruta
async function actualizarRuta(data) {
    try {
        const response = await fetch(`${API_URL}/actualizar`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Error al actualizar la ruta');
    } catch (error) {
        console.error('Error al actualizar la ruta:', error);
    }
}

// Eliminar una ruta
async function eliminarRuta(id) {
    try {
        const response = await fetch(`${API_URL}/eliminar`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ruta_id: id }),
        });
        if (!response.ok) throw new Error('Error al eliminar la ruta');
        obtenerRutas();
    } catch (error) {
        console.error('Error al eliminar la ruta:', error);
    }
}
