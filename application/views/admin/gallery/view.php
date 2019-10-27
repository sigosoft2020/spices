<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('admin/includes/includes.php'); ?>
    <?php $this->load->view('admin/includes/table-css.php'); ?>
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
                  <h4 class="page-title float-left">GALLERY</h4>
                  <!-- <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Add amenity</button>
                  </ol> -->
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <div class="row">
                    <?php foreach ($images as $image) { ?>
                      <div class="col-md-4 mb-4">
                        <a href="#"><img id="image<?=$image->image_id?>" src="<?=base_url() . $image->image;?>" width="100%" onclick="show(this,<?=$image->image_id?>)"></a>
                      </div>
                    <?php } ?>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('admin/includes/footer.php'); ?>
    </div>
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Image preview</h4>
          </div>
          <div class="modal-body">
            <img src="" id="modal-image" class="img-fluid" width="100%">
          </div>
          <div class="modal-footer">
            <form action="<?=site_url('admin/gallery/delete')?>" method="post" id="delete-form" onsubmit="return deleteConfirm()">
              <input type="hidden" name="image_id" id="delete_id">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </body>
  <?php $this->load->view('admin/includes/scripts.php'); ?>
  <?php $this->load->view('admin/includes/table-script.php'); ?>
  <script type="text/javascript">
    function show(param,image_id)
    {
      $('#delete_id').val(image_id);
      var modalImg = document.getElementById("modal-image");
      modalImg.src = param.src;
      $('#imagemodal').modal('show');
    }
    function deleteConfirm()
    {
      if (confirm("Are you sure to delete this image?")) {
        return true;
      }
      else {
        return false;
      }
    }
  </script>
</html>
