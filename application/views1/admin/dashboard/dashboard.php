<!DOCTYPE html>
<html>
    <head>
      <?php $this->load->view('admin/includes/includes'); ?>
    </head>
    <body>
        <div id="wrapper">
            <?php $this->load->view('admin/includes/sidebar'); ?>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title float-left">Dashboard</h4>

                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="#">Wooslot</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-box float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Pending bookings</h6>
                                    <h4 class="mb-3" data-plugin="counterup"><?=$pending?></h4>
                                    <!-- <span class="badge badge-primary"> +11% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-layers float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Bookings this month</h6>
                                    <h4 class="mb-3"><span data-plugin="counterup"><?=$bookingThisMonth?></span></h4>
                                    <!-- <span class="badge badge-primary"> -29% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-tag float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Registered turfs</h6>
                                    <h4 class="mb-3"><span data-plugin="counterup"><?=$turfs?></span></h4>
                                    <!-- <span class="badge badge-primary"> 0% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-briefcase float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Registered customers</h6>
                                    <h4 class="mb-3" data-plugin="counterup"><?=$users?></h4>
                                    <!-- <span class="badge badge-primary"> +89% </span> <span class="text-muted ml-2 vertical-middle">Last year</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-briefcase float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3"> Today's expense</h6>
                                    <h4 class="mb-3" data-plugin="counterup">₹ <?php if($expenseToday){ echo $expenseToday; }else{ echo 0; }?></h4>
                                    <!-- <span class="badge badge-primary"> +89% </span> <span class="text-muted ml-2 vertical-middle">Last year</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-briefcase float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Expense this month</h6>
                                    <h4 class="mb-3" data-plugin="counterup">₹ <?php if($expenseMonthly){ echo $expenseMonthly; }else{ echo 0; }?></h4>
                                    <!-- <span class="badge badge-primary"> +89% </span> <span class="text-muted ml-2 vertical-middle">Last year</span> -->
                                </div>
                            </div>
                        </div>



                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">New users</h4>

                                    <div class="inbox-widget slimscroll" style="max-height: 370px;">
                                      <?php foreach ($customers as $user) { ?>

                                        <a href="#">
                                            <div class="inbox-item">
                                                <div class="inbox-item-img"><img src="<?=base_url() . $user->image?>" class="rounded-circle bx-shadow-lg" alt=""></div>
                                                <p class="inbox-item-author"><?=$user->username?></p>
                                                <p class="inbox-item-text"><?=$user->email . ", " . $user->mobile?></p>
                                            </div>
                                        </a>

                                     <?php } ?>

                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Latest Feedbacks</h4>

                                    <div class="comment-list slimscroll" style="max-height: 370px;">
                                      <?php foreach ($feedbacks as $feedback) { ?>

                                        <a href="#">
                                            <div class="comment-box-item">
                                                <div class="badge badge-pill badge-success"><?=$feedback->turf_name?></div>
                                                <p class="commnet-item-date">1 month ago</p>
                                                <h6 class="commnet-item-msg"><?=$feedback->review?></h6>
                                                <p class="commnet-item-user"><?=$feedback->username?></p>
                                            </div>
                                        </a>

                                      <?php } ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Last expenses</h4>

                                    <ul class="list-unstyled transaction-list slimscroll mb-0" style="max-height: 370px;">
                                      <?php foreach ($expenses as $exp) { ?>

                                        <li>
                                            <i class="dripicons-arrow-down text-success"></i>
                                            <span class="tran-text"><?=$exp->notes?></span>
                                            <span class="pull-right text-success tran-price"><?=$exp->expense?></span>
                                            <span class="pull-right text-muted"><?=$exp->date?></span>
                                            <span class="clearfix"></span>
                                        </li>

                                      <?php } ?>
                                    </ul>

                                </div>
                            </div>

                        </div>


                    </div> <!-- container -->

                </div> <!-- content -->

                <?php $this->load->view('admin/includes/footer') ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <?php $this->load->view('admin/includes/scripts') ?>

    </body>

<!-- Mirrored from coderthemes.com/abstack/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Jul 2018 07:59:48 GMT -->
</html>
