<?php
session_start();
require("funciones/pdo.php");
require("funciones/pedidos.php");

?>
<html>
    <head>
        <title>Pedidos Sí</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <!-- <link href="css/master.css" rel="stylesheet"> -->
        <!-- <link href="css/master2.css" rel="stylesheet"> -->
    </head>
    <body>
        <div>
            <div class="header">
                <?php require("componentes/header.php")?>
            </div>
            <div class="col-md-11 main">
                <!-- START BREADCRUMB -->
                <div class="col-12 p-0">
                    <div class="titleSection">
                        <span class="pointer" onclick="redirect('inicio')">Inicio</span> -<span class="grey"> Pedidos Realizados </span>
                    </div>
                </div>
                <!-- END BREADCRUMB -->
                
                
                <!-- START ALERTS -->
                <div class="alert alert-danger mt-3 centrarTexto <?php echo $alertErrorConexion ?>" id="alertErrorConexion" role="alert" >
                    <?php echo $mensajeAlertError ?>
                </div>
                <div class="alert alert-success mt-3 centrarTexto <?php echo $alertConfirmacion ?>" id="alertConfirmacion" role="alert">
                    <?php echo $mensajeAlertConfirmacion ?>
                </div>
                <!-- END ALERTS -->
                
                
                <!-- START TABLA SIN DATOS -->
                <div class="bloque mb-4 pb-0 <?php echo $noHayDatos?>">
                    <table class="table">
                        <thead class="d-flex justify-content-center">
                            <tr>
                                <th scope="col" style="width:100%">NO SE ENCONTRARON DATOS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- END TABLA SIN DATOS -->


                <!-- TABLA CON LISTA DE PEDIDOS -->
                <div class="<?php echo $hayDatos?>">                   
                    <!-- START TABLA ROL ADMIN -->
                    <div class="table-responsive bloque mb-4 pb-0 ">
                        <table class="table">
                            <div class="<?php echo $mostrarAdmin?>">
                                <div class="d-flex anchoTotal row">
                                    <div class="col-12 mb-3 d-flex align-items-end justify-content-between">
                                        <button type="button" name="btnVerFiltros" onclick="mostrarFiltros()"  id="btnVerFiltros" class="btn boton">Ver Filtros</button>
                                        <button type="button" name="btnQuitarFiltros" onclick="ocultarFiltros()"  id="btnQuitarFiltros" class="btn hide botonCancelar">Quitar Filtros</button>
                                        <button type="submit" name="nuevoPedido" onclick="redirect('iniciarPedido')"  id="nuevoPedido" class="btn boton">Generar Pedido</button>        
                                    </div>
                                    <div class="hide mb-2" id="boxFiltros">
                                        <div class="row bg-grey d-flex align-items-center p-0 m-0 justify-content-around" style="width:100%">
                                            <div class="col-12 col-sm-3">
                                                <div class="row rowFiltro">
                                                    Mes:
                                                    <select style="height:30px" class="col-12 inputForm" onchange="filtrar()" name="mes" id="selectMes">
                                                        <option value="todos">Todos</opcion>
                                                        <option value="01">Enero</opcion>
                                                        <option value="02">Febrero</opcion>
                                                        <option value="03">Marzo</opcion>
                                                        <option value="04">Abril</opcion>
                                                        <option value="05">Mayo</opcion>
                                                        <option value="06">Junio</opcion>
                                                        <option value="07">Julio</opcion>
                                                        <option value="08">Agosto</opcion>
                                                        <option value="09">Septiembre</opcion>
                                                        <option value="10">Octubre</opcion>
                                                        <option value="11">Noviembre</opcion>
                                                        <option value="12">Diciembre</opcion>
                                                    </select>   
                                                </div>
                                            </div>    
                                            <div class="col-12 col-sm-4">
                                                <div class="row rowFiltro">
                                                    Voluntario:
                                                    <select style="height:30px" class="col-12 inputForm" onchange="filtrar()" name="voluntario" id="selectVoluntario">
                                                        <option value="todos">Todos</opcion>
                                                        <?php foreach($voluntarios as $voluntario){ ?>
                                                            <option value="<?php echo $voluntario["nombre"] . " " . $voluntario["segundoNombre"] . " " . $voluntario["apellido"] ?>" ><?php echo $voluntario["nombre"] . " " . $voluntario["segundoNombre"] . " " . $voluntario["apellido"]?></opcion>
                                                        <?php } ?>
                                                    </select>   
                                                </div>
                                            </div> 
                                            <div class="col-12 col-sm-4">
                                                <div class="row rowFiltro">
                                                    Sede:
                                                    <select style="height:30px" class="col-12 inputForm" onchange="filtrar()" name="categoria" id="selectSede">
                                                        <option value="todos">Todas</opcion>
                                                        <?php foreach($sedes as $sede){ ?>
                                                            <option value="<?php echo $sede['localidad'] ?>" ><?php echo $sede["localidad"]?></opcion>
                                                        <?php } ?>
                                                    </select>   
                                                </div>
                                            </div> 
                                            <!-- <div class="col-12 col-sm-5 col-md-2 d-flex align-self-end justify-content-center mb-0" id="boxBotonFiltro">
                                                <div class="d-flex align-items-end justify-content-center">
                                                    <button type="submit" class="botonQuitarFiltro" name="reiniciarPedido" onclick="quitarFiltros()" class="editButton botonReiniciar">
                                                        Quitar
                                                    </button>
                                                </div>
                                            </div>  -->
                                        </div>
                                    
                                    </div>
                                </div> 
                            </div>
                            <div class="<?php echo $mostrarStock ?>">
                                <div class="d-flex anchoTotal row">
                                    <div class="col-12 col-sm-6 d-flex align-items-end justify-content-start dataSede">
                                        <div>
                                            Sede: <?php echo $pedidos[0]["provinciaSede"] . ", " . $pedidos[0]["localidadSede"]?> <br> Casa:  <?php echo $_SESSION["casa"]?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 d-flex align-items-end justify-content-end">
                                        <button type="submit" name="nuevoPedido" onclick="redirect('iniciarPedido')"  id="nuevoPedido" class="btn mb-3 boton">Generar Pedido</button>        
                                    </div>
                                </div> 
                            </div>
                            <thead style="width:100%">
                                <tr style="width:100%">
                                    <th scope="col" style="width:30%" class="centrarTexto">Fecha</th>
                                    <th scope="col" style="width:40%" class="centrarTexto">Voluntario</th>
                                    <th scope="col" style="width:20%" class="centrarTexto">Sede / Casa</th>
                                    <th scope="col" style="width:10%; text-align:center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($pedidos as $pedido){ ?>
                                    <tr name="rowTableAdmin">
                                        <td class="tdp centrarTexto pt-0 pb-0"><?php echo $newDate = date("d/m/Y H:i:s", strtotime($pedido["fecha"]));?></td>
                                        <td class="tdp centrarTexto pt-0 pb-0"><?php echo $pedido["nombre"] . " " . $pedido["segundoNombre"] . " " . $pedido["apellido"] ?></td>              
                                        <td class="tdp centrarTexto pt-0 pb-0"><?php echo $pedido["provinciaSede"] . ", " . $pedido["localidadSede"] . " / " . $pedido["casa"] ?></td>
                                        <td class="tdp pl-0 pr-0 pt-0 pb-0"> 
                                            <div class="d-flex tdp">
                                                <form method="POST" class="mb-0" style="height:48px" action="pedidos.php">
                                                    <input type="text" class="hide" style ="border: none" name="id" readonly value="<?php echo $pedido["id"] ?>">
                                                    <button type="button" class="btn btnVerPedido" name="verPedido" onclick="verPedidoModal(<?php echo $pedido['id']?>)" id="btnVerPedido<?php echo $pedido['id']?>" data-bs-toggle="modal" data-bs-target="#modalVerPedido">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form method="POST" action="verPedido.php" target="_blank">
                                                    <input type="text" style ="border: none" name="id" class="hide" readonly value="<?php echo $pedido["id"] ?>"> 
                                                    <button type="submit" class="btn btnVerPedido" name="descargarPedido" id="btnVerPedido<?php echo $pedido['id']?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            <div>
                                        </td>
                                    </tr>
                                <?php } ?>   
                            </tbody>               
                        </table>
                    </div>
                    <!-- END TABLA ROL ADMIN -->
                </div>
                <!-- END TABLA PEDIDOS -->

                <!-- START MODAL VER PEDIDO -->
                <div class="modal fade" id="modalVerPedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-left">
                                    <div>
                                    <b>Fecha: </b><span id="fechaPedidoModal"></span>
                                    <br>
                                    <b>Voluntario: </b><span id="usuarioPedidoModal"></span>
                                    <br>
                                    <b>Sede: </b><span id="sedePedidoModal"></span>
                                    <br>
                                    <b>Casa: </b><span id="casaPedidoModal"></span>
                                </div>
                                </div>
                                <div id="mensajeActualizacion">
                                    <div class="modal-body" id="descripcionPedidoModal">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-around">
                                        <button type="button" class="btn boton" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MODAL VER PEDIDO -->
                
            </div>   
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>           
        <script type="text/javascript"  src="js/funcionesCompartidas.js"></script> 
        <script type="text/javascript"  src="js/pedidos.js"></script> 
    </body>
