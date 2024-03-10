function ocultarAlertConfirmacion(){
    let alertConfirmacion = document.getElementById("alertConfirmacion")
    alertConfirmacion.classList.remove('show')
    alertConfirmacion.classList.add('hide')
}
function ocultarAlertError(){
    let alertErrorConexion = document.getElementById("alertErrorConexion")
    alertErrorConexion.classList.remove('show')
    alertErrorConexion.classList.add('hide')
}
function validarFormularioEdicion () {
    let descripcion = document.getElementById("descripcionEdicion").value
    let btnEdicion = document.getElementById("btnEdicion")
    btnEdicion.setAttribute("disabled", true)
    
    if(descripcion.length >=3) {
        btnEdicion.removeAttribute("disabled")
    } else {
        btnEdicion.setAttribute("disabled", true)
    }
}
function limpiarFormularioCreacion () {
    document.getElementById("descripcionCreacion").value = ""
    document.getElementById("medidaCreacion").value = 1
    document.getElementById("categoriaCreacion").value = 1
    let btnCreacion = document.getElementById("btnCreacion")
    btnCreacion.setAttribute("disabled", true)
    limpiarValidaciones("crear")
}
function limpiarFormularioEdicion () {
    document.getElementById("descripcionEdicion").value = ""
    document.getElementById("medidaEdicion").value = 1
    document.getElementById("categoriaEdicion").value = 1
    let btnEdicion = document.getElementById("btnEdicion")
    btnEdicion.setAttribute("disabled", true)
    limpiarValidaciones("editar")
}
function limpiarValidaciones(accion) {
    if(accion == "crear") {
        document.getElementById("mensajeValidacionCreacion").classList.add("hide")
    } else {
        document.getElementById("mensajeValidacionEdicion").classList.add("hide")
    }
}
function pedirConfirmacion(idOcultar, idMostrar, accion) {
    let cajaOcultar = document.getElementById(idOcultar)
    cajaOcultar.classList.add("hide")
    let cajaMostrar = document.getElementById(idMostrar)
    cajaMostrar.classList.remove("hide")
    if (accion == "crear") {
        bloquearFormularioCreacion()
    } else {
        bloquearFormularioEdicion()
    }
}
function cancelarConfirmacion(idOcultar, idMostrar, accion) {
    let cajaOcultar = document.getElementById(idOcultar)
    cajaOcultar.classList.add("hide")
    let cajaMostrar = document.getElementById(idMostrar)
    cajaMostrar.classList.remove("hide")
    if (accion == "crear") {
        desbloquearFormularioCreacion()
    } else {
        desbloquearFormularioEdicion()
    }
}
function bloquearFormularioCreacion() {
    let btnLimpiar = document.getElementById("btnLimpiarFormCreacion")
    btnLimpiar.setAttribute("disabled", true)
    let descripcion = document.getElementById("descripcionCreacion")
    descripcion.setAttribute("disabled", true)
    let medida = document.getElementById("medidaCreacion")
    medida.setAttribute("disabled", true)
    let categoria = document.getElementById("categoriaCreacion")
    categoria.setAttribute("disabled", true)
}
function desbloquearFormularioCreacion() {
    let btnLimpiar = document.getElementById("btnLimpiarFormCreacion")
    btnLimpiar.removeAttribute("disabled")
    let descripcion = document.getElementById("descripcionCreacion")
    descripcion.removeAttribute("disabled")
    let medida = document.getElementById("medidaCreacion")
    medida.removeAttribute("disabled")
    let categoria = document.getElementById("categoriaCreacion")
    categoria.removeAttribute("disabled")
}
function bloquearFormularioEdicion() {
    // let btnLimpiar = document.getElementById("btnLimpiarFormEdicion")
    // btnLimpiar.setAttribute("disabled", true)
    let descripcion = document.getElementById("descripcionEdicion")
    descripcion.setAttribute("disabled", true)
    let medida = document.getElementById("medidaEdicion")
    medida.setAttribute("disabled", true)
    let categoria = document.getElementById("categoriaEdicion")
    categoria.setAttribute("disabled", true)
}
function desbloquearFormularioEdicion() {
    // let btnLimpiar = document.getElementById("btnLimpiarFormEdicion")
    // btnLimpiar.removeAttribute("disabled")
    let descripcion = document.getElementById("descripcionEdicion")
    descripcion.removeAttribute("disabled")
    let medida = document.getElementById("medidaEdicion")
    medida.removeAttribute("disabled")
    let categoria = document.getElementById("categoriaEdicion")
    categoria.removeAttribute("disabled")
}
function cargarDatosEdicion(id, descripcion, medida, categoria){
    document.getElementById("idArticuloEdicion").value = id
    document.getElementById("descripcionEdicion").value = descripcion
    document.getElementById("medidaEdicion").value = medida
    document.getElementById("categoriaEdicion").value = categoria
}
function eliminarArticulo(id, descripcion) {
    document.getElementById("articuloAEliminar").innerHTML = " - " + descripcion + " - "
    document.getElementById("idArticuloEliminar").value = id
}
//START FUNCIONES DEL FILTRO ADMIN
// function filtrar() {
//     let producto = document.getElementById("buscadorProducto").value.toLowerCase();
//     let listaFilas = document.getElementsByName("rowTable");
//     listaFilas = Array.from(listaFilas)
//     listaFilas.forEach(function callback(value) {
//         if (value.classList.contains("hide")) {
//             value.classList.remove("hide")
//         }
//     })
//     listaFilas.forEach(function callback(value) {
//         let parametro = null
//         parametro = value.firstElementChild.nextElementSibling.firstElementChild.innerHTML.toLowerCase()
//         if (!parametro.includes(producto)) {
//             value.classList.add("hide")
//         }
//     })
// }
function filtrar() {
    let producto = document.getElementById("buscadorProducto").value;
    let categoria = document.getElementById("selectCategoria").value;
    //let sede = document.getElementById("selectSede").value;
    if (producto != "" && categoria == "todos"){
        filtrarFilas(producto, "producto")
    } else if (producto == "" && categoria != "todos"){
        filtrarFilas(categoria, "categoria")
    } else if(producto != "" && categoria != "todos") {
        filtrarDoble(producto, categoria)
    } else {
        mostrarFilas()
    }
    // else {
    //     filtrarFilasPorDosParametros(mes, voluntario, sede)
    // }
}
function mostrarFilas() {
    let listaFilas = document.getElementsByName("rowTable");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value) {
        if (value.classList.contains("hide")) {
            value.classList.remove("hide")
        }
    })
}
function filtrarFilas(param, param2){
    mostrarFilas()
    let listaFilas = document.getElementsByName("rowTable");
    listaFilas.forEach(function callback(value) {
        let parametro = null
        if (param2 == "producto") {
            parametro = value.firstElementChild.nextElementSibling.firstElementChild.innerHTML.toLowerCase()
        } else if (param2 == "categoria") {
            parametro = value.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.firstElementChild.innerHTML.toLowerCase()
        } 
        if (!parametro.includes(param.toLowerCase())) {
            value.classList.add("hide")
        }
    })
}
function filtrarDoble(producto, categoria){
    mostrarFilas()
    let listaFilas = document.getElementsByName("rowTable");
    listaFilas.forEach(function callback(value) {
        //let parametro = null
        let productoValue = value.firstElementChild.nextElementSibling.firstElementChild.innerHTML.toLowerCase()
        let categoriaValue = value.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.firstElementChild.innerHTML
        
        if(!productoValue.includes(producto.toLowerCase()) || !categoriaValue.includes(categoria.toLowerCase())) {
            value.classList.add("hide")
        }
    })
}
