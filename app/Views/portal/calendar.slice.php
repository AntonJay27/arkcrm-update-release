@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

<!-- Full Calendar -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/fullcalendar/fullcalendar.css">

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
          <h6 class="float-left mb-0">
            <span>
              <a href="javascript:void(0)" id="btn_holidays" class="btn btn-default btn-sm">
                <i class="fa fa-flag mr-1"></i>Holidays
              </a>
            </span>
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_addEvent">
                  <i class="fa fa-plus mr-1"></i>Add Event
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_addTask">
                  <i class="fa fa-plus mr-1"></i>Add Task
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_createCalendar">
                  <i class="fa fa-calendar-plus mr-1"></i>Create Calendar
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_addEvent">
                <i class="fa fa-plus mr-1"></i> Add Event
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_addTask">
                <i class="fa fa-plus mr-1"></i> Add Task
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_createCalendar">
                <i class="fa fa-calendar-plus mr-1"></i> Create Calendar
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

      <div id="div_note" hidden>
         <div class="callout callout-danger">
            <h5>Note!</h5>
            <p>You cannot add tasks or events if you don't have a calendar yet. Please create your calendar first. <br>And remember, you can also create more calendars with different time zones for comparison purposes. Take a look at the example picture below.</p>
         </div>
         <a href="<?php echo base_url(); ?>/public/assets/img/calendar.png" target=_blank>
            <img src="<?php echo base_url(); ?>/public/assets/img/calendar.png" width="100%" class="mb-3 img img-bordered">
         </a>
      </div>
      <div id="div_calendars">
         <center><i>Loading, please wait...</i></center>
      </div>

    </div><!-- /.container flued -->

    <div class="modal fade" id="modal_calendar" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-calendar-plus mr-1"></i> Create New Calendar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_calendar">
              <input type="hidden" id="txt_calendarId" name="txt_calendarId">
              Calendar Name :
              <input type="text" class="form-control form-control-sm" id="txt_calendarName" name="txt_calendarName" placeholder="(e.g. Philippines)" required>
              <div class="mb-2"></div>
              Timezone :
              <select class="form-control select2" id="slc_timezone" name="slc_timezone" style="width:100%;" required>
                <option value="">--Select Timezone--</option>
              </select>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <!-- <button type="reset" class="btn btn-secondary">Clear</button> -->
            <button type="submit" class="btn btn-primary" id="btn_saveCalendar" form="form_calendar">
               <i class="fa fa-save mr-2"></i>Save Calendar
            </button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modal_events" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_eventHeader"><i class="fa fa-plus mr-1"></i> Add Events</h5>
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
                          <input type="date" class="form-control form-control-sm" id="txt_eventStartDate" name="txt_eventStartDate" value="<?php echo date('Y-m-d'); ?>">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <input type="time" class="form-control form-control-sm" id="txt_eventStartTime" name="txt_eventStartTime" value="<?php echo date('H:i'); ?>">
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
                          <input type="date" class="form-control form-control-sm" id="txt_eventEndDate" name="txt_eventEndDate" value="<?php echo date('Y-m-d'); ?>">
                        </td>                        
                      </tr>
                      <tr>
                        <td>
                          <input type="time" class="form-control form-control-sm" id="txt_eventEndTime" name="txt_eventEndTime" value="<?php echo date('H:i'); ?>">
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
                  <select class="form-control form-control-sm" id="slc_eventStatus" name="slc_eventStatus" style="width:100%;" required>
                    <option value="">--Select Status--</option>
                    <option value="planned">Planned</option>
                    <option value="held">Held</option>
                    <option value="not_held">Not Held</option>
                  </select>
                </div>
                <div class="col-lg-6 col-sm-12">
                  Type *:
                  <select class="form-control form-control-sm" id="slc_eventType" name="slc_eventType" style="width:100%;" required>
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
            <!-- <button type="reset" class="btn btn-secondary">Clear</button> -->
            <button type="submit" class="btn btn-primary" id="btn_saveEvent" form="form_events">
               <i class="fa fa-save mr-2"></i>Save Event
            </button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modal_tasks" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_taskHeader"><i class="fa fa-plus mr-1"></i> Add Tasks</h5>
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
                          <input type="date" class="form-control form-control-sm" id="txt_taskStartDate" name="txt_taskStartDate" value="<?php echo date('Y-m-d'); ?>">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <input type="time" class="form-control form-control-sm" id="txt_taskStartTime" name="txt_taskStartTime" value="<?php echo date('H:i'); ?>">
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
                          <input type="date" class="form-control form-control-sm" id="txt_taskEndDate" name="txt_taskEndDate" value="<?php echo date('Y-m-d'); ?>">
                        </td>                        
                      </tr>
                      <tr>
                        <td>
                          <input type="time" class="form-control form-control-sm" id="txt_taskEndTime" name="txt_taskEndTime" value="<?php echo date('H:i'); ?>">
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
              <select class="form-control form-control-sm" id="slc_taskStatus" name="slc_taskStatus" style="width:100%;" required>
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
            <!-- <button type="reset" class="btn btn-secondary">Clear</button> -->
            <button type="submit" class="btn btn-primary" id="btn_saveTask" form="form_tasks">
               <i class="fa fa-save mr-2"></i>Save Task
            </button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modal_holidays" role="dialog">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-flag mr-1"></i> Holidays</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <center>
               <img src="<?php echo base_url(); ?>/public/assets/img/coming-soon.jpg" class="img mb-2" style="height: 80vh;">
            </center>

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

