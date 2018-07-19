<?php
	require_once 'php_function/general.php'; //general php function
	require_once 'php_function/function_report.php';
	
	$date_month_year = generate_date_month_year_options();
	
	list($year_selection,$month_selection,$date_selection) = explode("|||||",$date_month_year);
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
		<script src="javascript_function/function_report.js" type="text/javascript"></script>
		
		<script>
		function check_amt(){
			if(document.rpt_sales_frm.amount.value == "" || isNaN(document.rpt_sales_frm.amount.value) || !Number.isInteger(parseFloat(document.rpt_sales_frm.amount.value)) || document.rpt_sales_frm.amount.value <= 0){
				document.rpt_sales_frm.amount.style.border = "2px solid red";
				document.rpt_sales_frm.amount.focus();
				document.rpt_sales_frm.amount.select();
				return false;
			}
			else{
				document.rpt_sales_frm.amount.style.border = "";
				return true;
			}
		}
		function validate(){
			if(check_amt()){
				return true;
			}
			else{
				return false;
			}
		}
		function show_hide_date(){
			var len = document.rpt_sales_frm.period.length;
			var i = 0;
			var chosen = "";
			
			for (i = 0; i < len; i++) 
			{
				if (document.rpt_sales_frm.period[i].checked) // checks which radio button is checked
					chosen = document.rpt_sales_frm.period[i];
			}
			period_selected(chosen);
		}
		</script>
	</head>
	
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
Sales Performance Report | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>
		
		
		
		<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="content table-responsive table table-striped">
		
		
		
		<h3>Sales Performance Report</h3>
		<form name="rpt_sales_frm" method="post" action="rpt_sales_result.php">
			<table>
				<tr>
					<td colspan="2"><h4>Report Criteria</h4></td>
				</tr>
				<tr>
					<td>Top/Bottom Sales:</td>
					<td>
						<input type="radio" name="topbtm" value="top" checked /> Top
						<input type="radio" name="topbtm" value="btm" /> Bottom
					</td>
				</tr>
				<tr>
					<td>Amount of the Records:</td>
					<td><input type="text" name="amount" value="10" onblur="check_amt(this.value);"/></td>
				</tr>
				<tr>
					<td>Sales Based On:</td>
					<td>
						<input type="radio" name="method" value="qty" checked /> Quantity
						<input type="radio" name="method" value="profit" /> Profit
					</td>
				</tr>
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
					<td></td>
					<td>
						<input type="submit" name="submit_criteria" value="Generate Report" onclick="return check_amt();"/>
						<input type="button" value="Cancel" onclick="cancel_button();"/>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>