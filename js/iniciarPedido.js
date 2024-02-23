// INICIO COLUMNA CATEGORIA RESPONSIVE
window.addEventListener("resize", function(){
    let ancho =  window.innerWidth
    ajustarColumnaCategoria (ancho)
});
function guardarFiltro(param){
    let input = document.getElementById(param);
    let valor = input.value;
    localStorage.setItem(param, valor);
}
let ancho =  window.innerWidth
let thCategoria = document.getElementsByName("thCategoria")
let tdCategoria = document.getElementsByName("tdCategoria")
ajustarColumnaCategoria (ancho)
function ajustarColumnaCategoria (ancho) {
    if(ancho < 767){
        for (th of thCategoria){
            th.classList.add("hide")
        }
        for (td of tdCategoria){
            td.classList.add("hide")
        }
    } else{
        for (th of thCategoria){
            th.classList.remove("hide")
        }
        for (td of tdCategoria){
            td.classList.remove("hide")
        }
    }
}
// FIN COLUMNA CATEGORIA RESPONSIVE
cargarPedido();
function filtrar() {
    let producto = document.getElementById("buscadorProducto").value;
    let boxBotonFiltro = document.getElementById("boxBotonFiltro");
    let categoria = document.getElementById("selectCategoria").value;
    if(producto.trim() != "" && categoria != "todos"){
        filtrarFilas(producto.toLowerCase(), categoria)
        boxBotonFiltro.classList.remove("hide")
    } else if(producto.trim() != "" && categoria == "todos") {
        filtrarFilasPorParametro("producto", producto.toLowerCase())
        boxBotonFiltro.classList.remove("hide")
    }  else if(producto.trim() == "" && categoria != "todos") {
        filtrarFilasPorParametro("categoria", categoria.toLowerCase())
        boxBotonFiltro.classList.remove("hide")
    } else {
        quitarFiltros()
        boxBotonFiltro.classList.add("hide")
    }
}
function quitarFiltros(){
    resetFiltros()
    let listaFilas = document.getElementsByName("rowTable");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value) {
        value.classList.remove("hide")
    })
}
function filtrarFilas(param1, param2){
    let listaFilas = document.getElementsByName("rowTable");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value, index) {
       let producto = document.getElementById("producto"+index).innerHTML.trim().toLowerCase()
       let categoria = document.getElementById("categoria"+index).innerHTML.trim()
       if(!producto.includes(param1) || !categoria.includes(param2)){
           value.classList.add("hide")
       } else {
            value.classList.remove("hide")
       }
    })
}
function filtrarFilasPorParametro(param1, param2){
    let listaFilas = document.getElementsByName("rowTable");
    listaFilas = Array.from(listaFilas)
    listaFilas.forEach(function callback(value, index) {
        if(param1 == "producto") {
            let producto = document.getElementById("producto"+index).innerHTML.trim().toLowerCase()
            if(!producto.includes(param2) ){
                value.classList.add("hide")
            } else {
                value.classList.remove("hide")
            }
        }
        if(param1 == "categoria") {
            let categoria = document.getElementById("categoria"+index).innerHTML.trim().toLowerCase()
            if(!categoria.includes(param2) ){
                value.classList.add("hide")
            } else {
                value.classList.remove("hide")
            }
        }
    })
}
function resetFiltros(){
    localStorage.setItem("buscadorProducto", "")
    localStorage.setItem("selectCategoria", "todos")
}
// PEDIDO
function validarPedido() {
    let listaInput = document.getElementsByClassName("inputProducto")
    let claves = Object.keys(listaInput)
    let formularioValidado = false
    let otrosValidado = false
    for(let i=0; i< claves.length; i++){
        let clave = claves[i];
        if(listaInput[clave].value != 0) {
            formularioValidado = true
        }
    }
    let textarea= document.getElementById("textareaOtros")
    if(textarea.value.trim() != ""){
        otrosValidado = true
    }
    showModal(otrosValidado, formularioValidado)
}
function showModal(otrosValidado, formularioValidado) {
    let modalPedido = document.getElementById("modalIniciarPedido")
    let titleModalPedido = document.getElementById("titleModalPedido")
    let mensajeModalPedido = document.getElementById("mensajeModalPedido")
    let btnCancelarEnvio = document.getElementById("btnCancelarEnvio")
    let btnAceptarModalIniciarPedido = document.getElementById("btnAceptarModalIniciarPedido")
    let btnConfirmarIniciarPedido = document.getElementById("btnConfirmarIniciarPedido")
    btnCancelarEnvio.classList.add("hide")
    btnConfirmarIniciarPedido.classList.add("hide")
    btnAceptarModalIniciarPedido.classList.add("hide")

    let botonConfirmar = document.getElementById("botonConfirmar")
    if(!otrosValidado && !formularioValidado) {
        modalPedido.classList.remove("hide")
        modalPedido.scrollIntoView()
        titleModalPedido.innerHTML =  "¡ATENCIÓN!"
        titleModalPedido.classList.add("red")
        mensajeModalPedido.innerHTML="Disculpe, no puede generar un pedido vacio."
        btnAceptarModalIniciarPedido.classList.remove("hide")
        botonConfirmar.classList.add("hide")
        botonConfirmar.classList.remove("show")
    } else if (otrosValidado && !formularioValidado){
        modalPedido.classList.remove("hide")
        modalPedido.scrollIntoView()
        btnCancelarEnvio.classList.remove("hide")
        btnConfirmarIniciarPedido.classList.remove("hide")
        titleModalPedido.innerHTML =  "CONFIRMACIÓN!"
        titleModalPedido.classList.add("purple")
        mensajeModalPedido.innerHTML="El pedido no tiene productos del listado cargados.<br> Solo se pedirá lo agregado en el campo adicional. <br> ¿Desea confirmar el pedido?"
    } else {
        modalPedido.classList.remove("hide")
        modalPedido.scrollIntoView()
        titleModalPedido.innerHTML =  "CONFIRMACIÓN!"
        titleModalPedido.classList.add("purple")
        btnCancelarEnvio.classList.remove("hide")    
        btnConfirmarIniciarPedido.classList.remove("hide")         
        mensajeModalPedido.innerHTML="¿Desea confirmar el pedido?"
    }
}
function cancelarGenerarPedido () {
    let modalPedido = document.getElementById("modalIniciarPedido")
    modalPedido.classList.add("hide")
}
function mostrarSpinnerBoton(idBotonOcultar, ibBotonSpinner) {
    let botonOcultar = document.getElementById(idBotonOcultar)
    botonOcultar.classList.add("hide")
    let botonSpinner = document.getElementById(ibBotonSpinner)
    botonSpinner.classList.remove("hide")
}
function cerrarModal (idModal) {
    let modal = document.getElementById(idModal)
    modal.classList.add("hide")
}
function confirmarIniciarPedido() {
    let btnConfirmarIniciarPedido = document.getElementById("btnConfirmarIniciarPedido")
    btnConfirmarIniciarPedido.classList.add("hide")
    let spinnerConfirmarPedido = document.getElementById("spinnerConfirmarPedido")
    spinnerConfirmarPedido.classList.remove("hide")
}
function inputFocusOn(){
    //marcarProducto();
    if(document.activeElement.value == 0){
        document.activeElement.value = "";
    }
}
function inputFocusOut(param){
    validarCantidad(param);
   //desmarcarProducto();
}
function cargarPedido(){
    let inputs = document.getElementsByTagName("input");
    for(let input of inputs){
        let id = input.id;
        let valorGuardado = localStorage.getItem(id);
        if(valorGuardado != undefined && id == "textareaOtros"){
            if(valorGuardado != ""){
                input.value = valorGuardado;
            }
        }
        else if(valorGuardado != undefined && id!= "textareaOtros"){
            if(valorGuardado != 0 && valorGuardado != "NaN"){
                input.value = valorGuardado;
            }
        }else{
            input.value = 0;
            let inputOtros= document.getElementById("textareaOtros");
            inputOtros.value = "";
        }
    }   
    let buscador = document.getElementById("buscadorProducto");
    buscador.value="";
    recordarCategoriaSeleccionada();
}
function guardarOtros(param){
    let input = document.getElementById(param);
    let valor = input.value;
    localStorage.setItem(param, valor);
}
function limpiarInputFocus(){
    let focusedElement = document.activeElement;  
    if(focusedElement.value == 0){
        focusedElement.value="";
    }
}
function recordarCategoriaSeleccionada(){
    let cat = localStorage.getItem("categoriaSeleccionada");
    let opciones = document.getElementsByTagName("option");
    for (opcion of opciones){
        if(opcion.value != cat){
            opcion.removeAttribute("selected");
        }else{
            opcion.setAttribute("selected", true);
        }
    }
}
function validarCantidad(param){
    let input = document.getElementById(param);
    let valor = input.value;
    if(valor == "" ){
        input.value = 0;
    }else{
        input.value = parseInt( valor, 10 )
    }
    localStorage.setItem(param, parseInt( valor, 10 ));
}
function cerrarModalPedido() {
    let modalPedido = document.getElementById("modalPedido")
    modalPedido.classList.remove("show")
    modalPedido.classList.add("hide")
}
function confirmarPedido(){
    let modalSpinner = document.getElementById("modalSpinner")
    modalSpinner.classList.remove("hide")
    modalSpinner.classList.add("show")
}
function reintentarPedido(){
    let modalConfirmacion = document.getElementById("modalConfirmacion")
    modalConfirmacion.classList.remove("show")
    modalConfirmacion.classList.add("hide")
    let modalSpinner = document.getElementById("modalSpinner")
    modalSpinner.classList.remove("hide")
    modalSpinner.classList.add("show")
}
function cerrarModalConfirmacion() {
    let modalConfirmacion = document.getElementById("modalConfirmacion")
    modalConfirmacion.classList.remove("show")
    modalConfirmacion.classList.add("hide")
}
function cerrarModalPedidoGenerado() {
    let modalConfirmacion = document.getElementById("modalConfirmacion")
    modalConfirmacion.classList.remove("show")
    modalConfirmacion.classList.add("hide")
    location.href='pedidos.php'
}
function cerrarModalActualizacion() {
    let mensajeActualizacion = document.getElementById("mensajeActualizacion")
    mensajeActualizacion.classList.remove("show")
    mensajeActualizacion.classList.add("hide")
    let spinnerActualizacion = document.getElementById("spinnerActualizacion")
    spinnerActualizacion.classList.remove("hide")
    spinnerActualizacion.classList.add("show")
    // let modalActualizacion = document.getElementById("modalActualizacion")
    // modalActualizacion.classList.remove("show")
    // modalActualizacion.classList.add("hide")
    // let modalSpinner = document.getElementById("modalSpinner")
    // modalSpinner.classList.remove("hide")
    // modalSpinner.classList.add("show")
}

