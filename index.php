<?php
include 'core/init.php';
if($userObj->isLoggedIn()){
    $userObj->redirect('home.php');
}
// $user = $userObj->get('users', array('user_id' => 1));
// echo $user->username;
 if(isset($_POST['login'])){
    $email    = Validate::escape($_POST['email']); //escape special char from input field
    $password = Validate::escape($_POST['password']);

    //Validate user Input
    if(empty($email) or empty($password)){
        $error = "Enter your email and password to login!";
    }else {
        if(!Validate::filterEmail($email)){
            $error = "Invaild email";
        }else{
            if($user = $userObj->emailExist($email)){
                $hash = $user->password;
                if(password_verify($password, $hash)){
                    //login
                    //redirect to home page if verified.
                    $_SESSION['user_id'] = $user->user_id;
                    $userObj->redirect('home.php');
                }else{
                    $error = "Email or Password is incorrect";
                }
             }else{
                $error = "No account with that email exists";
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
	
	<link rel="stylesheet" href="assets/css/indexstyle.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <title>PHP: Login and Registration With Email & Mobile Verification</title>
</head>
<body class="body">
	<div class="wrapper">
	<div class="wrapper-inner">
		<div class="header-wrapper">
			<h1>C.T.E EMS</h1>
			<h3 style="color:blue;">Click the sign up button to register a new user</h3>			
		</div><!--HEADER WRAPPER ENDS-->
		<div class="sign-div">
		<div class="sign-in">
			<form method="POST">
			<div class="signIn-inner">
                <form mathod="POST">
				<div class="input-div">
				<input type="email" name="email" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<button type="submit" name="login">Login</button>
            </div>
                </form>

                <?php if(isset($error)):?>
                    <div class="error shake-horizontal"> <?php echo $error ?></div>
                <?php endif;?>

		</div>
		</div>
		<div class="r-pass">
			<a href="account/recover/">I forget my Password</a>
		</div>
		</div><!--CONTENT WRAPPER ENDS-->
		<div class="footer-wrapper">
			<div class="inner-footer-wrap">
			<div class="sign-up"><button class="sign-up-btn" onclick="location.href='register';" type="submit">Sign Up</button></div>
			</div>
		</div><!--FOOTER WRAPPER ENDS-->
	</div>
	</div><!--WRAPPER ENDS-->
</body>
</html>