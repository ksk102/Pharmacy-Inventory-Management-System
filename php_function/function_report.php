<?php
/*generate today's date, month and year*/
function generate_date_month_year_options(){
	$start_year = mktime(0, 0, 0, 1, 1, 2000);
	$start_year = date("Y", $start_year);
	$this_year = date("Y");
	$this_month = date("m");
	$today = date("d");
	
	$year_selection = "";
	$month_selection = "";
	$date_selection = "";
	
	if($this_month == 1 || $this_month == 3 || $this_month == 5 || $this_month == 7 || $this_month == 8 || $this_month == 10 || $this_month == 12){
		$day_in_month = 31;
	}
	else if($this_month = 2){
		$day_in_month = 28;
		
		if($this_year % 4 == 0){
			$day_in_month = 29;
		}
	}
	else{
		$day_in_month = 30;
	}
	
	for($i=$start_year;$i<=$this_year;$i++){
		if($i == $this_year){
			$selected = "selected";
		}
		else{
			$selected = "";
		}
		
		$year_selection .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}
	
	for($i=1;$i<=12;$i++){
		if($i == $this_month){
			$selected = "selected";
		}
		else{
			$selected = "";
		}
		
		$month_selection .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}
	
	for($i=1;$i<=$day_in_month;$i++){
		if($i == $today){
			$selected = "selected";
		}
		else{
			$selected = "";
		}
		
		$date_selection .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}
	
	return $year_selection."|||||".$month_selection."|||||".$date_selection;
}

/*generate the data of medicine, to be choose by user*/
function datalist_medicine($dbconn,$mode){
	$sql_medicines = "SELECT drug_id, 
					CASE WHEN (drug_form = '' OR drug_form IS NULL) AND (drug_dosage = '' OR drug_dosage IS NULL)
					THEN drug_name
					ELSE CASE WHEN drug_form = '' OR drug_form IS NULL 
					THEN CONCAT(drug_name,' (',drug_dosage,')')
					ELSE CASE WHEN drug_dosage = '' OR drug_dosage IS NULL
					THEN CONCAT(drug_name,' (',drug_form,')')
					ELSE CONCAT(drug_name,' (',drug_dosage,' ',drug_form,')') END END END
					AS drug_name FROM mst_medicine";
	$result_medicines = $dbconn->query($sql_medicines);
	$combobox = "<datalist id='medicine_list'>";
	
	if($mode == "rpt"){
		$combobox .= "<option value='All - All Medicines'></option>";
	}
	
	while($row = $result_medicines->fetch_assoc()){
		$combobox .=
		"
			<option value='".$row["drug_id"]." - ".$row["drug_name"]."'></option>
		";
	}
	$combobox .= "</datalist>";
	
	return $combobox;
}

?>