<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/23/2019-->
<!-- * Time: 8:52 AM-->
<!-- */-->

<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Team List</span>
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
                    <a href="<?php echo base_url('Master_Con');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">team</span>
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
                <h5 class="card-title">Team</h5>
                <div class="header-elements">
                    <a href="<?php echo base_url('master/Master_Team_Con/addTeam')?>" type="submit" class="btn bg-primary"><i class="icon-color-sampler mr-2"></i>New Team</a>
            </div>
            </div>

            <div class="card-body">

              <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                    <table class="table datatable-basic table-hover table-bordered">
                        <thead>
                        <tr>
                          <th>Location</th>
                          <th>Department</th>
                          <th>Team</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($teams)){
                            foreach ($teams as $row){
                                ?>
                                <tr>
                                    <td><?php echo $row->location; ?></td>
                                    <td><?php echo $row->department; ?></td>
                                    <td><?php echo $row->line; ?></td>
                                    <?php
                                    if ($row->active == '1') {
                                        ?>
                                        <td class="text-center"><span class="badge badge-success">&nbsp;&nbsp;Active&nbsp;&nbsp;</span>
                                        </td>
                                        <?php
                                    } else if ($row->active == '0') {
                                        ?>
                                        <td class="text-center"><span class="badge badge-danger"> Inactive </span></td>
                                        <?php
                                    }
                                    ?>

                                    <td class="text-center"><a href="<?php echo base_url('master/Master_Team_Con/getTeamToEdit/').$row->line_id ?>"<span style="color: #0c83e2;"><i class="icon-compose ml-2"></i></span></a></td>
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
