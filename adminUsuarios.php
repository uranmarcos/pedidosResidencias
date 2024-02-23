<?php
session_start();
require("funciones/pdo.php");
require("funciones/adminUsuarios.php");
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
                        <span class="pointer" onclick="redirect('inicio')">Inicio</span> -<span class="pointer" onclick="redirect('admin')"> Admin </span> - <span class="grey"> Admin USUARIOS</span>
                    </div>
                </div>
                <!--    START BOX LISTADO USUARIOS    -->
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
                                    Usuarios Disponibles
                                </div>
                                <div class="col-6 d-flex align-items-end justify-content-end">
                                    <button type="button" class="btn boton" data-toggle="modal" data-target="#pruebaModal">
                                        Nuevo Usuario
                                    </button>
                                </div>
                            </div>
                            <!-- START TABLA CON LISTA DE USUARIOS -->
                            <div class="table-responsive">
                                <table class="table <?php echo $hayDatos ?>">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="hide">#</th>
                                            <th scope="col" style="width:30%">Nombre</th>
                                            <th scope="col" style="width:20%">Apellido</th>
                                            <th scope="col" style="width:30%; text-align:center">Sede</th>
                                            <th scope="col" style="width:5%; text-align:center">Casa</th>
                                            <th scope="col" style="width:10%; text-align:center">Rol</th>
                                            <th scope="col" style="width:150px; text-align:center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($usuarios as $usuario){ ?>
                                            <tr>
                                                <td class="hide"><?php echo $usuario["id"] ?></td>
                                                <td><?php echo $usuario["nombre"] . " " . $usuario["segundoNombre"] ?></td>
                                                <td><?php echo $usuario["apellido"] ?></td>
                                                <td style="text-align: center"><?php echo $usuario["provincia"] . " - " . $usuario["sede"] ?></td>
                                                <td style="text-align: center"><?php echo $usuario["casa"] ?></td>
                                                <td style="text-align: center"><?php echo $usuario["rol"] ?></td>
                                                <td class="pl-0 pr-0" style="width:150px; text-align:center"> 
                                                    <div class="row <?php echo $usuario['rol'] == 'admin' ? 'hide' : ''?>" style="width:145px; margin:auto;">
                                                        <!-- BOTON TRASH -->
                                                        <div style="width:45px" onmouseover="overBotonAccion('btnTrash<?php echo $usuario['id']?>','btnTrashFill<?php echo $usuario['id']?>')" onmouseout="overBotonAccion('btnTrashFill<?php echo $usuario['id']?>', 'btnTrash<?php echo $usuario['id']?>')" name="trashButton<?php echo $usuario['id']?>" id="trashButton<?php echo $usuario['id']?>" class="trashButton" onclick="eliminarUsuarios(<?php echo $usuario['id']?>, '<?php echo $usuario['nombre'];?>', '<?php echo $usuario['apellido'];?>')" data-bs-toggle="modal" data-bs-target="#modalEliminar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" id="btnTrash<?php echo $usuario['id']?>" viewBox="0 0 16 16">
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>    
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi hide bi-trash-fill" id="btnTrashFill<?php echo $usuario['id']?>" viewBox="0 0 16 16">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                            </svg>
                                                        </div>
                                                        <!-- BOTON EDIT -->
                                                        <div style="width:45px" class="editButton" id="editButton<?php echo $usuario['id']?>" onmouseover="overBotonAccion('btnPen<?php echo $usuario['id']?>','btnPenFill<?php echo $usuario['id']?>')" onmouseout="overBotonAccion('btnPenFill<?php echo $usuario['id']?>', 'btnPen<?php echo $usuario['id']?>')" onclick="cargarDatosEdicion('<?php echo $usuario['id']?>', '<?php echo $usuario['nombre']?>', '<?php echo $usuario['segundoNombre']?>', '<?php echo $usuario['apellido']?>', '<?php echo $usuario['dni']?>', '<?php echo $usuario['rol']?>', '<?php echo $usuario['mail']?>', '<?php echo $usuario['idSede']?>', <?php echo $usuario['casa']?>)" data-toggle="modal" data-target="#edicionModal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="btnPen<?php echo $usuario['id']?>" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="btnPenFill<?php echo $usuario['id']?>" class="bi hide bi-pencil-fill" viewBox="0 0 16 16">
                                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                            </svg> 
                                                        </div>
                                                        <!-- BOTON KEY -->
                                                        <div style="width:45px" class="editButton" id="passwordButton<?php echo $usuario['id']?>" onmouseover="overBotonAccion('btnKey<?php echo $usuario['id']?>','btnKeyFill<?php echo $usuario['id']?>')"  onmouseout=" overBotonAccion('btnKeyFill<?php echo $usuario['id']?>', 'btnKey<?php echo $usuario['id']?>')" onclick="cargarResetPassword('<?php echo $usuario['id']?>', '<?php echo $usuario['dni']?>', '<?php echo $usuario['nombre']?>', '<?php echo $usuario['segundoNombre']?>', '<?php echo $usuario['apellido']?>')" data-bs-toggle="modal" data-bs-target="#resetModal" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" id="btnKey<?php echo $usuario['id']?>" viewBox="0 0 16 16">
                                                                <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
                                                                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi hide bi-key-fill" id="btnKeyFill<?php echo $usuario['id']?>" viewBox="0 0 16 16">
                                                                <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                            </svg>    
                                                        </div>
                                                    </div>
                                                </td>                                            
                                            </tr>
                                        <?php } ?>   
                                    </tbody>               
                                </table>
                            </div>
                            <!-- END TABLA CON LISTA DE USUARIOS -->
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
                <!-- START MODAL CONFIRMACION ELIMINACION USUARIO -->                    
                <form action="adminUsuarios.php" method="POST">
                    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <input type="text" hidden name="idUsuarioEliminar" id="idUsuarioEliminar"></input>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body centrarTexto">
                                    ¿Confirma que desea eliminar el usuario <b><span id="usuarioAEliminar"></span></b>?
                                </div>
                                <div class="modal-footer d-flex justify-content-around">
                                    <button type="button" class="btn botonCancelar" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="eliminarUsuario" id="btnEliminarUsuario" onclick="mostrarSpinner('btnEliminarUsuario', 'spinnerEliminarUsuario')" class="btn boton">Confirmar</button>
                                    <button type="button" class="btnReenviarCircle hide" id="spinnerEliminarUsuario">
                                        <div class="spinner-border spinnerReenviar" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END MODAL CONFIRMACION ELIMINACION USUARIO -->
                <!----     START MODAL CREACION DE USUARIO    ----->
                <form name="formCreacion" method="POST" action="adminUsuarios.php">
                    <div class="modal fade" id="pruebaModal" tabindex="-1" role="dialog" aria-labelledby="pruebaModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title centrarTexto purple" id="pruebaModalLabel">CREACIÓN DE USUARIO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="bodyModalCrear">
                                    <div class="contenedorSeccion purple contenedorModal mb-4">        
                                        <div class="row">
                                            <div class="col-12 columna">
                                                <button type="button" class="btn botonLimpiar" id="btnLimpiarCreacion" onclick="limpiarFormularioCreacion()">Limpiar Formulario</button>
                                            </div>
                                            <div class="col-12 columna">
                                                <label >Primer Nombre: </label>
                                                <input  maxlength="12" style="width:100%" name="primerNombreCreacion" id="primerNombreCreacion" autocomplete="off" onkeyup="validarCampo('primerNombreCreacion', 'errorPrimerNombreCreacion'), validarFormCreacion()">
                                                <div class="hide errorValidacion" id="errorPrimerNombreCreacion"></div>
                                            </div>
                                            <div class="col-12 columna">
                                                <label>Segundo Nombre: </label>
                                                <input maxlength="12"  style="width:100%" name="segundoNombreCreacion" id="segundoNombreCreacion" autocomplete="off" onkeyup="validarCampo('segundoNombreCreacion', 'errorSegundoNombreCreacion'), validarFormCreacion()">                                               
                                                <div class="hide errorValidacion" id="errorSegundoNombreCreacion"></div>
                                            </div>
                                            <div class="col-12 columna">
                                                <label>Apellido: </label>
                                                <input maxlength="12"  style="width:100%" name="apellidoCreacion" id="apellidoCreacion" autocomplete="off" onkeyup="validarCampo('apellidoCreacion', 'errorApellidoCreacion'), validarFormCreacion()">
                                                <div class="hide errorValidacion" id="errorApellidoCreacion"></div>
                                            </div>
                                            <div class="col-6 columna">
                                                <label>DNI: </label>
                                                <input maxlength="8"  style="width:100%" name="dniCreacion" id="dniCreacion" autocomplete="off" onkeyup="validarCampo('dniCreacion', 'errorDniCreacion'), validarFormCreacion()">
                                                <div class="hide errorValidacion" id="errorDniCreacion"></div>
                                            </div>
                                            <div class="col-6 columna">
                                                <label>Rol: </label>
                                                <select  style="width:100%; height: 30px"  name="rolCreacion" id="rolCreacion" onchange="validarFormCreacion()">
                                                    <?php foreach($roles as $rol){ ?>
                                                        <option value="<?php echo $rol["value"] ?>"><?php echo $rol["descripcion"] ?></option>
                                                    <?php } ?>
                                                </select>   
                                                <div class="hide errorValidacion" id="errorRolCreacion"></div>
                                            </div>
                                            <div class="col-12 columna">                                                    
                                                <label>Mail: </label>
                                                <input name="mailCreacion"  style="width:100%" id="mailCreacion" type="email" autocomplete="off" onkeyup="validarCampo('mailCreacion', 'errorMailCreacion'), validarFormCreacion()"> 
                                                <div class="hide errorValidacion" id="errorMailCreacion"></div>
                                            </div>
                                            <div class="col-9 columna">
                                                <label>Sede: </label>
                                                <select style="height:30px; width: 100%;" id="sedeCreacion" name="sedeCreacion" onchange="selectSede(value), validarFormCreacion()">
                                                    <?php foreach($sedes as $sede){ ?>
                                                        <option value="<?php echo $sede['id']?>"><?php echo $sede['provincia'] . " - " . $sede['localidad']?></option>
                                                    <?php } ?> 
                                                </select>    
                                                <div class="hide errorValidacion" id="errorSedeCreacion"></div>
                                            </div>
                                            <div class="col-3 columna">
                                                <label>Casa: </label>
                                                <select  id="casaCreacion" name="casaCreacion" style="height:30px; width:100%" onchange="validarFormCreacion()">
                                                    <option value="1" name="opcionSelectCasa">1</option>
                                                    <option value="2" name="opcionSelectCasa">2</option>
                                                    <option value="3" name="opcionSelectCasa">3</option>
                                                    <option value="4" name="opcionSelectCasa">4</option>
                                                    <option value="5" name="opcionSelectCasa">5</option>
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
                                            ¿Confirma la creación del usuario?
                                        </div>
                                        <div class="d-flex align-items-center justify-content-around">
                                            <button type="button" class="btn botonCancelar" onclick="cancelarConfirmacion('confirmacionCreacion', 'botonesModalCreacion', 'crear')">Cancelar</button>
                                            <button type="submit" name="crearUsuario" id="btnCrearUsuario" onclick="desbloquearFormularioCreacion(), mostrarSpinner('btnCrearUsuario','spinnerCrearUsuario')" class="btn boton">Confirmar</button>
                                            <button type="button" class="btnReenviarCircle hide" id="spinnerCrearUsuario" >
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
                <!----     END MODAL CREACION DE USUARIO    ----->
                <!----     START MODAL EDICION DE USUARIO    ----->
                <form name="formEdicion" method="POST" action="adminUsuarios.php">
                    <div class="modal fade" id="edicionModal" tabindex="-1" role="dialog" aria-labelledby="edicionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title centrarTexto purple" id="edicionModalLabel">EDICIÓN DE USUARIO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="bodyModalCrear">
                                    <div class="contenedorSeccion purple contenedorModal mb-4">        
                                        <div class="row">
                                            <!-- <div class="col-12 columna">
                                                <button type="button" class="btn botonLimpiar" id="btnLimpiarEdicion" onclick="limpiarFormularioEdicion()">Limpiar Formulario</button>
                                            </div> -->
                                            <input class="hide" name="idUsuarioEdicion" id="idUsuarioEdicion">
                                            <div class="col-12 columna">
                                                <label >Primer Nombre: </label>
                                                <input  maxlength="12" style="width:100%" name="primerNombreEdicion" id="primerNombreEdicion" autocomplete="off" onkeyup="validarCampo('primerNombreEdicion', 'errorPrimerNombreEdicion'), validarFormEdicion()">
                                                <div class="hide errorValidacion" id="errorPrimerNombreEdicion"></div>
                                            </div>
                                            <div class="col-12 columna">
                                                <label>Segundo Nombre: </label>
                                                <input maxlength="12"  style="width:100%" name="segundoNombreEdicion" id="segundoNombreEdicion" autocomplete="off" onkeyup="validarCampo('segundoNombreEdicion', 'errorSegundoNombreEdicion'), validarFormEdicion()">                                               
                                                <div class="hide errorValidacion" id="errorSegundoNombreEdicion"></div>
                                            </div>
                                            <div class="col-12 columna">
                                                <label>Apellido: </label>
                                                <input maxlength="12"  style="width:100%" name="apellidoEdicion" id="apellidoEdicion" autocomplete="off" onkeyup="validarCampo('apellidoEdicion', 'errorApellidoEdicion'), validarFormEdicion()">
                                                <div class="hide errorValidacion" id="errorApellidoEdicion"></div>
                                            </div>
                                            <div class="col-6 columna">
                                                <label>DNI: </label>
                                                <input maxlength="8" disabled style="width:100%" name="dniEdicion" id="dniEdicion" autocomplete="off" onkeyup="validarCampo('dniEdicion', 'errorDniEdicion'), validarFormEdicion()">
                                            </div>
                                            <div class="col-6 columna">
                                                <label>Rol: </label>
                                                <select  style="width:100%; height: 30px"  name="rolEdicion" id="rolEdicion" onchange="validarFormEdicion()">
                                                    <?php foreach($roles as $rol){ ?>
                                                        <option value="<?php echo $rol["value"] ?>"><?php echo $rol["descripcion"] ?></option>
                                                    <?php } ?>
                                                </select>   
                                            </div>
                                            <div class="col-12 columna">                                                    
                                                <label>Mail: </label>
                                                <input name="mailEdicion"  style="width:100%" id="mailEdicion" type="email" autocomplete="off" onkeyup="validarCampo('mailEdicion', 'errorMailEdicion'), validarFormEdicion()"> 
                                                <div class="hide errorValidacion" id="errorMailEdicion"></div>
                                            </div>
                                            <div class="col-9 columna">
                                                <label>Sede: </label>
                                                <select style="height:30px; width: 100%;" id="sedeEdicion" name="sedeEdicion" onchange="selectSede(value), validarFormEdicion()">
                                                    <?php foreach($sedes as $sede){ ?>
                                                        <option value="<?php echo $sede['id']?>"><?php echo $sede['provincia'] . " - " . $sede['localidad']?></option>
                                                    <?php } ?> 
                                                </select>    
                                            </div>
                                            <div class="col-3 columna">
                                                <label>Casa: </label>
                                                <select  id="casaEdicion" name="casaEdicion" style="height:30px; width:100%" onchange="validarFormEdicion()">
                                                    <option value="1" name="opcionSelectCasa">1</option>
                                                    <option value="2" name="opcionSelectCasa">2</option>
                                                    <option value="3" name="opcionSelectCasa">3</option>
                                                    <option value="4" name="opcionSelectCasa">4</option>
                                                    <option value="5" name="opcionSelectCasa">5</option>
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
                                            ¿Confirma la edición del usuario?
                                        </div>
                                        <div class="d-flex align-items-center justify-content-around">
                                            <button type="button" class="btn botonCancelar" onclick="cancelarConfirmacion('confirmacionEdicion', 'botonesModalEdicion', 'editar')">Cancelar</button>
                                            <button type="submit" name="editarUsuario" id="btnEditar" onclick="desbloquearFormularioEdicion(), mostrarSpinner('btnEditar','spinnerEditarUsuario')" class="btn boton">Confirmar</button>
                                            <button type="button" class="btnReenviarCircle hide" id="spinnerEditarUsuario" >
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

                <!-- MODAL CONFIRMACION RESET PASSWORD -->
                <form name="formEdicion" method="POST" action="adminUsuarios.php">
                    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <input type="text" hidden name="idUsuarioResetPassword" id="idUsuarioResetPassword"></input>
                                    <input type="text" hidden name="dniUsuarioResetPassword" id="dniUsuarioResetPassword"></input>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body centrarTexto">
                                    ¿Confirma que desea resetear la contraseña <br>de <b><span id="spanResetPassword"></span></b>?</br> Se le asignará como nueva contraseña su DNI.
                                </div>
                                <div class="modal-footer d-flex justify-content-around">
                                    <button type="button" class="btn botonCancelar" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="resetPassword" id="btnResetPassword" onclick="mostrarSpinner('btnResetPassword','spinnerResetPassword')" class="btn boton">Confirmar</button>
                                    <button type="button" class="btnReenviarCircle hide" id="spinnerResetPassword" >
                                        <div class="spinner-border spinnerReenviar" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>          
        <script type="text/javascript"  src="js/funcionesCompartidas.js"></script> 
        <script type="text/javascript"  src="js/adminUsuarios.js"></script> 
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

function selectSede(param) {
    let sedes = <?php echo json_encode($sedes)?> 
    let sedeSeleccionada = sedes.filter(e=> e.id == param)
    let cantidadCasas = parseInt(sedeSeleccionada[0].casas)
    let opciones = document.getElementsByName("opcionSelectCasa")
    opciones.forEach(e => {
        e.removeAttribute("disabled")
    })
    opciones.forEach(e => {
        if (e.value > cantidadCasas){
            e.setAttribute("disabled", true)
        }
    })
}


</script>