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
                  <h4 class="page-title float-left">Vouchers</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md" onclick="add()">Add voucher</button>
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <table id="user_data" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="20%">Code</th>
                        <th width="10%">Type</th>
                        <th width="10%">Offer</th>
                        <th width="10%">Voucher count</th>
                        <th width="10%">Voucher remains</th>
                        <th width="10%">End date</th>
                        <th width="10%">Status</th>
                        <th width="10%">Edit</th>
                        <th width="10%">Delete</th>
                      </tr>
                    </thead>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('admin/includes/footer.php'); ?>
    </div>
    <div id="add-voucher" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog">
                 <div class="modal-content">

                     <div class="modal-body">
                         <h2 class="text-uppercase text-center m-b-30">
                             <span><h4>Voucher</h4></span>
                         </h2>


                         <form class="form-horizontal" action="<?=site_url('admin/vouchers/add')?>" method="post" onsubmit="return confirm_submit()">

                             <div class="form-group m-b-25">
                                 <div class="col-12">
                                     <label for="select">Voucher code</label>
                                     <label class="pull-right"><button type="button" class="btn btn-link" style="padding:0px;margin:0px;" onclick="generate()">Change</button></label>
                                     <input type="text" class="form-control" name="code" id="code" readonly>
                                 </div>
                             </div>

                             <div class="form-group m-b-25">
                                 <div class="col-12">
                                     <label for="select">Voucher type</label><br>
                                     <select class="form-control" name="type">
                                       <option value="cash">Cash</option>
                                       <option value="percentage">Percentage</option>
                                     </select>
                                 </div>
                             </div>

                             <div class="form-group m-b-25">
                                 <div class="col-12">
                                     <label for="select">Offer</label>
                                     <input type="text" class="form-control" name="offer" placeholder="In cash/percentage">
                                 </div>
                             </div>

                             <div class="form-group m-b-25">
                                 <div class="col-12">
                                     <label for="select">Voucher count</label>
                                     <input type="text" class="form-control" name="count">
                                 </div>
                             </div>

                             <div class="form-group m-b-25">
                                 <div class="col-12">
                                     <label><button type="button" class="btn btn-link" style="padding:0px;margin:0px;" onclick="setup_end_date()">SET UP END DATE</button></label>
                                 </div>
                             </div>
                             <div id="end-date-div" style="display:none;">
                               <div class="form-group m-b-25">
                                   <div class="col-12">
                                       <label for="select">End date</label>
                                       <input type="date" class="form-control" name="end_date">
                                   </div>
                               </div>
                             </div>
                             <div class="form-group account-btn text-center m-t-10">
                                 <div class="col-12">
                                     <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                                     <button class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Add</button>
                                 </div>
                             </div>
                         </form>


                     </div>
                 </div><!-- /.modal-content -->
             </div><!-- /.modal-dialog -->
         </div>
         <div id="edit-voucher" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog">
                      <div class="modal-content">

                          <div class="modal-body">
                              <h2 class="text-uppercase text-center m-b-30">
                                  <span><h4>Edit voucher</h4></span>
                              </h2>


                              <form class="form-horizontal" action="<?=site_url('admin/vouchers/edit')?>" method="post" onsubmit="return confirm_submit()">

                                  <div class="form-group m-b-25">
                                      <div class="col-12">
                                          <label for="select">Voucher code</label>
                                          <input type="text" class="form-control" name="code" id="voucher-code" readonly>
                                      </div>
                                  </div>
                                  <input type="hidden" name="voucher_id" id="voucher_id">
                                  <div class="form-group m-b-25">
                                      <div class="col-12">
                                          <label for="select">Voucher type</label><br>
                                          <select class="form-control" name="type" id="voucher-type">
                                            <option value="cash">Cash</option>
                                            <option value="percentage">Percentage</option>
                                          </select>
                                      </div>
                                  </div>

                                  <div class="form-group m-b-25">
                                      <div class="col-12">
                                          <label for="select">Offer</label>
                                          <input type="text" class="form-control" name="offer" id="voucher-offer" placeholder="In cash/percentage">
                                      </div>
                                  </div>

                                  <div class="form-group m-b-25">
                                      <div class="col-12">
                                          <label for="select">Voucher count</label>
                                          <input type="text" class="form-control" name="count" id="voucher-count" readonly>
                                      </div>
                                  </div>

                                  <div class="form-group m-b-25">
                                      <div class="col-12">
                                          <label for="select">Voucher remains</label>
                                          <input type="text" class="form-control" name="remains" id="voucher-remains" readonly>
                                      </div>
                                  </div>

                                  <div id="setup-div">
                                    <div class="form-group m-b-25">
                                        <div class="col-12">
                                            <label><button type="button" class="btn btn-link" style="padding:0px;margin:0px;" onclick="setup_end_date_edit()">SET UP END DATE</button></label>
                                        </div>
                                    </div>
                                  </div>

                                  <div id="end-date-div-edit" style="display:none;">
                                    <div class="form-group m-b-25">
                                        <div class="col-12">
                                            <label for="select">End date</label>
                                            <input type="date" class="form-control" name="end_date" id="end_date">
                                        </div>
                                    </div>

                                    <div id="checkbox-div">
                                      <div class="form-group m-b-25">
                                          <div class="col-12">
                                              <label class="checkbox-inline"><input type="checkbox" name="remove" value="" id="remove_id" onclick="check_value()" value="0">&nbsp;&nbsp;&nbsp;Remove End date</label>
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group account-btn text-center m-t-10">
                                      <div class="col-12">
                                          <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                                          <button class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Add</button>
                                      </div>
                                  </div>
                              </form>


                          </div>
                      </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
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
          url:"<?=site_url('admin/vouchers/get')?>",
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
  <script type="text/javascript">
      var status_check = 0;
      $(document).ready(function() {
          $('#datatable').DataTable();

          //Buttons examples
          var table = $('#datatable-buttons').DataTable({
              lengthChange: false,
              buttons: ['copy', 'excel', 'pdf']
          });

          table.buttons().container()
                  .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      } );
      function add()
      {
        var random = makeid();
        $('#code').val(random);
        $('#add-voucher').modal('show');
      }
      function confirm_delete() {
        if (confirm("Are you sure to delete this item?")) {
            return true;
        }
        return false;
      }
      function makeid() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        for (var i = 0; i < 10; i++)
          text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
      }
      function generate()
      {
        var random = makeid();
        $('#code').val(random);
      }
      function setup_end_date()
      {
        $("#end-date-div").css({ display: "block" });
      }
      function setup_end_date_edit()
      {
        $("#end-date-div-edit").css({ display: "block" });
      }
      function edit_voucher(id)
      {
        $('#voucher_id').val(id);
        $.ajax({
          method: "POST",
          url: "<?=site_url('admin/vouchers/getVouchersById');?>",
          data : { id : id },
          dataType : "json",
          success : function( data ){
            $('#voucher-code').val(data.code);
            $('#voucher-offer').val(data.offer);
            $('#voucher-count').val(data.count);
            $('#voucher-remains').val(data.remains);
            $('#voucher-type').val(data.type);
            var st = data.end_date_status;
            if(st == '1')
            {
              $("#end-date-div-edit").css({ display: "block" });
              $("#setup-div").css({ display: "none" });
              $("#checkbox-div").css({ display: "block" });
              $('#end_date').val(data.end_date);
            }
            else {
              $("#end-date-div-edit").css({ display: "none" });
              $("#setup-div").css({ display: "block" });
              $("#checkbox-div").css({ display: "none" });
            }
            $('#answer').val(data.answer);
            $('#edit-voucher').modal('show');
              }
        });
      }
      function check_value()
      {
        if ($('#remove_id').is(":checked"))
        {
          //$('#remove_id').val(1);
          document.getElementById("end_date").readOnly = true;
        }
        else {
          //$('#remove_id').val(0);
          document.getElementById("end_date").readOnly = false;
        }
      }
      function del()
      {
        if (confirm('Are you sure to delete this voucher ?')) {
          return true;
        }
        else {
          return false;
        }
      }
  </script>
</html>
