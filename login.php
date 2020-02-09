<style>
.login {
    background: #fff none repeat scroll 0 0;
    border-radius: 5px;
    margin: 35px auto 0;
    padding: 15px 0 0;
    width: 31%;
}
</style>

<div class="login">
	<h2>Login</h2>
	<form>
		<input type="text" onblur="if (this.value == '') {this.value = 'User name';}" onfocus="this.value = '';" value="User name" class="user active">
		<input type="password" onblur="if (this.value == '') {this.value = 'Password';}" onfocus="this.value = '';" value="Password" class="lock active">
	</form>
	<div class="forgot">
		 <div class="login-check">
 			 <label class="checkbox"><input type="checkbox" checked="" name="checkbox"><i> </i> Remember Me</label>

 		  </div>
 		  <div class="login-para">
 			<p><a href="#"> Forgot Password? </a></p>
 		 </div>
		<div class="clear"> </div>
	</div>
	<div class="login-bwn">
	   <input type="submit" value="Log in">
	</div>
	<div class="login-bottom">
		<h3>Login</h3>
		<p>With your social media account</p>
	 <div class="social-icons">
		<div class="button">
			<a href="#" class="tw"> <i class="anc-tw"> </i> <span>Twitter</span>
			<div class="clear"> </div></a>
			<a href="#" class="fa"> <i class="anc-fa"> </i> <span>Facebook</span>
			<div class="clear"> </div></a>
			<a href="#" class="go"><i class="anc-go"> </i><span>Google+</span>
			<div class="clear"> </div></a>
				<div class="clear"> </div>
		</div>
		<h4>Don,t have an Account? <a href="#"> Register Now!</a></h4>
		<div class="reg-bwn"><a href="#">REGISTER</a></div>
	</div>
  </div>
</div>