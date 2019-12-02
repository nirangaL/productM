<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/23/2019-->
<!-- * Time: 9:05 AM-->
<!-- */-->



<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Master Data</span>
                </h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-link btn-float text-default"><i
                                class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i>
                        <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i>
                        <span>Schedule</span></a>
                </div>
            </div>

            <!--            --><?php //print_r($userGroups);?>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
<!--                    <a href="" class="breadcrumb-item">Master</a>-->
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Form inputs -->
        <div class="card card-body">
            <div class="row">
              <?php if($this->MyConUserGroup == '1'){ ?>
                <div class="col-sm-3">
                    <a href="<?php echo base_url('Company_Master_Con'); ?>" class="small-box-footer">
                        <div class="card card-body bg-green-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">My Company</h3>
                                    <span class="text-uppercase text-size-mini">Open My Company</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-office icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3">
                    <a href="<?php echo base_url('Location_Master_Con'); ?>" class="small-box-footer">
                        <div class="card card-body bg-green-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">Location</h3>
                                    <span class="text-uppercase text-size-mini">Open Location</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-pin-alt icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3">
                    <a href="<?php echo base_url('master/Master_Department_Con'); ?>" class="small-box-footer">
                        <div class="card card-body bg-green-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">Department</h3>
                                    <span class="text-uppercase text-size-mini">Open Department</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-stack3 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3">
                    <a href="<?php echo base_url('master/Master_Team_Con'); ?>" class="small-box-footer">
                        <div class="card card-body bg-green-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">Team</h3>
                                    <span class="text-uppercase text-size-mini">Open Teams</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-cube4 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

              <?php } ?>
<!--
                <div class="col-sm-3">
                    <a href="<?php //echo base_url('bpom/Style_info_con'); ?>" class="small-box-footer">
                        <div class="card card-body bg-blue-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">Production</h3>
                                    <span class="text-uppercase text-size-mini">Buyer Purchase Order Manager</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-book3 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
 -->
            <?php if($this->MyConUserGroup == '1' || $this->MyConUserGroup == '13' ){ ?>
                <div class="col-sm-3">
                    <a href="<?php echo base_url('master/Emp_Master_Con'); ?>" class="small-box-footer">
                        <div class="card card-body bg-blue-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">HR Management</h3>
                                    <span class="text-uppercase text-size-mini">Employee Add</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-book3 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>
     <!--            <div class="col-sm-3">
                    <a href="<?php //echo base_url('account_controll/index'); ?>" class="small-box-footer">
                        <div class="card card-body bg-blue-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">Accounts</h3>
                                    <span class="text-uppercase text-size-mini">Open Accounts</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-book3 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> -->





                <!-- <div class="col-sm-3">
                    <a href="<?php //echo base_url('account_controll/index'); ?>" class="small-box-footer">
                        <div class="card card-body bg-pink-700 p-20">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin">Accounts</h3>
                                    <span class="text-uppercase text-size-mini">Open Accounts</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-book3 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> -->







            </div>
        </div>
        <!-- /form inputs -->

    </div>
    <!-- /content area -->
