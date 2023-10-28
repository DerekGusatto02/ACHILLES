<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>ACHILLES</title>
<!-- FOGLI DI STILE -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="stylesheet.css">
<!-- cambio icona scheda -->
<link rel="icon" href="images/icons/icona.png" />
<script> //Funzione javascript che richiama la pagina php che crea la giusta intestazione della pagina con tecnologia ajax
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

<div class="container"> <!--FORM PER LA RICERCA NEL CATALOGO-->
    <form  name="cerca" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-top: 15px;">
    <input size="50" type="text" name="cerca" placeholder="cerca per titolo, autore o ISBN" style="vertical-align: middle" /> 
    <input type="image" src="images/icons/search.png" alt="Submit" width="30" height="30" style="border-width: 0; vertical-align: middle" >
    </form>
</div>

<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'achilles');

//Connessione al database
$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($con->connect_errno) {
    printf("Connect failed: %s\n", $con->connect_error);
    exit();
}
$con->set_charset("utf8");

//verifica se sono presenti canoni di ricerca
if(isset($_GET['cerca'])){
	$cerca = $_GET['cerca'];
}else{
	$cerca = '';
}


//Seleziona i libri che corrispondo ai criteri di ricerca (se presenti) e che sono presnti nella biblioteca presso cui è registrato l'utente (se questo haneffettuato il login)
$sql = "SELECT libro.*, autore.nome, autore.cognome, collocazione.*, genere.descrizione";
$sql .= " FROM libro";
$sql .= " INNER JOIN scrivere ON libro.idLibro=scrivere.fkLibro";
$sql .= " INNER JOIN autore ON autore.idAutore=scrivere.fkAutore";
$sql .= " INNER JOIN collocazione ON libro.fkCollocazione=collocazione.codice";
$sql .= " INNER JOIN comprendere ON libro.idLibro=comprendere.fkLibro";
$sql .= " INNER JOIN genere ON genere.idGenere=comprendere.fkGenere";
$sql .= " WHERE idLibro IN (SELECT idLibro FROM libro";
$sql .= " WHERE titolo LIKE '%".$cerca."%'";
$sql .= " OR autore.nome LIKE '%".$cerca."%'";
$sql .= " OR autore.cognome LIKE '%".$cerca."%'";
$sql .= " OR ISBN LIKE '%".$cerca."%' )";
if(isset($_SESSION['idBiblioteca'])){
    $sql .= " AND idLibro IN (SELECT idLibro FROM libro INNER JOIN biblioteca ON idBiblioteca=fkBiblioteca WHERE idBiblioteca = '".$_SESSION['idBiblioteca']."')";
}

$result = $con->query($sql);
//se la query ha avuto successo, stampa i risultati
	if ($result) {
        if ($result->num_rows > 0) {
            echo "<table>";
            while($row=$result->fetch_array()){
                echo "<tr >";
                echo "<td rowspan='5' ><img src='".$row['immagine']."' height='150'></td>";
                echo "<td colspan='3'><b>Titolo:</b> ".$row['titolo']."</td>";
                //se l'utente è un bibliotecario, mostra la possibilità di modifica, eliminare o dare in prestito il libro
                if(isset($_SESSION['ruolo']) AND $_SESSION['ruolo']=='bibliotecario'){
                    echo "<td rowspan='5'>";
                        echo "<table>";
                        echo "<tr><td><a href='modifica.php?idLibro=".$row['idLibro']."'><img src='images/icons/edit.png' height='40'></a></td></tr>"; //Modifica del libro
                        echo "<tr><td><a href='elimina.php?idLibro=".$row['idLibro']."'><img src='images/icons/delete.png' height='40'></a></td></tr>"; //elimina il libro
                        echo "<tr><td><a href='nuovoprestito.php?idLibro=".$row['idLibro']."'><img src='images/icons/prestito.png' height='40'></a></td></tr>"; //Prestito del libro
                        echo "</table>";
                    echo "</td>";
                }
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='3' ><b>Autore:</b> ".$row['cognome']." ".$row['nome']."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td ><b>ISBN:</b> ".$row['ISBN']."</td>";
                echo "<td ><b>Genere:</b> ".$row['descrizione']."</td>";
                echo "<td ><b>Lingua:</b> ".$row['lingua']."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td ><b>Anno:</b> ".$row['anno']."</td>";
                echo "<td ><b>Prezzo:</b> €".$row['prezzo']."</td>";
                echo "<td ><b>Pagine:</b> ".$row['numPagine']."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='3' ><b>Collocazione:</b> ".$row['codice']."-".$row['sezione']."</td>";
                echo "</tr>";
                echo "<tr  style='border-bottom: 3px solid black;'><td colspan='5'></td></tr>";
              
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
