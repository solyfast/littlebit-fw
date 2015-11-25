<?php
	namespace core;

	class config {

		
		    public static $mail                     = "<email>";

		#database config
			public static $database_host            = "<database_host>";
			public static $database_user            = "<database_user>";
			public static $database_password        = "<database_password>";
			public static $database_name            = "<database_name>";
			public static $database_prefix          = "<database_prefix>";

		#components config
			public static $component_default        = "<default_page_component>"; // url - /<component>/action/parameter
			public static $component_default_action = "<default_page_action>"; // url - /component/<action>/parameter

		#templates config
			public static $template_default     	= "<template>"; // default template
			public static $template_components      = array("header.tpl.php", "body.tpl.php", "footer.tpl.php"); //components
			public static $template_dir   			= "/templates/"; // template dir: by default - /templates/
			public static $page_title				= "<Project_Name>"; //default page title from <title></title>

	}

?>