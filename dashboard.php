<?php
#***************************************************************************************#

				#****************************************#
				#********** PAGE CONFIGURATION **********#
				#****************************************#
				
				require_once('./include/config.inc.php');
				require_once('./include/form.inc.php');
				require_once('./include/db.inc.php');

                #*************************	***************#
				#********** SECURE PAGE ACCESS **********#
				#****************************************#
				
				require_once('include/pageAccess.inc.php');

                #******************************************#
				#********** INITIALIZE VARIABLES **********#
				#******************************************#
				$errorCategory					= NULL;
				
				$errorCatID						= NULL;
				$errorTitle						= NULL;
				$errorBlogText					= NULL;
				$title							= NULL;
				$blogText						= NULL;


				$dbSuccess						= NULL;
			
				$errorImageUpload				= NULL;
				$uploadedFilePath				= NULL;
                #********** LOGIN CONFIGURATION **********#
				$loggedIn                       = true;


#***************************************************************************************#
				#********** PROCESS URL PARAMETERS **********#
				
				#********** PREVIEW GET ARRAY **********#
if(DEBUG_V)	echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)	print_r($_GET);					
if(DEBUG_V)	echo "</pre>";
				#****************************************#
				
				// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde
				if( isset($_GET['action']) ) {
if(DEBUG)		echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\n";										
										
					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$action = cleanString($_GET['action']);
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$action: $action <i>(" . basename(__FILE__) . ")</i></p>\n";
										
					// Schritt 3 URL: Verzweigung
										
					#********** LOGOUT **********#
					if( $action === 'logout' ) {
if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Logout wird durchgeführt... <i>(" . basename(__FILE__) . ")</i></p>\n";
											
						// Schritt 4 URL: Daten weiterverarbeiten
											
						session_regenerate_id(true);
											
						// Löschen aller Session-Variablen.
						$_SESSION = array();
						// 1. Bestehende Session löschen
						session_destroy();
						// 2. User auf Index-Seite umleiten
						header('LOCATION: index.php');
						/*
						3. Fallback, falls Redirect nicht funktionieren sollte:
						exit beendet sofort die Ausführung des Skripts
						*/
						exit;
						
					} // LOGOUT END	
					
				} // PROCESS URL PARAMETERS END


#***************************************************************************************#
				#********** PROCESS FORM CATEGORY **********#
				
				#********** PREVIEW POST ARRAY **********#

