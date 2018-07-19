<?php
	require_once 'php_function/general.php'; //general php function
	
	if($_SESSION["sess_ugroup"] != 0){
		header("Location: inv_menu.php");
	}
	
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
	
	/*search function*/
	if(isset($_GET["f_user_submit"])){
		if($f_uid != ""){
			$where .= " AND uid = '$f_uid' ";
		}
		if($f_uemail != ""){
			$where .= " AND uemail LIKE '%".trim($f_uemail)."%'";
		}
		if($f_uname != ""){
			$where .= " AND uname LIKE '%".trim($f_uname)."%'";
		}
		if($f_ugroup != ""){
			$where .= " AND ugroup LIKE '%".trim($f_ugroup)."%'";
		}
	}
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>User Listing | Pharmacy Inventory Management System</title>
		
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
			<a href="mst_lst_user.php" target="_self" class="active">

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
User Listing | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            
                            <div class="content table-responsive table">
		<!--filter-->
		<form name="search_form" method="get" action="">
			<table>
				<h3>Search User</h3>
				<tr>
					<td>User ID:</td>
					<td><input type="text" name="f_uid" size="20" value="<?php echo $f_uid; ?>"></td>
				</tr>
				<tr>
					<td>User Email:</td>
					<td><input type="text" name="f_uemail" size="20" value="<?php echo $f_uemail; ?>"></td>
				</tr>
				<tr>
					<td>User Name:</td>
					<td><input type="text" name="f_uname" size="20" value="<?php echo $f_uname; ?>"></td>
				</tr>
				<tr>
					<td>User Group:</td>
					<td>
						<select name="f_ugroup">
							<option value="" <?php echo $f_ugroup == "" ? "selected" : "" ?>>All</option>
							<option value="0" <?php echo $f_ugroup == "0" ? "selected" : "" ?>>Admin</option>
							<option value="1" <?php echo $f_ugroup == "1" ? "selected" : "" ?>>Staff</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="f_user_submit" value="Search">
						<input type="reset" name="f_user_reset" value="Reset">
					</td>
				</tr>
			</table>
		</form>
		<!--end filter-->
		

		
		 </div>
                        </div>
                    </div>
		
		
		<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            
                            <div class="content table-responsive table table-striped">
		
		
		
		
		<!--user listing-->
		<table>
			<h3>User Listing <?php echo $title ?><a href="mst_maint_user.php" style="font-size:20px;float:right;padding-right:33px;" target="_self">Add New</a></h3>
			<tr>
				<th>User ID</th>
				<th>User Email</th>
				<th>User Name</th>
				<th>User Group</th>
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
			
			$sql_user_lst = "SELECT uid,uemail,uname,ugroup 
							FROM users 
							$where
							ORDER BY uid ASC
							LIMIT $start_from,$per_page
							;";
			$result_user_lst = $conn->query($sql_user_lst);
			
			//list down the records
			if ($result_user_lst->num_rows > 0) {				
				while($row = $result_user_lst->fetch_assoc()){
					$usergroup = $row["ugroup"] == "0" ? "Admin" : "Staff";
					
					echo 
					"
					<tr>
						<td><a href='mst_maint_user.php?userid=".$row["uid"]."'' target='_self'>".$row["uid"]."</a></td>
						<td>".$row["uemail"]."</td>
						<td>".$row["uname"]."</td>
						
						<td>".$usergroup."</td>
					</tr>
					";
				}
			}
			else{
				echo
				"<tr>
					<td colspan='4'>no record found</td>
				</tr>
				";
			}
			?>
		</table>
		
		<?php
		/*pagination*/
		$sql_total_line = "SELECT COUNT(1)
						FROM users
						$where";
		$result_total_line = $conn->query($sql_total_line);
		list($total_line) = $result_total_line->fetch_row(); //total of the records

		//Using ceil function to divide the total records on per page
		$total_pages = ceil($total_line / $per_page);
		
		if($total_pages > 1){
			//Going to first page
			echo "<a href='mst_lst_user.php".$qr_string."page=1'><<&nbsp;&nbsp;</a>";

			for ($i=1; $i<=$total_pages; $i++) {
				if($_GET['page']==$i)
				{
					$selected_page = "style='color:red;'";
				}
				else{
					$selected_page = "";
				}
				echo "<a href='mst_lst_user.php".$qr_string."page=".$i."' ".$selected_page.">".$i."&nbsp;&nbsp;</a>";
			};
			// Going to last page
			echo "<a href='mst_lst_user.php".$qr_string."page=$total_pages'>>>&nbsp;&nbsp;</a>";
		}
		/*end pagination*/
		?>
		 </div>
                        </div>
                    </div>
		
		<!--end user listing-->
	</body>
</html>