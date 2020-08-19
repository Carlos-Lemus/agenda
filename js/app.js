const formularioContactos = document.querySelector("#contacto");
const listadoContactos = document.querySelector("#listado-contactos tbody");
const buscar = document.querySelector("#buscar");


evenListener();

function evenListener() {

    //formulario de añadir y editar
    formularioContactos.addEventListener("submit", leerFormulario);

    if(listadoContactos) {
        listadoContactos.addEventListener("click", eliminarContacto);
    }

    if(buscar) {
        buscar.addEventListener("input", buscarContacto);

        numerosContactos();
    }

}

function leerFormulario(e) {
    e.preventDefault();
    
    // Leer los datos de los nombres

    const nombre = document.querySelector("#nombre");
    const empresa = document.querySelector("#empresa");
    const telefono = document.querySelector("#telefono");
    const accion = document.querySelector("#accion");

    if(nombre.value === '' || empresa.value === '' || telefono.value === ''){
        mostrarNotificacion("Todos los campos son obligatorios", "error");
    } else {

        // pasa la validacion para llamar ha ajax

        const infoContacto = new FormData();

        infoContacto.append("nombre", nombre.value);
        infoContacto.append("empresa", empresa.value);
        infoContacto.append("telefono", telefono.value);
        infoContacto.append("accion", accion.value);

        // console.log(...infoContacto);

        if(accion.value === "crear") {

            //crearemos un nuevo contacto
            insertBD(infoContacto);

        } else {
            
            //editar el contacto
            const idRegistro = document.querySelector("#id"); 
            
            infoContacto.append("id", idRegistro.value);

            actualizarRegistro(infoContacto);
        }

        setTimeout(() => {
            window.location.href = "index.php";
        }, 4000);

    }
}

function insertBD(datos) {

    // llamar a ajax

    // crear el objeto
    const xhr = new XMLHttpRequest();

    // abrir la conexion
    xhr.open("POST", "includes/modelos/modelos-contactos.php",true);
    
    // pasar los datos
    xhr.onload = function() {

        if(this.status === 200) {

            try {
                const respuesta = JSON.parse(xhr.responseText);
                
                //agregando el nuevo contacto en la tabla

                let nuevoContacto = document.createElement("tr");
                nuevoContacto.innerHTML = `
                    <td>${respuesta.datos.nombre}</td>
                    <td>${respuesta.datos.empresa}</td>
                    <td>${respuesta.datos.telefono}</td>
                `;

                let contenidoAcciones = document.createElement("td");

                //creando el boton para editar

                let btnEditar = document.createElement("a");
                btnEditar.classList.add("btn", "btn-editar");

                let iconEditar = document.createElement("i");
                iconEditar.classList.add("fas", "fa-pen-square");

                btnEditar.appendChild(iconEditar);

                //creando el boton para eliminar

                let btnEliminar = document.createElement("button");
                btnEliminar.classList.add("btn", "btn-eliminar");
                btnEliminar.setAttribute("data_id", respuesta.datos.info);

                let iconEliminar = document.createElement("i");
                iconEliminar.classList.add("fas", "fa-trash-alt");

                btnEliminar.appendChild(iconEliminar);
                
                contenidoAcciones.appendChild(btnEditar);
                contenidoAcciones.appendChild(btnEliminar);

                // agregamos el nuevo tr
                nuevoContacto.appendChild(contenidoAcciones);

                // agregamos el nuevo contacto a la tabla
                listadoContactos.appendChild(nuevoContacto);

                // vaciando los campos de los formularios

                formularioContactos.reset();

                numerosContactos();

                mostrarNotificacion("Se ha añadido el contacto con exito", "correcto");

            } catch(ex) {
                console.log(ex.message);
            }

            // leemos la respuesta de php
        }

    }

    // enviar los datos
    xhr.send(datos);

}

function actualizarRegistro(datos) {

    //creamos el objeto
    xhr = new XMLHttpRequest();

    //abribos la conexion
    xhr.open("POST", "includes/modelos/modelos-contactos.php", true);

    // leemos la respuesta
    xhr.onload = function() {

        if(xhr.status == 200) {
            let resultado = JSON.parse(xhr.responseText);
            
            if(resultado.respuesta == "correcto") {   
                mostrarNotificacion("Se ha modificado el contacto con exito", "correcto");
            } else {
                mostrarNotificacion("Ha ocurrido un error...", "error");
            }

        }

    }

    // enviamos los datos
    xhr.send(datos);

}

function eliminarContacto(e) {

    if(e.target.parentElement.classList.contains("btn-eliminar")) {
            
            let confirmar = confirm("¿Estas seguro que quieres borrar un contacto?");

            if(confirmar) {
                // llamar a ajax
    
                const id = e.target.parentElement.getAttribute("id_data");
    
                // crear el objeto
                const xhr  = new XMLHttpRequest();
    
                //abro la conexion
                xhr.open("GET", `includes/modelos/modelos-contactos.php?id=${id}&accion=borrar`, true);
    
                // leer los datos
                xhr.onload = function() {
    
                    if(xhr.status == 200) {
                        let resultado = JSON.parse(xhr.responseText);
                        
                        if(resultado.respuesta == "correcto") {

                            let td = e.target.parentElement.parentElement.parentElement;
                            td.remove();

                            numerosContactos();

                            mostrarNotificacion("Se ha eliminado el contacto con exito", "correcto");

                        } else {
                            mostrarNotificacion("Ha ocurrido un error...", "error");
                        }
                    }
    
                }
    
                //enviar datos
                xhr.send();
            }
    }

}

function buscarContacto(e) {

    var expresion = new RegExp(e.target.value, "i");
    var registros = document.querySelectorAll("tbody tr");

    registros.forEach( registro => {
        registro.style.display = "none";

        if(registro.childNodes[1].textContent.replace(/\s/g, " ").search(expresion) != -1) {
            registro.style.display = "table-row";
        }
 
    });

    numerosContactos();
}

function numerosContactos() {

    const totalContactos = document.querySelectorAll("tbody tr");
    const contenedorNumeroContactos = document.querySelector(".total-contactos span");
    let total = 0;
    
    totalContactos.forEach(contacto => {

        if(contacto.style.display === "" || contacto.style.display === "table-row") {
            total++;
        }

    });

    contenedorNumeroContactos.textContent = total;

}

//mostrar un mensaje en la pantalla

function mostrarNotificacion(mensaje, clase) {
    
    const notificacion = document.createElement("div");
    notificacion.textContent = mensaje;
    notificacion.classList.add(clase, "notificacion", "sombra");

    formularioContactos.insertBefore(notificacion, document.querySelector("form legend"));

    //mostrar y ocultar la notificacion

    setTimeout(() => {
        
        notificacion.classList.add("visible");
        
        setTimeout(() => {
            notificacion.classList.remove("visible");
            
            setTimeout(() => {
                notificacion.remove();
            }, 500);

        }, 3000);
        
    }, 100);

}