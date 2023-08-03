<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class EventController extends BaseController
{
   
   public function __construct()
   {
      $this->events = model('Portal/Events');
   }

   public function addEvent()
   {
      $this->validation->setRules([
          'txt_eventSubject' => [
              'label'  => 'Subject',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Subject is required'
              ],
          ],
          'slc_eventTimezone' => [
              'label'  => 'Timezone',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Timezone is required'
              ],
          ],
          'slc_eventAssignedTo' => [
              'label'  => 'Assigned To',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Assigned To is required'
              ],
          ],
          'slc_eventStatus' => [
              'label'  => 'Status',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Status is required'
              ],
          ],
          'slc_eventType' => [
              'label'  => 'Type',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Type is required'
              ],
          ],
      ]);

      if($this->validation->withRequest($this->request)->run())
      {  
         $fields = $this->request->getPost();

         $arrData = [
            'subject'         => $fields['txt_eventSubject'],
            'assigned_to'     => $fields['slc_eventAssignedTo'],
            'event_timezone'  => $fields['slc_eventTimezone'],
            'start_date'      => $fields['txt_eventStartDate'],
            'start_time'      => $fields['txt_eventStartTime'],
            'end_date'        => $fields['txt_eventEndDate'],
            'end_time'        => $fields['txt_eventEndTime'],
            'status'          => $fields['slc_eventStatus'],
            'type'            => $fields['slc_eventType'],
            'created_by'      => $this->session->get('arkonorllc_user_id'),
            'created_date'    => date('Y-m-d H:i:s')
         ];

         $result = $this->events->addEvent($arrData);
         $msgResult[] = ($result > 0)? "Success" : "Database error";
      }
      else
      {
          $msgResult[] = $this->validation->getErrors();
      }
      return $this->response->setJSON($msgResult);
   }

   public function selectEvent()
   {
      $fields = $this->request->getGet();
      $data = $this->events->selectEvent($fields['eventId']);
      return $this->response->setJSON($data);
   }

   public function editEvent()
   {
      $this->validation->setRules([
          'txt_eventSubject' => [
              'label'  => 'Subject',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Subject is required'
              ],
          ],
          'slc_eventTimezone' => [
              'label'  => 'Timezone',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Timezone is required'
              ],
          ],
          'slc_eventAssignedTo' => [
              'label'  => 'Assigned To',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Assigned To is required'
              ],
          ],
          'slc_eventStatus' => [
              'label'  => 'Status',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Status is required'
              ],
          ],
          'slc_eventType' => [
              'label'  => 'Type',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Type is required'
              ],
          ],
      ]);

      if($this->validation->withRequest($this->request)->run())
      {  
         $fields = $this->request->getPost();

         $arrData = [
            'subject'         => $fields['txt_eventSubject'],
            'assigned_to'     => $fields['slc_eventAssignedTo'],
            'event_timezone'  => $fields['slc_eventTimezone'],
            'start_date'      => $fields['txt_eventStartDate'],
            'start_time'      => $fields['txt_eventStartTime'],
            'end_date'        => $fields['txt_eventEndDate'],
            'end_time'        => $fields['txt_eventEndTime'],
            'status'          => $fields['slc_eventStatus'],
            'type'            => $fields['slc_eventType'],
            'updated_by'      => $this->session->get('arkonorllc_user_id'),
            'updated_date'    => date('Y-m-d H:i:s')
         ];

         $result = $this->events->editEvent($arrData, $fields['txt_eventId']);
         $msgResult[] = ($result > 0)? "Success" : "Database error";
      }
      else
      {
          $msgResult[] = $this->validation->getErrors();
      }
      return $this->response->setJSON($msgResult);
   }
}
