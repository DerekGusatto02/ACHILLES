<?php
session_start();
if(isset($_GET['username'])){
    $username=$_GET['username'];
}
if(isset($_GET['nome'])){
    $nome=$_GET['nome'];
}
if(isset($_GET['cognome'])){
    $cognome=$_GET['cognome'];
}
if(isset($_GET['telefono'])){
    $telefono=$_GET['telefono'];
}
if(isset($_GET['mail'])){
    $mail=$_GET['mail'];
}
if(isset($_GET['data'])){
    $data=$_GET['data'];
}
if(isset($_GET['num'])){
    $num=$_GET['num'];
}
if(isset($_GET['cap'])){
    $cap=$_GET['cap'];
}
if(isset($_GET['via'])){
    $via=$_GET['via'];
}
if(isset($_GET['comune'])){
    $comune=$_GET['comune'];
}

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
    $sql = "INSERT INTO utente (password, username, nome, cognome, telefono, email, dataNascita, numCivico, via, cap, fkComune, fkBiblioteca) VALUES ";
    $sql .= "('".$username."', '".$username."', '".$nome."', '".$cognome."', '".$telefono."', '".$mail."', '".$data."', '".$num."', '".$via."', '".$cap."', '".$comune."', '".$_SESSION['idBiblioteca']."')";
    echo $sql;
    $result = $con->query($sql);
        if ($result) {
            if($con->affected_rows > 0){
                header('Location: utenti.php');
            }else{
                header('Location: nuovoutente.php');
            }
        }

?>