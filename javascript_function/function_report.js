function period_selected(element){
	var selected;
	
	selected = element.value;
	
	if(selected == "date"){
		document.getElementById("period_selection_date").style.display = '';
		document.getElementById("period_selection_month").style.display = '';
		document.getElementById("period_selection_year").style.display = '';
	}
	else if(selected == "month"){
		document.getElementById("period_selection_date").style.display = 'none';
		document.getElementById("period_selection_month").style.display = '';
		document.getElementById("period_selection_year").style.display = '';
	}
	else if(selected == "year"){
		document.getElementById("period_selection_date").style.display = 'none';
		document.getElementById("period_selection_month").style.display = 'none';
		document.getElementById("period_selection_year").style.display = '';
	}
	else if(selected == "lifetime"){
		document.getElementById("period_selection_date").style.display = 'none';
		document.getElementById("period_selection_month").style.display = 'none';
		document.getElementById("period_selection_year").style.display = 'none';
	}
}
function change_year(selected_year){
	var i,day_in_month;
	var selected_month = document.getElementById("period_selection_month").value;
	
	if(selected_month == 2){
		document.getElementById("period_selection_date").innerHTML = "";
		
		day_in_month = 28;
		
		if(selected_year % 4 == 0){
			day_in_month = 29;
		}
		
		for(i=1;i<=day_in_month;i++){
			document.getElementById("period_selection_date").innerHTML += '<option value="'+i+'">'+i+'</option>';
		}
	}
}
function change_month(selected_month){
	var i,day_in_month;
	var selected_year = document.getElementById("period_selection_year").value;
	
	document.getElementById("period_selection_date").innerHTML = "";
	
	if(selected_month == 2){				
		day_in_month = 28;
		
		if(selected_year % 4 == 0){
			day_in_month = 29;
		}
	}
	else if(selected_month == 1 || selected_month == 3 || selected_month == 5 || selected_month == 7 || selected_month == 8 || selected_month == 10 || selected_month == 12){
		day_in_month = 31;
	}
	else{
		day_in_month = 30;
	}
	
	for(i=1;i<=day_in_month;i++){
		document.getElementById("period_selection_date").innerHTML += '<option value="'+i+'">'+i+'</option>';
	}
}