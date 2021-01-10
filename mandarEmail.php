<?php

require 'PHPMailer-master/PHPMailerAutoload.php';

//instancio un objeto de la clase PHPMailer
$mail = new PHPMailer(); // defaults to using php "mail()"

$mail->IsSMTP();
$mail->STMPDebug = 4;
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->STMPSecure = 'TLS';
$mail->SMTPAuth = true;
$mail->Username = 'emailpruebaphp@gmail.com';
$mail->Password = 'dakolas29';

$email = $_POST['email'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$consulta = $_POST['consulta'];

// Validar datos
if (empty($email) || empty($nombre) || empty($apellido) || empty($consulta)) {
	echo "El email, nombre, apellido y consulta son necesarios.";
	exit;
}

if (empty($telefono)) {
	$telefono = "No especificado.";
}

$email_body = "Has recibido un mensaje de:\n\n$nombre". " $apellido.\n". "Email: $email\n". "Telefono: $telefono\n". "\nTexto de la consulta:\n$consulta. ";

//defino el cuerpo del mensaje en una variable $body
//se trae el contenido de un archivo de texto
//también podríamos hacer $body="contenido...";
$body = $email_body;
//Esta línea la he tenido que comentar
//porque si la pongo me deja el $body vacío
// $body = preg_replace('/[]/i','',$body);

$nombreCompleto = $nombre . $apellido;

//defino el email y nombre del remitente del mensaje
$mail->SetFrom('$email', '$nombreCompleto');

//defino la dirección de email de "reply", a la que responder los mensajes
//Obs: es bueno dejar la misma dirección que el From, para no caer en spam
$mail->AddReplyTo("$email","$nombreCompleto");

//Defino la dirección de correo a la que se envía el mensaje
$address = "asegurog@alumnos.unex.es";

//la añado a la clase, indicando el nombre de la persona destinatario
$mail->AddAddress($address, "$nombreCompleto");

//Añado un asunto al mensaje
$mail->Subject = "Contacto del cliente via pagina web.";

//inserto el texto del mensaje en formato HTML
$mail->Body = $body;

//envío el mensaje, comprobando si se envió correctamente
if (!$mail->Send()) {
	echo "Error al enviar el mensaje: " . $mail->ErrorInfo;
} 
else {
	echo "Mensaje enviado correctamente.";
}

?>

