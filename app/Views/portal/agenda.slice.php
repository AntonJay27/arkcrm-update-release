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
      
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <center>
         <img src="<?php echo base_url(); ?>/public/assets/img/coming-soon.jpg" class="img mb-2" style="height: 80vh;">
      </center>

      <!-- <div class="card">
        <div class="card-header">
          <h3 class="card-title">Check List</h3>
        </div>

        <div class="card-body">
        <table class="table">
        <thead>
        <tr>
        <th>Employee Name</th>
        <th>Job Description</th>
        <th>Department</th>
        <th>Date Hired</th>
        <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <tr class="callout callout-info" data-widget="expandable-table" aria-expanded="false">
        <td>183</td>
        <td>John Doe</td>
        <td>11-7-2014</td>
        <td>Approved</td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
        <tr class="expandable-body d-none">
        <td colspan="5">
        <p style="display: none;">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        </td>
        </tr>
        <tr class="callout callout-info" data-widget="expandable-table" aria-expanded="false">
        <td>219</td>
        <td>Alexander Pierce</td>
        <td>11-7-2014</td>
        <td>Pending</td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
        <tr class="expandable-body d-none">
        <td colspan="5">
        <p style="display: none;">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Meetings</h3>
        </div>

        <div class="card-body">
        <table class="table">
        <thead>
        <tr>
        <th>Name</th>
        <th>Job Description</th>
        <th>Department</th>
        <th>Date Hired</th>
        <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <tr class="callout" data-widget="expandable-table" aria-expanded="false">
        <td>183</td>
        <td>John Doe</td>
        <td>11-7-2014</td>
        <td>Approved</td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
        <tr class="expandable-body d-none">
        <td colspan="5">
        <p style="display: none;">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        </td>
        </tr>
        <tr class="callout" data-widget="expandable-table" aria-expanded="false">
        <td>219</td>
        <td>Alexander Pierce</td>
        <td>11-7-2014</td>
        <td>Pending</td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
        <tr class="expandable-body d-none">
        <td colspan="5">
        <p style="display: none;">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
      </div> -->

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

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_agenda').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-list mr-2"></i>
                  <b>AGENDA</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    //
    // ======================================================>
    //

    


  });
</script>

@endsection
