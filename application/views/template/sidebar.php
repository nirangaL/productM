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

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img
                                    src="<?php echo base_url() ?>assets/global_assets/images/placeholders/placeholder.jpg"
                                    width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold"><?php echo $_SESSION['session_user_data']['name'];?></div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-briefcase font-size-sm"></i> <?php echo $_SESSION['session_user_data']['designation'];?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?php echo base_url('Location_Dashboard_Con')?>" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>Dashboard
						</span>
                    </a>
                </li>
                <!-- /Dashboard -->
                <?php if($this->MyConUserGroup == '1' || $this->MyConUserGroup == '13' ){ ?>
                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Main</div>
                    <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="<?php echo base_url()?>Master_Con" class="nav-link">
                        <i class="icon-grid52"></i>
                        <span>Master
						                  </span>
                    </a>
                </li>
                <!-- /main -->

              <?php } if($this->MyConUserGroup =='11' || $this->MyConUserGroup=='2' ||  $this->MyConUserGroup=='1'){ ?>

                <!-- Work-Study -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Work-Study</div>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-equalizer2"></i> <span>Work-Study</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Works-Study">
                        <li class="nav-item"><a href="<?php echo base_url()?>incentive_con" class="nav-link">  <i class="icon-esc"></i>Incentive Master</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>Plan_efficiency_con" class="nav-link">  <i class="icon-esc"></i>Efficiency Plan</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>Time_Template_con" class="nav-link">  <i class="icon-sort-time-asc"></i>Time Template</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>Workstudy_con" class="nav-link">  <i class="icon-vector"></i>Day plan</a></li>
                    </ul>
                </li>
                <!--/ Work-Study -->
              <?php }

              if($this->MyConUserGroup =='4' ||  $this->MyConUserGroup == '1'){ ?>
                <!-- bpom -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">BPOM</div>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-enlarge3"></i> <span>BPOM</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="BPOM">
                       <!-- <li class="nav-item"><a href="<?php //echo base_url()?>bpom/Buyer_info_Con" class="nav-link">  <i class="icon-user-tie"></i>BPOM - Buyer Info</a></li>-->
                        <li class="nav-item"><a href="<?php echo base_url()?>bpom/Style_info_Con" class="nav-link">  <i class="icon-reminder"></i>BPOM - Style Info</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>bpom/Cut_Plan_Con" class="nav-link">  <i class="icon-scissors"></i>BPOM - Cut Plan</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>bpom/Style_info_Con" class="nav-link">  <i class="icon-pencil4"></i>BPOM - Style Info</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>bpom/Style_info_Con" class="nav-link">  <i class="icon-pencil4"></i>BPOM - Style Info</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>bpom/Style_info_Con" class="nav-link">  <i class="icon-pencil4"></i>BPOM - Style Info</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>bpom/Style_info_Con" class="nav-link">  <i class="icon-pencil4"></i>BPOM - Style Info</a></li>
                    </ul>
                </li>
                <!--/ bpom -->

              <?php }

                  if($this->MyConUserGroup =='5' ||  $this->MyConUserGroup == '1'){ ?>

            <!-- Cutting Dep -->
            <li class="nav-item-header">
                <div class="text-uppercase font-size-xs line-height-xs">Cutting Dep</div>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-ungroup"></i> <span>Cutting Dep</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Cutting">
                    <li class="nav-item"><a href="<?php echo base_url('bpom/cutdep/Cutting_Cut_Plan_Con')?>" class="nav-link">  <i class="icon-vector"></i>Proceed Cut-Plan</a></li>
                    <li class="nav-item"><a href="<?php echo base_url('cutting/Cutting_Out_Con')?>" class="nav-link">  <i class="icon-esc"></i>Cutting Output</a></li>
                    <!-- <li class="nav-item"><a href="<?php echo base_url()?>Time_Template_con" class="nav-link">  <i class="icon-sort-time-asc"></i>Time Template</a></li>
                    <li class="nav-item"><a href="<?php echo base_url()?>Workstudy_con" class="nav-link">  <i class="icon-vector"></i>Day plan</a></li>  -->
                </ul>
            </li>
            <!--/ Cutting Dep -->

                  <?php }

                      if($this->MyConUserGroup =='12' ||  $this->MyConUserGroup == '1'){ ?>

                <!-- Cutting Dep -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Production Dep</div>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-puzzle2"></i> <span>Production Dep</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Production">
                        <li class="nav-item"><a href="<?php echo base_url('production/Line_In_Con')?>" class="nav-link">  <i class="icon-cart-add"></i>Line In</a></li>
                        <li class="nav-item"><a href="<?php  echo base_url('production/Line_Out_Con')?>" class="nav-link">  <i class="icon-cart5"></i>Line Out</a></li>
                        <!-- <li class="nav-item"><a href="<?php // echo base_url()?>Time_Template_con" class="nav-link">  <i class="icon-sort-time-asc"></i>Time Template</a></li>
                        <li class="nav-item"><a href="<?php // echo base_url()?>Workstudy_con" class="nav-link">  <i class="icon-vector"></i>Day plan</a></li>  -->
                    </ul>
                </li>
                <!--/ Cutting Dep -->
              <?php }
           ?>
                <!-- Work-Study -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Report</div>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-book"></i> <span>Report</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Report ">
                        <li class="nav-item"><a href="<?php echo base_url()?>report/StyleSizeWise_con" class="nav-link">  <i class="icon-menu6"></i>Style Size Wise Report</a></li>
                        <li class="nav-item"><a href="<?php echo base_url()?>report/TeamWiseEfficiency_con" class="nav-link">  <i class="icon-esc"></i>Date Wise Efficiency Report</a></li>
                       <li class="nav-item"><a href="http://192.168.1.211/intranet/index.php/Pass_list_report_con" class="nav-link">  <i class="icon-sort-time-asc"></i>View Pass & Defect Qty</a></li>
                       <li class="nav-item"><a href="<?php echo base_url()?>report/DateWisePassQtyReport" class="nav-link">  <i class="icon-calendar2"></i>Day wise pass Qty</a></li>
                       <li class="nav-item"><a href="<?php echo base_url()?>report/Qc_passlog" class="nav-link">  <i class="icon-stack-check"></i>Qc Pass Log</a></li>
                       <li class="nav-item"><a href="<?php echo base_url()?>report/Qc_defectlog" class="nav-link">  <i class="icon-stack-cancel"></i>Qc Defect Log</a></li>
                       <li class="nav-item"><a href="<?php echo base_url()?>report/Team_Workers_List_Con" class="nav-link">  <i class="icon-people"></i>Date Wise worker list</a></li>
                       <!-- <li class="nav-item"><a href="--><?php //echo base_url()?><!--Workstudy_con" class="nav-link">  <i class="icon-vector"></i>Day plan</a></li> -->
                    </ul>
                </li>
                <!--/ Work-Study -->


                <?php if($_SESSION['session_user_data']['userGroup'] == "1"){?>
                <!-- Admin -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Admin</div>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-cog3"></i> <span>Preference</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Admin">
                        <li class="nav-item"><a href="<?php echo base_url()?>User_con/userList" class="nav-link">  <i class="icon-users2"></i>Users</a></li>
                    </ul>
                </li>
                <!-- /Admin -->
                <?php } ?>


            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
