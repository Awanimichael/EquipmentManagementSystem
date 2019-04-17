<?php 
	class Items{
		protected $db;

		public function __construct(){
			$this->db = Database::instance();
		}

		public function get($table, $fields = array()){   // array_keys function gets the index in the fields array
			$columns = implode(', ', array_keys($fields)); // implode function joins element in the array
			//sql query
			$sql = "SELECT * FROM `{$table}`WHERE `{$columns}` = :{$columns}";
            
			//check if sql query is set
			if($stmt = $this->db->prepare($sql)){
                //bind values to placeholders
				foreach ($fields as $key => $value) {
					//bind columns
					$stmt->bindValue(":{$key}", $value);
				}
				//execute the query
				$stmt->execute();
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
		}

		public function delete($table, $fields = array()) {   // array_keys function gets the index in the fields array
			$columns = implode(', ', array_keys($fields)); 
			//sql query
			$sql = "DELETE FROM `{$table}` WHERE `{$columns}` = :{$columns}";

			//check if the sql query is set
			if($stmt = $this->db->prepare($sql)){
				//bind values to placeholders
				foreach ($fields as $key => $value) {
					//bind colunms
					$stmt->bindValue(":{$key}", $value);
				}
				//execute the query
				$stmt->execute();
			}
		}

        // Method to insert into the database.
		public function insert($table, $fields = array()){
			$columns = implode(", ", array_keys($fields));
			$values  = ":".implode(", :", array_keys($fields));
			//sql query
			$sql = "INSERT INTO {$table} ({$columns}) VALUES({$values})";
			//check if sql is prepared
			if($stmt = $this->db->prepare($sql)){
				//bind values to placeholders
				foreach ($fields as $key => $value) {
					$stmt->bindValue(":{$key}", $value);
				}
				//execute
				$stmt->execute();
				//return user_id
				return $this->db->lastInsertId();
			}
		}

		public function update($table, $fields, $condition){
			$columns  = '';
			$where    = " WHERE ";
			$i        = 1;
			//create columns
			foreach($fields as $name => $value){
				$columns .= "`{$name}` = :{$name}"; // placeholder to bind column value to SQL query
				if($i < count($fields)){
					$columns .= ", ";
				}
				$i++;
			}
			//create sql query
            $sql = "UPDATE {$table} SET {$columns}";

            // var_dump($sql);

			//adding where condition to sql query
			foreach($condition as $name => $value){
				$sql .= "{$where} `{$name}` = :{$name}";
				$where = " AND ";
			}
			//check if sql query is prepared
			if($stmt = $this->db->prepare($sql)){
				foreach ($fields as $key => $value) {
					//bind columns to sql query
					$stmt->bindValue(":{$key}", $value);
					foreach ($condition as $key => $value) {
						//bind where conditions to sql query
						$stmt->bindValue(":{$key}", $value);
					}
				}
				//execute the query
				$stmt->execute();
			}
		}

		public function usernameExist($username){
			$username = $this->get('users', array('username' => $username));
			return ((!empty($username))) ? $username : false;
		}

		public function itemIDExist($itemID){
			$itemID = $this->get('inventory', array('itemID' => $itemID));
			return ((!empty($itemID))) ? $itemID : false;
		}


		public function itemData($itemID = string){
			return $this->get('inventory', array('itemID' => $itemID));
		}


		public function itemDelete($itemID = string){
			return $this->delete('inventory', array('itemID' => $itemID));
		}

	}
?>
