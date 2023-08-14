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
              <a href="<?php echo base_url(); ?>/campaigns" class="text-muted">Campaigns</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>/campaigns" class="text-muted">All</a>
            </small> 
            @if($campaignId != "")
            <small> - 
              <a href="javascript:void(0)" class="text-muted" id="lnk_campaign"></a>
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
                   <a class="dropdown-item" href="javascript:void(0)" id="lnk_addCampaign">
                     <i class="fa fa-plus mr-1"></i>Add Campaign
                   </a>
                   <a class="dropdown-item" href="javascript:void(0)" id="lnk_importCampaigns">
                     <i class="fa fa-upload mr-1"></i>Import
                   </a>
                 </div>
               @endif
            </div>
            <div class="d-none d-lg-block">
               @if($accessActionsAndFields[1][1] == '1')
                 <button type="button" class="btn btn-default btn-sm" id="btn_addCampaign">
                   <i class="fa fa-plus mr-1"></i> Add Campaign
                 </button>
                 <button type="button" class="btn btn-default btn-sm" id="btn_importCampaigns">
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

      <input type="hidden" id="txt_campaignId" name="txt_campaignId" value="{{ $campaignId }}">
      <input type="hidden" id="txt_campaignState" name="txt_campaignState">

      <input type="hidden" id="txt_createCampaign" value="{{ $accessActionsAndFields[1][1] }}">
      <input type="hidden" id="txt_updateCampaign" value="{{ $accessActionsAndFields[1][2] }}">
      <input type="hidden" id="txt_deleteCampaign" value="{{ $accessActionsAndFields[1][3] }}">

      @if($campaignId == "")
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_campaigns" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2" data-priority="1">Campaign Name</th>
                    <th class="p-2" data-priority="2">Campaign Type</th>
                    <th class="p-2" data-priority="3">Campaign Status</th>
                    <th class="p-2">Expected Revenue</th>
                    <th class="p-2">Expected Close Date</th>
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
                      <img class="img-square elevation-1" src="<?php echo base_url(); ?>/public/assets/img/campaign-placeholder.png" alt="User Avatar">
                    </span>
                    <div class="info-box-content" style="line-height:1.7">
                      <span class="info-box-text" id="lbl_campaignName" style="font-size: 1.5em;">
                        <!-- Mr. Anton Jay Hermo -->
                      </span>
                      <span class="info-box-text" style="font-size: .9em;" title="Campaign Status">
                        <i class="fa fa-clone mr-1"></i>
                        <span id="lbl_campaignStatus"><!-- Web Developer --></span>
                      </span>
                      <span class="info-box-text" style="font-size: .9em;" title="Expected Close Date">
                        <i class="fa fa-calendar mr-1"></i>
                        <span id="lbl_expectedCloseDate"><!-- ajhay.dev@gmail.com --></span>
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
                       <button class="btn btn-sm btn-default" id="btn_editCampaign">
                         <i class="fa fa-pen mr-2"></i>Edit
                       </button>
                     @endif
                     @if($accessActionsAndFields[1][3] == '1')
                       <button class="btn btn-sm btn-default text-red" id="btn_deleteCampaign">
                         <i class="fa fa-trash mr-2"></i>Delete Campaign
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
                  <a class="nav-link" id="lnk_activities" data-toggle="pill" href="#div_activities" role="tab" aria-controls="div_activities" aria-selected="false">Activities</a>
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
                      <h3 class="card-title">Campaign Details</h3>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Campaign Name</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Campaign Status</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Campaign Type</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Product</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Target Audience</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Close Date</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Sponsor</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Target Size</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Created Time</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Num Sent</td>
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
                      <h3 class="card-title">Expectations & Actuals</h3>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Budget Cost</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Response</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Sales Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Response Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected ROI</td>
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
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual Cost</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Revenue</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual Sales Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual Response Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual ROI</td>
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
                  <div class="timeline timeline-inverse" id="div_campaignUpdates">

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
                  <table id="tbl_campaignActivities" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
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
      
    </div><!-- container-fluid -->

    <div class="modal fade" id="modal_campaign" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_stateCampaign">
              <i class="fa fa-plus mr-1"></i> 
              <span>Add Campaign</span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_campaign">
              
              <!-- <input type="hidden" id="txt_contactId" name="txt_contactId">   -->

              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">Campaign Details - 
                    <small><i class="text-red">All fields with astirisk(*) is required </i></small>
                  </h5>
                </div>
                <div class="card-body">

                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="150px;" valign="middle">Campaign Name *</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_campaignName" name="txt_campaignName" placeholder="(Campaign name is regquired)" required>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="150px;" valign="middle">Assigned To *</td>
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
                            <td class="p-1" width="150px;" valign="middle">Campaign Status</td>
                            <td class="p-1">
                              <select class="form-control form-control-sm" id="slc_campaignStatus" name="slc_campaignStatus">
                                <option value="" selected>--Select campaign status--</option>
                                <option value="Planning">Planning</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
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
                            <td class="p-1" width="150px;" valign="middle">Campaign Type</td>
                            <td class="p-1">
                              <select class="form-control form-control-sm" id="slc_campaignType" name="slc_campaignType">
                                <option value="" selected>--Select campaign type--</option>
                                <option value="Conference">Conference</option>
                                <option value="Webinar">Webinar</option>
                                <option value="Trade Show">Trade Show</option>
                                <option value="Public Relations">Public Relations</option>
                                <option value="Partners">Partners</option>
                                <option value="Referral Program">Referral Program</option>
                                <option value="Advertisement">Advertisement</option>
                                <option value="Banner Ads">Banner Ads</option>
                                <option value="Direct Mail">Direct Mail</option>
                                <option value="Primary Email">Primary Email</option>
                                <option value="Telemarketing">Telemarketing</option>
                                <option value="Others">Others</option>
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
                            <td class="p-1" width="150px;" valign="middle">Product</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_product" name="txt_product" placeholder="(e.g. Product)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="150px;" valign="middle">Target Audience</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_targetAudience" name="txt_targetAudience" placeholder="(e.g. Target Audience)">
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
                            <td class="p-1" width="150px;" valign="middle">Expected Close Date *</td>
                            <td class="p-1">
                              <input type="date" class="form-control form-control-sm" id="txt_expectedCloseDate" name="txt_expectedCloseDate" placeholder="(e.g. YYYY-mm-dd)" required>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="150px;" valign="middle">Sponsor</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_sponsor" name="txt_sponsor" placeholder="(e.g. Sponsor)">
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
                            <td class="p-1" width="150px;" valign="middle">Target Size</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_targetSize" name="txt_targetSize" placeholder="(e.g. xxxxxxx)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="150px;" valign="middle">Num Sent</td>
                            <td class="p-1">
                              <input type="number" class="form-control form-control-sm" id="txt_numSent" name="txt_numSent" placeholder="(e.g. xxxxxxx)">
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
                  <h5 class="m-0">Expectations & Actuals</h5>
                </div>
                <div class="card-body">
                  
                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Budget Cost</td>
                            <td class="p-1">
                              <input type="number" class="form-control form-control-sm" id="txt_budgetCost" name="txt_budgetCost">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Expected Response</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_expectedResponse" name="txt_expectedResponse">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Expected Sales Count</td>
                            <td class="p-1">
                              <input type="number" class="form-control form-control-sm" id="txt_expectedSalesCount" name="txt_expectedSalesCount">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Expected Response Count</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_expectedResponseCount" name="txt_expectedResponseCount">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Expected ROI</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_expectedROI" name="txt_expectedROI">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Actual Cost</td>
                            <td class="p-1">
                              <input type="number" class="form-control form-control-sm" id="txt_actualCost" name="txt_actualCost">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Expected Revenue</td>
                            <td class="p-1">
                              <input type="number" class="form-control form-control-sm" id="txt_expectedRevenue" name="txt_expectedRevenue">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Actual Sales Count</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_actualSalesCount" name="txt_actualSalesCount">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Actual Response Count</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_actualResponseCount" name="txt_actualResponseCount">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="180px;" valign="middle">Actual ROI</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_actualROI" name="txt_actualROI">
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

            </form>
              
          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_saveCampaign" form="form_campaign">Save Campaign</button>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_importCampaigns" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Import Campaigns</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_importCampaigns">
              <center><h4 class="text-red">! Under construction</h4></center>
              <input type="file" class="form-control" style="padding: 3px 3px 3px 3px !important;" name="file_pdf" accept=".pdf">
              <a href="javascript:void(0)"><i>Download file format</i></a>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="reset" class="btn btn-secondary">clear</button>
            <button type="submit" class="btn btn-primary" form="form_importCampaigns">Upload File</button>
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

            <form id="form_selectCampaigns">
              <table id="tbl_allContacts" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2"></th>
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

            <form id="form_selectCampaigns">
              <table id="tbl_allOrganizations" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2"></th>
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
<script src="<?php echo base_url(); ?>/public/assets/js/portal/marketing/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('#nav_marketing').parent('li').addClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_marketing').addClass('active'); // menu
    $('#nav_campaigns').addClass('active');  // sub-menu

    //topNav icon & label

    let topNav = `<i class="fas fa-bullhorn mr-2"></i>
                    <b>MARKETING</b>`;
    $('#lnk_topNav').html(topNav);

    //events

    $('.select2').select2();

    $('#btn_addCampaign').on('click',function(){
      CAMPAIGN.loadUsers('#slc_assignedTo');
      CAMPAIGN.loadCampaigns('select');
      $('#lbl_stateCampaign span').text('Add Campaign');
      $('#lbl_stateCampaign i').removeClass('fa-pen');
      $('#lbl_stateCampaign i').addClass('fa-plus');
      $('#txt_campaignState').val('add');
      $('#modal_campaign').modal({backdrop:'static',keyboard: false});
    });

    $('#btn_importCampaigns').on('click',function(){
      $('#modal_importCampaigns').modal({backdrop:'static',keyboard: false});
    });

    $('#lnk_addCampaign').on('click',function(){
      CAMPAIGN.loadUsers('#slc_assignedTo');
      CAMPAIGN.loadCampaigns('select');
      $('#lbl_stateCampaign span').text('Add Campaign');
      $('#lbl_stateCampaign i').removeClass('fa-pen');
      $('#lbl_stateCampaign i').addClass('fa-plus');
      $('#txt_campaignState').val('add');
      $('#modal_campaign').modal({backdrop:'static',keyboard: false});
    });

    $('#lnk_importCampaigns').on('click',function(){
      $('#modal_importCampaigns').modal({backdrop:'static',keyboard: false});
    });

    $('#form_campaign').on('submit',function(e){
      e.preventDefault();
      ($('#txt_campaignState').val() == "add")? CAMPAIGN.addCampaign(this) : CAMPAIGN.editCampaign(this);
    });

    let campaignId = $('#txt_campaignId').val();
    if(campaignId == "")
    {
      // ===========================================================>
      // load Campaigns
      CAMPAIGN.loadCampaigns('table');
    }
    else
    {
      // ===========================================================>
      // select Campaign

      $('#lnk_details').addClass('active');

      CAMPAIGN.selectCampaign('load',campaignId);

      $('#btn_editCampaign').on('click',function(){
        $('#txt_campaignState').val('edit');
        CAMPAIGN.selectCampaign('edit',campaignId);
      });

      $('#btn_deleteCampaign').on('click',function(){
        CAMPAIGN.removeCampaign(campaignId);
      });

      CAMPAIGN.loadCampaignDetails(campaignId);

      $('#lbl_contactCount').prop('hidden',true);
      CAMPAIGN.loadSelectedContactCampaigns(campaignId);
      $('#lbl_organizationCount').prop('hidden',true);
      CAMPAIGN.loadSelectedOrganizationCampaigns(campaignId);

      $('#lnk_details').on('click',function(){

      });

      $('#lnk_updates').on('click',function(){
        CAMPAIGN.loadCampaignUpdates(campaignId);
      });

      $('#lnk_contacts').on('click',function(){
        CAMPAIGN.loadSelectedContactCampaigns(campaignId);
      });

      $('#lnk_activities').on('click',function(){
        CAMPAIGN.loadCampaignActivities(campaignId);
      });

      $('#lnk_organizations').on('click',function(){
        CAMPAIGN.loadSelectedOrganizationCampaigns(campaignId);
      });
    }

    $('#btn_addSelectedContacts').on('click',function(){
      CAMPAIGN.addSelectedContact();
    });

    $('#btn_addSelectedOrganizations').on('click',function(){
      CAMPAIGN.addSelectedOrganization();
    });

  });
</script>

@endsection
