<?php
#********************************************************************************************#
				/**
				*	Replaces potential dangerous tokens (< > " ' &) of a forwarded String
				*	with HTML-entities and removes all Whitespaces before and after the String.
				*	An empty String is replaced by NULL
				*
				*	@param	String	$value			Forwarded String
				*
				*	@return	NULL|String				NULL at empty String | Neutralised and cleaned String
				*
				*/
				function cleanString($value) {
if(DEBUG_F)		echo "<p class='debugCleanString'>🌀 <b>Line " . __LINE__ . "</b>: Calling " . __FUNCTION__ . "('$value') <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					/*
						trim() removes before and after the String(not unside) 
						all so-called Whitespaces(empty spaces, tabs, CR)
					*/
					$value = trim($value);
					
					$value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
					
					/*
						Empty String is converted in NULL 
					*/
					if( $value === '' ) {
						$value = NULL;
					}
					
					return $value;
				}
				

#********************************************************************************************#
				/**
				* 	Checks forwarded String on minium- and maxium length, as well optionally on
				*	empty String.
				*	Error is generated in case of empty String or unvalid length
				*
				*	@param	String		$value							forwarded String
				*	@param	Bool		$mandatory=true					toggle mandatory field	
				*	@param	Integer		$minLength=INPUT_MIN_LENGTH		minimum length to be checked								
				*	@param	Integer		$maxLength=INPUT_MAX_LENGTH		maximum length to be checked								
				*
				*	@return	String|NULL									error message | else NULL
				*
				*/
				function checkInputString($value, $mandatory=true, $minLength=INPUT_MIN_LENGTH, $maxLength=INPUT_MAX_LENGTH) {
if(DEBUG_F)		echo "<p class='debugCheckInputString'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value' | [$minLength | $maxLength] | mandatory: $mandatory) <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					// Constants
					$ERROR_MANDATORY_FIELD = 'This is a mandatory field!';
					$ERROR_MINIMUM_LENGTH  = 'Shall hava a minimum length of %d characters!'
					$ERROR_MAXIMUM_LENGTH  = 'Shall hava a maximum length of %d characters!'

					/*
						Variable is false when: empty String, Integer 0. Float 0.0, NULL, empty array or false
						Exception: (!) Null ('0') are false, '00' is true.
					*/
					// Optional (when $mandatory===true): Check empty String or NULL
					#********** MANDATORY CHECK **********#
					if( $mandatory === true AND ($value === '' OR $value === NULL) ) {  // $value === NULL muss ergänzt werden, wenn cleanString() auf NULL-Rückgabe umgestellt wird.
						// error case
						return $ERROR_MANDATORY_FIELD;
						
					
					#********** MINIMUM LENGTH CHECK **********#
					} elseif( mb_strlen($value) < $minLength ) {
						// error case
						return sprintf($ERROR_MINIMUM_LENGTH, $minLength);
						
						
					#********** MAXIMUM LENGTH CHECK **********#
					} elseif( mb_strlen($value) > $maxLength ) {
						// error case
						return sprintf($ERROR_MAXIMUM_LENGTH, $maxLength);
						
					
					#********** STRING IS VALID **********#
					} else {
						// success case
						return NULL;
					}				
				}

#********************************************************************************************#
				/**
				*	Checks forwarded String on empty String and maximum length and if
				*	Email is valid.
				*	Error message is generated in each case.
				*
				*	@param	String	$value							forwarded String
				*	@param	Bool	$mandatory=true					mandatory field	
				*	@param	Integer	$maxLength=INPUT_MAX_LENGTH		maximum length to be checked
				*
				*	@return	String|NULL								error message | else NULL
				*
				*/
				function validateEmail($value, $mandatory=true, $minLength=INPUT_MIN_LENGTH, $maxLength=INPUT_MAX_LENGTH) {
if(DEBUG_F)		echo "<p class='debugValidateEmail'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value' | [$minLength | $maxLength] | mandatory: $mandatory) <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					// Constants
					$ERROR_EMAIL_FIELD = 'This is not a valid Email';
					
					#********** VALIDATE MANDATORY AND MAXIMUM LENGTH **********#
					// Checks on empty String and length
					if( $error = checkInputString($value, $mandatory, $minLength, $maxLength) ) {
						// error case
						return $error;
						
					
					#********** VALIDATE EMAIL ADDRESS **********#
					} elseif( filter_var($value, FILTER_VALIDATE_EMAIL) === false ) {
						// error case
						return $ERROR_EMAIL_FIELD;
					
					
					#********** STRING IS VALID EMAIL ADDRESS **********#
					} else {
						// success case
						return NULL;
					}
				}

