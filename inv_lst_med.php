<?php
	require_once 'php_function/general.php'; //general php function
	
	/*get the url parameter string*/
	reset ($_GET);
	$qr_string = "?";
	while (list ($key, $val) = each ($_GET)) {
		$qr_string .= "$key=$val&";
	}
	$_SESSION['qr_string'] = $qr_string;
	/*end - get the url parameter string*/

	/*initialise variable*/
	$where = " WHERE 1=1 ";
	
	//product that need to re-order
	if(isset($_GET["type"])){
		$type = $_GET["type"];
		
		if($type == "reorder"){
			$title = "(To re-order)";
			$where = " AND inv_qty < 10 ";
		}
	}
	//end - product that need to re-order
	
	/*search function*/
	if(isset($_GET["f_med_submit"])){
		if($f_med_id != ""){
			$where .= " AND drug_id = '$f_med_id' ";
		}
		if($f_med_name != ""){
			$where .= " AND drug_name LIKE '%".trim($f_med_name)."%'";
		}
		if($f_med_cost_from != ""){
			$where .= " AND drug_cost >= '$f_med_cost_from' ";
		}
		if($f_med_cost_to != ""){
			$where .= " AND drug_cost <= '$f_med_cost_to' ";
		}
		if($f_med_price_from != ""){
			$where .= " AND drug_price >= '$f_med_price_from' ";
		}
		if($f_med_price_to != ""){
			$where .= " AND drug_price <= '$f_med_price_to' ";
		}
		if($f_med_left_from != ""){
			$where .= " AND inv_qty >= '$f_med_left_from' ";
		}
		if($f_med_left_to != ""){
			$where .= " AND inv_qty <= '$f_med_left_to' ";
		}
		if((!is_numeric($f_med_cost_from) && $f_med_cost_from != "") || (!is_numeric($f_med_cost_to) && $f_med_cost_to != "") || (!is_numeric($f_med_price_from) && $f_med_price_from != "") || (!is_numeric($f_med_price_to) && $f_med_price_to != "") || (!is_numeric($f_med_left_from) && $f_med_left_from != "") || (!is_numeric($f_med_left_to) && $f_med_left_to != "")){
			$where .= "AND 1 != 1";
		}
	}
	/*end - search function*/
	
	/*sort function*/
	if(isset($_GET["sort"])){
		$sort = $_GET["sort"];
		if($sort == "medid"){
			$sortby = "drug_id,";
		}
		else if($sort == "medname"){
			$sortby = "drug_name,";
		}
		else if($sort == "meddosage"){
			$sortby = "drug_dosage,";
		}
		else if($sort == "medform"){
			$sortby = "drug_form,";
		}
		else if($sort == "medcost"){
			$sortby = "drug_cost,";
		}
		else if($sort == "medprice"){
			$sortby = "drug_price,";
		}
		else if($sort == "medamount"){
			$sortby = "inv_qty,";
		}
	}
	/*end - sort*/
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Medicines Listing | Pharmacy Inventory Management System</title>
		<link href="css/general.css" rel="stylesheet" type="text/css"/>
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
			<a href="inv_menu.php" target="_self" >

				<p>
					<strong>Home</strong>
					<small>menu</small>
				</p>
			</a>
		</li>
		<li>
			<a href="inv_lst_med.php" target="_self" class="active" >

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
Medicines Listing  | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>
	
	
	
		<div class="content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="content table">
		<form name="search_form" method="get" action="">

			<table>
				<h3>Search Medicine</h3>
				<tr>
					<td>Med ID:</td>
					<td colspan="3"><input type="text" name="f_med_id" size="30" value="<?php echo $f_med_id; ?>"></td>
				</tr>
				<tr>
					<td>Med Name:</td>
					<td colspan="3"><input type="text" name="f_med_name" size="30" value="<?php echo $f_med_name; ?>"></td>
				</tr>
				<tr>
					<td>Cost From:</td>
					<td><input type="text" name="f_med_cost_from" size="10" value="<?php echo $f_med_cost_from; ?>"></td>
					<td>To:</td>
					<td><input type="text" name="f_med_cost_to" size="10" value="<?php echo $f_med_cost_to; ?>"></td>
				</tr>
				<tr>
					<td>Price From:</td>
					<td><input type="text" name="f_med_price_from" size="10" value="<?php echo $f_med_price_from; ?>"></td>
					<td>To:</td>
					<td><input type="text" name="f_med_price_to" size="10" value="<?php echo $f_med_price_to; ?>"></td>
				</tr>
				<tr>
					<td>Amt Left:</td>
					<td><input type="text" name="f_med_left_from" size="10" value="<?php echo $f_med_left_from; ?>"></td>
					<td>To:</td>
					<td><input type="text" name="f_med_left_to" size="10" value="<?php echo $f_med_left_to; ?>"></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="3">
						<input type="submit" name="f_med_submit" value="Search">
						<input type="reset" name="f_med_reset" value="Reset">
					</td>
				</tr>
			</table>
			</div></div></div> 
          
		
			
			<input type="hidden" name="type" value="<?php echo $type ?>"/>
		</form>
		<!--end filter-->
		
		<!--medicines listing-->
		<div class="content">

                    <div class="col-md-8">
                        <div class="card">
                          <div class="content table-responsive  table table-striped">
		<table>
			<h3>Medicines Listing <a style="font-size:20px;float:right;padding-right:30px;"href="inv_maint_med.php" target="_self">Add New</a><?php echo $title ?></h3>
			<tr>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medid" ?>" target="_self">Med ID</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medname" ?>" target="_self">Med Name</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=meddosage" ?>" target="_self">Med Dosage</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medform" ?>" target="_self">Med Form</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medcost" ?>" target="_self">Med Cost</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medprice" ?>" target="_self">Med Price</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medamount" ?>" target="_self">Amt Left</a></th>
				<!--<th>Category</th>-->
			</tr>
			<?php
			
			/*pagination*/
			$per_page=20;
			if(isset($_GET["page"])){
				$page = $_GET["page"];
			}
			else{
				$page=1;
			}
			
			// Page will start from 0 and Multiple by Per Page
			$start_from = ($page-1) * $per_page;
			/*end pagination*/
			
			//top 10 product need to re-order
			$sql_med_lst = "SELECT drug_id, drug_name, drug_dosage, drug_form, drug_cost, drug_price, inv_qty
							FROM mst_medicine
							INNER JOIN inventory ON inv_prd_id = drug_id 
							$where
							ORDER BY $sortby drug_id ASC
							LIMIT $start_from,$per_page
							;";
			$result_med_lst = $conn->query($sql_med_lst);
			
			//list down the records
			if ($result_med_lst->num_rows > 0) {				
				while($row = $result_med_lst->fetch_assoc()){
					echo 
					"
					<tr>
						<th><a href='inv_maint_med.php?drugid=".$row["drug_id"]."' target='_self'>".$row["drug_id"]."</a></th>
						<td>".$row["drug_name"]."</td>
						<td>".$row["drug_dosage"]."</td>
						<td>".$row["drug_form"]."</td>
						<td>".$row["drug_cost"]."</td>
						<td>".$row["drug_price"]."</td>
						<td>".$row["inv_qty"]."</td>
					</tr>
					";
				}
			}
			else{
				echo
				"<tr>
					<td colspan='7'>no record found</td>
				</tr>
				";
			}
			?>
		</table>
		
		<?php
		/*pagination*/
		$sql_total_line = "SELECT COUNT(1)
						FROM mst_medicine
						INNER JOIN inventory ON inv_prd_id = drug_id 
						$where";
		$result_total_line = $conn->query($sql_total_line);
		list($total_line) = $result_total_line->fetch_row(); //total of the records

		//Using ceil function to divide the total records on per page
		$total_pages = ceil($total_line / $per_page);
		
		if($total_pages > 1){
			//Going to first page
			echo "<a href='inv_lst_med.php".$qr_string."page=1'><<&nbsp;&nbsp;</a>";

			for ($i=1; $i<=$total_pages; $i++) {
				if($_GET['page']==$i)
				{
					$selected_page = "style='color:red;'";
				}
				else{
					$selected_page = "";
				}
				echo "<a href='inv_lst_med.php".$qr_string."page=".$i."' ".$selected_page.">".$i."&nbsp;&nbsp;</a>";
			};
			// Going to last page
			echo "<a href='inv_lst_med.php".$qr_string."page=$total_pages'>>>&nbsp;&nbsp;</a>";
		}
		/*end pagination*/
		?>
	

		<!--end medicines listing-->
	</body>
</html>