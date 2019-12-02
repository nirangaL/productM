<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Style Size Wise
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
                    <span class="breadcrumb-item active">Style Size Wise</span>
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
               <form action="<?php echo base_url('report/StyleSizeWise_con/getTableData')?>" method="post">
                   <div class="row">
                       <label class="col-form-label col-lg-1">Style : </label>
                       <div class="col-lg-2">
                           <select id="style" name="style" class="form-control select-search select2" data-fouc=""
                                   tabindex="-1" onchange="getDelivery(this);" required>
                               <option value="">-- Select a Style --</option>
                               <?php
                               if (!empty($style)) {
                                   foreach ($style as $row) {
                                       ?>
                                       <option value="<?php echo $row->style; ?>" <?php if($row->style==$selectStyle){echo 'Selected';}?> > <?php echo $row->style . ' - ' . $row->scNumber ?></option>
                                       <?php
                                   }
                               }
                               ?>
                           </select>
                       </div>

                       <label class="col-form-label col-lg-1">Delivery : </label>
                       <div class="col-lg-2">
                           <select id="delivery" name="delivery" class="form-control select-search select2" data-fouc="" tabindex="-1"
                                   onchange="getTeam(this);">
                               <option value="">-- Select a Delivery --</option>
                           </select>
                       </div>

                       <label class="col-form-label col-lg-1">Team : </label>
                       <div class="col-lg-2">
                           <select id="team" name="team" class="form-control select-search select2" data-fouc="" tabindex="-1">
                               <option value="">-- Select a Team --</option>

                           </select>
                       </div>

                       <div class="col-lg-3">
                           <div class="text-right">
                               <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i>
                               </button>
                           </div>
                       </div>
                   </div>
               </form>

            </div>

            <table id="StyleSizeWiseTable" class="table dataTable ">
                <thead>
                <tr>
                    <th>Style</th>
                    <th>Delivery</th>
                    <th>Order Qty</th>
                    <th>Actual Qty</th>
                    <th>Size</th>
                    <th>Order Size Qty</th>
                    <th>Actual Size Qty</th>
                    <th>Location</th>
                    <th>Team</th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (!empty($tableData)) {
                    $styleTd = '';
                    $delivery = '';
                    $orderQty = '';

                    $actualQty = 0;

                    foreach ($tableData as $row){
                        if ($row->delivery != $delivery) {
                            $actualQty += (int)$row->passQty;
                        }
                    }

                    foreach ($tableData as $row) {
                        //// Style td ///
                        ?>
                        <tr>
                            <?php
                            if ($row->style != $styleTd) {
                                $delivery ='';
                                $styleTd = $row->style;
                                ?>

                                <td><?php echo $row->style; ?></td>

                                <?php

                            } else {///style
                                ?>
                                <td></td>
                                <?php
                            }

                            if ($row->delivery != $delivery  ) {
                                $orderQty ='';
                                $delivery = $row->delivery;
                                ?>

                                <td><?php echo $row->delivery; ?></td>

                                <?php

                            } else { /// delivery
                                ?>
                                <td></td>
                                <?php
                            }

                            if ($row->orderQty != $orderQty) {
                                $orderQty = $row->orderQty;
                                ?>

                                <td><?php echo $row->orderQty; ?></td>
                                <td><?php echo $actualQty; ?></td>

                                <?php
                            } else { /// order Qty
                                ?>
                                <td></td>
                                <td></td>

                                <?php
                            }


                            ?>
                            <td><?php echo $row->defineSize; ?></td>
                            <td><?php echo $row->orderSizeQty; ?></td>
                            <td><?php echo $row->passQty; ?></td>
                            <td><?php echo $row->location; ?></td>
                            <td><?php echo $row->lineName; ?></td>
                        </tr>
                        <?php

                    }/// Foreach

                } else { ///If tableData
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                }

                ?>

                </tbody>
            </table>
        </div>
    </div>


    <script>


        $(document).ready(function () {

            $('#StyleSizeWiseTable').DataTable({
                retrieve: true,
                "paging":   false,
                "ordering": false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Style Size Wise Report'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Style Size Wise Report'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Style Size Wise Report'
                    }, {
                        extend: 'print',
                        title: 'Style Size Wise Report'
                    }
                ]
            });


            var style = $('#style').val();
            var delivery = $('#delivery').val();

            if(style != ''){
                getDelivery($('#style'));
                if(delivery !=' '){
                    getTeam($('#delivery'));
                }
            }

        });




    function getDelivery(style) {
        var style = $(style).val();

        if(style != ''){
            $.ajax({
                url: '<?php echo base_url("report/StyleSizeWise_con/getDelivery")?>', //This is the current doc
                type: "POST",
                data: ({
                    style: style,
                }),
                success: function (data) {
                    var html =  "<option value='all' <?php if($selectDelivery == 'all'){echo 'selected';}?> >All</option>";
                    var json_value = JSON.parse(data);
                    for (var i = 0; i < json_value.length; i++) {
                        var isSelect = '';

                        if(json_value[i]['deliverNo'] =='<?php echo $selectDelivery;?>'){
                            isSelect =  'Selected';
                        }

                        html += "<option value='" + json_value[i]['deliverNo'] + "' "+ isSelect +">" + json_value[i]['deliverNo'] + "</option>";
                    }
                    $('#delivery').empty().append(html);

                    if(  $('#delivery').val()!='all'){
                        getTeam( $('#delivery'));
                    }


                }
            });
        }else{
            var html =  "<option value='' >-- Select a Delivery --</option>";
            $('#delivery').empty().append(html);
            var html =  "<option value='' >-- Select a Team --</option>";
            $('#team').empty().append(html);
        }
    }


    function getTeam(delivery) {

        var delivery = $(delivery).val();

        if(delivery != ''){
            delivery = $('#delivery').val();
        }

        var style = $('#style').val();


        if(style != '' && delivery !=''){
            var html = "<option value='all' <?php if($selectTeam == 'all'){echo 'selected';}?> >All</option>";
            $.ajax({
                url: '<?php echo base_url("report/StyleSizeWise_con/getTeam")?>', //This is the current doc
                type: "POST",
                data: ({
                    style: style,
                    delivery: delivery,
                }),
                success: function (data) {
                    var html = "<option value='all' >All</option>";
                    var json_value = JSON.parse(data);
                    for (var i = 0; i < json_value.length; i++) {

                        var isSelect = '';

                        if(json_value[i]['line_id'] =='<?php echo $selectTeam;?>'){
                            isSelect =  'Selected';
                        }

                        html += "<option value='" + json_value[i]['line_id'] + "' "+ isSelect +"  >" +json_value[i]['location'] +' - '+ json_value[i]['line'] + "</option>";
                    }
                    $('#team').empty().append(html);
                }
            });

        }else{
            var html =  "<option value='' >-- Select a Team --</option>";
            $('#team').empty().append(html);
        }
    }



    </script>