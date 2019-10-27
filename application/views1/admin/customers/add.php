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
                  <h4 class="page-title float-left">ADD CUSTOMER</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/customers/addCustomer')?>" method="post" id="add-form">


                  <div class="row">
                      <div class="col-md-8">
                          <div class="">
                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Username <span style="color:red">*</span></p>
                                  <p class="text-muted font-14">
                                        (Enter customer name here , eg: John samuel)
                                  </p>
                                  <input type="text" maxlength="50" name="username" class="form-control" required>
                              </div>
                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Mobile <span style="color:red">*</span></p>
                                  <p class="text-muted font-14">
                                        (Mobile number must contain 10 digits)
                                  </p>
                                  <input type="text" maxlength="10" name="mobile" id="mo" class="form-control" required>
                                  <p id="mobile_error" style="display:none;color:red">Invalid mobile number</p>
                              </div>
                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Email address <span style="color:red">*</span></p>
                                  <p class="text-muted font-14">
                                        (Format : someone@domain.com)
                                  </p>
                                  <input type="email" maxlength="100" name="email" id="em" class="form-control" required>
                                  <p id="email_error" style="display:none;color:red">Invalid mobile number</p>
                              </div>

                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Image</p>
                                  <p class="text-muted font-14">
                                        (If you wish to change the image of amenity change it here , else leave this field empty)
                                  </p>
                                  <input type="file" class="form-control" id="upload">
                                  <!-- <input class="sample_input" type="hidden" name="test[image]"> -->
                              </div>

                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Password <span style="color:red">*</span></p>
                                  <p class="text-muted font-14">
                                        (Default password will be wooslot , password must contains 6 to 12 characters)
                                  </p>
                                  <input type="text" pattern=".{6,12}" class="form-control" value="wooslot" id="password" required>
                                  <!-- <input class="sample_input" type="hidden" name="test[image]"> -->
                              </div>

                          </div>
                      </div>

                      <div class="col-md-4">
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
                        <button type="submit" class="btn btn-success btn-rounded waves-light waves-effect w-md pull-right" id="submit-button" style="display:block;">Add</button>
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
    var flag = true;
    var email = $('#em').val();
    var mobile = $('#mo').val();

    if (isNaN(mobile) || mobile.length != 10) {
      $("#mobile_error").css("display", "none");
      $("#email_error").css("display", "none");
      if (isNaN(mobile)) {
        $("#mobile_error").text("Invalid Mobile number");
        $("#mobile_error").css("display", "block");
      }
      if (mobile.length != 10) {
        $("#mobile_error").text("Mobile number must contain 10 digits");
        $("#mobile_error").css("display", "block");
      }
    }
    else {
      $("#mobile_error").css("display", "none");
      $("#email_error").css("display", "none");
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('admin/customers/validation');?>",
          dataType : "json",
          data : { mobile : mobile , email : email },
          success : function( data ){

            if (data.mobile) {
              $("#mobile_error").text("Mobile number already registered..!");
              $("#mobile_error").css("display", "block");
              flag = false;
            }

            if (data.email) {
              $("#email_error").text("Email address already registered..!");
              $("#email_error").css("display", "block");
              flag = false;
            }
            if (flag) {
              document.getElementById("add-form").submit();
            }
          }
        });
    }
  });
  </script>
</html>
