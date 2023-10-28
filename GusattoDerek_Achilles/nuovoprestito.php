<?php
session_start();
if(isset($_GET['idLibro'])){
    $idLibro = $_GET['idLibro'];
}
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
<body onload="intestazione();">
<center>
<div class="header">
<a href="achilles.php" ><img src="images/logo.png" height="70px"/></a>
<div id="intestazione"></div>
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
?>
<div>
    <form id="prestito" method="post" action="insertprestito.php" style="margin-top: 10px; padding-top: 5px; padding-bottom: 5px;">
    <label for="utente">Utente</label>
    <input type="text" id="utente" name="utente" list="utenti" ></br>
    <datalist id="utenti"> 
    <?php //creo una datalist con gli utenti della biblioteca
        $sql = "SELECT nome, cognome, idUtente FROM utente WHERE fkBiblioteca=".$_SESSION['idBiblioteca']."";
        echo $sql;
        $result = $con->query($sql);
        if($result){
            if($result->num_rows > 0){
                while($row=$result->fetch_array()){
                   echo "<option value=".$row['idUtente'].">".$row['cognome']." ".$row['nome']."</option>";
                }
            }
        }
    ?>
    </datalist>
    <?php
    if(!isset($_GET['idLibro'])){
    ?>
     <label for="libro">Libro</label>
    <input type="text" id="libro" name="libro" list="libri" ></br>
    <datalist id="libri">
    <?php  //creo una datalist con i libri disponibili 
    $sql = "SELECT titolo, idLibro FROM libro WHERE fkBiblioteca=".$_SESSION['idBiblioteca']." AND idLibro NOT IN (SELECT fkLibro FROM prestito WHERE rientrato='0')";
    echo $sql;
    $result = $con->query($sql);
    if($result){
        if($result->num_rows > 0){
            while($row=$result->fetch_array()){
               echo "<option value=".$row['idLibro'].">".$row['titolo']."</option>";
            }
        }
    }
    }else{ //Se ho già selezionato il libro per il prestito in achilles.php
    ?>
        <input type="hidden" id="libro" name="libro" list="libri" value=<?php echo $idLibro ?>>
    <?php
    }
    ?>
    </datalist>
    <label for="giorni">Giorni di prestito</label>
    <input type="number" name="giorni" step="5" min="15" max="40" value="30"></br>
    
    <button type="submit" class="btn btn-dark">Inserisci</button>
    
    </form>
</div>
    <?php
        $con->close();
    ?>
</center>
</body>
</html>