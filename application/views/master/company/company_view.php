<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Company</span>
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
                    <a href="<?php echo base_url('Master_Con')?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">Company</a>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">
            <div class="card-header">
                    <div class="col-sm-12 text-right">
                        <a class="btn bg-blue-800 text-right" type="button" href="<?php echo base_url('Company_Master_Con/selectUpdate').'/'.$company[0]->comp_id; ?>"><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit Information</a>
                    </div>
                </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table table-lg">
                                <tbody>
                                <tr>
                                    <th style="width: 20%;" class="text-left">Company<span class="text-right">:</span></th>
                                    <td><?php echo $company[0]->company; ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="text-left">Address<span class="text-right">:</span></th>
                                    <td><?php echo $company[0]->address; ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="text-left">Country<span class="text-right">:</span></th>
                                    <td><?php echo $company[0]->countryName; ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="text-left">Phone<span class="text-right">:</span></th>
                                    <td><?php echo  $company[0]->phoneCode.'-'.$company[0]->phone; ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="text-left">Web Site<span class="text-right">:</span></th>
                                    <td><?php echo $company[0]->web;?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-lg">
                                <tbody>
                                <tr>
                                    <th style="width: 20%;" class="text-left">E-mail<span class="text-right">:</span></th>
                                    <td><?php echo $company[0]->email;?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="text-left">Other Email<span class="text-right">:</span></th>
                                    <td><?php echo $company[0]->email2;?></td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
        </div>
    </div>
