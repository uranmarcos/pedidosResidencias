<?php
session_start();
require("funciones/pdo.php");
$error = "";
$dniUsuario = "";
$password = "";
$cbxUserChecked = false;
$cbxDatosChecked = false;
$mensajeError = "";
$boxMensajeError = "hide";
if (isset($_COOKIE["usuario"])) {
    $dniUsuario = $_COOKIE["usuario"];
}
if (isset($_COOKIE["recordarUsuario"])) {
    $cbxUserChecked = $_COOKIE["recordarUsuario"];
}
if (isset($_COOKIE["password"])) {
    $password = $_COOKIE["password"];
}
if (isset($_COOKIE["recordarDatos"])) {
    $cbxDatosChecked = $_COOKIE["recordarDatos"];
}
if($_POST){
    if(isset($_POST["btnIngresar"])){
        require("funciones/validarLogin.php");
        // header("Location:http://localhost/repositorioPedidos/componentes/home.php");
    }
    if(isset($_POST["resetPassword"])){
        $dni = $_POST["dniReset"];
        $mail = $_POST["mailReset"];
        try {
            $consulta = $baseDeDatos ->prepare("SELECT * FROM agentes WHERE dni = '$dni' AND mail='$mail'");
            $consulta->execute();
            $datosUsuarios = $consulta -> fetchAll(PDO::FETCH_ASSOC);
            if(empty($datosUsuarios)){
                $boxMensajeError = "show";
                $mensajeError = "Los datos ingresados no coinciden <br> con ningún registro.<br> El reseteo de contraseña no pudo realizarse.";
            } else {
                $newPassword = randomPassword();
                $pass = password_hash($newPassword, PASSWORD_DEFAULT);
                $consultaToken = $baseDeDatos ->prepare("UPDATE agentes SET password = '$pass' WHERE dni = '$dni'"); 
                try {
                    $consultaToken->execute();
                    try {
                        include("mailRecuperoPassword.php");
                        $boxMensajeError = "show";
                        $mensajeError = "El reseteo de contraseña se realizó correctamente y te enviamos un mail. <br> Revisá tu casilla de correo no deseado";
                    } catch (\Throwable $th) {
                        $boxMensajeError = "show";
                        $mensajeError = "Disculpe, hubo un error de conexión <br> y el reseteo de contraseña no pudo realizarse. <br> Por favor intente nuevamente.";
                    }
                } catch (\Throwable $th) {
                    $boxMensajeError = "show";
                    $mensajeError = "Disculpe, hubo un error de conexión <br> y el reseteo de contraseña no pudo realizarse. <br> Por favor intente nuevamente.";
                }
            }
        } catch (\Throwable $th) {
            $boxMensajeError = "show";
            $mensajeError = "Disculpe, hubo un error de conexión <br> y el reseteo de contraseña no pudo realizarse. <br> Por favor intente nuevamente.";
        }
    }
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

?>
<script>
    localStorage.clear();
</script>
<!DOCTYPE html>
<html>
    <head>
      <title>Pedidos Sí</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.8">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
      <link href="css/index.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="col-10 col-md-6 col-xl-4 container">
                <!-- caja botones login y registro  -->
                <section class="row">
                    <img src="img/si.jpg">
                </section>
                <section class="row contenedorForm">
                    <form action="index.php" method="POST">                      
                        <div class="row rowForm">
                            <input class="inputLabel" placeholder="DNI" maxlength="8" autocomplete="off" value="<?php echo $dniUsuario?>" onkeyup="validarDni()" type="text" name="dni" id="dni">
                            <div class="mensajeError" id="errorDni"></div>
                        </div>
                        <div class="row rowForm">                                
                            <input class="inputLabel inputContrasenia" placeholder="Contraseña" autocomplete="off" onkeyup="validarPassword()" value="<?php echo $password?>" type="password" id="password" name="password" value="">
                            <div class="eyeButton" id="mostrarContrasenia" onclick="mostrarContrasenia()">
                                <div class="contenedorSvgEye">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="hide eyeButton" id="ocultarContrasenia" onclick="ocultarContrasenia()">
                                <div class="contenedorSvgEye">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mensajeError" id="error"> <?php echo $error ?> </div>
                        </div>
                        <div class="row rowForm">
                            <label class="labelCheckbox"><input type="checkbox" name="cbxUsuario" onchange="alternarCheckbox('cbxDatos')" id="cbxUsuario"> Recordar usuario</label>
                            <label class="labelCheckbox"><input type="checkbox" name="cbxDatos" id="cbxDatos" onchange="alternarCheckbox('cbxUsuario')"> Recordar usuario y contraseña</label>
                        </div>    
                        <div class="row justify-content-center" >
                            <input type="submit" disabled class="col-6 botonSubmit" name="btnIngresar" id="btnIngresar" value="Ingresar">
                            <span class="recuperar" data-bs-toggle="modal" data-bs-target="#resetModal">
                                Recuperar contraseña
                            </span>
                        </div>     
                    </form>
                    <div class="boxError <?php echo $boxMensajeError ?>" id="boxError">
                        <div class="boxMensajeError">
                            <div class="cierreMensaje" onclick="cerrarError()">x</div>
                            <div class="cajaMensaje">
                                <div><?php echo $mensajeError;?></div>
                                <br>
                                <div>
                                    <button onclick="cerrarError()">Aceptar</button>
                                </div>
                            </div>    
                        </div>
                    </div>
                </section>
                <form name="formRecupero" method="POST" action="index.php">
                    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">RESETEO DE CONTRASEÑA
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body centrarTexto">
                                    Para resetear su contraseña por favor ingrese<br> su correo electrónico y su DNI
                                </div>
                                <input type="mail" class="inputReset" autocomplete="OFF" placeholder="Correo electrónico" name="mailReset" id="mailReset"></input>
                                <input type="text" class="inputReset" placeholder="DNI" autocomplete="OFF" name="dniReset" id="dniReset"></input>
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
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </body>
</html>
<script>
    if ( window.history.replaceState ) {
       window.history.replaceState( null, null, window.location.href );
    }
    window.onload = function(){
        validarFormulario()
        let cbxUserChecked =  <?php  echo json_encode($cbxUserChecked) ?>;
        let cbxDatosChecked = <?php  echo json_encode($cbxDatosChecked) ?>;
        let cbxUsuario = document.getElementById("cbxUsuario")
        let cbxDatos = document.getElementById("cbxDatos")
        if (cbxUserChecked) {
            return cbxUsuario.setAttribute("checked", true)
        }
        if (cbxDatosChecked) {
            return cbxDatos.setAttribute("checked", true)
        }
        cbxDatos.removeAttribute("checked")
        cbxUsuario.removeAttribute("checked")
       
    }
    function alternarCheckbox(id) {
        let idChecked = document.getElementById(id)
        idChecked.checked = 0
    }
    function mostrarContrasenia(){
        let boxMostrarContrasenia = document.getElementById("mostrarContrasenia")
        let password = document.getElementById("password")
        password.setAttribute("type", "text")
        boxMostrarContrasenia.classList.add("hide")
        let boxOcultarContrasenia = document.getElementById("ocultarContrasenia")
        boxOcultarContrasenia.classList.remove("hide")
    }
    function ocultarContrasenia(){
        let boxMostrarContrasenia = document.getElementById("mostrarContrasenia")
        let password = document.getElementById("password")
        password.setAttribute("type", "password")
        boxMostrarContrasenia.classList.remove("hide")
        let boxOcultarContrasenia = document.getElementById("ocultarContrasenia")
        boxOcultarContrasenia.classList.add("hide")
    }
    function validarDni(){
        let dni = document.getElementById("dni").value
        let password = document.getElementById("password").value
        let errorDni = document.getElementById("errorDni")
        let btnIngresar = document.getElementById("btnIngresar")
        if (dni.trim().length == 0){
            btnIngresar.setAttribute("disabled", true)
            return errorDni.innerHTML = ""
        } else if (!isNumber(dni)) {
            btnIngresar.setAttribute("disabled", true)
            return errorDni.innerHTML = "Campo numérico"
        } else if(dni.trim().length < 8) {
            btnIngresar.setAttribute("disabled", true)
            return errorDni.innerHTML = "Debe contener 8 dígitos"
        }else{
            if (password.length > 7) {
                btnIngresar.removeAttribute("disabled")
            } else {
                btnIngresar.setAttribute("disabled", true)
            }
            errorDni.innerHTML = "";
        }
    }
    function validarFormulario() {
        let dni = document.getElementById("dni").value
        let password = document.getElementById("password").value
        let btnIngresar = document.getElementById("btnIngresar")
        if (password.trim().length >= 8 && dni.length == 8 && isNumber(dni)) {
            btnIngresar.removeAttribute("disabled")
        }
    }
    function validarPassword() {
        let dni = document.getElementById("dni").value
        let error = document.getElementById("error")
        let password = document.getElementById("password").value
        let btnIngresar = document.getElementById("btnIngresar")
        if (password.trim().length == 0){
            btnIngresar.setAttribute("disabled", true)
            return error.innerHTML = ""
        } else if (password.trim().length <8 ) {
            btnIngresar.setAttribute("disabled", true)
            return error.innerHTML = "Mínimo 8 caracteres"
        } else {
            if (dni.length == 8 && isNumber(dni)) {
                btnIngresar.removeAttribute("disabled")
            } else {
                btnIngresar.setAttribute("disabled", true)
            }
            error.innerHTML = "";
        }
    }
    function isNumber(str) {
        var pattern = /^\d+$/;
        return pattern.test(str);  // returns a boolean
    }
    function mostrarSpinner(idBotonOcultar, ibBotonSpinner) {
        let botonOcultar = document.getElementById(idBotonOcultar)
        botonOcultar.classList.add("hide")
        let botonSpinner = document.getElementById(ibBotonSpinner)
        botonSpinner.classList.remove("hide")
    }
    function cerrarError(){
        console.log("ocultar")
        let boxError = document.getElementById("boxError")
        boxError.classList.remove("show")
        boxError.classList.add("hide")
    }
</script>