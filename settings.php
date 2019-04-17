<?php
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
    $user = $userObj->userData($user_id);
    $verifyObj->authOnly();

    // exit();
    // Check to see that all required fields are filled.
    if (isset($_POST['update'])) {
        // $required = array('firstName','lastName','username','email','password');
        $required = array('name','username','email','password');
        foreach($_POST as $key => $value){
            if(empty($value) && in_array($key, $required)){
                $errors['allFields']= "All fields are required";
                break;
            }
        }


        //call to escape function to validate all input fields
        if(empty($errors['allFields'])){
            // $firstName      = Validate::escape($_POST['firstName']);
            // $lastName       = Validate::escape($_POST['lastName']);
            $name           = $_POST['name'];
            $username       = Validate::escape($_POST['username']);
            $email          = Validate::escape($_POST['email']);
            $password       = $_POST['password'];

            // if(Validate::length($firstName, 2, 30)){
            //     $errors['names'] = "Names can only be between 2 - 30 char";

            // } else if (Validate::length($lastName, 2, 30)) {
            //     $errors['names'] = "Names can only be between 2 - 30 char";
            // }
            if(Validate::length($username, 2, 10)) {
                $errors['username'] = "Names can only be between 2 - 10 char";

            } else if ($username != $user->username && $userObj->usernameExist($username)) {
                $errors['username'] = "Username is already taken!";
            }

            if(!Validate::filterEmail($email)) {
                $errors['email'] = "Invalid email format";
            
            }else if($email != $user->email && $userObj->emailExist($email)) { // check if email is not tied to the user or if it doesnt already exist in the database.
                $errors['email'] = "Email already exists";
            } else {
                if(password_verify($password, $user->password)) {
                    //update user
                    // $userObj->update('users', array('firstName' => $firstName, 'lastName' => $lastName, 'username' => $username, 'email' => $email ), array('user_id' => $user_id));
                    $userObj->update('users', array('name' => $name, 'username' => $username, 'email' => $email ), array('user_id' => $user_id));
                    $userObj->redirect('account/settings');
                }else{
                    $errors['password'] = "Password is incorrect";
                }
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
	
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <title>Update your account</title>
</head>
<body class="body2">
<div class="banner">
		<h2>C.T.E EMS</h2>
</div>
<div class="home-nav">
    <a class="logout" href="<?php echo BASE_URL;?>home.php">Home</a>
</div>
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">
			  <form method="POST">
				<div class="name">
				<h3>Change Name</h3>
				<input type="text" name="name" placeholder="First Name Last Name" value="<?php echo $user->name;?>"/>
				
				</div>
                <!-- Name Error -->
                <?php if(isset($errors['names'])):?>
				<span class="error-in"><?php echo $errors['names'];?></span>
                <?php endif;?>
				<div>
				<h3>Change User Name</h3>
				<input type="text" name="username" placeholder="UserName" value="<?php echo Validate::escape($user->username);?>"/>
 				</div>
                <!-- Username Error -->
                <?php if(isset($errors['username'])):?>
	  		  	<span class="error-in"><?php echo $errors['username'];?></span>
                <?php endif;?>
				<div>
				<h3>Change Email</h3>
				<input type="email" name="email" placeholder="Email" value="<?php echo Validate::escape($user->email);?>"/>
                <!-- Email Error -->
                <?php if(isset($errors['email'])):?>
				<span class="error-in"><?php echo $errors['email'];?></span>
				</div>
                <?php endif;?>

				<div>
				<h3>Enter your password to update your account</h3>
				<input type="password" name="password" placeholder="Password"/>
				
                <!-- Password Errors -->
                <?php if(isset($errors['password'])):?>
                <span class="error-in"><?php echo $errors['password'];?></span>
                <?php endif;?>
				</div>

                <!-- Required Fields Errors -->
                <?php if(isset($errors['allFields'])):?>
                 <span class="error-in"><?php echo $errors['allFields'];?></span>
                <?php endif;?>
				<div class="btn-div">
				<button value="sign-up" name="update">Save</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>
</html>