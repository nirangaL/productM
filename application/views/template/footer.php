
<!-- Footer -->
<div class="navbar navbar-expand-lg navbar-light">
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
</div>
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

$("body").prepend('<div class="loading"></div>');

// $(document).ready(function() {
//   $(".loading").remove();
// });

    $(document).ready(function() {
        $(".loading").fadeOut();
        $("form").on("submit", function(){
        $(".loading").fadeIn();
        })

      setInterval(function(){ $('.ci-flash-alert').fadeOut(); }, 3000);

        ////// Snow fallen effect ////
        // $('body').flurry({
        //     character: "❄",
        //     color: "white",
        //     frequency: 100,
        //     speed: 5000,
        //     small: 4,
        //     large: 14,
        //     wind: 40,
        //     windVariance: 20,
        //     rotation: 90,
        //     rotationVariance: 180,
        //     startOpacity: 1,
        //     endOpacity: 0,
        //     opacityEasing: "cubic-bezier(1,.3,.6,.74)",
        //     blur: true,
        //     overflow: "hidden",
        //     zIndex: 9999
        //     });



        
    });

    //// Hide error for all pages /////
    $('input,select').change(function () {
        $(this).next('#error').fadeOut();
    });

    // Basic datatable
    $('.datatable-basic').DataTable();



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

    $(".content").prepend('<div class="loading"></div>');

    //// input validaton is number ///
    function isNumber(evt){
      var e = evt || window.event;
      var key = e.keyCode || e.which;

      if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
          // numbers
          key >= 48 && key <= 57 ||
          // Numeric keypad
          key >= 96 && key <= 105 ||
          // Backspace and Tab and Enter
          key == 8 || key == 9 || key == 13 ||
          // Home and End
          key == 35 || key == 36 ||
          // left and right arrows
          key == 37 || key == 39 ||
          // Del and Ins
          key == 46 || key == 45) {
          // input is VALID
      }
      else {
          // input is INVALID
          e.returnValue = false;
          if (e.preventDefault) e.preventDefault();
      }
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
