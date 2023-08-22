@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

<!-- BS-STEPPER -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bs-stepper/css/bs-stepper.min.css">

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
  <div class="content-header pt-2 pb-2">

  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fa fa-upload"></i> Batch Import Contact
              </h3>
            </div>
            <div class="card-body p-0">
              <div class="bs-stepper linear">
                <div class="bs-stepper-header" role="tablist">

                  <div class="step" data-target="#logins-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger" aria-selected="true">
                      <span class="bs-stepper-circle">1</span>
                      <span class="bs-stepper-label">Choose CSV</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step active" data-target="#information-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false">
                      <span class="bs-stepper-circle">2</span>
                      <span class="bs-stepper-label">Various information</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#information-part-2">
                    <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false" disabled="disabled">
                      <span class="bs-stepper-circle">2</span>
                      <span class="bs-stepper-label">Step 3</span>
                    </button>
                  </div>
                </div>
                <div class="bs-stepper-content">

                  <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                  </div>
                  <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                    <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div><!-- /.container flued -->
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

<!-- BS STEPPER -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bs-stepper/js/bs-stepper.min.js"></script>

<!-- Custom Scripts -->

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_employees').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-user-tie mr-2"></i>
    <b>TEST</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    //
    // ======================================================>
    //
    
  });
</script>

@endsection
