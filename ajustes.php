<?php
session_start();
require("funciones/pdo.php");
$id = $_SESSION["id"];
$dni = $_SESSION["dni"];
$alertErrorConexion = "hide";
$alertConfirmacion = "hide";
$mensajeAlertError = "";
$mensajeAlertConfirmacion = "";

if (isset($_POST["changePassword"])) {
    $pass = $_POST["inputPassword"];
    $newPass = password_hash($_POST["inputNewPassword"], PASSWORD_DEFAULT);
    $consulta = $baseDeDatos ->prepare("SELECT password FROM agentes A WHERE A.id = '$id'");
    try {
        $consulta->execute();
        $password = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        if(password_verify($pass, $password[0]["password"])) {
            $update = $baseDeDatos ->prepare("UPDATE agentes SET password = '$newPass' WHERE id = '$id'");
            try {
                $update->execute();
                $_SESSION["pedirCambioPassword"] = "hide";
                $mensajeAlertConfirmacion = "¡La contraseña se modificó correctamente!";
                $alertConfirmacion = "show";
                if(isset($_POST["cbxDatos"])){
                    setcookie("usuario", $dni, time()+(60*60*24*365));
                    setcookie("password", $_POST["inputNewPassword"], time()+(60*60*24*365));
                    setcookie("recordarDatos", true, time()+(60*60*24*365));
                } else {
                    setcookie("usuario", "", time()+(60*60*24*365));
                    setcookie("password", "", time()+(60*60*24*365));
                    setcookie("recordarDatos", false, time()+(60*60*24*365));
                    setcookie("recordarUsuario", false, time()+(60*60*24*365));
                }
            } catch (\Throwable $th) {
                $mensajeAlertError = "Hubo un error de conexión. Por favor realizá el cambio nuevamente";
                $alertErrorConexion = "show";
            }
        } else{
            $mensajeAlertError = "La contraseña actual que ingresó no es correcta";
            $alertErrorConexion = "show";
        }
    } catch (\Throwable $th) {  
        $mensajeAlertError = "Hubo un error de conexión. Por favor intente nuevamente";
        $alertErrorConexion = "show";
    }
};

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
                        <span class="pointer" onclick="redirect('inicio')">Inicio</span> -<span class="grey"> Ajustes </span>
                    </div>
                </div>
                <div>
                    <div class="alert alert-danger mt-3 centrarTexto <?php echo $alertErrorConexion ?>" id="alertErrorConexion" role="alert" >
                        <?php echo $mensajeAlertError ?>
                    </div>
                    <div class="alert alert-success mt-3 centrarTexto <?php echo $alertConfirmacion ?>" id="alertConfirmacion" role="alert">
                        <?php echo $mensajeAlertConfirmacion ?>
                    </div>
                    <div class="alert alert-success mt-3  <?php echo $_SESSION["pedirCambioPassword"] ?>" id="alertConfirmacion" role="alert">
                        Por seguridad, te pedimos que cambies tu contraseña. La misma debe tener como mínimo 8 digitos, y debe ser alfanumérica. Gracias.
                    </div>
                    <form name="formEdicion" method="POST" action="ajustes.php">
                        <!----     START BLOQUE CAMBIO DE CONTRASEÑA   ----->
                        <div class="bloque pb-4" >
                            <h5 class="modal-title centrarTexto purple" id="passwordModalLabel">CAMBIO DE CONTRASEÑA</h5>
                            <div class="row">
                                <!-- START INPUT PASSWORD -->
                                <div class="col-12 col-md-6 columna">
                                    <label>Actual contraseña </label>
                                    <div class="row m-0">
                                        <input class="col-10 col-sm-11 col-md-10 inputForm" maxlength="15" type="password" onkeyup="validarPassword(), validarFormPass()" name="inputPassword" autocomplete="off" id="inputPassword">
                                        <div class="col-1">
                                            <div class="eyeButton pt-1" id="mostrarContraseniaPerfil" onclick="mostrarContrasenia('mostrarContraseniaPerfil', 'ocultarContraseniaPerfil', 'inputPassword')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                </svg>
                                            </div>
                                            <div class="hide eyeButton pt-1" id="ocultarContraseniaPerfil" onclick="ocultarContrasenia('mostrarContraseniaPerfil', 'ocultarContraseniaPerfil', 'inputPassword')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" errorValidacion" id="errorInputPassword"></div>
                                </div>
                                <!-- END INPUT PASSWORD -->

                                <!-- START INPUT NEW PASSWORD -->
                                <div class="col-12 col-md-6 columna">
                                    <label>Nueva contraseña </label>
                                    <div class="row m-0">
                                        <input class="col-10 col-sm-11 col-md-10 inputForm" maxlength="15" type="password" onkeyup="validarNewPassword(), validarFormPass()" name="inputNewPassword" autocomplete="off" id="inputNewPassword"> 
                                        <div class="col-1">
                                            <div class="eyeButton pt-1" id="mostrarNewContraseniaPerfil" onclick="mostrarContrasenia('mostrarNewContraseniaPerfil', 'ocultarNewContraseniaPerfil', 'inputNewPassword')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                </svg>
                                            </div>
                                            <div class="hide eyeButton pt-1" id="ocultarNewContraseniaPerfil" onclick="ocultarContrasenia('mostrarNewContraseniaPerfil', 'ocultarNewContraseniaPerfil', 'inputNewPassword')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" errorValidacion" id="errorNewPassword"></div>
                                </div>
                                <!-- END INPUT NEW PASSWORD -->

                                <!-- START INPUT REPEAT NEW PASSWORD -->
                                <div class="col-12 col-md-6 columna">
                                    <label>Repita su nueva contraseña: </label>
                                    <div class="row m-0">
                                        <input class="col-10 col-sm-11 col-md-10 inputForm" maxlength="15" type="password" name="confirmPassword" autocomplete="off" onkeyup="compararContrasenias(), validarFormPass()" id="inputConfirmPassword">
                                        <div class="col-1">
                                            <div class="eyeButton pt-1" id="mostrarConfirmContraseniaPerfil" onclick="mostrarContrasenia('mostrarConfirmContraseniaPerfil', 'ocultarConfirmContraseniaPerfil', 'inputConfirmPassword')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                </svg>
                                            </div>
                                            <div class="hide eyeButton pt-1" id="ocultarConfirmContraseniaPerfil" onclick="ocultarContrasenia('mostrarConfirmContraseniaPerfil', 'ocultarConfirmContraseniaPerfil', 'inputConfirmPassword')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" errorValidacion" id="errorConfirmPassword"></div>
                                </div>     

                                <!-- END INPUT REPEAT NEW PASSWORD -->
                                <div class="col-12 col-sm-6 col-md-3 d-flex pt-4 pt-md-0 align-items-end justify-content-center columna">
                                    <label class="labelCheckbox d-flex align-items-center"><input type="checkbox" class="mr-2" name="cbxDatos" id="cbxDatos"> Recordar usuario y contraseña</label>
                                </div> 

                                <!-- START BOTON CONFIRMACION -->
                                <div class="col-12 col-sm-6 col-md-3 d-flex pt-4 pt-md-0 align-items-end justify-content-center columna">
                                    <button type="button" class="btn boton" disabled id="btnConfirmar" data-bs-toggle="modal" data-bs-target="#passwordModal">Confirmar</button>
                                </div>     
                                <!-- END BOTON CONFIRMACION -->
                            </div>                  
                        </div>
                        <!----     END BLOQUE CAMBIO DE CONTRASEÑA    ----->
                    
                        <!----     START MODAL CAMBIO DE CONTRASEÑA   ----->
                        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title purple" id="passwordModalLabel">CONFIRMACIÓN</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="bodyModalCrear">
                                        <div class="row d-flex justify-content-center">
                                            ¿Confirma el cambio de contraseña?
                                        </div>               
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-12" id="confirmacionEdicion">
                                            <div class="d-flex align-items-center justify-content-around">
                                            <button type="button" class="btn botonCancelar" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" name="changePassword" id="btnChangePassword" onclick="mostrarSpinner('btnChangePassword','spinnerChangePassword')" class="btn boton">Confirmar</button>
                                                <button type="button" class="btnReenviarCircle hide" id="spinnerChangePassword" >
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
                        <!----     END MODAL CAMBIO DE CONTRASEÑA    ----->
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>           
        <script type="text/javascript"  src="js/funcionesCompartidas.js"></script> 
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

