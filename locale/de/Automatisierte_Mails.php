<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 *
 */
/**********************************************************************************
 *   Instructions for translators:
 *
 *   All gettext key/value pairs are specified as follows:
 *     $trans["key"] = "<php translation code to set the $text variable>";
 *   Allowing translators the ability to execute php code withint the transFunc string
 *   provides the maximum amount of flexibility to format the languange syntax.
 *
 *   Formatting rules:
 *   - Resulting translation string must be stored in a variable called $text.
 *   - Input arguments must be surrounded by % characters (i.e. %pageCount%).
 *   - A backslash ('\') needs to be placed before any special php characters 
 *     (such as $, ", etc.) within the php translation code.
 *
 *   Simple Example:
 *     $trans["homeWelcome"]       = "\$text='Welcome to OpenBiblio';";
 *
 *   Example Containing Argument Substitution:
 *     $trans["searchResult"]      = "\$text='page %page% of %pages%';";
 *
 *   Example Containing a PHP If Statment and Argument Substitution:
 *     $trans["searchResult"]      = 
 *       "if (%items% == 1) {
 *         \$text = '%items% result';
 *       } else {
 *         \$text = '%items% results';
 *       }";
 *
 **********************************************************************************
 */
	$trans["Betreff_Auto"]       				= "\$text='Automatisierte Mails';";
	$trans["Betreff_Rückgabe"]   				= "\$text='Rückgabebestätigung AVMZ';";
	$trans["Betreff_Bestätigung"]   			= "\$text='Ausleihbestätigung AVMZ';";	
	
	$trans["Begrüssung"]   						= "\$text='Guten Tag %name% %nachname% \n ';";	
	
	$trans["Ausleih_Einleitung"]   				= "\$text='\nhiermit bestätigen wir, dass Sie folgende Medien bei uns ausgeliehen haben:\n';";
	
	$trans["Rückgabebestätigung_Einleitung"]  	= "\$text='\nhiermit bestätigen wir, dass Sie folgendes Medium bei uns zurück gegeben haben:\n';";
	$trans["Rückgabebestätigung_Schluss"]   	= "\$text='\nEinen schönen Tag wünscht Ihnen. \n\nIhr AVMZ Service.\n';";

	$trans["MailEinleitungErinnerung"]			= "\$text = '\nEs befinden sich noch folgende Medien in Ihrer Ausleihe, die bald fällig sind:\n';";
	$trans["MailEinleitungErmahnung"]   		= "\$text = '\nEs befinden sich noch folgende Medien in Ihrer Ausleihe, die überfällig sind:\n';";
	
	$trans["Back"]         						= "\$text = '\nRückgabe am: %today%,';";
	$trans["Beschreibung"]         				= "\$text = '\nMedium: %Beschreibung%,';";
	$trans["Barcode"] 							= "\$text = ' Barcode: %Barcodenummer%';";
	$trans["fällig in %days% Tagen"] 			= "\$text = ' fällig in %days% Tagen,\n';";
	$trans["fällig vor %days% Tagen"] 			= "\$text = ' fällig vor %days% Tagen,\n';";
	$trans["due_back_dt"] 						= "\$text = ' Fristende: %end_line%.\n';";
	
	$trans["MailSchlussErinnerung"]				= "\$text = '\nBitte tragen Sie dafür Sorge, dass die ausgeliehenen Medien rechtzeitig wieder unserem Ausleihpool zugetragen werden, da ansonsten Gebühren zu Ihren Lasten, gemäß unseren AGBs veranschlagt werden.\n\nMit freundlichen Grüßen\n\nIhr AVMZ Service.';";
	$trans["MailSchlussErmahnung"]        		= "\$text = '\nBitte tragen Sie dafür Sorge, dass die ausgeliehenen Medien schnellstmöglich wieder unserem Ausleihpool zugetragen werden, da ansonsten weitere Gebühren zu Ihren Lasten, gemäß unseren AGBs veranschlagt werden.\nMit freundlichen Grüßen \n\nIhr AVMZ Service.';";
	
?>
