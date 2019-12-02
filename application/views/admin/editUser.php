<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/22/2019-->
<!-- * Time: 1:08 PM-->
<!-- */-->

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">User</span> - Edit
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

    <?php $userId =  $user[0]->id;?>

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
                <form action="<?php echo base_url('User_con/editUser/').$userId;?>" method="post">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <div class="form-group row">

                            <label class="col-form-label col-lg-2">EPF Number :</label>
                            <div class="col-lg-2">
                                <input id="epfNo" name="epfNo" type="text" class="form-control" value="<?php if(!empty($user[0]->epfNo)){echo $user[0]->epfNo;}else{echo set_value('epfNo');} ?>" readonly>
                                <span class="error" id="error"><?php echo form_error('epfNo'); ?></span>
                            </div>

                            <label class="col-form-label col-lg-2">Name with Initial :</label>
                            <div class="col-lg-6">
                                <input id="uName" name="uName" type="text" class="form-control" value="<?php if(!empty($user[0]->name)){echo $user[0]->name;}else{echo set_value('uName');} ?>">
                                <span class="error" id="error"><?php echo form_error('uName'); ?></span>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Designation :</label>
                            <div class="col-lg-4">
                                <input id="designation" name="designation" type="text" class="form-control" value="<?php if(!empty($user[0]->designation)){echo $user[0]->designation;}else{echo set_value('designation');} ?>">
                                <span class="error" id="error"><?php echo form_error('designation'); ?></span>
                            </div>
                            <label class="col-form-label col-lg-2">User Group :</label>
                            <div class="col-lg-4">
                                <select id="userGroup" name="userGroup" class="custom-select" >
                                    <option value="" >--- Select User Group ----</option>
                                    <?php foreach ($userGroups as $row){
                                        ?>
                                        <option value="<?php echo $row->id;?>" <?php if($user[0]->userGroup == $row->id ){echo 'Selected';}else{echo set_select('userGroup', $row->id);} ?> > <?php echo $row->userGroup;?> </option>
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
                                        <option value="<?php echo $row->location_id;?>" <?php if($user[0]->location == $row->location_id){echo 'Selected';}else{echo set_select('location', $row->location_id);} ?> > <?php echo $row->location;?> </option>
                                        <?php
                                    }?>
                                </select>
                                <span class="error" id="error"><?php echo form_error('location'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Login User Name :</label>
                            <div class="col-lg-4">
                                <input id="userName" name="userName" type="text" class="form-control" placeholder="Enter your username..." value="<?php if(!empty($user[0]->userName)){echo $user[0]->userName;}else{echo set_value('userName');} ?>" readonly>
                                <span class="error" id="error"><?php echo form_error('userName'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Password :</label>
                            <div class="col-lg-4">
                                <input id="userPassword" name="userPassword" type="password" class="form-control" value="NNNNNNNNNN" >
                                <span class="error" id="error"><?php echo form_error('userPassword'); ?></span>
                            </div>

                            <label class="col-form-label col-lg-2">Confirmed Password  :</label>
                            <div class="col-lg-4">
                                <input id="confPassword" name="confPassword" type="password" class="form-control" value="NNNNNNNNNN">
                                <span class="error" id="error"><?php echo form_error('confPassword'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">E-Mail Address</label>
                            <div class="col-lg-4">
                                <input id="email" name="email" type="text" class="form-control" value="<?php if(!empty($user[0]->email)){echo $user[0]->email;}else{echo set_value('email');} ?>">
                                <span class="error" id="error"><?php echo form_error('email'); ?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Active Status:</label>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <label clgass="form-check-label">
                                        <input type="radio" name="activeStatus" value="1" <?php if($user[0]->active==0){echo 'Checked';}else{set_checkbox('activeStatus', '0');}?> <?php if($user[0]->active==1){echo 'Checked';}else{set_checkbox('activeStatus', '1');}?> class="form-check-input-styled-primary" checked data-fouc>
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" name="activeStatus" value="0" <?php if($user[0]->active==0){echo 'Checked';}else{set_checkbox('activeStatus', '0');}?> class="form-check-input-styled-danger" data-fouc>
                                        Inactive
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" id="update" name="update"  class="btn bg-purple-400 ">Update<i class="icon-pencil7 ml-2"></i> </button>
                            <button type="button" id="delete" name="delete"  class="btn btn-danger" onclick="deleteConfirm('Are you sure,Do you want to delete this User ?','User_con/deleteUser/<?php echo $userId;?>');" >Delete<i class="icon-bin2 ml-2"></i> </button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- /form inputs -->

    </div>
    <!-- /content area -->

    <script>


        $(document).ready(function () {

        });

        function getLocations() {
            var comp_id = $('#company').val();
            var html='<option value="">Select Location</option>';
            $.ajax({
                url: '<?php echo base_url("User_con/getLocations")?>', //This is the current doc
                type: "POST",
                data: ({
                    comp_id: comp_id,
                }),
                success: function (data) {
                    var json_value = JSON.parse(data);
                    for (var i = 0; i < json_value.length; i++) {
                        var temp  = json_value[i]['location_id'];
                        html += "<option value='" + json_value[i]['location_id'] + "'>"+ json_value[i]['location'] + "</option>";
                    }
                    $('#location').empty().append(html);
                }
            });

        }

        function alertMeg(msgType,msg){
            if(msgType == 'success'){
                toastr.success(msg);
            }else  if(msgType == 'info'){
                toastr.info(msg);
            }else if(msgType == 'warning'){
                toastr.warning(msg);
            }else if(msgType == 'error'){
                toastr.error(msg);
            }

        }

    </script>





