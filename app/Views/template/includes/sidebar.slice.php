<!-- Put your sidebar here! -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="javascript:void(0)" class="brand-link">
    <img src="<?php echo base_url(); ?>/public/assets/img/arkonorllc-logo-edited.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Arkonor LLC - CRM</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url(); ?>/public/assets/AdminLTE/dist/img/user2-160x160.jpg" id="img_thisUserProfilePicture" class="profile-user-img img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?php echo base_url(); ?>/my-account" class="d-block">
          <span id="lbl_thisUserCompleteName1"></span>
        </a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar nav-child-indent nav-flat nav-legacy flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        @if(in_array(1,$accessModules[0]))
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/dashboard" id="nav_dashboard" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>DASHBOARD</p>
          </a>
        </li>
        @endif

        @if(in_array(1,$accessModules[1]) || in_array(1,$accessModules[2]))
        <li class="nav-item">
          <a href="#" id="nav_rolodex" class="nav-link">
            <i class="nav-icon fas fa-address-book" aria-hidden="true"></i>
            <p>
              ROLODEX
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if(in_array(1,$accessModules[1]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/contacts" id="nav_contacts" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Contacts</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[2]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/organizations" id="nav_organizations" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Organizations</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif

        @if(in_array(1,$accessModules[3]) || in_array(1,$accessModules[4]) || in_array(1,$accessModules[5]) || in_array(1,$accessModules[6]) || in_array(1,$accessModules[7]) || in_array(1,$accessModules[8]))
        <li class="nav-item">
          <a href="#" id="nav_marketing" class="nav-link">
            <i class="nav-icon fas fa-bullhorn" aria-hidden="true"></i>
            <p>
              MARKETING
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if(in_array(1,$accessModules[3]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/campaigns" id="nav_campaigns" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Campaigns</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[4]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/news-letters" id="nav_newsLetters" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>News Letters</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[5]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/social-media-post" id="nav_socialMediaPosts" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Social Media Posts</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[6]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/image-library" id="nav_imageLibrary" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Image Library</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[7]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/email-template" id="nav_emailTemplate" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Email Templates</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[8]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/email-signature" id="nav_emailSignature" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Email Signatures</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif
        @if(in_array(1,$accessModules[9]))
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/employees" id="nav_employees" class="nav-link">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>EMPLOYEES</p>
          </a>
        </li>
        @endif
        @if(in_array(1,$accessModules[10]))
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/agenda" id="nav_agenda" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>AGENDA</p>
          </a>
        </li>
        @endif
        @if(in_array(1,$accessModules[11]))
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/calendar" id="nav_calendar" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i>
            <p>CALENDAR</p>
          </a>
        </li>
        @endif
        @if(in_array(1,$accessModules[12]))
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/documents" id="nav_documents" class="nav-link">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>DOCUMENTS</p>
          </a>
        </li>
        @endif
        @if(in_array(1,$accessModules[13]) || in_array(1,$accessModules[14]) || in_array(1,$accessModules[15]))
        <li class="nav-item">
          <a href="javascript:void(0)" id="nav_userManagement" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>USER MANAGEMENT <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @if(in_array(1,$accessModules[13]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/users" id="nav_users" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Users</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[14]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/roles" id="nav_roles" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Roles</p>
              </a>
            </li>
            @endif
            @if(in_array(1,$accessModules[15]))
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/profiles" id="nav_profiles" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Profiles</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif
        @if(in_array(1,$accessModules[16]))
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/settings" id="nav_settings" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>SETTINGS <span class="right badge badge-danger">New</span></p> 
          </a>
        </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>