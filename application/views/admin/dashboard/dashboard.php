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
                                        <li class="breadcrumb-item"><a href="#">Indian Society For Spices</a></li>
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
                                    <h6 class="text-muted text-uppercase mb-3">Upcoming events</h6>
                                    <h4 class="mb-3" data-plugin="counterup"><?=$eventUpcoming?></h4>
                                    <!-- <span class="badge badge-primary"> +11% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-layers float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Completed events</h6>
                                    <h4 class="mb-3"><span data-plugin="counterup"><?=$eventCompleted?></span></h4>
                                    <!-- <span class="badge badge-primary"> -29% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-tag float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Registered members</h6>
                                    <h4 class="mb-3"><span data-plugin="counterup"><?=$activeMembers?></span></h4>
                                    <!-- <span class="badge badge-primary"> 0% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-briefcase float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Upcoming polls</h6>
                                    <h4 class="mb-3" data-plugin="counterup"><?=$pollsUpcoming?></h4>
                                    <!-- <span class="badge badge-primary"> +89% </span> <span class="text-muted ml-2 vertical-middle">Last year</span> -->
                                </div>
                            </div>
                        </div>



                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">New members</h4>

                                    <div class="inbox-widget slimscroll" style="max-height: 370px;">
                                      <?php foreach ($members as $member) {
                                        if ($member->image == '') {
                                          $image = 'uploads/profile/user.png';
                                        }
                                        else {
                                          $image = $member->image;
                                        }

                                      ?>

                                        <a href="#">
                                            <div class="inbox-item">
                                                <div class="inbox-item-img"><img src="<?=base_url() . $image?>" class="rounded-circle bx-shadow-lg" alt=""></div>
                                                <p class="inbox-item-author"><?=$member->username?></p>
                                                <p class="inbox-item-text"><?=$member->email . ", " . $member->mobile?></p>
                                            </div>
                                        </a>

                                     <?php } ?>

                                    </div>

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
