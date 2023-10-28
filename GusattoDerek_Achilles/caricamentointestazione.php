<?php
session_start();
echo "<table width='100%' style='background-color: lightcoral; vertical-align: middle;'><tr>";
//se l'utente ha fatto il login ed è un bibliotecario mostra la possibilità di visualizzare i prestiti, gli utenti, la biblioteca e fare il logout
if(isset($_SESSION['ruolo']) && $_SESSION['ruolo']=='bibliotecario'){
    echo "<td width='25%' style='text-align: center;'><a href='prestiti.php' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/prestito.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>Prestiti</span></a></td>";
    echo "<td width='25%' style='text-align: center'><a href='utenti.php' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/manageaccount.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>Utenti</span></a></td>";
    echo "<td width='25%' style='text-align: center'><a href='biblioteca.php' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/biblioteca.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>La tua biblioteca</span></a></td>";
    echo "<td width='25%' style='text-align: center'><a href='logout.php' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/logout.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>Logout</span></a></td>";
}//se l'utente ha fatto il login ed è un utente mostra la possibilità di visualizzare i suoi prestiti, modificare il proprio prpfilo,visualizzare la pagina della biblioteca e fare il logout
else if(isset($_SESSION['ruolo']) && $_SESSION['ruolo']=='user'){
    echo "<td width='25%' style='text-align: center'><a href='prestiti_utente.php?idUtente=".$_SESSION['idUtente']."' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/persona.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>Situazione utente</span></a></td>";
    echo "<td width='25%' style='text-align: center'><a href='modifica_utente.php?idUtente=".$_SESSION['idUtente']."' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/manageaccount.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>Modifica profilo</span></a></td>";
    echo "<td width='25%' style='text-align: center'><a href='biblioteca.php' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/biblioteca.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>La tua biblioteca</span></a></td>";
    echo "<td width='25%' style='text-align: center'><a href='logout.php' style='text-decoration: none; font-weight: bold;   font-family: Verdana, Geneva, Tahoma, sans-serif;color: black;'><img src='images/icons/logout.png' height='30' style='vertical-align: middle;'/><span vertical-align: middle;>Logout</span></a></td>";
}//se non è stato effettuato il login mostra la possibilità di fare il login o di registrarsi
else{
    echo "<td style='text-align: center'><a href='login.php'>Login</a></td>";
    
}
echo "</tr></table>";
?> 