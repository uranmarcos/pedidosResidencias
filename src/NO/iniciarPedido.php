<?php
session_start();
require("funciones/pdo.php");
require("funciones/iniciarPedido.php");
require("funciones/generarPedido.php");

?>
<script>
    function pulsar(e) {
        tecla = (document.querySelectorAll) ? e.keyCode : e.which;
        return (tecla != 13);
    }      
</script>    
<html>
    <head>
        <title>Pedidos Sí</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="css/master2.css" rel="stylesheet">
    </head>
    
    <body >
        <div class="contenedorPrincipal">
            <div class="header">
                <?php require("componentes/header.php")?>
            </div>
            <div class="col-md-11 main mb-3">
                <!-- START BREADCRUMB -->
                <div class="col-12 p-0">
                    <div class="titleSection">
                        <span class="pointer" onclick="redirect('inicio')">Inicio</span> -<span class="grey"> Generar Pedido </span>
                    </div>
                </div>
                <!-- END BREADCRUMB -->
                <!-- START ALERTS -->
                <div class="sectionBloque mt-2">
                    <div class="alert alert-danger centrarTexto <?php echo $alertErrorConexion ?>" id="alertErrorConexion" role="alert" >
                        Hubo un error de conexión. Por favor actualizá la página
                    </div>
                </div>
                <!-- END ALERTS -->
                <div class="bloque mb-4 pb-0">
                    <div class="contenedorSeccion contenedorModal">
                        <div class="table-responsive">
                                <form method="POST" action="iniciarPedido.php" onkeypress="return pulsar(event)">
                                    <table class="table table-hover" id="tablePedidos">
                                        <!-- FILTROS -->
                                        <div class="row d-flex align-items-center p-0 mb-2 justify-content-around" style="width:100%; margin:auto">
                                            <div class="col-10 col-sm-6 col-md-4 mb-2 mb-sm-0">
                                                <div class="row rowFiltro">
                                                    <input type="textarea" autocomplete="off" class="col-12" placeholder="Buscar por producto" onkeyup="filtrar(), guardarFiltro('buscadorProducto')" name="buscadorProducto" id="buscadorProducto">
                                                </div>
                                            </div>    
                                            <div class="col-10 col-sm-6 col-md-4">
                                                <div class="row rowFiltro">
                                                    <select style="height:30px" class="col-12" onchange="filtrar(), changeCategoria(), guardarFiltro('selectCategoria')" name="categoria" id="selectCategoria">
                                                        <option value="todos">Todas las categorias</opcion>
                                                        <?php foreach($categorias as $categoria){ ?>
                                                            <option value="<?php echo $categoria['descripcion'] ?>" ><?php echo $categoria["descripcion"]?></opcion>
                                                        <?php } ?>
                                                    </select>   
                                                </div>
                                            </div> 
                                            <div class="col-12 col-md-2 mt-2 mt-md-0 hide" id="boxBotonFiltro">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="botonQuitarFiltro" name="reiniciarPedido" onclick="quitarFiltros()" class="editButton botonReiniciar">
                                                        Quitar
                                                    </button>
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- END FILTROS -->
                                        <!-- TABLA -->
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="row" style="width:90%; margin:0px">
                                                        <div class="col-auto">
                                                            Producto
                                                        </div>
                                                        <div class="col d-flex align-items-center"  style="padding-left:0">
                                                            <button name="productoAsc" class="<?php echo $productosAsc?> buttonSort">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                                                </svg>
                                                            </button>
                                                            <button name="productoDesc" class="<?php echo $productosDesc?> buttonSort">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col" name="thCategoria">
                                                    <div class="row d-flex justify-content-center" style="width:90%; margin:0px">
                                                        <div class="col-auto">
                                                            Categoria
                                                        </div>
                                                        <div class="col-auto d-flex align-items-center" style="padding-left:0" id="ordenCategorias">
                                                            <button name="categoriaAsc" class="<?php echo $categoriaAsc?> buttonSort" id="categoriaAsc">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                                                </svg>
                                                            </button>
                                                            <button name="categoriaDesc" class="<?php echo $categoriaDesc?> buttonSort" id="categoriaDesc">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($productos as $producto){ ?>
                                                <tr name="rowTable">
                                                    <td class="productos">
                                                        <div id="producto<?php echo $posicion = array_search($producto, $productos)?>">
                                                            <?php echo $producto["descripcion"] ?>
                                                        </div>
                                                        <div style="font-size:10px"><?php echo $producto["medida"] ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <input type="number" min=0 id="input<?php echo $producto["id"]?>" value="0" onfocus="inputFocusOn()" onkeydown="limpiarInputFocus" onblur="inputFocusOut('input<?php echo $producto['id']?>')" class="cantidadProducto inputProducto col-8 col-sm-10" name="<?php echo $producto['id']?>">
                                                            <div class="trashButton col-1" style="height:27px; margin-left:2px"  onclick="borrarCantidad('<?php echo $producto['id']?>')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="categorias centrarTexto" name="tdCategoria">
                                                        <div id="categoria<?php echo $posicion = array_search($producto, $productos)?>">
                                                            <?php echo $producto["categoria"] ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>                    
                                        </tbody>
                                    </table>             
                                    <div class="row cajaInternaBloque" id="cajaOtros">
                                        <div class="centrarTexto">¿Falta algo en el listado?</div>
                                            <div class="">
                                                <input  type="textarea" id="textareaOtros" class="textarea" autocomplete="off" onblur="guardarOtros('textareaOtros')" name="otros" for="producto">    
                                            </div>    
                                        </div> 
                                    </div>
                                    <div>
                                        <div class="row rowBoton mb-5 d-flex justify-content-center"> 
                                            <button type="button" id="generarPedido" name="generarPedido" onclick="validarPedido()" class="boton">Confirmar</button>
                                        </div>
                                    </div> 
                                    
                                    <!-- START MODAL AVISO PEDIDO VACIO / CONFIRMACION INICIAR PEDIDO -->
                                    <div class="modalConfirmacion hide" id="modalIniciarPedido">
                                        <div class="">
                                            <div  class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header violeta d-flex justify-content-center centrarTexto" id="titleModalPedido">
                                                    </div>
                                                    <div>
                                                        <div class="modal-body centrarTexto" id="mensajeModalPedido">
                                                        </div>
                                                        <input type="text" class="hide" name="idActualizarPedido" id="idActualizarPedido" value="<?php echo $idPorActualizar?>">
                                                        <div>
                                                            <div class="modal-footer d-flex justify-content-around">
                                                                <button type="button" class="btn hide botonCancelar" id="btnCancelarEnvio" onclick="cancelarGenerarPedido()">CANCELAR</button>
                                                                <button type="button" class="btn boton hide" id="btnAceptarModalIniciarPedido" name="btnAceptarModalIniciarPedido" onclick="cancelarGenerarPedido()">ACEPTAR</button>
                                                                <button type="submit" class="btn boton hide" id="btnConfirmarIniciarPedido" name="generarPedido" onclick="confirmarIniciarPedido()">ACEPTAR</button>
                                                                <button type="button" class="boton hide" id="spinnerConfirmarPedido" >
                                                                    <div class="spinner-border" role="status">
                                                                        <span class="sr-only"></span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="modal-body hide centrarTexto" id="spinnerActualizacion">
                                                        <div style="min-height:100px" class="d-flex justify-content-center align-items-center">
                                                            <div class="spinner-border violeta" role="status">
                                                                <span class="sr-only"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL AVISO PEDIDO VACIO / CONFIRMACION INICIAR PEDIDO -->

                                    <!-- START MODAL ERROR PEDIDO NO GENERADO -->
                                    <div class="modalConfirmacion <?php echo $modalPedidoNoGenerado ?>" id="modalPedidoNoGenerado">
                                        <div  class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header red d-flex justify-content-center centrarTexto" id="titleModalPedido">
                                                    ERROR
                                                </div>
                                                <div>
                                                    <div class="modal-body red centrarTexto" id="mensajeModalPedido">
                                                        <?php echo $mensajePedidoNoGenerado ?>
                                                    </div>
                                                    <input type="text" class="hide" name="idActualizarPedido" id="idActualizarPedido" value="<?php echo $idPorActualizar?>">
                                                    <div>
                                                        <div class="modal-footer d-flex justify-content-around">
                                                            <button type="button" class="btn botonCancelar" id="btnCancelarEnvio" onclick="cerrarModal('modalPedidoNoGenerado')">CANCELAR</button>
                                                            <button type="submit" class="btn boton" id="btnConfirmarIniciarPedido" name="generarPedido" onclick="confirmarIniciarPedido()">ACEPTAR</button>
                                                            <button type="button" class="boton hide" id="spinnerConfirmarPedido" >
                                                                <div class="spinner-border" role="status">
                                                                    <span class="sr-only"></span>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL ERROR PEDIDO NO GENERADO -->
                                </form>

                                <!-- START MODAL ERROR PEDIDO ENVIADO NO ACTUALIZADO -->
                                <div class="modalConfirmacion <?php echo $modalPedidoNoActualizado ?>" id="modalPedidoNoActualizado">
                                    <div class="">
                                        <form method="POST" action="iniciarPedido.php">
                                            <div  class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header purple d-flex justify-content-center centrarTexto" id="titleModalPedido">
                                                        ¡ATENCIÓN!
                                                    </div>
                                                    <div>
                                                        <div class="modal-body centrarTexto" id="mensajeModalPedido">
                                                            El pedido se generó y se envió correctamente, pero no se guardó.
                                                            <br>Por favor presioná ACTUALIZAR para solucionarlo.
                                                            <br>
                                                            ¡Gracias!
                                                        </div>
                                                        <input type="text" class="hide" name="idActualizarPedido" id="idActualizarPedido" value="<?php echo $idPorActualizar?>">
                                                        <div>
                                                            <div class="modal-footer d-flex justify-content-center">
                                                                <button type="submit" class="btn boton" id="botonActualizarEnviado" name="actualizarEnviado" onclick="mostrarSpinnerBoton('botonActualizarEnviado','spinnerBotonActualizarEnviado' )">ACTUALIZAR</button>
                                                                <button type="button" class="boton hide" id="spinnerBotonActualizarEnviado" >
                                                                    <div class="spinner-border" role="status">
                                                                        <span class="sr-only"></span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END MODAL ERROR PEDIDO GUARDADO NO ENVIADO -->
                         
                        </div>                          
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript"  src="js/iniciarPedido.js"></script> 
    </body>
</html>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    window.onload = function(){
        let alertErrorConexion = document.getElementById("alertErrorConexion")
        if (alertErrorConexion.classList.contains('show')) {
            setTimeout(ocultarAlertError, 5000)
        }
        document.getElementById("buscadorProducto").value = localStorage.getItem("buscadorProducto");
        document.getElementById("selectCategoria").value = localStorage.getItem("selectCategoria");
        filtrar()
    };
    function ocultarAlertError(){
        let alertErrorConexion = document.getElementById("alertErrorConexion")
        alertErrorConexion.classList.remove('show')
        alertErrorConexion.classList.add('hide')
    }
    function borrarCantidad(id) {
        let input = document.getElementById("input" + id)
        console.log(input)
        input.value = 0
    }
    function changeCategoria() {
        let categoriaDesc = document.getElementById("categoriaDesc");
        let categoriaAsc = document.getElementById("categoriaAsc");
        let categoria = document.getElementById("selectCategoria").value;
        if(categoria != "todos"){
            categoriaAsc.setAttribute("disabled", true)
            return categoriaDesc.setAttribute("disabled", true)
        }
        categoriaAsc.removeAttribute("disabled")
        return categoriaDesc.removeAttribute("disabled")

    }
</script>