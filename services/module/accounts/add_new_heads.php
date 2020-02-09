<?php
$userId   = $_SESSION['user_srl_id'];

if(isset($_POST['btnAddHeads']))
{
	$headName = $_POST['headName'];
	
	if($headName=="" || $headName==null){
		$_SESSION['userMsg'] = "Head name can not be blank !";
		$_SESSION['alert'] = "danger";
		header("Location:?module=sys_settings&page=heads");
		exit;
	}
	$isAldearyExisted = numOfExistedData("tbl_account_heads","user_id='$userId' AND name='$headName'");
	if($isAldearyExisted>0){
		$_SESSION['userMsg'] = "Duplicate head. It's already existed. !";
		$_SESSION['alert'] = "danger";
		header("Location:?module=sys_settings&page=heads");
		exit;
	}
	$data = array(
	    'user_id'   => $userId,   
		'name'      => $headName,
		'create_at' => date('Y-m-d H:i:s')
	);
	$isInsert = insertData("tbl_account_heads",$data);
	 if($isInsert){
	    $_SESSION['alert'] = "success"; 
	    $_SESSION['userMsg'] = "Data saved successfully !";
		header("Location:?module=sys_settings&page=heads");
		exit;
	 }
	 else{
	    $_SESSION['alert'] = "danger"; 
	    $_SESSION['userMsg'] = "Sorry, data not saved !";
		header("Location:?module=sys_settings&page=heads");
		exit;
	 }
}
if(isset($_POST['btnUpdateHead'])){
    $headName = $_POST['headName'];
	$updateId = $_POST['updateId'];
	if($headName=="" || $headName==null){
		$_SESSION['userMsg'] = "Head name can not be blank !";
		$_SESSION['alert'] = "danger";
		header("Location:?module=sys_settings&page=heads");
		exit;
	}
    $isAldearyExisted = numOfExistedData("tbl_account_heads","id!='$updateId' AND user_id='$userId' AND name='$headName'");
	if($isAldearyExisted>0){
		$_SESSION['userMsg1'] = "Duplicate head. It's already existed. !";
		$_SESSION['alert1'] = "danger";
		header("Location:?module=sys_settings&page=heads");
		exit;
	}
	$data = array(
		'name' => $headName,
		'create_at' => date('Y-m-d H:i:s')
	);
	$where = array(
	'id' => $updateId,
	);
	$isUpdate = updateData("tbl_account_heads",$data,$where);
	if($isUpdate){
	    $_SESSION['alert1'] = "success"; 
	    $_SESSION['userMsg1'] = "Data is updated successfully !";
		header("Location:?module=sys_settings&page=heads");
		exit;
	 }
	 else{
	    $_SESSION['alert1'] = "danger"; 
	    $_SESSION['userMsg1'] = "Sorry, data not updated !";
		header("Location:?module=sys_settings&page=heads");
		exit;
	 }
}
if(isset($_POST['btnDeleteHead'])){
	$updateId = $_POST['updateId'];
	$res = mysql_query("UPDATE `tbl_account_heads` SET head_status='0' where id='$updateId'");
	if($res){
	    $_SESSION['alert1'] = "success"; 
	    $_SESSION['userMsg1'] = "Your requested head is deleted successfully !";
		header("Location:?module=sys_settings&page=heads");
		exit;
	 }
	 else{
	    $_SESSION['alert1'] = "danger"; 
	    $_SESSION['userMsg1'] = "Sorry, data not deleted !";
		header("Location:?module=sys_settings&page=heads");
		exit;
	 }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Add New Heads | eAccount Book</title>		
    </head>
    <body>
        <div style="text-align: left;">
            
        </div>

		<div class="panel panel-default input_form_inner_content">
			<div class="panel-heading">
				<h3 class="panel-title page_title">Add New Accounts Head
				<ol class="breadcrumb">
					<li><?=$reqPage['module_title']?></li>
					<li class="active"><a href="?module=<?=$reqPage['module_value']?>&page=<?=$reqPage['page_value']?>"><?=$reqPage['page_title']?></a></li>
				</ol>
				</h3>
			</div>
		<div class="panel-body">							 
			<div class="input_field_content input_form">
				<div class="row">
					<div class="col-lg-4">
						<?php
						if($_SESSION['userMsg'] != "" )
						{
						?>
						<div class="row">
							<div class="alert alert-<?=$_SESSION['alert']?>">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php
										echo "\t".$_SESSION['userMsg'];
										$_SESSION['userMsg']='';
									?>
							</div>
						</div>
						<?php
						}              
						?>						
						<form method="post">
							<div class="row title_div">Add New Head</div>
							
							<div class="row field_div">
								Head Name<span style="color:red;">*</span><br/>
								<input name="headName" type="text" class="form-control" placeholder="Enter a head name"/>
							</div>
							<div class="row field_div updt_btn_content" style="">
								<input type="reset" value="Cancel" class="btn btn-warning"/>
								<input type="submit" value="Submit »" name="btnAddHeads" class="btn btn-success" /> 
							</div>							
						</form>						
					</div>
					<div class="col-lg-1"></div>
					<div class="col-lg-7">
						<div class="row title_div">List of Heads</div>
						<?php
						if($_SESSION['userMsg1'] != "" )
						{
						?>
						<div class="row">
							<div class="alert alert-<?=$_SESSION['alert1']?>">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php
										echo "\t".$_SESSION['userMsg1'];
										unset($_SESSION['userMsg1']);
										unset($_SESSION['alert1']);
									?>
							</div>
						</div>
						<?php
						}              
						?>						
                        <div class="row">						
							<div class="table-responsive">								
								<table class="table table-bordered">
									<thead class="rpt_thead">
										<tr>
											<th style="text-align:center">#</th>
											<th style="text-align:center">Head Name</th>
											<th style="text-align:center;width:100px">Action</th>												
										</tr>
									</thead>														
										<?php
										$sl=1;									
										$sql="SELECT * FROM `tbl_account_heads` 
										WHERE user_id='$userId' AND head_status=1 ORDER BY name";
										$run = mysql_query($sql);
										$num = mysql_num_rows($run);
										if($num > 0)
										{
											while($row=mysql_fetch_array($run)){
												if($sl%2==0){ $headTr="background-color:#F3F4F5";}
												else{ $headTr="background-color:#FFFFFF";}
											?>
											<form method="post">
											<tr style="<?=$headTr?>">
												<td style="text-align:center"><?=$sl++?></td>
												<td style="text-align:left">
													<input type="text" name="headName" value="<?=$row['name']?>" class="form-control" style="min-width:200px"></td>
												</td>																					
												<td style="text-align:center;">
													<input type="hidden" name="updateId" value="<?=$row['id']?>">
													<button type="submit" name="btnUpdateHead" class="bg_none" title="Edit"><i class="fa fa-edit" style="font-size:22px;color:#138AB2"></i></button>
													<button type="submit" name="btnDeleteHead" class="bg_none" onclick="return confirm('Are you sure to delete the account-head ?');" title="Delete">
													<i class="fa fa-minus-circle" style="font-size:22px;color:#D32826"></i>
													</button>													
												</td>
											</tr>
											</form>
											<?php
											}
										}
										else
										{
										?>
										<tr><td colspan="3" class="dataNotAvailable">You have no account head !</td></tr>										
										<?php
										}
										?>
								</table>
							</div>
                        </div>						
					</div>
				</div>					
			</div>					
		</div>
		</div>
    </body>
</html>