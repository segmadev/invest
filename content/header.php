<?php
require_once "include/ini-session.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once "include/ini.php"; ?>
<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 14 Aug 2023 16:00:13 GMT -->

<head>
  <!--  Title -->
  <title><?= company_name ?></title>
  <!--  Required Meta Tag -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="handheldfriendly" content="true" />
  <meta name="MobileOptimized" content="width" />
  <meta name="description" content="<?= company_name ?>" />
  <meta name="author" content="" />
  <meta name="keywords" content="<?= company_name ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!--  Favicon -->
  <link rel="shortcut icon" type="image/png" href="<?= $favicon ?>" />

  <!-- Owl Carousel  -->
  <?php require_once "content/head.php"; ?>
  <style>
    input[type="number"] {
      font-size: 30px;
      border: none;
      padding: 10px 0px;
      /* padding-top: ; */

    }

    li {
      list-style: none !important;
    }
  </style>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader bg-transparent d-none" id="pagepreload">
        <img src="https://proloomtrading.com/images/w-loading.gif" alt="loader" class="lds-ripple img-fluid" />
        <!-- <p class="lds-ripple img-fluid">Finding message</p> -->
    </div>
  <!-- <div class="preloader">
      <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div> -->
  <!-- Preloader -->
  <!-- <div class="preloader">
      <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div> -->
  <!--  Body Wrapper -->
  <div class="page-wrapper p-0 p-3" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="../" class="text-nowrap logo-img">
            <img src="<?= $logo ?>" class="dark-logo" width="180" alt="" />
            <!-- <img src="<?= $light_logo ?>" class="light-logo" width="180" alt="" /> -->
          </a>
          <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8 text-muted"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">
            <!-- ============================= -->
            <!-- Home -->
            <!-- ============================= -->
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Theme</span>
            </li>
            <?= $theme_btn ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Dashboard</span>
            </li>
            <!-- =================== -->
            <!-- Dashboard -->
            <!-- =================== -->
            <li class="sidebar-item">
              <a class="sidebar-link" href="index" aria-expanded="false">
                <span>
                  <i class="ti ti-dashboard"></i>
                </span>
                <span class="hide-menu">Home</span>
              </a>
            </li>
            <?php if($user['chat_status'] == "active") { ?>
            <li class="sidebar-item">
              <a class="sidebar-link d-flex" href="index?p=chat" aria-expanded="false">
                <span>
                  <i class="ti ti-messages"></i>
                </span>
                <span class="hide-menu">Chat</span>
                <span class="sidebar-link text-danger bg-light-danger fs-2 p-1" id="message-no"></span>
              </a>
            </li>
          <?php } ?>
            <!-- ============================= -->
            <!-- Apps -->
            <!-- ============================= -->
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Investment</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="index?p=investment&action=overview" aria-expanded="false">
                <span>
                  <i class="ti ti-plus"></i>
                </span>
                <span class="hide-menu">New Investment</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="index?p=investment" aria-expanded="false">
                <span>
                  <i class="ti ti-coins"></i>
                </span>
                <span class="hide-menu">Manage Investment</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="index?p=promo&action=new" aria-expanded="false">
                <span>
                  <i class="ti ti-star"></i>
                </span>
                <span class="hide-menu">Promo</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="index?p=compound_profits&action=new" aria-expanded="false">
                <span>
                  <i class="ti ti-topology-star-3"></i>
                </span>
                <span class="hide-menu">Compound your Profits</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="index?p=stocks" aria-expanded="false">
                <span>
                  <i class="ti ti-box-multiple-0"></i>
                </span>
                <span class="hide-menu">Stocks</span>
              </a>
            </li>
            <!-- ============================= -->
            <!-- PAGES -->
            <!-- ============================= -->
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Transactions</span>
            </li>


            <li class="sidebar-item">
              <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-currency-dollar"></i>
                </span>
                <span class="hide-menu">Deposit</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="index?p=deposit&action=new" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Make new deposit</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="index?p=deposit" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Manage Deposit</span>
                  </a>
                </li>
              </ul>
            </li>


            <li class="sidebar-item">
              <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-box-multiple"></i>
                </span>
                <span class="hide-menu">Withdraw</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="index?p=withdraw&action=new" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Make new Withdrawal</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="index?p=withdraw" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Manage withdrawal</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Wallets</span>
                  </a>
                  <ul aria-expanded="false" class="collapse two-level">
                    <li class="sidebar-item">
                      <a href="index?p=wallets&action=new" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                          <i class="ti ti-circle"></i>
                        </div>
                        <span class="hide-menu">Add new wallet</span>
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="index?p=wallets&action=list">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                          <i class="ti ti-circle"></i>
                        </div>
                        <span class="hide-menu">Manage Wallets</span>
                      </a>

                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link text-success" href="index?p=referral" aria-expanded="false">
                <span>
                  <i class="ti ti-award "></i>
                </span>
                <span class="hide-menu">Refer & Earn</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">activities</span>
            </li>
            <!-- Activites -->
            <li class="sidebar-item">
              <a class="sidebar-link" href="index?p=activities" aria-expanded="false">
                <span>
                  <i class="ti ti-list"></i>
                </span>
                <span class="hide-menu">All Activities</span>
              </a>
            </li>
            <!-- ============================= -->

          </ul>
       
          <form action="index?logout=" method="post">
            <div class=" fixed-profile bg-light-secondary rounded sidebar-ad m-0 p-0 p-3 mt-3">
              <a href='index?p=profile' class="hstack gap-3">
                <div class="john-img">
                  <img src="<?= $u->get_profile_icon_link($userID) ?>" class="rounded-circle" width="40" height="40" alt="">
                </div>
                <div class="john-title">
                  <h6 class="mb-0 fs-3 fw-semibold"><?= $d->short_text($u->get_name($userID), 8) ?></h6>

                </div>
                <button class="border-0 p-2 rounded-1 text-danger bg-light-danger ms-auto" tabindex="0" type="submit" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                  <i class="ti ti-power fs-6"></i>
                </button>
              </a>
            </div>
          </form>
          <div class="unlimited-access hide-menu bg-light-primary position-relative my-7 rounded">
            <div class="d-flex">
              <div class="unlimited-access-title">
                <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">10X</h6>
                <a href="index?p=investment&action=overview" class="btn btn-primary fs-2 fw-semibold lh-sm">Invest Now!</a>
              </div>
              <div class="unlimited-access-img">
                <img src="dist/images/backgrounds/rocket.png" alt="" class="img-fluid">
              </div>
            </div>
          </div>
        </nav>

        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item d-none d-lg-block">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ti ti-search"></i>
              </a>
            </li>
          </ul>
          <!-- <ul class="navbar-nav quick-links d-none d-lg-flex">
            <li class="nav-item dropdown hover-dd d-none d-lg-block">
              <a class="nav-link" href="javascript:void(0)" data-bs-toggle="dropdown">Apps<span class="mt-1"><i class="ti ti-chevron-down"></i></span></a>
              <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0">
                <div class="row">
                  <div class="col-8">
                    <div class=" ps-7 pt-7">
                      <div class="border-bottom">
                        <div class="row">
                          <div class="col-6">
                            <div class="position-relative">
                              <a href="app-chat.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-chat.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">Chat Application</h6>
                                  <span class="fs-2 d-block text-dark">New messages arrived</span>
                                </div>
                              </a>
                              <a href="app-invoice.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-invoice.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">Invoice App</h6>
                                  <span class="fs-2 d-block text-dark">Get latest invoice</span>
                                </div>
                              </a>
                              <a href="app-contact2.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-mobile.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">Contact Application</h6>
                                  <span class="fs-2 d-block text-dark">2 Unsaved Contacts</span>
                                </div>
                              </a>
                              <a href="app-email.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-message-box.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">Email App</h6>
                                  <span class="fs-2 d-block text-dark">Get new emails</span>
                                </div>
                              </a>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="position-relative">
                              <a href="page-user-profile.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-cart.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">User Profile</h6>
                                  <span class="fs-2 d-block text-dark">learn more information</span>
                                </div>
                              </a>
                              <a href="app-calendar.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-date.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">Calendar App</h6>
                                  <span class="fs-2 d-block text-dark">Get dates</span>
                                </div>
                              </a>
                              <a href="app-contact.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-lifebuoy.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">Contact List Table</h6>
                                  <span class="fs-2 d-block text-dark">Add new contact</span>
                                </div>
                              </a>
                              <a href="app-notes.html" class="d-flex align-items-center pb-9 position-relative text-decoration-none text-decoration-none text-decoration-none text-decoration-none">
                                <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                  <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-application.svg" alt="" class="img-fluid" width="24" height="24">
                                </div>
                                <div class="d-inline-block">
                                  <h6 class="mb-1 fw-semibold bg-hover-primary">Notes Application</h6>
                                  <span class="fs-2 d-block text-dark">To-do and Daily tasks</span>
                                </div>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row align-items-center py-3">
                        <div class="col-8">
                          <a class="fw-semibold text-dark d-flex align-items-center lh-1 text-decoration-none" href="#"><i class="ti ti-help fs-6 me-2"></i>Frequently Asked Questions</a>
                        </div>
                        <div class="col-4">
                          <div class="d-flex justify-content-end pe-4">
                            <button class="btn btn-primary">Check</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4 ms-n4">
                    <div class="position-relative p-7 border-start h-100">
                      <h5 class="fs-5 mb-9 fw-semibold">Quick Links</h5>
                      <ul class="">
                        <li class="mb-3">
                          <a class="fw-semibold text-dark bg-hover-primary text-decoration-none text-decoration-none text-decoration-none text-decoration-none" href="page-pricing.html">Pricing Page</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold text-dark bg-hover-primary text-decoration-none text-decoration-none text-decoration-none text-decoration-none" href="authentication-login.html">Authentication Design</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold text-dark bg-hover-primary text-decoration-none text-decoration-none text-decoration-none text-decoration-none" href="authentication-register.html">Register Now</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold text-dark bg-hover-primary text-decoration-none text-decoration-none text-decoration-none text-decoration-none" href="authentication-error.html">404 Error Page</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold text-dark bg-hover-primary text-decoration-none text-decoration-none text-decoration-none text-decoration-none" href="app-notes.html">Notes App</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold text-dark bg-hover-primary text-decoration-none text-decoration-none text-decoration-none text-decoration-none" href="page-user-profile.html">User Application</a>
                        </li>
                        <li class="mb-3">
                          <a class="fw-semibold text-dark bg-hover-primary text-decoration-none text-decoration-none text-decoration-none text-decoration-none" href="page-account-settings.html">Account Settings</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown-hover d-none d-lg-block">
              <a class="nav-link" href="app-chat.html">Chat</a>
            </li>
            <li class="nav-item dropdown-hover d-none d-lg-block">
              <a class="nav-link" href="app-calendar.html">Calendar</a>
            </li>
            <li class="nav-item dropdown-hover d-none d-lg-block">
              <a class="nav-link" href="app-email.html">Email</a>
            </li>
          </ul> -->
          <div class="d-block d-lg-none">
            <img src="<?= $dark_logo ?>" class="dark-logo" width="180" alt="" />
            <img src="<?= $light_logo ?>" class="light-logo" width="180" alt="" />
          </div>
          <button onclick="loadnotification()" class="btn mb-1 btn-light-info text-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
              <div class="icon bg-primary rounded-circle"></div>
              <i class="ti ti-bell-ringing"></i> <span class='text-danger fw-semibold'><b id="note-no"></b></span>
            </a>
          </button>
          <a class="navbar-toggler p-0 border-0" href="index?p=profile" type="button" id="drop2">
            <div class="nav-link nav-icon-hover">
              <div class="rounded-circle overflow-hidden me-6">
                <img src="<?= $u->get_profile_icon_link($userID) ?>" alt="" width="40" height="40">
              </div>
              <!-- <div class="notification bg-primary rounded-circle"></div> -->
            </div>
          </a>
          <div class="navbar-collapse justify-content-end collapse" id="navbarNav">
            <div class="d-flex align-items-center justify-content-between">
              <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                <i class="ti ti-align-justified fs-7"></i>
              </a>

            </div>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="d-flex middle">
          <?php
          if ($page != "chat") {
            require_once "include/translate.php";
          } ?>
        </div>