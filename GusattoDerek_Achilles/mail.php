<?php
session_start();
if(isset($_GET['utente'])){
    $utente=$_GET['utente'];
}else{
    $utente='';
}

if(isset($_GET['allegato'])){
    $allegato=$_GET['allegato'];
}else{
    $allegato='';
}

//Importa le classi PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/Exception.php';
//Crea una nuova istanza
$mail = new PHPMailer();
//Usa protocollo SMTP
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_OFF;
//utilizza GMAIL
$mail->Host = 'smtp.gmail.com';
//Set del numero di porta
$mail->Port = 587;
//Set della crittografia
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// e dell'autenticazione
$mail->SMTPAuth = true;
//casella di posta da cui invio la mail
$mail->Username = 'maildaluca@gmail.com'; 
//Password 
$mail->Password = 'lucamail.00';
//Indirizzo da cui deve arrivare dal mail e nome
$mail->setFrom('noreply@achilles.com', 'Achilles');
//Indirizzo di risposta alla mail e nome
$mail->addReplyTo('noreply@achilles.com', 'Achilles');
//prelevo dal database l'email dell'utente
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'achilles');
$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($con->connect_errno) {
    printf("Connect failed: %s\n", $con->connect_error);
    exit();
}
$con->set_charset("utf8");
$m = '';
$sql = "SELECT email  FROM utente WHERE idUtente ='".$utente."'";
echo "sql: ".$sql;
$result = $con->query($sql);
if ($result) {
    if ($result->num_rows > 0) {
        $row=$result->fetch_array();
            $m=$row['email'];
    }
}
//Set email destinatario
$mail->addAddress($m, 'Utente'.$utente);
//Set oggetto della mail
$mail->Subject = 'Nuovo prestito ';
//Set corpo del messaggio
$mail->msgHTML("Nuovo prestito all'utente");
//Allegato pdf
$path = $_SERVER['DOCUMENT_ROOT'].'/GusattoDerek_Achilles/pdfprestiti/'.$allegato.'.pdf';
$mail->addAttachment($path, $name = 'prestito',  $encoding = 'base64', $type = 'application/pdf');
//Invio
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    header('Location: achilles.php');
}

