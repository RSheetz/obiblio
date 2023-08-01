<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 *
 *******************************************************************************
 *
 * @author Roman Sheetz <roman-sheetz@gmx.de>;
 * @descr Hier ist die Verwaltung des Peppers gelöst.
 * @version 1.0
 * @access public
 *
 ******************************************************************************
 */
 
 /*
 *	Autor: Roman Sheetz
 *	Datum: 11.06.2023
 *	Decr: Funktion beim Anmelden; Gibt den Pepper angehängt an das Passwort zurück.
 *	Param: $username, $pwd
 *	Return: $pwd
 *	Letzte Änderung: 25.07.2023
 */
function controlpepper($username,$pwd)
{
	$ini_array = parse_ini_file("config.ini");
	$openfile= file_get_contents($ini_array["pepperpath"], 'r');
	$users = explode("\n",$openfile);
	
   foreach ($users as $row) {
	list($user, $secret) = explode(' ',$row);
		if($user == $username)
		{
		$pwd.=$secret;
		break;
		}
   }
   return $pwd;
}
 /*
 *	Autor: Roman Sheetz
 *	Datum: 11.06.2023
 *	Decr: 	Funktion beim Anlegen eines neuen Mitarbeiters; 
 *			Erstellt zufallsgenerierten 16 byte Code
 *			der dann in Hex gewandelt und 
 *			gibt den Pepper angehängt an das Passwort zurück. 
 *	Param: $username, $pwd
 *	Return: $pwd
 *  Letzte Änderung: 25.07.2023
 */
function insertpepper($pwd,$username)
{
	$ini_array = parse_ini_file("config.ini");
	$sRandomBytes= random_bytes(16);
	$secret=bin2hex($sRandomBytes);
	$pwd.=$secret;
	
	$fileOpen = fopen($ini_array["pepperpath"], 'a');
	fwrite($fileOpen, "\n");
	fwrite($fileOpen, $username);
	fwrite($fileOpen, " ");
	fwrite($fileOpen, $secret);
	fclose($fileOpen);	
	
	return $pwd;
}

 /*
 *	Autor: Roman Sheetz
 *	Datum: 11.06.2023
 *	Decr: 	Funktion beim reset des Passwortes eines Mitarbeiters; 
 *			Verwendet das neu gesetzte Passwort und
 *			gibt den Pepper angehängt an das Passwort zurück. 
 *	Param: $username, $pwd
 *	Return: $pwd
 *  Letzte Änderung: 25.07.2023
 */
function resetpepper($userid,$pwd)
{
	$ini_array = parse_ini_file("config.ini");
	// $sRandomBytes= random_bytes(16);
	// $secret=bin2hex($sRandomBytes);
	$username="";
	
	// Datenbank Verbindung wird hergestellt
	
	try{
		$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);
		$sql = "select staff.username from staff where userid ='$userid'";
		
		foreach ($pdo->query($sql) as $row)
		{		
		$username=$row['username'];
		$openfile= file_get_contents($ini_array["pepperpath"], 'r');
		$users = explode("\n",$openfile);
	
			foreach ($users as $row) 
			{
			list($user, $secret) = explode(' ',$row);
				if($user == $username)
				{
				$pwd.=$secret;
				break;
				}
			}
		}
		
	}
	catch(PDOException $e) 
	{
	echo $sql . "<br>" . $e->getMessage();
	}
	
	return $pwd;
}

/*
 *	Autor: Roman Sheetz
 *	Datum: 11.06.2023
 *	Decr: 	Funktion beim Löschen eines Mitarbeiters; 
 *			Durch die Übergabe der Userid sucht 
 *			die Funktion sich den passenden usernamen 
 *			aus der Datenbank und vergeleicht den mit den 
 *			Einträgen in der Datei, bei einem Treffer wird
 *			der Eintrag aus der Datei gelöscht/überschrieben
 *	Param: $userid
 *	Return: kein
 *  Letzte Änderung: 25.07.2023
 */
function deletepepper($userid)
{
	$ini_array = parse_ini_file("config.ini");
	
	// Datenbank Verbindung wird hergestellt
	
	try{
		$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);
		$sql = "select staff.username from staff where userid ='$userid'";
		
		foreach ($pdo->query($sql) as $row)
		{		
		$username=$row['username'];
		$count=0;
		
		$openfile= file_get_contents($ini_array["pepperpath"], 'r');
		$users = explode("\n",$openfile);	
		$countmax=count($users);
		$openfileNew = fopen($ini_array["pepperpath"], 'w');
		
			foreach ($users as $row)
			{
			$count++;
			list($user, $secret) = explode(' ',$row);	
				if($user !== $username)
				{
				fwrite($openfileNew, $user);
				fwrite($openfileNew, " ");
				fwrite($openfileNew, $secret);
				
				if($count<$countmax-1)
				{
				fwrite($openfileNew, "\n");	
				}
				}
				
			}	
		fclose($openfileNew);
		}		
	}
	catch(PDOException $e) 
	{
	echo $sql . "<br>" . $e->getMessage();
	}
}
 ?>
