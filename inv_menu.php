<?php
	require_once 'php_function/general.php'; //general php function
	
	//for the inventory level
	$sql_product_available = "SELECT COUNT(1) FROM mst_medicine INNER JOIN inventory ON drug_id = inv_prd_id WHERE inv_qty > 0;";
	$result_product_available = $conn->query($sql_product_available);
	list($product_available) = $result_product_available->fetch_row();
	
	$sql_total_qty = "SELECT SUM(inv_qty) FROM inventory;";
	$result_total_qty = $conn->query($sql_total_qty);
	list($total_qty) = $result_total_qty->fetch_row();
	
	$sql_reorder_required = "SELECT COUNT(1) FROM inventory WHERE inv_qty < 10;";
	$result_reorder_required = $conn->query($sql_reorder_required);
	list($reorder_required) = $result_reorder_required->fetch_row();
	//end inventory level
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Main Menu | Pharmacy Inventory Management System</title>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
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
			<a href="inv_menu.php" target="_self" class="active">

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
				
		</li>
		
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
Main Menu | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <strong>Current Inventory Level</strong>
                            </div>
                            <div class="content table-responsive table table-striped">
		<table>
			<tr>
				<th>Product Available</th>
				<th>Quantity</th>
				<th>Product to Re-Order</th>
			</tr>
			<tr>
				<td><?php echo $product_available; ?></td>
				<td><?php echo $total_qty; ?></td>
				<td><a href="inv_lst_med.php?type=reorder" target="_self"><?php echo $reorder_required; ?></a></td>
			</tr>
		</table>
		  </div>
                        </div>
                    </div>
		
		
		
		<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
						<div class="header">
                                <strong>Top 10 Product Need to Re-Order</strong>
                            </div>
                            <div class="content table-responsive  table table-striped">
		<?php
		//top 10 product need to re-order
			$sql_reorder_list = "SELECT 
				CASE WHEN (drug_form = '' OR drug_form IS NULL) AND (drug_dosage = '' OR drug_dosage IS NULL)
				THEN drug_name
				ELSE CASE WHEN drug_form = '' OR drug_form IS NULL 
				THEN CONCAT(drug_name,' (',drug_dosage,')')
				ELSE CASE WHEN drug_dosage = '' OR drug_dosage IS NULL
				THEN CONCAT(drug_name,' (',drug_form,')')
				ELSE CONCAT(drug_name,' (',drug_dosage,' ',drug_form,')') END END END
				AS drug, 
				inv_qty, drug_cost, drug_price 
				FROM mst_medicine 
				INNER JOIN inventory ON inv_prd_id = drug_id 
				ORDER BY inv_qty, drug
				LIMIT 10;";
			$result_reorder_list = $conn->query($sql_reorder_list);

			if ($result_reorder_list->num_rows > 0) {
				echo 
				"
				<table>
					<tr>
						<th>Medicine</th>
						<th>Quantity</th>
						<th>Cost</th>
						<th>Price</th>
					</tr>
				";
				
				while($row = $result_reorder_list->fetch_assoc()){
					echo 
					"
					<tr>
						<td>".$row["drug"]."</td>
						<td>".$row["inv_qty"]."</td>
						<td>".$row["drug_cost"]."</td>
						<td>".$row["drug_price"]."</td>
					</tr>
					";
				}
				
				echo "</table>";
				echo "<br/>";
			}
			?> </div>
                        </div>
                    </div>
			
			
			
 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
						<div class="header">
                                <strong>Top 10 Sales This Month (By Quantity)</strong>
                            </div>
                            <div class="content table-responsive  table table-striped">
                                <?php
			$sql_top10 = "SELECT
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
								AND YEAR(NOW()) = YEAR(trans_date) AND MONTH(NOW()) = MONTH(trans_date)
								GROUP BY trans_prd_id
								ORDER BY SUM(trans_qty_out) DESC, drug ASC
								LIMIT 10;";
			$result_top10 = $conn->query($sql_top10);

			if ($result_top10->num_rows > 0) {
				
				echo 
				"
				<table>
					<tr>
						<td>Medicine</td>
						<td>Sold Quantity</td>
						<td>Total Profit</td>
					</tr>
				";
				
				while($row = $result_top10->fetch_assoc()){
					echo 
					"
					<tr>
						<td>".$row["drug"]."</td>
						<td>".$row["total_qty"]."</td>
						<td>".$row["total_profit"]."</td>
					</tr>
					";
				}
				
				echo "</table>";
				echo "<br/>";
			}
		?>
                            </div>
                        </div>
                    </div>
	</body>
</html>