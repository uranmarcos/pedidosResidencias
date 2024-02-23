<?php 
//consulto a base de datos el pedido clickeado para ver
        $pedidoConsultado = $baseDeDatos ->prepare("SELECT PN.pedido, PN.sede, PN.fecha, PN.casa, A.nombre, A.segundoNombre, A.apellido FROM pedidosnuevos PN INNER JOIN
        agentes A ON PN.usuario = A.id WHERE PN.id = $idPedido");
        try {
            $pedidoConsultado->execute();
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
        }
        $pedido = $pedidoConsultado -> fetchAll(PDO::FETCH_ASSOC);
        $idSede = $pedido[0]["sede"];


        //consulta de la sede del pedido
        $consultaSede = $baseDeDatos ->prepare("SELECT * from sedes WHERE id = '$idSede'");
        try {
            $consultaSede->execute();
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
        }
        $sede = $consultaSede -> fetchAll(PDO::FETCH_ASSOC);
        // conversion de formato de fecha
        $newDate = date("d-m-Y", strtotime($pedido[0]["fecha"]));
        $otrosTabla = "";
        $pedidoTabla = [];

        // consulta listado de articulos
        $consultaArticulos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, A.medida, M.descripcion medida from articulos A INNER JOIN medidas M WHERE A.medida = M.id");
        $consultaArticulosValidada = false;
        try {
            $consultaArticulos->execute();
            $consultaArticulosValidada = true;
        } catch (\Throwable $th) {
            $alertErrorConexion = "show";
        }
        $otrosFormateado = "";
        if ($consultaArticulosValidada) {
            $articulos = $consultaArticulos -> fetchAll(PDO::FETCH_ASSOC);
            $pedidoAMostrar = explode(";", $pedido[0]["pedido"]);
            foreach($pedidoAMostrar as $p){
                $item = explode(":", $p);
                if($item[0] != "otros" && $item[0] != "" ){
                    $key = array_search($item[0], array_column($articulos, "id"));
                    $nuevoItem = [];
                    array_push($nuevoItem, $articulos[$key]["descripcion"] . ": " . $item[1] . " " . $articulos[$key]["medida"]); 
                    array_push($pedidoTabla, $nuevoItem);
                }
                if($item[0] == "otros"){
                    $otrosTabla = $item[1];
                    $cantidadRenglones = ceil(strlen($otrosTabla) / 95);
                    for ($i = 0; $i < $cantidadRenglones; $i++) {
                        $inicial = 95 * $i;
                        $final = 95;
                        if($final > strlen($otrosTabla)){
                            $final = strlen($otrosTabla);
                        }
                        $string = substr($otrosTabla, $inicial, $final) . "\n";  
                        $otrosFormateado = $otrosFormateado . $string;
                    }
                }
            }
            sort($pedidoTabla);
        try {
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $header = array('Listado de articulos pedidos');
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,5,"Pedido Mensual de " . utf8_decode($sede[0]["provincia"]) . ", " . utf8_decode($sede[0]["localidad"]),0,1,'C');
            $pdf->Cell(0,10,'Fecha: ' . $newDate,0,1);
            $pdf->Cell(0,10,'Casa: ' . $pedido[0]["casa"] . " -  Voluntario: " . $pedido[0]["nombre"] . " " . $pedido[0]["segundoNombre"] . " " . $pedido[0]["apellido"],0,1);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,10,'Articulos pedidos: ' ,0,1);
            $pdf->SetFont('Arial','',12);
            $pdf->TablaSimple($header,$pedidoTabla);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,10,'Otros: ' ,0,1);
            $pdf->SetFont('Arial','',12);
            $pdf->Multicell(190,10,utf8_decode($otrosFormateado),1);
            //$pdf->Output();
            $archivoPdf = $pdf->Output('','S'); 
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
        }
        }