document.addEventListener('DOMContentLoaded', function() {
    const notaForm = document.getElementById('notaForm');
    const listaNotas = document.getElementById('listaNotas');
    
    // Cargar notas al inicio
    cargarNotas();
    
    // Agregar nueva nota
    notaForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const titulo = document.getElementById('titulo').value;
      const contenido = document.getElementById('contenido').value;
      
      if (titulo.trim() === '' || contenido.trim() === '') return;
      
      const formData = new FormData();
      formData.append('accion', 'agregar');
      formData.append('titulo', titulo);
      formData.append('contenido', contenido);
      
      fetch('notas.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.exito) {
          document.getElementById('titulo').value = '';
          document.getElementById('contenido').value = '';
          cargarNotas();
        }
      });
    });
    
    // Cargar notas desde el servidor
    function cargarNotas() {
      fetch('notas.php?accion=listar')
        .then(response => response.json())
        .then(data => {
          listaNotas.innerHTML = '';
          
          data.notas.forEach(nota => {
            const notaDiv = document.createElement('div');
            notaDiv.className = 'nota';
            notaDiv.dataset.id = nota.id;
            
            const titulo = document.createElement('h3');
            titulo.textContent = nota.titulo;
            
            const contenido = document.createElement('p');
            contenido.textContent = nota.contenido;
            
            const btnEliminar = document.createElement('button');
            btnEliminar.textContent = 'Eliminar';
            btnEliminar.className = 'eliminar';
            btnEliminar.addEventListener('click', function() {
              eliminarNota(nota.id);
            });
            
            notaDiv.appendChild(titulo);
            notaDiv.appendChild(contenido);
            notaDiv.appendChild(btnEliminar);
            listaNotas.appendChild(notaDiv);
          });
        });
    }
    
    // Eliminar nota
    function eliminarNota(id) {
      const formData = new FormData();
      formData.append('accion', 'eliminar');
      formData.append('id', id);
      
      fetch('notas.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.exito) {
          cargarNotas();
        }
      });
    }
  });