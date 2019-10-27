<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('admin/includes/includes.php'); ?>
    <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">

    <link href="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?=base_url()?>plugins/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
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
                  <h4 class="page-title float-left">EDIT EVENT</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/events/editEvent')?>" method="post" id="add-form">

                  <input type="hidden" name="ev_id" id="ev_id" value="<?=$event->ev_id?>">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Event name <span style="color:red">*</span></label>
                        <input type="text" maxlength="100" placeholder="Enter event name here" name="ev_name" id="ev_name" value="<?=$event->ev_name?>" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Location <span style="color:red">*</span></label>
                        <input type="text" maxlength="100" placeholder="Enter event location here" name="location" id="location" value="<?=$event->location?>" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Event description <span style="color:red">*</span></label>
                        <textarea name="ev_description" placeholder="Enter event description here" class="form-control" rows="3" cols="80"><?=$event->ev_description?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6 form-group">
                      <div class="form-group">
                        <label>Start date</label>
                        <input type="date" class="form-control" id="datepicker3" name="start_date" value="<?=$event->start_date?>">
                        <p id="start-date-error" style="color:red;"></p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>End date</label>
                        <input type="date" class="form-control" id="datepicker4" name="end_date" value="<?=$event->end_date?>">
                        <p id="end-date-error" style="color:red;"></p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Event start time : <span style="font-style:italic;font-size:13px;">(Click on the field to select time)</span></label>
                          <div class="input-group">
                              <input id="timepicker" type="text" name="start_time" class="form-control" value="<?=$event->start_time?>" readonly>
                          </div>
                          <p id="start-time-error" style="color:red;"></p>
                      </div>
                    </div>

                    <div class="col-md-6">
                        <label>Choose event image</label>
                        <input type="file" class="form-control" id="upload">
                        <p style="font-style:italic;font-size:12px;">( If you wish to change the event image choose image or leave this field empty )</p>
                    </div>
                    <div class="col-md-12">
                      <div id="current-image">
                        <img src="<?=base_url() . $event->ev_image?>" width="100%">
                      </div>
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
                      <button type="submit" class="btn btn-success waves-light waves-effect w-md pull-right" id="submit-button" style="display:block;">Update</button>
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
  <?php $this->load->view('admin/includes/scripts.php'); ?>
  <script src="<?=base_url()?>plugins/image-crop/croppie.js"></script>

  <script src="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
  <script src="<?=base_url()?>assets/pages/jquery.form-pickers.init.js"></script>

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
      $("#current-image").css("display", "none");
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
      $("#current-image").css("display", "block");
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
    $('#start-date-error').text('');
    $('#end-date-error').text('');
    $('#start-time-error').text('');

    var start_date = $('#datepicker3').val();
    var end_date = $('#datepicker4').val();

    var d1 = new Date();
    d1.setHours(0,0,0,0);

    var d2 = new Date(start_date + " 00:00:00");
    d1.setHours(0,0,0,0);

    // console.log(d1.getTime());
    // console.log(d2.getTime());
    //
    // console.log(d1);
    // console.log(d2);

    if (d1 <= d2) {
      var d3 = new Date(end_date);
      if (d3 < d2) {
        $('#end-date-error').text('End date cannot be lesser than start date');
      }
      else {
        var time = $('#timepicker').val();
        var time = changeFormat(time);

        var d = new Date(); // for now
        hour = d.getHours();
        min = d.getMinutes();
        sec = d.getSeconds();

        var now = hour + ":" + min + ":" + sec;

        var dummy_date = "01/01/2011 ";
        var time1 = dummy_date + time;
        var time2 = dummy_date + now;

        if (d1.getTime() == d2.getTime()) {
          if (Date.parse(time1) > Date.parse(time2)) {
            document.getElementById("add-form").submit();
          }
          else {
            $('#start-time-error').text('Please select a valid time');
          }
        }
        else {
          document.getElementById("add-form").submit();
        }
      }
    }
    else {
      $('#start-date-error').text('Start date cannot be lesser than todays date');
    }
  });

  function changeFormat(time)
  {
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = time.match(/\s(.*)$/)[1];
    if(AMPM == "PM" && hours<12) hours = hours+12;
    if(AMPM == "AM" && hours==12) hours = hours-12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if(hours<10) sHours = "0" + sHours;
    if(minutes<10) sMinutes = "0" + sMinutes;

    var time = sHours + ":" + sMinutes + ":00";

    return time;
    //alert(time);
  }

  function compareTime(time)
  {
    var d = new Date();
    var m = d.getMinutes();
    var h = d.getHours();
    if(h == '0') {h = 24}

    var currentTime = h+"."+m;
    console.log(currentTime);

    // get input time
    var time = element.split(":");
    var hour = time[0];
    if(hour == '00') {hour = 24}
    var min = time[1];

    var inputTime = hour+"."+min;
    console.log(inputTime);

    var totalTime = currentTime - inputTime;
    console.log(totalTime);

    if ((Math.abs(totalTime)) > 2) {
      //document.getElementById("check").innerHTML = "sufficient time";
      alert('time ok');
    }
    else {
      alert('time not ok');
    }
  }
  </script>
</html>
