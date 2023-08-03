<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class CalendarController extends BaseController
{
    public function __construct()
    {
        
        
        $this->contacts         = model('Portal/Contacts');
        $this->organizations    = model('Portal/Organizations');
        $this->calendars        = model('Portal/Calendars');
        $this->events           = model('Portal/Events');
        $this->tasks            = model('Portal/Tasks');


    }

    public function loadCalendars()
    {
        $userId = $this->session->get('arkonorllc_user_id');
        $arrData['arrCalendars'] = $this->calendars->loadCalendars($userId);
        $arrData['arrEvents'] = $this->events->loadEvents();
        $arrData['arrTasks'] = $this->tasks->loadTasks();
        return $this->response->setJSON($arrData);
    }

    public function addCalendar()
    {
        $fields = $this->request->getPost();

        $arrData = [
            'calendar_name' => $fields['txt_calendarName'],
            'timezone'      => $fields['slc_timezone'],
            'created_by'    => $this->session->get('arkonorllc_user_id'),
            'created_date'  => date('Y-m-d H:i:s')
        ];

        $result = $this->calendars->addCalendar($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function selectCalendar()
    {

    }

    public function editCalendar()
    {

    }

    public function removeCalendar()
    {

    }

    public function loadUsers()
    {
      $arrResult = $this->calendars->loadUsers();
      return $this->response->setJSON($arrResult);
    }
}
