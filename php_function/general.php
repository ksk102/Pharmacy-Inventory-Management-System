<?php

require_once 'db_con.php'; //database connection

//set time zone
date_default_timezone_set("Asia/Kuala_Lumpur");

/*turn off E_NOTICE error reporting*/
error_reporting(E_ALL & ~E_NOTICE);

/*fields name = php variable name*/
if(isset($_GET)){
  while(list($var, $val)=each($_GET)){    	
	$$var=$val;
  }
}
if(isset($_POST)){  
  while(list($var, $val)=each($_POST)){    		
	$$var=$val;	
  }
}
if(isset($_COOKIE)){  
  while(list($var, $val)=each($_COOKIE)){    	
	$$var=$val;
  }
}
if(isset($_SERVER)){
  while(list($var, $val)=each($_SERVER)){    	
	$$var=$val;
  }
}
/*end fields name = php variable name*/

/*prevent access without login*/
$current_url = $_SERVER["PHP_SELF"];
$url_is_index = strpos($current_url,"index.php");
if(!isset($_SESSION["sess_uid"]) && !$url_is_index)
{
	header("Location: index.php");
}
/*end prevent access*/

/*if user try to access login page while already logged in, redirect the menu page*/
function redirect_as_logged_in(){
	if(isset($_SESSION["sess_uid"]))
	{
		header("Location: inv_menu.php");
	}
}

//if user group is not admin hidden the user list link
$hidden_userlist = "style='display:none;'";
	
if($_SESSION["sess_ugroup"] == 0){
	$hidden_userlist = "";
}
?>