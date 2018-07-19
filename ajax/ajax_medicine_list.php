<?php
//check if the input value in the product field is valid

require_once '../php_function/general.php';

$q = $_REQUEST["q"];
$r_value = 0;

$sql_medicines = "SELECT drug_id, 
				CASE WHEN (drug_form = '' OR drug_form IS NULL) AND (drug_dosage = '' OR drug_dosage IS NULL)
				THEN drug_name
				ELSE CASE WHEN drug_form = '' OR drug_form IS NULL 
				THEN CONCAT(drug_name,' (',drug_dosage,')')
				ELSE CASE WHEN drug_dosage = '' OR drug_dosage IS NULL
				THEN CONCAT(drug_name,' (',drug_form,')')
				ELSE CONCAT(drug_name,' (',drug_dosage,' ',drug_form,')') END END END
				AS drug_name FROM mst_medicine";
$result_medicines = $conn->query($sql_medicines);

while($row = $result_medicines->fetch_assoc()){
	$medicines = $row["drug_id"]." - ".$row["drug_name"];
	
	if($q == $medicines){
		$r_value = 1;
		break;
	}
}

echo $r_value;
?>