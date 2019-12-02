<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Monthly Efficiency Report
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
                    <a href="<?php echo base_url('Workstudy_con') ?>" class="breadcrumb-item">Report</a>
                    <span class="breadcrumb-item active">Team Efficiency</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">

            <!--            --><?php //print_r($tableData);?>

            <div class="card-body">
                <form action="<?php echo base_url('report/TeamWiseEfficiency_con/getTableData')?>" method="post">
                    <div class="row">
                        <label class="col-form-label col-lg-1">Date : </label>
                        <div class="col-lg-3">
                            <div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text"><i class="icon-calendar5"></i></span>
										</span>

                                <select id="month" name="month" class="form-control select-search select2" data-fouc=""
                                        tabindex="-1" >
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March </option>
                                    <option value="4">April </option>
                                    <option value="5">May </option>
                                    <option value="6">June </option>
                                    <option value="7">July </option>
                                    <option value="8">August </option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">All</option>
                                    <option value="12">All</option>
                                </select>
                            </div>
                        </div>

                        <label class="col-form-label col-lg-1">Location : </label>
                        <div class="col-lg-2">
                            <select id="location" name="location" class="form-control select-search select2" data-fouc=""
                                    tabindex="-1" >
                                <option value="All">All</option>
                                <?php
                                if (!empty($location)) {
                                    foreach ($location as $row) {
                                        ?>
                                        <option value="<?php echo $row->location_id; ?>" <?php if($row->location_id == $selectLocation){echo 'Selected';}?> > <?php echo $row->location; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-lg-5">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <table id="dateWiseEfficTable" class="table dataTable">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Team</th>
                    <th>Style</th>
                    <th>Delivery</th>
                    <th>Planned Qty</th>
                    <th>Actual Qty</th>
                    <th>Efficiency</th>
                </tr>
                </thead>
                <tbody>

                <?php
                if(!empty($tableData)){
                    foreach ($tableData as $row){
                        ?>
                        <tr>
                            <td><?php echo date('Y-m-d', strtotime($row->dateTime));?></td>
                            <td><?php echo $row->location;?></td>
                            <td><?php echo $row->line;?></td>
                            <td><?php echo $row->style;?></td>
                            <td><?php echo $row->delivery;?></td>
                            <td><?php echo $row->totalPlanQty;?></td>
                            <td><?php echo $row->actualOutQty;?></td>
                            <td><?php echo $row->efficiency.'%';?></td>
                        </tr>
                        <?php
                    }

                }
                ?>

                </tbody>
            </table>
        </div>
    </div>


    <script>

        $(document).ready(function () {
            $('.datepick').pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'yyyy-mm-dd',
            })

            $('#dateWiseEfficTable').DataTable({
                retrieve: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Date Wise Efficiency'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Date Wise Efficiency'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Date Wise Efficiency'
                    }, {
                        extend: 'print',
                        title: 'Date Wise Efficiency'
                    }
                ]
            });


        });


    </script>