if(DEBUG_V)	echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)	print_r($_POST);					
if(DEBUG_V)	echo "</pre>";

                #****************************************#
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				if( isset($_POST['formCategory']) ) {
if(DEBUG)		echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: Formular 'Kategory' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\n";										
                                        
                // Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Werte auslesen und entschärfen... <i>(" . basename(__FILE__) . ")</i></p>\n";
                    
                $category 	= cleanString( $_POST['category'] );
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$category: $category <i>(" . basename(__FILE__) . ")</i></p>\n";
                                        
                // Schritt 3 FORM: Feldvalidierung
if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Feldwerte werden validiert... <i>(" . basename(__FILE__) . ")</i></p>\n";
                                        
                $errorCategory 	= checkInputString($category, maxLength:30);
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$errorCategory: $errorCategory <i>(" . basename(__FILE__) . ")</i></p>\n";
                                        
                                        
                #********** FINAL FORM VALIDATION **********#
                if( $errorCategory !== NULL ) {
                    // Fehlerfall
if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\n";				
                                            
                } else {
                    // Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei. <i>(" . basename(__FILE__) . ")</i></p>\n";				
                                            
                	// Schritt 4 FORM: Daten weiterverarbeiten
                                            
                    #********** VALIDATE CATEGORY **********#

                    #********** DB OPERATION **********#
                                            
                    // Schritt 1 DB: DB-Verbindung herstellen
                    $PDO = dbConnect('blog');
                                            
                    #********** CHECK IF CATEGORY ALREADY EXISTS **********#
if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Lese Kategorie zum Abgleicehn aus... <i>(" . basename(__FILE__) . ")</i></p>\n";
                                            
                    $sql 		= 'SELECT count(catLabel)
                                    FROM categories
                                    WHERE catLabel = :ph_category';
                                            
                    $params 	= array( 'ph_category' => $category );
                                            
                    // Schritt 2 DB: SQL-Statement vorbereiten
                    $PDOStatement = $PDO->prepare($sql);
                                            
                    // Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
                         try {	
                            $PDOStatement->execute($params);						
                        } catch(PDOException $error) {
if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
                            $dbError = 'Fehler beim Zugriff auf die Datenbank!';
                        }
                                                
                    	// Schritt 4 DB: Daten weiterverarbeiten
                    	/*
                   		Bei SELECT COUNT(): Rückgabewert von COUNT() über $PDOStatement->fetchColumn() auslesen
						*/
							$count = $PDOStatement->fetchColumn();
if(DEBUG_V)				echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$count: $count <i>(" . basename(__FILE__) . ")</i></p>\n";
														
						if( $count > 0 ) {
							// Fehlerfall
if(DEBUG)					echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Der Kategory '$category' ist bereits in der DB registriert! <i>(" . basename(__FILE__) . ")</i></p>\n";				
															
							// Fehlermeldung an User
							$errorCategory = 'Es existiert bereits eine gültige Kategorie!';							
															
						} else {
							// Erfolgsfall
if(DEBUG)					echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Der Kategorie '$category' ist noch nicht in der DB registriert. <i>(" . basename(__FILE__) . ")</i></p>\n";				
							
							#********** SAVE CATEGORY **********#							
							
							// Schritt 1 DB: DB-Verbindung herstellen
							// $PDO = dbConnect('benutzerverwaltung');
							
if(DEBUG)					echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Speichere Kategorie... <i>(" . basename(__FILE__) . ")</i></p>\n";
								
							$sql 		= 'INSERT INTO categories (catLabel)
											VALUES (:ph_catLabel)';
								
							$params 	= array( 'ph_catLabel' 	=> $category);
								
							// Schritt 2 DB: SQL-Statement vorbereiten
							$PDOStatement = $PDO->prepare($sql);
								
							// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
							try {	
								$PDOStatement->execute($params);						
							} catch(PDOException $error) {
if(DEBUG)						echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
								$dbError = 'Fehler beim Zugriff auf die Datenbank!';
							}
								
							// Schritt 4 DB: Daten weiterverarbeiten
							/*
								Bei schreibenden Operationen (INSERT/UPDATE/DELETE):
								Schreiberfolg prüfen anhand der Anzahl der betroffenen Datensätze
							*/
							$rowCount = $PDOStatement->rowCount();
if(DEBUG_V)					echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
					
							if( $rowCount !== 1 ) {
									// Fehlerfall
if(DEBUG)							echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Speichern des Userdatensatzes! <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
									// Fehlermeldung an User
									$dbError = 'Es ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.';
									
							} else {
									// Erfolgsfall
									/*
										Bei einem INSERT die Last-Insert-ID nur nach geprüftem Schreiberfolg auslesen. 
										Im Zweifelsfall wird hier sonst die zuletzt vergebene ID aus einem älteren 
										Schreibvorgang zurückgeliefert.
									*/
								$newCategoryID = $PDO->lastInsertId();
if(DEBUG)							echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Userdatensatz erfolgreich unter ID$newCategoryID gespeichert. <i>(" . basename(__FILE__) . ")</i></p>\n";				

									// Erfolgsmeldung an User
								$dbSuccess = "Ihre Kategorie $category war erfolgreich gespeichert.";

								// DB-Verbindung beenden
								unset($PDO);

								} // END #********** SAVE CATEGORY **********#	
							} // END #********** CHECK CATEGORY ALREADY EXISTS **********#
						} // END #********** VALIDATE FORM CATEGORY **********#
					} // END #********** PROCESS FORM CATEGORY **********#

#*******************************************************************************************#
					#********** FETCH CATEGORIES FOR SELECT FIELD **********#

                    #********** DB OPERATION **********#
                                            
                    // Schritt 1 DB: DB-Verbindung herstellen
                    $PDO = dbConnect('blog');
                                            
                    #********** SELECT ALL CATEGORIES **********#
