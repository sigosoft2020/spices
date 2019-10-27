  <?php $user = $this->session->userdata['admin']; ?>
  <div class="topbar">
      <!-- LOGO -->
      <div class="topbar-left">
          <a href="<?=site_url('admin/dashboard')?>" class="logo">
            <span>

               <img src="<?=base_url()?>assets/images/logo.png" alt="" height="40" width="110">
            </span>
            <i>
              <img src="<?=base_url()?>assets/images/logo_sm.png" alt="" height="30">
            </i>
          </a>


      </div>



      <nav class="navbar-custom">

          <ul class="list-unstyled topbar-right-menu float-right mb-0">

              <li class="dropdown notification-list">
                  <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                     aria-haspopup="false" aria-expanded="false">
                       <span class="ml-1"><?=$user['name']?><i class="mdi mdi-chevron-down"></i> </span>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <a href="<?=site_url('admin/settings')?>" class="dropdown-item notify-item">
                        <i class="fi-power"></i> <span>Settings</span>
                    </a>
                    <a href="<?=site_url('app/logout')?>" class="dropdown-item notify-item">
                        <i class="fi-power"></i> <span>Logout</span>
                    </a>
                  </div>
              </li>
          </ul>

          <ul class="list-inline menu-left mb-0 float-left">
              <li class="float-left">
                  <button class="button-menu-mobile open-left waves-light waves-effect">
                      <i class="dripicons-menu"></i>
                  </button>
              </li>
          </ul>
 <!-- <h2 class="page_hd">Vendor</h2> -->
      </nav>

  </div>
  <!-- Top Bar End -->


  <!-- ========== Left Sidebar Start ========== -->
  <div class="left side-menu">
      <div class="slimscroll-menu" id="remove-scroll">

          <!--- Sidemenu -->
          <div id="sidebar-menu">
              <!-- Left Menu Start -->
              <ul class="metismenu" id="side-menu">
                  <li class="menu-title">Navigation</li>
                  <li>
                      <a href="<?=site_url('admin/dashboard')?>">
                          <i class="fa fa-dashcube"></i><span> Dashboard </span>
                      </a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-book"></i> <span> Events </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/events')?>">Upcoming</a></li>
                          <!--<li><a href="<?=site_url('admin/events/completed')?>">Completed</a></li>-->
                          <li><a href="<?=site_url('admin/events/completed')?>">Past events</a></li>
                          <li><a href="<?=site_url('admin/events/add')?>">Add event</a></li>
                      </ul>
                  </li>
                  
                  <li>
                      <a href="#"><i class="fa fa-newspaper-o"></i> <span> News </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/news')?>">View</a></li>
                          <li><a href="<?=site_url('admin/news/add')?>">Add news</a></li>
                      </ul>
                  </li>
                  <!-- <li>
                      <a href="#"><i class="fa fa-futbol-o"></i> <span> Turfs </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/turfs')?>">Active turfs</a></li>
                          <li><a href="<?=site_url('admin/turfs/blocked')?>">Blocked turfs</a></li>
                          <li><a href="<?=site_url('admin/turfs/pending')?>">Pending turfs</a></li>
                      </ul>
                  </li> -->

                  <!--<li>
                      <a href="<?=site_url('slider')?>">
                          <i class="fa fa-desktop"></i><span> Home slider </span>
                      </a>
                  </li>-->

                  <li>
                      <a href="#"><i class="fa fa-user"></i> <span> Members </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/members')?>">View members</a></li>
                          <li><a href="<?=site_url('admin/members/add')?>">Add member</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-user-secret"></i> <span> Gallery </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/gallery')?>">View images</a></li>
                          <li><a href="<?=site_url('admin/gallery/add')?>">Add image</a></li>
                      </ul>
                  </li>

                  <!--<li>-->
                  <!--    <a href="#"><i class="fa fa-shower"></i> <span> Polls </span> <span class="menu-arrow"></span></a>-->
                  <!--    <ul class="nav-second-level" aria-expanded="false">-->
                  <!--        <li><a href="<?=site_url('admin/polls/upcoming')?>">Upcoming polls</a></li>-->
                  <!--        <li><a href="<?=site_url('admin/polls/completed')?>">Completed polls</a></li>-->
                  <!--        <li><a href="<?=site_url('admin/polls/add')?>">Add polls</a></li>-->
                  <!--    </ul>-->
                  <!--</li>-->

                  <!-- <li>
                      <a href="#"><i class="fa fa-money"></i> <span> Expenses </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/expenses')?>">View expenses</a></li>
                          <li><a href="<?=site_url('admin/expenses/add')?>">Add expense</a></li>
                          <li><a href="<?=site_url('admin/expenses/category')?>">Expense categories</a></li>
                          <li><a href="<?=site_url('admin/expenses/add_category')?>">Add expense category</a></li>
                      </ul>
                  </li> -->

                  <li>
                      <a href="#"><i class="fa fa-image"></i> <span> Sliders </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/sliders')?>">View sliders</a></li>
                          <li><a href="<?=site_url('admin/sliders/add')?>">Add slider</a></li>
                      </ul>
                  </li>

                  <!-- <li>
                      <a href="<?=site_url('admin/vouchers')?>"><i class="fa fa-gift"></i> <span> Vouchers </span></a>
                  </li>

                  <li>
                      <a href="<?=site_url('admin/feedbacks')?>"><i class="fa fa-comments-o"></i> <span> Feedbacks </span></a>
                  </li>

                  <li>
                      <a href="<?=site_url('admin/types')?>"><i class="fa fa-clone"></i> <span> Turf types </span></a>
                  </li> -->


              </ul>

          </div>
          <!-- Sidebar -->
          <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->

  <style>
    .page_hd {    width: 100%;
    text-align: center;
    color: #FFF;
    font-size: 22px;
    text-transform: uppercase;
    line-height: 70px;}

  </style>
