<?php

  $dsn = "mysql:dbname=pedidos; host=localhost; port=3306";
  $usuario = "root";
  $pass = "";
  // $dsn = "mysql:dbname=fundaci_pedidos; host=localhost; port=21";
  // $usuario = "fundaci_pedidos";
  // $pass = "pedidos.1379";

  try {
    $baseDeDatos = new PDO($dsn, $usuario, $pass);
    $baseDeDatos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (\Exception $e) {
      echo "Oh no, hubo un error! Vuelves mas tarde?"; exit;
  }