<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/moment/moment-timezone-with-data.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/fullcalendar/fullcalendar.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_calendar').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-calendar mr-2"></i>
                  <b>CALENDAR</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    //
    // ======================================================>
    //

    CALENDAR.loadCalendars();

    $('#lnk_createCalendar').on('click',function(){
      CALENDAR.loadTimezones('#slc_timezone');
      CALENDAR.clearEvent();
      $('#modal_calendar').modal({'backdrop':'static'});
    }); 

    $('#btn_createCalendar').on('click',function(){
      CALENDAR.loadTimezones('#slc_timezone');
      CALENDAR.clearEvent();
      $('#modal_calendar').modal({'backdrop':'static'});
    });

    $('#form_calendar').on('submit',function(e){
      e.preventDefault();
      let calendarId = $('#txt_calendarId').val();

      (calendarId == "")? CALENDAR.addCalendar(this) : CALENDAR.editCalendar(this);
    });

    $('#lnk_addEvent').on('click',function(){
      $('#lbl_eventHeader').html('<i class="fa fa-plus mr-1"></i> Add Event');
      CALENDAR.loadTimezones('#slc_eventTimezone');
      CALENDAR.loadUsers('#slc_eventAssignedTo');
      CALENDAR.clearEvent();
      $('#modal_events').modal({'backdrop':'static'});
    });

    $('#btn_addEvent').on('click',function(){
      $('#lbl_eventHeader').html('<i class="fa fa-plus mr-1"></i> Add Event');
      CALENDAR.loadTimezones('#slc_eventTimezone');
      CALENDAR.loadUsers('#slc_eventAssignedTo');
      CALENDAR.clearEvent();
      $('#modal_events').modal({'backdrop':'static'});
    });

    $('#lnk_addTask').on('click',function(){
      $('#lbl_taskHeader').html('<i class="fa fa-plus mr-1"></i> Add Event');
      CALENDAR.loadTimezones('#slc_taskTimezone');
      CALENDAR.loadUsers('#slc_taskAssignedTo');
      CALENDAR.clearTask();
      $('#modal_tasks').modal({'backdrop':'static'});
    });

    $('#btn_addTask').on('click',function(){
      $('#lbl_taskHeader').html('<i class="fa fa-plus mr-1"></i> Add Event');
      CALENDAR.loadTimezones('#slc_taskTimezone');
      CALENDAR.loadUsers('#slc_taskAssignedTo');
      CALENDAR.clearTask();
      $('#modal_tasks').modal({'backdrop':'static'});
    });

    $('#form_events').on('submit',function(e){
      e.preventDefault();
      let eventId = $('#txt_eventId').val();
      (eventId == "")? CALENDAR.addEvent(this) : CALENDAR.editEvent(this);
    });

    $('#form_tasks').on('submit',function(e){
      e.preventDefault();
      let taskId = $('#txt_taskId').val();
      (taskId == "")? CALENDAR.addTask(this) : CALENDAR.editTask(this);
    });

    $('#btn_holidays').on('click',function(){
      $('#modal_holidays').modal({'backdrop':'static'});
    });


  });
</script>

@endsection