if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Lese Kategorie für Select Field aus... <i>(" . basename(__FILE__) . ")</i></p>\n";
                                            
                    $sql 		= 'SELECT *
                                    FROM categories';
                                            
                    $params 	= array();
                                            
                    // Schritt 2 DB: SQL-Statement vorbereiten
                    $PDOStatement = $PDO->prepare($sql);
                                            
                    // Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
                    try {	
                    	$PDOStatement->execute();						
                    } catch(PDOException $error) {
if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
                        $dbError = 'Fehler beim Zugriff auf die Datenbank!';
                    }
                                                
                    // Schritt 4 DB: Daten weiterverarbeiten
                    	
					$categories = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

// if(DEBUG_V)			echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)			print_r($categories);					
// if(DEBUG_V)			echo "</pre>";
														
					// Zählen, wieviele Datensätze zurückgeliefert wurden
					$rowCount = $PDOStatement->rowCount();
if(DEBUG_V)			echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					// DB-Verbindung beenden
					unset($PDO);			
						
#*******************************************************************************************#
					#********** FETCH USER DETAILS FOR GREETING MESSAGE **********#

                    #********** DB OPERATION **********#
                                            
                    // Schritt 1 DB: DB-Verbindung herstellen
                    $PDO = dbConnect('blog');
                                            
                    #********** SELECT USER DETAILS **********#
if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Lese Userdetails aus... <i>(" . basename(__FILE__) . ")</i></p>\n";
                                            
                    $sql 		= 'SELECT userFirstName, userLastName
                                    FROM users
									WHERE userID = :ph_userID';
                                            
                    $params 	= array('ph_userID' => $userID);
                                            
                    // Schritt 2 DB: SQL-Statement vorbereiten
                    $PDOStatement = $PDO->prepare($sql);
                                            
                    // Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
                    try {	
                    	$PDOStatement->execute($params);						
                    } catch(PDOException $error) {
if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
                        $dbError = 'Fehler beim Zugriff auf die Datenbank!';
                    }
                                                
                    // Schritt 4 DB: Daten weiterverarbeiten
                    	
					$userDetails = $PDOStatement->fetch(PDO::FETCH_ASSOC);

if(DEBUG_V)			echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)			print_r($userDetails);					
if(DEBUG_V)			echo "</pre>";
														
					// Zählen, wieviele Datensätze zurückgeliefert wurden
					$rowCount = $PDOStatement->rowCount();
if(DEBUG_V)			echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					// Zusammenstllen Willkommensnachricht
					$welcomeMessage = 'Willkommen '.$userDetails['userFirstName'].' '.$userDetails['userLastName'];

					// DB-Verbindung beenden
					unset($PDO);			
						
#*******************************************************************************************#				
				#********** PROCESS FORM BLOGS **********#
				
				#********** PREVIEW POST ARRAY **********#

