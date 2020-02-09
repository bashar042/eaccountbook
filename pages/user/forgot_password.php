<?php
    if(isset($_POST['btnRecoverPass']))
    {  
        $userEmail = $check->check_post($_POST['userEmail']);
		$result = mysql_query("select * from tbl_user where email='$userEmail' and status=1");
        $is_exist = mysql_num_rows($result);
		if($is_exist > 0)
        {
			$row = mysql_fetch_array($result);
			$id = $row['id'];
			
			
			$rest = substr(time(), -4);
			$newPass = md5($rest);
			mysql_query("UPDATE `tbl_user` SET password='$newPass',secure_entry='$rest' WHERE id='$id'");
			
			$message = "Your new password is <b>$rest</b>.<br/> You can reset your password(from settings->profile) after login the system. <br/>Thanks";
			emailForPassRecover($userEmail,"Recover Your Password",$message);
			
			$_SESSION['emailSendingAlert'] = "A new password is already sent. Please check your email.";
			header('Location:?page=forgot_pass');
			exit;
		}
		else
		{
			$_SESSION['login_err'] = "Email address is not matching !";
			header('Location:?page=forgot_pass');
			exit;
		}      

    }
    function emailForPassRecover($to,$subject,$message)
    {     
		$headers  = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "From: eaccountbook.com <noreply@eaccountbook.com>" . "\r\n" .
					"X-Mailer: PHP/" . phpversion()."\r\n";	
		
		$from = "eaccountbook.com";
		$from_name = "";
		$to_name = "";
		mail($to, $subject, $message, $headers);
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

			.login{padding:30px 20px 20px 20px}
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
        </style>	 
    
<div style="background:#fff;padding:50px 0px;">        
		<div id="login-form">    
		<div class="log_reg_header">
			Recover Your Password
		</div>  
		<?php 
			if($_SESSION['login_err'] != "")
			{
				echo "<div style='color:red;border:0px solid red;text-align:center;padding-top:10px;margin-bottom:-20px'><i class='fa fa-info-circle'></i>&nbsp;".$_SESSION['login_err']."</div>";
				$_SESSION['login_err'] = "";
			}
			if($_SESSION['emailSendingAlert'] !="")
			{
				echo "<div style='color:green;border:0px solid red;text-align:center;padding-top:10px;margin-bottom:-20px'><i class='fa fa-info-circle'></i>&nbsp;".$_SESSION['emailSendingAlert']."</div>";
				$_SESSION['emailSendingAlert'] = "";
			}				
		?>
		<div class="section-out">
			<section class="login-section">
				<div class="login">
				    <p style="text-align:justify">Enter the email-address you have used for your eaccountbook registration. We will send you a new password.</p>					
					<form action=""  method="post">
						<ul class="ul-list">                                  						
							<li style="margin-bottom:30px">
								<input type="email" required name="userEmail" class="input" placeholder="Email address" value=""><span class="icon"><i class="fa fa-envelope"></i></span>
							</li>
							<li><button type="submit" name="btnRecoverPass" class="btn">SEND</button></li>
							<li><a href="?page=login">Back to Login</a></li>							
						</ul>
					</form>
				</div>
			</section>
		</div>
	</div>
	
</div>