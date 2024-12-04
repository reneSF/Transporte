// URL base del backend
const API_URL = "http://localhost8888"; // Cambia esta URL según tu configuración del backend

// Referencias a elementos del DOM
const formCrearBoleto = document.getElementById("form-crear-boleto");
const cargarBoletosBtn = document.getElementById("cargar-boletos");
const boletosLista = document.getElementById("boletos-lista");

// Función para crear un boleto
formCrearBoleto.addEventListener("submit", async (event) => {
  event.preventDefault();

  // Recopilando datos del formulario
  const boletoData = {
    origen: document.getElementById("origen").value,
    nombre_vendedor: document.getElementById("nombre_vendedor").value,
    numero_serie: document.getElementById("numero_serie").value,
    precio: parseFloat(document.getElementById("precio").value),
    terminal_id: parseInt(document.getElementById("terminal_id").value),
  };

  try {
    // Realizando la solicitud al backend
    const response = await fetch(`${API_URL}/boletos`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer <tu-token>", // Agrega tu token si es necesario
      },
      body: JSON.stringify(boletoData),
    });

    const result = await response.json();

    if (response.ok) {
      alert("Boleto creado exitosamente.");
      formCrearBoleto.reset();
    } else {
      alert(`Error: ${result.error || "No se pudo crear el boleto."}`);
    }
  } catch (error) {
    console.error("Error al crear el boleto:", error);
    alert("Error al conectar con el servidor.");
  }
});

// Función para cargar la lista de boletos
cargarBoletosBtn.addEventListener("click", async () => {
  try {
    // Realizando la solicitud al backend
    const response = await fetch(`${API_URL}/boletos`, {
      headers: {
        Authorization: "Bearer <tu-token>", // Agrega tu token si es necesario
      },
    });

    const boletos = await response.json();

    if (response.ok) {
      // Limpiando la lista de boletos
      boletosLista.innerHTML = "";

      // Agregando boletos a la tabla
      boletos.forEach((boleto) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${boleto.boleto_id}</td>
          <td>${boleto.origen}</td>
          <td>${boleto.nombre_vendedor}</td>
          <td>${boleto.numero_serie}</td>
          <td>${boleto.precio}</td>
          <td>${boleto.terminal_id}</td>
        `;
        boletosLista.appendChild(row);
      });
    } else {
      alert(`Error: ${boletos.error || "No se pudo cargar la lista de boletos."}`);
    }
  } catch (error) {
    console.error("Error al cargar boletos:", error);
    alert("Error al conectar con el servidor.");
  }
});
