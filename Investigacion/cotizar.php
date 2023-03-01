<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar cotización</title>
    <link rel="stylesheet" href="cotizar.css">
    <link rel="stylesheet" href="css/css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
   
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Tienda de Ropa</a>
   
    </div>
  </nav>
<body>
    <div class="col-auto  p-5 text-center">
    <form action="" method="post"  enctype="multipart/form-data">
        <label for="email">Correo</label>
        <input type="text" name="email" id="email" placeholder="Ingrese su correo">

        
        <button type="submit" name = "EnviarC"> Enviar cotización</button>
    </form>
    </div>
    <?php
//variables de sesión
session_start();

//para poder usar la libreria dompdf
require_once './vendor/autoload.php';
use Dompdf\Dompdf;

//traemos la info del vector creado para almacenar el carrito
if (isset($_SESSION['carrito'])) {
    $carrito_mio = $_SESSION['carrito'];
    $dompdf = new Dompdf();
    $datos = $carrito_mio;
    $html = '<html>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12pt;
                color: #333;
                text-align: center;
                background-color: beige;
            }
            h1 {
                font-size: 16pt;
                font-weight: bold;
                margin-bottom: 20px;
            }
            table {
                border-collapse: collapse;
                margin-bottom: 20px;
                width: 100%;
                padding: 20px;
                table-layout: fixed;
            }
            th, td {
                border: 1px solid #ccc;
                padding: 8px;
            }
            th {
                background-color: #eee;
                font-weight: bold;
            }
        </style>
        <body>
            <h1>Cotización</h1><br>
            <h3>Datos del Producto</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';

    $total = 0; // inicializamos la variable total

    foreach ($datos as $dato) {
        $subtotal = $dato['cantidad'] * $dato['precio']; // calculamos el subtotal de cada producto
        $total += $subtotal; // sumamos el subtotal al total

        $html .= '<tr>
            <td>' . $dato['titulo'] . '</td>
            <td>$' . $dato['precio'] . '</td>
            <td>' . $dato['cantidad'] . '</td>
            <td>$' . $subtotal . '</td>
        </tr>';
    }

    $html .= '<tr>
        <td colspan="3" align="right"><strong>Total:</strong></td>
        <td>$' . $total . '</td>
    </tr>';

    $html .= '</tbody></table></body></html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'vertical');
    $dompdf->render();

    $guardar = $dompdf->output();
    $filename = 'Cotización.pdf';
    $filepath = 'C:\xampp\htdocs\ejercicios\Investigacion1\Investigacion\pdf' .'\pdf'. $filename;
    file_put_contents($filepath, $guardar);
    //$dompdf->stream('Cotización.pdf', array('Attachment' => false));
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$email =  "";
if(isset($_POST['EnviarC'])){
if(isset( $_REQUEST['email']) && filter_var( $_REQUEST['email'],  FILTER_VALIDATE_EMAIL)){

$email = $_REQUEST['email'];




require 'C:\xampp\htdocs\ejercicios\Investigacion1\Investigacion\PHPMailer\Exception.php';
require 'C:\xampp\htdocs\ejercicios\Investigacion1\Investigacion\PHPMailer\PHPMailer.php';
require 'C:\xampp\htdocs\ejercicios\Investigacion1\Investigacion\PHPMailer\SMTP.php';

$mail = new PHPMailer(true);

try {
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tarealis123@gmail.com';
    $mail->Password = 'uovuaigadhfufhop';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('tarealis123@gmail.com', 'TareaLis');
    $mail->addAddress($email);
    

    $mail->addAttachment('../Investigacion/pdf/pdfCotización.pdf');

    $mail->isHTML(true);
    $mail->Subject = 'Cotizacion';
    $mail->Body = 'Saludos, por este medio le envio su cotización, feliz día!';
    $mail->send();

    echo"<p style='color:green; text-align: center; margin-top: 25px;'>
    Cotización enviada con éxito, revisar su correo.</center></p>";
} catch (Exception $e) {
    echo 'Mensaje ' . $mail->ErrorInfo;
}


}
else{
    echo"<p style='color:red; text-align: center; margin-top: 25px;'>
    Ingrese una dirección de correo válida </center></p>";
}}
?>

</body>
</html>
