
function mostrarCaja(idCaja, idCajaOcultar, idBoton=null) {
    ocultarCaja(idCajaOcultar)
    document.getElementById(idCaja).classList.remove("hide")
    document.getElementById(idCaja).scrollIntoView();
    if (idBoton != null) {
        document.getElementById(idBoton).classList.add("hide")
    }
}
function ocultarCaja(idCaja, idBoton=null) {
    document.getElementById(idCaja).classList.add("hide")
    if (idBoton != null) {
        document.getElementById(idBoton).classList.remove("hide")
    }
}
function validarFormCreacion () {
    let boton = document.getElementById("botonCrearSede")
    let provincia = document.getElementById("selectProvincia").value
    let ciudad = document.getElementById("inputNuevaSede").value
    if (provincia != "" && ciudad.length > 4) {
        boton.removeAttribute("disabled")
    } else {
        boton.setAttribute("disabled", true)
    }
}
function validarFormEdicion () {
    let botonEditar = document.getElementById("botonEditar")
    let provincia = document.getElementById("selectEdicionProvincia").value
    let ciudad = document.getElementById("inputEditarSede").value
    if (provincia != "" && ciudad.length > 4) {
        botonEditar.removeAttribute("disabled")
    } else {
        botonEditar.setAttribute("disabled", true)
    }

}
function crearNuevaSede () {
    let provincia = document.getElementById("selectProvincia").value
    let ciudad = document.getElementById("inputNuevaSede").value
    let cantidadCasas = document.getElementById("selectCasas").value
    let spanNuevaSede = document.getElementById("spanNuevaSede")
    let casas = "casas"
    if (cantidadCasas == 1) {
        casas = "casa"
    }
    spanNuevaSede.innerHTML = provincia + " - " + ciudad + " con " + cantidadCasas + " " + casas +"?"
}
function mostrarSpinner (idBotonOcultar, idBotonMostrar) {
    let botonOcultar = document.getElementById(idBotonOcultar) 
    let botonMostrar = document.getElementById(idBotonMostrar) 
    botonOcultar.classList.add("hide")
    botonMostrar.classList.remove("hide")
}
function confirmarCrearSede () {
    let botonConfirmarCrearSede = document.getElementById("botonConfirmarCrearSede") 
    let spinnerGenerarSede = document.getElementById("spinnerGenerarSede") 
    botonConfirmarCrearSede.classList.add("hide")
    spinnerGenerarSede.classList.remove("hide")
}
function confirmarEliminarSede () {
    let btnEliminarSede = document.getElementById("btnEliminarSede") 
    let spinnerEliminarSede = document.getElementById("spinnerEliminarSede") 
    btnEliminarSede.classList.add("hide")
    spinnerEliminarSede.classList.remove("hide")
}
function eliminarSedes(id, descripcion) {
    document.getElementById("sedeAEliminar").innerHTML = " - " + descripcion + " - "
    document.getElementById("idSedeEliminar").value = id
}
// CARGA LOS DATOS DE BASE DE LA SEDE EN EL BOX EDITABLE 
function cargarDatosEdicion(id, provincia, descripcion, casas){
    document.getElementById("idSedePorEditar").value = id
    document.getElementById("selectEdicionProvincia").value = provincia
    document.getElementById("inputEditarSede").value = descripcion
    document.getElementById("selectEditarCasas").value = casas
    document.getElementById("mensajeValidacionEditar").classList.add("hide")
}













// FUNCION PARA HABILITAR UN BOTON EN BASE A VALIDACION DE INPUT - PARAMETROS: VALUE, LENGTH, IDBOTON A HABILITAR 
function habilitarBoton(value, length, id, idMensajeValidacion) {
    let boton = document.getElementById(id)
    let mensajeValidacion = document.getElementById(idMensajeValidacion)
    let spanSede = document.getElementById("spanSede")
    let casas = document.getElementById("selectCasas").value
    if(value.length >= length) {
        boton.removeAttribute("disabled");
        mensajeValidacion.classList.add('hide')
        spanSede.innerHTML = value + " con " + (casas == 1 ? "1 casa" : casas + " casas")
    }else{
        boton.setAttribute("disabled", true)
        mensajeValidacion.classList.remove('hide')
    }
}
//ACTUALIZACION DE DATOS EN MODAL CONFIRMACION DE CREACION DE SEDE, AL CAMBIAR CANTIDAD DE CASAS
function actualizarDatosModalCrear(cantidad){
    let descripcion = document.getElementById("inputNuevaSede").value
    //let descripcion = document.getElementById("inputNuevaSede").value
    let spanSede = document.getElementById("spanSede")
    if (descripcion != "") {
        spanSede.innerHTML = descripcion + " con " + (cantidad == 1 ? "1 casa" : cantidad + " casas")
    } 
}


function habilitarBotonDirecto (id) {
    let boton = document.getElementById(id)
    if (boton.hasAttribute("disabled")){
        boton.removeAttribute("disabled")    
    }
}

// CARGA LOS DATOS NUEVOS DE LA SEDE EN EL MODAL PIDIENDO CONFIRMACION
function enviarDatosEdicion(provincia, descripcion, casas) {
    let descripcionSede = document.getElementById(descripcion).value
    let descripcionProvincia = document.getElementById(provincia).value
    let casasSede = document.getElementById(casas).value
    let spanEdicionSede = document.getElementById("spanEdicionSede")
    spanEdicionSede.innerHTML = descripcionProvincia + ", " + descripcionSede + " - " +  (casasSede == 1 ? " 1 casa" : casasSede + " casas")
}
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