<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class TaskController extends BaseController
{
   public function __construct()
   {
      $this->tasks = model('Portal/Tasks');
   }

   public function addTask()
   {
      $this->validation->setRules([
          'txt_taskSubject' => [
              'label'  => 'Subject',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Subject is required'
              ],
          ],
          'slc_taskTimezone' => [
              'label'  => 'Timezone',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Timezone is required'
              ],
          ],
          'slc_taskAssignedTo' => [
              'label'  => 'Assigned To',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Assigned To is required'
              ],
          ],
          'slc_taskStatus' => [
              'label'  => 'Status',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Status is required'
              ],
          ],
      ]);

      if($this->validation->withRequest($this->request)->run())
      {  
         $fields = $this->request->getPost();

         $arrData = [
            'subject'         => $fields['txt_taskSubject'],
            'assigned_to'     => $fields['slc_taskAssignedTo'],
            'task_timezone'   => $fields['slc_taskTimezone'],
            'start_date'      => $fields['txt_taskStartDate'],
            'start_time'      => $fields['txt_taskStartTime'],
            'end_date'        => $fields['txt_taskEndDate'],
            'end_time'        => $fields['txt_taskEndTime'],
            'status'          => $fields['slc_taskStatus'],
            'created_by'      => $this->session->get('arkonorllc_user_id'),
            'created_date'    => date('Y-m-d H:i:s')
         ];

         $result = $this->tasks->addTask($arrData);
         $msgResult[] = ($result > 0)? "Success" : "Database error";
      }
      else
      {
          $msgResult[] = $this->validation->getErrors();
      }
      return $this->response->setJSON($msgResult);
   }

   public function selectTask()
   {
      $fields = $this->request->getGet();
      $data = $this->tasks->selectTask($fields['taskId']);
      return $this->response->setJSON($data);
   }

   public function editTask()
   {
      $this->validation->setRules([
          'txt_taskSubject' => [
              'label'  => 'Subject',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Subject is required'
              ],
          ],
          'slc_taskTimezone' => [
              'label'  => 'Timezone',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Timezone is required'
              ],
          ],
          'slc_taskAssignedTo' => [
              'label'  => 'Assigned To',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Assigned To is required'
              ],
          ],
          'slc_taskStatus' => [
              'label'  => 'Status',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Status is required'
              ],
          ],
      ]);

      if($this->validation->withRequest($this->request)->run())
      {  
         $fields = $this->request->getPost();

         $arrData = [
            'subject'         => $fields['txt_taskSubject'],
            'assigned_to'     => $fields['slc_taskAssignedTo'],
            'task_timezone'   => $fields['slc_taskTimezone'],
            'start_date'      => $fields['txt_taskStartDate'],
            'start_time'      => $fields['txt_taskStartTime'],
            'end_date'        => $fields['txt_taskEndDate'],
            'end_time'        => $fields['txt_taskEndTime'],
            'status'          => $fields['slc_taskStatus'],
            'updated_by'      => $this->session->get('arkonorllc_user_id'),
            'updated_date'    => date('Y-m-d H:i:s')
         ];

         $result = $this->tasks->editTask($arrData, $fields['txt_taskId']);
         $msgResult[] = ($result > 0)? "Success" : "Database error";
      }
      else
      {
          $msgResult[] = $this->validation->getErrors();
      }
      return $this->response->setJSON($msgResult);
   }
}
