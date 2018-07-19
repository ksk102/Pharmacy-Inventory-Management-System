<?php 
	require_once 'php_function/general.php';
	
	redirect_as_logged_in(); //if the uid session still exists, redirect to main page without login
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login | Pharmacy Inventory Management System</title>
		
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<link href="css/login.css" rel="stylesheet" type="text/css">
		
		<script type="text/javascript">
		function check_email() //validate the email
		{
			if (document.login_frm.u_email.value == "" || !(isNaN(document.login_frm.u_email.value)) || document.login_frm.u_email.value.indexOf("@") == -1 || document.login_frm.u_email.value.indexOf(".com") == -1)
			{
				document.getElementById('EmailError').innerHTML = ' Enter the correct email';		
				return false;
			}
			else
			{
				document.getElementById('EmailError').innerHTML = '&nbsp;';
				return true;
			}
		}
		
		function check_pw() //validate the password
		{
			if (document.login_frm.u_password.value == "")
			{
				document.getElementById('PwError').innerHTML = ' Enter your password';
				return false;
			}
			else
			{
				document.getElementById('PwError').innerHTML = '&nbsp;';
				return true;
			}
		}
		
		function validatelogin() //double validate while 'Sign In' button clicked
		{
			if (check_email() && check_pw())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
				return false;
			}
		}
		</script>
	</head>
	
	<body>
	<div class="container">
		<div class="login">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Pharmacy Inventory</h3>
				</div>
					<div class="panel-body">
					
		<form name="login_frm" method="post" action="" onsubmit="return validatelogin();">
		
		<fieldset>
			<div class="form-group">
									<input type="email" name="u_email" placeholder="user@user_email.com" size="37" maxlength="45" id="email" autofocus required oninput="check_email();"/>
									<span id="EmailError" class="red" >&nbsp;</span>
								</div>
                                <div class="form-group">
                                    <input type="password" name="u_password" placeholder="Your Password" size="37" oninput="check_pw();"/>
			<span id="PwError" class="red">&nbsp;</span>
			<br><input class="btn" type="submit" name="login_btn" value="Sign In">
			<!--<p>Forget your password? Please contact system administer</p>-->
		</form>
	</body>
</html>

<?php
	if(isset($_POST["login_btn"]))
	{
		$user_email		= $_POST["u_email"];
		$user_password 	= $_POST["u_password"];
		
		$user_password = md5($user_password); //password encryption
		
		//vunerable by sql injection attack
		/*$sql_login	= "SELECT uid,uname from users where uemail='$user_email' and upw='$user_password'";
		//$result_login = $conn->query($sql_login);*/
		
		$stmt = $conn->prepare("SELECT uid,uname,ugroup,ufirst_login FROM users WHERE uemail=? and upw=?");
		$stmt->bind_param("ss", $user_email, $user_password);
		$stmt->execute();
		
		$result_login = $stmt->get_result();
		$stmt->close();
		
		if($row = $result_login->fetch_assoc())
		{
			$_SESSION["sess_uid"] = $row["uid"];
			$_SESSION["sess_uname"] = $row["uname"];
			$_SESSION["sess_ugroup"] = $row["ugroup"];
			
			if($row["ufirst_login"] == '1'){
				header("Location: setNewPassword.php");
			}
			else{
				header("Location: inv_menu.php");
			}
		}
		else
		{
			echo '<script type = "text/javascript">';
			echo 'alert("Invalid Email or Password");';
			echo 'window.location.assign("index.php")';
			echo '</script>';
			
			//header("Location: index.php");
		}
	}
?>
