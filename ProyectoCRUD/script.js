document.addEventListener('DOMContentLoaded', function() {
    // Inicializar componentes de Materialize
    M.AutoInit();
  
    // Referencias a elementos del DOM
    const nombreInput = document.getElementById('nombre');
    const telefonoInput = document.getElementById('telefono');
    const emailInput = document.getElementById('email');
    const notasInput = document.getElementById('notas');
    const submitButton = document.querySelector('.btn-submit');
    const contactTableBody = document.querySelector('#contact-table tbody');
    let contactoEditando = null;
  
    // Manejar el evento de envío del formulario
    submitButton.addEventListener('click', function(event) {
      event.preventDefault();
  
      // Obtener los valores de los campos del formulario
      const nombre = nombreInput.value.trim();
      const telefono = telefonoInput.value.trim();
      const email = emailInput.value.trim();
      const notas = notasInput.value.trim();
  
      // Validar los campos
      if (nombre === '' || telefono === '' || email === '') {
        M.toast({html: 'Por favor complete todos los campos requeridos', classes: 'red'});
        return;
      }
  
      // Crear objeto FormData y añadir los campos del formulario
      const formData = new FormData();
      formData.append('nombre', nombre);
      formData.append('telefono', telefono);
      formData.append('email', email);
      formData.append('notas', notas);
  
      let url = 'guardar_contacto.php';
      if (contactoEditando !== null) {
        formData.append('id', contactoEditando);
        url = 'actualizar_contacto.php';
      }
  
      // Enviar los datos usando fetch API
      fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        console.log('Respuesta del servidor:', data);  // Agregar mensaje de depuración
        M.toast({html: data, classes: 'green'});
        cargarContactos();  // Actualizar la lista de contactos
  
        // Limpiar los campos del formulario
        nombreInput.value = '';
        telefonoInput.value = '';
        emailInput.value = '';
        notasInput.value = '';
        contactoEditando = null; // Resetear la variable de contacto en edición
        submitButton.innerText = 'Enviar'; // Cambiar el texto del botón a "Enviar"
      })
      .catch(error => {
        console.error('Error:', error);
        M.toast({html: 'Error al guardar el contacto', classes: 'red'});
      });
    });
  
    // Función para cargar contactos
    function cargarContactos() {
      fetch('obtener_contactos.php')
        .then(response => response.json())
        .then(data => {
          contactTableBody.innerHTML = '';
          data.forEach(contacto => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td class="col-nombre">${contacto.nombre}</td>
              <td class="col-telefono">${contacto.telefono}</td>
              <td class="col-email">${contacto.email}</td>
              <td class="col-notas">${contacto.notas}</td>
              <td class="col-acciones">
                <button class="btn-small yellow darken-2 btn-editar" data-id="${contacto.id}">Editar</button>
                <button class="btn-small red darken-2 btn-borrar" data-id="${contacto.id}">Borrar</button>
              </td>
            `;
            contactTableBody.appendChild(row);
          });
  
          // Agregar eventos a los botones de editar y borrar
          document.querySelectorAll('.btn-editar').forEach(button => {
            button.addEventListener('click', editarContacto);
          });
          document.querySelectorAll('.btn-borrar').forEach(button => {
            button.addEventListener('click', borrarContacto);
          });
        })
        .catch(error => {
          console.error('Error:', error);
          M.toast({html: 'Error al cargar los contactos', classes: 'red'});
        });
    }
  
    // Función para editar contacto
    function editarContacto(event) {
      const id = event.target.getAttribute('data-id');
      fetch(`obtener_contacto.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
          nombreInput.value = data.nombre;
          telefonoInput.value = data.telefono;
          emailInput.value = data.email;
          notasInput.value = data.notas;
          contactoEditando = id;
          submitButton.innerText = 'Actualizar'; // Cambiar el texto del botón a "Actualizar"
        })
        .catch(error => {
          console.error('Error:', error);
          M.toast({html: 'Error al obtener el contacto', classes: 'red'});
        });
    }
  
    // Función para borrar contacto
    function borrarContacto(event) {
      const id = event.target.getAttribute('data-id');
      if (confirm('¿Estás seguro de que deseas eliminar este contacto?')) {
        fetch('borrar_contacto.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${id}`
        })
        .then(response => response.text())
        .then(data => {
          console.log('Respuesta del servidor:', data);  // Agregar mensaje de depuración
          M.toast({html: data, classes: 'green'});
          cargarContactos();  // Actualizar la lista de contactos
        })
        .catch(error => {
          console.error('Error:', error);
          M.toast({html: 'Error al borrar el contacto', classes: 'red'});
        });
      }
    }
  
    // Cargar contactos al iniciar la página
    cargarContactos();
  });
  