function validarPassword () {
    let password = document.getElementById("inputPassword").value
    let boxError = document.getElementById("errorInputPassword")

    if ( password.length == 0 ) {
        boxError.innerHTML = "Campo requerido"
        boxError.classList.remove("hide")
        return
    }  else if ( password.length < 8 ) {
        boxError.innerHTML = "Entre 8 y 15 caracteres"
        boxError.classList.remove("hide")
        return
    } 
        boxError.innerHTML = ""
        boxError.classList.add("hide")
        return
}
function validarFormPass () {
    let password = document.getElementById("inputPassword").value
    let newPassword = document.getElementById("inputNewPassword").value
    let confirmPassword = document.getElementById("inputConfirmPassword").value
    let errorPassword = document.getElementById("errorInputPassword").innerHTML
    let errorNewPassword = document.getElementById("errorNewPassword").innerHTML
    let errorConfirmPassword = document.getElementById("errorConfirmPassword").innerHTML
    let btnConfirmar = document.getElementById("btnConfirmar")
    if ( password.trim() != "" && newPassword.trim() != "" && confirmPassword.trim() != "" && errorPassword == "" && errorNewPassword == ""  && errorConfirmPassword == "") {
        return btnConfirmar.removeAttribute("disabled")
    } 
    return btnConfirmar.setAttribute("disabled", true)
}
function validarNewPassword () {
    let password = document.getElementById("inputNewPassword").value
    let boxError = document.getElementById("errorNewPassword")
    let confirmPassword = document.getElementById("inputConfirmPassword").value
    if(confirmPassword != "") {
        compararContrasenias()
    }

    if ( password.length == 0 ) {
        boxError.innerHTML = "Campo requerido"        
        return boxError.classList.remove("hide")
    }  else if ( password.length < 8 ) {
        boxError.innerHTML = "Entre 8 y 15 caracteres"
        return boxError.classList.remove("hide")
    } else if ( password.includes(' ')) {
        boxError.innerHTML = "No puede poseer espacios en blanco"
        return boxError.classList.remove("hide") 
    } else if (!tiene_letras(password) || !tiene_numeros(password)) {
        boxError.innerHTML = "Debe tener letras y números"
        return boxError.classList.remove("hide")
    } 
    boxError.innerHTML = ""
    boxError.classList.add("hide")
    return
}
function compararContrasenias () {
    let newPassword = document.getElementById("inputNewPassword").value
    let confirmPassword = document.getElementById("inputConfirmPassword").value
    let errorConfirmPassword = document.getElementById("errorConfirmPassword")
    if ( confirmPassword != "" && confirmPassword != newPassword ) {
        errorConfirmPassword.innerHTML = "Las contraseñas no coinciden"
        return errorConfirmPassword.classList.remove("hide")
    }
    errorConfirmPassword.innerHTML = ""
    return errorConfirmPassword.classList.add("hide")
}


function tiene_letras(texto){
    var letras="abcdefghyjklmnñopqrstuvwxyz";
    texto = texto.toLowerCase();
    for(i=0; i<texto.length; i++){
       if (letras.indexOf(texto.charAt(i),0)!=-1){
          return 1;
       }
    }
    return 0;
}
function tiene_numeros(texto){
    var letras="0123456789";
    texto = texto.toLowerCase();
    for(i=0; i<texto.length; i++){
       if (letras.indexOf(texto.charAt(i),0)!=-1){
          return 1;
       }
    }
    return 0;
}
</script>