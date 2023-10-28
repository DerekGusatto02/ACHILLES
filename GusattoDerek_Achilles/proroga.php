
<?php
session_start();
if(isset($_GET['idPrestito'])){
    $idPrestito = $_GET['idPrestito'];
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

$sql = "UPDATE prestito SET dataFine = ADDDATE(dataFine, INTERVAL 30 DAY), prorogato = 1 WHERE idPrestito='".$idPrestito."' AND prorogato = 0";
echo "sql: ".$sql;
$result = $con->query($sql);
    if ($result) {
        if($con->affected_rows > 0){
            $_SESSION['proroga'] = true;
        }else{
            $_SESSION['proroga'] = false;
        }
    }else{
        $_SESSION['proroga'] = false;
    }

  header("Location: prestiti.php");
?>

