<?php
if (isset($_POST['btnLogin'])) { 
    $userId = $check->check_post($_POST['userId']);
    $userPassword = $check->check_post($_POST['userPassword']);
    $password = md5($userPassword);
    //echo "select * from tbl_user where user_id='$userId' and password='$password' and status=1";
    
    $result = mysql_query("select * from `tbl_user` where user_id='$userId' and password='$password' and status=1");
    $is_exist = mysql_num_rows($result);
    $arrLoginUser = mysql_fetch_array($result);

    if ($is_exist > 0) { 
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_password'] = $userPassword;
        $_SESSION['user_name'] = $arrLoginUser['name'];
        $_SESSION['user_srl_id'] = $arrLoginUser['id'];
        $id = $arrLoginUser['id'];
        $dt = get_current_date_time();
        $ip = getIp();

        // record log
        //$sql="insert into `tbl_log_login` (logged_user_id,from_ip,login_at) values ('$id','$ip','$dt')";
        //mysql_query($sql);
        // count last login
        $lastLogin = date('Y-m-d H:i:s');
        $id = $arrLoginUser['id'];
        mysql_query("update `tbl_user` SET last_login='$lastLogin' WHERE id='$id'");

        unset($_SESSION['reqUserId']);
        unset($_SESSION['reqUserPass']); //exit('21');
        header('Location:?module=dashboard&page=system_info');
        exit;
    } else {
        $_SESSION['reqUserId'] = $userId;
        $_SESSION['reqUserPass'] = $userPassword;
        $_SESSION['login_err'] = "Invalid login information !";
        header('Location:?page=login');
        exit;
    }

}

?>


<style type="text/css">
    body {
        font-family: 'Ropa Sans', sans-serif;
        color: #666;
        font-size: 14px;
        color: #333
    }

    li, ul, body, input {
        margin: 0;
        padding: 0;
        list-style: none
    }

    #login-form {
        width: 352px;
        background: #FFF;
        margin: 0 auto;
        background: #FCFCFC;
        overflow: hidden;
        border-radius: 4px;
        border: 1px solid #DDDDDD;
    }

    .form-header {
        display: table;
        clear: both
    }

    .form-header label {
        display: block;
        cursor: pointer;
        z-index: 999
    }

    .form-header li {
        margin: 0;
        line-height: 60px;
        width: 175px;
        text-align: center;
        background: #e6e6e6;
        font-size: 18px;
        float: left;
        transition: all 600ms ease
    }

    /*sectiop*/
    .section-out {
        width: 700px;
        float: left;
        transition: all 600ms ease
    }

    .section-out:after {
        content: '';
        clear: both;
        display: table
    }

    .section-out section {
        width: 350px;
        float: left
    }

    .login {
        padding: 30px 20px 20px 20px
    }

    .ul-list {
        clear: both;
        display: table;
        width: 100%
    }

    .ul-list:after {
        content: '';
        clear: both;
        display: table
    }

    .ul-list li {
        margin: 0 auto;
        margin-bottom: 15px
    }

    .input {
    	background: #fff;
    	transition: all 800ms;
    	width: 260px;
    	border-radius: 0px 3px 3px 0;
    	font-family: 'Ropa Sans', sans-serif;
    	border: solid 1px #ccc;
    	border-left: 1px solid #ccc;
    	outline: none;
    	color: #666;
    	height: 40px;
    	line-height: 40px;
    	display: inline-block;
    	padding-left: 10px;
    	font-size: 16px;
    }

    .input, .login span.icon {
        vertical-align: top
    }

    .login span.icon {
        width: 50px;
        transition: all 800ms;
        text-align: center;
        color: #666;
        height: 40px;
        border-radius: 3px 0px 0px 3px;
        background: #e8e8e8;
        height: 40px;
        line-height: 40px;
        display: inline-block;
        border: solid 1px #ccc;
        border-right: none;
        font-size: 16px;
    }

    .input:focus:invalid {
        border-color: red
    }

    .input:focus:invalid + .icon {
        border-color: red
    }

    .input:focus:valid {
        border-color: green
    }

    .input:focus:valid + .icon {
        border-color: green
    }

    #check, #check1 {
        top: 1px;
        position: relative
    }

    .btn {
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
        font-family: "Ropa Sans", sans-serif;
        font-size: 16px;
        height: 40px;
        margin: 0 auto;
        outline: medium none;
        padding: 0 10px;
        width: 100%;
    }

    .social-login {
        padding: 15px 20px;
        background: #f1f1f1;
        border-top: solid 2px #e8e8e8;
        text-align: right
    }

    .social-login a {
        display: inline-block;
        height: 35px;
        text-align: center;
        line-height: 35px;
        width: 35px;
        margin: 0 3px;
        text-decoration: none;
        color: #FFFFFF
    }

    .form a i.fa {
        line-height: 35px
    }

    .fb {
        background: #305891
    }

    .tw {
        background: #2ca8d2
    }

    .gp {
        background: #ce4d39
    }

    .in {
        background: #006699
    }

    .remember {
        width: 50%;
        display: inline-block;
        clear: both;
        font-size: 14px
    }

    .remember:nth-child(2) {
        text-align: right
    }

    .remember a {
        text-decoration: none;
        color: #666
    }

    .hide {
        display: none
    }

    /*swich form*/
    #signup:checked ~ .section-out {
        margin-left: -350px
    }

    #login:checked ~ .section-out {
        margin-left: 0px
    }

    #login:checked ~ div .form-header li:nth-child(1), #signup:checked ~ div .form-header li:nth-child(2) {
        background: #F8F8F8
    }

    .sys_name_login {
        width: 352px;
        margin: 50px auto 0;
        font-size: 32px;
        text-align: center;
        color: #83BC3E;
        font-weight: bold;
    }

    .log_reg_header {
        background-color: #E8E8E8;
        padding: 8px;
        text-align: center;
        font-size: 21px;
        color: #666;
    }
</style>

<div style="background:#fff;padding:50px 0px;">
    <div id="login-form">
        <div class="log_reg_header">
            Login
        </div>
        <?php
        if ($_SESSION['login_err'] != "") {
            echo "<div style='color:red;border:0px solid red;text-align:center;padding-top:10px;margin-bottom:-20px'><i class='fa fa-info-circle'></i>&nbsp;" . $_SESSION['login_err'] . "</div>";
            $_SESSION['login_err'] = "";
        }
        ?>
        <div class="section-out">
            <section class="login-section">
                <div class="login">
                    <form method="post">
                        <ul class="ul-list">
                            <li>
                                <span class="icon"><i class="fa fa-user"></i></span><input name="userId" required
                                                                                           id="userId" class="input"
                                                                                           placeholder="User ID"
                                                                                           type="text"
                                                                                           value="<?= $_SESSION['reqUserId'] ?>">
                            </li>
                            <li style="margin-bottom:30px">
                                <span class="icon"><i class="fa fa-lock"></i></span><input type="password" required
                                                                                           name="userPassword"
                                                                                           id="userPassword"
                                                                                           class="input"
                                                                                           placeholder="Password"
                                                                                           value="">
                            </li>
                            <li>
                                <button type="submit" name="btnLogin" class="btn">LOGIN</button>
                            </li>
                            <li>Don't have an Account? <a href="?page=register">Register Now!</a></li>
                            <li><a href="?page=forgot_pass">Forgot your password?</a></li>
                        </ul>
                    </form>
                </div>
            </section>
        </div>
    </div>

</div>