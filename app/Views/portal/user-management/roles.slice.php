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

  .label
  {
    border: 1px solid grey;
    padding: 2px 6px 2px 6px;
    background-color: #F3F5F8;
    display: inline;
  }

  /*.label:hover + .actions, .actions:hover{
    display: inline-block;
  }*/

  .actions
  {
    display: inline-block;
  }

  .tree, .tree ul {
      margin:0;
      padding:0;
      list-style:none;
  }
  .tree ul {
      margin-left:1em;
      position:relative
  }
  .tree ul ul {
      margin-left:.5em
  }
  .tree ul:before {
      content:"";
      display:block;
      width:0;
      position:absolute;
      top:0;
      bottom:0;
      left:0;
      border-left:1px solid
  }
  .tree li {
      margin:0;
      padding:0 1em;
      line-height:2em;
      color:#369;
      font-weight:700;
      position:relative;
  }
  .tree ul li:before {
      content:"";
      display:block;
      width:10px;
      height:0;
      border-top:1px solid;
      margin-top:-1px;
      position:absolute;
      top:1em;
      left:0;
  }
  .tree ul li:last-child:before {
      background:#fff;
      height:auto;
      top:1em;
      bottom:0
  }
  .indicator {
      margin-right:5px;
  }
  .tree li a {
      text-decoration: none;
      color:#369;
  }
  .tree li button, .tree li button:active, .tree li button:focus {
      text-decoration: none;
      color:#369;
      border:none;
      background:transparent;
      margin:0px 0px 0px 0px;
      padding:0px 0px 0px 0px;
      outline: 0;
  }

  .select2-selection__choice{
    color: black !important;
  }

  .range-zero {
    -webkit-appearance: none;  /* Override default CSS styles */
    appearance: none;
    width: 30px;
    height: 10px; /* Specified height */
    background: #d3d3d3; /* Grey background */
    outline: none; /* Remove outline */
    opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
    -webkit-transition: .2s; /* 0.2 seconds transition on hover */
    transition: opacity .2s;
  }

  .range-zero::-webkit-slider-thumb {
    -webkit-appearance: none; /* Override default look */
    appearance: none;
    width: 10px; /* Set a specific slider handle width */
    height: 10px; /* Slider handle height */
    background: black; /* Green background */
    cursor: pointer; /* Cursor on hover */
  }

  .range-one {
    -webkit-appearance: none;  /* Override default CSS styles */
    appearance: none;
    width: 30px;
    height: 10px; /* Specified height */
    background: #d3d3d3; /* Grey background */
    outline: none; /* Remove outline */
    opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
    -webkit-transition: .2s; /* 0.2 seconds transition on hover */
    transition: opacity .2s;
  }

  .range-one::-webkit-slider-thumb {
    -webkit-appearance: none; /* Override default look */
    appearance: none;
    width: 10px; /* Set a specific slider handle width */
    height: 10px; /* Slider handle height */
    background: orange; /* Green background */
    cursor: pointer; /* Cursor on hover */
  }

  .range-two {
    -webkit-appearance: none;  /* Override default CSS styles */
    appearance: none;
    width: 30px;
    height: 10px; /* Specified height */
    background: #d3d3d3; /* Grey background */
    outline: none; /* Remove outline */
    opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
    -webkit-transition: .2s; /* 0.2 seconds transition on hover */
    transition: opacity .2s;
  }

  .range-two::-webkit-slider-thumb {
    -webkit-appearance: none; /* Override default look */
    appearance: none;
    width: 10px; /* Set a specific slider handle width */
    height: 10px; /* Slider handle height */
    background: green; /* Green background */
    cursor: pointer; /* Cursor on hover */
  }

  .table-remove-borders tr td
  {
    border: 0px !important;
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
              <a href="<?php echo base_url(); ?>/users" class="text-muted">Roles</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>/users" class="text-muted">All</a>
            </small> 
            <!-- <small> - 
              <a href="#" class="text-muted" id="lnk_user">Anton Jay</a>
            </small> -->
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_createNewRole">
                  <i class="fa fa-plus mr-1"></i>Create New Role
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_createNewRole">
                <i class="fa fa-plus mr-1"></i> Create New Role
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
          
          <div class="row">
            <div class="col-sm-12">
              <ul id="tree1">
                <li>
                  <span class="label" id="lbl_organizationName">Organization</span>
                  <!-- <a href="javascript:void(0)" onclick="ROLES.selectOrganizationName();">
                     <i class="fa fa-pen ml-1"></i>
                  </a> -->
                  <ul id="ul_roles">
                    
                  </ul>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>

    </div><!-- /.container flued -->

    <div class="modal fade" id="modal_roles" role="dialog">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_modalTitle"><i class="fa fa-plus mr-1"></i> Create New Role</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_roles">

              <input type="hidden" id="txt_roleId" name="txt_roleId">
              <input type="hidden" id="txt_subRole" name="txt_subRole">

              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-7">
                  <table width="100%">
                    <tr>
                      <td class="pb-2 pr-3" style="vertical-align: top; text-align: right; width: 40%;">Role Name *:</td>
                      <td class="pb-2">
                        <input type="text" class="form-control form-control-sm" id="txt_roleName" name="txt_roleName" required>
                      </td>
                    </tr>
                    <tr>
                      <td class="pb-2 pr-3" style="vertical-align: top; text-align: right; width: 40%;">Reports To:</td>
                      <td class="pb-2">
                        <select class="form-select form-control form-control-sm" id="slc_reportsTo" name="slc_reportsTo">
                          
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="pb-2 pr-3" style="vertical-align: top; text-align: right; width: 40%;">Can Assign Records To:</td>
                      <td class="pb-2">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="rdb_canAssignRecordsTo" id="rdb_1" value="all-users" checked>
                            <label class="form-check-label" for="rdb_1">All Users</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="rdb_canAssignRecordsTo" id="rdb_2" value="users-having-same-role-or-subordinate-role">
                            <label class="form-check-label" for="rdb_2">Users having same role or subordinate role</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="rdb_canAssignRecordsTo" id="rdb_3" value="users-having-subordinate-role">
                            <label class="form-check-label" for="rdb_3">Users having subordinate role</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="pb-2 pr-3" style="vertical-align: top; text-align: right; width: 40%;">Privileges:</td>
                      <td class="pb-2">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="rdb_privileges" id="rdb_4" value="assign-privileges-directly-to-role" checked>
                            <label class="form-check-label" for="rdb_4">Assign privileges directly to role</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="rdb_privileges" id="rdb_5" value="assign-privileges-from-existing-profiles">
                            <label class="form-check-label" for="rdb_5">Assign privileges from existing profiles</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr id="tr_privilegesFromExistingProfiles">
                      <td class="pb-2 pr-3" style="vertical-align: top; text-align: right; width: 40%;">Profiles:</td>
                      <td class="pb-2">
                        <div class="form-group">
                          <select class="select2 form-select form-control form-control-sm" id="slc_profiles" name="slc_profiles"  multiple="" data-placeholder="Choose Profiles" style="width: 100%;" aria-hidden="true">
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr id="tr_privilegesDirectlyToRole">
                      <td class="pb-2 pr-3" style="vertical-align: top; text-align: right; width: 40%;">Assign Privileges from Profile or Custom:</td>
                      <td class="pb-2">
                        <select class="form-select form-control form-control-sm" id="slc_profile" name="slc_profile">
                          
                        </select>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>

              <div id="div_privileges">
                <label>Edit Privileges of this Profile</label>
                <div class="table-responsive">
                  <table class="table table-bordered mb-0" id="tbl_profilePrivileges">
                    <thead>
                      <tr>
                        <th width="20%;">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chk_modules">
                            <label class="form-check-label" for="chk_modules">Modules</label>
                          </div>
                        </th>
                        <th width="15%;">
                          <center>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="chk_view">
                              <label class="form-check-label" for="chk_view">View</label>
                            </div>
                          </center>
                        </th>
                        <th width="15%;">
                          <center>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="chk_create">
                              <label class="form-check-label" for="chk_create">Create</label>
                            </div>
                          </center>
                        </th>
                        <th width="15%;">
                          <center>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="chk_edit">
                              <label class="form-check-label" for="chk_edit">Edit</label>
                            </div>
                          </center>
                        </th>
                        <th width="15%;">
                          <center>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="chk_delete">
                              <label class="form-check-label" for="chk_delete">Delete</label>
                            </div>
                          </center>
                        </th>
                        <th width="50%">
                          <center><label class="form-check-label">Field & Tool Privileges</label></center>              
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Dashboard</label>
                          </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            sample
                          </div>
                        </td>
                      </tr>

                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Rolodex/Contacts</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Basic Information</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Salutation
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> First Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Last Name
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Position
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Company Name
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Primary Email
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Secondary Email
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Date of Birth
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Intro Letter
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Office Phone
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mobile Phone
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Home Phone
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Secondary Phone
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Fax
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Do not Call
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> LinkedIn
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Twitter
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Facebook
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Instagram
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Lead Source
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Department
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Reports To
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Assigned To
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Email Opt Out
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Address Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing Street
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing P.O Box
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing City
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing State
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing Zip
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing Country
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other Street
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other P.O. Box
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other City
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other State
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other Zip
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other Country
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Description Details & Profile Picture</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Description
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Profile Picture
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Rolodex/Organizations</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Basic Information</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Organization
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Assigned To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Primary Email
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Secondary Email
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Main Website
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other Website
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Phone Number
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Fax
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> LinkedIn
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Facebook
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Twitter
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Instagram
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Industry
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> NAICS Code
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Employee Count
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Annual Revenue
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Type
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Ticket Symbol
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Member Of
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Email Opt Out
                                  </td>
                                  <td class="pl-3">
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Address Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing Street
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing City
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing State
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing Zip
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Mailing Country
                                  </td>
                                  <td class="pl-3">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other Street
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other City
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other State
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other Zip
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Other Country
                                  </td>
                                  <td class="pl-3"> 
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Description Details & Profile Picture</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Description
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Profile Picture
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>

                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Marketing/Campaigns</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <td class="p-2">
                                    <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                  </td>
                                  <td class="p-2"></td>
                                  <td class="p-2">
                                    <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                  </td>
                                  <td class="p-2"></td>
                                  <td class="p-2">
                                    <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                  </td>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Campaign Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Campaign Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Assigned To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Campaign Status
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Campaign Type
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Product
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Target Audience
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Expected Close Date
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Sponsor
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Target Size
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Num Sent
                                  </td>
                                  <td class="pl-3">
                                    
                                  </td>
                                  <td class="pl-3">
                                    
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Expectations & Actuals</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Budget Cost
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Actual Cost
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Expected Response
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Expected Revenue
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Expected Sales Count
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Actual Sales Count
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Expected Response Count
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Actual Response Count
                                  </td>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Expected ROI
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Actual ROI
                                  </td>
                                  <td class="pl-3">
                                    
                                  </td>
                                  <td class="pl-3">
                                    
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Description Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Descriptions
                                  </td>
                                  <td class="pl-3">
                                    
                                  </td>
                                  <td class="pl-3">
                                    
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->

                          </div>
                        </td>
                      </tr>
                      
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Marketing/News Letters</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            <center><h5>No Fields Yet!</h5></center>
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Marketing/Social Media Posts</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            <center><h5>No Fields Yet!</h5></center>
                          </div>
                        </td>
                      </tr>

                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Marketing/Image Library</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            <center><h5>No Fields Yet!</h5></center>
                          </div>
                        </td>
                      </tr>

                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Marketing/Email Templates</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Email Template Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Template Name/Code
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Category
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Accessibility
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Description
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Subject
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Content
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Marketing/Email Signatures</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            <center><h5>No Fields Yet!</h5></center>
                          </div>
                        </td>
                      </tr>

                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Employees</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            <center><h5>No Fields Yet!</h5></center>
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Agenda</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            <center><h5>No Fields Yet!</h5></center>
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Calendar</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Calendar Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Calendar Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Time Zone
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Event Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Subject 
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Timezone
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> From 
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Assigned To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Status
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Type
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <h6>Task Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Subject 
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Timezone
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> From 
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Assigned To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Status
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Documents</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Document Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Title
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Assigned To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Type
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> File Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> File URL
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Notes
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>
                      
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">User Management/Users</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>User Login & Role</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> User Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Primary Email
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> First Name
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Last Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Role
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Admin?
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">User Management/Roles</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Role Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Role Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Reports To
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Can Assign Records To
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Privileges
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Copy Privileges From
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Profiles
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Privileges Table
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">User Management/Profiles</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                              <center><h5>No Fields Yet!</h5></center>
                            <!-- <center>
                              <table class="mb-3 mt-3">
                                <tbody>
                                  <tr>
                                    <td class="p-2">
                                      <input type="range" class="range-zero mr-3" min="0" max="2" value="0" disabled> Invisible
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-one mr-3" min="0" max="2" value="1" disabled> Read Only
                                    </td>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                      <input type="range" class="range-two mr-3" min="0" max="2" value="2" disabled> Write
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h5>--- Fields ---</h5>
                            </center>

                            <h6>Profile Details</h6>
                            <table class="mb-3 table-remove-borders" width="100%">
                              <tbody>
                                <tr>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Profile Name
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Description
                                  </td>
                                  <td class="pl-3" width="33.33%">
                                    <input type="range" class="range-zero fields mr-3" min="0" max="2" value="0" onchange="ROLES.changeFieldStatus(this)"> Privileges Table
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->
                          </div>
                        </td>
                      </tr>
                      <tr class="module">
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_modules[]">
                            <label class="form-check-label">Settings</label>
                          </div>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center><input type="checkbox" name="rdb_canAssignRecordsTo"></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-tool btn_modules">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </center>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" class="p-0">
                          <div class="container" style="display:none;">
                            <center><h5>No Fields Yet!</h5></center>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="reset" class="btn btn-secondary">clear</button>
            <button type="submit" class="btn btn-primary" id="btn_saveRole" form="form_roles">Save Role</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_organizationName" role="dialog">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-pen mr-1"></i> Edit Organization Name</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_organizationName">
               <input type="text" class="form-control" id="txt_organizationName" name="txt_organizationName" placeholder="Organization Name" required>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="submit" class="btn btn-primary" id="btn_saveOrganizationName" form="form_organizationName">Save Changes</button>
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

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/user-management/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('#nav_userManagement').parent('li').addClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_userManagement').addClass('active'); //menu
    $('#nav_roles').addClass('active'); //sub-menu

    //topNav icon & label

    let topNav = `<i class="fas fa-users mr-2"></i>
                  <b>USER MANAGEMENT</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    $('.select2bs4').select2();

    $.fn.extend({
        treed: function (o) {
          
          var openedClass = 'fa fa-minus';
          var closedClass = 'fa fa-plus';
          
          if (typeof o != 'undefined'){
            if (typeof o.openedClass != 'undefined'){
            openedClass = o.openedClass;
            }
            if (typeof o.closedClass != 'undefined'){
            closedClass = o.closedClass;
            }
          };
          
          //initialize each of the top levels
          var tree = $(this);
          tree.addClass("tree");

          tree.find('li:not(:has(ul))').each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator fa fa-minus'></i>");
          });

          tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator " + openedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
              if (this == e.target) {
                var icon = $(this).children('i:first');
                icon.toggleClass(openedClass + " " + closedClass);
                $(this).children().children().toggle();
              }
            });
            // branch.children().children().toggle();
          });
          //fire event from the dynamically added icon
          tree.find('.branch .indicator').each(function(){
            $(this).on('click', function () {
              $(this).closest('li').click();
            });
          });
        }
    });

    //Initialization of treeviews

    $('#tree1').treed({openedClass:'fa fa-minus-square', closedClass:'fa fa-plus-square'});

    ROLES.loadRoles();
    // ROLES.loadOrganizationName();

    // $('.branch').hover(function(){
    //   console.log($(this).html());
    // });


    $('#lnk_createNewRole').on('click',function(){
      $('#lbl_modalTitle').html('<i class="fa fa-plus"></i> Create New Role');
      $('#modal_roles').modal('show');

      $('#txt_roleId').val('');

      $('#tr_privilegesFromExistingProfiles').hide();
      $('#tr_privilegesDirectlyToRole').show();
      $('#div_privileges').show();

      $('#tbl_profilePrivileges').find('input[type="checkbox"]').prop('checked',true);

      ROLES.loadReportsTo();
      ROLES.loadProfiles('single-select');
    });

    $('#btn_createNewRole').on('click',function(){
      $('#lbl_modalTitle').html('<i class="fa fa-plus"></i> Create New Role');
      $('#modal_roles').modal('show');

      $('#txt_roleId').val('');

      $('#tr_privilegesFromExistingProfiles').hide();
      $('#tr_privilegesDirectlyToRole').show();
      $('#div_privileges').show();

      $('#tbl_profilePrivileges').find('input[type="checkbox"]').prop('checked',true);

      ROLES.loadReportsTo();
      ROLES.loadProfiles('single-select');
    });

    $('#rdb_4').on('change',function(){
      if($(this).is(':checked'))
      {
        $('#tr_privilegesFromExistingProfiles').hide();
        $('#tr_privilegesDirectlyToRole').show();
        $('#div_privileges').show();

        $('#tbl_profilePrivileges').find('input[type="checkbox"]').prop('checked',true);

        $('#slc_profiles').prop('required',false);
        ROLES.loadProfiles('single-select');
      }
    });

    $('#rdb_5').on('change',function(){
      if($(this).is(':checked'))
      {
        $('#tr_privilegesFromExistingProfiles').show();
        $('#tr_privilegesDirectlyToRole').hide();
        $('#div_privileges').hide();

        $('#slc_profiles').prop('required',true);
        ROLES.loadProfiles('multiple-select');
      }
    });

    $('#slc_profile').on('change',function(){
      $('#tbl_profilePrivileges').find('input[type="checkbox"]').prop('checked',false);
      if($(this).val() != "")
      {
         ROLES.copyProfile(this);
      }
    });

    // $('#rangeLegend1').addClass('range-zero');
    // $('#rangeLegend2').addClass('range-one');
    // $('#rangeLegend3').addClass('range-two');

    // Check All Modules
    $('#chk_modules').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      $('#tbl_profilePrivileges').find('input[type="checkbox"]').prop('checked',checkBoxStatus);
      $('.btn_modules').prop('disabled',!checkBoxStatus);   
    });
    $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      $(this).parents('tr').find('td input[type="checkbox"]').prop('checked',checkBoxStatus);
      $(this).parents('tr').find('td:eq(5) .btn_modules').prop('disabled',!checkBoxStatus);

      let checkboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').length;
      let checkedboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input:checked[type="checkbox"]').length;
      $('#chk_modules').prop('checked',(checkboxesModule == checkedboxesModule)? true : false);

      let checkboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').length;
      let checkedboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input:checked[type="checkbox"]').length;
      $('#chk_view').prop('checked',(checkboxesView == checkedboxesView)? true : false);

      let checkboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input[type="checkbox"]').length;
      let checkedboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input:checked[type="checkbox"]').length;
      $('#chk_create').prop('checked',(checkboxesCreate == checkedboxesCreate)? true : false);

      let checkboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input[type="checkbox"]').length;
      let checkedboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input:checked[type="checkbox"]').length;
      $('#chk_edit').prop('checked',(checkboxesEdit == checkedboxesEdit)? true : false);

      let checkboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input[type="checkbox"]').length;
      let checkedboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input:checked[type="checkbox"]').length;
      $('#chk_delete').prop('checked',(checkboxesDelete == checkedboxesDelete)? true : false);
    });

    // Check All View Columns
    $('#chk_view').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').prop('checked',checkBoxStatus);     
      $('#tbl_profilePrivileges').find('input[type="checkbox"]').prop('checked',checkBoxStatus);
      $('.btn_modules').prop('disabled',!checkBoxStatus);
    });
    $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      $(this).parents('tr').find('td:eq(0) input[type="checkbox"]').prop('checked',checkBoxStatus);
      $(this).parents('tr').find('td:eq(2) input[type="checkbox"]').prop('checked',checkBoxStatus);
      $(this).parents('tr').find('td:eq(3) input[type="checkbox"]').prop('checked',checkBoxStatus);
      $(this).parents('tr').find('td:eq(4) input[type="checkbox"]').prop('checked',checkBoxStatus);
      $(this).parents('tr').find('td:eq(5) .btn_modules').prop('disabled',!checkBoxStatus);

      let checkboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').length;
      let checkedboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input:checked[type="checkbox"]').length;
      $('#chk_modules').prop('checked',(checkboxesModule == checkedboxesModule)? true : false);

      let checkboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').length;
      let checkedboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input:checked[type="checkbox"]').length;
      $('#chk_view').prop('checked',(checkboxesView == checkedboxesView)? true : false);

      let checkboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input[type="checkbox"]').length;
      let checkedboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input:checked[type="checkbox"]').length;
      $('#chk_create').prop('checked',(checkboxesCreate == checkedboxesCreate)? true : false);

      let checkboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input[type="checkbox"]').length;
      let checkedboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input:checked[type="checkbox"]').length;
      $('#chk_edit').prop('checked',(checkboxesEdit == checkedboxesEdit)? true : false);

      let checkboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input[type="checkbox"]').length;
      let checkedboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input:checked[type="checkbox"]').length;
      $('#chk_delete').prop('checked',(checkboxesDelete == checkedboxesDelete)? true : false);
    });

    // Check All Create Columns
    $('#chk_create').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input[type="checkbox"]').prop('checked',checkBoxStatus); 
      if($(this).is(':checked') || $('#chk_edit').is(':checked') || $('#chk_delete').is(':checked'))
      {
        $('#tbl_profilePrivileges thead tr').find('th:eq(0) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges thead tr').find('th:eq(1) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').prop('checked',true);
        $('.btn_modules').prop('disabled',false);
      }
    });
    $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input[type="checkbox"]').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      if(checkBoxStatus == true)
      {
        $(this).parents('tr').find('td:eq(0) input[type="checkbox"]').prop('checked',checkBoxStatus);
        $(this).parents('tr').find('td:eq(1) input[type="checkbox"]').prop('checked',checkBoxStatus);
        $(this).parents('tr').find('td:eq(5) .btn_modules').prop('disabled',!checkBoxStatus);
      }

      let checkboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').length;
      let checkedboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input:checked[type="checkbox"]').length;

      let checkboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').length;
      let checkedboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input:checked[type="checkbox"]').length;

      let checkboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input[type="checkbox"]').length;
      let checkedboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input:checked[type="checkbox"]').length;

      $('#chk_modules').prop('checked',(checkboxesModule == checkedboxesModule)? true : false);
      $('#chk_view').prop('checked',(checkboxesView == checkedboxesView)? true : false);
      $('#chk_create').prop('checked',(checkboxesCreate == checkedboxesCreate)? true : false);
    });

    // Check All Edit Columns
    $('#chk_edit').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input[type="checkbox"]').prop('checked',checkBoxStatus);  
      if($('#chk_create').is(':checked') || $(this).is(':checked') || $('#chk_delete').is(':checked'))
      {
        $('#tbl_profilePrivileges thead tr').find('th:eq(0) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges thead tr').find('th:eq(1) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').prop('checked',true);
        $('.btn_modules').prop('disabled',false);
      }
    });
    $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input[type="checkbox"]').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      if(checkBoxStatus == true)
      {
        $(this).parents('tr').find('td:eq(0) input[type="checkbox"]').prop('checked',checkBoxStatus);
        $(this).parents('tr').find('td:eq(1) input[type="checkbox"]').prop('checked',checkBoxStatus);
        $(this).parents('tr').find('td:eq(5) .btn_modules').prop('disabled',!checkBoxStatus);
      }

      let checkboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').length;
      let checkedboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input:checked[type="checkbox"]').length;

      let checkboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').length;
      let checkedboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input:checked[type="checkbox"]').length;

      let checkboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input[type="checkbox"]').length;
      let checkedboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input:checked[type="checkbox"]').length;

      $('#chk_modules').prop('checked',(checkboxesModule == checkedboxesModule)? true : false);
      $('#chk_view').prop('checked',(checkboxesView == checkedboxesView)? true : false);
      $('#chk_edit').prop('checked',(checkboxesEdit == checkedboxesEdit)? true : false);
    });

    // Check All Delete Columns
    $('#chk_delete').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input[type="checkbox"]').prop('checked',checkBoxStatus);   
      if($('#chk_create').is(':checked') || $('#chk_edit').is(':checked') || $(this).is(':checked'))
      {
        $('#tbl_profilePrivileges thead tr').find('th:eq(0) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges thead tr').find('th:eq(1) input[type="checkbox"]').prop('checked',true);
        $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').prop('checked',true);
        $('.btn_modules').prop('disabled',false);
      }
    });
    $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input[type="checkbox"]').on('change',function(){
      let checkBoxStatus = ($(this).is(':checked'))? true : false;
      if(checkBoxStatus == true)
      {
        $(this).parents('tr').find('td:eq(0) input[type="checkbox"]').prop('checked',checkBoxStatus);
        $(this).parents('tr').find('td:eq(1) input[type="checkbox"]').prop('checked',checkBoxStatus);
        $(this).parents('tr').find('td:eq(5) .btn_modules').prop('disabled',!checkBoxStatus);
      }

      let checkboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input[type="checkbox"]').length;
      let checkedboxesModule = $('#tbl_profilePrivileges tbody tr').find('td:eq(0) input:checked[type="checkbox"]').length;

      let checkboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').length;
      let checkedboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input:checked[type="checkbox"]').length;

      let checkboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input[type="checkbox"]').length;
      let checkedboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input:checked[type="checkbox"]').length;

      $('#chk_modules').prop('checked',(checkboxesModule == checkedboxesModule)? true : false);
      $('#chk_view').prop('checked',(checkboxesView == checkedboxesView)? true : false);
      $('#chk_delete').prop('checked',(checkboxesDelete == checkedboxesDelete)? true : false);
    });

    $('.btn_modules').on('click',function(){
      $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
      $(this).closest('tr').next('tr').find('div').toggle();
    });

    $('#form_roles').on('submit',function(e){
      e.preventDefault();
      let roleId = $('#txt_roleId').val();
      (roleId == "")? ROLES.addRole(this) : ROLES.editRole(this);
    });

    $('#form_organizationName').on('submit',function(e){
      e.preventDefault();
      ROLES.editOrganizationName(this);
    });

  });
</script>

@endsection
