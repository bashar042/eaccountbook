<?php

	$userSrlId   = $_SESSION['user_srl_id'];
	$sql = "SELECT * FROM `tbl_user` WHERE id='$userSrlId'";							
	$arr = selectAllRows($sql);
	foreach($arr as $row){
		$userId      = $row['user_id'];
		$name        = $row['name'];
		$birth_date  = $row['birth_date'];
		$phone_mob   = $row['phone_mob'];
		$email       = $row['email'];
		$user_image  = $row['user_image'];
		$com_name    = $row['com_name'];
		$com_address = $row['com_address'];
		$com_phone   = $row['com_phone'];
		
		$dob         = explode("-",$birth_date);
		$yy          = $dob[0];
		$mm          = $dob[1];
		$dd          = $dob[2];
	}
	//-------------------------------------------------
	if(isset($_POST['btnUpdateBasicInfo']))
	{
		$userName   = $_POST['userName'];
		
		if($userName=='')
		{
			$_SESSION['alert1'] = "danger"; 
			$_SESSION['userMsg1'] = "Sorry, name can not be blank !";
			header("Location:?module=sys_settings&page=profile_view&colOneOpen=in");
			exit;
		}
		
		$DoB_day    = $_POST['DoB_day'];
		$DoB_month  = $_POST['DoB_month'];
		$DoB_year   = $_POST['DoB_year'];
		$birth_date = $DoB_year."-".$DoB_month."-".$DoB_day;
		
		//echo "ee".$_FILES["userImageNew"]["name"]; exit;
	if($_FILES["userImageNew"]["name"])
	{  
		if(file_exists($_POST['userImageOld']))
		{
		 unlink($_POST['userImageOld']);
		}
		
		// upload image with resize
		$nImage         = $_FILES["userImageNew"]["name"];
		$tempImage      = $_FILES['userImageNew']['tmp_name'];
		echo $destination    = "images/reg_user_img/";
		$ImageName      = uniqid();  
		$nWhidth        = ''; 
		$nHight         = ''; 
		$maxSize        = 100 * 1024; // 100 KB		
		$imgUploadRes   = ImageResize($nImage,$tempImage,"110", "135", $destination,$ImageName);
		
		$arrImg         = explode(":",$imgUploadRes);
		if($arrImg[0] == 'error')
		{
		  	$_SESSION['alert1'] = "danger"; 
			$_SESSION['userMsg1'] = $arrImg[1];
			header("Location:?module=sys_settings&page=profile_view&colOneOpen=in");
			exit;
		}
		if($arrImg[0] == 'success')
		{
		  $user_img_path = $arrImg[1];
		}
        // end upload image	
	 
	} 
	else
	{
		$user_img_path = $_POST['userImageOld'];
	}
		
		
		$data = array(
		 'name'       => $userName,
		 'user_image' => $user_img_path,
		 'birth_date' => $birth_date
		);
		$where = array('id' => $userSrlId);
		$isUpdate = updateData("tbl_user",$data,$where);
		
		if($isUpdate)
		{
			$_SESSION['alert1'] = "success";
			$_SESSION['user_name'] = $userName;									
			$_SESSION['userMsg1'] = "Basic information is updated successfully !";
			header("Location:?module=sys_settings&page=profile_view&colOneOpen=in");
			exit;
		}
		else
		{
			$_SESSION['alert1'] = "danger"; 
			$_SESSION['userMsg1'] = "Sorry, problem to update Basic Information !";
			header("Location:?module=sys_settings&page=profile_view&colOneOpen=in");
			exit;
		}
	}
	if(isset($_POST['btnUpdateLoginInfo']))
	{							
		$userPass    = $_POST['userPass'];
		$confirmPass = $_POST['confirmPass'];
		
		if($userPass=='')
		{
			$_SESSION['alert2'] = "danger"; 
			$_SESSION['userMsg2'] = "Sorry, password can not be blank !";
			header("Location:?module=sys_settings&page=profile_view&colTwoOpen=in");
			exit;
		}
		if($userPass != $confirmPass){
			$_SESSION['alert2'] = "danger"; 
			$_SESSION['userMsg2'] = "Sorry, password does not match with confirm password !";
			header("Location:?module=sys_settings&page=profile_view&colTwoOpen=in");
			exit;
		}
		
		$data = array(
		 'password'     => md5($userPass),
		 'secure_entry' => $userPass
		);
		$where = array('id' => $userSrlId);
		$isUpdate = updateData("tbl_user",$data,$where);
		
		if($isUpdate)
		{
			$_SESSION['alert2'] = "success"; 
			$_SESSION['user_password'] = $userPass;
			$_SESSION['userMsg2'] = "Password is updated successfully !";
			header("Location:?module=sys_settings&page=profile_view&colTwoOpen=in");
			exit;
		}
		else
		{
			$_SESSION['alert2'] = "danger"; 
			$_SESSION['userMsg2'] = "Sorry, problem to update password !";
			header("Location:?module=sys_settings&page=profile_view&colTwoOpen=in");
			exit;
		}
	}
	if(isset($_POST['btnUpdateContactInfo']))
	{
		$phoneMobileNo = $_POST['phoneMobileNo'];
		$userEmail = $_POST['userEmail'];
		if($userEmail=='')
		{
			$_SESSION['alert3'] = "danger"; 
			$_SESSION['userMsg3'] = "Sorry, email-address can not be blank !";
			header("Location:?module=sys_settings&page=profile_view&colThreeOpen=in");
			exit;
		}
		$data = array(
		 'phone_mob'  => $phoneMobileNo,
		 'email' => $userEmail
		);
		$where = array('id' => $userSrlId);
		$isUpdate = updateData("tbl_user",$data,$where);
		
		if($isUpdate)
		{
			$_SESSION['alert3'] = "success";									
			$_SESSION['userMsg3'] = "Contact information is updated successfully !";
			header("Location:?module=sys_settings&page=profile_view&colThreeOpen=in");
			exit;
		}
		else
		{
			$_SESSION['alert3'] = "danger"; 
			$_SESSION['userMsg3'] = "Sorry, problem to update contact information !";
			header("Location:?module=sys_settings&page=profile_view&colThreeOpen=in");
			exit;
		}
		
	}
	if(isset($_POST['btnUpdateCompanyInfo']))
	{
		$companyName    = $_POST['companyName'];
		$companyAddress = $_POST['companyAddress'];
		$companyPhone   = $_POST['companyPhone'];
		$data = array(
		 'com_name'     => $companyName,
		 'com_address'  => $companyAddress,
		 'com_phone'    => $companyPhone
		);
		$where = array('id' => $userSrlId);
		$isUpdate = updateData("tbl_user",$data,$where);
		
		if($isUpdate)
		{
			$_SESSION['alert4'] = "success";									
			$_SESSION['userMsg4'] = "Company information is updated successfully !";
			header("Location:?module=sys_settings&page=profile_view&colFourOpen=in");
			exit;
		}
		else
		{
			$_SESSION['alert4'] = "danger"; 
			$_SESSION['userMsg4'] = "Sorry, problem to update Company information !";
			header("Location:?module=sys_settings&page=profile_view&colFourOpen=in");
			exit;
		}
	}
	if($_GET['colOneOpen']=='' && $_GET['colTwoOpen']=='' && $_GET['colThreeOpen']=='' && $_GET['colFourOpen']=='')
	{
		$defaultOpen = 'in';
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Client Profile | eAccount Book</title>
    </head>
    <body>     
		<div class="panel panel-default input_form_inner_content">
			<div class="panel-heading">
				<h3 class="panel-title page_title">Profile View
					<ol class="breadcrumb">
						<li><?=$reqPage['module_title']?></li>
						<li class="active"><a href="?module=<?=$reqPage['module_value']?>&page=<?=$reqPage['page_value']?>"><?=$reqPage['page_title']?></a></li>
					</ol>
				</h3>
			</div>
		<div class="panel-body">			
				<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">				    
					<div class="row">					
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						  <div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
							  <h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								  <i class="fa fa-angle-double-right"></i>&nbsp; Basic Information
								</a>
							  </h4>
							</div>							
							<div id="collapseOne" class="panel-collapse collapse <?=($_GET['colOneOpen'] == 'in') ? "in" : $defaultOpen?>" role="tabpanel" aria-labelledby="headingOne">
							    <div class="panel-body">
								<?php
								if($_SESSION['userMsg1'] != "" )
								{
								?>
									<div class="row" style="padding:1px 10px">					    
										<div class="alert alert-<?=$_SESSION['alert1']?>">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<?php
												echo "\t".$_SESSION['userMsg1'];
												$_SESSION['userMsg1']='';
											?>
										</div>
									</div>
								<?php
								}  
								?>
									<div class="col-lg-2"></div>
									<div class="col-lg-6">
									    <form method="post" action="" enctype="multipart/form-data">
											<div class="row field_div">
												Name<span style="color:red;">*</span><br/>
												<input name="userName" type="text" value="<?=$name?>" class="form-control" placeholder="Enter user name"/>
											</div>											
											<div class="row field_div">
												Date of Birth<br/>
											    <div class="col-lg-3">												
												<select name="DoB_day" class="form-control" style="width:80px;height:32px" >
												    <option value="">-Day-</option>
                                                  	<?php
													for($d=1;$d<=31;$d++){
														if($d<10){ 
															$d = "0".$d; 
														}
														else{ 
															$d = $d; 
														}
														?>
														<option value="<?=$d?>" <?=($d==$dd)?"selected='selected'" : ""?>><?=$d?></option>
													<?php	
													}
													?>											  
												</select>
												</div>
												<div class="col-lg-3">
												<select name="DoB_month" class="form-control" style="width:80px;height:32px">
												    <option value="">-Month-</option>
                                                    <?php
													for($m=1;$m<=12;$m++){
														if($m<10){ 
															$m = "0".$m; 
														}
														else{ 
															$m = $m; 
														}
														?>
														<option value="<?=$m?>" <?=($m==$mm)?"selected='selected'" : ""?>><?=$m?></option>
													<?php	
													}
													?>													  
												</select>
												</div>
												<div class="col-lg-3">
												<select name="DoB_year" class="form-control" style="width:80px;height:32px">
													<option value="">-Year-</option>
													<?php
													$y1 = date('Y')-75;
													$y2 = date('Y');
													for($y=$y2;$y>=$y1;$y--){
													?>	
														<option value="<?=$y?>" <?=($y==$yy) ? "selected='selected'" : ""?>><?=$y?></option>
												    <?php
													}
													?>														
												</select>
												</div>	
											</div>
											<div class="row field_div">
												Upload Your Image<br/>
												<input type="file" name="userImageNew" onchange="displayImage(this)"/>
											</div>
											<div class="row field_div">
												<input type="hidden" name="userImageOld" value="<?=$user_image?>">
												<?php
												if($user_image != "")
												{
												?>
												  <img src="<?=$user_image?>" id="userImage" name="userImage" width="140px" height="126px" alt="" />
												<?php
												}
												else
												{
												?>
													<img src='images/reg_user_img/default_img.jpg' width="140px" height="126px" id="userImage" name="userImage" alt="">
												<?php
												}
												?>
												
											</div>
											<script type="text/javascript">
											function readURL(input) {
												if (input.files && input.files[0]) {
													var reader = new FileReader();

													reader.onload = function (e) {
														$('#userImage').attr('src', e.target.result);
													}

													reader.readAsDataURL(input.files[0]);
												}
											}
											function displayImage(id)
											{
												var imgName = id.value; //alert(imgName);
												if(imgName != "")
												{
												  readURL(id);  
												}
											}
											</script>
											<div class="row updt_btn_content">
												<input type="reset" value="Cancel" class="btn btn-warning"/>
												<input type="submit" value="Update »" name="btnUpdateBasicInfo" class="btn btn-primary" /> 							
											</div>
                                        </form>  										
									</div>
									<div class="col-lg-2"></div>
							    </div>
							</div>
						  </div>
						  <div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
							  <h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								 <i class="fa fa-angle-double-right"></i>&nbsp; Login Information (Change Password)
								</a>
							  </h4>
							</div>							
							<div id="collapseTwo" class="panel-collapse collapse <?=$_GET['colTwoOpen']?>" role="tabpanel" aria-labelledby="headingTwo">
							    <div class="panel-body">
								<?php
								if($_SESSION['userMsg2'] != "" )
								{
								?>
									<div class="row" style="padding:1px 10px">					    
										<div class="alert alert-<?=$_SESSION['alert2']?>">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<?php
												echo "\t".$_SESSION['userMsg2'];
												$_SESSION['userMsg2']='';
											?>
										</div>
									</div>
								<?php
								}  
								?>
									<div class="col-lg-2"></div>
									<div class="col-lg-6">
										<form method="post">
											<div class="row field_div">
												User ID<span style="color:red;">*</span><br/>
												<input name="userId" id="userId" type="text" value="<?=$userId?>" readonly="readonly" class="form-control" placeholder="Enter phone no."/>
											</div>
											<div class="row field_div">
													New Password<span style="color:red;">*</span><br/>
													<input name="userPass" id="userPass" type="password" value="<?=$_SESSION['user']['pass']?>" class="form-control" placeholder="Enter password" />
											</div>
											<div class="row field_div">
													Confirm Password<span style="color:red;">*</span><br/>
													<input name="confirmPass" id="confirmPass" type="password" value="<?=$_SESSION['user']['conPass']?>" class="form-control" placeholder="Enter Confirm pass." />
											</div>
											<div class="row updt_btn_content">
												<input type="reset" value="Cancel" class="btn btn-warning"/>
												<input type="submit" value="Update »" name="btnUpdateLoginInfo" class="btn btn-primary" /> 							
											</div>											
										</form>	
									</div>	
									<div class="col-lg-2"></div>									
								</div>
							</div>
						  </div>
						  <div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
							  <h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								  <i class="fa fa-angle-double-right"></i>&nbsp; Contact Information
								</a>
							  </h4>
							</div>							
							<div id="collapseThree" class="panel-collapse collapse <?=$_GET['colThreeOpen']?>" role="tabpanel" aria-labelledby="headingThree">
							  <div class="panel-body">
							  <?php
								if($_SESSION['userMsg3'] != "" )
								{
								?>
									<div class="row" style="padding:1px 10px">					    
										<div class="alert alert-<?=$_SESSION['alert3']?>">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<?php
												echo "\t".$_SESSION['userMsg3'];
												$_SESSION['userMsg3']='';
											?>
										</div>
									</div>
								<?php
								}  
								?>
								    <div class="col-lg-2"></div>
								    <div class="col-lg-6">
										<form method="post">
											<div class="row field_div">
												Phone/Mobile No<br/>
												<input name="phoneMobileNo" type="text" value="<?=$phone_mob?>" class="form-control" placeholder="Your phone/mob. no."/>							
											</div>
											<div class="row field_div">
												Email<span style="color:red;">*</span><br/>
												<input name="userEmail" type="email" value="<?=$email?>"  class="form-control" placeholder="Enter email address" />
											</div>
											<div class="row updt_btn_content">
												<input type="reset" value="Cancel" class="btn btn-warning"/>
												<input type="submit" value="Update »" name="btnUpdateContactInfo" class="btn btn-primary" /> 							
											</div>
										</form>	
								    </div>
								    <div class="col-lg-2"></div>
							  </div>
							</div>
						  </div>
						  <div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingFour">
							  <h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
								 <i class="fa fa-angle-double-right"></i>&nbsp; Company Information
								</a>
							  </h4>
							</div>						
							<div id="collapseFour" class="panel-collapse collapse <?=$_GET['colFourOpen']?>" role="tabpanel" aria-labelledby="headingFour">
							  <div class="panel-body">
							  <?php
								if($_SESSION['userMsg4'] != "" )
								{
								?>
									<div class="row" style="padding:1px 10px">					    
										<div class="alert alert-<?=$_SESSION['alert4']?>">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<?php
												echo "\t".$_SESSION['userMsg4'];
												$_SESSION['userMsg4']='';
											?>
										</div>
									</div>
								<?php
								}  
								?>
								    <div class="col-lg-2"></div>
								    <div class="col-lg-6">
										<form method="post">
											<div class="row field_div">
												Company Name<br/>
												<input name="companyName" type="text" value="<?=$com_name?>" class="form-control" placeholder="Your phone/mob. no."/>							
											</div>
											<div class="row field_div">
												Address<br/>
												<input name="companyAddress" type="text" value="<?=$com_address?>"  class="form-control" placeholder="Enter email address" />
											</div>
											<div class="row field_div">
												Phone No<br/>
												<input name="companyPhone" type="text" value="<?=$com_phone?>"  class="form-control" placeholder="Enter email address" />
											</div>											
											<div class="row updt_btn_content">
												<input type="reset" value="Cancel" class="btn btn-warning"/>
												<input type="submit" value="Update »" name="btnUpdateCompanyInfo" class="btn btn-primary" /> 							
											</div>
										</form>				
								    </div>
								    <div class="col-lg-2"></div>
							  </div>
							</div>
						  </div>
						</div>					
					</div>				
				</div>	
				<div class="col-lg-2"></div>	
                </div>					
		</div>
		</div>
    </body>
</html>