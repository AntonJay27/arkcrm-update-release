  @extends('template.layout')

  @section('page_title',$pageTitle)



  @section('custom_styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

  <!-- BS-STEPPER -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bs-stepper/css/bs-stepper.min.css">

  <!-- BS-DUALLISTBOX -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

  <style type="text/css">
    /*INTERNAL STYLES*/
    .tbl tr td
    {
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
                <a href="<?php echo base_url(); ?>/contacts" class="text-muted">Contacts</a> -
              </span> 
              <small>
                <a href="<?php echo base_url(); ?>/contacts" class="text-muted">All</a>
              </small> 
              @if($contactId != "")
              <small> - 
                <a href="javascript:void(0)" class="text-muted" id="lnk_contact"></a>
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
                  <a class="dropdown-item" href="javascript:void(0)" id="lnk_addContacts">
                    <i class="fa fa-plus mr-1"></i>Add Contact
                  </a>
                  <a class="dropdown-item" href="javascript:void(0)" id="lnk_importContacts">
                    <i class="fa fa-upload mr-1"></i>Import
                  </a>
                </div>
               @endif
              </div>
              <div class="d-none d-lg-block">
               @if($accessActionsAndFields[1][1] == '1')
                <button type="button" class="btn btn-default btn-sm" id="btn_addContacts">
                  <i class="fa fa-plus mr-1"></i> Add Contact
                </button>
                <button type="button" class="btn btn-default btn-sm" id="btn_importContacts">
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

        <input type="hidden" id="txt_contactId" name="txt_contactId" value="{{ $contactId }}">
        <input type="hidden" id="txt_contactState" name="txt_contactState">

        <input type="hidden" id="txt_createContact" value="{{ $accessActionsAndFields[1][1] }}">
        <input type="hidden" id="txt_updateContact" value="{{ $accessActionsAndFields[1][2] }}">
        <input type="hidden" id="txt_deleteContact" value="{{ $accessActionsAndFields[1][3] }}">

        @if($contactId == "")
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
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
                        <img class="profile-user-img img-fluid img-square" id="img_contactProfilePicture" src="<?php echo base_url(); ?>/public/assets/img/user-placeholder.png" alt="User Avatar">
                      </span>
                      <div class="info-box-content" style="line-height:1.7">
                        <span class="info-box-text" id="lbl_contactName" style="font-size: 1.5em;">
                          <!-- Mr. Anton Jay Hermo -->
                        </span>
                        <span class="info-box-text" style="font-size: .9em;" title="Position">
                          <i class="fa fa-user-tie mr-1"></i>
                          <span id="lbl_contactPosition"><!-- Web Developer --></span>
                        </span>
                        <span class="info-box-text" style="font-size: .9em;" title="Primary Email">
                          <i class="fa fa-envelope mr-1"></i>
                          <span id="lbl_contactEmail"><!-- ajhay.dev@gmail.com --></span>
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
                      <button class="btn btn-sm btn-default" id="btn_editContact">
                        <i class="fa fa-pen mr-2"></i>Edit
                      </button>
                     @endif
                      <button class="btn btn-sm btn-default" id="btn_sendEmail">
                        <i class="fa fa-paper-plane mr-2"></i>Send Email
                      </button>
                     @if($accessActionsAndFields[1][3] == '1')
                      <button class="btn btn-sm btn-default text-red" id="btn_removeContact">
                        <i class="fa fa-trash mr-2"></i>Delete
                      </button>
                     @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-1 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_summary" data-toggle="pill" href="#div_summary" role="tab" aria-controls="div_summary" aria-selected="true">Summary</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_details" data-toggle="pill" href="#div_details" role="tab" aria-controls="div_details" aria-selected="false">Details</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_updates" data-toggle="pill" href="#div_updates" role="tab" aria-controls="div_updates" aria-selected="false">Updates</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_activities" data-toggle="pill" href="#div_activities" role="tab" aria-controls="div_activities" aria-selected="false">Activities
                      <span class="badge badge-danger ml-1" id="lbl_activityCount">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_emails" data-toggle="pill" href="#div_emails" role="tab" aria-controls="div_emails" aria-selected="false">Emails
                      <span class="badge badge-danger ml-1" id="lbl_emailCount">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_documents" data-toggle="pill" href="#div_documents" role="tab" aria-controls="div_documents" aria-selected="false">Documents
                      <span class="badge badge-danger ml-1" id="lbl_documentCount">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_campaigns" data-toggle="pill" href="#div_campaigns" role="tab" aria-controls="div_campaigns" aria-selected="false">Campaigns
                      <span class="badge badge-danger ml-1" id="lbl_campaignCount">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_comments" data-toggle="pill" href="#div_comments" role="tab" aria-controls="div_comments" aria-selected="false">
                      Comments
                      <span class="badge badge-danger ml-1" id="lbl_commentCount">0</span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane fade active show" id="div_summary" role="tabpanel" aria-labelledby="lnk_summary">
                    <div class="row">
                      <div class="col-lg-4 col-sm-12">
                        <h6>Key Fields</h6>
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">First Name</td>
                              <td class="p-1">
                                <span id="lbl_firstName">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Last Name</td>
                              <td class="p-1">
                                <span id="lbl_lastName">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Position</td>
                              <td class="p-1">
                                <span id="lbl_position">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Organization Name</td>
                              <td class="p-1">
                                <span id="lbl_organizationName">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Assigned To</td>
                              <td class="p-1">
                                <span id="lbl_assignedTo">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Mailing City</td>
                              <td class="p-1">
                                <span id="lbl_mailingCity">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Mailing Country</td>
                              <td class="p-1">
                                <span id="lbl_mailingCountry">---</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        
                        <hr>

                        <h6>Documents</h6>
                        <table id="tbl_summaryDocuments" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                          <tbody>
                            <tr>
                              <td class="p-1"><center>No related documents</center></td>
                            </tr>
                          </tbody>
                        </table>

                        <div class="d-inline d-lg-none"><hr></div>
                      </div>
                      <div class="col-lg-8 col-sm-12">
                        <h6>Activities</h6>
                        <table id="tbl_summaryActivities" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                          <tbody>
                            <tr>
                              <td class="p-1"><center>No pending activities</center></td>
                            </tr>
                          </tbody>
                        </table>
                        <hr>

                        <h6>Comments</h6>
                        <div class="card card-info" style="box-shadow: none;">
                          <form class="form-horizontal" id="form_summaryComments">
                            <div class="card-body" style="padding: 0px;">
                              <textarea class="form-control mb-1" rows="3" id="txt_summaryComments" name="txt_summaryComments" placeholder="Type to compose" required></textarea>
                            </div>
                            <div class="card-footer" style="background-color: white; padding: 0px;">
                              <button type="submit" class="btn btn-sm btn-primary float-right">Post Comment</button>
                            </div>
                          </form>
                        </div>
                        <div class="d-inline d-lg-none"><hr></div>
                        <h6>Recent Comments</h6>
                        <table id="tbl_recentComments" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                          <tbody>
                            <tr>
                              <td class="p-1">
                                <div class="card-comments p-2" id="div_loadCommentSummary" style="background: none;">
                                  <center>No recent comments</center>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="div_details" role="tabpanel" aria-labelledby="lnk_details">
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">First Name</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Last Name</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Position</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Company Name</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Primary Email</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Secondary Email</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Date of Birth</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Intro Letter</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Office Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mobile Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Home Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Secondary Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Fax</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Do not Call</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">LinkedIn</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Twitter</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Facebook</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Instagram</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Lead Source</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Department</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Reports To</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Email Opt Out</td>
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
                        <h3 class="card-title">Address Details</h3>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing Street</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing P.O. Box</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing City</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing State</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing Zip</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing Country</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other Street</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other P.O. Box</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other City</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other State</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other Zip</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other Country</td>
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
                        <h3 class="card-title">Description Details</h3>
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
                  </div>
                  <div class="tab-pane fade" id="div_updates" role="tabpanel" aria-labelledby="lnk_updates">
                    <div class="timeline timeline-inverse" id="div_contactUpdates">
                      
                    </div>
                  </div>
                  <div class="tab-pane fade" id="div_activities" role="tabpanel" aria-labelledby="lnk_activities">
                    <table id="tbl_contactActivities" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                      <thead>
                        <tr>
                          <th class="p-2">ID</th>
                          <th class="p-2 pl-4" data-priority="1">Status</th>
                          <th class="p-2" data-priority="2">Activity Type</th>
                          <th class="p-2" data-priority="3">Subject</th>
                          <th class="p-2">Start Date & Time</th>
                          <th class="p-2">Due Date</th>
                          <th class="p-2">Assigned To</th>
                          <th class="p-2">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="div_emails" role="tabpanel" aria-labelledby="lnk_emails">
                    <table id="tbl_contactEmails" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                      <thead>
                        <tr>
                          <th class="p-2">ID</th>
                          <th class="p-2 pl-4" data-priority="1">Sender Name</th>
                          <th class="p-2" data-priority="2">Subject</th>
                          <th class="p-2" data-priority="3">Parent Record</th>
                          <th class="p-2">Date Sent</th>
                          <th class="p-2">Time Sent</th>
                          <th class="p-2">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="div_documents" role="tabpanel" aria-labelledby="lnk_documents">
                    <table id="tbl_contactDocuments" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
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
                  <div class="tab-pane fade" id="div_campaigns" role="tabpanel" aria-labelledby="lnk_campaigns">
                    <table id="tbl_campaigns" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                      <thead>
                        <tr>
                          <th class="p-2"></th>
                          <th class="p-2 pl-4" data-priority="1">Campaign Name</th>
                          <th class="p-2" data-priority="2">Assigned To</th>
                          <th class="p-2" data-priority="3">Campaign Status</th>
                          <th class="p-2">Campaign Type</th>
                          <th class="p-2">Expected Close Date</th>
                          <th class="p-2">Expected Revenue</th>
                          <th class="p-2">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="div_comments" role="tabpanel" aria-labelledby="lnk_comments">
                    <div class="card card-info" style="box-shadow: none;">
                      <form class="form-horizontal" id="form_comments">
                        <div class="card-body" style="padding: 0px;">
                          <textarea class="form-control mb-1" rows="3" id="txt_comments" name="txt_comments" placeholder="Type to compose" required></textarea>
                        </div>
                        <div class="card-footer" style="background-color: white; padding: 0px;">
                          <button type="submit" class="btn btn-sm btn-primary float-right">Post Comment</button>
                        </div>
                      </form>
                    </div>
                    <hr>
                    <div>
                      <h6>Comments</h6>
                      <div class="card-comments p-2" id="div_loadComments" style="background: none;">
                        <!-- comments here -->
                      </div>

                    </div>
                  </div>
                </div> 
              </div>

            </div>
          </div>
        </div>

        @endif
        
      </div><!-- container-fluid -->

      <div class="modal fade" id="modal_contact" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title" id="lbl_stateContact">
                <i class="fa fa-plus mr-1"></i> 
                <span>Add Contact</span>
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_contacts">
                
                <!-- <input type="hidden" id="txt_contactId" name="txt_contactId">   -->

                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Basic Information - 
                      <small><i class="text-red">All fields with astirisk(*) is required </i></small>
                    </h5>
                  </div>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Salutation</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_salutation" name="slc_salutation">
                                  <option value="" selected>--Salutation--</option>
                                  <option value="Mr.">Mr.</option>
                                  <option value="Ms.">Ms.</option>
                                  <option value="Mrs.">Mrs.</option>
                                  <option value="Dr.">Dr.</option>
                                  <option value="Prof.">Prof.</option>
                                </select>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12"></div>
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
                              <td class="p-1" width="120px;" valign="middle">Position</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_position" name="txt_position" placeholder="(e.g. Web Developer)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Company Name</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_companyName" name="slc_companyName" style="width:100%;">
                                  <option value="">--Select Organization--</option>
                                </select>
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
                              <td class="p-1" width="120px;" valign="middle">Primary Email</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_primaryEmail" name="txt_primaryEmail" placeholder="(e.g. juan@gmail.com)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Secondary Email</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_secondaryEmail" name="txt_secondaryEmail" placeholder="(e.g. juandelacruz@gmail.com)">
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
                              <td class="p-1" width="120px;" valign="middle">Date of Birth</td>
                              <td class="p-1">
                                <input type="date" class="form-control form-control-sm" id="txt_birthDate" name="txt_birthDate" placeholder="(e.g. yyyy/mm/dd)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Intro Letter</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_introLetter" name="slc_introLetter">
                                  <option value="" selected>--Sent or Respond--</option>
                                  <option value="Sent">Sent</option>
                                  <option value="Respond">Respond</option>
                                </select>
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
                              <td class="p-1" width="120px;" valign="middle">Office Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_officePhone" name="txt_officePhone" placeholder="(e.g. +63xxxxxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mobile Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mobilePhone" name="txt_mobilePhone" placeholder="(e.g. +63xxxxxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Home Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_homePhone" name="txt_homePhone" placeholder="(e.g. +63xxxxxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Secondary Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_secondaryPhone" name="txt_secondaryPhone" placeholder="(e.g. +63xxxxxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Fax</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_fax" name="txt_fax" placeholder="(e.g. +63xxxxxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Do not Call</td>
                              <td class="p-1">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" id="chk_doNotCall" name="chk_doNotCall">
                                </div>
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
                              <td class="p-1" width="120px;" valign="middle">LinkedIn</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_linkedinUrl" name="txt_linkedinUrl" placeholder="(e.g. xxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Twitter</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_twitterUrl" name="txt_twitterUrl" placeholder="(e.g. xxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Facebook</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_facebookUrl" name="txt_facebookUrl" placeholder="(e.g. xxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Instagram</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_instagramUrl" name="txt_instagramUrl" placeholder="(e.g. xxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Lead Source</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_leadSource" name="slc_leadSource" style="width:100%;">
                                  <option value="" selected>--Select an option--</option>
                                  <option value="Cold-Call">Cold Call</option>
                                  <option value="Existing-Customer">Existing Customer</option>
                                  <option value="Self-Generated">Self Generated</option>
                                  <option value="Employee">Employee</option>
                                  <option value="Partner">Partner</option>
                                  <option value="Public-Relations">Public Relations</option>
                                  <option value="Direct-Mail">Direct Mail</option>
                                  <option value="Conference">Conference</option>
                                  <option value="Trade-Show">Trade Show</option>
                                  <option value="Web-Site">Web Site</option>
                                  <option value="Word-of-Mouth">Word of Mouth</option>
                                  <option value="Other">Other</option>
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
                              <td class="p-1" width="120px;" valign="middle">Department</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_department" name="txt_department" placeholder="(e.g. IT Department)">
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
                              <td class="p-1" width="120px;" valign="middle">Reports To</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_reportsTo" name="slc_reportsTo" style="width:100%;">
                                  <option value="">--Select user--</option>
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
                              <td class="p-1" width="120px;" valign="middle">Assigned To *</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_assignedTo" name="slc_assignedTo" style="width:100%;" required>
                                  <option value="">--Select user--</option>
                                </select>
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
                              <td class="p-1" width="120px;" valign="middle">Email Opt Out</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_emailOptOut" name="slc_emailOptOut">
                                  <option value="" selected>--Yes or No--</option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12"></div>
                    </div>

                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Address Details</h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Street</td>
                              <td class="p-1">
                                <textarea class="form-control" rows="3" id="txt_mailingStreet" name="txt_mailingStreet"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing P.O. Box</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingPOBox" name="txt_mailingPOBox">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingCity" name="txt_mailingCity">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingState" name="txt_mailingState">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingZip" name="txt_mailingZip">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Country</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingCountry" name="txt_mailingCountry">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Street</td>
                              <td class="p-1">
                                <textarea class="form-control" rows="3" id="txt_otherStreet" name="txt_otherStreet"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other P.O. Box</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherPOBox" name="txt_otherPOBox">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherCity" name="txt_otherCity">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherState" name="txt_otherState">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherZip" name="txt_otherZip">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Country</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherCountry" name="txt_otherCountry">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Description Details</h5>
                  </div>
                  <div class="card-body">
                    <span>Description</span>
                    <textarea class="form-control" rows="5" id="txt_description" name="txt_description">sads</textarea>
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Profile Picture</h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <div class="info-box shadow-none bg-light mb-2">
                          <span class="info-box-icon bg-dark">
                            <div class="text-center bg-light" id="div_imagePreview">
                              <img class="profile-user-img img-fluid img-circle" id="img_profilePicture"
                                   src="<?php echo base_url(); ?>/public/assets/img/user-placeholder.png"
                                   alt="User profile picture">
                            </div>
                          </span>
                          <div class="info-box-content">
                            <div id="div_imageDetails">
                              <span class="info-box-number" id="lbl_fileName">/*************/</span>
                              <span class="info-box-text" id="lbl_fileSize">/*****/</span>
                              <span id="lbl_fileStatus">/*****/</span>
                            </div>
                          </div>
                        </div>
                        <div class="info-box-content">
                          <span class="info-box-number">Note:</span>
                          <span class="info-box-text">Accepted files (.jpg, .png, .jpeg)</span>
                        </div>
                        <input type="file" class="form-control" id="file_profilePicture" name="file_profilePicture" style="padding: 3px 3px 3px 3px !important;" accept="image/*">
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <!-- empty -->
                      </div>
                    </div>                    
                  </div>
                </div>

              </form>
                
            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" form="form_contacts">Save Contact</button>
            </div>

          </div>
        </div>
      </div>

      <!-- <div class="modal fade" id="modal_importContacts" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Import Contacts</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_importContacts" enctype="multipart/form-data">
               <label>CSV File Only:</label>
                <input type="file" class="form-control" id="file_contactList" name="file_contactList" style="padding: 3px 3px 3px 3px !important;" accept=".csv" required>
                <span id="lbl_loader"><br><i>Analizing your file, please wait...</i></span>
                <div class="pt-3" id="div_checkResult">
                  <label>Existing on DB: <span id="lbl_forUpdate"></span></label>
                  <br>
                  <label>For Insert: <span id="lbl_forInsert"></span></label>
                  <br>
                  <label>Conflict Rows: <span id="lbl_conflictRows"></span></label>
                  
                  <p id="lbl_download">
                    Click <a href="#" id="lnk_download" target="_blank">here</a> to download conflict rows.
                  </p>
                </div>
                <div class="pt-3" id="div_errorResult" style="color:red;">
                  <label>Error:</label>
                  <p></p>
                  <br>
                </div>
                <label id="lbl_uploadingProgress" class="text-danger"><i>Uploading in progress, Please wait...</i></label>
              </form>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <a href="<?php echo base_url(); ?>/public/assets/files/ContactsCSVFileFormat.xlsx" class="btn btn-default">
               <i class="fa fa-download"></i> Download File Format</a>
              <button type="submit" class="btn btn-primary" id="btn_submitContactList" form="form_importContacts">
               <i class="fa fa-save"></i> Upload File</button>
            </div>
          </div>
        </div>
      </div> -->

      <div class="modal fade" id="modal_importContacts" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Import Contacts</h5>
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> -->
            </div>
            <div class="modal-body">

              <div class="bs-stepper linear">
                <div class="bs-stepper-header" role="tablist">
                  <div class="step active" data-target="#step1" id="step1Indicator">
                    <button type="button" class="step-trigger" role="tab" aria-controls="step1" id="step1Trigger" aria-selected="true">
                      <span class="bs-stepper-circle">1</span>
                      <span class="bs-stepper-label">Upload CSV File</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#step2" id="step2Indicator">
                    <button type="button" class="step-trigger" role="tab" aria-controls="step2" id="step2Trigger" aria-selected="false" disabled>
                      <span class="bs-stepper-circle">2</span>
                      <span class="bs-stepper-label">Duplicate Handling</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#step3" id="step3Indicator">
                    <button type="button" class="step-trigger" role="tab" aria-controls="step3" id="step3Trigger" aria-selected="false" disabled>
                      <span class="bs-stepper-circle">3</span>
                      <span class="bs-stepper-label">Field Mapping</span>
                    </button>
                  </div>
                </div>
                <div class="bs-stepper-content">

                  <div id="step1" class="content active dstepper-block" role="tabpanel" aria-labelledby="step1Trigger">
                    <div class="container-fluid mt-5">
                      <h6>Import from CSV file</h6>
                      <hr>
                      <form id="form_stepOne">
                        <div class="row">
                          <div class="col-lg-3" style="margin: auto;">
                            <label class="text-muted">Select CSV File Only</label>
                          </div>
                          <div class="col-lg-9">
                            <input type="file" class="form-control" id="file_contactList" name="file_contactList" style="padding: 3px 3px 3px 3px !important;" accept=".csv" required>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-lg-3" style="margin: auto;">
                            <label class="text-muted">Has Header</label>
                          </div>
                          <div class="col-lg-9">
                            <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chk_hasHeader" checked>
                            <label class="form-check-label" for="chk_hasHeader"></label>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div id="step2" class="content" role="tabpanel" aria-labelledby="step2Trigger">
                    <div class="container-fluid mt-5">
                      <h6>Duplicate record handling</h6>
                      <hr>
                      <form id="form_stepTwo">
                        <label class="text-muted">Select how duplicate records should be handled</label>
                        <select class="form-control form-control-sm form-select" id="slc_duplicateHandler" required>
                          <option value="Skip">Skip</option>
                          <option value="Override">Override</option>
                          <option value="Merge">Merge</option>
                        </select>

                        <select multiple="multiple" size="10" name="duallistbox_demo2" class="demo" style="display: none;">
                            <option value="salutation">Salutation</option>
                            <option value="first_name">First Name</option>
                            <option value="last_name">Last Name</option>
                            <option value="position">Position</option>
                            <option value="organization_id">Organization Name</option>
                            <option value="primary_email">Primary Email</option>
                            <option value="secondary_email">Secondary Email</option>
                            <option value="office_phone">Office Phone</option>
                            <option value="mobile_phone">Mobile Phone</option>
                            <option value="home_phone">Home Phone</option>
                            <option value="secondary_phone">Secondary Phone</option>
                            <option value="fax">Fax</option>
                            <option value="date_of_birth">Date of Birth</option>
                            <option value="intro_letter">Intro Letter</option>
                            <option value="linkedin_url">LinkedIn URL</option>
                            <option value="facebook_url">Facebook URL</option>
                            <option value="instagram_url">Instagram URL</option>
                            <option value="twitter_url">Twitter URL</option>
                            <option value="department">Department</option>
                            <option value="mailing_street">Mailing Street</option>
                            <option value="other_street">Other Street</option>
                            <option value="mailing_po_box">Mailing P.O. Box</option>
                            <option value="other_po_box">Other P.O. Box</option>
                            <option value="mailing_city">Mailing City</option>
                            <option value="other_city">Other City</option>
                            <option value="mailing_state">Mailing State</option>
                            <option value="other_state">Other State</option>
                            <option value="mailing_zip">Mailing Postal Code</option>
                            <option value="other_zip">Other Postal Code</option>
                            <option value="mailing_country">Mailing Country</option>
                            <option value="other_country">Other Country</option>
                            <option value="description">Description</option>
                        </select>
                      </form>
                    </div>
                  </div>
                  <div id="step3" class="content" role="tabpanel" aria-labelledby="step3Trigger">
                    <div class="container-fluid mt-5">
                      <h6>Map the columns to CRM fields</h6>
                      <hr>
                      <form id="form_stepThree">
                        <div class="row mb-3">
                          <div class="col-lg-2" style="margin-top:auto; margin-bottom: auto;">
                            <label>Use Save Maps</label>
                          </div>
                          <div class="col-lg-4">
                            <select class="form-control form-control-sm form-select" id="slc_savedMaps">
                              <option value="">--No saved maps</option>
                            </select>
                          </div>
                        </div>
                        <table class="table table-sm table-bordered mb-3" id="tbl_mapping">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>HEADER</th>
                              <th>ROW 1</th>
                              <th>CRM FIELDS</th>
                              <th>DEFAULT VALUE</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>

                        <div class="row">
                          <div class="col-lg-3" style="margin-top:auto; margin-bottom: auto;">
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="chk_saveCustomMapping" checked>
                              <label class="form-check-label" for="chk_saveCustomMapping"> Save as Custom Mapping</label>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <input type="text" class="form-control form-control-sm" id="txt_customMapName" name="txt_customMapName" required>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <div id="div_step1" class="pl-4 pr-4">
                  <button type="button" class="btn btn-primary" id="btn_stepOneNext">Next</button>
                  <button type="button" class="btn btn-danger" id="btn_stepOneCancel">Cancel</button>
              </div>
              <div id="div_step2" class="pl-4 pr-4" hidden>
                  <button type="button" class="btn btn-secondary" id="btn_stepTwoBack">Back</button>
                  <button type="button" class="btn btn-primary" id="btn_stepTwoNext">Next</button>
                  <button type="button" class="btn btn-dark" id="btn_stepTwoSkip">Skip this step</button>
                  <button type="button" class="btn btn-danger" id="btn_stepTwoCancel">Cancel</button>
              </div>
              <div id="div_step3" class="pl-4 pr-4" hidden>
                  <button type="button" class="btn btn-primary" id="btn_stepThreeImport">Import</button>
                  <button type="button" class="btn btn-danger" id="btn_stepThreeCancel">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_sendContactEmail" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-paper-plane mr-2"></i>Send Email</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_sendContactEmail">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <label class="col-form-label text-muted" for="slc_emailTemplate">
                      <i class="fa fa-info-circle"></i> Choose Email Template 
                    </label>
                    <select class="form-control select2" id="slc_emailTemplate" style="width:100%;">
                      <option value="">--Optional--</option>
                    </select>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <label class="col-form-label text-muted" for="slc_emailSignature">
                      <i class="fa fa-info-circle"></i> Choose Signature
                    </label>
                    <select class="form-control select2" id="slc_emailSignature" style="width:100%;">
                      <option value="">--Optional--</option>
                    </select>
                  </div>
                </div>

                <label class="col-form-label text-muted" for="txt_to">
                  <i class="fa fa-info-circle"></i> To *
                </label>
                <div class="input-group">
                  <!-- <div class="input-group-prepend">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Add
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Add Cc</a>
                      <a class="dropdown-item" href="#">Add Bcc</a>
                    </div>
                  </div> -->
                  <input type="text" id="txt_to" name="txt_to" class="form-control form-control-sm" placeholder="Required" required>
                </div>
                <!-- <div class="input-group mt-1">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-default btn-sm">
                    Cc
                    </button>
                  </div>
                  <input type="text" class="form-control form-control-sm" placeholder="Required" required>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-default btn-sm">
                    <i class="fa fa-times text-red"></i>
                    </button>
                  </div>
                </div>
                <div class="input-group mt-1">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-default btn-sm">
                    Bcc
                    </button>
                  </div>
                  <input type="text" class="form-control form-control-sm" placeholder="Required" required>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-default btn-sm">
                    <i class="fa fa-times text-red"></i>
                    </button>
                  </div>
                </div> -->

                <label class="col-form-label text-muted" for="txt_subject">
                  <i class="fa fa-info-circle"></i> Subject *
                </label>
                <input type="text" class="form-control form-control-sm" id="txt_subject" name="txt_subject" placeholder="Required" required>
                <label class="col-form-label text-muted" for="txt_content">
                  <i class="fa fa-info-circle"></i> Content *
                </label>
                <textarea id="txt_content" name="txt_content" required></textarea>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="chk_unsubscribe" name="chk_unsubscribe">
                  <label class="form-check-label" for="chk_unsubscribe">Include unsubscribe link</label>
                </div>

                <hr>
                <div class="card shadow-none">
                  <div class="card-header p-0">
                    <label class="col-form-label text-muted">
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
              <button type="button" class="btn btn-secondary">clear</button>
              <button type="submit" class="btn btn-primary" id="btn_sendContactEmail" form="form_sendContactEmail">
                <i class="fa fa-paper-plane mr-1"></i> Send Email
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_events" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Add Events</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_events">
                <input type="hidden" id="txt_eventId" name="txt_eventId">
                Subject:
                <input type="text" class="form-control form-control-sm" id="txt_eventSubject" name="txt_eventSubject" placeholder="Subject *" required>
                <div class="mb-2"></div>
                Timezone :
                <select class="form-control select2" id="slc_eventTimezone" name="slc_eventTimezone" style="width:100%;" required>
                  <option value="">--Select Timezone--</option>
                </select>
                <div class="mb-2"></div>
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <table width="100%">
                      <tbody>
                        <tr>
                          <td colspan="2">From</td>
                        </tr>
                        <tr>
                          <td>
                            <input type="date" class="form-control form-control-sm" id="txt_eventStartDate" name="txt_eventStartDate">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <input type="time" class="form-control form-control-sm" id="txt_eventStartTime" name="txt_eventStartTime">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <table width="100%">
                      <tbody>
                        <tr>
                          <td colspan="2">To</td>
                        </tr>
                        <tr>
                          <td>
                            <input type="date" class="form-control form-control-sm" id="txt_eventEndDate" name="txt_eventEndDate">
                          </td>                        
                        </tr>
                        <tr>
                          <td>
                            <input type="time" class="form-control form-control-sm" id="txt_eventEndTime" name="txt_eventEndTime">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="mb-2"></div>
                Assigned To *:
                <select class="form-control select2" id="slc_eventAssignedTo" name="slc_eventAssignedTo" style="width:100%;" required>
                  <option value="">--Select User--</option>
                </select>
                <div class="mb-2"></div>
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    Status *:
                    <select class="form-control select2" id="slc_eventStatus" name="slc_eventStatus" style="width:100%;" required>
                      <option value="">--Select Status--</option>
                      <option value="planned">Planned</option>
                      <option value="held">Held</option>
                      <option value="not_held">Not Held</option>
                    </select>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    Type *:
                    <select class="form-control select2" id="slc_eventType" name="slc_eventType" style="width:100%;" required>
                      <option value="">--Select Type--</option>
                      <option value="call">Call</option>
                      <option value="meeting">Meeting</option>
                      <option value="mobile_call">Mobile Call</option>
                    </select>
                  </div>
                </div>                
              </form>
              
            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="reset" class="btn btn-secondary">clear</button>
              <button type="submit" class="btn btn-primary" id="btn_saveEvent" form="form_events">Save Event</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="modal_tasks" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Add Tasks</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_tasks">
                <input type="hidden" id="txt_taskId" name="txt_taskId">
                Subject:
                <input type="text" class="form-control form-control-sm" id="txt_taskSubject" name="txt_taskSubject" placeholder="Subject *" required>
                <div class="mb-2"></div>
                Timezone :
                <select class="form-control select2" id="slc_taskTimezone" name="slc_taskTimezone" style="width:100%;" required>
                  <option value="">--Select Timezone--</option>
                </select>
                <div class="mb-2"></div>
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <table width="100%">
                      <tbody>
                        <tr>
                          <td colspan="2">From</td>
                        </tr>
                        <tr>
                          <td>
                            <input type="date" class="form-control form-control-sm" id="txt_taskStartDate" name="txt_taskStartDate">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <input type="time" class="form-control form-control-sm" id="txt_taskStartTime" name="txt_taskStartTime">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <table width="100%">
                      <tbody>
                        <tr>
                          <td colspan="2">To</td>
                        </tr>
                        <tr>
                          <td>
                            <input type="date" class="form-control form-control-sm" id="txt_taskEndDate" name="txt_taskEndDate">
                          </td>                        
                        </tr>
                        <tr>
                          <td>
                            <input type="time" class="form-control form-control-sm" id="txt_taskEndTime" name="txt_taskEndTime">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="mb-2"></div>
                Assigned To *:
                <select class="form-control select2" id="slc_taskAssignedTo" name="slc_taskAssignedTo" style="width:100%;" required>
                  <option value="">--Select User--</option>
                </select>
                <div class="mb-2"></div>
                Status *:
                <select class="form-control select2" id="slc_taskStatus" name="slc_taskStatus" style="width:100%;" required>
                  <option value="">--Select Status--</option>
                  <option value="not_started">Not Started</option>                
                  <option value="in_progress">In Progress</option>                
                  <option value="completed">Completed</option>                
                  <option value="pending_input">Pending Input</option>                
                  <option value="deferred">Deferred</option>                
                  <option value="planned">Planned</option>                
                </select>
              </form>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="reset" class="btn btn-secondary">clear</button>
              <button type="submit" class="btn btn-primary" id="btn_saveTask" form="form_tasks">Save Task</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_selectDocuments" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-file mr-1"></i> Select Documents</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_selectDocuments">
                <table id="tbl_allDocuments" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                  <thead>
                    <tr>
                      <th class="p-2 pl-4"></th>
                      <th class="p-2 pl-4" data-priority="1">Title</th>
                      <th class="p-2" data-priority="2">File</th>
                      <th class="p-2" data-priority="3">Modified Date & Time</th>
                      <th class="p-2">Assigned To</th>
                      <th class="p-2">Download Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </form>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="button" class="btn btn-primary" id="btn_addSelectedDocuments">Add selected document/s</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_addDocument" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Add Document</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_addDocument">
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
                    <select class="form-control form-control-sm" id="slc_uploadtype" name="slc_uploadtype">
                      <option>--Select Type--</option>
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
              <button type="submit" class="btn btn-primary" id="btn_addDocument" form="form_addDocument">Save Document</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_selectCampaigns" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-bullhorn mr-1"></i> Select Campaigns</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_selectCampaigns">
                <table id="tbl_allCampaigns" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                  <thead>
                    <tr>
                      <th class="p-2 pl-4"></th>
                      <th class="p-2 pl-4" data-priority="1">Campaign Name</th>
                      <th class="p-2" data-priority="2">Assigned To</th>
                      <th class="p-2" data-priority="3">Campaign Status</th>
                      <th class="p-2">Campaign Type</th>
                      <th class="p-2">Expected Close Date</th>
                      <th class="p-2">Expected Revenue</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </form>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="button" class="btn btn-primary" id="btn_addSelectedCampaigns">Add selected campaign/s</button>
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

  <!-- BS STEPPER -->
  <script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bs-stepper/js/bs-stepper.min.js"></script>

  <!-- BS DUALLISTBOX -->
  <script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

  <!-- Custom Scripts -->
  <script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/rolodex/{{ $customScripts }}.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      //jQuery Events

      //sideNav active/inactive

      $('.nav-item').removeClass('menu-open');
      $('#nav_rolodex').parent('li').addClass('menu-open');
      $('.nav-link').removeClass('active');
      $('#nav_rolodex').addClass('active'); // menu
      $('#nav_contacts').addClass('active');  // sub-menu

      //topNav icon & label

      let topNav = `<i class="fas fa-address-book mr-2"></i>
                    <b>ROLODEX</b>`;
      $('#lnk_topNav').html(topNav);

      //events

      $('.select2').select2();

      $('#btn_addContacts').on('click',function(){
        CONTACTS.loadUsers('#slc_reportsTo');
        CONTACTS.loadUsers('#slc_assignedTo');
        CONTACTS.loadOrganizations('#slc_companyName');
        $('#lbl_stateContact span').text('Add Contact');
        $('#lbl_stateContact i').removeClass('fa-pen');
        $('#lbl_stateContact i').addClass('fa-plus');
        $('#txt_contactState').val('add');        
        $('#modal_contact').modal({backdrop:'static',keyboard: false});
      });

      $('#lnk_addContacts').on('click',function(){
        CONTACTS.loadUsers('#slc_reportsTo');
        CONTACTS.loadUsers('#slc_assignedTo');
        CONTACTS.loadOrganizations('#slc_companyName');
        $('#lbl_stateContact span').text('Add Contact');
        $('#lbl_stateContact i').removeClass('fa-pen');
        $('#lbl_stateContact i').addClass('fa-plus');
        $('#txt_contactState').val('add');
        $('#modal_contact').modal({backdrop:'static',keyboard: false});
      });

      $('#file_profilePicture').on('change',function(){
        CONTACTS.uploadContactPicturePreview(this);
      });

      $('#form_contacts').on('submit',function(e){
        e.preventDefault();
        ($('#txt_contactState').val() == "add")? CONTACTS.addContact(this) : CONTACTS.editContact(this);
      });

      $('#btn_importContacts').on('click',function(){
         $('#modal_importContacts').modal({backdrop:'static',keyboard: false});
         var demo2 = $('.demo').bootstrapDualListbox({
           nonSelectedListLabel: 'Non-selected',
           selectedListLabel: 'Selected',
           preserveSelectionOnMove: 'moved',
           moveOnSelect: false,
           selectorMinimalHeight: 200
         });
      });

      $('#lnk_importContacts').on('click',function(){
         $('#modal_importContacts').modal({backdrop:'static',keyboard: false});
         var demo2 = $('.demo').bootstrapDualListbox({
           nonSelectedListLabel: 'Non-selected',
           selectedListLabel: 'Selected',
           preserveSelectionOnMove: 'moved',
           moveOnSelect: false,
           selectorMinimalHeight: 200
         });
      });

      $('#btn_stepOneNext').on('click',function(){
        CONTACTS.uploadFile();
      });

      $('#btn_stepOneCancel').on('click',function(){
        CONTACTS.stepOneCancel();
      });

      $('#btn_stepTwoBack').on('click',function(){
        CONTACTS.backToStepOne();
      });

      $('#btn_stepTwoNext').on('click',function(){
        CONTACTS.duplicateHandling();
      });

      $('#btn_stepTwoSkip').on('click',function(){
        CONTACTS.skipDuplicateHandling();
      });

      $('#btn_stepTwoCancel').on('click',function(){
        CONTACTS.stepTwoCancel();
      });

      $('#btn_stepThreeBack').on('click',function(){
        CONTACTS.backToStepTwo();
      });

      $('#btn_stepThreeImport').on('click',function(){
        CONTACTS.importContacts();
      });

      $('#btn_stepThreeCancel').on('click',function(){
        CONTACTS.stepThreeCancel();
      });

      // $('#file_contactList').on('change',function(){
      //    CONTACTS.checkCSVFile(this);
      // });

      // $('#form_importContacts').on('submit',function(e){
      //   e.preventDefault();
      //   CONTACTS.uploadContacts();
      // });

      let contactId = $('#txt_contactId').val();
      if(contactId == "")
      {
        // ===========================================================>
        // load Contacts

        CONTACTS.loadContacts();
      }
      else
      {
        // ===========================================================>
        // select Contact

        $('#lnk_summary').addClass('active');

        CONTACTS.selectContact('load',contactId);
        
        $('#btn_editContact').on('click',function(){
          $('#txt_contactState').val('edit');
          CONTACTS.selectContact('edit',contactId);
        });

        $('#btn_sendEmail').on('click',function(){
          CONTACTS.selectEmailConfig('contact-form');
        });

        $('#btn_removeContact').on('click',function(){
          CONTACTS.removeContact(contactId);
        });

        CONTACTS.loadContactSummary(contactId);
        CONTACTS.loadContactCommentSummary(contactId);
        $('#lbl_activityCount').prop('hidden',true);
        CONTACTS.loadContactActivities(contactId);
        $('#lbl_emailCount').prop('hidden',true);
        CONTACTS.loadContactEmails(contactId);
        $('#lbl_documentCount').prop('hidden',true);
        CONTACTS.loadContactDocuments(contactId);
        $('#lbl_campaignCount').prop('hidden',true);
        CONTACTS.loadContactCampaigns(contactId);
        $('#lbl_commentCount').prop('hidden',true);
        CONTACTS.loadContactComments(contactId);

        $('#lnk_summary').on('click',function(){
          CONTACTS.loadContactSummary(contactId);
          CONTACTS.loadContactCommentSummary(contactId);
        });

        $('#lnk_details').on('click',function(){
          CONTACTS.loadContactDetails(contactId);
        });

        $('#lnk_updates').on('click',function(){
          CONTACTS.loadContactUpdates(contactId);
        });

        $('#lnk_activities').on('click',function(){
          CONTACTS.loadContactActivities(contactId);
        });

        $('#lnk_emails').on('click',function(){
          CONTACTS.loadContactEmails(contactId);
        });

        $('#lnk_documents').on('click',function(){
          CONTACTS.loadContactDocuments(contactId);
        });

        $('#lnk_campaigns').on('click',function(){
          CONTACTS.loadContactCampaigns(contactId);
        });

        $('#lnk_comments').on('click',function(){
          CONTACTS.loadContactComments(contactId);
        });


        // comments
        $('#form_comments').on('submit',function(e){
          e.preventDefault();
          CONTACTS.addContactComment(this);
        });

        $('#form_summaryComments').on('submit',function(e){
          e.preventDefault();
          CONTACTS.addContactCommentSummary(this);
        });

      }

      $('#btn_addSelectedDocuments').on('click',function(){
        CONTACTS.addSelectedDocuments();
      });

      $('#slc_uploadtype').on('change',function(){
        let type = $(this).val();
        if(type == 1)
        {
          $('#div_fileName').show();
          $('#div_fileUrl').hide();
        }
        else
        {
          $('#div_fileName').hide();
          $('#div_fileUrl').show();
        }
      });

      $('#form_addDocument').on('submit',function(e){
        e.preventDefault();
        CONTACTS.addContactDocument(this);
      });

      $('#btn_addSelectedCampaigns').on('click',function(){
        CONTACTS.addSelectedCampaigns();
      });

      $('#slc_emailTemplate').on('change',function(){
        let contactId = $('#txt_contactId').val();
        let templateId = $(this).val();
        CONTACTS.selectEmailTemplate(contactId,templateId);
      });

      $('#form_sendContactEmail').on('submit',function(e){
        e.preventDefault();
        CONTACTS.sendContactEmail(this);
      });





      //test code for uploading pdf
      $('#form_importContacts').on('submit',function(e){
        e.preventDefault();
        CONTACTS.uploadPdf(this);
      });  

      

      // test codes

      $('#summernote').summernote({height: 300});

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
          url : `${baseUrl}/submit-sample-email`,
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
