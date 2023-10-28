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
<link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChTsh9mTgKrBBzRAdmRVFLBTDWG__5aWk&sensor=false">
</script>
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


<script>
function creaMappa(){
    var coordinate = new google.maps.LatLng(45.8519, 11.87354);
    var opzioni = {
        zoom : 20, 
        center: coordinate,
        mapTypeId: google.maps.MapTypeId.HYBRID,
    }
    
    var mappa = new google.maps.Map(document.getElementById('mappa'), opzioni);
}
</script>

</head>
<body onload="intestazione(); creaMappa();">
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

$sql = "SELECT biblioteca.*, comune.*";
$sql .= " FROM biblioteca INNER JOIN comune on idComune=fkComune";
$sql .= " WHERE biblioteca.idBiblioteca = '".$_SESSION['idBiblioteca']."'";
//echo "sql: ".$sql;
$result = $con->query($sql);
	if ($result) {
        if ($result->num_rows > 0) {
            while($row=$result->fetch_array()){
            echo "<h1>".$row['denominazione']."</h1>";
            echo "<h3>".$row['via']." ".$row['numCivico']." ".$row['comune']." ".$row['cap']." ".$row['provincia']."</h3>";
            }
        }
    }
?>

<div id="mappa" >
</div>
</center>

</body>
</html>
