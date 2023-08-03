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
              <a href="<?php echo base_url(); ?>/email-template" class="text-muted">Email Templates</a>
            </span>
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
            @if($accessActionsAndFields[1][1] == '1')
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_createTemplate">
                  <i class="fa fa-plus mr-1"></i>Create Template
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_importTemplate">
                  <i class="fa fa-upload mr-1"></i>Import
                </a>
              </div>
            @endif
            </div>
            <div class="d-none d-lg-block">
            @if($accessActionsAndFields[1][1] == '1')
              <button type="button" class="btn btn-default btn-sm" id="btn_createTemplate">
                <i class="fa fa-plus mr-1"></i> Create Template
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_importTemplate">
                <i class="fa fa-upload mr-1"></i> Import
              </button>
            @endif
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

      <input type="hidden" id="txt_createEmailTemplate" value="{{ $accessActionsAndFields[1][1] }}">
      <input type="hidden" id="txt_updateEmailTemplate" value="{{ $accessActionsAndFields[1][2] }}">
      <input type="hidden" id="txt_deleteEmailTemplate" value="{{ $accessActionsAndFields[1][3] }}">
      
      <div class="card card-primary card-outline">
        <div class="card-body">
          <table id="tbl_emailTemplates" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
            <thead>
              <tr>
                <th class="p-2 pl-4" data-priority="1">Name/Code</th>
                <th class="p-2" data-priority="2">Category</th>
                <th class="p-2" data-priority="3">Owner</th>
                <th class="p-2">Subject</th>
                <th class="p-2">Type</th>
                <th class="p-2">Status</th>
                <th class="p-2">Date Created</th>
                <th class="p-2">Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>

    </div> <!-- container-fluid -->

    <div class="modal fade" id="modal_emailTemplate" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_stateTemplate">
              <i class="fa fa-plus mr-2"></i>
              <span>Create Email Template</span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_emailTemplate">

              <input type="hidden" id="txt_templateId" name="txt_templateId">

              <div class="row">
                <div class="col-lg-4 col-sm-12">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Template Name/Code *
                  </label>
                  <input type="text" class="form-control form-control-sm" id="txt_templateName" name="txt_templateName" required> 
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Category * 
                  </label>
                  <select class="form-control form-control-sm" id="slc_category" name="slc_category" required>
                    <option value="">--Select Category</option>
                    <option value="All">All</option>
                    <option value="Contacts">Contacts</option>
                    <option value="Organizations">Organizations</option>
                  </select>
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Type *
                  </label>
                  <select class="form-control form-control-sm" id="slc_templateVisibility" name="slc_templateVisibility">
                    <option value="">--Select Type--</option>
                    <option value="Personal">Personal</option>
                    <option value="Corporate">Corporate</option>
                    <option value="System">System</option>
                  </select>
                </div>
              </div>
              <label class="col-form-label text-muted" for="inputError">
                <i class="fa fa-info-circle"></i> Description 
              </label>
              <textarea class="form-control form-control-sm" rows="4" id="txt_description" name="txt_description" placeholder="Description (optional)"></textarea>
              <hr>
              <label class="col-form-label text-muted" for="inputError">
                <i class="fa fa-info-circle"></i> Subject *
              </label>
              <input type="text" class="form-control form-control-sm" id="txt_subject" name="txt_subject" required>
              <label class="col-form-label text-muted" for="inputError">
                <i class="fa fa-info-circle"></i> Content *
              </label>
              <textarea id="txt_content" name="txt_content" required></textarea>

              <hr>
              <div class="card shadow-none">
                <div class="card-header p-0">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Possible Substitutions 
                  </label>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <div class="card-body p-0" style="display: block;">
                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <table class="table table-striped" id="tbl_contactSubstitutions">
                        <thead>
                          <tr>
                            <th><h5>Substitutions for Contacts</h5></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table table-striped" id="tbl_organizationSubstitutions">
                        <thead>
                          <tr>
                            <th><h5>Substitutions for Organizations</h5></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="reset" class="btn btn-secondary">clear</button>
            <button type="submit" class="btn btn-primary" form="form_emailTemplate">
              <i class="fa fa-save mr-1"></i> Save Template 
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

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/marketing/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('#nav_marketing').parent('li').addClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_marketing').addClass('active'); // menu
    $('#nav_emailTemplate').addClass('active');  // sub-menu

    //topNav icon & label

    let topNav = `<i class="fas fa-tools mr-2"></i>
                  <b>TOOLS</b>`;
    $('#lnk_topNav').html(topNav);

    $('.select2').select2();

    //methods

    EMAIL_TEMPLATE.loadTemplates();

    $('#lnk_createTemplate').on('click',function(){
      $('#lbl_stateTemplate span').text('Create Email Template');
      $('#lbl_stateTemplate i').removeClass('fa-pen');
      $('#lbl_stateTemplate i').addClass('fa-plus');

      $('#txt_templateId').val('');

      $('#txt_templateName').val('');
      $('#slc_category').val('');
      $('#slc_templateVisibility').val('');
      $('#txt_description').val('');

      $('#txt_subject').val('');
      $('#txt_content').summernote('destroy');
      $('#txt_content').val('');
      $('#txt_content').summernote(summernoteConfig);

      EMAIL_TEMPLATE.loadContactSubstitutions();
      EMAIL_TEMPLATE.loadOrganizationSubstitutions();

      $('#modal_emailTemplate').modal('show');
    });

    $('#btn_createTemplate').on('click',function(){
      $('#lbl_stateTemplate span').text('Create Email Template');
      $('#lbl_stateTemplate i').removeClass('fa-pen');
      $('#lbl_stateTemplate i').addClass('fa-plus');

      $('#txt_templateId').val('');
      
      $('#txt_templateName').val('');
      $('#slc_category').val('');
      $('#slc_templateVisibility').val('');
      $('#txt_description').val('');

      $('#txt_subject').val('');
      $('#txt_content').summernote('destroy');
      $('#txt_content').val('');
      $('#txt_content').summernote(summernoteConfig);

      EMAIL_TEMPLATE.loadContactSubstitutions();
      EMAIL_TEMPLATE.loadOrganizationSubstitutions();

      $('#modal_emailTemplate').modal('show');
    });

    $('#form_emailTemplate').on('submit',function(e){
      e.preventDefault();
      let templateId = $('#txt_templateId').val();
      (templateId == "")? EMAIL_TEMPLATE.addTemplate(this) : EMAIL_TEMPLATE.editTemplate(this);
    });

    

    
    

    // test codes

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
