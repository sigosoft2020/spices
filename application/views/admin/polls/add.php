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
                  <h4 class="page-title float-left">ADD POLL</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('admin/polls/addPoll')?>" method="post" id="add-form">

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Question <span style="color:red">*</span></label>
                        <input type="text" maxlength="150" placeholder="Enter poll question" name="question" id="question" class="form-control" required>
                      </div>
                    </div>

                    <div class="col-md-6 form-group">
                      <div class="form-group">
                        <label>Poll end date</label>
                        <input type="date" class="form-control" id="datepicker3" name="end_date" value="<?=date('Y-m-d')?>">
                        <p id="start-date-error" style="color:red;"></p>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Poll end time : <span style="font-style:italic;font-size:13px;">(Click on the field to select time)</span></label>
                          <div class="input-group">
                              <input id="timepicker" type="text" name="end_time" class="form-control" readonly>
                          </div>
                          <p id="start-time-error" style="color:red;"></p>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <h6>Add options</h6>
                      <div id="options-div">
                        <table id="options" width="100%">
                          <tr>
                            <td width="90%"><input type="text" class="form-control" name="options[]" required></td>
                            <td width="10%">-</td>
                          </tr>
                        </table>
                      </div>

                      <div class="text-center">
                        <button type="button" class="btn btn-link" onclick="addRow()"><i style="font-size:25px;" class="fa fa-plus-circle"></i></button>
                      </div>
                    </div>

                    <div class="col-md-12 mt-4">
                      <button type="submit" class="btn btn-success waves-light waves-effect w-md pull-right" id="submit-button" style="display:block;">Add</button>
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
    function addRow()
    {
      var col1 = "<tr><td><input type='text' class='form-control' name='options[]' required></td>";

      var col2 = "<td><a class='btn btn-link' onclick='deleteRow(this);'><i style='font-size:25px; color:red;' class='fa fa-minus-circle'></i></a></td></tr>";
      var row = col1 + col2;
      $('#options').append(row);
    }
    function deleteRow(row)
    {
      $(row).closest('tr').remove();
    }
  </script>
</html>
