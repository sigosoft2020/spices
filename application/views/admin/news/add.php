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
                  <h4 class="page-title float-left">ADD NEWS</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/news/addNews')?>" method="post" id="add-form">

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Title <span style="color:red">*</span></label>
                        <input type="text" maxlength="200" placeholder="Enter title here" name="title" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Location <span style="color:red">*</span></label>
                        <input type="text" maxlength="100" placeholder="Enter location here" name="location" id="location" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Description <span style="color:red">*</span></label>
                        <textarea name="description" placeholder="Enter news here" class="form-control" rows="5" cols="80"></textarea>
                      </div>
                    </div>

                    <div class="col-md-6">
                        <label>Choose image</label>
                        <input type="file" class="form-control" id="upload" required>
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
                      <button type="submit" class="btn btn-success waves-light waves-effect w-md pull-right" id="submit-button" style="display:none;">Add</button>
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

  </script>
</html>
