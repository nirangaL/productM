
<!-- Footer -->
<!-- <div class="navbar navbar-expand-lg navbar-light">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2019. <a href="#">ProductM Web App Kit</a> by <a href="#" target="_blank">OAIT</a>
					</span>

        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
        </ul>
    </div>
</div> -->
<!-- /footer -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->
</body>


<div class="modal fade" data-backdrop="static"  id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger-400" >
                <h4 class="modal-title"><i class="icon-bin mr-1"></i>Delete</h4>
            </div>
            <div class="modal-body ">
                <center>   <p id="deleteMsg"></p></center>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <a id="deleteUrl" type="button" class="btn btn-danger">Yes</a>
                <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
//// Hide error for all pages /////
$('input,select').change(function () {
  $(this).next('#error').fadeOut();
});

$(function(){
  $(".se-pre-con").show();
});

$("body").prepend('<div class="loading"></div>');

$(document).ready(function() {
  $(".loading").remove();
});

// Single picker date picker
$('.daterange-single').daterangepicker({
  singleDatePicker: true,
});


// $(window).load(function() {
//     // Animate loader off screen
//     $(".se-pre-con").hide();
// });


//// Toastr Alert msg configuration /////
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-full-width",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "300",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
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

function deleteConfirm(deleteMsg,url) {
  $('#deleteMsg').text(deleteMsg);
  $('#deleteUrl').attr('href','<?php echo base_url(); ?>'+ url);
  $('#deleteModal').modal('show');
}

function loaderOn() {
  $("body").prepend('<div class="loading"></div>');
}

function loaderOff() {
  $(document).ready(function() {
    $(".loading").remove();
  });
}

</script>


</html>
