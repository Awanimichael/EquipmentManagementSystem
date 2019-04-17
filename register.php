<?php
include 'core/init.php';
if($userObj->isLoggedIn()){
    $userObj->redirect('home.php');
}

if (isset($_POST['signup'])) {
    $required = array('name','username','enail','password','passwordAgain','gender');
    foreach ($_POST as $key => $value){
        if(empty($value) && in_array($key, $required) === true) {
            $errors['allFields'] = 'All fields are required';
            break;
        }
    }
    if(empty($errors['allFields'])){
        //validate form

        // $firstName      = Validate::escape($_POST['firstName']);
		// $lastName       = Validate::escape($_POST['lastName']);
		$name 			= $_POST['name'];
        $username       = Validate::escape($_POST['username']);
        $email          = Validate::escape($_POST['email']);
        $password       = $_POST['password'];
        $rePassword     = $_POST['passwordAgain'];
        $gender         = Validate::escape($_POST['gender']);


        // if(Validate::length($firstName, 2, 30)){
        //     $errors['names'] = "Names can only be between 2 - 30 char";

        // } else if (Validate::length($lastName, 2, 30)) {
        //     $errors['names'] = "Names can only be between 2 - 30 char";

        if(Validate::length($username, 2, 10)) {
            $errors['username'] = "Names can only be between 2 - 10 char";

        } else if ($userObj->usernameExist($username)) {
            $errors['username'] = "Username is already taken!";

        } else if(!Validate::filterEmail($email)) {
            $errors['email'] = "Invalid email format";
        
        }else if($userObj->emailExist($email)) { // check if email is not tied to the user or if it doesnt already exist in the database.
            $errors['email'] = "Email already exists";
        } else if($password != $rePassword) {
            $errors['password'] = "Password does not match";
        } else {
            //create user
            $hash = $userObj->hash($password);
   			$user_id = $userObj->insert('users', array('name' => $name, 'username' => $username, 'email' => $email, 'password' => $hash, 'gender' => $gender));
   			$_SESSION['user_id'] = $user_id;
			$userObj->redirect('verification');

        }


    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/indexstyle.css"/>
	<!-- <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/> -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<title>Registration</title>
</head>
<div class="home-nav">
	<a class="logout" href="<?php echo BASE_URL;?>home.php">Home</a>
</div>
<body class="body2">
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">
				<form method="POST">
				<div class="name">
				<!-- <h3>Name</h3> -->
				<input type="text" name="name" placeholder="First Name Last Name" value="<?php echo ((isset($name)) ? $name : '');?>"/>
												 
				 <!-- Name Error -->
                 <?php if(isset($errors['names'])):?>
                     <span class="error-in"><?php echo $errors['names'] ?></span>
                <?php endif;?>
				</div>

				<div>
				<!-- <h3>Username</h3> -->
				<input type="text" name="username" placeholder="Username" value="<?php echo ((isset($username)) ? Validate::escape($username) : '');?>" />
				<!-- Username Error -->
                <?php if(isset($errors['username'])):?>
                     <span class="error-in"><?php echo $errors['username'] ?></span>
                <?php endif;?>
				</div>

				<div>
				<!-- <h3>Email</h3> -->
				<input type="email" name="email" placeholder="Email" value="<?php echo ((isset($email)) ? Validate::escape($email) : '');?>"/>
				<!-- Email Error -->
                <?php if(isset($errors['email'])):?>
                     <span class="error-in"><?php echo $errors['email'] ?></span>
                <?php endif;?>
				</div>

				<div>
				<!-- <h3>Password</h3> -->
				<input type="password" name="password" placeholder="Password"/>
				
				<input type="password" name="passwordAgain" placeholder="Confirm Password" />
				<!-- Password Error -->
                <?php if(isset($errors['password'])):?>
                     <span class="error-in"><?php echo $errors['password'] ?></span>
                <?php endif;?>
				</div>
				
				<div>
				<fieldset>
					<legend>Gender</legend>
					<input id="male" type="hidden" name="gender" value="">
					<input id="male" type="radio" name="gender" value="male">
					<label for="male">
						Male
					</label>
					<input id="female" type="radio" name="gender" value="female">
					<label for="female">
						Female
					</label> 
				</fieldset>
  

				<!-- <fieldset class="date">
				  <legend>Date of Birth</legend>
				  <label for="month">Month</label>
				  <select id="month_start"
				          name="month" />
  				    <option  value="" selected>Month</option>    
				    <option value="1">January</option>      
				    <option value="2">February</option>      
				    <option value="3">March</option>      
				    <option value="4">April</option>      
				    <option value="5">May</opcenter>      
				    <option value="6">June</option>      
				    <option value="7">July</option>      
				    <option value="8">August</option>      
				    <option value="9">September</option>      
				    <option value="10">October</option>      
				    <option value="11">November</option>      
				    <option value="12">December</option>      
				  </select> -
				  <label for="day_start">Day</label>
				  <select id="day_start"
				          name="day" />
  				    <option  value="" selected>Day</option>    
				    <option>1</option>      
				    <option>2</option>      
				    <option>3</option>      
				    <option>4</option>      
				    <option>5</option>      
				    <option>6</option>      
				    <option>7</option>      
				    <option>8</option>      
				    <option>9</option>      
				    <option>10</option>      
				    <option>11</option>      
				    <option>12</option>      
				    <option>13</option>      
				    <option>14</option>      
				    <option>15</option>      
				    <option>16</option>      
				    <option>17</option>      
				    <option>18</option>      
				    <option>19</option>      
				    <option>20</option>      
				    <option>21</option>      
				    <option>22</option>      
				    <option>23</option>      
				    <option>24</option>      
				    <option>25</option>      
				    <option>26</option>      
				    <option>27</option>      
				    <option>28</option>      
				    <option>29</option>      
				    <option>30</option>      
				    <option>31</option>      
				  </select> -
				  <label for="year_start">Year</label>
				  <select id="year_start"
				         name="year" />
 				    <option  value="" selected>Year</option>    
				    <option>1980</option>      
				    <option>1981</option>      
				    <option>1982</option>      
				    <option>1983</option>      
				    <option>1984</option>      
				    <option>1985</option>      
				    <option>1986</option>      
				    <option>1987</option>      
				    <option>1988</option>      
				    <option>1989</option>     
				    <option>1990</option>      
				    <option>1991</option>      
				    <option>1992</option>      
				    <option>1993</option>      
				    <option>1994</option>      
				    <option>1995</option>      
				    <option>1996</option>      
				    <option>1997</option>      
				    <option>1998</option>      
				    <option>1999</option>
				    <option>2000</option>      
				    <option>2001</option>      
				    <option>2002</option>      
				    <option>2003</option>      
				    <option>2004</option>      
				    <option>2005</option>      
				    <option>2006</option>      
				    <option>2007</option>      
				    <option>2008</option>      
				    <option>2009</option>      
				  </select>
				  <span class="inst">(Month-Day-Year)</span>
				</fieldset> -->

                     <!-- All Fields error -->
                 <?php if(isset($errors['allFields'])):?>
                     <span class="error-in"><?php echo $errors['allFields'] ?></span>
                <?php endif;?>

				</div>
				<div class="btn-div">
				<button value="sign-up" name="signup">Register</button>
 				</div>
			 </form>
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>
</html>