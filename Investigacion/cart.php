<?php 
session_start();

if (isset($_SESSION['carrito'])) {
    $carrito_mio = $_SESSION['carrito'];
} else {
    $carrito_mio = array();
}

if (isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    $precio = (float)$_POST['precio'];
    $cantidad = (int)$_POST['cantidad'];

    // Verificar si el producto ya está en el carrito
    $product_exists = false;
    foreach ($carrito_mio as &$item) {
        if ($item['titulo'] === $titulo) {
            $item['cantidad'] += $cantidad;
            $product_exists = true;
            break;
        }
    }

    // Si no está en el carrito, agregarlo
    if (!$product_exists) {
        $carrito_mio[] = array("titulo" => $titulo, "precio" => $precio, "cantidad" => $cantidad);
    }

    $_SESSION['carrito'] = $carrito_mio;
}

header("Location: " . $_SERVER['HTTP_REFERER'] . "");

