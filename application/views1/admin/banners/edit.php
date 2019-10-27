<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('admin/includes/includes.php'); ?>
    <?php $this->load->view('admin/includes/table-css.php'); ?>
    <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">
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
                  <h4 class="page-title float-left">EDIT AMENITY</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/amenities/editAmenity')?>" method="post">

                  <input type="hidden" name="amenity_id" value="<?=$amenity->amenity_id?>">
                  <div class="row">
                      <div class="col-md-8">
                          <div class="">
                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Name</p>
                                  <p class="text-muted font-14">
                                        (Change turf amenity name here , eg : Parking);
                                  </p>
                                  <input type="text" maxlength="25" name="name" class="form-control" value="<?=$amenity->amenity?>" required>
                              </div>

                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Image</p>
                                  <p class="text-muted font-14">
                                        (If you wish to change the image of amenity change it here , else leave this field empty);
                                  </p>
                                  <input type="file" class="form-control" id="upload">
                                  <!-- <input class="sample_input" type="hidden" name="test[image]"> -->
                              </div>

                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Status</p>
                                  <p class="text-muted font-14">
                                        (Activate or deactivate this amenity , if you deactivate this amenity it will not display in the android/ios app..!);
                                  </p>
                                  <select class="form-control" name="status">
                                    <option value="1" <?php if($amenity->status){?>selected<?php } ?>>Active</option>
                                    <option value="0" <?php if(!$amenity->status){?>selected<?php } ?>>Blocked</option>
                                  </select>
                                  <!-- <input class="sample_input" type="hidden" name="test[image]"> -->
                              </div>

                          </div>
                      </div>

                      <div class="col-md-4">
                        <div id="current-image">
                          <img src="<?=base_url() . $amenity->image?>" height="192px" width="192px">
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
                        <button type="submit" class="btn btn-success btn-rounded waves-light waves-effect w-md pull-right" id="submit-button" style="display:block;">Update</button>
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
  <!-- <script src="<?=base_url()?>plugins/crop/jquery.min.js"></script>
  <script src="<?=base_url()?>plugins/crop/bootstrap.min.js"></script>
  <script src="<?=base_url()?>plugins/crop/jquery.imgareaselect.js"></script>
  <script src="<?=base_url()?>plugins/crop/jquery.awesome-cropper.js"></script> -->

  <script type="text/javascript">
  $uploadCrop = $('#upload-demo').croppie({
      enableExif: true,
      viewport: {
          width: 192,
          height: 192,
          type: 'rectangle'
      },
      boundary: {
          width: 300,
          height: 300
      }
  });


  $('#upload').on('change', function () {
    $("#submit-button").css("display", "none");
    var file = $("#upload")[0].files[0];
    var val = file.type;
    var type = val.substr(val.indexOf("/") + 1);
    if (type == 'png' || type == 'jpg' || type == 'jpeg') {

      $("#current-image").css("display", "none");
      $("#submit-button").css("display", "none");

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
      $("#current-image").css("display", "block");
      $('#ameimg').val('');
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
