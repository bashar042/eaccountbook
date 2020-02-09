<?php
   	if(isset($_POST['btnRegistration'])){
		unset($_SESSION['user']);
		$userId          = $check->check_post($_POST['userId']);
        $userPassword    = $check->check_post($_POST['userPassword']);
        $confirmPassword = $check->check_post($_POST['confirmPassword']);
        $emailAddress    = $check->check_post($_POST['emailAddress']);
		$_SESSION['user']['id']      = $userId;
		$_SESSION['user']['pass']    = $userPassword;
		$_SESSION['user']['conPass'] = $confirmPassword;
		$_SESSION['user']['emailAddress'] = $emailAddress;
		
		if($userId=="" || $userPassword=="" || $confirmPassword=="" || $emailAddress==""){
			$_SESSION['login_err'] = "Required fields can not be blank !";
			$_SESSION['alert'] = "danger";
			header("Location:?page=register");
			exit;
		}
		if(!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['login_err'] = "Invalid email address !";
			$_SESSION['alert'] = "danger";
			header("Location:?page=register");
			exit;
		}		
		
		if($userPassword != $confirmPassword){
			$_SESSION['login_err'] = "Password does not match !";
			$_SESSION['alert'] = "danger";
			header("Location:?page=register");
			exit;
		}
		//$ar = explode("",$userPass);
	    $isAlreadyExistedUserId = numOfExistedData("tbl_user","user_id='$userId'");// AND secure_entry='$userPass'
	    $isAlreadyExistedEmail  = numOfExistedData("tbl_user","email='$emailAddress'");// AND secure_entry='$userPass'
		  /* if user id + password check return duplicate then the requested 
		 user try to login by that info. So i use only duplicate user Id */
		 if($isAlreadyExistedUserId > 0){
			$_SESSION['login_err'] = "User Id:<i><b>$userId</b></i> is not available. Please try another !";
			$_SESSION['alert'] = "danger";
			header("Location:?page=register");
			exit;
		 }
		 if($isAlreadyExistedEmail > 0){
			$_SESSION['login_err'] = "<i><b>$emailAddress</b></i> is not available. Please try another email-address !";
			$_SESSION['alert'] = "danger";
			header("Location:?page=register");
			exit;
		 }
		$data = array(
		 'user_type' 	=> '0',
		 'user_id' 	=> $userId,
		 'password'     => md5($userPassword),
		 'secure_entry' => $userPassword,		 
		 'email'        => $emailAddress,
		 'create_at'    => date('Y-m-d H:i:s')
		 );
	 
	 $isInsert = insertData("tbl_user",$data);
	 if($isInsert){	    
		$_SESSION['user_id']       = $userId;
		$_SESSION['user_password'] = $userPassword;
		$_SESSION['user_srl_id']   = mysql_insert_id();
		
	    $_SESSION['alert'] = "success"; 
	    $_SESSION['reg_success'] = "Registration completed successfully !";
		header("Location:?module=dashboard&page=system_info");
		exit;
	 }
	 else{
	    $_SESSION['alert'] = "danger"; 
	    $_SESSION['login_err'] = "Sorry, registration not completed !";
		header("Location:?page=register");
		exit;
	 } 
	}
