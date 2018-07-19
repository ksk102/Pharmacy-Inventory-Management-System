<?php
	require_once 'php_function/general.php'; //general php function
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Set New Password | Pharmacy Inventory Management System</title>
		
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<link href="css/login.css" rel="stylesheet" type="text/css">
		
		
		<script>
		function checkpw(ele){
			if(ele.value == ""){
				ele.style.border = "2px solid red";
				return false;
			}
			else{
				ele.style.border = "";
				return true;
			}
		}
		function check_cpw(ele){
			if(ele.value != document.newPw_frm.new_pw.value){
				ele.style.border = "2px solid red";
				document.getElementById("cpw_error").innerHTML = "Password doesn't match!";
				return false;
			}
			else{
				ele.style.border = "";
				document.getElementById("cpw_error").innerHTML = "";
				return true;
			}
		}
		function validate(){
			if(checkpw(document.newPw_frm.new_pw) && check_cpw(document.newPw_frm.new_cpw)){
				return true;
			}
			else{
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
					<h3 class="panel-title">Set New Password</h3>
				</div>
					<div class="panel-body">
					
		<form name="newPw_frm" method="post" action="">
		
		<fieldset>
			<div class="form-group">
			<table>
				<tr>
					<td>New Password</td>
					<td  width="350px"><input type="password" name="new_pw" size="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" oninput="checkpw(this);"/></td>
				</tr>
				<tr>
					<td>Confirm Password</td>
					<td>
						<input type="password" name="new_cpw" size="20" oninput="check_cpw(this);"/>
						<br/>
						<label id="cpw_error" style="color:red;"></label>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="save_pw" value="Save" onclick="return validate();"></td>
				</tr>
			</table>
		</form>
	</body>
</html>

<?php

	if(isset($_POST['save_pw'])){
		
		$user_id = $_SESSION["sess_uid"];
		$new_pw = md5($new_pw); //password encryption
		
		$sql_newpw = 'UPDATE users SET upw="'.$new_pw.'", ufirst_login="0" WHERE uid="'.$user_id.'";';
		$conn->query($sql_newpw);
		
		echo "<script>
			alert('Changes Saved');
			location.assign('inv_menu.php');
		</script>";		
	}

?>