#********************************************************************************************#
				/**
				*	Validiert ein auf den Server geladenes Bild, generiert einen unique Dateinamen
				*	sowie eine sichere Dateiendung und verschiebt das Bild in ein anzugebendes Zielverzeichnis.
				*	Validiert werden der aus dem Dateiheader ausgelesene MIME-Type, die aus dem Dateiheader
				*	ausgelesene Bildgröße in Pixeln sowie die ermittelte Dateigröße. 
				*	Der Dateiheader wird außerdem auf Plausibilität geprüft.
				*
				*	@param	String	$fileTemp														Der temporäre Pfad zum hochgeladenen Bild im Quarantäneverzeichnis
				*	@param	Integer	$imageMaxWidth=IMAGE_MAX_WIDTH							Die maximal erlaubte Bildbreite in Pixeln
				*	@param	Integer	$imageMaxHeight=IMAGE_MAX_HEIGHT							Die maximal erlaubte Bildhöhe in Pixeln
				*	@param	Integer	$imageMaxSize=IMAGE_MAX_SIZE								Die maximal erlaubte Dateigröße in Bytes
				*	@param	String	$imageUploadPath=IMAGE_UPLOAD_PATH						Das Zielverzeichnis
				*	@param	Array		$imageAllowedMimeTypes=IMAGE_ALLOWED_MIME_TYPES		Whitelist der zulässigen MIME-Types mit den zugehörigen Dateiendungen
				*	@param	Integer	$imageMinSize=IMAGE_MIN_SIZE								Die minimal erlaubte Dateigröße in Bytes
				*
				*	@return	Array		{'imagePath'	=>	String|NULL, 							Bei Erfolg der Speicherpfad zur Datei im Zielverzeichnis | bei Fehler NULL
				*							 'imageError'	=>	String|NULL}							Bei Erfolg NULL | Bei Fehler Fehlermeldung
				*
				*/
				function imageUpload( $fileTemp,
											 $imageMaxWidth				= IMAGE_MAX_WIDTH,
											 $imageMaxHeight				= IMAGE_MAX_HEIGHT,
											 $imageMaxSize					= IMAGE_MAX_SIZE,
											 $imageUploadPath				= IMAGE_UPLOAD_PATH,
											 $imageAllowedMimeTypes		= IMAGE_ALLOWED_MIME_TYPES,
											 $imageMinSize					= IMAGE_MIN_SIZE
											) {
if(DEBUG_F)		echo "<p class='debugImageUpload'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$fileTemp') <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					
					#***************************************************************************#
					#********** GATHER INFORMATION FOR IMAGE FILE VIA THE FILE HEADER **********#
					#***************************************************************************#
					
					/*
						Die Funktion getimagesize() liest den Dateiheader einern Bilddatei aus und 
						liefert bei gültigem MIME Type ('image/...') ein gemischtes Array zurück:
						
						[0] 				Bildbreite in PX 
						[1] 				Bildhöhe in PX 
						[3] 				Einen für das HTML <img>-Tag vorbereiteten String (width="480" height="532") 
						['bits']			Anzahl der Bits pro Kanal 
						['channels']	Anzahl der Farbkanäle (somit auch das Farbmodell: RGB=3, CMYK=4) 
						['mime'] 		MIME Type
						
						Bei ungültigem MIME Type (also nicht 'image/...') liefert getimagesize() false zurück
					*/
					$imageDataArray = getimagesize($fileTemp);
/*					
if(DEBUG_V)		echo "<pre class='debugImageUpload value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)		print_r($imageDataArray);					
if(DEBUG_V)		echo "</pre>";
*/					
					
					#********** CHECK FOR VALID MIME TYPE **********#
					if( $imageDataArray === false ) {
						// Fehlerfall (MIME TYPE is not valid)
						/*
							Bildwerte auf NULL setzen, damit die Variablen für die nachfolgenden
							Validierungen exitieren und zu korrekten Fehlermeldungen führen
						*/
						$imageWidth = $imageHeight = $imageMimeType = $fileSize = NULL;
					

					#********** FETCH FILE INFOS **********#
					} elseif( is_array($imageDataArray) === true ) {
						// Erfolgsfall (MIME TYPE is valid)
						
						$imageWidth 	= $imageDataArray[0];			// image width in px via getimagesize()
						$imageHeight 	= $imageDataArray[1];			// image height in px via getimagesize()
						$imageMimeType	= $imageDataArray['mime'];		// image mime type via getimagesize()
						$fileSize		= filesize($fileTemp);			// image size in bytes via filesize()
					}
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$imageWidth: $imageWidth px <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$imageHeight: $imageHeight px <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$imageMimeType: $imageMimeType <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$fileSize: " . round($fileSize/1024, 2) . " kB <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					#*************************************************#
					
					
					#**************************************#
					#********** IMAGE VALIDATION **********#
					#**************************************#
					
					// Whitelist mit erlaubten MIME TYPES und Dateiendungen
					// $imageAllowedMimeTypes = array('image/jpg' => '.jpg', 'image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif');
					
					/*
						Da Schadcode häufig nur wenige Zeilen lang ist, ist eine zu kleine
						Dateigröße per se verdächtig. Brauchbare Bilddateien beginnen bei
						etwa 1kB Dateigröße (ca. 80-100Bytes für Icons).
						Außerdem wird gleich geprüft, ob ein Hacker womöglich den MIME Type
						im Dateiheader manipuliert hat. Bilder verfügen immer über eine Größenangabe
						in Pixeln, die vom Hacker manchmal vergessen wird, ebenfalls in den manipulierten
						Header einzufügen. Wenn die Bildgrößenangaben keinen Wert besitzen, muss von einem
						manipulierten Dateiheader ausgegangen werden.
						
						Sollte getimagesize() aufgrund eines falschen MIME Types 'false' zurückgeliefert haben,
						wurden im vorherigen Schritt alle Variablenwerte auf NULL gesetzt und führen hier 
						automatisch zum Fehlerfall.
					*/
					#********** CHECK IF FILE HEADER IS PLAUSIBLE **********#
					if( $fileSize < $imageMinSize OR $imageWidth === NULL OR $imageHeight === NULL OR $imageMimeType === NULL ) {
						// Fehlerfall 1: Potentiell verdächtiger Dateiheader
						$errorMessage = 'Potentielles Schadskript entdeckt!';
					
						
					#********** CHECK FOR VALID MIME TYPE **********#
					/*
						Der optionale 3. Parameter der in_array()-Funktion erzwingt einen strikten Wertevergleich, 
						damit '0' und '' nicht als gleich interpretiert werden.
						Er sollte aus Sicherheitsgründen immer gesetzt werden.
						in_array() liefert 'true' zurück, wenn die Needle im Array gefunden wurde, ansonsten 'false'.
					*/
					} elseif( in_array($imageMimeType, array_keys($imageAllowedMimeTypes), true) === false ) {
						// Fehlerfall 2: Unerlaubter MIME TYPE
						$errorMessage = 'Dies ist kein erlaubter Bildtyp!';
					
					
					#********** VALIDATE IMAGE WIDTH **********#
					} elseif( $imageWidth > $imageMaxWidth ) {
						// Fehlerfall 3: Bildbreite zu groß
						$errorMessage = "Die Bildbreite darf maximal $imageMaxWidth Pixel betragen!";
					
					
					#********** VALIDATE IMAGE HEIGHT **********#
					} elseif( $imageHeight > $imageMaxHeight ) {
						// Fehlerfall 4: Bildhöhe zu groß
						$errorMessage = "Die Bildhöhe darf maximal $imageMaxHeight Pixel betragen!";
						
						
					#********** VALIDATE FILE SIZE **********#	
					} elseif( $fileSize > $imageMaxSize ) {
						// Fehlerfall 5: Dateigröße zu groß
						$errorMessage = 'Die Dateigröße darf maximal ' . $imageMaxSize/1024 . 'kB betragen!';
						
					
					#********** ALL CHECKS ARE PASSED **********#
					} else {
						// Erfolgsfall
						$errorMessage = NULL;
					}
					
					#*************************************************#
					
					
					#********** FINAL IMAGE VALIDATION **********#
					if( $errorMessage !== NULL ) {
						// Fehlerfall
if(DEBUG_F)			echo "<p class='debugImageUpload err'><b>Line " . __LINE__ . "</b>: $errorMessage <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						/*
							Da die Verzweigung im Fehlerfall an dieser Stelle verlassen wird, die Variable
							$fileTarget aber fester Bestandteil des Return-Wertes ist, muss sie an dieser 
							Stelle initialisiert werden, da sie ansonsten nicht existiert.
						*/
						// Initialize $fileTarget
						$fileTarget = NULL;
						
					} else {
						// Erfolgsfall
if(DEBUG_F)			echo "<p class='debugImageUpload ok'><b>Line " . __LINE__ . "</b>: Die Bildvalidierung ergab keinen Fehler. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						
						#**********************************************************#
						#********** PREPARE IMAGE FOR PERSISTANT STORING **********#
						#**********************************************************#
						
						/*
							Da der Dateiname selbst Schadcode in Form von ungültigen oder versteckten Zeichen,
							doppelte Dateiendungen (dateiname.exe.jpg) etc. beinhalten kann, darüberhinaus ohnehin 
							sämtliche, nicht in einer URL erlaubten Sonderzeichen und Umlaute entfernt werden müssten 
							sollte der Dateiname aus Sicherheitsgründen komplett neu generiert werden.
							
							Hierbei muss außerdem bedacht werden, dass die jeweils generierten Dateinamen unique
							sein müssen, damit die Dateien sich bei gleichem Dateinamen nicht gegenseitig überschreiben.
						*/
						
						#********** GENERATE UNIQUE FILE NAME **********#
						/*
							- 	mt_rand() stellt die verbesserte Version der Funktion rand() dar und generiert 
								Zufallszahlen mit einer gleichmäßigeren Verteilung über das Wertesprektrum. Ohne zusätzliche
								Parameter werden Zahlenwerte zwischen 0 und dem höchstmöglichem von mt_rand() verarbeitbaren 
								Zahlenwert erzeugt.							
							- 	str_shuffle mischt die Zeichen eines übergebenen Strings zufällig durcheinander.
							- 	microtime() liefert einen Timestamp mit Millionstel Sekunden zurück (z.B. '0.57914300 163433596'),
								aus dem für eine URL-konforme Darstellung der Dezimaltrenner und das Leerzeichen entfernt werden.
						*/
						$fileName = mt_rand() . '_' . str_shuffle('abcdefghijklmnopqrstuvwxyz_-0123456789') . '_' . str_replace( array('.', ' '), '', microtime());
						
						
						#********** GENERATE FILE EXTENSION **********#
						/*
							Aus Sicherheitsgründen wird nicht die ursprüngliche Dateinamenerweiterung aus dem
							Dateinamen verwendet, sondern eine vorgenerierte Dateiendung aus dem Array der 
							erlaubten MIME Types.
							Die Dateiendung wird anhand des ausgelesenen MIME Types [key] ausgewählt.
						*/
						$fileExtension = $imageAllowedMimeTypes[$imageMimeType];
						
						
						#********** GENERATE FILE TARGET **********#
						/*
							Endgültigen Speicherpfad auf dem Server generieren:
							destinationPath/fileName + fileExtension
						*/
						$fileTarget = $imageUploadPath . $fileName . $fileExtension;						
					
					
if(DEBUG_V)			echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$fileTarget: <i>'$fileTarget'</i> <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)			echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: Länge des Pfades: " . strlen($fileTarget) . " <i>(" . basename(__FILE__) . ")</i></p>\n";
					
						#*************************************************#
						
						
						#*****************************************************#
						#********** MOVE IMAGE TO FINAL DESTINATION **********#
						#*****************************************************#
						
						/*
							move_uploaded_file() verschiebt eine hochgeladene Datei an einen 
							neuen Speicherort und benennt die Datei um
						*/
						if( move_uploaded_file($fileTemp, $fileTarget) === false ) {
							// Fehlerfall
if(DEBUG_F)				echo "<p class='debugImageUpload err'><b>Line " . __LINE__ . "</b>: FEHLER beim Verschieben der Datei von '$fileTemp' nach '$fileTarget'! <i>(" . basename(__FILE__) . ")</i></p>\n";				
							$errorMessage = 'Beim Speichern des Bildes ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.';
							
							// Lösche $fileTarget
							$fileTarget = NULL;
							
						} else {
							// Erfolgsfall
if(DEBUG_F)				echo "<p class='debugImageUpload ok'><b>Line " . __LINE__ . "</b>: Datei erfolgreich von <i>'$fileTemp'</i> nach <i>'$fileTarget'</i> verschoben. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						} // MOVE IMAGE TO FINAL DESTINATION END					
						#*************************************************#
					
					} // FINAL IMAGE VALIDATION END
					
					#*************************************************#
					
					#********** RETURN ARRAY CONTAINING EITHER IMAGE PATH OR ERROR MESSAGE **********#
					return array( 'imagePath' => $fileTarget, 'imageError' => $errorMessage );
					
					#*************************************************#
					
				}


#********************************************************************************************#
?>


















