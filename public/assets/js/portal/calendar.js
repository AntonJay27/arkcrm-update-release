let baseUrl = $('#txt_baseUrl').val();

const CALENDAR = (function(){

  let thisCalendar = {};

  var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisCalendar.loadCalendars = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* CalendarController->loadCalendars() */
      url : `${baseUrl}/load-calendars`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        if(data['arrCalendars'].length > 0)
        {
          $('#lnk_addEvent').removeClass('disabled');
          $('#lnk_addTask').removeClass('disabled');
          $('#btn_addEvent').prop('disabled',false);
          $('#btn_addTask').prop('disabled',false);

          $('#div_note').prop('hidden',true);

          let divCalendar = '<div class="row">';
          let divCounter = 1;
          data['arrCalendars'].forEach(function(value,key){
            divCalendar += `<div class="col-lg-6 col-sm-12">
                              <div class="card card-primary card-outline">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-sm-12 col-lg-5">
                                      <h5>${value['calendar_name']}</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-7">
                                      <h5>${moment().tz(value['timezone']).format('(Z) ddd MM/DD/y H:mm:ss')}</h5>
                                    </div>
                                  </div>
                                  <hr>
                                  <div id='div_calendar${divCounter}'></div>
                                </div>
                              </div>
                            </div>`;
            divCounter++;
          });

          divCalendar += '</div>';

          $('#div_calendars').html(divCalendar);

          let arrEventsAndTasks = [];

          console.log(data['arrEvents']);

          divCounter = 1;
          let objTimezones = moment.tz._names;
          console.log(objTimezones);
          data['arrCalendars'].forEach(function(value,key){

            arrEventsAndTasks = [];
            data['arrEvents'].forEach(function(cValue,key){
              let arrEvents = [];
              let eventStart = '';
              let eventEnd = '';

              eventStart = `${cValue['start_date']}${(cValue['start_time'] == null)? '' : 'T'+cValue['start_time']}`;
              eventEnd = `${(cValue['end_date'] == null)? '' : cValue['end_date']}${(cValue['end_time'] == null)? '' : 'T'+cValue['end_time']}`;

              arrEvents['id']    = cValue['id'];
              arrEvents['title'] = `Event - ${cValue['subject']}`;
              arrEvents['start'] = moment(moment(eventStart).tz(objTimezones[cValue['event_timezone']]).format()).tz(objTimezones[value['timezone']]).format();
              // arrEvents['start'] = moment(eventStart).tz(objTimezones[value['timezone']]).format();

              if(eventEnd != '')
              {
                // arrEvents['end'] = moment(moment(eventEnd).tz(objTimezones[cValue['event_timezone']]).format()).tz(objTimezones[value['timezone']]).format();
                arrEvents['end'] = moment(eventEnd).tz(objTimezones[value['timezone']]).format();
              }

              arrEventsAndTasks.push(arrEvents);
            });

            data['arrTasks'].forEach(function(cValue,key){
              let arrTasks = [];
              let taskStart = '';
              let taskEnd = '';

              taskStart = `${cValue['start_date']}${(cValue['start_time'] == null)? '' : 'T'+cValue['start_time']}`;
              taskEnd = `${(cValue['end_date'] == null)? '' : cValue['end_date']}${(cValue['end_time'] == null)? '' : 'T'+cValue['end_time']}`;

              arrTasks['id']    = cValue['id'];
              arrTasks['title'] = `Task - ${cValue['subject']}`;
              arrTasks['start'] = moment(moment(taskStart).tz(objTimezones[cValue['task_timezone']]).format()).tz(objTimezones[value['timezone']]).format();
              // arrTasks['start'] = moment(taskStart).tz(objTimezones[value['timezone']]).format();

              if(taskEnd != '')
              {
                // arrTasks['end'] = moment(moment(taskEnd).tz(objTimezones[cValue['event_timezone']]).format()).tz(objTimezones[value['timezone']]).format();
                arrTasks['end'] = moment(taskEnd).tz(objTimezones[value['timezone']]).format();
              }

              arrEventsAndTasks.push(arrTasks);
            });

            console.log(`div_calendar${divCounter}`);
            console.log(arrEventsAndTasks);

            let objCalendar = new FullCalendar.Calendar(document.getElementById(`div_calendar${divCounter}`),{
              headerToolbar: {
                left  : 'prev,next today',
                center: 'title',
                right : 'dayGridMonth,timeGridWeek,timeGridDay'
              },
              themeSystem: 'bootstrap',
              timeZone: objTimezones[value['timezone']],
              now: moment().tz(objTimezones[value['timezone']]).format(),
              events: arrEventsAndTasks,
              eventTimeFormat: { hour: 'numeric', minute: '2-digit', timeZoneName: 'short' },
              eventClick:function(info)
              {
                let eventObj = info.event;
                // console.log(eventObj);
                // alert(eventObj.id);
                let title = eventObj.title;
                if(title.substring(0,5) == 'Event')
                {
                  CALENDAR.selectEvent(eventObj.id);
                }
                else
                {
                  CALENDAR.selectTask(eventObj.id);
                }
              }
            });
            objCalendar.render();

            arrEventsAndTasks = [];

            divCounter++;        
          });
        }
        else
        {
          $('#lnk_addEvent').addClass('disabled');
          $('#lnk_addTask').addClass('disabled');
          $('#btn_addEvent').prop('disabled',true);
          $('#btn_addTask').prop('disabled',true);

          $('#div_note').prop('hidden',false);
          $('#div_calendars').html('');
        }
        // console.log(data['arrCalendars'].length);
        // console.log(arrEventsAndTasks);

      }
    });
  }

  thisCalendar.loadTimezones = function(elemId, timezoneKey = '')
  {
    let objTimezones = moment.tz._names;
    let slcTimezones = '<option value="">--Select Timezone--</option>';

    slcTimezones += '<option value="utc">UTC</option>';

    Object.keys(objTimezones).forEach(function(key){
      if(timezoneKey == key)
      {
        slcTimezones += `<option value="${key}" selected>(${moment().tz(objTimezones[key]).format('Z')}) ${objTimezones[key]}</option>`;
      }
      else
      {
        slcTimezones += `<option value="${key}">(${moment().tz(objTimezones[key]).format('Z')}) ${objTimezones[key]}</option>`;
      }
    });

    $(elemId).html(slcTimezones);
  }

  thisCalendar.addCalendar = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_saveCalendar').prop('disabled',true);
    $.ajax({
      /* CalendarController->addCalendar() */
      url : `${baseUrl}/add-calendar`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_calendar').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New calendar added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/calendar`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
      }
    });
  }

  thisCalendar.selectCalendar = function(calendarId)
  {

  }

  thisCalendar.editCalendar = function(thisForm)
  {

  }

  thisCalendar.removeCalendar = function(calendarId)
  {

  }

  thisCalendar.loadUsers = function(elemId, userId = '')
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* CalendarController->loadUsers() */
      url : `${baseUrl}/calendar/load-users`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        let options = '<option value="">--Select user--</option>';
        data.forEach(function(value,key){
          let userName = `${HELPER.checkEmptyFields(value['salutation'],'')} ${HELPER.checkEmptyFields(value['first_name'],'')} ${HELPER.checkEmptyFields(value['last_name'],'')}`;
          if(userId == value['user_id'])
          {
            options += `<option value="${value['user_id']}" selected>${userName}</option>`;
          }
          else
          {
            options += `<option value="${value['user_id']}">${userName}</option>`;
          }         
        });
        $(elemId).html(options);
      }
    });
  }


  thisCalendar.addEvent = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_saveEvent').prop('disabled',true);
    $.ajax({
      /* EventController->addEvent() */
      url : `${baseUrl}/add-event`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_events').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New event added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/calendar`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
      }
    });
  }

  thisCalendar.clearEvent = function()
  {
    $('#txt_eventId').val('');
    $('#txt_eventSubject').val('');
    $('#slc_eventTimezone').val('');
    // $('#txt_eventStartDate').val('');
    // $('#txt_eventStartTime').val('');
    // $('#txt_eventEndDate').val('');
    // $('#txt_eventEndTime').val('');
    $('#slc_eventAssignedTo').val('');
    $('#slc_eventStatus').val('');
    $('#slc_eventType').val('');
  }

  thisCalendar.selectEvent = function(eventId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* EventController->selectEvent() */
      url : `${baseUrl}/select-event`,
      method : 'get',
      dataType: 'json',
      data : {eventId : eventId},
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#lbl_eventHeader').html('<i class="fa fa-pen mr-1"></i> Update Event');
        $('#txt_eventId').val(data['id']);
        $('#txt_eventSubject').val(data['subject']);
        CALENDAR.loadTimezones('#slc_eventTimezone',data['event_timezone']);
        $('#txt_eventStartDate').val(data['start_date']);
        $('#txt_eventStartTime').val(data['start_time']);
        $('#txt_eventEndDate').val(data['end_date']);
        $('#txt_eventEndTime').val(data['end_time']);
        CALENDAR.loadUsers('#slc_eventAssignedTo',data['assigned_to']);
        $('#slc_eventStatus').val(data['status']);
        $('#slc_eventType').val(data['type']);
        $('#modal_events').modal({'backdrop':'static'});
      }
    });
  }

  thisCalendar.editEvent = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_saveEvent').prop('disabled',true);
    $.ajax({
      /* EventController->editEvent() */
      url : `${baseUrl}/edit-event`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_events').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Event updated successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/calendar`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
      }
    });
  }

  thisCalendar.removeEvent = function(eventId)
  {

  }


  thisCalendar.addTask = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_saveTask').prop('disabled',true);
    $.ajax({
      /* TaskController->addTask() */
      url : `${baseUrl}/add-task`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_tasks').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New tasks added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/calendar`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
      }
    });
  }

  thisCalendar.clearTask = function()
  {
    $('#txt_taskId').val('');
    $('#txt_taskSubject').val('');
    $('#slc_taskTimezone').val('');
    // $('#txt_taskStartDate').val('');
    // $('#txt_taskStartTime').val('');
    // $('#txt_taskEndDate').val('');
    // $('#txt_taskEndTime').val('');
    $('#slc_taskAssignedTo').val('');
    $('#slc_taskStatus').val('');
  }

  thisCalendar.selectTask = function(taskId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* EventController->selectTask() */
      url : `${baseUrl}/select-task`,
      method : 'get',
      dataType: 'json',
      data : {taskId : taskId},
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#lbl_taskHeader').html('<i class="fa fa-pen mr-1"></i> Update Task');
        $('#txt_taskId').val(data['id']);
        $('#txt_taskSubject').val(data['subject']);
        CALENDAR.loadTimezones('#slc_taskTimezone',data['task_timezone']);
        $('#txt_taskStartDate').val(data['start_date']);
        $('#txt_taskStartTime').val(data['start_time']);
        $('#txt_taskEndDate').val(data['end_date']);
        $('#txt_taskEndTime').val(data['end_time']);
        CALENDAR.loadUsers('#slc_taskAssignedTo',data['assigned_to']);
        $('#slc_taskStatus').val(data['status']);
        $('#slc_taskType').val(data['type']);
        $('#modal_tasks').modal({'backdrop':'static'});
      }
    });
  }

  thisCalendar.editTask = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_saveTask').prop('disabled',true);
    $.ajax({
      /* EventController->editTask() */
      url : `${baseUrl}/edit-task`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide'); 
        $('#modal_tasks').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Task updated successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/calendar`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
      }
    });
  }

  thisCalendar.removeTask = function(taskId)
  {

  }

  return thisCalendar;

})();