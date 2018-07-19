<?php
	require_once 'php_function/general.php'; //general php function
	require_once 'php_function/function_report.php';
	
	/*get user information*/
	$user_name = $_SESSION["sess_uname"];
	$user_id = $_SESSION["sess_uid"];
	
	/*get whether it is stock in or out*/
	$mode = $_GET["mode"];
	
	if($mode == "in"){
		$title = "Stock In";
	}
	else if($mode == "out"){
		$title = "Stock Out";
	}
	
	$combobox = datalist_medicine($conn,"trans");
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?> | Pharmacy Inventory Management System</title>
		
		<link href="css/general.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
		<script src="javascript_function/general.js" type="text/javascript"></script>
		
		<script>
		//check if the input is valid
		function check_input(str){ 
			
			var index_num = get_row_index(str); //get the input field's index number
			
			prd_value = str.value; //get the value of the field
			
			/*ajax function*/
			var xhttp;
			if (prd_value.length == 0) { //if the field is empty
				document.getElementById("prd_price["+index_num+"]").value="0.00";
				return;
			}
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					returnstring = this.responseText; //return string from php
					if(returnstring == 1){ //if the input is valid
						fill_price(str); //fill in the price field
						fill_qty(str);
						document.getElementById("prd_name["+index_num+"]").style.border = ""; //remove error indicator
					}
					else{
						alert("Invalid Input");
						document.getElementById("prd_name["+index_num+"]").style.border = "2px solid red"; //error indicator
						document.getElementById("prd_name["+index_num+"]").focus();
						document.getElementById("prd_name["+index_num+"]").value = "";
						document.getElementById("prd_price["+index_num+"]").value="0.00";
					}
				}
			};
			xhttp.open("GET", "ajax/ajax_medicine_list.php?q="+prd_value, true); //pass to php file
			xhttp.send(); 
		}
		//save the prd_id in hidden field for later use
		function get_prd_id(index_num,prd_id){ 
			document.getElementById("prd_id["+index_num+"]").value=prd_id;
		}
		//fill in the price field according to the product selected
		function fill_price(str){ 
			
			var index_num = get_row_index(str); //get input field index number
			
			var xhttp;
			
			//get the prd_id by the product selected
			var med = str.value.split(" - ");
			var med_id = med[0];
			
			var mode = document.getElementById("hid_mode").value; //stock in or stock out
			
			get_prd_id(index_num,med_id); //save the prd_id in hidden field for later use
			
			/*ajax function*/
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					returnstring = this.responseText; //return string from ajax
					
					document.getElementById("prd_price["+index_num+"]").value=returnstring; //write the price to the field
					
					cal_total(index_num); //calculate the total price
				}
			};
			xhttp.open("GET", "ajax/ajax_medicine_price.php?q="+med_id+"&mode="+mode, true);
			xhttp.send();
		}
		//fill in the quantity before the transaction
		function fill_qty(str){
			var index_num = get_row_index(str); //get input field index number
			
			var xhttp;
			
			//get the prd_id by the product selected
			var med = str.value.split(" - ");
			var med_id = med[0];
			
			/*ajax function*/
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					returnstring = this.responseText; //return string from ajax
					
					document.getElementById("prd_qty_before["+index_num+"]").value=returnstring; //write the qunatity to the hiddenfield
					
					cal_qty_after(index_num); //calculate the total price
				}
			};
			xhttp.open("GET", "ajax/ajax_medicine_qty.php?q="+med_id, true);
			xhttp.send();
		}
		//check if the quantity input is valid
		function check_qty(str){
			if(str.value == ""){ //if empty, do nothing
				return;
			}
			else if(isNaN(str.value) || !Number.isInteger(parseFloat(str.value))){ //if not a number
				
				alert("Invalid Input");
				str.style.border = "2px solid red"; //error indicator
				str.focus();
				str.value = "";
				
			}
			else{
				
				var index_num = get_row_index(str); //get the field index number
				
				cal_total(index_num); //calculate total price
				cal_qty_after(index_num); //calculate quantity after transaction
				str.style.border = ""; //remove error indicator
			}
		}
		//calculate total price
		function cal_total(index_num){ 
			var total=0,unit_price,qty;
			
			qty = document.getElementById("prd_qty["+index_num+"]").value; //get the quantity
			
			unit_price = document.getElementById("prd_price["+index_num+"]").value; //get the unit price
			total = qty * unit_price;
			total = total.toFixed(2);
			document.getElementById("prd_ttl_price["+index_num+"]").value = total; //write into the total field
			
			cal_grand(); //calculate grand total
		}
		//estimate the quantity after the transaction
		function cal_qty_after(index_num){
			var qty=0,qty_before=0,qty_after=0,operator;
			
			var mode = document.getElementById("hid_mode").value; //stock in or stock out
			
			qty_before = parseInt(document.getElementById("prd_qty_before["+index_num+"]").value); //get the quantity before
			
			qty = parseInt(document.getElementById("prd_qty["+index_num+"]").value); //get the qty wish to do transaction
			
			if(isNaN(qty)){
				qty = 0;
			}
			
			if(mode == "in"){
				qty_after = qty_before + qty;
			}
			else if(mode == "out"){
				qty_after = qty_before - qty;
			}
			
			document.getElementById("prd_qty_after["+index_num+"]").value = qty_after; //write into the total field
		}
		//calculate grand total
		function cal_grand(){
			var i,total_rows,grand=0;
			
			total_rows = document.getElementById("input_table").rows.length - 2; //get the total input rows
			
			for(i=0; i < total_rows; i++){
				grand += parseFloat(document.getElementById("prd_ttl_price["+i+"]").value); //grand = total price of each row
			}
			
			document.getElementById("grand_total").innerHTML = "Grand Total: "+grand.toFixed(2); //write grand total into the field
		}
		//add a new row
		function add_new_row(){
			var table = document.getElementById("input_table");
			var row = table.insertRow(-1);
			
			row_index = row.rowIndex-2; //index the field
			
			var cell_name = row.insertCell(0);
			var cell_qty = row.insertCell(1);
			var cell_qty_after = row.insertCell(2);
			var cell_price = row.insertCell(3);
			var cell_total = row.insertCell(4);
			
			cell_name.innerHTML = '<input type="text" name="prd_name['+row_index+']" id="prd_name['+row_index+']" list="medicine_list" size="50" onblur="check_input(this);"><input type="hidden" name="prd_id['+row_index+']"  id="prd_id['+row_index+']"/>';
			cell_qty.innerHTML = '<input type="text" name="prd_qty['+row_index+']" id="prd_qty['+row_index+']" size="3" onblur="check_qty(this);";/>';
			cell_qty_after.innerHTML = '<td><input type="text" name="prd_qty_after['+row_index+']" id="prd_qty_after['+row_index+']" size="3" readonly /><input type="hidden" name="prd_qty_before['+row_index+']" id="prd_qty_before['+row_index+']"/></td>';
			cell_price.innerHTML = '<input type="text" name="prd_price['+row_index+']" id="prd_price['+row_index+']" value="0.00" size="20" readonly />';
			cell_total.innerHTML = '<input type="text" name="prd_ttl_price['+row_index+']" id="prd_ttl_price['+row_index+']" value="0.00" size="20" readonly />';
		}
		//remove last row
		function remove_last_row(){
			if(document.getElementById("input_table").rows.length > 3){ //avoid to delete the first input row
				document.getElementById("input_table").deleteRow(-1);
			}
		}
		//if submit click, check if there is any empty field
		function validate(){
			var i,total_row;
			
			total_row = document.getElementById("input_table").rows.length - 2; //total records
			
			for(i=0;i<total_row;i++){
				if(document.getElementById('prd_name['+i+']').value == ""){
					alert("Please check your information again");
					document.getElementById("prd_name["+i+"]").style.border = "2px solid red";
					document.getElementById("prd_name["+i+"]").focus();
					return false;
				}
				else if(document.getElementById('prd_qty['+i+']').value == ""){
					alert("Please check your information again");
					document.getElementById("prd_qty["+i+"]").style.border = "2px solid red";
					document.getElementById("prd_qty["+i+"]").focus();
					return false;
				}
			}
			
			return true;
		}
		//get the total records and write into hidden field for later use
		function count_total_row(){
			total_row = document.getElementById("input_table").rows.length - 2; //total records
			
			document.stockin_frm.hid_total_row.value=total_row; //write into hidden field
		}
		//get the field index number
		function get_row_index(str){
			var name = str.name; //name of the field
			index_number = name.match(/\[(.*?)\]/); //get the content inside []
			var index_num = index_number[1];
			return index_num;
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
			<a href="inv_lst_med.php" target="_self">

				<p>
					<strong>Medicines</strong>
					<small>listing</small>
				</p>
			</a>
		</li>
		<li>
			<a href="" class="hover active">
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
<?php echo $title; ?>  | Pharmacy Inventory Management System
                </div>
            </div>
        </nav>
		
		
	 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-11">
                        <div class="card">
                            <h3><?php echo $title; ?></h3>
							
                            <div class="content table-striped2 table ">
		
		<p>Date: <?php echo date("Y-m-d")." (".date("l").")"; ?></p>
		<p>Time: <?php echo date("h:ia"); ?></p>
		<p>User: <?php echo $user_name; ?></p>
		<form name="stockin_frm" method="post" action="">
			<table id="input_table">
				<tr>
				</tr>
				<tr>
					<td>Product ID/Name</td>
					<td>Quantity</td>
					<td>Quantity (After)</td>
					<td>Product Price</td>
					<td>Total Price</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="prd_name[0]" id="prd_name[0]" list="medicine_list" size="50" onblur="check_input(this);">
						<input type="hidden" name="prd_id[0]" id="prd_id[0]"/>
					</td>
					<td><input type="text" name="prd_qty[0]" id="prd_qty[0]" size="3" onblur="check_qty(this);"/></td>
					<td>
						<input type="text" name="prd_qty_after[0]" id="prd_qty_after[0]" size="3" readonly />
						<input type="hidden" name="prd_qty_before[0]" id="prd_qty_before[0]"/>
					</td>
					<td><input type="text" name="prd_price[0]" id="prd_price[0]" value="0.00" size="20" readonly /></td>
					<td><input type="text" name="prd_ttl_price[0]" id="prd_ttl_price[0]" size="20" value="0.00" readonly /></td>
					<?php echo $combobox; ?>
				</tr>
			</table>
			<p id="grand_total">Grand Total: 0.00</p>
			<input type="button" name="add_row" value="Add New Row" onclick="add_new_row();count_total_row();"/>
						<input type="button" name="remove_row"  value="Remove Last Row" onclick="remove_last_row();count_total_row();"/>
						<input type="hidden" name="hid_total_row" value="1"/>
						<input type="hidden" name="hid_mode" id="hid_mode" value="<?php echo $mode; ?>"/>
			
			<input style="float:right"type="button" value="Cancel" onclick="cancel_button();"/>
			<input style="float:right"type="submit" name="submit_stockin" value="Confirm" onclick="return validate();"/>
		</form>
	</body>
</html>

<?php
	//if save button clicked
	if(isset($_POST["submit_stockin"])){
		
		if($mode == "in"){
			$operator = "+";
			$values = "trans_qty_in";
		}
		else if($mode == "out"){
			$operator = "-";
			$values = "trans_qty_out";
		}
		
		/*get last group id*/
		$sql_last_groupid = "SELECT trans_group_id FROM transactions ORDER BY trans_group_id DESC LIMIT 1;";
		$result_last_groupid = $conn->query($sql_last_groupid);
		list($last_groupid) = $result_last_groupid->fetch_row();
		
		/*generate new group id*/
		$last_groupid += 1;
		
		/*insert date*/
		$date = date("Y-m-d");
		
		/*insert time*/
		$time = date("H:i");
		
		/*get the parameters*/
		for($i=0;$i<$hid_total_row;$i++){
			
			/*update inventory*/
			$sql_update_inv = "UPDATE inventory SET inv_qty = inv_qty".$operator.$prd_qty[$i]." WHERE inv_prd_id = ".$prd_id[$i].";";
			$conn->query($sql_update_inv);
			
			$prepare_sql[] = '("'.$last_groupid.'","'.$prd_id[$i].'","'.$prd_qty[$i].'","'.$user_id.'","'.$date.'","'.$time.'")';
		}
		$prepare_value_sql = join(",",$prepare_sql);
		
		/*insert into database*/
		$sql_insert_trans = "INSERT INTO transactions (trans_group_id,trans_prd_id,".$values.",trans_user,trans_dt,trans_time)
							VALUES $prepare_value_sql;";
		$conn->query($sql_insert_trans);
		
		/*notify the user that the process is done successfully*/
		echo "<script>alert('Transaction Done');</script>";
	}