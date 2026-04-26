document.addEventListener("DOMContentLoaded", () => {
  const visor = document.getElementById("visorNota");

  const notaId = document.getElementById("notaId");
  const notaTitulo = document.getElementById("notaTitulo");
  const notaContenido = document.getElementById("notaContenido");

  const btnCrear = document.getElementById("btnCrearNota");
  const btnGuardar = document.getElementById("btnGuardar");
  const btnEditar = document.getElementById("btnEditar");
  const btnArchivar = document.getElementById("btnArchivar");
  const btnEliminar = document.getElementById("btnEliminar");
  const btnCerrar = document.getElementById("btnCerrar");

  const listaGuardadas = document.getElementById("listaGuardadas");
  const listaArchivadas = document.getElementById("listaArchivadas");

  let modoActual = "crear"; // crear | editar | archivada

  cargarNotas();

  btnCrear.addEventListener("click", () => {
    abrirHoja("crear");
  });

  btnCerrar.addEventListener("click", cerrarHoja);

  btnGuardar.addEventListener("click", guardarNota);
  btnEditar.addEventListener("click", editarNota);
  btnArchivar.addEventListener("click", archivarNota);
  btnEliminar.addEventListener("click", eliminarNota);

  function abrirHoja(modo, nota = null) {
    modoActual = modo;
    configurarBotones();

    if (nota) {
      notaId.value = nota.id;
      notaTitulo.value = nota.titulo;
      notaContenido.value = nota.contenido;
    } else {
      notaId.value = "";
      notaTitulo.value = "";
      notaContenido.value = "";
    }

    visor.classList.remove("visor-oculto");
  }

  function cerrarHoja() {
    visor.classList.add("visor-oculto");
  }

  function configurarBotones() {
    btnGuardar.style.display = modoActual === "crear" ? "inline-block" : "none";
    btnEditar.style.display = modoActual === "editar" ? "inline-block" : "none";
    btnArchivar.style.display = modoActual === "editar" ? "inline-block" : "none";
    btnEliminar.style.display = modoActual !== "crear" ? "inline-block" : "none";
  }

  function cargarNotas() {
    fetch("notas.php?accion=listar")
      .then(r => r.json())
      .then(data => {
        listaGuardadas.innerHTML = "";
        listaArchivadas.innerHTML = "";

        data.guardadas.forEach(n => crearTarjeta(n, listaGuardadas, true));
        data.archivadas.forEach(n => crearTarjeta(n, listaArchivadas, false));
      });
  }

  function crearTarjeta(nota, contenedor, conArchivar) {
    const div = document.createElement("div");
    div.className = "nota";
    div.innerHTML = `<h3>${nota.titulo}</h3><p>${nota.contenido}</p>`;

    if (conArchivar) {
      const b = document.createElement("button");
      b.textContent = "Archivar";
      b.onclick = e => {
        e.stopPropagation();
        archivarPorId(nota.id);
      };
      div.appendChild(b);
    }

    div.onclick = () =>
      abrirHoja(conArchivar ? "editar" : "archivada", nota);

    contenedor.appendChild(div);
  }

  function guardarNota() {
    enviar("agregar");
  }

  function editarNota() {
    enviar("editar");
  }

  function archivarNota() {
    enviar("eliminar");
  }

  function eliminarNota() {
    if (confirm("Eliminar definitivamente?")) enviar("borrar");
  }

  function archivarPorId(id) {
    const f = new FormData();
    f.append("accion", "eliminar");
    f.append("id", id);
    fetch("notas.php", { method: "POST", body: f }).then(cargarNotas);
  }

  function enviar(accion) {
    const f = new FormData();
    f.append("accion", accion);
    f.append("id", notaId.value);
    f.append("titulo", notaTitulo.value);
    f.append("contenido", notaContenido.value);

    fetch("notas.php", { method: "POST", body: f })
      .then(() => {
        cerrarHoja();
        cargarNotas();
      });
  }
});