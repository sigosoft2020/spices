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
                  <h4 class="page-title float-left"><?=$turf->turf_name?></h4>
                  <!-- <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Add amenity</button>
                  </ol> -->
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="card-box">
                  <h4 class="header-title m-t-0 m-b-30">Amenities</h4>
                  <table class="table table-borderless">
                      <tbody>
                        <?php foreach ($amenities as $amenity) { ?>
                          <tr>
                            <td><img src="<?=base_url() . $amenity->image?>" height="70px"></td>
                            <td><?=$amenity->amenity?></td>
                          </tr>
                        <?php } ?>
                    </tbody>
                  </table>
              </div>
              <div class="card-box">
                  <h4 class="header-title m-t-0 m-b-30">Slider images</h4>
                  <table class="table table-borderless">
                      <tbody>
                        <?php foreach ($images as $image) { ?>
                          <tr>
                            <td><img src="<?=base_url() . $image->image?>" width="100%"></td>
                          </tr>
                        <?php } ?>
                    </tbody>
                  </table>
              </div>
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Turf details</h4>
                    <img src="<?=base_url() . $turf->cover_image?>" width="100px">
                    <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>Name</td>
                            <td><?=$turf->turf_name?></td>
                          </tr>
                          <tr>
                            <td>Place</td>
                            <td><?=$turf->place?></td>
                          </tr>
                          <tr>
                            <td>Latitude</td>
                            <td><?=$turf->lat?></td>
                          </tr>
                          <tr>
                            <td>Longitude</td>
                            <td><?=$turf->lon?></td>
                          </tr>
                          <tr>
                            <td>Status</td>
                            <td><?php if($turf->status == 'a'){ echo "Active"; }else{ echo "Blocked"; }?></td>
                          </tr>
                      </tbody>
                    </table>
                </div>
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Owner details</h4>

                    <img src="<?=base_url() . $owner->image?>" width="100px">
                    <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>Name</td>
                            <td><?=$owner->username?></td>
                          </tr>
                          <tr>
                            <td>Mobile</td>
                            <td><?=$owner->mobile?></td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td><?=$owner->email?></td>
                          </tr>
                      </tbody>
                    </table>
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
</html>
