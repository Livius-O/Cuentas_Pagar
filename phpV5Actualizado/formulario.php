<?php
    $con = mysqli_connect('localhost','root','','cuentas_pagar');
    try{
    $monto = $_POST['input_monto'];
    $modo_pago = $_POST['select1'];
    $id_producto = $_POST['input_id_producto'];
    #$id_factura = $_POST['input_id_factura'];
    #$dias = $_POST['input_dias'];
    $fecha_pago = $_POST['input_pago'];
    $fecha_recibo = $_POST['input_recibo'];
    $estado = "";
    if ($fecha_pago >= $fecha_recibo) {
        $estado = "Vigente";
    }
    else{
        $estado = "Atrazado";
    }

    $intro = "INSERT INTO pedido_proveedor(id_producto,monto,modo_pago,fecha_pago,fecha_recibo,estado)
    VALUES ($id_producto,$monto,'$modo_pago','$fecha_pago','$fecha_recibo','$estado')";
        echo $intro;
    $enviar = mysqli_query($con,$intro);

    if(!$con){
      die("Connection failed: " . mysqli_connect_errno());
    }
    elseif($enviar){
    header("Location: Cuentas_pagar2V3.php");
    echo "Producto registrado";
  }

    }catch(Exception $e){
        echo 'Message' . $e->getMessage();
    }
?>