<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <link rel="stylesheet" href="../css/bootstrap.css" />
  <title>Cuentas por pagar</title>

</head>

<body>
  <?php include_once 'header.php'; ?>

  <div class="container-fluid">
    <div class="row aling-items-end">

      <div class="col-4 order-1">
        <label class="lista_pago">Listado de pago</label>
      </div>

      <div class="col-5 orden-5">
        <a class="btn btn-outline-primary" href="AgregarV3.php" role="button">Agregar Factura</a>
      </div>

    </div>
  </div>
<?php 
$connection = mysqli_connect('localhost','root','','cuentas_principal');

if($connection){
    
    $query = "SELECT * FROM pedido_proveedor";
    $result = mysqli_query($connection,$query);    
     $number_per_pages= mysqli_num_rows($result);
    $page_count = 10;

     $page_result= ceil($number_per_pages/$page_count);

     if(!isset($_GET['page'])){
         $page =1;
     }else{
         $page =$_GET['page'];
     }

     $first_result = ($page -1) * $page_count;

     
    $bring_query ='SELECT * FROM pedido_proveedor LIMIT ' . $first_result . ',' .  $page_count;

    $bring_query_result= mysqli_query($connection,$bring_query);

    }
?>
  <table class="table table-striped ml-4">
    <thead>
      <tr>
        <th scope="col">Id Pedido</th>
        <th scope="col">Id Producto</th>
        <th scope="col">Id Suplidor</th>
        <th scope="col">Fecha Recibo</th>
        <th scope="col">Fecha de pago</th>
        <th scope="col">Monto</th>
        <th scope="col">Modo de pago</th>
        <th scope="col">Estado</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($fila = mysqli_fetch_array($bring_query_result)) { ?>
        <tr>
          <th scope="row"><?php echo $fila['id_pedido'] ?></th>
          <td><?php echo $fila[1] ?></td>
          <td><?php echo $fila[2] ?></td>
          <td><?php echo $fila[3] ?></td>
          <td><?php echo $fila[4] ?></td>
          <td><?php echo $fila[5] ?></td>
          <td><?php echo $fila[6] ?></td>

          <td><?php if($fila['estado']=='Pagado'){echo '<label class="bg-success text-white rounded">Pagado</label>';}
          if($fila['estado']=='Atrazado'){echo '<label class="bg-danger text-white rounded">Atrasado</label>';}
          if($fila['estado']=='Vigente'){echo '<label class="bg-warning text-white rounded">Vigente</label>';} ?></td>
          <td>

            <a href="#" onclick="pagame(<?php echo $fila['id_pedido'];?>)" role="button" class="btn btn-success">
            <i class="fas fa-money-bill-alt"></i>
            </a>
            <a href="modificar.php?id_pedido=<?php echo $fila[0]; ?>" class="btn btn-primary">
              <i class="far fa-edit"></i>
            </a>

            <a onclick="deleteme(<?php echo $fila['id_pedido'];?>)" role="button" name="delete" value="delete" class="btn btn-danger">
              <i class="fas fa-trash-restore"></i>
            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
        <div class="container">
          <div class="row">
            <div class="col d-flex justify-content-center">
              <?php
              for ($page=1;$page<=$page_result;$page++) {
              echo '<a href="Cuentas_pagar2V3.php?page=' . $page . '">' . $page . '</a> ';
              }
              ?>
            </div>
          </div>
        </div>
  <!--<i class="fas fa-user-edit"></i>-->

  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

	<script language="javascript">
  function deleteme(delid){
    if (confirm("¿Seguro de que desea eliminar la factura?")) {
    window.location.href = 'eliminar.php?del_id=' + delid+'';
    return true;
  }
  }
  function pagame(p){
    if (confirm("¿Seguro de que desea pagar la factura?")) {
    window.location.href = 'pagar.php?del_id=' + p + '';
    return true;
  }
  }
  
</script>
      </body> 
</html>