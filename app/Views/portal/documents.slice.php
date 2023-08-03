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
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <h6 class="mt-1 float-left">
            <span>
              <a href="<?php echo base_url(); ?>/documents" class="text-muted">Documents</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>/documents" class="text-muted">All</a>
            </small> 
            @if($documentId != "")
            <small> - 
              <a href="javascript:void(0)" class="text-muted" id="lnk_document"></a>
            </small>
            @endif
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
            @if($accessActionsAndFields[1][1] == '1')
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_addDocument">
                  <i class="fa fa-plus mr-1"></i>New Document
                </a>
                <!-- <a class="dropdown-item" href="javascript:void(0)" id="lnk_importUsers">
                  <i class="fa fa-upload mr-1"></i>Import
                </a> -->
              </div>
            @endif
            </div>
            <div class="d-none d-lg-block">
            @if($accessActionsAndFields[1][1] == '1')
              <button type="button" class="btn btn-default btn-sm" id="btn_addDocument">
                <i class="fa fa-plus mr-1"></i>New Document
              </button>
              <!-- <button type="button" class="btn btn-default btn-sm" id="btn_importUsers">
                <i class="fa fa-upload mr-1"></i> Import
              </button> -->
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
      
      <input type="hidden" id="txt_documentId" name="txt_documentId" value="{{ $documentId }}">
      <input type="hidden" id="txt_documentState" name="txt_documentState">

      <input type="hidden" id="txt_createDocument" value="{{ $accessActionsAndFields[1][1] }}">
      <input type="hidden" id="txt_updateDocument" value="{{ $accessActionsAndFields[1][2] }}">
      <input type="hidden" id="txt_deleteDocument" value="{{ $accessActionsAndFields[1][3] }}">

      @if($documentId == "")
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_documents" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2"></th>
                    <th class="p-2 pl-4" data-priority="1">Title</th>
                    <th class="p-2" data-priority="2">File Name</th>
                    <th class="p-2" data-priority="3">Modified Date & Time</th>
                    <th class="p-2">Assigned To</th>
                    <th class="p-2">Download Count</th>
                    <th class="p-2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->

      @else

      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline mb-2">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-4 col-sm-12">
                  <div class="info-box shadow-none bg-light mb-0">
                    <span class="info-box-icon">
                      <!-- <i class="far fa-image"></i> -->
                      <img class="img-square elevation-1" src="<?php echo base_url(); ?>/public/assets/img/document-placeholder.png" alt="User Avatar">
                    </span>
                    <div class="info-box-content" style="line-height:1.7">
                      <span class="info-box-text" id="lbl_documentTitle" style="font-size: 1.5em;">
                        <!-- Mr. Anton Jay Hermo -->
                      </span>
                      <span class="info-box-text" style="font-size: .9em;">
                        <i class="fa fa-clock mr-1" title="Uploaded Last"></i>
                        <span id="lbl_documentUploadedLast"><!-- Web Developer --></span>
                      </span>
                      <span class="info-box-text" style="font-size: .9em;" id="lbl_documentDownload">
                        <!-- <i class="fa fa-download mr-1" title="Download"></i>
                        <span></span> -->
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                  
                </div>
                <div class="col-lg-4 col-sm-12">
                  <div class="d-inline d-lg-none"><hr></div>
                  <div class="form-group mb-0">
                  @if($accessActionsAndFields[1][2] == '1')
                    <button class="btn btn-sm btn-default" id="btn_editDocument">
                      <i class="fa fa-pen mr-2"></i>Edit
                    </button>
                  @endif
                  @if($accessActionsAndFields[1][3] == '1')
                    <button class="btn btn-sm btn-default text-red" id="btn_removeDocument">
                      <i class="fa fa-trash mr-2"></i>Delete Document
                    </button>
                  @endif
                    <!-- <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                      More <i class="nav-icon fas fa-caret-down ml-1"></i> 
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item hover-red" href="javascript:void(0)" id="">
                        <i class="fa fa-plus mr-2"></i>Add Event
                      </a>
                      <a class="dropdown-item" href="javascript:void(0)" id="">
                        <i class="fa fa-plus mr-2"></i>Add Task
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-red" href="javascript:void(0)" id="">
                        <i class="fa fa-trash mr-2"></i>Delete Organization
                      </a>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-1 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="lnk_details" data-toggle="pill" href="#div_details" role="tab" aria-controls="div_details" aria-selected="false">Details</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_updates" data-toggle="pill" href="#div_updates" role="tab" aria-controls="div_updates" aria-selected="false">Updates</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_contacts" data-toggle="pill" href="#div_contacts" role="tab" aria-controls="div_contacts" aria-selected="false">Contacts 
                    <span class="badge badge-danger ml-1" id="lbl_contactCount">0</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_organizations" data-toggle="pill" href="#div_organizations" role="tab" aria-controls="div_organizations" aria-selected="false">Organizations
                    <span class="badge badge-danger ml-1" id="lbl_organizationCount">0</span>
                  </a>
                </li>                
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane fade active show" id="div_details" role="tabpanel" aria-labelledby="lnk_details">
                  <div class="card shadow-none">
                    <div class="card-header p-0">
                      <h3 class="card-title">Basic Information</h3>
                      <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      </div>
                    </div>
                    <div class="card-body p-0" style="display: block;">
                      <div class="row mt-2">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Title</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Assigned To</td>
                                <td class="p-1">
                                  ---
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Folder Name</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Document No.</td>
                                <td class="p-1">
                                  ---
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Created Time</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Modified Time</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="card shadow-none">
                    <div class="card-header p-0">
                      <h3 class="card-title">Description</h3>
                      <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      </div>
                    </div>
                    <div class="card-body p-0" style="display: block;">
                      <div class="row">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12"></div>
                      </div>
                    </div>
                  </div>
                  <div class="card shadow-none">
                    <div class="card-header p-0">
                      <h3 class="card-title">File Details</h3>
                      <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      </div>
                    </div>
                    <div class="card-body p-0" style="display: block;">
                      <div class="row mt-2">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">File Name</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">File Size</td>
                                <td class="p-1">
                                  ---
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">File Type</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Download Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="div_updates" role="tabpanel" aria-labelledby="lnk_updates">
                  <div class="timeline timeline-inverse" id="div_documentUpdates">

                  </div>
                </div>
                <div class="tab-pane fade" id="div_contacts" role="tabpanel" aria-labelledby="lnk_contacts">
                  <table id="tbl_contacts" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                    <thead>
                      <tr>
                        <th class="p-2">ID</th>
                        <th class="p-2" data-priority="1">Salutation</th>
                        <th class="p-2" data-priority="2">First Name</th>
                        <th class="p-2" data-priority="3">Last Name</th>
                        <th class="p-2">Position</th>
                        <th class="p-2">Company Name</th>
                        <th class="p-2">Primary Email</th>
                        <th class="p-2">Assigned To</th>
                        <th class="p-2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="div_organizations" role="tabpanel" aria-labelledby="lnk_organizations">
                  <table id="tbl_organizations" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                    <thead>
                      <tr>
                        <th class="p-2">ID</th>
                        <th class="p-2" data-priority="1">Organization Name</th>
                        <th class="p-2" data-priority="2">Primary Email</th>
                        <th class="p-2" data-priority="3">Website</th>
                        <th class="p-2">State</th>
                        <th class="p-2">City</th>
                        <th class="p-2">Leads</th>
                        <th class="p-2">Assigned To</th>
                        <th class="p-2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      @endif

    </div><!-- /.container flued -->

    <div class="modal fade" id="modal_document" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_stateDocument">
              <i class="fa fa-plus mr-1"></i> 
              <span>Add Document</span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_document">
              <div class="row">
                <div class="col-lg-3 col-sm-12">
                  Title *
                </div>
                <div class="col-lg-9 col-sm-12">
                  <input type="text" class="form-control form-control-sm" id="txt_title" name="txt_title" required>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-lg-3 col-sm-12">
                  Assigned To *
                </div>
                <div class="col-lg-9 col-sm-12">
                  <select class="form-control select2" id="slc_assignedToDocument" name="slc_assignedToDocument" required style="width:100%;">
                    <option value="">--Select user--</option>
                  </select>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-lg-3 col-sm-12">
                  Type
                </div>
                <div class="col-lg-9 col-sm-12">
                  <select class="form-control form-control-sm" id="slc_uploadtype" name="slc_uploadtype" required>
                    <option value="">--Select Type--</option>
                    <option value="1">File Upload</option>
                    <option value="2">Link External Document</option>
                  </select>
                </div>
              </div>
              <div class="row mt-2" id="div_fileName">
                <div class="col-lg-3 col-sm-12">
                  File Name
                </div>
                <div class="col-lg-9 col-sm-12">
                  <input type="file" class="form-control" id="file_fileName" name="file_fileName" style="padding: 3px 3px 3px 3px !important;">
                  <span class="text-danger" id="lbl_fileNameNote"></span>
                </div>
              </div>
              <div class="row mt-2" id="div_fileUrl">
                <div class="col-lg-3 col-sm-12">
                  File URL
                </div>
                <div class="col-lg-9 col-sm-12">
                  <textarea class="form-control form-control-sm" id="txt_fileUrl" name="txt_fileUrl" rows="4"></textarea>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-lg-3 col-sm-12">
                  Notes
                </div>
                <div class="col-lg-9 col-sm-12">
                  <textarea class="form-control form-control-sm" id="txt_notes" name="txt_notes" rows="4"></textarea>
                </div>
              </div>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="submit" class="btn btn-primary" id="btn_addDocument" form="form_document">Save Document</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_selectContact" role="dialog">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-user mr-1"></i> Select Contact</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_selectContactDocuments">
              <table id="tbl_allContacts" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2 pl-4"></th>
                    <th class="p-2 pl-4" data-priority="1">Salutation</th>
                    <th class="p-2" data-priority="2">First Name</th>
                    <th class="p-2" data-priority="3">Last Name</th>
                    <th class="p-2">Position</th>
                    <th class="p-2">Company Name</th>
                    <th class="p-2">Primary Email</th>
                    <th class="p-2">Assigned To</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="button" class="btn btn-primary" id="btn_addSelectedContacts">Add selected contact/s</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_selectOrganization" role="dialog">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-building mr-1"></i> Select Organization</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_selectOrganizationDocuments">
              <table id="tbl_allOrganizations" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2 pl-4"></th>
                    <th class="p-2 pl-4" data-priority="1">Organization Name</th>
                    <th class="p-2" data-priority="2">Primary Email</th>
                    <th class="p-2" data-priority="3">Website</th>
                    <th class="p-2">State</th>
                    <th class="p-2">City</th>
                    <th class="p-2">Leads</th>
                    <th class="p-2">Assigned To</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="button" class="btn btn-primary" id="btn_addSelectedOrganizations">Add selected organization/s</button>
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
    $('#nav_documents').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-folder-open mr-2"></i>
                  <b>DOCUMENTS</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    $('#lnk_addDocument').on('click',function(){
      DOCUMENTS.addDocumentModal();
    });

    $('#btn_addDocument').on('click',function(){
      DOCUMENTS.addDocumentModal();
    });

    $('#slc_uploadtype').on('change',function(){
      let type = $(this).val();
      if(type == 1)
      {
        $('#div_fileName').show();
        $('#div_fileUrl').hide();
        $('#file_fileName').prop('required',true);
        $('#txt_fileUrl').prop('required',false);
      }
      else
      {
        $('#div_fileName').hide();
        $('#div_fileUrl').show();
        $('#file_fileName').prop('required',false);
        $('#txt_fileUrl').prop('required',true);
      }
    });

    $('#form_document').on('submit',function(e){
      e.preventDefault();
      ($('#txt_documentState').val() == "add")? DOCUMENTS.addDocument(this) : DOCUMENTS.editDocument(this);
    });

    let documentId = $('#txt_documentId').val();
    if(documentId == "")
    {
      // ===========================================================>
      // load Documents
      DOCUMENTS.loadDocuments();
    }
    else
    {

      $('#btn_editDocument').on('click',function(){
        $('#txt_documentState').val('edit');
        DOCUMENTS.selectDocument('edit',documentId);
      });

      $('#btn_removeDocument').on('click',function(){
        DOCUMENTS.removeDocument(documentId);
      });

      $('#lnk_details').addClass('active');

      DOCUMENTS.selectDocument('load',documentId);
      DOCUMENTS.loadDocumentDetails(documentId);

      $('#lbl_contactCount').prop('hidden',true);
      DOCUMENTS.loadSelectedContactDocuments(documentId);
      $('#lbl_organizationCount').prop('hidden',true);
      DOCUMENTS.loadSelectedOrganizationDocuments(documentId);

      $('#lnk_details').on('click',function(){
        DOCUMENTS.loadDocumentDetails(documentId);
      });

      $('#lnk_updates').on('click',function(){
        DOCUMENTS.loadDocumentUpdates(documentId);
      });

      $('#lnk_contacts').on('click',function(){
        DOCUMENTS.loadSelectedContactDocuments(documentId);
      });

      $('#lnk_organizations').on('click',function(){
        DOCUMENTS.loadSelectedOrganizationDocuments(documentId);
      });

    }

    $('#btn_addSelectedContacts').on('click',function(){
      DOCUMENTS.addSelectedContact();
    });

    $('#btn_addSelectedOrganizations').on('click',function(){
      DOCUMENTS.addSelectedOrganization();
    });

  });
</script>

@endsection
