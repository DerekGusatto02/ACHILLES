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
<button type="button" class="btn btn-outline-secondary btn-sm"  onclick="location.href = 'nuovoutente.php'"  style="margin: 5pt">Nuovo utente</button>
<table class="table table-striped table-bordered" style="width:70%">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">username</th>
      <th scope="col">nome</th>
      <th scope="col">cognome</th>
      <th scope="col">telefono</th>
      <th scope="col">data di nascita</th>
    </tr>
  </thead>
  <tbody>
    
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
    $sql = " SELECT * FROM utente";
    if(isset($_SESSION['idBiblioteca'])){
        $sql .= " WHERE fkBiblioteca  = '".$_SESSION['idBiblioteca']."'";
    }
    
    $result = $con->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                while($row=$result->fetch_array()){
                    echo "<tr>";
                    echo '<th scope="row">'.$row['idUtente'].'</th>';
                    echo '<td>'.$row['username'].'</td>';
                    echo '<td>'.$row['nome'].'</td>';
                    echo '<td>'.$row['cognome'].'</td>';
                    echo '<td>'.$row['telefono'].'</td>';
                    echo '<td>'.$row['dataNascita'].'</td>';
                    echo '<td>';
                    echo "<a href='modifica_utente.php?idUtente=".$row['idUtente']."'><img src='images/icons/edit.png' height='40'></a>";
                    echo "<a href='eliminautente.php?idUtente=".$row['idUtente']."'><img src='images/icons/delete.png' height='40'></a>";
                    echo '</td>';
                    echo "</tr>";	
                }
                		
            } else {
            }
        } else { 
            echo "errore: ".$con->error;
        }
    
    ?>
  </tbody>
</table>


</center>
</body>