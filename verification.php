<?php
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
    $user = $userObj-> userData($user_id);
    $verifyObj->authOnly();

    if(isset($_POST['email'])){
        $link = Verify::generateLink();
        $message = "{$user->firstName}, Your account has been created, Vist this link to verify your account : <a href='http://localhost:10080/mastersProject/cte-ems/verification/{$link}'>Verify Link</a>";
        $subject = "Account Verification";
        $verifyObj->sendToMail($user->email, $message, $subject);
        $userObj->insert('verification', array('user_id' => $user_id, 'code' => $link));
        $userObj->redirect('verification?mail=sent');
    }

    if(isset($_GET['verify'])){
        $code = Validate::escape($_GET['verify']);
        $verify = $verifyObj->verifyCode($code);

        // check if the verification code is not expired
        if($verify){
            if(date('Y-m-d', strtotime($verify->createdAt))< date('Y-m-d')){
                $errors['verify'] = "Your verification link has expired ";
                //Update the verification table
            }else{ 
                $userObj->update('verification',array('status' => '1'), array('user_id' => $user_id,'code' => $code));
                $userObj->redirect('home.php');
            }

        }else {
            $errors['verify'] = "Invalid verification link";
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
    <title>Verification</title>
</head>
<div class="home-nav">
    <a class="logout" href="<?php echo BASE_URL;?>home.php">Home</a>
</div>
<body class="body2">
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">
				<div class="name">
                <?php
                    if(isset($_GET['verify']) || !empty($_GET['verify'])){
                        if(isset($errors['verify'])){
                            echo '<h4>' .$errors['verify']. '</h4>';
                        }
                    }else{
                ?>
				<h4>Your account has been created, you need to activate your account by Email</h4>
				<fieldset>
                <legend></legend>
                <?php if(isset($_GET['mail'])):?>
                    <h4> A Verification email has been sent to your email, check your email to verify your account</h4>
                <?php else:?>
				
                <h3>Email verificaiton</h3>
                <form method="POST">
				<input type="email" name="email" placeholder="<?php echo $user->email;?>" value="<?php echo $user->email;?>" />
 				<button type="submit" class="suc">Send me verification email</button>
                </form>
                <?php endif;?>
				</fieldset>
				</div>
                 <!-- Email error field -->
                 <?php if(isset($errors['email'])):?>
				<span class="error-in"><b><?php echo $errors['email'];?></b></span>
                <?php endif;?>
				<!-- <fieldset>
					<legend>Method 2</legend>
				<div>
					<h3>Phone verificaiton</h3>
					<form method="POST">
					<input type="tel" name="number" placeholder="Enter your Phone number"/>
					<button type="submit" name="phone" class="suc">Send verification code via SMS</button>
					</form>
				</div>
 				</fieldset> -->
 				<!-- Phone error field -->
                 <?php if(isset($errors['phone'])):?>
				<span class="error-in"><b><?php echo $errors['phone'];?></b></span>
                <?php endif;?>
            </div>
            <?php }?>
		</div>
    </div>
</div><!--WRAPPER ENDS-->
</body>
</html>