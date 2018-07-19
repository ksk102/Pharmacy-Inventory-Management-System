<?php
/*to get the product price*/

require_once '../php_function/general.php';

$q = $_REQUEST["q"];

$sql_qty = 'SELECT inv_qty FROM inventory WHERE inv_prd_id = "'.$q.'";';
$result_qty = $conn->query($sql_qty);
list($qty) = $result_qty->fetch_row();

echo $qty;

?>