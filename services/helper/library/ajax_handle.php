<?php 
   	error_reporting(0);
	session_start();
	include "../../config/db_connector.php";
	
    $jsArray=array('status'=>0);
	$userId   = $_SESSION['user_srl_id'];
    $requestType = $_POST['ajax_request']; 
    if($requestType=='get_voucher_head'){
        $head_type = $_POST['head_type'];
        if($head_type=='Dr'||$head_type=='Cr'){
            $query = "select * from tbl_account_heads where user_id='$userId' AND head_type='".$head_type."' and head_status =1 order by name ASC";
            $d=mysql_query($query);
            $r=array();
            while($h=mysql_fetch_array($d)){
                //$r[$h['id']]=$h['name'];
                $r[]=$h['id']."/".$h['name'];
            }
            if(!empty($r)){
                $jsArray['status']=1;
                $jsArray['result']=$r;
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($jsArray);
   
?>