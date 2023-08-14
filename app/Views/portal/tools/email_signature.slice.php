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
              <a href="<?php echo base_url(); ?>/email-signature" class="text-muted">Email Signatures</a>
            </span>
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_createSignature">
                  <i class="fa fa-plus mr-1"></i>Create Signature
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_importTemplate">
                  <i class="fa fa-upload mr-1"></i>Import
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_createSignature">
                <i class="fa fa-plus mr-1"></i> Create Signature
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_importTemplate">
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
      
      <div class="card card-primary card-outline">
        <div class="card-body">
          <!-- <table id="tbl_emailTemplates" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
            <thead>
              <tr>
                <th class="p-2 pl-4" data-priority="1">Name/Code</th>
                <th class="p-2" data-priority="2">Category</th>
                <th class="p-2" data-priority="3">Owner</th>
                <th class="p-2">Subject</th>
                <th class="p-2">Access</th>
                <th class="p-2">Status</th>
                <th class="p-2">Date Created</th>
                <th class="p-2">Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table> -->

          <center>
             <h3 class="text-bold text-danger">Coming Soon!</h3>
          </center>

        </div>
      </div>

    </div> <!-- container-fluid -->

    <div class="modal fade" id="modal_createSignature" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-plus mr-2"></i>Create Email Signature</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_emailSignature">
              
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="reset" class="btn btn-secondary">clear</button>
            <button type="submit" class="btn btn-primary" form="form_emailSignature">
              <i class="fa fa-save mr-1"></i> Save Signature 
            </button>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.content -->
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
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/tools/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('#nav_marketing').parent('li').addClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_marketing').addClass('active'); // menu
    $('#nav_emailSignature').addClass('active');  // sub-menu

    //topNav icon & label

    let topNav = `<i class="fas fa-tools mr-2"></i>
                  <b>TOOLS</b>`;
    $('#lnk_topNav').html(topNav);

    //methods

    EMAIL_SIGNATURE.loadEmailSignatures();

    $('#lnk_createTemplate').on('click',function(){
      EMAIL_TEMPLATE.loadCategories('slc','#slc_category');
      $('#txt_content').summernote({
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontname','fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ],
        height: 300
      });
      $('#modal_createTemplate').modal('show');
    });

    $('#btn_createTemplate').on('click',function(){
      EMAIL_TEMPLATE.loadCategories('slc','#slc_category');
      $('#txt_content').summernote({
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontname','fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ],
        height: 300
      });
      $('#modal_createTemplate').modal('show');
    });

    $('#form_emailSignature').on('submit',function(e){
      e.preventDefault();
      EMAIL_SIGNATURE.addEmailSignature(this);
    });

    $('.select2').select2();

    
    

    // test codes

    

    $(document).ready( function () {
      $('#myTable').DataTable();
    } );

    // $('body').addClass('layout-footer-fixed');
    // $('body').removeClass('layout-footer-fixed');

    $('#form_email').on('submit',function(e){
      e.preventDefault();

      let formData = new FormData(this);
      $.ajax({
        /*  */
        url : `${baseUrl}submit-sample-email`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          console.log(result);
        }
      });

    });
  });
</script>

@endsection
