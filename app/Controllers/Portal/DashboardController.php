<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->users            = model('Portal/Users');
        $this->campaigns        = model('Portal/Campaigns');
        $this->contacts         = model('Portal/Contacts');
        $this->organizations    = model('Portal/Organizations');
    }

    public function loadAllCampaigns()
    {
        $arrResult = $this->campaigns->loadCampaigns();
        $data = ($arrResult == null)? 0 : count($arrResult);
        return $this->response->setJSON($data);
    }

    public function loadAllContacts()
    {
        $arrResult = $this->contacts->loadContacts();
        $data = ($arrResult == null)? 0 : count($arrResult);
        return $this->response->setJSON($data);
    }

    public function loadContactReports()
    {
      $fields = $this->request->getGet();
      
      $arrResult = $this->contacts->loadContactReports($fields['monthYearDate']);
      $month = substr($fields['monthYearDate'],5,2);
      $year = substr($fields['monthYearDate'],0,4);

      $numberOfDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);

      $arrLabels = [];
      $arrData = [];
      for ($i=1; $i <= $numberOfDays; $i++) 
      { 
         $count = 0;
         foreach ($arrResult as $key => $value) 
         {
            if((int)substr($value['created_date'],9,2) == $i)
            {
               $count++;
            }
         }
         $origDate = "{$year}-{$month}-{$i}";
         $arrLabels[] = date("M d, Y", strtotime($origDate));
         $arrData[] = $count; 
      }
      $arrResult = ['arrLabels'=>$arrLabels,'arrData'=>$arrData];
      return $this->response->setJSON($arrResult);
    }

    public function loadAllOrganizations()
    {
        $arrResult = $this->organizations->loadOrganizations();
        $data = ($arrResult == null)? 0 : count($arrResult);
        return $this->response->setJSON($data);
    }

    public function loadOrganizationReports()
    {
      $fields = $this->request->getGet();
      
      $arrResult = $this->organizations->loadOrganizationReports($fields['monthYearDate']);
      $month = substr($fields['monthYearDate'],5,2);
      $year = substr($fields['monthYearDate'],0,4);

      $numberOfDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);

      $arrLabels = [];
      $arrData = [];
      for ($i=1; $i <= $numberOfDays; $i++) 
      { 
         $count = 0;
         foreach ($arrResult as $key => $value) 
         {
            if((int)substr($value['created_date'],9,2) == $i)
            {
               $count++;
            }
         }
         $origDate = "{$year}-{$month}-{$i}";
         $arrLabels[] = date("M d, Y", strtotime($origDate));
         $arrData[] = $count; 
      }
      $arrResult = ['arrLabels'=>$arrLabels,'arrData'=>$arrData];
      return $this->response->setJSON($arrResult);
    }

    public function loadAllUsers()
    {
        $whereParams = [
            'id !=' => $this->session->get('arkonorllc_user_id'),
            'user_status' => '1'
        ];
        $arrResult = $this->users->loadUsers($whereParams);
        $data = ($arrResult == null)? 0 : count($arrResult);
        return $this->response->setJSON($data);
    }

    public function loadSummaryReports()
    {
      $arrResult = $this->campaigns->loadCampaigns();
      $arrCounts[] = ($arrResult == null)? 0 : count($arrResult);

      $arrResult = $this->contacts->loadContacts();
      $arrCounts[] = ($arrResult == null)? 0 : count($arrResult);

      $arrResult = $this->organizations->loadOrganizations();
      $arrCounts[] = ($arrResult == null)? 0 : count($arrResult);

      $whereParams = [
          'id !=' => $this->session->get('arkonorllc_user_id'),
          'user_status' => '1'
      ];
      $arrResult = $this->users->loadUsers($whereParams);
      $arrCounts[] = ($arrResult == null)? 0 : count($arrResult);

      return $this->response->setJSON($arrCounts);
    }
}
