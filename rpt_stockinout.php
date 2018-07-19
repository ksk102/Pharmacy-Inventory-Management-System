<?php
	require_once 'php_function/general.php'; //general php function
	require_once 'php_function/function_report.php';
	
	/*get today's date, month and year*/
	$date_month_year = generate_date_month_year_options();
	list($year_selection,$month_selection,$date_selection) = explode("|||||",$date_month_year);
	
	/*get whether it is stock in or out*/
	$mode = $_GET["mode"];
	
	if($mode == "in"){
		$title = "Stock In Report";
	}
	else if($mode == "out"){
		$title = "Stock Out Report";
	}
	
	/*get datalist for medicine*/
	$combobox = datalist_medicine($conn,"rpt");
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?> | Pharmacy Inventory Management System</title>
		
	<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<script src="javascript_function/general.js" type="text/javascript"></script>
		<script src="javascript_function/function_report.js" type="text/javascript"></script>
	</head>
	
	<script>
	//check if the input is valid
	function check_input(str){ 
		
		prd_value = str.value; //get the value of the field
		
		/*ajax function*/
		var xhttp;
		if (prd_value.length == 0) { //if the field is empty
			document.getElementById("prd_id").value="";
			return;
		}
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				returnstring = this.responseText; //return string from php
				
				if(document.getElementById("prd_name").value == "All - All Medicines"){
					returnstring = 1;
				}
				
				if(returnstring == 1){ //if the input is valid
					document.getElementById("prd_name").style.border = ""; //remove error indicator
					
					//get the prd_id by the product selected
					var med = prd_value.split(" - ");
					var med_id = med[0];
					document.getElementById("prd_id").value=med_id; //save the prd_id in hidden field for later use
				}
				else{
					alert("Invalid Input");
					document.getElementById("prd_name").style.border = "2px solid red"; //error indicator
					document.getElementById("prd_name").focus();
					document.getElementById("prd_name").value = "";
				}
			}
		};
		xhttp.open("GET", "ajax/ajax_medicine_list.php?q="+prd_value, true); //pass to php file
		xhttp.send(); 
	}
	function show_hide_date(){
		var len = document.rpt_stockinout_frm.period.length;
		var i = 0;
		var chosen = "";
		
		for (i = 0; i < len; i++) 
		{
			if (document.rpt_stockinout_frm.period[i].checked) // checks which radio button is checked
				chosen = document.rpt_stockinout_frm.period[i];
		}
		period_selected(chosen);
	}
	</script>
	
	<body onload="show_hide_date();">
	
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
			<a href="" class="hover active">
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
<?php echo $title; ?> | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php echo $title; ?> </h4>
                            </div>
                            <div class="content table-responsive table table-striped">
							
		<form name="rpt_stockinout_frm" method="post" action="rpt_stockinout_result.php">
			<input type="hidden" name="hid_mode" value="<?php echo $mode; ?>"/>
			<table>
				<tr>
					<td>Period:</td>
					<td>
						<input type="radio" name="period" value="date" checked onclick="period_selected(this);"/> Date
						<input type="radio" name="period" value="month" onclick="period_selected(this);"/> Month
						<input type="radio" name="period" value="year" onclick="period_selected(this);"/> Year
						<input type="radio" name="period" value="lifetime" onclick="period_selected(this);"/> Lifetime
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<select name="period_selection_year" id="period_selection_year" onchange="change_year(this.value);">
							<?php echo $year_selection; ?>
						</select>
						<select name="period_selection_month" id="period_selection_month" onchange="change_month(this.value);">
							<?php echo $month_selection; ?>
						</select>
						<select name="period_selection_date" id="period_selection_date">
							<?php echo $date_selection; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Medicine:</td>
					<td>
						<input type="text" name="prd_name" id="prd_name" list="medicine_list" size="50" value="All - All Medicines" onblur="check_input(this);">
						<input type="hidden" name="prd_id" id="prd_id"/>
					</td>
				</tr>
				<tr>
					<td>User</td>
					<td>
						<select name="user_list">
							<option value="all">All User</option>
						<?php
						/*generate list of users*/
						$sql_user = "SELECT uid, uname FROM users;";
						$result_user = $conn->query($sql_user);
						
						while($row = $result_user->fetch_assoc()){
							echo "<option value='".$row["uid"]."'>".$row["uname"]."</option>";
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="submit_criteria" value="Generate Report"/>
						<input type="button" value="Cancel" onclick="cancel_button();"/>
					</td>
				</tr>
				<?php echo $combobox; ?>
			</table>
			</div>
                        </div>
                    </div>
		</form>
	</body>
</html>