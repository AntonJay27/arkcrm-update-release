<!-- Put your navbar here! -->

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" id="lnk_topNav" role="button">
        <i class="fas fa-users mr-2"></i>
        <b>MARKETING</b>
      </a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user-circle"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <span class="dropdown-header">
          <i class="far fa-user-circle mr-2"></i>
          <span id="lbl_thisUserCompleteName2"></span>
        </span>
        <!-- <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
        </a> -->
        <div class="dropdown-divider"></div>
        <a href="<?php echo base_url(); ?>/user-logout" class="dropdown-item dropdown-footer">
          <i class="fa fa-lock mr-2"></i>Log out
        </a>
      </div>
    </li>
  </ul>

</nav>

<!-- /.navbar -->

