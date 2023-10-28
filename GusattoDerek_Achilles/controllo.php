<?php
	session_start();
	$username=$_POST['username'];
	$password=$_POST['password'];

	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'achilles');

	$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if($con->errno){
		printf("Connection failed: %\n", $con->connection_error);
		exit();
	}

	$con->set_charset("utf8");
	
	$username=htmlspecialchars($username); 
	$username=$con->real_escape_string($username);

	$password=htmlspecialchars($password);
	$password=$con->real_escape_string($password);	
	$password=sha1($password);

	$sql="SELECT username, password, ruolo, idUtente, fkBiblioteca ";
	$sql .= "FROM utente ";
	$sql .= "WHERE username='". $username . "' ";
	$sql .= "AND password='". $password . "' ";
	$result=$con->query($sql);
	if($result){
		if($result->num_rows >0){
			$row=$result->fetch_array();
			$_SESSION['username'] = $username;
			$_SESSION["ruolo"] = $row['ruolo'];
			$_SESSION['idUtente'] = $row['idUtente'];
			$_SESSION['idBiblioteca'] = $row['fkBiblioteca'];
			header("Location: achilles.php");
		}else{
			echo "<h3>utente non riconosciuto</h3>";
			session_destroy();
		}
	}else{
		echo "<h3>errore accesso db</h3>";
	}
	$con->close();
	
?>

