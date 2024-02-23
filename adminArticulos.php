<?php
session_start();
require("funciones/pdo.php");
require("funciones/adminArticulos.php");
if($_SESSION["rol"] != "admin" && $_SESSION["rol"] != "general"){
    echo "<script> window.location.href='inicio.php' </script>";
}
?>
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
    <body>
        <div class="contenedorPrincipal">
            <div class="header">
                <?php require("componentes/header.php")?>
            </div>
            <div class="col-md-11 main">
                <div class="col-12 p-0">
                    <div class="titleSection">
                        <span class="pointer" onclick="redirect('inicio')">Inicio</span> -<span class="pointer" onclick="redirect('admin')"> Admin </span> - <span class="grey"> Admin ARTICULOS</span>
                    </div>
                </div>

                <!--    START BOX LISTADO ARTICULOS    -->
                <div class="bloque">
                    <div class="alert alert-danger centrarTexto <?php echo $alertError ?>" id="alertErrorConexion" role="alert" >
                        <?php echo $mensajeAlertError ?>
                    </div>
                    <div class="alert alert-success centrarTexto <?php echo $alertConfirmacion ?>" id="alertConfirmacion" role="alert">
                        <?php echo $mensajeAlertConfirmacion ?>
                    </div>
                    <div class="contenedorSeccion contenedorModal">
                        <form name="form2" method="POST" action="adminUsuarios.php">
                            <div class="d-flex anchoTotal MB-2 row">
                                <div class="subtitle col-6">
                                    Articulos Disponibles
                                </div>
                                <div class="col-6 d-flex align-items-end justify-content-end">
                                    <button type="button" class="btn boton" data-toggle="modal" data-target="#pruebaModal">
                                        Nuevo Articulo
                                    </button>
                                </div>
                            </div>
                            <!-- START TABLA CON LISTA DE ARTICULOS -->
                            <div class="table-responsive">
                                <table class="table <?php echo $hayDatos ?>">
                                    <div class="row bg-grey d-flex align-items-center p-0 mt-2 mb-2 justify-content-around" style="width:100%">
                                        <div class="col-11 col-sm-5 col-md-4">
                                            <div class="row rowFiltro">
                                                <input type="textarea" autocomplete="off" class="col-12" placeholder="Buscar por producto" onkeyup="filtrar()" name="buscadorProducto" id="buscadorProducto">
                                            </div>
                                        </div>    
                                        <div class="col-11 col-sm-5 col-md-4">
                                            <div class="row rowFiltro">
                                                <select style="height:30px" class="col-12" onchange="filtrar()" name="categoria" id="selectCategoria">
                                                    <option value="todos">Todas las categorias</opcion>
                                                        <?php foreach($categorias as $categoria){ ?>
                                                            <option value="<?php echo $categoria['descripcion'] ?>" ><?php echo $categoria["descripcion"]?></opcion>
                                                        <?php } ?>
                                                    </select>  
                                                </div>
                                            </div> 
                                            <div class="col-12 col-md-2 mb-2 hide mb-md-0" id="boxBotonFiltro">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="botonQuitarFiltro" name="reiniciarPedido" onclick="quitarFiltros()" class="editButton botonReiniciar">
                                                        Quitar
                                                    </button>
                                                </div>
                                            </div> 
                                        </div>
                                        <thead>
                                            <tr>
                                                <th scope="col" class="hide">#</th>
                                                <th scope="col" style="width:50%">Descripcion</th>
                                                <th scope="col" style="width:10%; text-align:center">Medida</th>
                                                <th scope="col" style="width:10%; text-align:center">Categoria</th>
                                                <th scope="col" style="width:100px; text-align:center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($articulos as $articulo){ ?>
                                                <tr name="rowTable">
                                                    <td class="hide"><?php echo $articulo["id"] ?></td>
                                                    <td class="productos">
                                                        <div id="producto<?php echo $posicion = array_search($articulo, $articulos)?>">
                                                            <?php echo $articulo["descripcion"] ?>
                                                        </div>    
                                                    </td>
                                                    <td style="text-align: center"><?php echo $articulo["medida"] ?></td>
                                                    <td class="categorias centrarTexto">
                                                        <div id="categoria<?php echo $posicion = array_search($articulo, $articulos)?>">
                                                            <?php echo $articulo["categoria"] ?>
                                                        </div>
                                                    </td>
                                                    <td class="pl-0 pr-0" style="width:100px; text-align:center"> 
                                                        <div class="row" style="width:90px; margin:auto;">
                                                            <!-- BOTON TRASH -->
                                                            <div style="width:45px" onmouseover="overBotonAccion('btnTrash<?php echo $articulo['id']?>','btnTrashFill<?php echo $articulo['id']?>')" onmouseout="overBotonAccion('btnTrashFill<?php echo $articulo['id']?>', 'btnTrash<?php echo $articulo['id']?>')" name="trashButton<?php echo $articulo['id']?>" id="trashButton<?php echo $articulo['id']?>" class="trashButton" onclick="eliminarArticulo(<?php echo $articulo['id']?>, '<?php echo $articulo['descripcion'];?>')" data-bs-toggle="modal" data-bs-target="#modalEliminar">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" id="btnTrash<?php echo $articulo['id']?>" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                </svg>    
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi hide bi-trash-fill" id="btnTrashFill<?php echo $articulo['id']?>" viewBox="0 0 16 16">
                                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                                </svg>
                                                            </div>
                                                            <!-- BOTON EDIT -->
                                                            <div style="width:45px" class="editButton" id="editButton<?php echo $articulo['id']?>" onmouseover="overBotonAccion('btnPen<?php echo $articulo['id']?>','btnPenFill<?php echo $articulo['id']?>')" onmouseout="overBotonAccion('btnPenFill<?php echo $articulo['id']?>', 'btnPen<?php echo $articulo['id']?>')" onclick="cargarDatosEdicion('<?php echo $articulo['id']?>', '<?php echo $articulo['descripcion']?>', '<?php echo $articulo['idMedida']?>', '<?php echo $articulo['idCategoria']?>')" data-toggle="modal" data-target="#edicionModal">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="btnPen<?php echo $articulo['id']?>" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                </svg>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="btnPenFill<?php echo $articulo['id']?>" class="bi hide bi-pencil-fill" viewBox="0 0 16 16">
                                                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                                </svg> 
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>   
                                        </tbody>               
                                </table>                            
                            </div>
                            <!-- END TABLA CON LISTA DE ARTICULOS -->
                            <!-- START TABLA SIN DATOS -->
                            <table class="table <?php echo $noHayDatos?>">
                                <thead class="d-flex justify-content-center">
                                    <tr>
                                        <th scope="col" style="width:100%">NO SE ENCONTRARON DATOS</th>
                                    </tr>
                                </thead>
                            </table>
                            <!-- END TABLA SIN DATOS -->
                        </form>
                    </div>
                </div>
                <!--    END BOX LISTADO USUARIOS    -->

                <!-- START MODAL CONFIRMACION ELIMINACION ARTICULO -->                    
                <form action="adminArticulos.php" method="POST">
                    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <input type="text" hidden name="idArticuloEliminar" id="idArticuloEliminar"></input>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body centrarTexto">
                                    ¿Confirma que desea eliminar el articulo <b><span id="articuloAEliminar"></span></b>?
                                </div>
                                <div class="modal-footer d-flex justify-content-around">
                                    <button type="button" class="btn botonCancelar" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="eliminarArticulo" id="btnEliminarArticulo" onclick="mostrarSpinner('btnEliminarArticulo', 'spinnerEliminarArticulo')" class="btn boton">Confirmar</button>
                                    <button type="button" class="btnReenviarCircle hide" id="spinnerEliminarArticulo">
                                        <div class="spinner-border spinnerReenviar" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END MODAL CONFIRMACION ELIMINACION ARTICULO -->

                <!----     START MODAL CREACION DE ARTICULO    ----->
                <form name="formCreacion" method="POST" action="adminArticulos.php">
                    <div class="modal fade" id="pruebaModal" tabindex="-1" role="dialog" aria-labelledby="pruebaModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title centrarTexto purple" id="pruebaModalLabel">CREACIÓN DE ARTICULO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="bodyModalCrear">
                                    <div class="contenedorSeccion purple contenedorModal mb-4" id="boxEditarUsuario">        
                                        <div class="row">
                                            <div class="col-12 columna">
                                                <button type="button" class="btn botonLimpiar" id="btnLimpiarFormCreacion" onclick="limpiarFormularioCreacion()">Limpiar Formulario</button>
                                            </div>
                                            <div class="col-12 columna">
                                                <label> Descripción: </label>
                                                <input maxlength="30" style="width:100%" id="descripcionCreacion" name="descripcionCreacion" autocomplete="off" onkeyup="validarDescripcionCreacion(value)">
                                                <div class="hide errorValidacion" id="mensajeValidacionCreacion"></div>
                                            </div>
                                            <div class="col-12 columna">
                                                <label class="labelForm"> Medida: </label>
                                                <select id="medidaCreacion" style="width:100%; height:30px"  name="medidaCreacion">
                                                <?php foreach($medidas as $medida){ ?>
                                                        <option value="<?php echo $medida['id']?>"><?php echo $medida['descripcion']?></option>
                                                    <?php } ?> 
                                                </select>   
                                            </div>
                                            <div class="col-12 columna">
                                                <label class="labelForm"> Categoria: </label>
                                                <select id="categoriaCreacion" style="width:100%; height:30px" name="categoriaCreacion">
                                                    <?php foreach($categorias as $categoria){ ?>
                                                        <option value="<?php echo $categoria['id']?>"><?php echo $categoria['descripcion']?></option>
                                                    <?php } ?>  
                                                </select>   
                                            </div>                
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-12" id="botonesModalCreacion">
                                        <div class="d-flex align-items-center justify-content-around">
                                            <button type="button" class="btn botonCancelar" data-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn boton" disabled id="btnCreacion" onclick="pedirConfirmacion('botonesModalCreacion', 'confirmacionCreacion', 'crear')">Confirmar</button>
                                        </div>
                                    </div>
                                    <div class="col-12  hide" id="confirmacionCreacion">
                                        <div class="d-flex align-items-center mb-3 purple justify-content-around">
                                            ¿Confirma la creación del articulo?
                                        </div>
                                        <div class="d-flex align-items-center justify-content-around">
                                            <button type="button" class="btn botonCancelar" onclick="cancelarConfirmacion('confirmacionCreacion', 'botonesModalCreacion', 'crear')">Cancelar</button>
                                            <button type="submit" name="crearArticulo" id="btnCrearArticulo" onclick="desbloquearFormularioCreacion(), mostrarSpinner('btnCrearArticulo','spinnerCrearArticulo')" class="btn boton">Confirmar</button>
                                            <button type="button" class="btnReenviarCircle hide" id="spinnerCrearArticulo" >
                                                <div class="spinner-border spinnerReenviar" role="status">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!----     END MODAL CREACION DE ARTICULO    ----->

                <!----     START MODAL EDICION DE ARTICULO    ----->
                <form name="formEdicion" method="POST" action="adminArticulos.php">
                    <div class="modal fade" id="edicionModal" tabindex="-1" role="dialog" aria-labelledby="edicionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title centrarTexto purple" id="edicionModalLabel">EDICIÓN DE ARTICULO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="bodyModalCrear">
                                    <div class="contenedorSeccion purple contenedorModal mb-4" id="boxEditarArticulo">        
                                        <div class="row">
                                            <!-- <div class="col-12 columna">
                                                <button type="button" class="btn botonLimpiar" id="btnLimpiarFormEdicion" onclick="limpiarFormularioEdicion()">Limpiar Formulario</button>
                                            </div> -->
                                            <input id="idArticuloEdicion" name="idArticuloEdicion" class="hide">
                                                
                                            <div class="col-12 columna">
                                                <label> Descripción: </label>
                                                <input maxlength="30" style="width:100%" id="descripcionEdicion" name="descripcionEdicion" autocomplete="off" onkeyup="validarDescripcionEdicion(value)">
                                                <div class="hide errorValidacion" id="mensajeValidacionEdicion"></div>
                                            </div>
                                            <div class="col-12 columna">
                                                <label class="labelForm"> Medida: </label>
                                                <select id="medidaEdicion" style="width:100%; height:30px" onchange="validarFormularioEdicion()" name="medidaEdicion">
                                                <?php foreach($medidas as $medida){ ?>
                                                        <option value="<?php echo $medida['id']?>"><?php echo $medida['descripcion']?></option>
                                                    <?php } ?> 
                                                </select>   
                                            </div>
                                            <div class="col-12 columna">
                                                <label class="labelForm"> Categoria: </label>
                                                <select id="categoriaEdicion" style="width:100%; height:30px" onchange="validarFormularioEdicion()" name="categoriaEdicion">
                                                    <?php foreach($categorias as $categoria){ ?>
                                                        <option value="<?php echo $categoria['id']?>"><?php echo $categoria['descripcion']?></option>
                                                    <?php } ?>  
                                                </select>   
                                            </div>                
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-12" id="botonesModalEdicion">
                                        <div class="d-flex align-items-center justify-content-around">
                                            <button type="button" class="btn botonCancelar" data-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn boton" disabled id="btnEdicion" onclick="pedirConfirmacion('botonesModalEdicion', 'confirmacionEdicion', 'editar')">Confirmar</button>
                                        </div>
                                    </div>
                                    <div class="col-12  hide" id="confirmacionEdicion">
                                        <div class="d-flex align-items-center mb-3 purple justify-content-around">
                                            ¿Confirma la edición del articulo?
                                        </div>
                                        <div class="d-flex align-items-center justify-content-around">
                                            <button type="button" class="btn botonCancelar" onclick="cancelarConfirmacion('confirmacionEdicion', 'botonesModalEdicion', 'editar')">Cancelar</button>
                                            <button type="submit" name="editarArticulo" id="btnEditarArticulo" onclick="desbloquearFormularioEdicion(), mostrarSpinner('btnEditarArticulo','spinnerEditarArticulo')" class="btn boton">Confirmar</button>
                                            <button type="button" class="btnReenviarCircle hide" id="spinnerEditarArticulo" >
                                                <div class="spinner-border spinnerReenviar" role="status">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!----     END MODAL EDICION DE USUARIO    ----->
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>          
        <script type="text/javascript"  src="js/funcionesCompartidas.js"></script> 
        <script type="text/javascript"  src="js/adminArticulos.js"></script> 
    </body>
