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
                  <h4 class="page-title float-left">MEMBERS</h4>
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
                  <table id="user_data" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="10%">Image</th>
                        <th width="20%">Username</th>
                        <th width="10%">Mobile</th>
                        <th width="20%">Email address</th>
                        <th width="5%">Status</th>
                        <th width="5%">Edit</th>
                        <th width="5%">Payment</th>
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
    <div class="modal fade" id="add-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">MAKE PAYMENT</h4>
          </div>
          <div class="modal-body">
            <form action="<?=site_url('admin/members/addPayment')?>" method="post" id="delete-form" onsubmit="return deleteConfirm()">
            <input type="hidden" name="member_id" id="member_id">
            <div class="form-group">
              <label>User</label>
              <input type="text" class="form-control" id="username" readonly>
            </div>
            <div class="form-group">
              <label>Registration fee</label>
              <input type="text" class="form-control" name="fee" value="<?=$fee?>" id="fee">
            </div>
            <div class="form-group">
              <label>Notes</label>
              <textarea name="notes" rows="4" cols="80" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success">Add payment</button>
            </form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="payment-status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">PAYMENT DETAILS</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label>User</label>
              <input type="text" class="form-control" id="user" readonly>
            </div>
            <div class="form-group">
              <label>Amount paid</label>
              <input type="text" class="form-control" id="paid_amount" readonly>
            </div>
            <div class="form-group">
              <label>Date</label>
              <input type="text" class="form-control" id="date" readonly>
            </div>
            <div class="form-group">
              <label>Time</label>
              <input type="text" class="form-control" id="time" readonly>
            </div>
            <div class="form-group">
              <label>Payment added by</label>
              <input type="text" class="form-control" id="payment_by" readonly>
            </div>
            <div class="form-group">
              <label>Notes</label>
              <textarea name="notes" rows="4" cols="80" class="form-control" id="notes" readonly></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
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
          url:"<?=site_url('admin/members/get')?>",
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

    function addPayment(id,user)
    {
      $('#member_id').val(id);
      $('#username').val(user);
      $('#add-payment').modal('show');
    }

    function getStatus(id,user)
    {
      $.ajax({
        method: "POST",
        url: "<?=site_url('admin/members/getPaymentDetails');?>",
        data : { member_id : id },
        dataType : "json",
        success : function( data ){
          $('#user').val(user);
          $('#paid_amount').val(data.payment);
          $('#payment_by').val(data.payment_by);
          $('#notes').val(data.notes);
          $('#date').val(data.date);
          $('#time').val(data.time);

          $('#payment-status').modal('show');
        }
      });
    }
  </script>
</html>
