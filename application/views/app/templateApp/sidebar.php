<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/21/2019-->
<!-- * Time: 10:15 AM-->
<!-- */-->

<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Main</div></li>
                <li class="nav-item">
                    <a href="<?php echo base_url('app/App_Team')?>" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>Dashboard
						</span>
                    </a>
                </li>
                <!-- /main -->

                <!-- Work-Study -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Work-Study</div>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-equalizer2"></i> <span>Work-Study</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Workstudy ">
                        <li class="nav-item"><a href="<?php echo base_url()?>incentive_con" class="nav-link">  <i class="icon-esc"></i>Incentive Master</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>Plan_efficiency_con" class="nav-link">  <i class="icon-esc"></i>Efficiency Plan</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>Time_Template_con" class="nav-link">  <i class="icon-sort-time-asc"></i>Team Time</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>Workstudy_con" class="nav-link">  <i class="icon-vector"></i>Day plan</a></li>
                    </ul>
                </li>

                <!--/ Work-Study -->


                <!-- Work-Study -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Report</div>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-book"></i> <span>Report</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Day plan ">
                        <li class="nav-item"><a href="<?php echo base_url()?>report/StyleSizeWise_con" class="nav-link">  <i class="icon-menu6"></i>Style Size Wise Report</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>report/TeamWiseEfficiency_con" class="nav-link">  <i class="icon-esc"></i>Date Wise Efficiency Report</a></li>
<!--                        <li class="nav-item"><a href="--><?php //echo base_url()?><!--Team_time_con" class="nav-link">  <i class="icon-sort-time-asc"></i>Team Time</a></li>-->
<!--                        <li class="nav-item"><a href="--><?php //echo base_url()?><!--Workstudy_con" class="nav-link">  <i class="icon-vector"></i>Day plan</a></li>-->
                    </ul>
                </li>
                <!--/ Work-Study -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
