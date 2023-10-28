<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>ACHILLES</title>

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

<link rel="icon" href="images/icons/icona.png" />
</head>
<body onload="intestazione()">
<center>
<div class="header">
<a href="achilles.php" ><img src="images/logo.png" height="70px"/></a>
<div id="intestazione"></div>
</div>
</div>

</center>
</body>
</html>
