

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Team Working Time</span> - Add
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
                    <a href="<?php echo base_url('Workstudy_con')?>" class="breadcrumb-item">Team Time List</a>
                    <span class="breadcrumb-item active">Add Team Time </span>
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
                <h5 class="card-title">Team Time Form</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>



            <div class="card-body">
                <form action="<?php echo base_url('Team_time_con/editTeamTime/').$teamTime[0]['id']?>" method="post">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">Team :</label>
                            <div class="col-lg-3">
                                <select id="line" name="line" class="form-control select-search"data-fouc disabled >
                                    <option value="" >--- Select Line ----</option>
                                    <?php foreach ($prdocLine as $row){
                                        ?>
                                        <option value="<?php echo $row->line_id;?>" <?php if($teamTime[0]['lineId']==$row->line_id){ echo 'selected';}else{ echo set_select('line', $row->line_id);} ?>  > <?php echo $row->line;?> </option>
                                        <?php
                                    }?>
                                </select>
                                <span class="error" id="error"><?php echo form_error('line'); ?></span>
                            </div>
                            <div class="col-lg-8">
                                <span class="error" id="errorLineRunnig"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">1<sup>st</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="1hStart" name="1hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('1hStart'))){echo set_value('1hStart'); }else{ echo $teamTime[0]['1hStart'];} ; ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('1hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="1hEnd" name="1hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('1hEnd'))){echo set_value('1hEnd'); }else{ echo $teamTime[0]['1hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('1hEnd'); ?></span>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-form-label col-lg-1">2<sup>nd</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="2hStart" name="2hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('2hStart'))){echo set_value('2hStart'); }else{ echo $teamTime[0]['2hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('2hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="2hEnd" name="2hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('2hEnd'))){echo set_value('2hEnd'); }else{ echo $teamTime[0]['2hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('2hEnd'); ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">3<sup>rd</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="3hStart" name="3hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('3hStart'))){echo set_value('3hStart'); }else{ echo $teamTime[0]['3hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('3hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="3hEnd" name="3hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('3hEnd'))){echo set_value('3hEnd'); }else{ echo $teamTime[0]['3hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('3hEnd'); ?></span>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-form-label col-lg-1">4<sup>tht</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="4hStart" name="4hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('4hStart'))){echo set_value('4hStart'); }else{ echo $teamTime[0]['4hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('4hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="4hEnd" name="4hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('4hEnd'))){echo set_value('4hEnd'); }else{ echo $teamTime[0]['4hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('4hEnd'); ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">5<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="5hStart" name="5hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('5hStart'))){echo set_value('5hStart'); }else{ echo $teamTime[0]['5hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('5hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="5hEnd" name="5hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('5hEnd'))){echo set_value('5hEnd'); }else{ echo $teamTime[0]['5hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('5hEnd'); ?></span>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-form-label col-lg-1">6<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="6hStart" name="6hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('6hStart'))){echo set_value('6hStart'); }else{ echo $teamTime[0]['6hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('6hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="6hEnd" name="6hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('6hEnd'))){echo set_value('6hEnd'); }else{ echo $teamTime[0]['6hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('6hEnd'); ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">7<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="7hStart" name="7hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('7hStart'))){echo set_value('7hStart'); }else{ echo $teamTime[0]['7hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('7hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="7hEnd" name="7hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('7hEnd'))){echo set_value('7hEnd'); }else{ echo $teamTime[0]['7hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('7hEnd'); ?></span>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-form-label col-lg-1">8<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="8hStart" name="8hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('8hStart'))){echo set_value('8hStart'); }else{ echo $teamTime[0]['8hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('8hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="8hEnd" name="8hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('8hEnd'))){echo set_value('8hEnd'); }else{ echo $teamTime[0]['8hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('8hEnd'); ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">9<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="9hStart" name="9hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('9hStart'))){echo set_value('9hStart'); }else{ echo $teamTime[0]['9hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('9hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="9hEnd" name="9hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('9hEnd'))){echo set_value('9hEnd'); }else{ echo $teamTime[0]['9hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('9hEnd'); ?></span>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-form-label col-lg-1">10<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="10hStart" name="10hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('10hStart'))){echo set_value('10hStart'); }else{ echo $teamTime[0]['10hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('10hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="10hEnd" name="10hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('10hEnd'))){echo set_value('10hEnd'); }else{ echo $teamTime[0]['10hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('10hEnd'); ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">11<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="11hStart" name="11hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('11hStart'))){echo set_value('11hStart'); }else{ echo $teamTime[0]['11hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('11hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="11hEnd" name="11hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('11hEnd'))){echo set_value('11hEnd'); }else{ echo $teamTime[0]['11hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('11hEnd'); ?></span>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-form-label col-lg-1">12<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="12hStart" name="12hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('12hStart'))){echo set_value('12hStart'); }else{ echo $teamTime[0]['12hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('12hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="12hEnd" name="12hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('12hEnd'))){echo set_value('12hEnd'); }else{ echo $teamTime[0]['12hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('12hEnd'); ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">13<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="13hStart" name="13hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('13hStart'))){echo set_value('13hStart'); }else{ echo $teamTime[0]['13hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('13hStart'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="13hEnd" name="13hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('13hEnd'))){echo set_value('13hEnd'); }else{ echo $teamTime[0]['13hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('13hEnd'); ?></span>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-form-label col-lg-1">14<sup>th</sup> Hours :</label>
                            <div class="col-lg-2">
                                <input id="14hStart" name="14hStart" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('14hStart'))){echo set_value('14hStart'); }else{ echo $teamTime[0]['14hStart'];} ;  ?>" placeholder="Start Time">
                                <span class="error" id="error"><?php echo form_error('14Start'); ?></span>
                            </div>
                            <div class="col-lg-2">
                                <input id="14hEnd" name="14hEnd" type="text"  class="form-control timepicker" value="<?php if(!empty(set_value('14hEnd'))){echo set_value('14hEnd'); }else{ echo $teamTime[0]['14hEnd'];} ;  ?>" placeholder="End Time">
                                <span class="error" id="error"><?php echo form_error('14hEnd'); ?></span>
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="submit" id="update" name="update" class="btn bg-purple-400 ">Update<i class="icon-pencil7 ml-2"></i> </button>
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
            $('.timepicker').timepicker({
                timeFormat: 'H:mm',
                interval: 5,
                minTime: '00',
                maxTime: '23:55pm',
                dynamic: true,
                dropdown: true,
                scrollbar: true
            });
        });

            // $('.timepicker').val('');
            // $('.timepicker').attr('Disabled','Disabled')

        $('#line').change(function () {
            if($(this).val()!=''){
                $('.timepicker').removeAttr('Disabled','Disabled');
            }else{
                $('.timepicker').attr('Disabled','Disabled');
                $('.timepicker').val('');
            }

        });

    </script>