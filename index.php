 <?php
 	session_start();
 	$link= mysqli_connect("localhost","cl11-a-wordp-f03","-private informaiton-","cl11-a-wordp-f03");

	if($_POST['submit']=="Sign up"){
		if(!$_POST['email']) $error.="<br /> Please enter your email";
			else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $error.="<br /> Please enter a valid email address";
		if (!$_POST['password']) $error.="<br /> Please enter a password";
			else{
				if (strlen($_POST['password'])<8) $error.="<br /> Please enter a password with at least 8 characters";
				if(!preg_match('`[A-Z]`',$_POST['password'])) $error.="<br /> Please include a capital leter in your password";
			}
		if ($error){
			echo "There were errors with your signup details:" .$error;
		}  else{
			$query="SELECT * FROM `test_user` WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
			
			$result=mysqli_query($link,$query);
			
			$results=mysqli_num_rows($result);
			
			if($results){
				echo "Your email address is already in use. Do you want to log in?";
			} else{
				$query="INSERT INTO `test_user`(`Email`,`Password`) VALUES('".mysqli_real_escape_string($link,$_POST["email"])."', '" .md5(md5($_POST["email"]).$_POST['password'])."')";
				mysqli_query($link,$query);
				echo "Youve been signed up!";
				$_SESSION['id']=mysqli_insert_id($link);
				print_r($_SESSION);
				//redirect to logged in page
			}
		}
	}
// 	if($_POST['submit']=="Log In"){
// 			$query="SELECT * FROM `test_user` WHERE email='".mysqli_real_escape_string($link,$_POST['loginemail'])."' AND password='".md5(md5($_POST['loginemail']).$_POST['loginpassword'])."' LIMIT 1";
// 			$result=mysqli_query($link,$query);
// 			
// 			$row= mysqli_fetch_array($result);
// 			
// 			if ($row){
// 				print_r($row);
// 				//$_SESSION['id']=$row['id'];
// 				print_r($_SESSION);
// 				//redirect to logged in page
// 			} else{
// 				echo "error, please enter the correct password.";
// 			}
// 	
// 	}

?>

<form method="post">
	<input type="email" name="email" id="email" />
	
	<input type="password" name="password" />
	
	<input type="submit" name="submit" value="Sign up" />
</form>


<!-- 
<form method="post">
	<input type="email" name="loginemail" id="loginemail" />
	
	<input type="password" name="loginpassword" />
	
	<input type="submit" name="submit" value="Log In" />
</form>
 -->
