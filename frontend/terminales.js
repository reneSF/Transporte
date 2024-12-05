// Lista inicial de terminales (puedes agregar más aquí)
const terminales = [
    {
        nombre: "Terminal TAPO - Ciudad de México",
        direccion: "Zaragoza 200, Venustiano Carranza, CDMX",
        telefono: "555-123-4567"
    },
    {
        nombre: "Terminal Central del Norte - Ciudad de México",
        direccion: "Eje Central Lázaro Cárdenas 4907, Gustavo A. Madero, CDMX",
        telefono: "555-765-4321"
    },
    {
        nombre: "Terminal Central de Autobuses de Guadalajara",
        direccion: "Av. Dr. R. Michel 101, Colonia Jardines de San José, Guadalajara, Jalisco",
        telefono: "333-123-4567"
    },
    {
        nombre: "Terminal Central de Monterrey",
        direccion: "Av. Cristóbal Colón 855, Centro, Monterrey, Nuevo León",
        telefono: "818-765-4321"
    },
    {
        nombre: "Central de Autobuses de Puebla (CAPU)",
        direccion: "Blvd. Norte 4222, Colonia Las Cuartillas, Puebla, Puebla",
        telefono: "222-123-4567"
    },
    {
        nombre: "Terminal de Autobuses de Querétaro",
        direccion: "Prolongación Luis Vega y Monroy 801, Desarrollo San Pablo, Querétaro",
        telefono: "442-765-4321"
    },
    {
        nombre: "Central de Autobuses de Veracruz (CAVE)",
        direccion: "Av. Salvador Díaz Mirón 3621, Colonia Formando Hogar, Veracruz",
        telefono: "229-123-4567"
    }
];

// Resalta el enlace activo en el menú
document.querySelectorAll('.navbar a').forEach(link => {
    if (link.href === window.location.href) {
        link.classList.add('active');
    }
});

// Opcional: Clase CSS para el botón activo
/* .active { font-weight: bold; border-bottom: 2px solid white; } */


// Referencia al contenedor de terminales en el HTML
const terminalesLista = document.getElementById("terminales").querySelector("ul");

// Función para renderizar la lista de terminales
function renderTerminales(lista) {
    terminalesLista.innerHTML = ""; // Limpiar lista actual

    lista.forEach((terminal) => {
        const li = document.createElement("li");
        li.innerHTML = `
            <h2>${terminal.nombre}</h2>
            <p><strong>Dirección:</strong> ${terminal.direccion}</p>
            <p><strong>Teléfono:</strong> ${terminal.telefono}</p>
        `;
        terminalesLista.appendChild(li);
    });
}

// Renderizar la lista inicial
renderTerminales(terminales);

// Función para buscar terminales
function buscarTerminales(texto) {
    const resultado = terminales.filter((terminal) =>
        terminal.nombre.toLowerCase().includes(texto.toLowerCase()) ||
        terminal.direccion.toLowerCase().includes(texto.toLowerCase())
    );
    renderTerminales(resultado);
}

// Agregar funcionalidad de búsqueda
const buscador = document.createElement("input");
buscador.type = "text";
buscador.placeholder = "Buscar terminal...";
buscador.style.margin = "10px";
buscador.addEventListener("input", (e) => {
    buscarTerminales(e.target.value);
});

// Insertar el buscador al inicio del contenedor de terminales
document.getElementById("terminales").prepend(buscador);
