<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('admin/includes/includes.php'); ?>
    <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">
    <link rel="stylesheet" href="<?=base_url()?>plugins/datepicker/datepicker.css">
    <link rel="stylesheet" href="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.min.css">
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
                  <h4 class="page-title float-left">ADD EXPENSE</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/expenses/addExpense')?>" method="post">

                  <div class="form-row">
                      <div class="col-md-6">
                        <p class="mb-1 font-weight-bold">Expense</p>
                        <p class="text-muted font-14">
                              (Add expense here , eg : 250);
                        </p>
                        <input type="number" step="any" name="expense" class="form-control" required>
                      </div>
                      <div class="col-md-6">
                        <p class="mb-1 font-weight-bold">Expense category</p>
                        <p class="text-muted font-14">
                              Select expense category.
                        </p>
                        <select class="form-control" name="cat_id" required>
                          <option value="">--- Select expense category ---</option>
                          <?php foreach ($categories as $cat) { ?>
                            <option value="<?=$cat->cat_id?>"><?=$cat->cat_name?></option>
                          <?php } ?>
                        </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="col-md-12">
                        <p class="mb-1 mt-2 font-weight-bold">Notes</p>
                        <p class="text-muted font-14">
                              (Add expense here , eg : 250);
                        </p>
                        <textarea class="form-control" name="notes" rows="4" cols="80" required></textarea>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="col-md-6">
                        <p class="mb-1 mt-2 font-weight-bold">Date</p>
                        <p class="text-muted font-14">
                              (Add date of expense);
                        </p>
                        <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                            <input class="form-control" type="text" name="date" readonly />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <p class="mb-1 mt-2 font-weight-bold">Time</p>
                        <p class="text-muted font-14">
                              (Add time of expense)
                        </p>
                        <input type="text" id="timepicker" step="any" name="time" class="form-control" required>
                      </div>
                  </div>

                  <div class="form-row">
                    <div class="col-md-12 mt-4">
                      <button type="submit" class="btn btn-success btn-rounded waves-light waves-effect w-md pull-right">Add</button>
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
  <script src="<?=base_url()?>plugins/datepicker/datepicker.js"></script>
  <script src="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
  <script src="<?=base_url()?>assets/pages/jquery.form-pickers.init.js"></script>

  <script type="text/javascript">
    $("#datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true
    }).datepicker('update', new Date());
  </script>
</html>