</html>
<script>
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
window.onload = function(){
    let alertConfirmacion = document.getElementById("alertConfirmacion")
    if (alertConfirmacion.classList.contains('show')) {
        setTimeout(ocultarAlertConfirmacion, 5000)
    }
    let alertErrorConexion = document.getElementById("alertErrorConexion")
    if (alertErrorConexion.classList.contains('show')) {
        setTimeout(ocultarAlertError, 5000)
    }
}
function validarDescripcionEdicion(value){
    let boxMensajeArticuloExistente = document.getElementById("mensajeValidacionEdicion")
    let btnEdicion = document.getElementById("btnEdicion")
    btnEdicion.setAttribute("disabled", true)
    let articulos = <?php  echo json_encode($articulos) ?>;
    if(value.length >=3) {
        let articulosExistentes = articulos.filter(element => element.descripcion.toLowerCase().includes(value.toLowerCase()))
        let descripcionesArticulosExistentes = ""
        articulosExistentes.forEach(function callback(value, index) {
            descripcionesArticulosExistentes = descripcionesArticulosExistentes + value.descripcion + " "
        })
        if(articulosExistentes.length > 0) {
            boxMensajeArticuloExistente.classList.remove("hide")
            boxMensajeArticuloExistente.innerHTML = "Ya existen los siguientes articulos: " + descripcionesArticulosExistentes
        }else{
            btnEdicion.removeAttribute("disabled")
            boxMensajeArticuloExistente.classList.add("hide")
        }
    } else {
        boxMensajeArticuloExistente.classList.remove("hide")
        boxMensajeArticuloExistente.innerHTML = "3 o mas caracteres"
    }
}
function validarDescripcionCreacion(value){
    let boxMensajeArticuloExistente = document.getElementById("mensajeValidacionCreacion")
    let btnCreacion = document.getElementById("btnCreacion")
    btnCreacion.setAttribute("disabled", true)
    let articulos = <?php  echo json_encode($articulos) ?>;
    if(value.length >=3) {
        let articulosExistentes = articulos.filter(element => element.descripcion.toLowerCase().includes(value.toLowerCase()))
        let descripcionesArticulosExistentes = ""
        articulosExistentes.forEach(function callback(value, index) {
            descripcionesArticulosExistentes = descripcionesArticulosExistentes + value.descripcion + " "
        })
        if(articulosExistentes.length > 0) {
            boxMensajeArticuloExistente.classList.remove("hide")
            boxMensajeArticuloExistente.innerHTML = "Ya existen los siguientes articulos: " + descripcionesArticulosExistentes
        }else{
            btnCreacion.removeAttribute("disabled")
            boxMensajeArticuloExistente.classList.add("hide")
        }
    } else {
        boxMensajeArticuloExistente.classList.remove("hide")
        boxMensajeArticuloExistente.innerHTML = "3 o mas caracteres"
    }
}

</script>