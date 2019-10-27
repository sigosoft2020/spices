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
                  <h4 class="page-title float-left">SETTINGS</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">

                  <form action="<?=site_url('admin/settings/change')?>" method="post">
                    <div class="row">
                      <!-- <div class="col-md-3">
                        <div class="form-group">
                          <label>Cancellation time<span style="font-size:12px;font-style:italic;">(In hours)</span></label>
                          <input type="number" min="0" max="24" name="hours" class="form-control" value="<?=$cancel->hours?>" required>
                        </div>
                      </div> -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Registration fee</label>
                          <input type="number" min="0" max="5000" class="form-control" name="fee" value="<?=$reg->fee?>" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div style="padding-top:30px;">
                          <button type="submit" class="btn btn-success">Update</button>
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
  <?php $this->load->view('admin/includes/table-script.php'); ?>
  <script type="text/javascript">
    $(document).ready(function(){
      var dataTable = $('#user_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url:"<?=site_url('admin/amenities/get')?>",
          type:"POST"
        },
        "columnDefs":[
          {
            "target":[0,3,4],
            "orderable":true
          }
        ]
      });
    });
  </script>
</html>
