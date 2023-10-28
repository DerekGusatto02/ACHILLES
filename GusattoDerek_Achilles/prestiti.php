<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>ACHILLES</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="stylesheet.css">
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
<?php 
    if(isset($_SESSION['proroga'])){ //Se la pagina viene caricata dopo un tentativo di proroga, stampa l'esito in un alert
        if($_SESSION['proroga']=true){
            echo '<script>';
            echo 'alert("Proroga effettuata")';
            echo '</script>';
        }else{
            echo '<script>';
            echo 'alert("Proroga NON effettuata")';
            echo '</script>';
        }
        unset($_SESSION['proroga']);
    }
    if(isset($_SESSION['rientro'])){//Se la pagina viene caricata dopo un tentativo di rientro, stampa l'esito in un alert
        if($_SESSION['rientro']=true){
            echo '<script>';
            echo 'alert("Rientro effettuato")';
            echo '</script>';
        }else{
            echo '<script>';
            echo 'alert("Rientro NON effettuato")';
            echo '</script>';
        }
        unset($_SESSION['rientro']);
    }
?>
<div class="container"> 
    <form  name="cerca" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-top: 15px;"> <!-- Form di ricerca, come quello di achilles.php-->
    <input size="50" type="text" name="cerca" placeholder="cerca per titolo, autore o ISBN" style="vertical-align: middle" />
    <input type="image" src="images/icons/search.png" alt="Submit" width="30" height="30" style="border-width: 0; vertical-align: middle" ></br>
    <input type="radio" name="scaduti">Prestiti scaduti</input>
    <input type="radio" name="rientrati">Prestiti rientrati</input>
    </form>
    <!-- Nuovo prestito -->
    <button type="button" class="btn btn-outline-secondary btn-sm"  onclick="location.href = 'nuovoprestito.php'"  style="margin: 5pt">Nuovo prestito</button>
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

//Verifica se sono presenti paramentri di ricarca
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

//Creazione della SELECT SQL
$sql = "SELECT prestito.*, utente.nome, utente.cognome, libro.titolo, libro.ISBN, collocazione.*, autore.nome AS anome, autore.cognome AS acognome";
$sql .= " FROM libro";
$sql .= " INNER JOIN scrivere ON libro.idLibro=scrivere.fkLibro";
$sql .= " INNER JOIN autore ON autore.idAutore=scrivere.fkAutore";
$sql .= " INNER JOIN collocazione ON libro.fkCollocazione=collocazione.codice";
$sql .= " INNER JOIN prestito ON libro.idLibro=prestito.fkLibro";
$sql .= " INNER JOIN utente ON utente.idUtente=prestito.fkUtente";
$sql .= " WHERE idLibro IN (SELECT idLibro FROM libro"; //Sub-query per la ricerca in titolo, autore o ISBN
$sql .= " WHERE titolo LIKE '%".$cerca."%'";
$sql .= " OR autore.nome LIKE '%".$cerca."%'";
$sql .= " OR autore.cognome LIKE '%".$cerca."%'";
$sql .= " OR ISBN LIKE '%".$cerca."%' )";
if(isset($_SESSION['idBiblioteca'])){   //sub-query per la ricerca all'interno della biblioteca presso qui l'utente è registrato
    $sql .= " AND idLibro IN (SELECT idLibro FROM libro INNER JOIN biblioteca ON idBiblioteca=fkBiblioteca WHERE idBiblioteca = '".$_SESSION['idBiblioteca']."')";
}
if($scaduti==true){ //Se si vogliono visualizzare solo prestiti scaduti
    $sql .= " AND prestito.dataFine < current_timestamp()"; 
}else if($rientrati==true){//Se si vogliono visualizzare solo prestiti rientrati
    $sql .= " AND prestito.rientrato = 1";
}else{ //altrimenti, di default, visualizza i prestiti in corso
    $sql .= " AND prestito.rientrato = 0";
}

$result = $con->query($sql);
	if ($result) {
        if ($result->num_rows > 0) {
            echo "<table>";
            while($row=$result->fetch_array()){
                echo "<tr >";
                echo "<td style='outline: thin solid; background-color: lightcoral;'><b>Prestito:</b> ".$row['idPrestito']."</td>";
                echo "</tr>";
                echo "<tr >";
                echo "<td><b>Utente:</b> ".$row['cognome']." ".$row['nome']."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><b>Inizio:</b> ".$row['dataInizio']."</td>";
                echo "<td><b>Fine:</b> ".$row['dataFine']."</td>";
                //bottone per la prooga del prestito
                echo "<td><a href='proroga.php?idPrestito=".$row['idPrestito']."'><img src='images/icons/proroga.png' height='40'></a></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><b>Libro:</b> ".$row['titolo']."</td>";
                echo "<td><b>Autore:</b> ".$row['acognome']." ".$row['anome']."</td>";
                //bottone per il rientro del prestito
                echo "<td><a href='rientro.php?idPrestito=".$row['idPrestito']."'><img src='images/icons/rientro.png' height='40'></a></td>"; 
                echo "</tr>";
            }
            echo "</table>";
        }
    } else { 
		echo "errore: ".$con->error;
    }
?>
</center>
</body>
</html>
