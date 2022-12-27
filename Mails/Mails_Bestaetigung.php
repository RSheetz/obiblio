<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 *
 *******************************************************************************
 *
 * @author Roman Sheetz <roman-sheetz@gmx.de>;
 * @version 1.0
 * @access public
 *
 *	avmz.verleih@fh-swf.de
 *	smtp.fh-swf.de
 *
 * Datenbank Verbindung wird hergestellt die verliehenen Medien werden gesucht.
 * Danach werden die E-Mail Adressen geholt.*
 * Falls die Bedinungen erfüllt sind, werden die E-Mails an die jeweiligen Adressen geschickt.
 * Zeitgleich, wird wird in einer Textdatei die Aktionen dokumentiert.
 *	
 * Die weiteren Bedinungen zum Senden sind:
 * Eine Emailadresse eines Benutzers exisitiert
 *
 ******************************************************************************
 */
 
 // Einbindung der Files für das obiblio Desgin
  $tab = "circulation";
  $nav = "";   
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../shared/header.php");
  require_once("../functions/inputFuncs.php");
 
//Einbindung der config.ini file 
$ini_array = parse_ini_file("config.ini");

//Einbindung der PHPMailer Bibliothek 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\composer\vendor\autoload.php';
 
 //Einbindung der Klassen und funktionen für Textfelder
$tab = "Automatisierte_Mails";



 $loc = new Localize(OBIB_LOCALE,$tab);

function sendeMail($fromEmailknot,$empfaenger,$betreff,$textAnfang,$textBody)
{
	
	//Prase the config.ini file 
	$ini_array = parse_ini_file("config.ini");
	$text='';
	
	$tab = "Automatisierte_Mails";
	
	require_once("../shared/common.php");
	require_once("../functions/inputFuncs.php");
	// require_once("../Mails/classes/Localize.php");
	$loc = new Localize(OBIB_LOCALE,$tab);

	//Block der nur für das Senden der Mail zuständig ist!
	$mail = new PHPMailer(TRUE);
	$mail->CharSet='UTF-8';
	// Generierung eines Zeitstempels
	$timestamp = time();
	$datum = date("Y-m-d",$timestamp);
	$uhrzeit = date("H:i",$timestamp);

	$zeile='';	
	if(!empty($betreff))
	{
	try 
		{
			
		$text.=$textAnfang;
		$text.=$textBody;
			
		if(0)
		{
		echo " <h2>Ausgabe der Variablen:</h2><br />";		
		echo "<br /> Knoten: ".$fromEmailknot."<br />";
		echo "<br /> Empfänger: ".$empfaenger."<br />";
		echo "<br /> Betreff: ".$betreff."<br />";	
		echo "<br /> Text-Message: <br />".$text."<br />";
		}			
		
	   
	   $mail->setFrom($fromEmailknot);
	   $mail->addAddress($empfaenger);
	   $mail->Subject = $betreff;
	   $mail->Body = $text;
	   
	   // SMTP parameters. 
	   
	   // Tells PHPMailer to use SMTP.
		$mail->isSMTP();
	   
	   // SMTP server address.
		$mail->Host = $ini_array["host-email-adresse"];

	   // Use SMTP authentication. 
		$mail->SMTPAuth = TRUE;
	   
	   //SMTP connection will not close after each email sent, reduces SMTP overhead
		$mail->SMTPKeepAlive = true; 
	   
	   // Set the encryption system. 
		$mail->SMTPSecure = $ini_array["ssl"];
	   
	   // SMTP authentication username. 
		$mail->Username = $ini_array["username"];
	   
	   // SMTP authentication password.
		$mail->Password = $ini_array["password"];
	   
	   // Set the SMTP port. 
		$mail->Port = $ini_array["port"];
	   
	   // Finally send the mail.
		$mail->send();
	  
	  // Clear the Adresses to prevent overload the recivers
		$mail->clearAddresses();
		
	echo " <h2>Email ist versendet</h2><br /><br />";

	//Protokoll den durchgeführten Emailversand
	$zeile .= "Mail gesendet an $empfaenger \r\n";		
	$zeile .= "Logfile: $datum - $uhrzeit \r\n";
	$log= fopen('C:\xampp\htdocs\obiblio\Mails\Log_Mails.txt', 'a');
	
	fwrite($log,$zeile);
	fclose($log);  
	}
	catch (Exception $e)
	{
	$zeileS ="";
	echo $e->errorMessage();
	echo " <h2>ARLARM ERROR</h2><br /><br />";
	
	$zeileS .= "Fehler: $mail->ErrorInfo\r\nLogfile: $datum - $uhrzeit \r\n";

	$log= fopen('C:\xampp\htdocs\obiblio\Mails\ErrorInfoHandling.txt', 'a');
	fwrite($log,$zeileS);
	fclose($log);
	
	try{
	$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql_Mailsave="Insert into BackupIfError (Betreff,Sender,Empfaenger,Textinhalt) values('$betreff','$fromEmailknot','$empfaenger','$textBody')";
	$pdo->exec($sql_Mailsave);
	
	
	$pdo=null;
		
	}
	catch(PDOException $e) {
	echo $sql_Mailsave . "<br>" . $e->getMessage();
	}

	}
	catch (\Exception $e)
	{
	   echo $e->getMessage();	   
	}	
	$betreff="";
	}	
	return ($betreff);
}	


