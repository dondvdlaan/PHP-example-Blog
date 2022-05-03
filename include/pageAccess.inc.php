<?php
#***************************************************************************************#


				#****************************************#
				#********** SECURE PAGE ACCESS **********#
				#****************************************#
				
				/*
					Für die Fortsetzung der Session muss hier der gleiche Name ausgewählt werden,
					wie beim Login-Vorgang, damit die Seite weiß, welches Cookie sie vom Client auslesen soll
				*/
				session_name('blog');
				
				
				#********** START SESSION **********#
				/*
					Der Befehl session_start() liest zunächst ein Cookie aus dem Browser des Clients aus,
					das den Nanem des im oberen Schritts gesetzten Sessionnamens entspricht. Existiert
					dieses Cookie, wird aus ihm der Name der zugehörigen Sessiondatei ausgelesen und geprüft,
					ob diese auf dem Server existiert. Ist beides der Fall, wird die bestehende Session fortgesetzt.
					
					Existieren Cookie oder Sessiondatei nicht, wird an dieser Stelle eine neue Session
					gestartet: Der Browser erhält ein frisches Cookie mit dem oben gesetzten Namen, und auf dem Server
					wird eine neue, leere Sessiondatei erstellt, deren Dateinamen in das Cookie geschrieben wird.
				*/
				if( session_start() === false ) {
					// Fehlerfall
if(DEBUG_I)		echo "<p class='debugInclude err'><b>Line " . __LINE__ . "</b>: FEHLER beim Starten der Session! <i>(" . basename(__FILE__) . ")</i></p>\n";				
										
				} else {
					// Erfolgsfall
if(DEBUG_I)		echo "<p class='debugInclude ok'><b>Line " . __LINE__ . "</b>: Session erfolgreich gestartet. <i>(" . basename(__FILE__) . ")</i></p>\n";				

if(DEBUG_I)		echo "<pre class='debugInclude value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_I)		print_r($_SESSION);					
if(DEBUG_I)		echo "</pre>";
					
					#********** CHECK FOR VALID LOGIN **********#
					/*
						Ohne erfolgten Login ist das SESSION-Array an dieser Stelle leer.
						Bei erfolgtem Login beinhaltet das SESSION-Array an dieser Stelle 
						den beim Login-Vorgang vergebenen Index, der hier auf Existenz geprüft wird.
					*/
					
					#********** A) NO VALID LOGIN **********#
					/*
						SICHERHEIT: Um Session Hijacking und ähnliche Identitätsdiebstähle zu verhindern,
						wird die IP-Adresse des sich einloggenden Users geloggt und mit der beim Loginvorgang
						in die Session gespeicherten IP-Adresse abgeglichen.
						Eine IP-Adresse zu fälschen ist nahezu unmöglich. Wenn sich also der Dieb von einer
						anderen IP-Adresse aus einloggen will, wird ihm hier der Zutritt verweigert.
					*/
					if( !isset($_SESSION['userID']) OR $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] ) {
						// Fehlerfall | User ist nicht eingeloggt
if(DEBUG_I)			echo "<p class='debugInclude err'><b>Line " . __LINE__ . "</b>: User ist NICHT eingeloggt! <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						
						#********** DENY PAGE ACCESS **********#
						// 1. Leere neu erstellte Session gleich wieder löschen
						session_destroy();
						// 2. User auf Index-Seite zurückleiten
						header('LOCATION: index.php');
						/*
							3. Fallback, falls Redirect nicht funktionieren sollte:
							exit beendet sofort die Ausführung des Skripts
						*/
						exit;						
					

					#********** B) VALID LOGIN **********#
					} else {
						// Erfolgsfall | User ist eingeloggt
if(DEBUG_I)			echo "<p class='debugInclude ok'><b>Line " . __LINE__ . "</b>: User ist eingeloggt. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						
						#********** IDENTIFY USER **********#
						$userID = $_SESSION['userID'];
if(DEBUG_I)			echo "<p class='debugInclude value'><b>Line " . __LINE__ . "</b>: \$userID: $userID <i>(" . basename(__FILE__) . ")</i></p>\n";
						
						
						/*
							SICHERHEIT: Um Cookiediebstahl oder Session Hijacking vorzubeugen, wird nach erfolgreicher
							Authentifizierung eine neue Session-ID vergeben. Ein Hacker, der zuvor ein Cookie mit einer 
							gültigen Session-ID erbeutet hat, kann dieses nun nicht mehr benutzen.
							Die Session-ID muss bei jedem erfolgreichem Login und bei jedem Logout erneuert werden, um
							einen effektiven Schutz zu bieten.
							
							Um die alte Session mit der alten (abgelaufenen) ID gleich zu löschen und eine neue Session
							mit einer neuen ID zu generieren, muss session_regenerate_id() den optionalen Parameter 
							delete_old_session=true erhalten.
						*/
						session_regenerate_id(true);
						
					} // CHECK FOR VALID LOGIN END
					
				} // SECURE PAGE ACCESS END


#***************************************************************************************#
?>