// if(DEBUG_V)	echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)	print_r($_POST);					
// if(DEBUG_V)	echo "</pre>";

                #****************************************#
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				if( isset($_POST['formBlog']) ) {
if(DEBUG)		echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: Formular 'Blog' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\n";										
                                        
                // Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Werte auslesen und entschärfen... <i>(" . basename(__FILE__) . ")</i></p>\n";

                $catID 			= cleanString( $_POST['catID'] );
                $title 			= cleanString( $_POST['title'] );
                $blogText 		= cleanString( $_POST['blogText'] );
                $imagePosition	= cleanString( $_POST['imagePosition'] );

if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$userID: $userID <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$catID: $catID <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$title: $title <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$blogText: $blogText <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$imagePosition: $imagePosition <i>(" . basename(__FILE__) . ")</i></p>\n";
                                        
                // Schritt 3 FORM: Feldvalidierung
if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Feldwerte werden validiert... <i>(" . basename(__FILE__) . ")</i></p>\n";
                                        
                $errorCatID 			= checkInputString($catID);
                $errorimagePosition 	= checkInputString($imagePosition);
                $errorTitle 			= checkInputString($title, maxLength:50);
                $errorBlogText 			= checkInputString($blogText, minLength:10, maxLength:10000);
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$errorCategory: $errorCategory <i>(" . basename(__FILE__) . ")</i></p>\n";
                                        
                                        
                #********** FINAL FORM VALIDATION **********#
                if( $errorCatID !== NULL OR $errorTitle !== NULL OR $errorBlogText !== NULL OR $errorimagePosition !== NULL) {
                    // Fehlerfall
if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\n";				
                                            
                } else {
                    // Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei. <i>(" . basename(__FILE__) . ")</i></p>\n";				

						#**********************************#
						#********** IMAGE UPLOAD **********#
						#**********************************#					

if(DEBUG_V)			echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)			print_r($_FILES);					
if(DEBUG_V)			echo "</pre>";
						
						#********** CHECK IF IMAGE UPLOAD IS ACTIVE **********#
						if( $_FILES['fileUpload']['tmp_name'] === '') {
							// image upload is not active
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Bildupload ist NICHT aktiv. <i>(" . basename(__FILE__) . ")</i></p>\n";				
							
						} else {
							// image upload is active
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Bildupload ist aktiv. <i>(" . basename(__FILE__) . ")</i></p>\n";				
							
							$imageUploadReturnArray = imageUpload( $_FILES['fileUpload']['tmp_name'] );
						
if(DEBUG_V)				echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)				print_r($imageUploadReturnArray);					
if(DEBUG_V)				echo "</pre>";
						
						#********** VALIDATE IMAGE UPLOAD **********#
						if( $imageUploadReturnArray['imageError'] !== NULL AND $imageUploadReturnArray['imagePath'] === NULL ) {
						// Fehlerfall
if(DEBUG)					echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Bildupload: <i>'$imageUploadReturnArray[imageError]'</i> <i>(" . basename(__FILE__) . ")</i></p>\n";				
						$errorImageUpload = $imageUploadReturnArray['imageError'];
	
						} else {
						// Erfolgsfall
if(DEBUG)					echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Bild wurde erfolgreich unter <i>'$imageUploadReturnArray[imagePath]'</i> gespeichert. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						// Neuen Bildpfad in Variable speichern
						$uploadedFilePath = $imageUploadReturnArray['imagePath'];
						} // END VALIDATE IMAGE UPLOAD

						} // END FILE UPLOAD IMAGE

						#********** FINAL IMAGE UPLOAD VALIDATION **********#
						if( $errorImageUpload !== NULL ) {
						// Fehlerfall
if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FINAL IMAGE UPLOAD VALIDATION: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\n";				
	
						} else {
						// Erfolgsfall
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: FINAL IMAGE UPLOAD VALIDATION: Das Formular ist formal fehlerfrei. <i>(" . basename(__FILE__) . ")</i></p>\n";				
	
					#********** SAVE BLOG TO DB **********#							
							
					// Schritt 1 DB: DB-Verbindung herstellen
					 $PDO = dbConnect('blog');
							
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Speicheren Blog... <i>(" . basename(__FILE__) . ")</i></p>\n";
								
					$sql 		= 'INSERT INTO blogs (blogHeadline, blogContent, catID, userID, blogImagePath, blogImageAlignment)
									VALUES (:ph_title, :ph_blogText, :ph_catID, :ph_userID, :ph_uploadedFilePath, :ph_imagePosition)';
								
					$params 	= array('ph_title' 	 			=> $title,
										'ph_blogText'			=> $blogText,
										'ph_catID'	 			=> $catID,
										'ph_userID'	 			=> $userID,
										'ph_uploadedFilePath'	=> $uploadedFilePath,
										'ph_imagePosition'		=> $imagePosition
										);
								
					// Schritt 2 DB: SQL-Statement vorbereiten
					$PDOStatement = $PDO->prepare($sql);
								
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					try {	
						$PDOStatement->execute($params);						
					} catch(PDOException $error) {
if(DEBUG)						echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
						$dbError = 'Fehler beim Zugriff auf die Datenbank!';
					}
								
					// Schritt 4 DB: Daten weiterverarbeiten
					/*
								Bei schreibenden Operationen (INSERT/UPDATE/DELETE):
								Schreiberfolg prüfen anhand der Anzahl der betroffenen Datensätze
					*/
					$rowCount = $PDOStatement->rowCount();
if(DEBUG_V)					echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					if( $rowCount !== 1 ) {
						// Fehlerfall
if(DEBUG)					echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Speichern des Userdatensatzes! <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						// Fehlermeldung an User
							$dbError = 'Es ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.';
									
					} else {
							// Erfolgsfall
							/*
								Bei einem INSERT die Last-Insert-ID nur nach geprüftem Schreiberfolg auslesen. 
								Im Zweifelsfall wird hier sonst die zuletzt vergebene ID aus einem älteren 
								Schreibvorgang zurückgeliefert.
							*/
						$newBlogID = $PDO->lastInsertId();
if(DEBUG)					echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Userdatensatz erfolgreich unter ID$newBlogID gespeichert. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						
						// Erfolgsmeldung an User
						$dbSuccess = 'Ihr Blog war erfolgreich veröffentlicht.';

						// DB-Verbindung beenden
						unset($PDO);

						// Formeingabe zurücksetzen
						$title							= NULL;
						$blogText						= NULL;


						} // END #********** SPEICHERN IN DB **********#	
					} // END #********** UPLOAD FILE **********#
					} // END #********** VALIDIERUNG FORM BLOGS **********#
				} // END #********** PROCESS FORM BLOGS **********#

