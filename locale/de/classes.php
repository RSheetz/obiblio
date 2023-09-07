<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/**********************************************************************************
 *   Instructions for translators:
 *
 *   All gettext key/valü pairs are specified as follows:
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

#****************************************************************************
#*  Translation text for class Biblio
#****************************************************************************
$trans["biblioError1"]            = "\$text = 'Der Standort wird benötigt.';";

#****************************************************************************
#*  Translation text for class BiblioField
#****************************************************************************
$trans["biblioFieldError1"]       = "\$text = 'Das Feld wird benötigt.';";
$trans["biblioFieldError2"]       = "\$text = 'Der Tag muss numerisch sein.';";

#****************************************************************************
#*  Translation text for class BiblioQüry
#****************************************************************************
$trans["biblioQüryQüryErr1"]    = "\$text = 'Fehler beim Zugriff auf die Medieninformation.';";
$trans["biblioQüryQüryErr2"]    = "\$text = 'Fehler beim Zugriff auf die Medienfelder.';";
$trans["biblioQüryInsertErr1"]   = "\$text = 'Fehler beim Einfügen des neuen Mediums.';";
$trans["biblioQüryInsertErr2"]   = "\$text = 'Fehler beim Einfügen des neuen Medienfeldes.';";
$trans["biblioQüryUpdateErr1"]   = "\$text = 'Fehler beim Aktualisieren des Mediums.';";
$trans["biblioQüryUpdateErr2"]   = "\$text = 'Fehler bei der Aktualisierung des Mediums beim Medienfeld.';";
$trans["biblioQüryDeleteErr"]    = "\$text = 'Fehler beim Löschen des Mediums.';";

#****************************************************************************
#*  Translation text for class BiblioSearchQüry
#****************************************************************************
$trans["biblioSearchQüryErr1"]   = "\$text = 'Fehler beim Zählen der Suchergenisse.';";
$trans["biblioSearchQüryErr2"]   = "\$text = 'Fehler beim Suchen nach Medieninformationen.';";
$trans["biblioSearchQüryErr3"]   = "\$text = 'Fehler beim Lesen der Medieninformationen.';";

#****************************************************************************
#*  Translation text for class BiblioCopy
#****************************************************************************
$trans["biblioCopyError1"]        = "\$text = 'Die Mediennummer wird benötigt.';";
$trans["biblioCopyError2"]        = "\$text = 'Ungültige Zeichen im Barcode.';";

#****************************************************************************
#*  Translation text for class BiblioCopyQüry
#****************************************************************************
$trans["biblioCopyQüryErr1"]     = "\$text = 'Fehler bei der Prüfung der Mediennummer.';";
$trans["biblioCopyQüryErr2"]     = "\$text = 'Mediennummer %barcodeNmbr% wird bereits benutzt.';";
$trans["biblioCopyQüryErr3"]     = "\$text = 'Fehler beim Einfügen des neün Exemplars.';";
$trans["biblioCopyQüryErr4"]     = "\$text = 'Fehler beim Zugriff auf das Exemplar.';";
$trans["biblioCopyQüryErr5"]     = "\$text = 'Fehler bei der Aktualisierung des Exemplars.';";
$trans["biblioCopyQüryErr6"]     = "\$text = 'Fehler beim Löschen des Exemplars.';";
$trans["biblioCopyQüryErr7"]     = "\$text = 'Fehler beim Zugriff auf die Medieninformation um den Genrecode zu bekommen.';";
$trans["biblioCopyQüryErr8"]     = "\$text = 'Fehler beim Zugriff auf die Genreinforamtionen um Rückgabe-Datum zu erstellen.';";
$trans["biblioCopyQüryErr9"]     = "\$text = 'Fehler bei der Rückgabe des Exemplars';";
$trans["biblioCopyQüryErr10"]    = "\$text = 'Fehler beim überprüfen der Ausleihlimits';";
$trans["biblioCopyQüryErr11"]    = "\$text = 'Fehler beim Ermitteln der Kopie mit der größten Nummer.';";

#****************************************************************************
#*  Translation text for class BiblioFieldQüry
#****************************************************************************
$trans["biblioFieldQüryErr1"]    = "\$text = 'Fehler beim Lesen eines Medienfeldes.';";
$trans["biblioFieldQüryErr2"]    = "\$text = 'Fehler beim Lesen eines Medienfeldes.';";
$trans["biblioFieldQüryInsertErr"] = "\$text = 'Fehler beim Einfügen eines Medienfeldes.';";
$trans["biblioFieldQüryUpdateErr"] = "\$text = 'Fehler beim Aktualisieren eines Medienfeldes.';";
$trans["biblioFieldQüryDeleteErr"] = "\$text = 'Fehler beim Löschen eines Medienfeldes.';";

#****************************************************************************
#*  Translation text for class UsmarcBlockDmQüry
#****************************************************************************
$trans["usmarcBlockDmQüryErr1"]  = "\$text = 'Fehler beim Zugriff auf die MARC-Blöcke.';";

#****************************************************************************
#*  Translation text for class UsmarcTagDmQüry
#****************************************************************************
$trans["usmarcTagDmQüryErr1"]    = "\$text = 'Fehler beim Zugriff auf die MARC-Tags.';";

#****************************************************************************
#*  Translation text for class UsmarcSubfieldDmQüry
#****************************************************************************
$trans["usmarcSubfldDmQüryErr1"] = "\$text = 'Fehler beim Zugriff auf die MARC-Unterfelder.';";

#****************************************************************************
#*  Translation text for class BiblioHoldQüry
#****************************************************************************
$trans["biblioHoldQüryErr1"]     = "\$text = 'Fehler beim Zugriff auf Vorbestellung durch Mediennummer.';";
$trans["biblioHoldQüryErr2"]     = "\$text = 'Fehler beim Zugriff auf Vorbestellung durch Benutzernummer.';";
$trans["biblioHoldQüryErr3"]     = "\$text = 'Fehler bei der Vorbestellung wegen Prüfung der Mediennummer.';";
$trans["biblioHoldQüryErr4"]     = "\$text = 'Fehler beim Einfügen der Vorbestellung.';";
$trans["biblioHoldQüryErr5"]     = "\$text = 'Fehler beim Löschen der Vorbestellung.';";
$trans["biblioHoldQüryErr6"]     = "\$text = 'Fehler beim Ermitteln der ersten Vorbestellung für dieses Exemplar.';";

#****************************************************************************
#*  Translation text for class ReportQüry
#****************************************************************************
$trans["reportQüryErr1"]         = "\$text = 'Fehler beim Erstellen der Berichte.';";

#****************************************************************************
#*  Translation text for class ReportCriteria
#****************************************************************************
$trans["reportCriteriaErr1"]      = "\$text = 'Ein nichtmumerischer Wert ist in einer Zahlenspalte nicht erlaubt.';";
$trans["reportCriteriaDateTimeErr"] = "\$text = 'Ungültiges Zeitformat.';";
$trans["reportCriteriaDateErr"]   = "\$text = 'Ungültiges Datumsformat.';";

#****************************************************************************
#*  Translation text for class Staff
#****************************************************************************
$trans["staffLastNameReqErr"]     = "\$text = 'Nachname wird benötigt.';";
$trans["staffUserNameLenErr"]     = "\$text = 'Benutzername muss mindestens 4 Zeichen lang sein.';";
$trans["staffUserNameCharErr"]    = "\$text = 'Benutzername darf kein Leerzeichen enthalten.';";
$trans["staffPwdLenErr"]          = "\$text = 'Passwort muss mindestens 8 Zeichen lang sein.';";
$trans["staffPwdCharErr"]         = "\$text = 'Passwort darf kein Leerzeichen enthalten.';";
$trans["staffPwdCharUppercaseErr"]         = "\$text = 'Passwort muss mindestens ein Großbuchstaben enthalten.';";
$trans["staffPwdCharLowcaseErr"]         = "\$text = 'Passwort muss mindestens ein Kleinbuchstaben enthalten.';";
$trans["staffPwdMatchErr"]        = "\$text = 'Passwörter sind nicht identisch.';";

#****************************************************************************
#*  Translation text for class Member
#****************************************************************************
$trans["memberBarcodeReqErr"]     = "\$text = 'Die Benutzernummer wird benötigt.';";
$trans["memberBarcodeCharErr"]    = "\$text = 'Ungültige Zeichen in Benutzernummer.';";
$trans["memberLastNameReqErr"]    = "\$text = 'Nachname wird benötigt.';";
$trans["memberFirstNameReqErr"]   = "\$text = 'Vorname wird benötigt.';";
$trans["memberEmailReqErr"]	= "\$text = 'E-Mail-Adresse wird benötigt.';";
//Übersetzung für die Fehlermeldung ins deutsche. Autor: Roman Sheetz geändert am 18.05.2020 */

