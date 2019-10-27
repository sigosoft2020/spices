<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('admin/includes/includes.php'); ?>
    <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/datetime/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/datetime/bootstrap-datetimepicker3.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?=base_url()?>assets/css/vendor/bootstrap-datepicker3.min.css" />

    <!-- <link href="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?=base_url()?>plugins/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet"> -->
    <style type="text/css">
      .bootstrap-datetimepicker-widget tr:hover {
       background-color: #808080;
     }
    </style>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('admin/includes/sidebar.php'); ?>
      <div class="content-page">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title float-left">ADD EVENT</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/events/addEvent')?>" method="post" id="add-form">


                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Event name <span style="color:red">*</span></label>
                        <input type="text" maxlength="100" placeholder="Enter event name here" name="ev_name" id="ev_name" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Location <span style="color:red">*</span></label>
                        <input type="text" maxlength="100" placeholder="Enter event location here" name="location" id="location" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Event description <span style="color:red">*</span></label>
                        <textarea name="ev_description" placeholder="Enter event description here" class="form-control" rows="3" cols="80"></textarea>
                      </div>
                    </div>
                    <div class="col-md-6 form-group">
                      <div class="form-group">
                        <label>Start date</label>
                        <input type="date" class="form-control" id="datepicker3" name="start_date" value="<?=date('Y-m-d')?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>End date</label>
                        <input class="form-control" id="datepicker4" name="end_date" value="<?=date('Y-m-d')?>" readonly>
                      </div>
                    </div>
                    <!-- <div class="col-md-6">
                      <div class="form-group">
                          <label>Event start time : <span style="font-style:italic;font-size:13px;">(Click on the field to select time)</span></label>
                          <div class="input-group">
                              <input id="timepicker" type="text" name="from" class="form-control" readonly>
                          </div>
                      </div>
                    </div> -->
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker'>
                                <input type='text' class="form-control" />
                                <div class="input-group-append input-group-addon">
                                    <span class="input-group-text"><i class="mdi mdi-clock"></i></span>
                                </div>
                                <!-- <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Choose event image</label>
                        <input type="file" class="form-control" id="upload">
                    </div>
                    <div class="col-md-12">
                      <div class="upload-div" style="display:none;">
                        <div id="upload-demo"></div>
                        <div class="col-12 text-center">
                          <a href="#" class="btn btn-primary btn-flat" style="border-radius : 5px;" id="crop-button">Crop</a>
                        </div>
                      </div>

                      <div class="upload-result text-center" id="upload-result" style="display : none; margin-bottom:10px;">

                      </div>
                      <input type="hidden" name="image" id="ameimg" >
                    </div>
                    <div class="col-md-12 mt-4">
                      <button type="submit" class="btn btn-success waves-light waves-effect w-md pull-right" id="submit-button" style="display:block;">Add</button>
                    </div>
                  </div>


                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('admin/includes/footer.php'); ?>
    </div>
  </body>
  <!-- <?php $this->load->view('admin/includes/scripts.php'); ?> -->
  <script src="<?=base_url()?>assets/datetime/jquery.min.js"></script>

  <!-- <script src="<?=base_url()?>assets/js/jquery.min.js"></script> -->
  <script src="<?=base_url()?>assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>assets/js/metisMenu.min.js"></script>
  <script src="<?=base_url()?>assets/js/waves.js"></script>
  <script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>
  <script src="<?=base_url()?>assets/js/jquery.core.js"></script>
  <script src="<?=base_url()?>assets/js/jquery.app.js"></script>

  <script src="<?=base_url()?>assets/datetime/moment.min.js"></script>
  <script src="<?=base_url()?>assets/datetime/bootstrap-datetimepicker.min.js"></script>
  <script src="<?=base_url()?>assets/js/vendor/mousetrap.min.js"></script>

  <script src="<?=base_url()?>assets/js/vendor/moment.min.js"></script>
  <script src="<?=base_url()?>assets/js/vendor/fullcalendar.min.js"></script>
  <script src="<?=base_url()?>assets/js/vendor/bootstrap-datepicker.js"></script>
  <script src="<?=base_url()?>plugins/image-crop/croppie.js"></script>

  <!-- <script src="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
  <script src="<?=base_url()?>plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
  <script src="<?=base_url()?>assets/pages/jquery.form-pickers.init.js"></script> -->

  <script type="text/javascript">
  $uploadCrop = $('#upload-demo').croppie({
      enableExif: true,
      viewport: {
          width: 800,
          height: 700,
          type: 'rectangle'
      },
      boundary: {
          width: 900,
          height: 900
      }
  });


  $('#upload').on('change', function () {
    $("#submit-button").css("display", "none");
    var file = $("#upload")[0].files[0];
    var val = file.type;
    var type = val.substr(val.indexOf("/") + 1);
    if (type == 'png' || type == 'jpg' || type == 'jpeg') {
      $(".upload-div").css("display", "block");
      $("#submit-button").css("display", "none");
      var reader = new FileReader();
        reader.onload = function (e) {
          $uploadCrop.croppie('bind', {
            url: e.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });

        }
        reader.readAsDataURL(this.files[0]);
    }
    else {
      alert('This file format is not supported.');
      document.getElementById("upload").value = "";
      $("#upload-result").css("display", "none");
      $("#submit-button").css("display", "none");
    }
  });


  $('#crop-button').on('click', function (ev) {
      $("#submit-button").css("display", "block");
    $uploadCrop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function (resp) {
      html = '<img src="' + resp + '" />';
      $("#upload-result").html(html);
      $("#upload-result").css("display", "block");
      $(".upload-div").css("display", "none");
      $("#submit-button").css("display", "block");
      $('#ameimg').val(resp);
    });
  });

  $('#add-form').on('submit', function(e){
    e.preventDefault();
    var start_date = $('#datepicker3').val();
    var end_date = $('#datepicker4').val();

    // var d1 = new Date();
    // d1.setHours(0,0,0,0);
    //
    // var d2 = new Date(start_date);
    //
    // if (d1 <= d2) {
    //   alert('ok');
    // }
    // else {
    //   alert('failed');
    // }

    //alert(d1.getTime());

  });
  </script>
  <script type="text/javascript">


$(document).ready(function(){

  $("#datepicker2").datepicker( {
    format: "mm-yyyy",
    viewMode: "months",
    minViewMode: "months"
  });

  $('#datetimepicker').datetimepicker({
      format: 'LT'
  });

  $("#datepicker1").datepicker( {
    format: "yyyy-mm-dd"
  });

  $("#datepicker3").datepicker( {
    format: "yyyy-mm-dd"
  });

  $("#datepicker4").datepicker( {
    format: "yyyy-mm-dd"
  });

   //Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
   $("#weeklyDatePicker").datetimepicker({
       format: 'YYYY-MM-DD'
   });

    //Get the value of Start and End of Week
   $('#weeklyDatePicker').on('dp.change', function (e) {
       var value = $("#weeklyDatePicker").val();
       var firstDate = moment(value, "YYYY-MM-DD").day(0).format("YYYY-MM-DD");
       var lastDate =  moment(value, "YYYY-MM-DD").day(6).format("YYYY-MM-DD");


       $("#weeklyDatePicker").val(firstDate);
       $("#date2").val(lastDate);
   });
  });
  </script>
</html>
