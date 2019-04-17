<?php 
	class Validate{

		public static function escape($input){ // accepts users input as parameter
			$input = trim(strip_tags($input)); //strip html/PHP tags from the string
			$input = stripslashes($input);// Removes blackslashes from the string
			$input = htmlentities($input, ENT_QUOTES);
			return $input;
        }
        
        //Validate email by filtering 
		public function filterEmail($email){
			return filter_var($email, FILTER_VALIDATE_EMAIL);
		}
        //Validate lenght for input characters
		public function length($input, $min, $max){
			if(strlen($input) > $max){
				return true;
			}else if(strlen($input) < $min){
				return true;
			}
		}
	}
?>