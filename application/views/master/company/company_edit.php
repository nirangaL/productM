<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Company Update</span>
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
                    <a href="<?php echo base_url('Company_Master_Con')?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Company</a>
                    <a href="#" class="breadcrumb-item">Company Update</a>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->

    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Update Company Data</h5>

            </div>

            <div class="card-body">
                <form action="<?php echo base_url('Company_Master_Con/updateCompany/'.$company[0]->comp_id); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company: <span class="text-danger">*</span></label>
                                <input type="text" name="cName" id="cName" value="<?php echo $company[0]->company; ?>" class="form-control required" placeholder="Example (Pvt) Ltd">
                            </div>
                            <div class="form-group">
                                <label>Address : <span class="text-danger">*</span></label>
                                <textarea name="cAddress" id="cAddress" rows="4" cols="4" class="form-control"><?php echo $company[0]->address; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>County: </label>
                                <select id="cCountry" name="cCountry" class="form-control select-search"
                                        onchange="getPhoneCode();" data-fouc required>
                                    <option value="">--- Select Country ----</option>
                                    <?php foreach ($country as $row) {
                                        ?>
                                        <option value="<?php echo $row->id; ?>" <?php echo set_select('country', $row->id); if($company[0]->country == $row->id ){echo 'selected';} ?>  > <?php echo $row->country; ?> </option>
                                        <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phone : </label>
                                <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text" id="phoneCode"></span>
                                                </span>
                                    <input id="phone" name="phone" type="number" value="<?php echo $company[0]->phone; ?>"  class="form-control col-md-4" maxlength="10"  placeholder="0111234567">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>website : </label>
                                <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text" id="url">url</span>
                                                </span>
                                    <input id="web" name="web" type="text" value="<?php echo $company[0]->web; ?>"  class="form-control col-md-6" placeholder="www.example.com">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>E-Mail: <span class="text-danger">*</span></label>
                                <input type="email" name="email1" id="email1" value="<?php echo $company[0]->email; ?>" class="form-control col-md-6 required" placeholder="info@example.com">
                            </div>
                            <div class="form-group">
                                <label>Other E-Mail: <span class="text-danger">*</span></label>
                                <input type="email" name="email2" id="email2" value="<?php echo $company[0]->email2; ?>" class="form-control col-md-6 required" placeholder="other@example.com">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 text-right">
                            <button type="submit" value="update" name="update" class="btn bg-success-800 pull-right btn-flat"><i class="icon-pencil5"></i> Update Company</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>

    </div> <!--    close content-->

    <script>

        $(document).ready(function () {
            getPhoneCode();
        });

        function getPhoneCode() {

            var country = $('#cCountry').val();

            if(country != ''){
                $.ajax({
                    url: '<?php echo base_url("Company_Master_Con/getPhoneCode")?>',
                    type:'POST',
                    data:({
                        'countryId':country,
                    }),
                    success:function (data) {
                        if(data!=''){
                            $('#phoneCode').text(data);
                        }
                    }
                });
            }else{
                $('#phoneCode').text('');
            }


        }

    </script>
