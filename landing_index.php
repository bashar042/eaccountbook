<?php
	include $base_url."pages/landing/header_landing.php";	
	if($page !='' )
	{				
		if($page=='about'){
			include $base_url."pages/informations/about_us.php";
		}
		elseif($page=='termsconditions'){
			include $base_url."pages/informations/terms_n_conditions.php";
		}
		elseif($page=='privacy'){
			include $base_url."pages/informations/privacy_policy.php";
		}
		elseif($page=='services'){
			include $base_url."pages/informations/services_info.php";
		}
		elseif($page=='faq'){
			include $base_url."pages/informations/faq.php";
		}
		elseif($page=='contact'){
			include $base_url."pages/landing/contact.php";
		}
		elseif($page=='register'){
			include $base_url."pages/user/register_form.php";
		}
		elseif($page=='login'){
			include $base_url."pages/user/login_form.php";
		}
		elseif($page=='forgot_pass'){
			include $base_url."pages/user/forgot_password.php";
		}
		else{
			include $base_url."pages/informations/page_not_found.php";
		}		
	}
	else
	{
		include $base_url."pages/landing/slider_landing.php";
		include $base_url."pages/landing/services_info_landing.php";
		include $base_url."pages/landing/client_feedback_landing.php";
	}	
	include $base_url."pages/landing/footer_landing.php";
?>  