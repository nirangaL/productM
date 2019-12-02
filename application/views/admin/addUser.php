<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/21/2019-->
<!-- * Time: 10:07 AM-->
<!-- */-->


<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">User</span> - Add
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
                    <a href="<?php echo base_url('User_con/userList')?>" class="breadcrumb-item">User</a>
                    <span class="breadcrumb-item active">Add User</span>
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
                <h5 class="card-title">User Form</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="<?php echo base_url('User_con/saveUser')?>" method="post">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <div class="form-group row">

                            <label class="col-form-label col-lg-2">EPF Number :</label>
                            <div class="col-lg-2">
                                <input id="epfNo" name="epfNo" type="text" class="form-control" value="<?php echo set_value('epfNo'); ?>">
                                <span class="error" id="error"><?php echo form_error('epfNo'); ?></span>
                            </div>

                            <label class="col-form-label col-lg-2">Name with Initial :</label>
                            <div class="col-lg-6">
                                <input id="uName" name="uName" type="text" class="form-control" value="<?php echo set_value('uName'); ?>">
                                <span class="error" id="error"><?php echo form_error('uName'); ?></span>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Designation :</label>
                            <div class="col-lg-4">
                                <input id="designation" name="designation" type="text" class="form-control" value="<?php echo set_value('designation'); ?>">
                                <span class="error" id="error"><?php echo form_error('designation'); ?></span>
                            </div>
                            <label class="col-form-label col-lg-2">User Group :</label>
                            <div class="col-lg-4">
                                <select id="userGroup" name="userGroup" class="custom-select" >
                                    <option value="" >--- Select User Group ----</option>
                                    <?php foreach ($userGroups as $row){
                                       ?>
                                        <option value="<?php echo $row->id;?>" <?php echo set_select('userGroup', $row->id);?> > <?php echo $row->userGroup;?> </option>
                                        <?php
                                    }?>
                                </select>
                                <span class="error" id="error"><?php echo form_error('userGroup'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Location :</label>
                            <div class="col-lg-4">
                                <select id="location" name="location" class="custom-select" >
                                    <option value="" >--- Select Location ----</option>
                                    <?php foreach ($location as $row){
                                        ?>
                                        <option value="<?php echo $row->location_id;?>" <?php echo set_select('location', $row->location_id);?> > <?php echo $row->location;?> </option>
                                        <?php
                                    }?>
                                </select>
                                <span class="error" id="error"><?php echo form_error('location'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Login User Name :</label>
                            <div class="col-lg-4">
                                <input id="userName" name="userName" type="text" class="form-control" placeholder="Enter your username..." value="<?php echo set_value('userName'); ?>">
                                <span class="error" id="error"><?php echo form_error('userName'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Password :</label>
                            <div class="col-lg-4">
                                <input id="userPassword" name="userPassword" type="password" class="form-control" value="<?php echo set_value('userPassword'); ?>">
                                <span class="error" id="error"><?php echo form_error('userPassword'); ?></span>
                            </div>

                            <label class="col-form-label col-lg-2">Confirmed Password  :</label>
                            <div class="col-lg-4">
                                <input id="confPassword" name="confPassword" type="password" class="form-control" value="<?php echo set_value('confPassword'); ?>">
                                <span class="error" id="error"><?php echo form_error('confPassword'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">E-Mail Address</label>
                            <div class="col-lg-4">
                                <input id="email" name="email" type="text" class="form-control" value="<?php echo set_value('email'); ?>">
                                <span class="error" id="error"><?php echo form_error('email'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Active Status:</label>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" name="activeStatus" value="1" <?php set_checkbox('activeStatus', '1');?> class="form-check-input-styled-primary" data-fouc>
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" name="activeStatus" value="0" <?php set_checkbox('activeStatus', '0');?> class="form-check-input-styled-danger" data-fouc>
                                        Inactive
                                    </label>
                                </div>
                            </div>
                        </div>

                    <div class="text-right">
                        <button type="submit" id="save" name="save"  class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i> </button>
                        <button type="reset" class="btn btn-warning">Reset<i class="icon-reset ml-2"></i> </button>

                    </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- /form inputs -->

    </div>
    <!-- /content area -->


