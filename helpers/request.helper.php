<?php
	namespace helper;

	class request {

		public static function receive() {

			$receive = file_get_contents("php://input");
			return $receive;

		}

		public static function receiveJson() {

			$receive = self::receive();

			$json    = json_decode($receive, true);
			if (!empty($json)) {
				return $json;
			}

			else return null;

		}

        public static function sendJson($data) {

            if (empty($data)) return false;
            else if (is_array($data)) {

                $json = json_encode($data);
                if (!empty($json)) {
                    http_response_code(200);
                    print $json;
                }
                return false;

            }
            else return false;

        }

        public static function method() {

        	return $_SERVER['REQUEST_METHOD'];

        }

	}

?>