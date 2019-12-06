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
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Work-Study</span> - Day Plans
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
                    <span class="breadcrumb-item active">Work-Study</span>
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
                <h5 class="card-title">Day Plans</h5>
                <div class="header-elements">
                    <a href="<?php echo base_url('Workstudy_con/addNewDayPlan')?>" type="submit" class="btn bg-primary"><i class="icon-pencil-ruler mr-2"></i>New Day Plan</a>
                </div>
            </div>

            <div class="card-body">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                    <div class="table-responsive">
                    <table class="table datatable-basic table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>Line</th>
                            <th>Type</th>
                            <th>Style</th>
                            <th>SMV</th>
                            <th>Workers</th>
                            <th>Plan QTY</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($dayPlans)){
                            foreach ($dayPlans as $row){
                                ?>
                                <tr>
                                    <td><?php echo $row->line; ?></td>
                                    <?php
                                    if ($row->dayPlanType == '1') {
                                        ?>
                                        <td>Normal</td>
                                        <?php
                                    } else if ($row->dayPlanType == '2') {
                                        ?>
                                        <td>Feeding</td>
                                        <?php
                                    } else if ($row->dayPlanType == '3') {
                                        ?>
                                        <td>Two Style - Split Team</td>
                                        <?php
                                    }  else if ($row->dayPlanType == '4') {
                                        ?>
                                        <td>Two Style & Same SMV- All Workers</td>
                                        <?php
                                    }
                                    ?>

                                    <td><?php echo $row->style; ?></td>
                                    <td><?php echo $row->smv; ?></td>
                                    <td><?php echo $row->noOfwokers; ?></td>

                                    <td><?php echo $row->dayPlanQty; ?></td>

                                    <?php
                                    if ($row->status == '1') {
                                        ?>
                                        <td class="text-center"><span class="badge badge-success">&nbsp;&nbsp;Running&nbsp;&nbsp;</span>
                                        </td>
                                        <?php
                                    } else if ($row->status == '2') {
                                        ?>
                                        <td class="text-center"><span class="badge badge-warning">Hold</span></td>
                                        <?php
                                    } else if ($row->status == '3') {
                                        ?>
                                        <td class="text-center"><span class="badge badge-danger">Close</span></td>
                                        <?php
                                    } else if ($row->status == '4') {
                                        ?>
                                        <td class="text-center"><span class="badge badge-primary">Feeding..</span></td>
                                        <?php
                                    }
                                    ?>
                                    <td><?php echo $row->dateTime; ?></td>
                                    <td class="text-center"><a href="<?php echo base_url('Workstudy_con/getDatPlanToEdit/').$row->id ?>"<span style="color: #0c83e2;"><i class="icon-compose ml-2"></i></span></a></td>
                                </tr>
                                <?php
                            }
                        }

                        ?>

                        </tbody>
                    </table>
                    </div>


                </fieldset>
            </div>
        </div>
        <!-- /form inputs -->

    </div>
    <!-- /content area -->
