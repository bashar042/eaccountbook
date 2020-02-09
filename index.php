<?php
    error_reporting(0);
	session_start();
	include "services/config/db_connector.php";
	include "services/helper/library/check.php";
	include "services/helper/library/functions.php";	 

	$check = new CHECK();
	if(isset($_GET['module'])){
		$module=$_GET['module'];
	}
	else{
		$module='';
	}
	if(isset($_GET['page'])){
		$page=$_GET['page'];
	}
	else{
		$page='';
	}
	
	if($module != '' && $page != ''){// exit('25');
		$base_url = "services/";
		include $base_url."index.php";
	}
	elseif($module == '' && $page != ''){
		$base_url = "";
		include $base_url."landing_index.php";
	}
	elseif($module == '' && $page == ''){ 
		$base_url = "";
		include $base_url."landing_index.php";
	}
	else{
		$base_url = "";
		include $base_url."pages/informations/page_not_found.php";
	}
	
?>    