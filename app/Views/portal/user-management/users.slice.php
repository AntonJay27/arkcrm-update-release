@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

<style type="text/css">
  /*INTERNAL STYLES*/
  .tbl tr td{
    border : none !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow b
  {
    margin-top: 2px !important;
  }

  .select2-container .select2-selection--single .select2-selection__rendered
  {
    padding-left: 0px !important;
  }

  .select2-container--default .select2-selection--single
  {
    border: 1px solid #ced4da;
  }
  
</style>

@endsection



@section('page_content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header pt-1 pb-1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <h6 class="mt-1 float-left">
            <span>
              <a href="<?php echo base_url(); ?>/users" class="text-muted">Users</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>/users" class="text-muted">All</a>
            </small> 
            <!-- <small> - 
              <a href="#" class="text-muted" id="lnk_user">Anton Jay</a>
            </small> -->
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_createNewUser">
                  <i class="fa fa-plus mr-1"></i> Create New User
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_importUsers">
                  <i class="fa fa-upload mr-1"></i>Import
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_createNewUser">
                <i class="fa fa-plus mr-1"></i> Create New User
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_importUsers">
                <i class="fa fa-upload mr-1"></i> Import
              </button>
            </div>
          </div>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_users" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2" data-priority="1">First Name</th>
                    <th class="p-2" data-priority="2">Last Name</th>
                    <th class="p-2" data-priority="3">User Name</th>
                    <th class="p-2">User Email</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">User Status</th>
                    <th class="p-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- /.row -->

    </div><!-- /.container flued -->

    <div class="modal fade" id="modal_users" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_titleHeader"><i class="fa fa-plus mr-1"></i> Create New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_users">

              <input type="hidden" id="txt_userId" name="txt_userId">

              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">User Login & Role - 
                    <small><i class="text-red">All fields with astirisk(*) is required </i></small>
                  </h5>
                </div>
                <div class="card-body">

                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">User Name *</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_userName" name="txt_userName" placeholder="(e.g. Notz)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Primary Email *</td>
                            <td class="p-1">
                              <input type="email" class="form-control form-control-sm" id="txt_primaryEmail" name="txt_primaryEmail" placeholder="(e.g. ajhay.dev@gmail.com)" required>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">First Name</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Last Name *</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_lastName" name="txt_lastName" placeholder="(e.g. Dela Cruz)" required>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Role *</td>
                            <td class="p-1">
                              <select class="form-select form-control form-control-sm" id="slc_roles" name="slc_roles" required>
                              
                              </select>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Admin</td>
                            <td class="p-1">
                              <div class="form-group">
                                <div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="chk_admin" name="chk_admin" value="1">
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
              
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="button" class="btn btn-secondary" id="btn_clearUserForm">Clear</button>
            <button type="submit" class="btn btn-primary" id="btn_submitUser" form="form_users">Save User</button>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer pt-2 pb-2">
  Powered by <strong>Arkonor LLC CRM</strong> &#169; <?php echo date('Y') ?>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
  </div>
  <!-- <center>
    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-save mr-1"></i> Save</button>
    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-times mr-1"></i> Cancel</button>
  </center> -->
</footer>

@endsection



@section('custom_scripts')

<!-- Plugins -->
<!-- Select2 -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/js/select2.full.min.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/user-management/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('#nav_userManagement').parent('li').addClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_userManagement').addClass('active'); //menu
    $('#nav_users').addClass('active'); //sub-menu

    //topNav icon & label

    let topNav = `<i class="fas fa-users mr-2"></i>
                  <b>USER MANAGEMENT</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    USERS.loadUsers();

    $('#lnk_createNewUser').on('click',function(){
      USERS.selectEmailConfig();
    });

    $('#btn_createNewUser').on('click',function(){
      USERS.selectEmailConfig();
    });

    $('#btn_clearUserForm').on('click',function(){
      $('#txt_userName').val('');
      $('#txt_primaryEmail').val('');
      $('#txt_firstName').val('');
      $('#txt_lastName').val('');
      $('#slc_roles').val('');
      $('#chk_admin').prop('checked',false);
    });

    $('#form_users').on('submit',function(e){
      e.preventDefault();
      let userId = $('#txt_userId').val();
      (userId == "")? USERS.addUser(this) : USERS.editUser(this);
    });

  });
</script>

@endsection
