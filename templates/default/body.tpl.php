	<body>
		<div class = "main">
	<?php

		$dir = dirName(__FILE__)."/pages/".$page."/front.tpl.php";
		if (file_exists($dir)) require_once($dir);

	?>
	</div>
</body>