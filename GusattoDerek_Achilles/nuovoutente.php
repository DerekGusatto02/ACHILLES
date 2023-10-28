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

<h1> NUOVO UTENTE</h1>
<div class="container" style="margin-top: 10px;">
  <div class="row">
    <div class="col-7">
    <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="username">
    </div>
 </div>
<div class="row">
    <div class="col">
    <input type="text" class="form-control" placeholder="Nome" aria-label="Nome" id="nome">
    </div>
    <div class="col">
    <input type="text" class="form-control" placeholder="Cognome" aria-label="Cognome" id="cognome">
    </div>
  </div>
  <div class="row">
    <div class="col-7">
    <input type="text" class="form-control" placeholder="email" aria-label="email" id="email">
    </div>
    <div class="col-5">
    <input type="text" class="form-control" placeholder="telefono" aria-label="telefono" id="telefono">
    </div>
  </div>
  <div class="row">
  data di nascita:
    <div class="col-5">
     <input type="date" class="form-control" id="data">
    </div>
 </div>
 Indirizzo:
 <div class="row">
    <div class="col-4">
    <input type="text" class="form-control" placeholder="Via" aria-label="via" id="via">
    </div>
    <div class="col-2">
    <input type="text" class="form-control" placeholder="Numero" aria-label="numero" id="num">
    </div>
    <div class="col-4">
    <input type="text" class="form-control" placeholder="Comune" aria-label="comune" list="comuni" id="comune">
    <datalist id="comuni">
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
    $sql = "SELECT idComune, comune FROM comune";
    $result = $con->query($sql);
    if($result){
        if($result->num_rows > 0){
            while($row=$result->fetch_array()){
               echo "<option value=".$row['idComune'].">".$row['comune']."</option>";
            }
        }
    }
    ?>
    </datalist>
    </div>
    <div class="col-2">
    <input type="text" class="form-control" placeholder="CAP" aria-label="cap" id="cap">
    </div>
 </div>

</div>
<button type="button" class="btn btn-dark btn-lg" style="margin-top: 5px" onclick="goto()">Inserisci</button>


</center>

<script>
    function goto(){
        var s = "insertutente.php?";
        var app = document.getElementById("username").value;
        if(app != ''){
            s += "username="+app;
        }
        app = document.getElementById("nome").value;
        if(app != ''){
            s += "&nome="+app;
        }
        app = document.getElementById("cognome").value;
        if(app != ''){
            s += "&cognome="+app;
        }
        app = document.getElementById("data").value;
        if(app != ''){
            s += "&data="+app;
        }
        app = document.getElementById("email").value;
        if(app != ''){
            s += "&mail="+app;
        }
        app = document.getElementById("telefono").value;
        if(app != ''){
            s += "&telefono="+app;
        }
        app = document.getElementById("via").value;
        if(app != ''){
            s += "&via="+app;
        }
        app = document.getElementById("num").value;
        if(app != ''){
            s += "&num="+app;
        }
        app = document.getElementById("comune").value;
        if(app != ''){
            s += "&comune="+app;
        }
        app = document.getElementById("cap").value;
        if(app != ''){
            s += "&cap="+app;
        }

        location.href = s;
    }
</script>
</body>
</html>
