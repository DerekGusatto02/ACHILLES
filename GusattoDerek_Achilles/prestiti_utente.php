<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>ACHILLES</title>
<link rel="icon" href="images/icons/icona.png" />
<script>
    function intestazione(){
        var request;
        request = new XMLHttpRequest;

        request.onreadystatechange = risposta; 
        request.open("post", "caricamentointestazione.php"); 
        request.send(); 
  
        function risposta() {
            if (request.readyState == 4 && request.status == 200) {
                document.getElementById("intestazione").innerHTML = request.responseText;	
            }
        }
    }
</script>

</head>
<body onload="intestazione()">
<center>
<div class="header">
<a href="achilles.php" ><img src="images/logo.png" height="70px"/></a>
<div id="intestazione"></div>
</div>
<div class="container">
    <form  name="cerca" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-top: 15px;">
    <input size="50" type="text" name="cerca" placeholder="cerca per titolo, autore o ISBN" style="vertical-align: middle" />
    <input type="image" src="images/icons/search.png" alt="Submit" width="30" height="30" style="border-width: 0; vertical-align: middle" ></br>
    <input type="radio" name="scaduti">Prestiti scaduti</input>
    <input type="radio" name="rientrati">Prestiti rientrati</input>
    </form>

    <input type="button" onclick="location.href = 'nuovoprestito.php'" value="nuovo prestito">
</div>

<?php

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

if(isset($_GET['cerca'])){
	$cerca = $_GET['cerca'];
}else{
	$cerca = '';
}
if(isset($_GET['scaduti'])){
	$scaduti = true;
}else{
	$scaduti = false;
}
if(isset($_GET['rientrati'])){
	$rientrati = true;
}else{
	$rientrati = false;
}

$sql = "SELECT prestito.*, utente.nome, utente.cognome, libro.titolo, libro.ISBN, collocazione.*, autore.nome AS anome, autore.cognome AS acognome";
$sql .= " FROM libro";
$sql .= " INNER JOIN scrivere ON libro.idLibro=scrivere.fkLibro";
$sql .= " INNER JOIN autore ON autore.idAutore=scrivere.fkAutore";
$sql .= " INNER JOIN collocazione ON libro.fkCollocazione=collocazione.codice";
$sql .= " INNER JOIN prestito ON libro.idLibro=prestito.fkLibro";
$sql .= " INNER JOIN utente ON utente.idUtente=prestito.fkUtente";
$sql .= " WHERE utente.idUtente = ".$_SESSION['idUtente'];
$sql .= " AND idLibro IN (SELECT idLibro FROM libro";
$sql .= " WHERE titolo LIKE '%".$cerca."%'";
$sql .= " OR autore.nome LIKE '%".$cerca."%'";
$sql .= " OR autore.cognome LIKE '%".$cerca."%'";
$sql .= " OR ISBN LIKE '%".$cerca."%' )";
if(isset($_SESSION['idBiblioteca'])){
    $sql .= " AND idLibro IN (SELECT idLibro FROM libro INNER JOIN biblioteca ON idBiblioteca=fkBiblioteca WHERE idBiblioteca = '".$_SESSION['idBiblioteca']."')";
}
if($scaduti==true){
    $sql .= " AND prestito.dataFine < current_timestamp()";
}else if($rientrati==true){
    $sql .= " AND prestito.rientrato = 1";
}else{
    $sql .= " AND prestito.rientrato = 0";
}

$result = $con->query($sql);
	if ($result) {
        if ($result->num_rows > 0) {
            echo "<table>";
            while($row=$result->fetch_array()){
                
                echo "<tr >";
                echo "<td style='outline: thin solid; background-color: lightblue;'><b>Prestito:</b> ".$row['idPrestito']."</td>";
                echo "<td><b>Utente:</b> ".$row['cognome']." ".$row['nome']."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><b>Inizio:</b> ".$row['dataInizio']."</td>";
                echo "<td><b>Fine:</b> ".$row['dataFine']."</td>";
                
                echo "</tr>";
                echo "<tr>";
                echo "<td><b>Libro:</b> ".$row['titolo']."</td>";
                echo "<td><b>Autore:</b> ".$row['acognome']." ".$row['anome']."</td>";
                
                echo "</tr>";
              
            }
            echo "</table>";
			
        } else {
            
        }
    } else { 
		echo "errore: ".$con->error;
    }

?>

</center>
</body>
</html>
