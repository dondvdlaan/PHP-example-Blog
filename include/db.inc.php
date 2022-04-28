<?php
#******************************************************************************************************#


				/**
				*
				*	Will connect to database by way of PDO
				*	Configuration and log in data come from config file
				*
				*	@param [String $dbname=DB_NAME]			Name of DB to be connected
				*
				*	@return Object							DB-Connectionobjekt
				*
				*/
				function dbConnect($dbname=DB_NAME) {
					
					/*
						Eine statische Variable existiert nur in einem lokalen Funktions-Geltungsbereich, 
						der Wert geht beim Verlassen dieses Bereichs aber nicht verloren. D.h. dass bei einem erneuten Aufruf der Funktion
						die Variable noch immer existiert. Somit kann geprüft werden, ob bereits eine offene Datenbankverbindung existiert,
						um unnötige Neu- bzw. Mehrfachverbindungen zu vermeiden.
					*/
					// Aus Sicherheitsgründen sollte man von einer solchen Lösung jedoch besser absehen
					// static $PDO;
					
					// Establish new DB connection, when none is in plce
					if( !isset($PDO) ) {
if(DEBUG_DB)		echo "<p class='debugDb'>📑 <b>Line " . __LINE__ . ":</b> Versuche mit der DB '<b>$dbname</b>' zu verbinden... <i>(" . basename(__FILE__) . ")</i></p>\r\n";					

						// EXCEPTION-HANDLING (Umgang mit Fehlern)
						// Versuche, eine DB-Verbindung aufzubauen
						try {
							// wirft, falls fehlgeschlagen, eine Fehlermeldung "in den leeren Raum"
							
							// $PDO = new PDO("mysql:host=localhost; dbname=market; charset=utf8mb4", "root", "");
							$PDO = new PDO(DB_SYSTEM . ":host=" . DB_HOST . "; dbname=$dbname; charset=utf8mb4", DB_USER, DB_PWD);
						
						// falls eine Fehlermeldung geworfen wurde, wird sie hier aufgefangen					
						} catch(PDOException $error) {
							// Ausgabe der Fehlermeldung
if(DEBUG_DB)			echo "<p class='error'><b>Line " . __LINE__ . ":</b> <i>FEHLER: " . $error->GetMessage() . " </i> <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							// Skript abbrechen
							exit;
						}
						// Falls das Skript nicht abgebrochen wurde (kein Fehler), geht es hier weiter
if(DEBUG_DB)		echo "<p class='debugDb ok'><b>Line " . __LINE__ . ":</b> Erfolgreich mit der DB '<b>$dbname</b>' verbunden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
					} else {
if(DEBUG_DB)		echo "<p class='debugDb hint'>📑 <b>Line " . __LINE__ . ":</b> Es ist bereits eine Datenbankverbindung aktiv. <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
						
					}

					// DB-Verbindungsobjekt zurückgeben
					return $PDO;
				}
				
				
#******************************************************************************************************#
?>