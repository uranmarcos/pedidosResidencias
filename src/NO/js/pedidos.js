function overReenviar(btnMostrar, btnOcultar) {
    let botonMostrar = document.getElementById(btnMostrar)
    let botonOcultar = document.getElementById(btnOcultar)
    botonMostrar.classList.remove("hide")
    botonOcultar.classList.add("hide")
}
function outReenviar(btnOcultar, btnMostrar) {
    let botonMostrar = document.getElementById(btnMostrar)
    let botonOcultar = document.getElementById(btnOcultar)
    botonMostrar.classList.remove("hide")
    botonOcultar.classList.add("hide")
}
function reenviarPedido() {
    let botonReenviarPedido = document.getElementById("botonReenviarPedido")
    let botonCircle = document.getElementById("botonCircle")
    botonReenviarPedido.classList.add("hide")
    botonCircle.classList.remove("hide")
}
function enviarPedido(id) {
    let modalConfirmacionReenvio = document.getElementById("modalConfirmacionReenvio")
    modalConfirmacionReenvio.classList.remove("hide")
    let idReenviarPedido = document.getElementById("idReenviarPedido")
    idReenviarPedido.value=id
}
function cancelarReenviarPedido() {
    let modalConfirmacionReenvio = document.getElementById("modalConfirmacionReenvio")
    modalConfirmacionReenvio.classList.add("hide")
}
function actualizarPedidoEnviado(){
    let btnActualizarEnviado = document.getElementById("btnActualizarEnviado")
    let btnCircleActualizarEnviado = document.getElementById("btnCircleActualizarEnviado")
    btnActualizarEnviado.classList.add("hide")
    btnCircleActualizarEnviado.classList.remove("hide")
}

//START FUNCIONES DEL FILTRO ADMIN
function filtrar() {
    let mes = document.getElementById("selectMes").value;
    let voluntario = document.getElementById("selectVoluntario").value;
    let sede = document.getElementById("selectSede").value;
    if (mes == "todos" && voluntario == "todos" && sede != "todos"){
        filtrarFilas(sede, "sede")
    } else if (mes == "todos" && voluntario != "todos" && sede == "todos"){
        filtrarFilas(voluntario, "voluntario")
    } else if (mes != "todos" && voluntario == "todos" && sede == "todos"){
        filtrarFilas(mes, "mes")
    } else if (mes == "todos" && voluntario == "todos" && sede == "todos"){
        quitarFiltros()
    } else if (mes != "todos" && voluntario != "todos" && sede != "todos"){
        filtrarFilasPorTresParametros(mes, voluntario, sede)
    } else {
        filtrarFilasPorDosParametros(mes, voluntario, sede)
    }
}
function quitarFiltros(){
    let listaFilas = document.getElementsByName("rowTableAdmin");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value, index) {
        value.classList.remove("hide")
    })
    document.getElementById("selectMes").value = "todos"
    document.getElementById("selectVoluntario").value = "todos"
    document.getElementById("selectSede").value = "todos"
    document.getElementById("boxFiltros").classList.add("hide")
    document.getElementById("btnVerFiltros").classList.remove("hide")
    document.getElementById("btnQuitarFiltros").classList.add("hide")
}
function ocultarFiltros() {
    quitarFiltros()
    document.getElementById("boxFiltros").classList.add("hide")
    document.getElementById("btnVerFiltros").classList.remove("hide")
    document.getElementById("btnQuitarFiltros").classList.add("hide")
}
function cerrarModalPedido(){
    document.getElementById("modalVerPedido").classList.remove("show")
    document.getElementById("modalVerPedido").classList.add("hide")
}


function mostrarFiltros() {
    document.getElementById("boxFiltros").classList.remove("hide")
    document.getElementById("btnVerFiltros").classList.add("hide")
    document.getElementById("btnQuitarFiltros").classList.remove("hide")
}
function filtrarFilas(param, param2){
    let listaFilas = document.getElementsByName("rowTableAdmin");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value) {
        if (value.classList.contains("hide")) {
            value.classList.remove("hide")
        }
    })
    listaFilas.forEach(function callback(value) {
        let parametro = null
        if (param2 == "mes") {
            parametro = value.firstElementChild.nextElementSibling.innerHTML.substring(3, 5)
        } else if (param2 == "voluntario") {
            parametro = value.firstElementChild.nextElementSibling.nextElementSibling.innerHTML
        } else {
            parametro = value.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML
        }
        if (!parametro.includes(param)) {
            value.classList.add("hide")
        }
    })
}
function filtrarFilasPorTresParametros(mes, voluntario, sede){
    let listaFilas = document.getElementsByName("rowTableAdmin");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value) {
        if (value.classList.contains("hide")) {
            value.classList.remove("hide")
        }
    })
    listaFilas.forEach(function callback(value) {
        mesValue = value.firstElementChild.nextElementSibling.innerHTML.substring(3, 5)
        voluntarioValue = value.firstElementChild.nextElementSibling.nextElementSibling.innerHTML
        sedeValue = value.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML
        if (!mesValue.includes(mes) || !voluntarioValue.includes(voluntario) || !sedeValue.includes(sede) ) {
            value.classList.add("hide")
        }
    })
}
function filtrarFilasPorDosParametros(mes, voluntario, sede){
    let listaFilas = document.getElementsByName("rowTableAdmin");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value) {
        if (value.classList.contains("hide")) {
            value.classList.remove("hide")
        }
    })
    listaFilas.forEach(function callback(value, index) {
        if(mes == "todos") {
            voluntarioValue = value.firstElementChild.nextElementSibling.nextElementSibling.innerHTML
            sedeValue = value.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML
            if (!voluntarioValue.includes(voluntario) || !sedeValue.includes(sede) ) {
                value.classList.add("hide")
            }
        }
        if (voluntario == "todos") {
            mesValue = value.firstElementChild.nextElementSibling.innerHTML.substring(3, 5)
            sedeValue = value.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML
            if (!mesValue.includes(mes) || !sedeValue.includes(sede) ) {
                value.classList.add("hide")
            }
        }
        if(sede == "todos") {
            mesValue = value.firstElementChild.nextElementSibling.innerHTML.substring(3, 5)
            voluntarioValue = value.firstElementChild.nextElementSibling.nextElementSibling.innerHTML
            if (!voluntarioValue.includes(voluntario) || !mesValue.includes(mes) ) {
                value.classList.add("hide")
            }
        }
    })
}
//END FUNCIONES DEL FILTRO ADMIN














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