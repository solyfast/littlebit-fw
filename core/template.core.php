<?php
	namespace core;

	class template {

		public $template;
		public $page;

		public static function get($template = "") {

			//explode template in array and get page (default: welcome) and template (default: default)
			$template = explode(":", $template);
			$page = strtolower($template[1]);
			$template = strtolower($template[0]);
			if (empty($template)) $template = strtolower(config::$template_default);
			if (empty($page)) $page = strtolower(config::$component_default);

			//get all files for include
			$file_list = config::$template_components;

			//check if files exists and require
			if (!empty($file_list) and is_array($file_list)) {

				for ($i = 0; $i < count($file_list); $i++) {

					$file_name = strtolower($file_list[$i]);
					$dir = dirName(__FILE__)."/..".config::$template_dir.$template."/".$file_name;
					if (file_exists($dir)) require_once($dir);

				}

			}

		}

		public static function widget($name, $arguments = "", $template = "") {

			if (empty($template)) $template = config::$template_default;
			
			$explode   = explode(":", "$name");
			$widget    = $explode[1];
			$component = $explode[0];
			$args = $arguments;

			if (empty($widget)) {
				$widget = $name;
				unset($component);
				$dir = dirName(__FILE__)."/../templates/".$template."/widgets/".$widget;
			}
			else if (!empty($widget) and !empty($component)) {
				$dir = dirName(__FILE__)."/../templates/".$template."/pages/".$component."/".$widget;
			}

			if (file_exists($dir)) require($dir);

		}

		public static function language($language) {

			$dir = dirName(__FILE__)."/../language/";
			$file = $language.".language.php";

			if (file_exists($dir.$file)) require_once($dir.$file);
			

		}

	}
	

?>