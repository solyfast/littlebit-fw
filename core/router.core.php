<?php
	namespace core;

	class router {

		public $uri;
		public $cName;
		public $cAction;
		public $cParameters;

		public function __construct() {

			//start router function
			$this->startRouter();

		}

		private function startRouter() {

			$uri = $this->getURI();

			if (!empty($uri)) {

				//create file path
				$file = dirName(__FILE__)."/../components/".strtolower($this->uri['component']).".component.php";
				//check if component exists
				if (file_exists($file)) {

					require_once($file);

					//create component name (cName) and component action (cAction), call with cParameters
					$this->cName   = "component".$this->uri['component'];
					$this->cAction = "action".$this->uri['action'];
					$this->cParameters = $this->uri['parameters'];

					//create object and call method
					if (isset($this->cParameters))
						if (class_exists($this->cName) and $component = new $this->cName($this->uri) and method_exists($component, $this->cAction) and $action = $this->cAction) $component->$action($this->cParameters);
					else 
						if (class_exists($this->cName) and $component = new $this->cName($this->uri) and method_exists($component, $this->cAction) and $action = $this->cAction) $component->$action();

					//return true if all was executed
					return true;

				}

			}
			else return false;

		}

		private function getURI() {

			$this->uri = $_SERVER['REQUEST_URI'];
			$this->uri = substr($this->uri, 1);


			if (!empty($this->uri)) {
				$uri = explode("/", $this->uri);
				if (empty($uri)) {
					$uri = explode("\\", $this->uri);
					if (!empty($uri)) $this->uri = $uri;
				}
				else $this->uri = $uri;
			}
			else {
				$this->uri['component'] = config::$component_default;
				$this->uri['action']    = config::$component_default_action;
				return $this->uri;
			}

			$this->uri = $uri;
			if (!empty($this->uri[0])) {
				$this->uri['component'] = $this->uri[0];
				$this->uri['component'] = strtolower($this->uri['component']);
				$this->uri['component'] = ucfirst($this->uri['component']);
				$this->uri['component'] = trim($this->uri['component']);
				$this->uri['component'] = htmlspecialchars($this->uri['component']);
				$this->uri['component'] = addslashes($this->uri['component']);
				unset($this->uri[0]);
			}
			else $this->uri['action'] = config::$component_default;

			if (!empty($this->uri[1])) {
				$this->uri['action'] = $this->uri[1];
				$this->uri['action'] = strtolower($this->uri['action']);
				$this->uri['action'] = ucfirst($this->uri['action']);
				$this->uri['action'] = trim($this->uri['action']);
				$this->uri['action'] = htmlspecialchars($this->uri['action']);
				$this->uri['action'] = addslashes($this->uri['action']);
				unset($this->uri[1]);
			}
			else $this->uri['action'] = config::$component_default_action;

			unset($uri[0]); unset($uri[1]);
			$uri = array_values($uri);
			$this->uri['parameters'] = $uri;

			if (!empty($this->uri['component']) and !empty($this->uri['action'])) return $this->uri;

		}

	}

?>