#****************************************************************************
#*  Translation text for class LabelFormat and LetterFormat
#****************************************************************************
$trans["labelFormatFontErr"]      = "\$text = 'Ungültige Schriftart in der Etikettendefinitionsdatei. Erlaubte Schriftarten sind Courier, Helvetica und Times-Roman.';";
$trans["labelFormatFontSizeErr"]  = "\$text = 'Ungültige Schriftgröße in der Etikettendefinitionsdatei. Die Schriftgröße muß numerisch sein.';";
$trans["labelFormatFontSizeErr2"] = "\$text = 'Ungültige Schriftgröße in der Etikettendefinitionsdatei. Die Schriftgröße muß größer als Null sein.';";
$trans["labelFormatLMarginErr"]   = "\$text = 'Ungültiger linker Rand in der Etikettendefinitionsdatei. Der linke Rand muß numerisch sein.';";
$trans["labelFormatLMarginErr2"]  = "\$text = 'Ungültiger linker Rand in der Etikettendefinitionsdatei. Der linke Rand muß größer als Null sein.';";
$trans["labelFormatRMarginErr"]   = "\$text = 'Ungültiger rechter Rand in der Etikettendefinitionsdatei. Der rechte Rand muß numerisch sein.';";
$trans["labelFormatRMarginErr2"]  = "\$text = 'Ungültiger rechter Rand in der Etikettendefinitionsdatei. Der rechte Rand muß größer als Null sein.';";
$trans["labelFormatTMarginErr"]   = "\$text = 'Ungültiger oberer Rand in der Etikettendefinitionsdatei. Der obere Rand muß numerisch sein.';";
$trans["labelFormatTMarginErr2"]  = "\$text = 'Ungültiger oberer Rand in der Etikettendefinitionsdatei. Der obere Rand muß größer als Null sein.';";
$trans["labelFormatBMarginErr"]   = "\$text = 'Ungültiger unterer Rand in der Etikettendefinitionsdatei. Der untere Rand muß numerisch sein.';";
$trans["labelFormatBMarginErr2"]  = "\$text = 'Ungültiger unterer Rand in der Etikettendefinitionsdatei. Der untere Rand muß größer als Null sein.';";
$trans["labelFormatColErr"]       = "\$text = 'Ungültige Spalten in der Etikettendefinitionsdatei. Die Spalten müssen numerisch sein.';";
$trans["labelFormatColErr2"]      = "\$text = 'Ungültige Spalten in der Etikettendefinitionsdatei. Die Spalten müssen größer als Null sein.';";
$trans["labelFormatWidthErr"]     = "\$text = 'Ungültige Breite in der Etikettendefinitionsdatei. Die Breite muß numerisch sein.';";
$trans["labelFormatWidthErr2"]    = "\$text = 'Ungültige Breite in der Etikettendefinitionsdatei. Die Breite muß größer als Null sein.';";
$trans["labelFormatHeightErr"]    = "\$text = 'Ungültige Höhe in der Etikettendefinitionsdatei. Die Höhe muß numerisch sein.';";
$trans["labelFormatHeightErr2"]   = "\$text = 'Ungültige Höhe in der Etikettendefinitionsdatei. Die Höhe muß größer als Null sein.';";
$trans["labelFormatNoLabelsErr"]  = "\$text = 'Ungültige Zeilen in der Etikettendefinitionsdatei.';";

