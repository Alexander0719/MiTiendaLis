<?php session_start();
error_reporting(E_ERROR | E_PARSE); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Ropa</title>
  <link rel="stylesheet" href="css/css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
  <?php
  //carrito 
  $carrito_mio = $_SESSION['carrito'];
  $_SESSION['carrito'] = $carrito_mio;

  if (isset($_SESSION['carrito'])) {
    for ($i = 0; $i <= count($carrito_mio) - 1; $i++) {
      if ($carrito_mio[$i] != NULL) {
        $total_cantidad = $carrito_mio['cantidad'];
        $total_cantidad++;
        $totalcantidad += $total_cantidad;
      }
    }
  }
  ?>
  <!--NavBar-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Tienda de Ropa</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modal_cart" style="color: black;"><i class="fas fa-shopping-cart"></i><?php echo $totalcantidad; ?></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<!--Modal-->
  <div class="modal fade" id="modal_cart" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Carrito de Cotización</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div>
          <h6>Productos Seleccionados</h6>
            <div class="p-2">
              <ul class="list-group mb-3">
                <!--Carrito-->
                <?php
                if (isset($_SESSION['carrito'])) {
                  $total = 0;
                  for ($i = 0; $i <= count($carrito_mio) - 1; $i++) {
                   if ($carrito_mio[$i] != NULL) {
                ?>
            <!--Información carrito en modal-->
            <li class="list-group-item justify-content-between px-4">
                <div class="row">
                    <div class="col-10 p-0" style="text-align: left; color: #000000;">
                        <h6 class="my-0"><?php echo $carrito_mio[$i]['titulo']; ?></h6>
                        <span class="text-muted"></span>
                    </div>
                    <div class="col-2">
                        <form action="actualizar.php" method="post">
                            <input type="hidden" name="indice" value="<?php echo $i; ?>">
                            <div class="input-group input-group-sm">
                                <input type="number" name="cantidad" class="form-control" min="0" style="width:20px" value="<?php echo $carrito_mio[$i]['cantidad']; ?>">
                                <div class="input-group-append">
                                  <button type="submit" class="btn btn-light">Actualizar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </li>
            <?php
            $total += $carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad'];
        }
    }
}
                ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a type="button" class="btn btn-secondary" href="borrar.php">Vaciar carrito</a>
          <a type="button" class="btn btn-secondary" href="cotizar.php">Enviar Cotización</a>
          
        </div>
      </div>
    </div>
  </div>

  <?php
  //llamando archivo xml
  $productos = simplexml_load_file('productos.xml');
  foreach ($productos->producto as $pro) {

  ?>
  <!--Formulario-->
    <form id="formulario" name="formulario" method="post" action="cart.php">
       <div class="lista">
        <div class="producto">
          <img src=<?php echo $pro->imagen; ?> class="product-image">
          <!--Muestro la información en el principal-->
          <div class="nombre-producto" name="titulo" id="titulo">
            <?php echo $pro->nombre; ?>
          </div>
          <div class="descripcion-producto" name="descripcion" id="descripcion">
            <?php echo $pro->descripcion; ?>   
          </div>
          <!--mandar información al carrito-->
          <input class="product-description" name="precio" type="hidden" id="precio" value="<?php echo $pro->precio; ?>" />
          <input class="product-price"  name="titulo" type="hidden" id="titulo" value="<?php echo $pro->nombre; ?>" />         
          <br>
          <div class="canti">
          <input name="cantidad" type="number" id="cantidad" min="1" value="1" style="width:50px" />
          <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fas fa-shopping-cart"></i></button>
           </div>
        </div>
    </form>
  <?php
  }
  ?>
</body>
</html>