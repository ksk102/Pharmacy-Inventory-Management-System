<?php
	require_once 'php_function/general.php'; //general php function
	
	if(isset($_SESSION['qr_string'])){
		$qr_string = $_SESSION['qr_string'];
	}
	
	$title = "Add";
	$delete_btn = 'style="display: none;"';
	$drug_id_field = 'style="display: none;"';
	
	//edit mode
	if(isset($_GET["drugid"])){
		
		$drugid = $_GET["drugid"];
		$title = "Edit";
		$delete_btn = ''; //only appear on edit mode
		$drug_id_field = ''; //only appear on edit mode
		
		
		$sql_med_detail = "SELECT drug_id, drug_name, drug_dosage, drug_form, drug_cost, drug_price, inv_qty
						FROM mst_medicine
						INNER JOIN inventory ON inv_prd_id = drug_id
						WHERE drug_id='$drugid'";
		$result_med_detail = $conn->query($sql_med_detail);
		list($drug_id,$drug_name,$drug_dosage,$drug_form,$drug_cost,$drug_price,$drug_qty) = $result_med_detail->fetch_row(); //list out the drug's details
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
		
		<script type="text/javascript">
		function chk_name(){
			if(document.inv_maint_med_form.med_name.value == ""){
				document.inv_maint_med_form.med_name.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_med_form.med_name.style.border = "";
				return true;
			}
		}
		function chk_cost(){
			if(document.inv_maint_med_form.med_cost.value == "" || isNaN(document.inv_maint_med_form.med_cost.value)){
				document.inv_maint_med_form.med_cost.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_med_form.med_cost.style.border = "";
				return true;
			}
		}
		function chk_price(){
			if(document.inv_maint_med_form.med_price.value == "" || isNaN(document.inv_maint_med_form.med_price.value)){
				document.inv_maint_med_form.med_price.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_med_form.med_price.style.border = "";
				return true;
			}
		}
		function chk_qty(){
			if(document.inv_maint_med_form.med_qty.value == "" || !Number.isInteger(parseFloat(document.inv_maint_med_form.med_qty.value))){
				document.inv_maint_med_form.med_qty.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_med_form.med_qty.style.border = "";
				return true;
			}
		}
		function validate(){
			if(chk_name() && chk_cost() && chk_price() && chk_qty()){
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
			<a href="inv_menu.php" target="_self" >

				<p>
					<strong>Home</strong>
					<small>menu</small>
				</p>
			</a>
		</li>
		<li>
			<a href="inv_lst_med.php" target="_self"  class="active">

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
			<a href="mst_lst_user.php" target="_self">

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
<?php echo $title; ?> Medicine Details | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Current Inventory Level</h4>
                            </div>
                            <div class="content table-responsive table table-striped">
		<form name="inv_maint_med_form" method="post">
			<table>
				
				<tr <?php echo $drug_id_field; ?>>
					<td>Medicine ID: </td>
					<td><input type="text" name="med_id" size="20" value="<?php echo $drug_id; ?>" readonly /></td>
				</tr>
				<tr>
					<td>Medicine Name: </td>
					<td><input type="text" name="med_name" value="<?php echo $drug_name; ?>" size="20" oninput="chk_name();"/></td>
				</tr>
				<tr>
					<td>Medicine Dosage</td>
					<td><input type="text" name="med_dos" value="<?php echo $drug_dosage; ?>" size="20"/></td>
				</tr>
				<tr>
					<td>Medicine Form</td>
					<td><input type="text" name="med_form" value="<?php echo $drug_form; ?>" size="20"/></td>
				</tr>
				<tr>
					<td>Medicine Cost</td>
					<td><input type="text" name="med_cost" value="<?php echo $drug_cost; ?>" size="20" oninput="chk_cost();"/></td>
				</tr>
				<tr>
					<td>Medicine Price</td>
					<td><input type="text" name="med_price" value="<?php echo $drug_price; ?>" size="20" oninput="chk_price();"/></td>
				</tr>
				<tr>
					<td>Quantity</td>
					<td><input type="text" name="med_qty" value="<?php echo $drug_qty; ?>" size="20" oninput="chk_qty();"/></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="maint_med_submit" value="Save" onclick="return validate();"/>
						<input type="submit" name="maint_med_delete" value="Delete" <?php echo $delete_btn; ?>/>
						<input type="submit" name="maint_med_cancel" value="Cancel"/>
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
	if(isset($_POST["maint_med_submit"])){
		//if edit mode
		if(isset($drugid)){
			$sql_edit_med = 'UPDATE mst_medicine
							INNER JOIN inventory ON inv_prd_id = drug_id
							SET drug_name="'.$med_name.'", drug_dosage="'.$med_dos.'", drug_form="'.$med_form.'", drug_cost="'.$med_cost.'", drug_price="'.$med_price.'", inv_qty="'.$med_qty.'"
							WHERE drug_id="'.$drugid.'";';
			$conn->query($sql_edit_med);
			
			echo "<script>
					alert('Changes Saved');
					location.assign('inv_lst_med.php".$qr_string."');
				</script>";		
		}
		else{ //if add new
			$sql_new_med = 'INSERT INTO mst_medicine (drug_name,drug_dosage,drug_form,drug_cost,drug_price)
							VALUES
							("'.$med_name.'","'.$med_dos.'","'.$med_form.'","'.$med_cost.'","'.$med_price.'");';
			$conn->query($sql_new_med);
			$sql_new_qty = 'INSERT INTO inventory (inv_prd_id,inv_qty)
							VALUES
							("'.$conn->insert_id.'","'.$med_qty.'");';
			$conn->query($sql_new_qty);
			
			echo "<script>alert('Record Added');location.assign('inv_lst_med.php".$qr_string."');</script>";	
		}
	}
	else if(isset($_POST["maint_med_delete"])){ //if delete button clicked
		
		$sql_delete_med = 'DELETE FROM mst_medicine
						WHERE drug_id = "'.$drugid.'"';
		$conn->query($sql_delete_med);
		$sql_delete_qty = 'DELETE FROM inventory
						WHERE inv_prd_id = "'.$drugid.'";';
		$conn->query($sql_delete_qty);
		
		echo "<script>alert('Record Deleted');location.assign('inv_lst_med.php".$qr_string."');</script>";		
	}
	else if(isset($_POST["maint_med_cancel"])){ //if cancel button clicked
		echo "<script>location.assign('inv_lst_med.php".$qr_string."');</script>";	
	}
?>