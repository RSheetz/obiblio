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
 *	
 *
 * Datenbank Verbindung wird hergestellt die verliehenen Medien werden gesucht.
 * Danach werden die E-Mail Adressen geholt.
 * Falls die Bedinungen erfüllt sind, werden die E-Mails an die jeweiligen Adressen geschickt.
 * Zeitgleich, wird wird in einer Textdatei die Aktionen dokumentiert.
 *	
 * Die weiteren Bedinungen zum Senden sind:
 * Eine Emailadresse eines Benutzers muss exisitiert
 * Die Abstände zur Abgabe entsprechen +3 / +7 Tage oder -2 / -7 Tage
 *	
 * Bei Fristüberschreitung wird zusätzlich das AVMZ als CC hinzugefügt
 *
 * Zur einfacheren Wartung und Anpassung sind alle Konfigruationen 
 * in die config.ini ausgelagert worden, dies macht das anpassen 
 * des Mailverkehrs einfacher.
 *
 *
 ******************************************************************************
 */
 
//Prase the config.ini file 
$ini_array = parse_ini_file("config.ini");

$tab = "Automatisierte_Mails";

//Einbindung der PHPMailer Bibliothek  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\composer\vendor\autoload.php';

//Einbindung der Klassen und funktionen für Textfelder
require_once("../shared/common.php");
require_once("../functions/inputFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);

function sendeMail($fromEmailknot,$empfaenger,$betreff,$textAnfang,$textBody)
{
	
	//Prase the config.ini file 
	$ini_array = parse_ini_file("config.ini");
	$text='';
	
	$tab = "Automatisierte_Mails";
	//Einbindung der Klassen und funktionen für Textfelder	
	require_once("../shared/common.php");
	require_once("../functions/inputFuncs.php");
	require_once("../classes/Localize.php");
	$loc = new Localize(OBIB_LOCALE,$tab);

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
			
		echo " <h2>Ausgabe der Variablen:</h2><br />";				
		
		echo "<br /> Knoten: ".$fromEmailknot."<br />";
		echo "<br /> Empfänger: ".$empfaenger."<br />";
		echo "<br /> Betreff: ".$betreff."<br />";	
		
		$text.=$textAnfang;
		
		
		if($betreff=='Frist Überschreitung 2 Tage' or $betreff=='Frist Überschreitung 7 Tage')
		{
			$mail->addCC($ini_array["fromEmail"], 'AVMZ');	
			$text.= $loc->getText("MailEinleitungErmahnung");
			$text.=$textBody;
			$text.= $loc->getText("MailSchlussErmahnung");			
		}
		else
		{
			$text.=  $loc->getText("MailEinleitungErinnerung");
			$text.=$textBody;
			$text.= $loc->getText("MailSchlussErinnerung");
		}
		
		echo "<br /> Text-Message: <br />".$text."<br />";
	   
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
		
	echo " <h2>Email ist versendet</h2><br />";
	
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
	$text="";	
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

//Kopntroll ausgaben
echo "Kontrolle Beginnt...<br>" ;
echo "Inisialisierung fuer das Holen der Daten<br>";

/*
******************************************************************************
*/

$fromEmailknot=  $ini_array["fromEmail"];

/*
******************************************************************************
*/

// Datenbank Verbindung wird hergestellt
$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);

/* Die Daten werden vorselektiert (SQL Anweisung)

	Das bedeutet konkret, dass alle Medien gesucht werden, die ausgeliehen sind.
	
*/
$sql1 = "SELECT DISTINCT member.email, member.first_name, member.last_name FROM biblio_copy LEFT JOIN member ON biblio_copy.mbrid = member.mbrid WHERE status_cd = 'out' ORDER BY member.email ";

// $sqlcount wird für Testzwecke benutzt und kann ggf entfernt werden
$sqlcount = "SELECT count(*) as 'count'  FROM biblio_copy LEFT JOIN member ON biblio_copy.mbrid = member.mbrid WHERE status_cd = 'out' order by 1, member.email ";

$empfaenger='';
$text='';
$textBody='';
$betreff='';
$Anzahl=0;
$zeile='';

BackupControl();


foreach ($pdo->query($sqlcount) as $row){
$count=$row['count'];
}

// Generierung eines Zeitstempels
$timestamp = time();
$datum = date("Y-m-d",$timestamp);
$uhrzeit = date("H:i",$timestamp);

// Dann werden die Daten druchsucht und bei Treffern geht es in die IF-Anweisungen
foreach ($pdo->query($sql1) as $row) 
{

// Übergabe der Daten an die zu verabeitende Stelle
$empfaenger=$row['email'];


$sql_Mail = "SELECT biblio_copy.mbrid , biblio_copy.due_back_dt ,biblio_copy.copy_desc ,biblio_copy.barcode_nmbr , member.email, member.last_name, member.first_name FROM biblio_copy LEFT JOIN member ON biblio_copy.mbrid = member.mbrid WHERE status_cd = 'out' And member.email='$empfaenger'";

	foreach ($pdo->query($sql_Mail) as $row)
	{		
	$Anzahl++;
	echo "<br>Anzahl:".$Anzahl."von:".$count."<br>";	
	/*
	Übergabe der Daten aus der DB an variablen zur weiteren Verarbeitung
	*/
	$name=$row['first_name'];
	$nachname=$row['last_name'];
	$textAnfang = $loc->getText("Begrüssung",array("name"=>$name, "nachname"=>$nachname ));
	$Beschreibung=$row['copy_desc'];
	$Barcodenummer=$row['barcode_nmbr'];
	$pro_deadline = $row['due_back_dt'];
	
	// Bestimmung der Zeitdifferenz zwischen aktuellem Datum und der Abgabe des Objekts
	$today = date_create($datum);
	$end = strtotime($pro_deadline);
	$end_line = date_create(date("Y-m-d",$end));
	$diff = date_diff($today,$end_line);

	//Kopntroll ausgaben
	echo $diff->format('%R%a'); 
	echo " days apart <br /><br />";
	$days = $diff->format("%R%a");// Formatierung für die Unterscheidung von Leihverzug oder nicht
	
	echo "Datum Abgabe: " .$row['due_back_dt']."<br /><br />";
	echo "Aktuelles Datum: " .$datum."<br /><br />";
		
		// Es wird erinnert falls der Abgabezeitpunkt nicht überschritten wurde 
		// Es wir ermahnt falls der Abgabezeitpunkt überschritten wurde
		if($empfaenger!='' && $days == +3 or $empfaenger!='' && $days == +7)
			{
			$betreff = $loc->getText("Betreff_Auto");
			$days=abs($days); // abs($var) entfernt das Vorzeichen
			echo " Text wird hinzugefügt<br /><br />";
			 // $textBody .="\nMedium: $Beschreibung , Barcode: $Barcodenummer fällig in $days Tagen,\n";					
	
			$textBody .= $loc->getText("Beschreibung",array("Beschreibung"=>$Beschreibung)); 
			$textBody .= $loc->getText("Barcode",array("Barcodenummer"=>$Barcodenummer));
			$textBody .= $loc->getText("fällig in %days% Tagen",array("days"=>$days));
	
			}
			else
			{	
			$betreff= sendeMail($fromEmailknot,$empfaenger,$betreff,$textAnfang,$textBody);
			
			if($empfaenger!=''&& $days == -2 or $empfaenger !='' && $days == -7)
				{
				$days=abs($days);	// abs($var) entfernt das Vorzeichen
				$betreff = "Frist Überschreitung $days Tage";
				
				$textBodyMahn='';
				
				echo " Text wird hinzugefügt<br /><br />";
				$textBodyMahn .= $loc->getText("Beschreibung",array("Beschreibung"=>$Beschreibung)); 
				$textBodyMahn .= $loc->getText("Barcode",array("Barcodenummer"=>$Barcodenummer));
				$textBodyMahn .= $loc->getText("fällig vor %days% Tagen",array("days"=>$days));
				
				$betreff= sendeMail($fromEmailknot,$empfaenger,$betreff,$textAnfang,$textBodyMahn);				
					
				}
				else
				{	
					//Kontroll ausgaben
					echo "Keine Reaktion nötig <br /><br />";
				
				}
			}			
	}

	$betreff= sendeMail($fromEmailknot,$empfaenger,$betreff,$textAnfang,$textBody);		
		
	$textBody='';
}
echo " $zeile <br /><br />";
//Kontroll ausgaben
echo "<br /> Kontrolle zu Ende";
?>