</html>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href )
    }
    function verPedidoModal(param){
        let articulos = <?php  echo json_encode($articulos)?>;
        let pedidos = <?php  echo json_encode($pedidos)?>;
        let usuarios = <?php  echo json_encode($voluntarios)?>;
        let sedes = <?php  echo json_encode($sedes)?>;
        let pedido = pedidos.filter(element => element.id == param)[0]; 
        let fecha = pedido.fecha;
        let sede = sedes.filter(element=> element.id == pedido.sede)[0]
        let pedidoAMostrar = pedido.pedido.split(";");
        let pedidoModal = "";

        
        let fechaPedidoModal = document.getElementById("fechaPedidoModal")
        let descripcionPedidoModal = document.getElementById("descripcionPedidoModal")
        for (p of pedidoAMostrar){
            if(p != ""){
                if(!p.includes("otros")) {
                    p = p.split(":")
                    let articulo = articulos.filter(element => element.id == p[0])[0]
                    pedidoModal = pedidoModal + "<b>" + articulo.descripcion + ":</b> " + p[1] + " " + articulo.medida + ", <br>"
                } else {
                    let otros = p.split(":")
                    pedidoModal = pedidoModal + "<b>Otros:</b> " + otros[1] + ", <br>"
                }
            }
        }
        fechaPedidoModal.innerHTML = fecha
        usuarioPedidoModal.innerHTML = pedido.nombre + " " + pedido.segundoNombre + " " + pedido.apellido
        sedePedidoModal.innerHTML = sede.provincia + ", " + sede.localidad
        casaPedidoModal.innerHTML = pedido.casa
        descripcionPedidoModal.innerHTML = pedidoModal
    }
    window.onload = function(){
        // START OCULTAR ALERTAS DE CONFIRMACION O ERROR LUEGO DE 5 SEGUNDOS DE CARGAR LA PAGINA
        let alertConfirmacion = document.getElementById("alertConfirmacion")
        if (alertConfirmacion.classList.contains('show')) {
            setTimeout(ocultarAlertConfirmacion, 5000)
        }
        let alertErrorConexion = document.getElementById("alertErrorConexion")
        if (alertErrorConexion.classList.contains('show')) {
            setTimeout(ocultarAlertError, 5000)
        }
        // END OCULTAR ALERTAS DE CONFIRMACION O ERROR LUEGO DE 5 SEGUNDOS DE CARGAR LA PAGINA

        // START VISIBILIDAD ALERT SOBRE COMO REENVIAR PEDIDOS 
        let pedidos = <?php  echo json_encode($pedidos) ?>;
        let pedidoNoEnviado  = pedidos.filter(element => element.enviado == 0 )
        if (pedidoNoEnviado.length > 0) {
            let alertAvisoReenvio = document.getElementById("alertAvisoReenvio")
            alertAvisoReenvio.classList.remove("hide")
        }
        // END VISIBILIDAD ALERT SOBRE COMO REENVIAR PEDIDOS 

        // START MUESTRO BOTON REENVIAR EN LOS CASOS EN QUE EL PEDIDO NO SE ENVIO
        let tdEnviado = document.getElementsByClassName("tdEnviado")
        tdEnviado = Array.from(tdEnviado)
        tdEnviado.forEach(function callback(value, index) {
            if(value.firstElementChild.innerHTML.includes("No enviado")){   
                value.firstElementChild.classList.add("hide")
                value.firstElementChild.nextElementSibling.classList.remove("hide")
            }
        })
        // END MUESTRO BOTON REENVIAR EN LOS CASOS EN QUE EL PEDIDO NO SE ENVIO

    }
</script>