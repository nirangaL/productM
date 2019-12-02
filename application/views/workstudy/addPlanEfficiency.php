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
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Plan Efficiency</span> - Add
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
                    <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="<?php echo base_url('Plan_efficiency_con')?>" class="breadcrumb-item">Plan Efficiency - List</a>
                    <span class="breadcrumb-item active">Add Plan Efficiency</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">

        <!-- Form inputs -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Plan Efficiency Form</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
<!--                        <a class="list-icons-item" data-action="reload"></a>-->
<!--                        <a class="list-icons-item" data-action="remove"></a>-->
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="<?php echo base_url('Plan_efficiency_con/savePlanEfficiency')?>" method="post">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">Day :</label>
                            <div class="col-lg-2">
                                <input id="day" name="day" type="number" class="form-control" value="<?php echo set_value('day'); ?>" min="1">
                                <span class="error" id="error"><?php echo form_error('day'); ?></span>
                            </div>
                            <label class="col-form-label col-lg-1">Efficiency :</label>
                            <div class="col-lg-2">
                                <input id="efficiency" name="efficiency" type="text" class="form-control" value="<?php echo set_value('efficiency'); ?>">
                                <span class="error" id="error"><?php echo form_error('efficiency'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <legend></legend>
                                <div class="text-right">
                                    <button type="submit" id="save" name="save"  class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i> </button>
                                    <button type="reset" class="btn btn-warning">Reset<i class="icon-reset ml-2"></i> </button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- /form inputs -->

    </div>
    <!-- /content area -->

    <script>

    </script>