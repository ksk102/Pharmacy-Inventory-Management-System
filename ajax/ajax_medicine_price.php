<?php
/*to get the product price*/

require_once '../php_function/general.php';

$q = $_REQUEST["q"];
$mode = $_REQUEST["mode"];

//stock in or stock out
if($mode == "in"){
	$select = "drug_cost";
}
else if($mode == "out"){
	$select = "drug_price";
}

$sql_price = 'SELECT '. $select .' FROM mst_medicine WHERE drug_id = "'.$q.'";';
$result_price = $conn->query($sql_price);
list($price) = $result_price->fetch_row();

echo $price;

?>