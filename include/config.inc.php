<?php
#***************************************************************************************#
				
				#******************************************#
				#********** GLOBAL CONFIGURATION **********#
				#******************************************#
				
				#********** DATABASE CONFIGURATION ********#
				define('DB_SYSTEM',					'mysql');
				define('DB_HOST',					'localhost');
				define('DB_NAME',					'blog');
				define('DB_USER',					'pato');
				define('DB_PWD',					'duck');
				
				
				#********** SESSION CONFIGURATION ************#
				define('SESSION_NAME',					'blog');

				#********** FORM CONFIGURATION ************#
				define('INPUT_MIN_LENGTH', 			 0);
				define('INPUT_MAX_LENGTH', 			 256);
				
				
				#********** IMAGE UPLOAD CONFIGURATION ****#
				define('IMAGE_MAX_WIDTH',				800);
				define('IMAGE_MAX_HEIGHT',				800);
				define('IMAGE_MAX_SIZE',				128*1024);
				define('IMAGE_MIN_SIZE',				1024);
				define('IMAGE_ALLOWED_MIME_TYPES',	array('image/jpg'=>'.jpg', 'image/jpeg'=>'.jpg', 'image/gif'=>'.gif', 'image/png'=>'.png'));
				
				
				#********** STANDARD PATHS CONFIGURATION **#
				define('IMAGE_UPLOAD_PATH',			'./uploadedImages/');
				define('AVATAR_DUMMY_PATH',			'../css/images/avatar_dummy.png');
				
				
				#********** DEBUGGING *********************#				
				define('DEBUG', 						true);	// Debugging main documents
				define('DEBUG_V', 						true);	// Debugging for values
				define('DEBUG_F', 						true);	// Debugging for functions
				define('DEBUG_I', 						true);	// Debugging for included files
				define('DEBUG_DB', 						true);	// Debugging for database operations


#***************************************************************************************#
?>