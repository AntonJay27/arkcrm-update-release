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
                <a href="<?php echo base_url(); ?>/organizations" class="text-muted">Organizations</a> -
              </span> 
              <small>
                <a href="<?php echo base_url(); ?>/organizations" class="text-muted">All</a>
              </small> 
              @if($organizationId != "")
              <small> - 
                <a href="javascript:void(0)" class="text-muted" id="lnk_organization"></a>
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
                  <a class="dropdown-item" href="javascript:void(0)" id="lnk_addOrganization">
                    <i class="fa fa-plus mr-1"></i>Add Organization
                  </a>
                  <a class="dropdown-item" href="javascript:void(0)" id="lnk_importOrganizations">
                    <i class="fa fa-upload mr-1"></i>Import
                  </a>
                </div>
               @endif
              </div>
              <div class="d-none d-lg-block">
               @if($accessActionsAndFields[1][1] == '1')
                <button type="button" class="btn btn-default btn-sm" id="btn_addOrganization">
                  <i class="fa fa-plus mr-1"></i> Add Organization
                </button>
                <button type="button" class="btn btn-default btn-sm" id="btn_importOrganizations">
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

        <input type="hidden" id="txt_organizationId" name="txt_organizationId" value="{{ $organizationId }}">
        <input type="hidden" id="txt_organizationState" name="txt_organizationState">

        <input type="hidden" id="txt_createOrganization" value="{{ $accessActionsAndFields[1][1] }}">
        <input type="hidden" id="txt_updateOrganization" value="{{ $accessActionsAndFields[1][2] }}">
        <input type="hidden" id="txt_deleteOrganization" value="{{ $accessActionsAndFields[1][3] }}">

        @if($organizationId == "")
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <table id="tbl_organizations" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                  <thead>
                    <tr>
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
                        <img class="profile-user-img img-fluid img-square" id="img_organizationProfilePicture" src="<?php echo base_url(); ?>/public/assets/img/organization-placeholder.png" alt="User Avatar">
                      </span>
                      <div class="info-box-content" style="line-height:1.7">
                        <span class="info-box-text" id="lbl_organizationName" style="font-size: 1.5em;">
                          <!-- Mr. Anton Jay Hermo -->
                        </span>
                        <span class="info-box-text" style="font-size: .9em;" title="Website">
                          <i class="fa fa-globe mr-1"></i>
                          <span id="lbl_organizationWebSite"><!-- Web Developer --></span>
                        </span>
                        <span class="info-box-text" style="font-size: .9em;" title="Email">
                          <i class="fa fa-envelope mr-1"></i>
                          <span id="lbl_organizationEmail"><!-- ajhay.dev@gmail.com --></span>
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
                      <button class="btn btn-sm btn-default" id="btn_editOrganization">
                        <i class="fa fa-pen mr-2"></i>Edit
                      </button>
                     @endif
                      <button class="btn btn-sm btn-default" id="btn_sendEmail">
                        <i class="fa fa-paper-plane mr-2"></i>Send Email
                      </button>
                     @if($accessActionsAndFields[1][3] == '1')
                      <button class="btn btn-sm btn-default text-red" id="btn_removeOrganization">
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
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
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
                    <a class="nav-link" id="lnk_contacts" data-toggle="pill" href="#div_contacts" role="tab" aria-controls="div_contacts" aria-selected="false">Contacts
                      <span class="badge badge-danger ml-1" id="lbl_contactCount">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_activities" data-toggle="pill" href="#div_activities" role="tab" aria-controls="div_activities" aria-selected="false">Activities</a>
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
                              <td class="p-1 text-muted" width="160px;" valign="middle">Organization Name</td>
                              <td class="p-1">
                                <span id="lbl_orgName">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Assigned To</td>
                              <td class="p-1">
                                <span id="lbl_assignedTo">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Billing City</td>
                              <td class="p-1">
                                <span id="lbl_billingCity">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Billing Country</td>
                              <td class="p-1">
                                <span id="lbl_billingCountry">---</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        
                        <hr>

                        <h6>Documents</h6>
                        <table id="tbl_documents" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
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
                        <table id="tbl_activities" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
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
                        <h3 class="card-title">Organization Details</h3>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Organization Name</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Main Website</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other Website</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Phone Number</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Fax</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Facebook</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Twitter</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Industry</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">NAICS Code</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Employee Count</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Annual Revenue</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Type</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Ticket Symbol</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Member Of</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Email Opt Out</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Billing Street</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Billing City</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Billing State</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Billing Zip</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Billing Country</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Shipping Street</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Shipping City</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Shipping State</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Shipping Zip</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Shipping Country</td>
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
                    <div class="card shadow-none">
                      <div class="card-header p-0">
                        <h3 class="card-title">Profile Picture</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        </div>
                      </div>
                      <div class="card-body p-0" style="display: block;">
                        
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="div_updates" role="tabpanel" aria-labelledby="lnk_updates">
                    <div class="timeline timeline-inverse" id="div_organizationUpdates">

                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>

                      <div>
                        <i class="fas fa-envelope bg-primary"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>
                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                          <div class="timeline-body">
                              Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>

                      <div>
                        <i class="fas fa-user bg-info"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                          <h3 class="timeline-header border-0">
                            <a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>

                      <div>
                        <i class="fas fa-comments bg-warning"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>


                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>


                      <div>
                        <i class="fas fa-camera bg-purple"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                          <div class="timeline-body">
                            <!-- <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="..."> -->
                          </div>
                        </div>
                      </div>

                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
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
                  <div class="tab-pane fade" id="div_activities" role="tabpanel" aria-labelledby="lnk_activities">
                    <table id="tbl_organizationActivities" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
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
                    <table id="tbl_organizationEmails" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                      <thead>
                        <tr>
                          <th class="p-2">ID</th>
                          <th class="p-2" data-priority="1">Sender Name</th>
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
                    <table id="tbl_organizationDocuments" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
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
                          <th class="p-2" data-priority="1">Campaign Name</th>
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

      <div class="modal fade" id="modal_organization" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title" id="lbl_stateOrganization">
                <i class="fa fa-plus mr-1"></i> 
                <span>Add Organization</span>
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_organization">
                
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
                              <td class="p-1" width="120px;" valign="middle">Organization *</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_organizationName" name="txt_organizationName" placeholder="(Organization name is regquired)" required>
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
                              <td class="p-1" width="120px;" valign="middle">Primary Email *</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_primaryEmail" name="txt_primaryEmail" placeholder="(e.g. juan@gmail.com)" required>
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
                                <input type="text" class="form-control form-control-sm" id="txt_secondaryEmail" name="txt_secondaryEmail" placeholder="(e.g. juantwo@gmail.com)">
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
                              <td class="p-1" width="120px;" valign="middle">Main Website</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mainWebsite" name="txt_mainWebsite" placeholder="(e.g. https://www.oragon.com)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Website</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherWebsite" name="txt_otherWebsite" placeholder="(e.g. https://www.crm.oragon.com)">
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
                              <td class="p-1" width="120px;" valign="middle">Phone Number</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_phoneNumber" name="txt_phoneNumber" placeholder="(e.g. 09395202340)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Fax</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_fax" name="txt_fax" placeholder="(e.g. 09395202340)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_linkedinUrl" name="txt_linkedinUrl" placeholder="(e.g. xxxxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Facebook</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_facebookUrl" name="txt_facebookUrl" placeholder="(e.g. xxxxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Twitter</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_twitterUrl" name="txt_twitterUrl" placeholder="(e.g. xxxxxxx)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_instagramUrl" name="txt_instagramUrl" placeholder="(e.g. xxxxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Industry</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_industry" name="slc_industry" style="width:100%;">
                                  <option value="">--Select industry--</option>
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
                              <td class="p-1" width="120px;" valign="middle">NAICS Code</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_naicsCode" name="txt_naicsCode" placeholder="(e.g. xxxxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Employee Count</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_employeeCount" name="txt_employeeCount" placeholder="(e.g. 5-10)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Annual Revenue</td>
                              <td class="p-1">
                                <input type="number" class="form-control form-control-sm" id="txt_annualRevenue" name="txt_annualRevenue" placeholder="(e.g. 1,000,000)">
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
                              <td class="p-1" width="120px;" valign="middle">Type</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_type" name="slc_type" style="width:100%;">
                                  <option value="">--Select type--</option>
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
                              <td class="p-1" width="120px;" valign="middle">Ticket Symbol</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_ticketSymbol" name="txt_ticketSymbol" placeholder="(e.g. xxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Member Of</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_memberOf" name="slc_memberOf" style="width:100%;">
                                  <option value="">--Select organization--</option>
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
                    </div>

                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Address Details</h5>
                  </div>
                  <div class="card-body">

                    <div class="row mb-0">
                      <div class="col-lg-4 col-sm-12">
                        <label>Is Billing the same as Shipping?</label>
                      </div>
                      <div class="col-lg-8 col-sm-12">
                        <label class="radio-inline">
                          <input type="radio" class="mr-1" name="rdb_optradio" checked>Yes
                        </label>
                        <label class="radio-inline">
                          <input type="radio" class="mr-1" name="rdb_optradio">No
                        </label>
                      </div>
                      <!-- <div class="col-lg-12 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="220px;" valign="middle">
                                <label>Is Billing the same as Shipping?</label>
                              </td>
                              <td class="p-1">
                                <label class="radio-inline">
                                  <input type="radio" class="mr-1" name="rdb_optradio" checked>Yes
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" class="mr-1" name="rdb_optradio">No
                                </label>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div> -->
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Billing Street</td>
                              <td class="p-1">
                                <textarea class="form-control" rows="3" id="txt_billingStreet" name="txt_billingStreet"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Billing City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_billingCity" name="txt_billingCity">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Billing State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_billingState" name="txt_billingState">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Billing Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_billingZip" name="txt_billingZip">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Billing Country</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_billingCountry" name="txt_billingCountry">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Shipping Street</td>
                              <td class="p-1">
                                <textarea class="form-control" rows="3" id="txt_shippingStreet" name="txt_shippingStreet"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Shipping City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_shippingCity" name="txt_shippingCity">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Shipping State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_shippingState" name="txt_shippingState">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Shipping Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_shippingZip" name="txt_shippingZip">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Shipping Country</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_shippingCountry" name="txt_shippingCountry">
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
                    <textarea class="form-control" rows="5" id="txt_description" name="txt_description"></textarea>
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
                                   src="<?php echo base_url(); ?>/public/assets/img/organization-placeholder.png"
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
                        
                      </div>
                    </div>                    
                  </div>
                </div>

              </form>
                
            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" form="form_organization">Save Organization</button>
            </div>

          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_importOrganizations" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Import Organizations</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_importOrganizations" enctype="multipart/form-data">
               <label>CSV File Only:</label>
                <input type="file" class="form-control" id="file_organizationList" name="file_organizationList" style="padding: 3px 3px 3px 3px !important;" accept=".csv" required>
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
              <a href="<?php echo base_url(); ?>/public/assets/files/OrganizationsCSVFileFormat.xlsx" class="btn btn-default">
               <i class="fa fa-download"></i> Download File Format</a>
              <button type="submit" class="btn btn-primary" id="btn_submitOrganizationList" form="form_importOrganizations">
               <i class="fa fa-save"></i> Upload File</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_sendOrganizationEmail" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-paper-plane mr-2"></i>Send Email</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_sendOrganizationEmail">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <label class="col-form-label text-muted" for="inputError">
                      <i class="fa fa-info-circle"></i> Choose Email Template 
                    </label>
                    <select class="form-control select2" id="slc_emailTemplate" style="width:100%;">
                      <option value="">--Optional--</option>
                    </select>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <label class="col-form-label text-muted" for="inputError">
                      <i class="fa fa-info-circle"></i> Choose Signature
                    </label>
                    <select class="form-control select2" id="slc_emailSignature" style="width:100%;">
                      <option value="">--Optional--</option>
                    </select>
                  </div>
                </div>

                <label class="col-form-label text-muted" for="inputError">
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

                <label class="col-form-label text-muted" for="inputError">
                  <i class="fa fa-info-circle"></i> Subject *
                </label>
                <input type="text" class="form-control form-control-sm" id="txt_subject" name="txt_subject" placeholder="Required" required>
                <label class="col-form-label text-muted" for="inputError">
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
              <button type="button" class="btn btn-secondary">clear</button>
              <button type="submit" class="btn btn-primary" id="btn_sendOrganizationEmail" form="form_sendOrganizationEmail">
                <i class="fa fa-paper-plane mr-1"></i> Send Email
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_addContact" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-user-plus mr-1"></i> Quick Create Contact</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_addContact">
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
                           <td class="p-1" width="120px;" valign="middle">Primary Email</td>
                           <td class="p-1">
                             <input type="text" class="form-control form-control-sm" id="txt_primaryEmail" name="txt_primaryEmail" placeholder="(e.g. juan@gmail.com)">
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
                          <td class="p-1" width="120px;" valign="middle">Company Name</td>
                          <td class="p-1">
                            <select class="form-control select2" id="slc_companyName" name="slc_companyName" style="width:100%;" required>
                              <option value="">--Select Organization--</option>
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
                             <select class="form-control select2" id="slc_assignedToContact" name="slc_assignedToContact" style="width:100%;" required>
                               <option value="">--Select user--</option>
                             </select>
                           </td>
                         </tr>
                       </tbody>
                     </table>
                   </div>
                </div>
              </form>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="submit" class="btn btn-primary" id="btn_saveContact" form="form_addContact">Save</button>
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

              <form id="form_selectContacts">
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
  <script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/rolodex/{{ $customScripts }}.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      //jQuery Events

      //sideNav active/inactive

      $('.nav-item').removeClass('menu-open');
      $('#nav_rolodex').parent('li').addClass('menu-open');
      $('.nav-link').removeClass('active');
      $('#nav_rolodex').addClass('active'); // menu
      $('#nav_organizations').addClass('active');  // sub-menu

      //topNav icon & label

      let topNav = `<i class="fas fa-users mr-2"></i>
                      <b>MARKETING</b>`;
      $('#lnk_topNav').html(topNav);

      //events

      $('.select2').select2();

      $('#btn_addOrganization').on('click',function(){
        ORGANIZATION.loadUsers('#slc_assignedTo');
        ORGANIZATION.loadOrganizations('select','#slc_memberOf');
        $('#lbl_stateOrganization span').text('Add Organization');
        $('#lbl_stateOrganization i').removeClass('fa-pen');
        $('#lbl_stateOrganization i').addClass('fa-plus');
        $('#txt_organizationState').val('add');
        $('#modal_organization').modal({backdrop:'static',keyboard: false});
      });

      $('#btn_importOrganizations').on('click',function(){
        $('#modal_importOrganizations').modal({backdrop:'static',keyboard: false});
      });

      $('#lnk_addOrganization').on('click',function(){
        ORGANIZATION.loadUsers('#slc_assignedTo');
        ORGANIZATION.loadOrganizations('select','#slc_memberOf');
        $('#lbl_stateOrganization span').text('Add Organization');
        $('#lbl_stateOrganization i').removeClass('fa-pen');
        $('#lbl_stateOrganization i').addClass('fa-plus');
        $('#txt_organizationState').val('add');
        $('#modal_organization').modal({backdrop:'static',keyboard: false});
      });

      $('#lnk_importOrganizations').on('click',function(){
        $('#modal_importOrganizations').modal({backdrop:'static',keyboard: false});
      });

      $('#file_profilePicture').on('change',function(){
        ORGANIZATION.uploadOrganizationPicturePreview(this);
      });

      $('#form_organization').on('submit',function(e){
        e.preventDefault();
        ($('#txt_organizationState').val() == "add")? ORGANIZATION.addOrganization(this) : ORGANIZATION.editOrganization(this);
      });

      $('#btn_importOrganizations').on('click',function(){
         $('#lbl_loader').hide();
         $('#div_checkResult').hide();
         $('#lbl_download').hide();
         $('#div_errorResult').hide();
         $('#lbl_uploadingProgress').hide();
         $('#btn_submitOrganizationList').prop('disabled',true);
         $('#modal_importOrganizations').modal({backdrop:'static',keyboard: false});
      });

      $('#lnk_importOrganizations').on('click',function(){
         $('#lbl_loader').hide();
         $('#div_checkResult').hide();
         $('#lbl_download').hide();
         $('#div_errorResult').hide();
         $('#lbl_uploadingProgress').hide();
         $('#btn_submitOrganizationList').prop('disabled',true);
         $('#modal_importOrganizations').modal({backdrop:'static',keyboard: false});
      });

      $('#file_organizationList').on('change',function(){
         ORGANIZATION.checkCSVFile(this);
      });

      $('#form_importOrganizations').on('submit',function(e){
        e.preventDefault();
        ORGANIZATION.uploadOrganizations();
      });

      let organizationId = $('#txt_organizationId').val();
      if(organizationId == "")
      {
        // ===========================================================>
        // load Organizations

        ORGANIZATION.loadOrganizations('table');
      }
      else
      {
        // ===========================================================>
        // select Organization

        $('#lnk_summary').addClass('active');

        ORGANIZATION.selectOrganization('load',organizationId);

        $('#btn_editOrganization').on('click',function(){
          $('#txt_organizationState').val('edit');
          ORGANIZATION.selectOrganization('edit',organizationId);
        });

        $('#btn_sendEmail').on('click',function(){
          ORGANIZATION.selectEmailConfig('organization-form');
        });

        $('#btn_removeOrganization').on('click',function(){
          ORGANIZATION.removeOrganization(organizationId);
        });

        
        ORGANIZATION.loadOrganizationSummary(organizationId);
        ORGANIZATION.loadOrganizationCommentSummary(organizationId);
        $('#lbl_contactCount').prop('hidden',true);
        ORGANIZATION.loadOrganizationContacts(organizationId);
        $('#lbl_emailCount').prop('hidden',true);
        ORGANIZATION.loadOrganizationEmails(organizationId);
        $('#lbl_documentCount').prop('hidden',true);
        ORGANIZATION.loadOrganizationDocuments(organizationId);
        $('#lbl_campaignCount').prop('hidden',true);
        ORGANIZATION.loadOrganizationCampaigns(organizationId);
        $('#lbl_commentCount').prop('hidden',true);
        ORGANIZATION.loadOrganizationComments(organizationId);

        $('#lnk_summary').on('click',function(){
          ORGANIZATION.loadOrganizationSummary(organizationId);
        });

        $('#lnk_details').on('click',function(){
          ORGANIZATION.loadOrganizationDetails(organizationId);
        });

        $('#lnk_updates').on('click',function(){
          ORGANIZATION.loadOrganizationUpdates(organizationId);
        });

        $('#lnk_contacts').on('click',function(){
          ORGANIZATION.loadOrganizationContacts(organizationId);
        });

        $('#lnk_activities').on('click',function(){
          ORGANIZATION.loadOrganizationActivities(organizationId);
        });

        $('#lnk_emails').on('click',function(){
          ORGANIZATION.loadOrganizationEmails(organizationId);
        });

        $('#lnk_documents').on('click',function(){
          ORGANIZATION.loadOrganizationDocuments(organizationId);
        });

        $('#lnk_campaigns').on('click',function(){
          ORGANIZATION.loadOrganizationCampaigns(organizationId);
        });

        $('#lnk_comments').on('click',function(){
          ORGANIZATION.loadOrganizationComments(organizationId);
        });

        // comments
        $('#form_comments').on('submit',function(e){
          e.preventDefault();
          ORGANIZATION.addOrganizationComment(this);
        });

        $('#form_summaryComments').on('submit',function(e){
          e.preventDefault();
          ORGANIZATION.addOrganizationCommentSummary(this);
        });
      }

      $('#form_addContact').on('submit',function(e){
         e.preventDefault();
         ORGANIZATION.addContactToOrganization(this);
      });

      $('#btn_addSelectedContacts').on('click',function(){
        ORGANIZATION.addSelectedContacts();
      });

      $('#btn_addSelectedDocuments').on('click',function(){
        ORGANIZATION.addSelectedDocuments();
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
        ORGANIZATION.addOrganizationDocument(this);
      });

      $('#btn_addSelectedCampaigns').on('click',function(){
        ORGANIZATION.addSelectedCampaign();
      });

      $('#slc_emailTemplate').on('change',function(){
        let organizationId = $('#txt_organizationId').val();
        let templateId = $(this).val();
        ORGANIZATION.selectEmailTemplate(organizationId,templateId);
      });

      $('#form_sendOrganizationEmail').on('submit',function(e){
        e.preventDefault();
        ORGANIZATION.sendOrganizationEmail(this);
      });



    });
  </script>

  @endsection