?>


        <style type="text/css">
			body{font-family: 'Ropa Sans', sans-serif; color:#666; font-size:14px; color:#333}
			li,ul,body,input{margin:0; padding:0; list-style:none}
			#login-form{width:352px; background:#FFF; margin:0 auto; background:#FCFCFC; overflow:hidden; border-radius:4px;border:1px solid #DDDDDD;}
			.form-header{display:table; clear:both}
			.form-header label{display:block; cursor:pointer; z-index:999}
			.form-header li{margin:0; line-height:60px; width:175px; text-align:center; background:#e6e6e6; font-size:18px; float:left; transition:all 600ms ease}

			/*sectiop*/
			.section-out{width:700px; float:left; transition:all 600ms ease}
			.section-out:after{content:''; clear:both; display:table}
			.section-out section{width:350px; float:left}

			.login{padding:10px 20px;}
			.ul-list{clear:both; display:table; width:100%}
			.ul-list:after{content:''; clear:both; display:table}
			.ul-list li{ margin:0 auto; margin-bottom:15px}
			.input{background:#fff; transition:all 800ms; width:260px; border-radius:3px 0 0 3px; font-family: 'Ropa Sans', sans-serif; border:solid 1px #ccc; border-right:none; outline:none; color:#666; height:40px; line-height:40px; display:inline-block; padding-left:10px; font-size:16px}
			.input,.login span.icon{vertical-align:top}
			.login span.icon{width:50px; transition:all 800ms; text-align:center; color:#666; height:40px; border-radius:0 3px 3px 0; background:#e8e8e8; height:40px; line-height:40px; display:inline-block; border:solid 1px #ccc; border-left:none; font-size:16px}
			.input:focus:invalid{border-color:red}
			.input:focus:invalid+.icon{border-color:red}
			.input:focus:valid{border-color:green}
			.input:focus:valid+.icon{border-color:green}
			#check,#check1{top:1px; position:relative}
			.btn{
				-moz-border-bottom-colors: none;
				-moz-border-left-colors: none;
				-moz-border-right-colors: none;
				-moz-border-top-colors: none;
				background: #3498db none repeat scroll 0 0;
				border-color: -moz-use-text-color -moz-use-text-color #1b80c4;
				border-image: none;
				border-radius: 3px;
				border-style: none none solid;
				border-width: medium medium 4px;
				color: #fff;
				display: block;
				font-family: "Ropa Sans",sans-serif;
				font-size: 16px;
				height: 40px;
				margin: 0 auto;
				outline: medium none;
				padding: 0 10px;
				width: 100%;			
			}

			.social-login{padding:15px 20px; background:#f1f1f1; border-top:solid 2px #e8e8e8; text-align:right}
			.social-login a{display:inline-block; height:35px; text-align:center; line-height:35px; width:35px; margin:0 3px; text-decoration:none; color:#FFFFFF}
			.form a i.fa{line-height:35px}
			.fb{background:#305891} .tw{background:#2ca8d2} .gp{background:#ce4d39} .in{background:#006699}
			.remember{width:50%; display:inline-block; clear:both; font-size:14px}
			.remember:nth-child(2){text-align:right}
			.remember a{text-decoration:none; color:#666}

			.hide{display:none}

			/*swich form*/
			#signup:checked~.section-out{margin-left:-350px}
			#login:checked~.section-out{margin-left:0px}
			#login:checked~div .form-header li:nth-child(1),#signup:checked~div .form-header li:nth-child(2){background:#F8F8F8}
            .sys_name_login{
				width:352px;margin:50px auto 0;font-size:32px;text-align:center;color:#83BC3E;font-weight:bold;
            } 
			.log_reg_header{
				background-color:#E8E8E8;
				padding:8px;
				text-align:center;
				font-size:21px;
				color:#666;
			} 	
            .req{
				color:red;
				font-size:18px;
			}  			
        </style>	 
    
<div style="background:#fff;padding:50px 0px;">        
		<div id="login-form">  	
		<div class="log_reg_header">
			Registration Form
		</div> 
		<?php 
			if($_SESSION['login_err'] != "")
			{
				echo "<div style='color:#EA6E52;border:0px solid red;text-align:center;padding-top:10px'><i class='fa fa-info-circle'></i>&nbsp;".$_SESSION['login_err']."</div>";
				$_SESSION['login_err'] = "";
			}
			if($_SESSION['reg_success'] != "")
			{
				echo "<div style='color:#1D9D74;text-align:center;padding-top:10px'><i class='fa fa-check-circle'></i>&nbsp;".$_SESSION['reg_success']."</div>";
				unset($_SESSION['reg_success']);
			}
			
		?>
		<div class="section-out">			
			<section class="signup-section">
				<div class="login">
					<form action="" method="post">
						<ul class="ul-list">
						    <li style="text-align:right;color:red"><span class='req'>*</span> Required</li>
							<li>
								<input name="userId" type="text" value="<?=$_SESSION['user']['id']?>" class="input" required placeholder="User ID"><span class="icon"><i class="fa fa-user"></i><span class='req'>*</span></span>
							</li>
							
							<li><input name="userPassword" type="password" value="<?=$_SESSION['user']['pass']?>" required class="input" placeholder="Password"/><span class="icon"><i class="fa fa-lock"></i><span class='req'>*</span></span></li>
							<li><input name="confirmPassword" type="password" value="<?=$_SESSION['user']['conPass']?>" required class="input" placeholder="Confirm Password"/><span class="icon"><i class="fa fa-lock"></i><span class='req'>*</span></span></li>
							<li style="margin-bottom:30px"><input name="emailAddress" type="email" value="<?=$_SESSION['user']['emailAddress']?>" required class="input" placeholder="Email Address"/><span class="icon"><i class="fa fa-envelope"></i><span class='req'>*</span></span></li>
							<li><input type="submit" name="btnRegistration" value="REGISTER NOW" class="btn"></li>
							<li>Already have an Account? <a href="?page=login">Login!</a></li>
						</ul>
					</form>
				</div>
			</section>
		</div>
	</div>
	
</div>