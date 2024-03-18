<?php
require_once 'vendor/autoload.php'; // Incluir el archivo de carga de Swift Mailer

// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuración del servidor SMTP de Zoho Mail
    $smtpHost = 'smtp.zoho.com';
    $smtpUsername = 'jairocalderon680@miformulario.xyz'; // Dirección de correo electrónico del administrador
    $smtpPassword = 'Oriaj2505@'; // Reemplaza con la contraseña de tu cuenta de correo electrónico
    $smtpPort = 587; // Puerto SMTP seguro para Zoho Mail

    // Recopilar los datos del formulario
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['asunto'];
    $message = $_POST['msg'];

    // Crear el objeto de transporte SMTP
    $transport = (new Swift_SmtpTransport($smtpHost, $smtpPort, 'tls'))
        ->setUsername($smtpUsername)
        ->setPassword($smtpPassword);

    // Crear el objeto Mailer
    $mailer = new Swift_Mailer($transport);

    // Crear el mensaje
    $swiftMessage = (new Swift_Message($subject))
        ->setFrom([$smtpUsername => $name]) // Utiliza el nombre proporcionado en el formulario como remitente
        ->setTo([$smtpUsername]) // Enviar una copia del correo al correo corporativo
        ->setBody($message);

    // Agregar una copia del correo al remitente
    $swiftMessage->setCc([$email => $name]); // Agrega la dirección de correo electrónico del remitente como CC

    // Enviar el mensaje
    $result = $mailer->send($swiftMessage);

    // Verificar si el correo se envió correctamente
    if ($result) {
        echo 'El correo se envió correctamente.';
    } else {
        echo 'Hubo un error al enviar el correo.';
    }
} else {
    // Si no se han enviado datos del formulario, redireccionar al formulario
    header("Location: index.html");
    exit();
}
?>
