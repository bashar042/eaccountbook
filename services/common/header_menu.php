<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="javascript:void(0)">Personal Account System</a>
</div>
<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?= $active_input_dash; ?>"><a href="?module=dashboard&page=system_info"><i
                        class="fa fa-dashboard"></i>&nbsp;Dashboard</a></li>
        <li class="dropdown <?= $active_input_forms; ?>">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="fa fa-plus-square"></i>&nbsp;Manage Voucher<b class="caret"></b></a>
            <ul class="dropdown-menu">
                </li>
                <li><a href="?module=accounts&page=voucher"><i class="fa fa-file-text-o"></i>&nbsp; Add New
                        Voucher</a></li>
                <li><a href="?module=accounts&page=voucher_update"><i class="fa fa-pencil-square-o"></i>&nbsp; Voucher
                        Update</a></li>
            </ul>
        </li>

        <li class="dropdown <?= $active_input_reports; ?>">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-th"></i>&nbsp;Reports<b
                        class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="?module=accounts&page=voucher_summary"><i class="fa fa-file-text"></i>&nbsp; Voucher
                        Summary</a></li>
                <li><a href="?module=accounts&page=dr_history"><i class="fa fa-minus-square-o"></i>&nbsp; Cost
                        History</a></li>
                <li><a href="?module=accounts&page=cr_history"><i class="fa fa-arrows"></i>&nbsp; Income History</a>
                </li>
                <li><a href="?module=accounts&page=cr_dr_history"><i class="fa fa-line-chart"></i>&nbsp; Income vs Costs</a>
                </li>
                <!--<li><a href="#">Balance Sheet</a></li>-->
            </ul>
        </li>
        <!--<li><a href=""><i class="fa fa-file-text"></i>&nbsp;Event's Calender</a></li>-->
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <!--<li><a href="?module=sys_settings&page=contact"><i class="fa fa-envelope-o"></i>&nbsp;Contact</a></li>-->
        <!--<li><a href="?module=sys_settings&page=donate"><i class="fa fa-usd"></i>&nbsp;Donate</a></li>-->
        <li class="dropdown <?= $active_input_settings; ?>">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-cog fa-fw"></i>&nbsp;Settings<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="?module=sys_settings&page=heads"><i class="fa fa-pencil-square"></i>&nbsp; Account
                        Heads</a>
                <li class="divider"></li>
                <li><a href="?module=sys_settings&page=profile_view"><i class="fa fa-user"></i>&nbsp;Profile</a></li>
                <li><a href="#"><i class="fa fa-gears"></i>&nbsp;Preference</a></li>
                <!--
                <li class="divider"></li>
                <li><a href="?module=sys_settings&page=logout"><i class="fa fa-power-off" style="color:#D32826"></i>&nbsp;Logout</a></li>
                -->
            </ul>
        </li>
        <?php
        //echo $sysPass=md5('792556');
        //echo "<br/>";
        //echo $_SESSION['user_password'];
        if ($_SESSION['user_id'] == 'admin' && $_SESSION['user_password'] == '792556') {
            ?>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-gears"></i>&nbsp;Administrator<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="?module=admin_reports&page=user_list"><i class="fa fa-user"></i>&nbsp;Client List</a>
                    </li>
                    <li><a href="http://eaccountbook.com:2095" target="_blank"><i class="fa fa-envelope-o"></i>&nbsp;Check
                            Webmail</a></li>
                    <li><a href="#"><i class="fa fa-sitemap"></i>&nbsp;System sitemap</a></li>
                    <li><a href="#"><i class="fa fa-credit-card"></i>&nbsp;Client Transaction</a></li>
                    <!--
                    <li class="divider"></li>
                    <li><a href="?module=sys_settings&page=logout"><i class="fa fa-power-off" style="color:#D32826"></i>&nbsp;Logout</a></li>
                    -->
                </ul>
            </li>
            <?php
        }
        ?>
    </ul>
</div><!--/.nav-collapse -->
