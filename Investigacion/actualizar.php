<?php
session_start();

if (isset($_SESSION['carrito'])) {
    $carrito_mio = $_SESSION['carrito'];

    if (isset($_POST['indice']) && isset($_POST['cantidad'])) {
        $indice = $_POST['indice'];
        $cantidad = $_POST['cantidad'];

        if ($cantidad <= 0) {
            unset($carrito_mio[$indice]); // remove the item from the cart if the quantity is zero or less
        } else {
            $carrito_mio[$indice]['cantidad'] = $cantidad; // update the quantity of the item
        }

        $_SESSION['carrito'] = $carrito_mio; // update the cart session variable
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']); // redirect back to the previous page
?>