function BackupControl()
{
	$ini_array = parse_ini_file("config.ini");
	try{
	$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql_Mailget="SELECT * FROM BackupIfError";
	foreach ($pdo->query($sql_Mailget) as $row){
		
		echo "Betreff:".$row['Betreff']."<br /><br />";		
		echo "Sender:".$row['Sender']."<br /><br />";		
		echo "Empfänger:".$row['Empfaenger']."<br /><br />";		
		echo "Textinhalt:".$row['Textinhalt']."<br /><br />";
		
		$textAnfang="Guten Tag";
	
	
	$betreff= sendeMail($row['Sender'],$row['Empfaenger'],$row['Betreff'],$textAnfang,$row['Textinhalt']);		
	
	}
	$sql_Maildelete="DELETE From BackupIfError";
	$pdo->exec($sql_Maildelete);
	$pdo=null;
		
	}
	catch(PDOException $e) {
	echo $sql_Mailsave . "<br>" . $e->getMessage();
	}
}

/*********************************************************************************/

$fromEmailknot=  $ini_array["fromEmail"];

/*********************************************************************************/

$mbrid = trim($_POST["mbrid"]);

// Generierung eines Zeitstempels
$timestamp = time();
$datum = date("Y-m-d",$timestamp);
$uhrzeit = date("H:i",$timestamp);
	
// Datenbank Verbindung wird hergestellt
$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);

$sql_Ausleihe = "SELECT biblio_copy.mbrid , biblio_copy.due_back_dt ,biblio_copy.copy_desc ,biblio_copy.barcode_nmbr, biblio_copy.status_begin_dt , member.email, member.last_name, member.first_name FROM biblio_copy LEFT JOIN member ON biblio_copy.mbrid = member.mbrid WHERE status_cd = 'out' And member.mbrid='$mbrid' AND CONVERT(biblio_copy.status_begin_dt, DATE)=CURRENT_DATE";

	$betreff=$loc->getText("Betreff_Bestätigung");	
	$textBody.=$loc->getText("Ausleih_Einleitung");

foreach ($pdo->query($sql_Ausleihe) as $row)
	{
	/*
	Übergabe der Daten aus der DB an variablen zur weiteren Verarbeitung
	*/
	$empfaenger=$row['email'];

	$name=$row['first_name'];
	$nachname=$row['last_name'];
	$Beschreibung=$row['copy_desc'];
	$Barcodenummer=$row['barcode_nmbr'];
	$pro_deadline = $row['due_back_dt'];
	
	$textAnfang = $loc->getText("Begrüssung",array("name"=>$name, "nachname"=>$nachname ));
	
	// Bestimmung der Zeitdifferenz zwischen aktuellem Datum und der Abgabe des Objekts
	$today = date_create($datum);
	$end = strtotime($pro_deadline);
	$end_line = date_create(date("Y-m-d",$end));
	$diff = date_diff($today,$end_line);

	$days = $diff->format("%R%a");// Formatierung für die Unterscheidung von Leihverzug oder nicht
	
	$days=abs($days);	// abs($var) entfernt das Vorzeichen
	
	$textBody .= $loc->getText("Beschreibung",array("Beschreibung"=>$Beschreibung)); 
	$textBody .= $loc->getText("Barcode",array("Barcodenummer"=>$Barcodenummer));
	$textBody .= $loc->getText("fällig in %days% Tagen",array("days"=>$days));
}
	$textBody .=$loc->getText("MailSchlussErinnerung");
	
	
if(!empty($empfaenger))
{
$betreff= sendeMail($fromEmailknot,$empfaenger,$betreff,$textAnfang,$textBody);		
}
else
{
	echo "Es wurden heute keine Medien an diesen Benutzer verliehen!<br /><br />";
}
 ?>

<?php require_once("../shared/footer.php"); ?>
