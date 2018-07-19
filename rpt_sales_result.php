<?php
require_once 'php_function/general.php'; //general php function

if(isset($_POST["submit_criteria"])){ //if submit was clicked
	
	//top sales or bottom sales
	if($topbtm == "top"){
		$topbtm_order = "DESC";
		$title = "Top ";
	}
	else if($topbtm == "btm"){
		$topbtm_order = "ASC";
		$title = "Bottom ";
	}
	
	$title .= $amount." Sales on ";
	
	//by date/month/year/lifetime
	if($period == "date"){
		$period_where = "AND YEAR(trans_dt) = $period_selection_year AND MONTH(trans_dt) = $period_selection_month AND DAY(trans_date) = $period_selection_date";
		$title .= "$period_selection_date/$period_selection_month/$period_selection_year ";
	}
	else if($period == "month"){
		$period_where = "AND YEAR(trans_dt) = $period_selection_year AND MONTH(trans_dt) = $period_selection_month";
		$title .= "$period_selection_month/$period_selection_year ";
	}
	else if($period == "year"){
		$period_where = "AND YEAR(trans_dt) = $period_selection_year";
		$title .= "$period_selection_year ";
	}
	else if($period == "lifetime"){
		$period_where = "";
		$title .= "Lifetime ";
	}
	
	//by quantity or profit
	if($method == "qty"){
		$method_order = "total_qty";
		$title .= "(By Quantity) ";
	}
	else if($method == "profit"){
		$method_order = "total_profit";
		$title .= "(By Profit) ";
	}
	
	$sql_sales_tmp_delete = "DROP TABLE IF EXISTS tmp_sales_report;";
	$conn->query($sql_sales_tmp_delete);
	
	$sql_sales_tmp = "CREATE TEMPORARY TABLE tmp_sales_report
					SELECT
					CASE WHEN (drug_form = '' OR drug_form IS NULL) AND (drug_dosage = '' OR drug_dosage IS NULL)
					THEN drug_name
					ELSE CASE WHEN drug_form = '' OR drug_form IS NULL 
					THEN CONCAT(drug_name,' (',drug_dosage,')')
					ELSE CASE WHEN drug_dosage = '' OR drug_dosage IS NULL
					THEN CONCAT(drug_name,' (',drug_form,')')
					ELSE CONCAT(drug_name,' (',drug_dosage,' ',drug_form,')') END END END
					AS drug, 
					SUM(trans_qty_out) AS total_qty,
					(SUM(trans_qty_out) * (drug_price-drug_cost)) AS total_profit
					FROM transactions
					INNER JOIN mst_medicine
					ON trans_prd_id = drug_id
					WHERE (trans_qty_out != 0 OR trans_qty_out IS NOT NULL)
					$period_where
					GROUP BY trans_prd_id
					ORDER BY $method_order $topbtm_order, drug ASC
					LIMIT $amount;";
	$conn->query($sql_sales_tmp);
	
	$sql_sales = "SELECT drug,total_qty,total_profit FROM tmp_sales_report;";
	$result_sales = $conn->query($sql_sales);
	
	$sql_sales_total = "SELECT SUM(total_qty) AS grand_qty, SUM(total_profit) AS grand_profit FROM tmp_sales_report;";
	$result_sales_total = $conn->query($sql_sales_total);
	list($grand_qty,$grand_profit) = $result_sales_total->fetch_row();
}
else{
	header("Location: rpt_sales.php"); //if direct access to this page without submit, go back to rpt_sales
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sales Performance Report | Pharmacy Inventory Management System</title>
		
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
Sales Report Result | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Current Inventory Level</h4>
                            </div>
                            <div class="content table-responsive table table-striped">

		<?php
		
		echo "<b>".$title."</b>";
		echo 
		"
		<table>
			<tr>
				<td>Medicine</td>
				<td>Sold Quantity</td>
				<td>Total Profit</td>
			</tr>
		";
		
		if ($result_sales->num_rows > 0) {
			
			while($row = $result_sales->fetch_assoc()){
				echo 
				"
				<tr>
					<td>".$row["drug"]."</td>
					<td>".$row["total_qty"]."</td>
					<td>".$row["total_profit"]."</td>
				</tr>
				";
			}
			echo 
				"
				<tr>
					<td><b>Grand Total</b></td>
					<td><b>".$grand_qty."</b></td>
					<td><b>".$grand_profit."</b></td>
				</tr>
				";
		}
		else{
			echo 
				"
				<tr>
					<td colspan='3'>No Record Found</td>
				</tr>
				";
		}
		echo "</table><br/>";
		?>
		
		<input type="button" name="goback" value="Go Back to Query Page" onclick="go_back();"/>
		</div>
                        </div>
                    </div>
	</body>
</html>
		