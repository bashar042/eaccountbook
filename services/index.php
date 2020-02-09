<?php
if (isset($_SESSION['user_id'])) {
    $active_input_dash = '';
    $active_input_forms = '';
    $active_input_reports = '';
    $active_input_settings = '';
    if (in_array($page, ['voucher', 'voucher_update'])) {
        $active_input_forms = 'active';
    } else if (in_array($page, ['cr_history', 'cr_dr_history', 'cr_dr_history', 'voucher_summary'])) {
        $active_input_reports = 'active';
    } else if (in_array($page, ['heads', 'profile_view'])) {
        $active_input_settings = 'active';
    } else if (in_array($page, ['system_info'])) {
        $active_input_dash = 'active';
    } else {
        $active_input_dash = 'active';
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
        <link rel="shortcut icon" href="<?= $base_url ?>images/eabLogo.png" height="35" width="35">

        <title>eAccountBook - Personal Account Management</title>

        <!-- Bootstrap core CSS -->
        <link href="<?= $base_url ?>helper/css/bootstrap.css" rel="stylesheet">
        <link href="<?= $base_url ?>helper/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $base_url ?>helper/css/font-awesome.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="<?= $base_url ?>helper/css/bootstrap-theme.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?= $base_url ?>helper/css/theme.css" rel="stylesheet">
        <link href="<?= $base_url ?>helper/css/tcal.css" rel="stylesheet">
        <link href="<?= $base_url ?>helper/css/custom_acc_sys.css" rel="stylesheet">
        <link href="<?= $base_url ?>helper/date_picker/bootstrap-datetimepicker.css" rel="stylesheet">
        <link href="<?= $base_url ?>helper/date_picker/bootstrap-datetimepicker.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../../assets/js/html5shiv.js"></script>
        <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
        <style type="text/css" id="holderjs-style">
            .holderjs-fluid {
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                font-family: sans-serif;
                margin: 0
            }
        </style>
        <?php
        //include "pages/landing/google_analytics_script.php";
        ?>
        <script src="<?= $base_url ?>helper/js/date_time.js"></script>
    </head>

    <body style="background:#F1F1F1;">
    <div class="container theme-showcase main_wrapper">
        <div class="row top_header">
            <div class="col-lg-8 sys_name">
                <span class="system_logo"><img src="<?= $base_url ?>images/eabLogo.png" alt="Logo"
                                               class="logo_sm"></span>&nbsp;
                <span class="system_name">Personal Account System(PAS)</span>
            </div>
            <div class="col-lg-4 user_name_img">
                <i class="fa fa-user" alt="UserImg" style="font-size:;color:#00B4FF"></i>&nbsp;
                <?= $_SESSION['user_id'] ?>&nbsp; | &nbsp; <a href="?module=sys_settings&page=logout"><i
                            class="fa fa-power-off" style="color:#D32826"></i>&nbsp;Logout</a>
                <div id="date_time"></div>
                <script type="text/javascript">window.onload = date_time('date_time');</script>
            </div>
        </div>
        <nav class="navbar navbar-default navbar-inverse" role="navigation">
            <?php
            include $base_url . 'common/header_menu.php';
            ?>
        </nav>
        <?php
        if (isset($_GET['module']) && isset($_GET['page'])) {
            $module = $_GET['module'];
            $page = $_GET['page'];
            /* echo "select * from tbl_side_map
            where module_value='$module' and page_value='$page' and page_status='1' order by id"; */
            $result = mysql_query("select * from tbl_side_map 
					where module_value='$module' and page_value='$page' and page_status='1' order by id");
            $numEntry = mysql_num_rows($result);
            if ($numEntry == 1) {
                $reqPage = mysql_fetch_array($result);
                include $base_url . $reqPage['path'];
            } else {
                include $base_url . "common/page_not_found.php";
            }
        }
        ?>
    </div>
    <div class="ris_footer">
        <div class="row">
            <div class="col-lg-6" style="text-align:left">Copyright &copy; 2015 - 2020 . All right reserved by
                eaccountbook.com
            </div>
            <div class="col-lg-6" style="text-align:right">Powered by - <a href="http://ideaitbd.com" target="_blank">Idea
                    IT Bangladesh</a></div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?= $base_url ?>helper/js/jquery.js"></script>
    <script src="<?= $base_url ?>helper/js/bootstrap.js"></script>
    <script src="<?= $base_url ?>helper/js/bootstrap.min.js"></script>
    <script src="<?= $base_url ?>helper/js/holder.js"></script>
    <script src="<?= $base_url ?>helper/js/custome_script.js"></script>
    <script src="<?= $base_url ?>helper/js/tcal.js"></script>
    <script src="<?= $base_url ?>helper/js/tab.js"></script>
    <script src="<?= $base_url ?>helper/date_picker/jquery.1.9.1.js"></script>
    <script src="<?= $base_url ?>helper/date_picker/bootstrap-datepicker.js"></script>
    </body>
    </html>
    <?php
}  // end module checking
else {
    // $dir = 'module/system_user/';
    // include $base_url.$dir.'login_form.php';
    header("Location:index.php?page=login");
    exit;
}
?>