#****************************************************************************
#*  Translation text for class BiblioStatusHistQüry
#****************************************************************************
$trans["biblioStatusHistQüryErr1"] = "\$text = 'Fehler die Ausleihhistory durch die Mediennummer zu bekommen.';";
$trans["biblioStatusHistQüryErr2"] = "\$text = 'Fehler die Ausleihhistory durch die Benutzernummer zu bekommen.';";
$trans["biblioStatusHistQüryErr3"] = "\$text = 'Fehler beim Einfügen der Ausleihhistory';";
$trans["biblioStatusHistQüryErr4"] = "\$text = 'Fehler die Ausleihhistory durch die Mediennummer zu löschen.';";
$trans["biblioStatusHistQüryErr5"] = "\$text = 'Fehler die Ausleihhistory durch die Benutzernummer zu löschen.';";

#****************************************************************************
#*  Translation text for class MemberAccountTransaction
#****************************************************************************
$trans["memberAccountTransError1"]  = "\$text = 'Der Betrag wird benötigt.';";
$trans["memberAccountTransError2"]  = "\$text = 'Der Betrag muß numerisch sein.';";
$trans["memberAccountTransError3"]  = "\$text = 'Die Beschreibung wird benötigt.';";
$trans["Amount must be greater than zero."]  = "\$text = 'Der Betrag muß größer als Null sein.';";

