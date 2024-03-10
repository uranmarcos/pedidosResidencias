function eliminarUsuarios(id, nombre, apellido) {
    let usuarioAEliminar = document.getElementById("usuarioAEliminar")
    usuarioAEliminar.innerHTML = " - " + nombre + "  " + apellido + " - "
    let idUsuarioEliminar = document.getElementById("idUsuarioEliminar")
    idUsuarioEliminar.value = id
}
function deshabilitarBotonTrash (id, rol) {
    let boton = document.getElementById("trashButton"+id)
    if (rol.toLowerCase() == "admin"){
        boton.setAttribute("disabled", true)    
    }
}
function cargarDatosEdicion(id, nombre, segundoNombre, apellido, dni, rol, mail, sede, casa){
    document.getElementById("idUsuarioEdicion").value = id
    document.getElementById("primerNombreEdicion").value = nombre
    document.getElementById("segundoNombreEdicion").value = segundoNombre
    document.getElementById("apellidoEdicion").value = apellido
    document.getElementById("dniEdicion").value = dni
    document.getElementById("rolEdicion").value = rol
    document.getElementById("mailEdicion").value = mail
    document.getElementById("sedeEdicion").value = sede
    document.getElementById("casaEdicion").value = casa
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
function validarCampo (idCampo, idCampoError) {
    let valor = document.getElementById(idCampo).value
    let campoError = document.getElementById(idCampoError)
    campoError.classList.remove("hide")

    switch (idCampo) {
        case "primerNombreCreacion":
        case "primerNombreEdicion":
        case "apellidoCreacion":
        case "apellidoEdicion":
            if (valor.trim().length < 3) {
                campoError.innerHTML = "Mínimo 3 dígitos"
            } else {
                if (!soloLetras(valor)){
                    campoError.innerHTML = "Solo letras y espacios"
                } else {
                    campoError.classList.add("hide")
                }
            }
        break;
    
        case "segundoNombreCreacion":
        case "segundoNombreEdicion":
            if(valor.trim() != ""){
                if (valor.length < 3) {
                    campoError.innerHTML = "Mínimo 3 dígitos"
                } else {
                    if (!soloLetras(valor)){
                        campoError.innerHTML = "Solo letras y espacios"
                    } else {
                        campoError.classList.add("hide")
                    }
                }
            } else{
                campoError.classList.add("hide")
            }
        break;
    
        case "dniCreacion":
            if (valor.length < 8) {
                campoError.innerHTML = "8 dígitos"
            } else {
                if (!isNumber(valor)){
                    campoError.innerHTML = "Campo numérico"
                } else {
                    campoError.classList.add("hide")
                }
            }
        break;
    
        case "mailCreacion":
        case "mailEdicion":
            if (!isEmailAddress(valor)){
                campoError.innerHTML = "Formato incorrecto"
            } else {
                campoError.classList.add("hide")
            }
        break;  
    
        default:
        break;
    }  
}
function bloquearFormularioCreacion() {
    let btnLimpiar = document.getElementById("btnLimpiarCreacion")
    btnLimpiar.setAttribute("disabled", true)
    let primerNombre = document.getElementById("primerNombreCreacion")
    primerNombre.setAttribute("disabled", true)
    let segundoNombre = document.getElementById("segundoNombreCreacion")
    segundoNombre.setAttribute("disabled", true)
    let apellido = document.getElementById("apellidoCreacion")
    apellido.setAttribute("disabled", true)
    let dni = document.getElementById("dniCreacion")
    dni.setAttribute("disabled", true)
    let rol = document.getElementById("rolCreacion")
    rol.setAttribute("disabled", true)
    let mail = document.getElementById("mailCreacion")
    mail.setAttribute("disabled", true)
    let sede = document.getElementById("sedeCreacion")
    sede.setAttribute("disabled", true)
    let casa = document.getElementById("casaCreacion")
    casa.setAttribute("disabled", true)
}
function desbloquearFormularioCreacion() {
    let btnLimpiar = document.getElementById("btnLimpiarCreacion")
    btnLimpiar.removeAttribute("disabled")
    let primerNombre = document.getElementById("primerNombreCreacion")
    primerNombre.removeAttribute("disabled")
    let segundoNombre = document.getElementById("segundoNombreCreacion")
    segundoNombre.removeAttribute("disabled")
    let apellido = document.getElementById("apellidoCreacion")
    apellido.removeAttribute("disabled")
    let dni = document.getElementById("dniCreacion")
    dni.removeAttribute("disabled")
    let rol = document.getElementById("rolCreacion")
    rol.removeAttribute("disabled")
    let mail = document.getElementById("mailCreacion")
    mail.removeAttribute("disabled")
    let sede = document.getElementById("sedeCreacion")
    sede.removeAttribute("disabled")
    let casa = document.getElementById("casaCreacion")
    casa.removeAttribute("disabled")
}
function validarFormCreacion () {
    let primerNombre = document.getElementById("primerNombreCreacion").value
    let segundoNombre = document.getElementById("segundoNombreCreacion").value
    let apellido = document.getElementById("apellidoCreacion").value
    let dni = document.getElementById("dniCreacion").value
    let mail = document.getElementById("mailCreacion").value
    let btn = document.getElementById("btnCreacion")
    
    // VALIDACION PRIMER NOMBRE
    if (primerNombre.trim().length < 3) {
        btn.setAttribute("disabled", true)
        return
    } else {
        if (!soloLetras(primerNombre)){
            btn.setAttribute("disabled", true)
            return
        }
    }

    // VALIDACION SEGUNDO NOMBRE
    if (segundoNombre.trim() != "") {
        if (segundoNombre.trim().length < 3) {
            btn.setAttribute("disabled", true)
            return
        } else {
            if (!soloLetras(segundoNombre)){
                btn.setAttribute("disabled", true)
                return
            }
        }
    }

    // VALIDACION APELLIDO
    if (apellido.trim().length < 3) {
        btn.setAttribute("disabled", true)
        return
    } else {
        if (!soloLetras(apellido)){
            btn.setAttribute("disabled", true)
            return
        }
    }
    
    // VALIDACION DNI
    if (dni.length < 8) {
        btn.setAttribute("disabled", true)
        return
    } else {
        if (!isNumber(dni)){
            btn.setAttribute("disabled", true)
            return
        }
    }
    
    // VALIDACION MAIL
    if (!isEmailAddress(mail)){
        btn.setAttribute("disabled", true)
        return
    } 

    btn.removeAttribute("disabled")

}
function validarFormEdicion () {
    let primerNombre = document.getElementById("primerNombreEdicion").value
    let segundoNombre = document.getElementById("segundoNombreEdicion").value
    let apellido = document.getElementById("apellidoEdicion").value
    let mail = document.getElementById("mailEdicion").value
    let btn = document.getElementById("btnEdicion")
    
    // VALIDACION PRIMER NOMBRE
    if (primerNombre.trim().length < 3) {
        btn.setAttribute("disabled", true)
        return
    } else {
        if (!soloLetras(primerNombre)){
            btn.setAttribute("disabled", true)
            return
        }
    }

    // VALIDACION SEGUNDO NOMBRE
    if (segundoNombre.trim() != "") {
        if (segundoNombre.trim().length < 3) {
            btn.setAttribute("disabled", true)
            return
        } else {
            if (!soloLetras(segundoNombre)){
                btn.setAttribute("disabled", true)
                return
            }
        }
    }

    // VALIDACION APELLIDO
    if (apellido.trim().length < 3) {
        btn.setAttribute("disabled", true)
        return
    } else {
        if (!soloLetras(apellido)){
            btn.setAttribute("disabled", true)
            return
        }
    }
       
    // VALIDACION MAIL
    if (!isEmailAddress(mail)){
        btn.setAttribute("disabled", true)
        return
    } 

    btn.removeAttribute("disabled")

}
function bloquearFormularioEdicion() {
    // let btnLimpiar = document.getElementById("btnLimpiarEdicion")
    // btnLimpiar.setAttribute("disabled", true)
    let primerNombre = document.getElementById("primerNombreEdicion")
    primerNombre.setAttribute("disabled", true)
    let segundoNombre = document.getElementById("segundoNombreEdicion")
    segundoNombre.setAttribute("disabled", true)
    let apellido = document.getElementById("apellidoEdicion")
    apellido.setAttribute("disabled", true)
    let rol = document.getElementById("rolEdicion")
    rol.setAttribute("disabled", true)
    let mail = document.getElementById("mailEdicion")
    mail.setAttribute("disabled", true)
    let sede = document.getElementById("sedeEdicion")
    sede.setAttribute("disabled", true)
    let casa = document.getElementById("casaEdicion")
    casa.setAttribute("disabled", true)
}
function desbloquearFormularioEdicion() {
    // let btnLimpiar = document.getElementById("btnLimpiarEdicion")
    // btnLimpiar.removeAttribute("disabled")
    let primerNombre = document.getElementById("primerNombreEdicion")
    primerNombre.removeAttribute("disabled")
    let segundoNombre = document.getElementById("segundoNombreEdicion")
    segundoNombre.removeAttribute("disabled")
    let apellido = document.getElementById("apellidoEdicion")
    apellido.removeAttribute("disabled")
    let rol = document.getElementById("rolEdicion")
    rol.removeAttribute("disabled")
    let mail = document.getElementById("mailEdicion")
    mail.removeAttribute("disabled")
    let sede = document.getElementById("sedeEdicion")
    sede.removeAttribute("disabled")
    let casa = document.getElementById("casaEdicion")
    casa.removeAttribute("disabled")
}
function limpiarFormularioCreacion () {
    document.getElementById("primerNombreCreacion").value = ""
    document.getElementById("segundoNombreCreacion").value = ""
    document.getElementById("apellidoCreacion").value = ""
    document.getElementById("dniCreacion").value = ""
    document.getElementById("rolCreacion").value = "stock"
    document.getElementById("mailCreacion").value = ""
    document.getElementById("sedeCreacion").value = 1
    document.getElementById("casaCreacion").value = 1
    limpiarValidaciones("crear")
}
function limpiarFormularioEdicion () {
    document.getElementById("idUsuarioEdicion").value = ""
    document.getElementById("primerNombreEdicion").value = ""
    document.getElementById("segundoNombreEdicion").value = ""
    document.getElementById("apellidoEdicion").value = ""
    document.getElementById("rolEdicion").value = "stock"
    document.getElementById("mailEdicion").value = ""
    document.getElementById("sedeEdicion").value = 1
    document.getElementById("casaEdicion").value = 1
    limpiarValidaciones("editar")
}
function limpiarValidaciones(accion) {
    if(accion == "crear") {
        document.getElementById("errorPrimerNombreCreacion").classList.add("hide")
        document.getElementById("errorSegundoNombreCreacion").classList.add("hide")
        document.getElementById("errorApellidoCreacion").classList.add("hide")
        document.getElementById("errorDniCreacion").classList.add("hide")
        document.getElementById("errorMailCreacion").classList.add("hide")
    } else {
        document.getElementById("errorPrimerNombreEdicion").classList.add("hide")
        document.getElementById("errorSegundoNombreEdicion").classList.add("hide")
        document.getElementById("errorApellidoEdicion").classList.add("hide")
        document.getElementById("errorMailEdicion").classList.add("hide")
    }
}









    function cargarResetPassword(id, dni, nombre, segundoNombre, apellido) {
        let spanResetPassword = document.getElementById("spanResetPassword")
        spanResetPassword.innerHTML = nombre + " " + segundoNombre + " " + apellido
        let idUsuarioResetPassword = document.getElementById("idUsuarioResetPassword")
        idUsuarioResetPassword.value = id
        let dniUsuarioResetPassword = document.getElementById("dniUsuarioResetPassword")
        dniUsuarioResetPassword.value = dni
    }
