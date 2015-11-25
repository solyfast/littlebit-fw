<?php
	namespace core;

	abstract class database {

		protected $connection;
		protected $host;
		protected $user;
		protected $password;
		protected $database;
		protected $table;

		public function __construct($table) {

			$this->table      = config::$database_prefix.$table;
			$this->host       = config::$database_host;
			$this->user       = config::$database_user;
			$this->password   = config::$database_password;
			$this->database   = config::$database_name;
			
			$this->connection = new \mysqli($this->host, $this->user, $this->password, $this->database);

		}

		public function query($query) {

			//echo $query."\n";
			return $this->connection->query($query);
			//echo $this->connection->error;

		}

		public function insert($new_values) {

			if (!empty($new_values) and is_array($new_values)) {

				foreach ($new_values as $field => $value) {

					#get fields `field`, `field_2`,
						$fields = $fields.'`'.$field.'`,';
						
					#get values 'value', 'value_1',
						$values = $values."'".$value."',";
						
				}
				
				#format fields (`field`, `field_2`)
					$fields = substr($fields, 0, -1);
					$fields = '('.$fields.')';
					
				#format values ('value', 'value_1')
					$values = substr($values, 0, -1);
					$values = '('.$values.')';
					
				#create query
					$query  = "INSERT INTO $this->table $fields VALUES $values";

				#execute query
				return $this->query($query);

			}

		}

		public function select($select = "", $where = "", $order = "", $limit = "") {

			//create SELECT - SQL Query Part
			if (!empty($select)) {
				for ($i = 0; $i < count($select); $i++) {

					if ($select[$i] != '*') $query_select .= '`'.addslashes($select[$i]).'`,';
					else $query_select = '*';

				}
				if ($query_select != '*') $query_select = substr($query_select, 0, -1); 
			}

			//create WHERE - SQL Query Part
			$query_where = $this->query_where($where);

			//create ORDER - SQL Query Part
			if (!empty($order)) {

				$n = 0;

				foreach ($order as $key => $value) {

					if ($value) $logic = 'ASC';
					else        $logic = 'DESC';

					$query_order = $query_order.' `'.addslashes($key).'` '.$logic.',';

				}

				$query_order = substr($query_order, 0, -1);

			}

			if (!empty($query_where)) $query_where   = ' WHERE'.$query_where;
			if (!empty($query_order)) $query_order   = ' ORDER BY '.$query_order;
			if (!empty($limit))       $query_limit   = ' LIMIT '.$limit;
			if (!empty($query_select)) {

				$query_select = ' '.$query_select.' ';
				$query = "SELECT".$query_select."FROM ".$this->table.$query_where.$query_order.$query_limit."";
			
			}

			if (!empty($query)) {

				$data  = $this->query($query);
				if (!empty($data)) {
					$rows  = $data->fetch_assoc();
					while ($rows) {
					 	$result[] = $rows;
						$rows     = $data->fetch_assoc();
					}
					return $result;
				}

			}
			 
		}

		public function update($update, $where) {

			if (isset($update) and isset($where)) {

				$query_where = $this->query_where($where);

				foreach ($update as $key => $value)
					$query_update = '`'.addslashes($key).'`=\''.addslashes($value).'\',';

				if (isset($query_update))
					$query_update = substr($query_update, 0, -1);

				$query = 'UPDATE '.$this->table.' SET '.$query_update.' WHERE'.$query_where;
				return $this->query($query);

			}


		}

		public function delete($where) {

			$query_where = $this->query_where($where);

			$query = "DELETE FROM ".$this->table." WHERE ".$query_where;

			return $this->connection->query($query);

		}

		private function query_where($where) {

			if (!empty($where)) {

				$n = 0;
				foreach ($where as $key => $value) {

					if (is_array($value)) {

						for ($i = 0; $i < count($value); $i++) {

							$in = $in."'".addslashes($value[$i])."',";

						}

						$in = substr($in, 0, -1);
						$query_where = $query_where.$key." IN (".$in.")";

					}
					else {

						if ($n != 0) {

							$type        = explode(":", $key);
							$logic       = $type[0];
							$key         = $type[1];
							$query_where = $query_where.' '.$logic.' '."`".addslashes($key)."`".' = '."'".addslashes($value)."'";
						
						}
						else $query_where = $query_where.' '."`".addslashes($key)."`".' = '."'".addslashes($value)."'";
					
					}

					$n++;

				}

			} else return false;

			return $query_where;

		}
		
	}

?>