#*******************************************************************************************
?>
<!DOCTYPE html>
    <html>
    <head>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
        <!-- Styling for public area -->
        <link rel="stylesheet" href="./css/main.css">
        <link rel="stylesheet" href="./css/debug.css">
        <meta charset="UTF-8">

        <title>PHP-Kurs Projektaufgabe Blog</title>
</head>
<body>
		<!-- navbar -->
		<?php include('./include/navbar.php') ?>
		<!-- // navbar -->
		<br>
		<!-- Willkommennachricht -->
		<p class="success" ><?= $welcomeMessage ?> </p>
		<!-- END Willkommennachricht -->
		<br>
		<!-- Form Categories -->
		<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST" >
			<input type="hidden" name="formCategory">
			<fieldset>
				<legend>Neue Kategorie anlegen</legend>					
				<span class='error'><?php echo $errorCategory ?></span><br>
				<input class="short" type="text" name="category" placeholder="Kategorie">
				<input class="short" type="submit" value="Fertig">
			</fieldset>
			</form>
			<!-- END Form Categories -->
			<br>
			<br>
			<!-- Form Blogs -->
			<form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="formBlog">
				
			<fieldset>
				<legend>Neue Blog-eintrag verfassen</legend>
				<span class='success'><?php echo $dbSuccess ?></span><br>
				<!-- Category -->
				<select class="category" name="catID">
					<?php foreach($categories as $category): ?>
						<option value="<?= $category['catID'] ?>"><?= $category['catLabel'] ?></option>
					<?php endforeach ?>
				</select>
				<!-- END Category -->
				<br>
				<span class="error"><?php echo $errorTitle ?></span><br>
				<input type="text" name="title" value="<?php echo $title ?>" placeholder="Überschrift"><br>
				<span class="error"><?php echo $errorBlogText ?></span><br>
				<textarea name="blogText" placeholder="Text..."><?php echo $blogText ?></textarea>
			</fieldset>
			
			<!-- -------- FILE UPLOAD START--------  -->
			<fieldset name="fileUpload">
				<legend>Bild hochladen</legend>
				<!-- -------- INFOTEXT FOR IMAGE UPLOAD START -------- -->
				<p class="small">
					Erlaubt sind Bilder des Typs 
					<?php $imageAllowedMimetypes = implode( ', ', array_keys(IMAGE_ALLOWED_MIME_TYPES) ) ?>
					<?= strtoupper( str_replace( array(', image/jpeg', 'image/'), '', $imageAllowedMimetypes) ) ?>.
					<br>
					Die Bildbreite darf <?= IMAGE_MAX_WIDTH ?> Pixel nicht übersteigen.<br>
					Die Bildhöhe darf <?= IMAGE_MAX_HEIGHT ?> Pixel nicht übersteigen.<br>
					Die Dateigröße darf <?= IMAGE_MAX_SIZE/1024 ?>kB nicht übersteigen.
				</p>
				<select class="right" name="imagePosition">
					<option value="left">Links im Blog</option>
					<option value="right">Rechts im Blog</option>
				</select>
				<!-- -------- INFOTEXT FOR IMAGE UPLOAD END -------- -->
				<span class="error"><?php echo $errorImageUpload ?></span><br>
				<input type="file" name="fileUpload">
			</fieldset>				
			<!-- -------- FILE UPLOAD END -------- -->
			<input class="short" type="submit" value="Veröffentlichen">
		</form>	
		<!-- END Form Blogs -->
		
		

</body>