#****************************************************************************
#*  Translation text for class MemberAccountQüry
#****************************************************************************
$trans["memberAccountQüryErr1"]    = "\$text = 'Fehler beim Zugriff auf die Benutzerinformationen.';";
$trans["memberAccountQüryErr2"]    = "\$text = 'Fehler beim Einfügen von Benutzerinformationen.';";
$trans["memberAccountQüryErr3"]    = "\$text = 'Fehler beim Löschen von Benutzerinformationen.';";

#****************************************************************************
#*  Translation text for class CircQüry
#****************************************************************************
$trans["Can't understand date: %err%"]                            = "\$text = 'Verstehe Datum nicht: %err%';";
$trans["Won't do checkouts for future dates."]                    = "\$text = 'Kann nicht an zukünftigem Datum ausleihen.';";
$trans["Bad member barcode: %bcode%"]                             = "\$text = 'Falsche Mitgliedsnummer: %bcode%';";
$trans["Member owes fines: checkout not allowed"]                 = "\$text = 'Beim Mitglied gibt es Gebühren: Ausleihen nicht erlaubt';";
$trans["Member must renew membership before checking out."]       = "\$text = 'Das Mitglied muss seine Mitgliedschaft verlängern bevor es ausleihen darf.';";
$trans["Bad copy barcode: %bcode%"]                               = "\$text = 'Falsche Exemplarnummer: %bcode%';";
$trans["Item %bcode% has reached its renewal limit."]             = "\$text = 'Das Exemplar %bcode% hat sein Verlängerungslimit erreicht.';";
$trans["Item %bcode% is late and cannot be renewed."]             = "\$text = 'Das Exemplar %bcode% ist zu spät und darf nicht verlängert werden.';";
$trans["Item %bcode% is on hold."]                                = "\$text = 'Das Exemplar %bcode% ist schon vorbestellt.';";
$trans["Item %bcode% is already checked out to another member."]  = "\$text = 'Das Exemplar %bcode% ist bereits an ein anderes Mitglied verliehen.';";
$trans["Item %bcode% isn't out and cannot be renewed."]  	   = "\$text = 'Das Exemplar %bcode% ist nicht ausgeliehen und kann daher nicht verlängert werden.';";
$trans["Member has reached checkout limit for this collection."]  = "\$text = 'Das Mitglied hat sein Ausleihlimit für dieses Genre erreicht.';";
$trans["Checkouts are disallowed for this collection."]           = "\$text = 'Dieses Genre darf nicht verliehen werden.';";
$trans["Item is on hold for another member."]                     = "\$text = 'Das Exemplar ist für jemand anderen vorbestellt.';";
$trans["!!!Note : dü date is after the end of the membership"] = "\$text = '!!!Hinweis : geplantes Rückgabedatum ist nach dem Ende der Mitgliedschaft!';";
$trans["Can't change status to an earlier date on item %bcode%."] = "\$text = 'Kann den Status von Exemplar %bcode% nicht auf ein früheres Datum ändern.';";
$trans["Can't change status more than once per second on item %bcode%."]  = "\$text = 'Kann den Status von Exemplar %bcode% nicht mehr als einmal pro Sekunde ändern.';";
$trans["Won't do checkins for future dates."]                     = "\$text = 'Kann keine Rückgaben für ein zukünftiges Datum machen.';";
$trans["Late fee (barcode=%barcode%)"]                            = "\$text = 'Säumnisgebühr (Barcode=%barcode%)';";

?>
