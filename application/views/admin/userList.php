<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">User</span> - List
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

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Users List</span>
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
                <h5 class="card-title">Users</h5>
                <div class="header-elements">
                        <a href="<?php echo base_url('User_con/addUserView')?>" type="submit" class="btn bg-primary"><i class="icon-user-plus mr-2"></i>New User</a>
                </div>
            </div>

            <div class="card-body">
               <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <table class="table datatable-basic table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>EPF No</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Location</th>
                                <th>UserName</th>
                                <th>Active/Inactive</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if(!empty($allUsers)){
                                    foreach ($allUsers as $row){
                                       ?>
                                        <tr>
                                            <td><?php echo $row->epfNo; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->designation ?></td>
                                            <td><?php echo $row->location ?></td>
                                            <td><?php echo $row->userName ?></td>
                                            <?php
                                            if ($row->active) {
                                                ?>
                                                <td class="text-center"><span class="badge badge-success">&nbsp;&nbsp;Active&nbsp;&nbsp;</span>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td class="text-center"><span class="badge badge-secondary">Inctive</span></td>
                                                <?php
                                            }
                                            ?>

                                            <td class="text-center"><a href="<?php echo base_url('User_con/editUserView/').$row->id ?>"<span style="color: #0c83e2;"><i class="icon-compose ml-2"></i></span></a></td>
                                        </tr>
                            <?php
                                    }
                                }

                            ?>
                            </tbody>
                        </table>
                    </fieldset>
            </div>
        </div>
        <!-- /form inputs -->

    </div>
    <!-- /content area -->