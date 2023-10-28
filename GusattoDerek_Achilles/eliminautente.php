<?php
if(!isset($_GET['idUtente'])){
    echo "Nessun utente selezionato";
}
$idUtente = $_GET['idUtente'];


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
    $sql = "DELETE FROM utente WHERE idUtente = ".$idUtente;
    echo $sql;
    $result = $con->query($sql);
    if ($result) {
        if($con->affected_rows > 0){
                
        }else{
                
        }
    }
    header('Location: utenti.php');