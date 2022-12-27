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
 
 require_once("../shared/common.php");
 
 //Einbindung der PHPMailer Bibliothek 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\composer\vendor\autoload.php';
 
 
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



function Rueckgabebestaetigung($barcode)
{
	
	$tab = "Automatisierte_Mails";
	require_once("../classes/Localize.php");
	$loc = new Localize(OBIB_LOCALE,$tab);
	$ini_array = parse_ini_file("config.ini");
	
	
/*********************************************************************************/

$fromEmailknot=  $ini_array["fromEmail"];

/*********************************************************************************/
	
	// Datenbank Verbindung wird hergestellt
	$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);
	
	$sql_Rueckgabe = "SELECT biblio_copy.mbrid, biblio_copy.due_back_dt, biblio_copy.copy_desc ,biblio_copy.barcode_nmbr, member.email, member.last_name, member.first_name FROM biblio_copy LEFT JOIN member ON biblio_copy.mbrid = member.mbrid WHERE status_cd = 'out' And biblio_copy.barcode_nmbr='$barcode'";

	$betreff=$loc->getText("Betreff_Rückgabe");	
	$textBody.=$loc->getText("Rückgabebestätigung_Einleitung");
	foreach ($pdo->query($sql_Rueckgabe) as $row)
	{
	$empfaenger=$row['email'];
	
	$name=$row['first_name'];
	$nachname=$row['last_name'];
	$Beschreibung=$row['copy_desc'];
	$Barcodenummer=$row['barcode_nmbr'];
	$pro_deadline = $row['due_back_dt'];
	
	// Bestimmung der Zeitdifferenz zwischen aktuellem Datum und der Abgabe des Objekts
	$today = date_create($datum);
	$end = strtotime($pro_deadline);
	$end_line = date_create(date("Y-m-d",$end));
	$diff = date_diff($today,$end_line);
	
	$today = $today->format('d-m-Y');
	$end_line = $end_line->format('d-m-Y');

	
	$textAnfang = $loc->getText("Begrüssung",array("name"=>$name, "nachname"=>$nachname ));
	
	$textBody .= $loc->getText("Back",array("today"=>$today)); 
//$textBody .= $loc->getText("",array("today"=>$today));  Bei Überfälligkeit vielleicht die Tage mit angeben?
	$textBody .= $loc->getText("Beschreibung",array("Beschreibung"=>$Beschreibung)); 
	$textBody .= $loc->getText("Barcode",array("Barcodenummer"=>$Barcodenummer));
	$textBody .= $loc->getText("due_back_dt",array("end_line"=>$end_line));
	
	$textBody .=$loc->getText("Rückgabebestätigung_Schluss");
	
	$betreff= sendeMail($fromEmailknot,$empfaenger,$betreff,$textAnfang,$textBody);		
	}

}

?>