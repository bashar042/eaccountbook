<?php
    if(isset($_POST['btnSave']))
    {
        $userId       = $check->check_post($_POST['userId']);
        $userPassword = $check->check_post($_POST['userPassword']);
		$password     = md5($userPassword);

        $result = mysql_query("select * from tbl_user where user_id='$userId' and password='$password' and status=1");
        $is_exist = mysql_num_rows($result);
        $arrLoginUser = mysql_fetch_array($result);

        if($is_exist > 0)
        {
            $_SESSION['user_id']       = $userId;
            $_SESSION['user_password'] = $userPassword;
            $_SESSION['user_name']     = $arrLoginUser['name'];
            $_SESSION['user_srl_id']   = $arrLoginUser['id'];
            $id = $arrLoginUser['id'];
            $dt = get_current_date_time();
            $ip = getIp();

            // record log
            //$sql="insert into `tbl_log_login` (logged_user_id,from_ip,login_at) values ('$id','$ip','$dt')";
            //mysql_query($sql);
            unset($_SESSION['reqUserId']);  
            unset($_SESSION['reqUserPass']);  
            header('Location:?module=dashboard&page=system_info');
            exit;
        }
        else
        {          
			$_SESSION['reqUserId']   = $userId;
			$_SESSION['reqUserPass'] = $userPassword;
			$_SESSION['login_err']   = "Invalid login information !";
			header('Location:index.php');
			exit;             
        }

    }
	if(isset($_POST['btnRegistration'])){
		$userId          = $check->check_post($_POST['userId']);
        $userPassword    = $check->check_post($_POST['userPassword']);
        $confirmPassword = $check->check_post($_POST['confirmPassword']);
        $phoneMob        = $check->check_post($_POST['phoneMob']);
		$_SESSION['user']['id']      = $userId;
		$_SESSION['user']['pass']    = $userPassword;
		$_SESSION['user']['conPass'] = $confirmPassword;
		$_SESSION['user']['phoneMob'] = $phoneMob;
		
		if($userId=="" || $userPassword=="" || $confirmPassword=="" || $phoneMob==""){
			$_SESSION['login_err'] = "Required fields can not be blank !";
			$_SESSION['alert'] = "danger";
			header("Location:index.php");
			exit;
		}
		if (is_numeric($phoneMob)) {
		    $len = strlen($phoneMob);
			if($len < 6 || $len > 11 ){
				$_SESSION['login_err'] = "Invalid Phone / Mobile !";
				$_SESSION['alert'] = "danger";
				header("Location:index.php");
				exit;
			}
			
		}
		else{
			$_SESSION['login_err'] = "Invalid Phone / Mobile !";
			$_SESSION['alert'] = "danger";
			header("Location:index.php");
			exit;
		}
		
		if($userPassword != $confirmPassword){
			$_SESSION['login_err'] = "Password does not match !";
			$_SESSION['alert'] = "danger";
			header("Location:index.php");
			exit;
		}
		//$ar = explode("",$userPass);
	    $isAlreadyExisted = numOfExistedData("tbl_user","user_id='$userId'");// AND secure_entry='$userPass'
		  /* if user id + password check return duplicate then the requested 
		 user try to login by that info. So i use only duplicate user Id */
		 if($isAlreadyExisted > 0){
			$_SESSION['login_err'] = "This User Id:<i><b>$userId</b></i> is not available. Please try another !";
			$_SESSION['alert'] = "danger";
			header("Location:index.php");
			exit;
		 }
		$data = array(
		 'user_id' 		=> $userId,
		 'password'     => md5($userPassword),
		 'secure_entry' => $userPassword,
		 'phone_mob'    => $phoneMob,
		 'create_at'    => date('Y-m-d H:i:s')
		 );
	 
	 $isInsert = insertData("tbl_user",$data);
	 if($isInsert){
	    unset($_SESSION['user']);
	    $_SESSION['alert'] = "success"; 
	    $_SESSION['reg_success'] = "Registration completed successfully !";
		header("Location:index.php");
		exit;
	 }
	 else{
	    $_SESSION['alert'] = "danger"; 
	    $_SESSION['login_err'] = "Sorry, registration not completed !";
		header("Location:index.php");
		exit;
	 } 
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
		<link rel="stylesheet" href="bootstrap.min.css" />
        <link rel="shortcut icon" href="http://getbootstrap.com/assets/ico/favicon.png">
        

        <title>Login :: eAccount Book</title>
		<link href="helper/css/bootstrap.css" rel="stylesheet">
		<link href="helper/css/font-awesome.min.css" rel="stylesheet">
		<link href="helper/css/font-awesome.css" rel="stylesheet">
		<!-- Bootstrap theme -->
		<link href="helper/css/bootstrap-theme.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="helper/css/theme.css" rel="stylesheet">
		<link href="helper/css/tcal.css" rel="stylesheet">
		<link href="helper/css/custom_acc_sys.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="../../assets/js/html5shiv.js"></script>
		<script src="../../assets/js/respond.min.js"></script>
		<![endif]-->
        <style type="text/css">
			body{font-family: 'Ropa Sans', sans-serif; color:#666; font-size:14px; color:#333}
			li,ul,body,input{margin:0; padding:0; list-style:none}
			#login-form{width:352px; background:#FFF; margin:0 auto; margin-top:20px; background:#FCFCFC; overflow:hidden; border-radius:4px;border:1px solid #DDDDDD;}
			.form-header{display:table; clear:both}
			.form-header label{display:block; cursor:pointer; z-index:999}
			.form-header li{margin:0; line-height:60px; width:175px; text-align:center; background:#e6e6e6; font-size:18px; float:left; transition:all 600ms ease}

			/*sectiop*/
			.section-out{width:700px; float:left; transition:all 600ms ease}
			.section-out:after{content:''; clear:both; display:table}
			.section-out section{width:350px; float:left}

			.login{padding:20px}
			.ul-list{clear:both; display:table; width:100%}
			.ul-list:after{content:''; clear:both; display:table}
			.ul-list li{ margin:0 auto; margin-bottom:12px}
			.input{background:#fff; transition:all 800ms; width:260px; border-radius:3px 0 0 3px; font-family: 'Ropa Sans', sans-serif; border:solid 1px #ccc; border-right:none; outline:none; color:#999; height:40px; line-height:40px; display:inline-block; padding-left:10px; font-size:16px}
			.input,.login span.icon{vertical-align:top}
			.login span.icon{width:50px; transition:all 800ms; text-align:center; color:#999; height:40px; border-radius:0 3px 3px 0; background:#e8e8e8; height:40px; line-height:40px; display:inline-block; border:solid 1px #ccc; border-left:none; font-size:16px}
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
			background: #83bc3e none repeat scroll 0 0;
			border-color: -moz-use-text-color -moz-use-text-color #4f8210;
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
        </style>	 
    </head>

<body style="background:#EAEAEA">        
	<div class="sys_name_login">
	   <img src="images/eabLogo.png" alt="Logo" class="logo_lg">&nbsp;
	   eAccount <span style='color:#FBA819'>Book</span>
	</div>	

	<div id="login-form">    
		<input type="radio" checked id="login" name="switch" class="hide">
		<input type="radio" id="signup" name="switch" class="hide">

		<div>
			<ul class="form-header">
				<li><label for="login"><i class="fa fa-lock"></i> LOGIN<label for="login"></li>
				<li><label for="signup"><i class="fa fa-credit-card"></i> REGISTER</label></li>
			</ul>
		</div> 
		<?php 
			if($_SESSION['login_err'] != "")
			{
				echo "<div style='color:red;border:0px solid red;text-align:center;padding-top:10px'><i class='fa fa-info-circle'></i>&nbsp;".$_SESSION['login_err']."</div>";
				$_SESSION['login_err'] = "";
			}
			if($_SESSION['reg_success'] != "")
			{
				echo "<div style='color:#1D9D74;text-align:center;padding-top:10px'><i class='fa fa-check-circle'></i>&nbsp;".$_SESSION['reg_success']."</div>";
				unset($_SESSION['reg_success']);
			}
		?>
		<div class="section-out">
			<section class="login-section">
				<div class="login">
					<form action=""  method="post">
						<ul class="ul-list">
							<li>
								<input name="userId" required id="userId" class="input" placeholder="User ID" type="text" value="<?=$_SESSION['reqUserId']?>"><span class="icon"><i class="fa fa-user"></i></span>
							</li>
							<li>
								<input type="password" required name="userPassword" id="userPassword" class="input" placeholder="Password" value=""><span class="icon"><i class="fa fa-lock"></i></span>
							</li>
							<li><button type="submit" name="btnSave" class="btn">LOGIN</button></li>
						</ul>
					</form>
				</div>
			</section>

			<section class="signup-section">
				<div class="login">
					<form action="" method="post">
						<ul class="ul-list">
							<li>
								<input name="userId" class="input" required placeholder="User ID" type="text"><span class="icon"><i class="fa fa-user"></i></span>
							</li>
							
							<li><input name="userPassword" type="password" required class="input" placeholder="Password"/><span class="icon"><i class="fa fa-lock"></i></span></li>
							<li><input name="confirmPassword" type="password" required class="input" placeholder="Confirm Password"/><span class="icon"><i class="fa fa-lock"></i></span></li>
							<li><input name="phoneMob" type="text" required class="input" placeholder="Mobile / Phone no"/><span class="icon"><i class="fa fa-phone"></i></span></li>
							<li><input type="submit" name="btnRegistration" value="REGISTER NOW" class="btn"></li>
						</ul>
					</form>
				</div>
			</section>
		</div>
	</div>

	<script src="helper/js/jquery.js"></script>
	<script src="helper/js/bootstrap.js"></script>
	<script src="helper/js/bootstrap.min.js"></script>
	<script src="helper/js/holder.js"></script>
	<script src="helper/js/custome_script.js"></script>
	<script src="helper/js/tcal.js"></script>
	<script src="helper/js/tab.js"></script>	
</body>
</html>