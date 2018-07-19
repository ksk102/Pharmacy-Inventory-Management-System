<?php
	require_once 'php_function/general.php'; //general php function
	
	if($_SESSION["sess_ugroup"] != 0){
		header("Location: inv_menu.php");
	}
	
	$title = "Add";
	$delete_btn = 'style="display: none;"';
	$user_id_field = 'style="display: none;"';
	
	//edit mode
	if(isset($_GET["userid"])){
		
		$userid = $_GET["userid"];
		$title = "Edit";
		$delete_btn = ''; //only appear on edit mode
		$user_id_field = ''; //only appear on edit mode
		
		
		$sql_user_detail = "SELECT uid,uemail,uname,ugroup FROM users
							WHERE uid = '$userid';";
		$result_user_detail = $conn->query($sql_user_detail);
		list($userid,$useremail,$usersname,$usergroup) = $result_user_detail->fetch_row(); //list out the user's details
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Medicine Details | Pharmacy Inventory Management System</title>
		
		<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		
		<script>
		function chk_name(ele){
			if(ele.value == ""){
				ele.style.border = "2px solid red";
				return false;
			}
			else{
				ele.style.border = "";
				return true;
			}
		}
		function checkpw(ele){
			if(ele.value == "" && document.mst_maint_user_form.uid.value == ""){
				ele.style.border = "2px solid red";
				return false;
			}
			else{
				ele.style.border = "";
				return true;
			}
		}
		function validate(){
			if(checkpw(document.mst_maint_user_form.upw) && chk_name(document.mst_maint_user_form.uname)){
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
	<div class="wrapper">
    <div class="sidebar">

    	<div class="sidebar-wrapper">
            <div class="logo simple-text">   
                   
<?php
	require_once 'php_function/general.php'; //general php function

	echo  "<p>". $_SESSION["sess_uname"] ."</p>" ; 
?>

            </div>

            <ul class=" puerto-menu nav">
		<li>
			<a href="inv_menu.php" target="_self">

				<p>
					<strong>Home</strong>
					<small>menu</small>
				</p>
			</a>
		</li>
		<li>
			<a href="inv_lst_med.php" target="_self" >

				<p>
					<strong>Medicines</strong>
					<small>listing</small>
				</p>
			</a>
		</li>
		<li>
			<a href="" class="hover">
				<p>
					<strong>Transaction</strong>
					<small>stock</small>
				</p>
			</a>
			<ul>
				<li><a href="trans_stockinout.php?mode=in" target="_self"></i>Stock In</a></li>
				<li>
					<a href="trans_stockinout.php?mode=out" target="_self">Stock Out</a>
					
				</li>
			</ul>
		</li>
		<li>
			<a href="" class="hover">
				<p>
					<strong>Report</strong>
					<small>table</small>
				</p>
			</a>
			<ul>
				<li><a href="rpt_sales.php" target="_self"></i>Sales Report</a></li>
				<li>
					<a href="rpt_stockinout.php?mode=in" target="_self">Stock In</a>
					
				</li>
				<li><a href="rpt_stockinout.php?mode=out" target="_self">Stock Out</a></li>
			</ul>
		</li>
		<li <?php echo $hidden_userlist; ?>>
			<a href="mst_lst_user.php" target="_self"  class="active">

				<p>
					<strong>User List</strong>
					<small>account</small>
				</p>
			</a>
		</li>
				
				<li class="active-pro">
	<a href="general_html/logout.php" target="_self">Logout</a>
                </li>
				
            </ul>
    	</div>
    </div>
	
	<div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header navbar-brand">
<?php echo $title; ?> User Details | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php echo $title; ?> User Details</h4>
                            </div>
                            <div class="content table-responsive table table-striped">
		<form name="mst_maint_user_form" method="post">
			<table>
				<tr <?php echo $user_id_field; ?>>
					<td>User ID: </td>
					<td><input type="text" name="uid" size="20" value="<?php echo $userid; ?>" readonly /></td>
				</tr>
				<tr>
					<td>User Email: </td>
					<td><input type="text" name="uemail" value="<?php echo $useremail; ?>" size="50" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"></td>
				</tr>
				<tr>
					<td>User Password: </td>
					<td><input type="password" name="upw" size="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" oninput="checkpw(this);"/></td>
				</tr>
				<tr>
					<td>User Name: </td>
					<td><input type="text" name="uname" value="<?php echo $usersname; ?>" size="20" oninput="chk_name(this);"/></td>
				</tr>
				<tr>
					<td>User Group</td>
					<td>
						<select name="ugroup">
							<option value="1" <?php echo $usergroup == "1" ? "selected" : "" ?>>Staff</option>
							<option value="0" <?php echo $usergroup == "0" ? "selected" : "" ?>>Admin</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="maint_user_submit" value="Save" onclick="return validate();"/>
						<input type="submit" name="maint_user_delete" value="Delete" <?php echo $delete_btn; ?>/>
						<input type="submit" name="maint_user_cancel" value="Cancel"/>
					</td>
				</tr>
			</table>
			  </div>
                        </div>
                    </div>
		
		</form>
	</body>
</html>

<?php
	//if save button clicked
	if(isset($_POST["maint_user_submit"])){
		
		$upw = md5($upw); //password encryption
		
		//if edit mode
		if(isset($userid)){
			
			if($upw == ""){
				$update_pw = "";
				
			}
			else{
				$update_pw = ', upw="'.$upw.'", ufirst_login="1"';
			}
			
			$sql_edit_user = 'UPDATE users
							SET uemail="'.$uemail.'", uname="'.$uname.'", ugroup="'.$ugroup.'" '.$update_pw.'
							WHERE uid="'.$userid.'";';
			$conn->query($sql_edit_user);
			
			echo "<script>
					alert('Changes Saved');
					location.assign('mst_lst_user.php".$qr_string."');
				</script>";		
		}
		else{ //if add new
		
			//if email existed
			$sql_user_exists = "SELECT * FROM users WHERE uemail = '$uemail'"; 
			$result_user_exists = $conn->query($sql_user_exists);
			
			if ($result_user_exists->num_rows != 0){
				echo '<script>
					alert("Username already existed! Record doesn\'t saved");
				</script>';
			}
			else{
				$sql_new_user = 'INSERT INTO users (uemail,uname,ugroup,upw,ufirst_login)
								VALUES
								("'.$uemail.'","'.$uname.'","'.$ugroup.'","'.$upw.'","1");';
				$conn->query($sql_new_user);
				
				echo "<script>alert('Record Added');location.assign('mst_lst_user.php".$qr_string."');</script>";	
			}
		}
	}
	else if(isset($_POST["maint_user_delete"])){ //if delete button clicked
		
		$sql_delete_user = 'DELETE FROM users
						WHERE uid = "'.$userid.'"';
		$conn->query($sql_delete_user);

		echo "<script>alert('Record Deleted');location.assign('mst_lst_user.php".$qr_string."');</script>";		
	}
	else if(isset($_POST["maint_user_cancel"])){ //if cancel button clicked
		echo "<script>location.assign('mst_lst_user.php".$qr_string."');</script>";	
	}
?>