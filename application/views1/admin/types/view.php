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
                  <h4 class="page-title float-left">TURF TYPES</h4>
                  <!-- <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Add amenity</button>
                  </ol> -->
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
             <div class="col-xl-10 center-page">
                 <div class="text-center">
                     <h4 class="mt-3">Pitches</h4>
                     <p>
                        We have 3 types of pitches , 11 x 11 , 7 x 7 and 5 x 5. 11 x 11 pitch can be devided into two 7 x 7 and four
                        5 x 5. If someone book 11 x 11 then 7 x 7 and 5 x 5 will not be available.<br>
                        And there are some other conditions too<br>
                        1 . If someone choose 7 x 7 then 11 x 11 will be blocked and two 5 x 5 and one 7 x 7 will be available<br>
                        2 . If someone choose 5 x 5 then three 5 x 5 or one 7 x 7 will be available.
                     </p>
                 </div>

                 <div class="row m-t-50">
                   <?php foreach ($types as $pitch) { ?>
                     <article class="pricing-column col-md-4">
                         <div class="inner-box card-box">
                             <div class="plan-header text-center">
                                 <h3 class="plan-title"></h3>
                                 <h2 class="plan-price"><?=$pitch->pitch?></h2>
                                 <div class="plan-duration"></div>
                             </div>
                         </div>
                     </article>
                   <?php } ?>
                 </div>
             </div><!-- end col -->
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
