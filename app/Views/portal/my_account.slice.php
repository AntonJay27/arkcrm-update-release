@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

<!-- Full Calendar -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/fullcalendar/main.css">

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
    <div class="mt-2"></div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" id="img_profilePicture"
                     src="<?php echo base_url(); ?>/public/assets/img/user-placeholder.png"
                     alt="User profile picture">
              </div>

              <h3 class="profile-username text-center" id="lbl_userCompleteName">---</h3>

              <p class="text-muted text-center" id="lbl_userPosition">---</p>
              
              <a href="javascript:void(0)" id="btn_changeProfilePicture" class="btn btn-primary btn-block">
                <i class="fa fa-pen mr-2"></i>Change Profile Picture
              </a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">

          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" id="lnk_details" href="#details" data-toggle="tab">Details</a></li>
                <li class="nav-item"><a class="nav-link" id="lnk_security" href="#security" data-toggle="tab">Security</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                
                <div class="tab-pane active" id="details">
                  
                  <form class="form-horizontal" id="form_details">

                    <div class="form-group row">
                      <label for="slc_salutation" class="col-sm-2 col-form-label">Salutation *</label>
                      <div class="col-sm-10">
                        <select class="form-control" id="slc_salutation" name="slc_salutation" required>
                          <option value="" selected>--Salutation--</option>
                          <option value="Mr.">Mr.</option>
                          <option value="Ms.">Ms.</option>
                          <option value="Mrs.">Mrs.</option>
                          <option value="Dr.">Dr.</option>
                          <option value="Prof.">Prof.</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txt_firstName" class="col-sm-2 col-form-label">First Name *</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txt_firstName" name="txt_firstName" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txt_lastName" class="col-sm-2 col-form-label">Last Name *</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txt_lastName" name="txt_lastName" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txt_lastName" class="col-sm-2 col-form-label">Position *</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txt_position" name="txt_position" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txt_email" class="col-sm-2 col-form-label">Email *</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="txt_email" name="txt_email" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txt_contactNumber" class="col-sm-2 col-form-label">Contact Number</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txt_contactNumber" name="txt_contactNumber" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-danger" id="btn_saveChanges">Save Changes</button>
                      </div>
                    </div>

                  </form>

                </div>

                <div class="tab-pane" id="security">
                  
                  <form class="form-horizontal" id="form_changePassword">

                    <div class="form-group row">
                      <label for="txt_oldPassword" class="col-sm-2 col-form-label">Old Password *</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="txt_oldPassword" name="txt_oldPassword" placeholder="*********" required>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <label for="txt_newPassword" class="col-sm-2 col-form-label">New Password *</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="txt_newPassword" name="txt_newPassword" placeholder="*********" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txt_confirmPassword" class="col-sm-2 col-form-label">Confirm Password *</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="txt_confirmPassword" name="txt_confirmPassword" placeholder="*********" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" id="chk_showPassword"> 
                            <label for="chk_showPassword">Show Password</label>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Save Password</button>
                      </div>
                    </div>
                  
                  </form>

                </div>

              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </div><!-- /.container flued -->

    <div class="modal fade" id="modal_profilePicture" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_stateDocument">
              <i class="fa fa-pen mr-1"></i> 
              <span>Profile Picture</span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_profilePicture" enctype="multipart/form-data">
              
              <div class="row">
                <div class="col-lg-12 col-sm-12">
                  <div class="text-center bg-light pt-3 pb-3 mb-2" id="div_imagePreview">
                    <img class="profile-user-img img-fluid img-circle" id="img_profilePicture"
                         src="<?php echo base_url(); ?>/public/assets/img/user-placeholder.png"
                         alt="User profile picture">
                  </div> 
                  <div class="info-box-content">
                    <span class="info-box-number">Note:</span>
                    <span class="info-box-text">Accepted files (.jpg, .png, .jpeg)</span>
                  </div>
                  <input type="file" class="form-control" id="file_profilePicture" name="file_profilePicture" style="padding: 3px 3px 3px 3px !important;" accept="image/*" required>
                  <div class="text-center" id="div_imageDetails">
                    <span id="lbl_fileName"></span><br>
                    <span id="lbl_fileSize"></span><br>
                    <span id="lbl_fileStatus"></span>
                  </div>                  
                </div>
              </div> 
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="submit" class="btn btn-primary" id="btn_savePicture" form="form_profilePicture">Save Changes</button>
          </div>
        </div>
      </div>
    </div>
    
  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer pt-2 pb-2">
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.2.0
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

<!-- FullCalendar -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/fullcalendar/main.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-bars mr-2"></i><b>MY ACCOUNT</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();


    $('#lnk_details').addClass('active');

    MY_ACCOUNT.loadMyAccount();
    MY_ACCOUNT.loadMyAccountDetails();

    $('#btn_changeProfilePicture').on('click',function(){
      $('#div_imageDetails').hide();
      $('#modal_profilePicture').modal('show');
    });

    $('#file_profilePicture').on('change',function(){
      MY_ACCOUNT.uploadMyAccountPicturePreview(this);
    });

    $('#form_profilePicture').on('submit', function(e){
      e.preventDefault();
      MY_ACCOUNT.changeMyAccountPicture(this);
    });

    $('#form_details').on('submit', function(e){
      e.preventDefault();
      MY_ACCOUNT.editMyAccountDetials(this);
    });

    $('#chk_showPassword').on('change', function(){
      if($(this).is(':checked'))
      {
        $("#txt_oldPassword").attr('type','text');
        $("#txt_newPassword").attr('type','text');
        $("#txt_confirmPassword").attr('type','text');
      }
      else
      {
        $("#txt_oldPassword").attr('type','password');
        $("#txt_newPassword").attr('type','password');
        $("#txt_confirmPassword").attr('type','password');
      }
    });

    $('#form_changePassword').on('submit', function(e){
      e.preventDefault();
      MY_ACCOUNT.editMyAccountPassword(this);
    });

  });
</script>
@endsection
