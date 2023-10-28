<?php 
    if(isset($_GET['idPrestito'])){
        $idPrestito = $_GET['idPrestito'];
    }
    require('fpdf183/fpdf.php');
    $idUtente;
    
class PDF extends FPDF
{
// Crea intestazione di pagina con il logo del sistema
function Header()
{
    // Logo
    $this->Image('images/logo.png',10,6,120, 40);
    $this->Ln(20);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Line break
    $this->Ln(30);
}

// Crea piè di pagina di pagina con il numero di pagina
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Times','',16);
    
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
    //richiede al database tutti i dati relativi al prestito, al libro e all'utente a cui è in carico 
    $sql = "SELECT prestito.*, utente.idUtente, utente.nome, utente.cognome, libro.titolo, libro.ISBN, collocazione.*, autore.nome AS anome, autore.cognome AS acognome, biblioteca.denominazione";
    $sql .= " FROM libro";
    $sql .= " INNER JOIN scrivere ON libro.idLibro=scrivere.fkLibro";
    $sql .= " INNER JOIN autore ON autore.idAutore=scrivere.fkAutore";
    $sql .= " INNER JOIN collocazione ON libro.fkCollocazione=collocazione.codice";
    $sql .= " INNER JOIN prestito ON libro.idLibro=prestito.fkLibro";
    $sql .= " INNER JOIN utente ON utente.idUtente=prestito.fkUtente";
    $sql .= " INNER JOIN biblioteca ON utente.fkBiblioteca=biblioteca.idBiblioteca";
    $sql .= " WHERE idPrestito ='".$idPrestito."'";
    $result = $con->query($sql);
	if ($result) {
        //stampa i risultati
        if ($result->num_rows > 0) {
            while($row=$result->fetch_array()){
                $idUtente = $row['idUtente'];
                $pdf->SetFont('Times','B',16);
                $pdf->Cell(40,10,utf8_decode('Prestito: '.$idPrestito),'', 2);
                $pdf->SetFont('Times','',16);
                $pdf->Cell(40,10,utf8_decode('Biblioteca: '.$row['denominazione']),'', 2);
                $pdf->Cell(40,10,utf8_decode('Utente: '.$row['cognome']. " ". $row['nome']), '', 2);
                $pdf->Cell(50,10,utf8_decode('Inizio: '.$row['dataInizio']));
                $pdf->Cell(20,10,'');
                $pdf->Cell(50,10,utf8_decode('Fine: '.$row['dataFine']), '', 2);
                $pdf->SetX(10);
                $pdf->Cell(60,10,utf8_decode('ISBN: '.$row['ISBN']. ", ID Libro: ". $row['fkLibro']), '', 2);
                $pdf->Cell(60,10,utf8_decode('Libro: '.$row['titolo']), '', 2);
                $pdf->Cell(60,10,utf8_decode('Autore: '.$row['acognome']. " ". $row['anome']), '', 2);
                
            }
        }
    }
    //salva il file nella cartella del server
    $path = $_SERVER['DOCUMENT_ROOT'].'/GusattoDerek_Achilles/pdfprestiti/prestito'.$idPrestito.'.pdf';
    $name = 'prestito'.$idPrestito;
    $pdf->Output('F', $path);
    //richiama la pagina che invia il file all'utente via mail
    header("Location: mail.php?utente=".$idUtente."&allegato=".$name);

?>