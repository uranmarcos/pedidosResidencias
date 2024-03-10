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
function eliminarCategoria(id, descripcion) {
    let categoriaAEliminar = document.getElementById("categoriaAEliminar")
    categoriaAEliminar.innerHTML = " - " + descripcion + " - "
    let idcategoriaEliminar = document.getElementById("idCategoriaEliminar")
    idcategoriaEliminar.value = id
}
function cargarDatosEdicion(id, descripcion){
    document.getElementById("idCategoriaEdicion").value = id
    document.getElementById("descripcionEdicion").value = descripcion
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
    let btnLimpiar = document.getElementById("btnLimpiarCreacion")
    btnLimpiar.setAttribute("disabled", true)
    let descripcion = document.getElementById("descripcionCreacion")
    descripcion.setAttribute("disabled", true)
}
function desbloquearFormularioCreacion() {
    let btnLimpiar = document.getElementById("btnLimpiarCreacion")
    btnLimpiar.removeAttribute("disabled")
    let descripcion = document.getElementById("descripcionCreacion")
    descripcion.removeAttribute("disabled")
}
function bloquearFormularioEdicion() {
    // let btnLimpiar = document.getElementById("btnLimpiarEdicion")
    // btnLimpiar.setAttribute("disabled", true)
    let descripcion = document.getElementById("descripcionEdicion")
    descripcion.setAttribute("disabled", true)
}
function desbloquearFormularioEdicion() {
    // let btnLimpiar = document.getElementById("btnLimpiarEdicion")
    // btnLimpiar.removeAttribute("disabled")
    let descripcion = document.getElementById("descripcionEdicion")
    descripcion.removeAttribute("disabled")
}
function limpiarFormularioCreacion () {
    document.getElementById("descripcionCreacion").value = ""
    let btnCrear = document.getElementById("btnCreacion")
    btnCrear.setAttribute("disabled", true)
    limpiarValidaciones("crear")
}
function limpiarFormularioEdicion () {
    document.getElementById("idCategoriaEdicion").value = ""
    document.getElementById("descripcionEdicion").value = ""
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