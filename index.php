<?php
	session_start();

	#include helpers
		#request
			$dir = dirName(__FILE__)."/helpers/request.helper.php";
			require_once($dir);

	#include classes
		#config
			$dir = dirName(__FILE__)."/core/config.core.php";
			require_once($dir);
		#database
			$dir = dirName(__FILE__)."/core/database.core.php";
			require_once($dir);
		#router
			$dir = dirName(__FILE__)."/core/router.core.php";
			require_once($dir);
		#template
			$dir = dirName(__FILE__)."/core/template.core.php";
			require_once($dir);

	#include models
		//

	$router = new core\router();

?>