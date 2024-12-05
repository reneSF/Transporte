const API_URL = 'http://localhost/api/vehiculos'; 

// Obtener todos los vehículos al cargar la página
document.addEventListener('DOMContentLoaded', obtenerVehiculos);

const formulario = document.getElementById('vehiculo-form');

formulario.addEventListener('submit', async (e) => {
    e.preventDefault();
    const vehiculo_id = document.getElementById('vehiculo_id').value;
    const nombre_propietario = document.getElementById('nombre_propietario').value;
    const numero_placa = document.getElementById('numero_placa').value;
    const marca = document.getElementById('marca').value;
    const modelo = document.getElementById('modelo').value;
    const color = document.getElementById('color').value;

    const datosVehiculo = { nombre_propietario, numero_placa, marca, modelo, color };

    if (vehiculo_id) {
        actualizarVehiculo(vehiculo_id, datosVehiculo);
    } else {
        crearVehiculo(datosVehiculo);
    }
});

// Obtener vehículos
async function obtenerVehiculos() {
    try {
        const respuesta = await fetch(API_URL);
        const vehiculos = await respuesta.json();
        const tbody = document.getElementById('vehiculos-tbody');
        tbody.innerHTML = '';
        vehiculos.forEach((vehiculo) => {
            tbody.innerHTML += `
                <tr>
                    <td>${vehiculo.vehiculo_id}</td>
                    <td>${vehiculo.nombre_propietario}</td>
                    <td>${vehiculo.numero_placa}</td>
                    <td>${vehiculo.marca}</td>
                    <td>${vehiculo.modelo}</td>
                    <td>${vehiculo.color}</td>
                    <td>
                        <button class="editar" onclick="editarVehiculo(${vehiculo.vehiculo_id})">Editar</button>
                        <button class="eliminar" onclick="eliminarVehiculo(${vehiculo.vehiculo_id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error('Error al obtener los vehículos:', error);
    }
}

// Resalta el enlace activo en el menú
document.querySelectorAll('.navbar a').forEach(link => {
    if (link.href === window.location.href) {
        link.classList.add('active');
    }
});

// Opcional: Clase CSS para el botón activo
/* .active { font-weight: bold; border-bottom: 2px solid white; } */


// Crear vehículo
async function crearVehiculo(datosVehiculo) {
    try {
        const respuesta = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datosVehiculo),
        });
        if (respuesta.ok) {
            obtenerVehiculos();
            formulario.reset();
        }
    } catch (error) {
        console.error('Error al crear el vehículo:', error);
    }
}

// Editar vehículo
async function editarVehiculo(id) {
    try {
        const respuesta = await fetch(`${API_URL}/${id}`);
        const vehiculo = await respuesta.json();
        document.getElementById('vehiculo_id').value = vehiculo.vehiculo_id;
        document.getElementById('nombre_propietario').value = vehiculo.nombre_propietario;
        document.getElementById('numero_placa').value = vehiculo.numero_placa;
        document.getElementById('marca').value = vehiculo.marca;
        document.getElementById('modelo').value = vehiculo.modelo;
        document.getElementById('color').value = vehiculo.color;
    } catch (error) {
        console.error('Error al editar el vehículo:', error);
    }
}

// Actualizar vehículo
async function actualizarVehiculo(id, datosVehiculo) {
    try {
        const respuesta = await fetch(`${API_URL}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datosVehiculo),
        });
        if (respuesta.ok) {
            obtenerVehiculos();
            formulario.reset();
        }
    } catch (error) {
        console.error('Error al actualizar el vehículo:', error);
    }
}

// Eliminar vehículo
async function eliminarVehiculo(id) {
    try {
        const respuesta = await fetch(`${API_URL}/${id}`, {
            method: 'DELETE',
        });
        if (respuesta.ok) {
            obtenerVehiculos();
        }
    } catch (error) {
        console.error('Error al eliminar el vehículo:', error);
    }
}
