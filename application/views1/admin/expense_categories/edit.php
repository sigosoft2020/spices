<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('admin/includes/includes.php'); ?>
    <?php $this->load->view('admin/includes/table-css.php'); ?>
    <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">
    <style media="screen">
    @media screen and (min-width: 975px) {
      .submit-button {
        padding-top: 50px;
      }
    }
    @media screen and (min-width: 1600px) {
      .submit-button {
        padding-top: 50px;
      }
    }
    @media screen and (min-width: 1900px) {
      .submit-button {
        padding-top: 50px;
      }
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
                  <h4 class="page-title float-left">EDIT EXPENSE CATEGORY</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/expenses/editCategory')?>" method="post">
                  <input type="hidden" name="cat_id" value="<?=$cat->cat_id?>">
                  <div class="form-row">
                      <div class="col-md-6">
                        <p class="mb-1 font-weight-bold">Name</p>
                        <p class="text-muted font-14">
                              (Add category name here , eg : Accessories);
                        </p>
                        <input type="text" name="cat_name" class="form-control" value="<?=$cat->cat_name?>" required>
                      </div>
                      <div class="col-md-6">
                        <p class="mb-1 font-weight-bold">Status</p>
                        <p class="text-muted font-14">
                              Activate or deactivate expense category.
                        </p>
                        <select class="form-control" name="status">
                          <option value="1" <?php if($cat->status){?>selected<?php } ?>>Active</option>
                          <option value="0" <?php if(!$cat->status){?>selected<?php } ?>>Blocked</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-row d-flex align-items-end">

                      <div class="col-md-8">
                        <p class="mb-1 mt-3 font-weight-bold">Description</p>
                        <p class="text-muted font-14">
                              Add description of the category here
                        </p>
                        <textarea name="cat_description" class="form-control" rows="3" cols="80"><?=$cat->cat_description?></textarea>
                      </div>
                      <div class="col-md-4">
                        <div class="submit-button" style="padding-top:20px;">
                          <button type="submit" class="btn btn-success btn-rounded waves-light waves-effect w-md pull-right">Edit</button>
                        </div>
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
  </script>
</html>
