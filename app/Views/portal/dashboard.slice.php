@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">
<!-- Chart JS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/chart.js/Chart.min.css">

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
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3 id="lbl_campaignsCount">0</h3>
              <h5>CAMPAIGNS</h5>
            </div>
            <div class="icon">
              <i class="fa fa-bullhorn"></i>
            </div>
            <a href="javascript:void(0)" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3 id="lbl_contactsCount">0</h3>
              <h5>CONTACTS</h5>
            </div>
            <div class="icon">
              <i class="fa fas fa-address-book"></i>
            </div>
            <a href="javascript:void(0)" onclick="DASHBOARD.loadContactChart('<?php echo date('Y-m'); ?>');" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3 class="text-white" id="lbl_organizationsCount">0</h3>
              <h5 class="text-white">ORGANIZATIONS</h5>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
            <a href="javascript:void(0)" onclick="DASHBOARD.loadOrganizationChart('<?php echo date('Y-m'); ?>');" class="small-box-footer">
              <span class="text-white">More info</span> <i class="fas fa-arrow-circle-right text-white"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3 id="lbl_usersCount">0</h3>
              <h5>USERS</h5>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo base_url(); ?>/users" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="row">
         <div class="col-lg-6">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Summary Reports</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                     <i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <canvas id="myChart"></canvas>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Activity Histories</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                     <i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
               The body of the card
               </div>
            </div>
         </div>
      </div>

      <!-- Modals Here -->

      <div class="modal fade" id="modal_contactChart" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fas fa-address-book mr-1"></i> Contacts</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

               <div class="row mb-2">
                  <div class="col-lg-9"><h5>Monthly Report</h5></div>
                  <div class="col-lg-3">
                     <input type="month" class="form-control form-control-sm" id="txt_monthYearContact" value="<?php echo date('Y-m'); ?>">
                  </div>
               </div>

               <canvas id="canvas_contactChart"></canvas>

            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_organizationChart" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-building mr-1"></i> Organizations</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

               <div class="row mb-2">
                  <div class="col-lg-9"><h5>Monthly Report</h5></div>
                  <div class="col-lg-3">
                     <input type="month" class="form-control form-control-sm" id="txt_monthYearOrganization" value="<?php echo date('Y-m'); ?>">
                  </div>
               </div>

               <canvas id="canvas_organizationChart"></canvas>

            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container flued -->
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
<!-- Chart JS -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/Chart.js/Chart.min.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_dashboard').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-th mr-2"></i>
                  <b>DASHBOARD</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    //
    // ======================================================>
    //

    DASHBOARD.loadAllCampaigns();
    DASHBOARD.loadAllContacts();
    DASHBOARD.loadAllOrganizations();
    DASHBOARD.loadAllUsers();

    $('#txt_monthYearContact').on('change',function(){
      // console.log($(this).val());
      DASHBOARD.loadContactChart($(this).val());
    });

    $('#txt_monthYearOrganization').on('change',function(){
      // console.log($(this).val());
      DASHBOARD.loadOrganizationChart($(this).val());
    });

    DASHBOARD.loadSummaryReports();

  });
</script>

@endsection
