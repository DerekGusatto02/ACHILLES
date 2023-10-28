
<?php
session_start();
if(isset($_POST['libro'])){
    $idLibro = $_POST['libro'];
}
if(isset($_POST['utente'])){
    $idUtente = $_POST['utente'];
}
if(isset($_POST['giorni'])){
    $giorni = $_POST['giorni'];
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

$errore = false;
$con->autocommit(false);
$con->begin_transaction();
$response;

$sql = "SELECT idLibro FROM libro WHERE idLibro = '".$idLibro."'";
$sql .= " AND idLibro NOT IN (SELECT fkLibro FROM prestito WHERE rientrato='0')";
//echo "sql: ".$sql;
$result = $con->query($sql);
	if ($result) {
        if($result->num_rows > 0){
        }else{
            $errore=true;
            $response="Libro già in prestito";
        }
    }else{
        $errore=true;
        $response="Fallimento inserimento del prestito";
    }

$sql = "SELECT COUNT(idPrestito) AS tot FROM prestito WHERE fkUtente = '".$idUtente."' AND rientrato = '0' GROUP BY fkUtente";    
//echo "sql: ".$sql;
$result = $con->query($sql);
    if ($result) {
        if($result->num_rows > 0){
            while($row=$result->fetch_array()){
                $tot = $row['tot']*1;
                if($tot>=5){
                    $errore=true;
                    $response="L'utente ha troppi prestiti in corso";
                }
            }
        }else{
         
        }
    }else{
         $errore=true;
    }


$sql = "INSERT INTO `prestito` (`dataInizio`, `dataFine`, `fkLibro`, `fkUtente`)";
$sql .= " VALUES (current_timestamp(), ADDDATE(current_timestamp(), INTERVAL ".$giorni." DAY), '".$idLibro."', '".$idUtente."');";
//echo "sql: ".$sql;
$result = $con->query($sql);
    if ($result) {
        if($con->affected_rows > 0){
            $last_id = $con->insert_id;
        }else{
         $errore=true;
         $response="Fallimento inserimento del prestito";
        }
    }else{
         $errore=true;
    }
if($errore==true){
    $con->rollback();
    echo "Errore: ".$response;
}else{
    $con->commit();
    header('Location: creapdf.php?idPrestito='.$last_id);
}
?>