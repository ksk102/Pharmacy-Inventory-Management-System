<?php
require_once 'php_function/general.php'; //general php function

if(isset($_POST["submit_criteria"])){ //if submit was clicked

	//medicine
	if($prd_id == "" || $prd_id == "All"){
		$medicine_where = "";
		$medicine_select = "";
		$medicine_group = "";
		$title = "All Medicines ";
		$hidden = "style='display:none;'";
		$colspan = "6";
	}
	else{
		$medicine_where = "AND drug_id = $prd_id";
		$medicine_select = ", uname";
		$medicine_group = ", uid";
		$title = $prd_name." ";
		$hidden = "";
		$colspan = "7";
	}
	
	//stock in or stock out
	if($hid_mode == "in"){
		$in_out = "trans_qty_in";
		$cost_price = "drug_cost";
		$big_title = "Stock In";
		$title .= "Stock In ";
		$td_title = "Cost";
	}
	else{
		$in_out = "trans_qty_out";
		$cost_price = "drug_price";
		$big_title = "Stock Out";
		$title .= "Stock Out ";
		$td_title = "Revenue";
	}
	
	$title .= "Report ";
	
	//by date/month/year/lifetime
	if($period == "date"){
		$period_where = "AND YEAR(trans_dt) = $period_selection_year AND MONTH(trans_dt) = $period_selection_month AND DAY(trans_date) = $period_selection_date";
		$title .= "(On $period_selection_date/$period_selection_month/$period_selection_year ";
	}
	else if($period == "month"){
		$period_where = "AND YEAR(trans_dt) = $period_selection_year AND MONTH(trans_dt) = $period_selection_month";
		$title .= "(On $period_selection_month/$period_selection_year ";
	}
	else if($period == "year"){
		$period_where = "AND YEAR(trans_dt) = $period_selection_year";
		$title .= "(On $period_selection_year ";
	}
	else if($period == "lifetime"){
		$period_where = "";
		$title .= "(On Lifetime ";
	}
	
	//user
	if($user_list == "" || $user_list == "all"){
		$user_where = "";
		$title .= "By All Users)";
	}
	else{
		$user_where = "AND uid = $user_list";
		
		$sql_user = "SELECT uname FROM users WHERE uid = $user_list";
		$result_user = $conn->query($sql_user);
		list($user_name) = $result_user->fetch_row();
		$title .= "By $user_name)";
	}
	
	/*drop temporary table*/
	$sql_stockinout_tmp_delete = "DROP TABLE IF EXISTS tmp_stockinout_report;";
	$conn->query($sql_stockinout_tmp_delete);
	
	/*generate the report based on query*/
	$sql_stockinout_tmp = "CREATE TEMPORARY TABLE tmp_stockinout_report
							SELECT drug_id, CASE WHEN (drug_form = '' OR drug_form IS NULL) AND (drug_dosage = '' OR drug_dosage IS NULL)
							THEN drug_name
							ELSE CASE WHEN drug_form = '' OR drug_form IS NULL 
							THEN CONCAT(drug_name,' (',drug_dosage,')')
							ELSE CASE WHEN drug_dosage = '' OR drug_dosage IS NULL
							THEN CONCAT(drug_name,' (',drug_form,')')
							ELSE CONCAT(drug_name,' (',drug_dosage,' ',drug_form,')') END END END
							AS drug_name,
							drug_cost, drug_price,SUM($in_out) AS total_qty,
							$cost_price * SUM($in_out) AS total_costprice $medicine_select
							FROM mst_medicine
							INNER JOIN transactions
							ON trans_prd_id = drug_id
							INNER JOIN users
							ON trans_user = uid
							WHERE ($in_out != 0 AND $in_out IS NOT NULL)
							$period_where
							$medicine_where
							$user_where
							GROUP BY drug_id $medicine_group
							ORDER BY drug_id;";
	$result_stockinout_tmp = $conn->query($sql_stockinout_tmp);
	
	/*show the report*/
	$sql_stockinout = "SELECT * FROM tmp_stockinout_report;";
	$result_stockinout = $conn->query($sql_stockinout);
	
	/*get the total*/
	$sql_stockinout_total = "SELECT SUM(total_qty) AS grand_qty, SUM(total_costprice) AS grand_costprice FROM tmp_stockinout_report;";
	$result_stockinout_total = $conn->query($sql_stockinout_total);	
	list($grand_qty,$grand_costprice) = $result_stockinout_total->fetch_row();
}
else{
	header("Location: rpt_sales.php"); //if direct access to this page without submit, go back to rpt_stockinout.php
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $big_title; ?> Report | Pharmacy Inventory Management System</title>
		
		<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<script src="javascript_function/general.js" type="text/javascript"></script>
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
<?php echo $big_title; ?> Report | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="content table-responsive table table-striped">
		
		<?php
			echo "<b>".$title."</b>";
		?>
		
		<table>
			<tr>
				<td>ID</td>
				<td>Medicine</td>
				<td>Cost</td>
				<td>Price</td>
				<td>Total Quantity <?php echo $big_title; ?></td>
				<td>Total <?php echo $td_title; ?></td>
				<td <?php echo $hidden; ?>>User</td>;
			</tr>
			
			<?php
			
			if ($result_stockinout->num_rows > 0) {
				while($row = $result_stockinout->fetch_assoc()){
					echo 
					"
					<tr>
						<td>".$row["drug_id"]."</td>
						<td>".$row["drug_name"]."</td>
						<td>".$row["drug_cost"]."</td>
						<td>".$row["drug_price"]."</td>
						<td>".$row["total_qty"]."</td>
						<td>".$row["total_costprice"]."</td>
						<td ".$hidden.">".$row["uname"]."</td>
					</tr>
					";
				}
				echo 
				"
					<tr>
						<td><b>Grand Total</b></td>
						<td></td>
						<td></td>
						<td></td>
						<td><b>".$grand_qty."</b></td>
						<td><b>".$grand_costprice."</b></td>
						<td ".$hidden."></td>
					</tr>
				";
			}
			else{
				echo 
					"
					<tr>
						<td colspan='$colspan'>No Record Found</td>
					</tr>
					";
			}
			
			?>
		</table>
		<br/>
		<input type="button" name="goback" value="Go Back to Query Page" onclick="go_back();"/>
		</div>
                        </div>
                    </div>
		
	</body>
</html>