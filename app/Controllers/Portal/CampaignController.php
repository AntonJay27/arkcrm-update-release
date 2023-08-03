<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class CampaignController extends BaseController
{
    public function __construct()
    {
        $this->campaigns      = model('Portal/Campaigns');
        $this->contacts       = model('Portal/Contacts');
        $this->organizations  = model('Portal/Organizations');
    }

    public function loadUsers()
    {
         $arrResult = $this->campaigns->loadUsers();
         return $this->response->setJSON($arrResult);
    }

    public function loadCampaigns()
    {
        $data = $this->campaigns->loadCampaigns();
        return $this->response->setJSON($data);
    }

    public function addCampaign()
    {
        $this->validation->setRules([
            'txt_campaignName' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
            'txt_expectedCloseDate' => [
                'label'  => 'Expected Close Date',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Expected Close Date is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();
            $arrData = [
                'campaign_name'             => $fields['txt_campaignName'],
                'campaign_status'           => $fields['slc_campaignStatus'],
                'product'                   => $fields['txt_product'],
                'expected_close_date'       => $fields['txt_expectedCloseDate'],
                'target_size'               => $fields['txt_targetSize'],
                'campaign_type'             => $fields['slc_campaignType'],
                'target_audience'           => $fields['txt_targetAudience'],
                'sponsor'                   => $fields['txt_sponsor'],
                'num_sent'                  => $fields['txt_numSent'],
                'assigned_to'               => $fields['slc_assignedTo'],
                'budget_cost'               => $fields['txt_budgetCost'],
                'expected_response'         => $fields['txt_expectedResponse'],
                'expected_sales_count'      => $fields['txt_expectedSalesCount'],
                'expected_response_count'   => $fields['txt_expectedResponseCount'],
                'expected_roi'              => $fields['txt_expectedROI'],
                'actual_cost'               => $fields['txt_actualCost'],
                'expected_revenue'          => $fields['txt_expectedRevenue'],
                'actual_sales_count'        => $fields['txt_actualSalesCount'],
                'actual_response_count'     => $fields['txt_actualResponseCount'],
                'actual_roi'                => $fields['txt_actualROI'],
                'campaign_description'      => $fields['txt_description'],
                'created_by'                => $this->session->get('arkonorllc_user_id'),
                'created_date'              => date('Y-m-d H:i:s')
            ];

            $insertId = $this->campaigns->addCampaign($arrData);
            $msgResult[] = ($insertId > 0)? "Success" : "Database error";

            // campaign updates
            $actionDetails = $arrData;

            $arrData = [
              'campaign_id'       => $insertId,
              'actions'           => 'Created Campaign',
              'action_details'    => json_encode($actionDetails),
              'action_author'     => 'Campaign',
              'action_icon'       => 'fa-bullhorn',
              'action_background' => 'bg-success',
              'created_by'        => $this->session->get('arkonorllc_user_id'),
              'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->campaigns->addCampaignUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectCampaign()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->selectCampaign($fields['campaignId']);
        return $this->response->setJSON($data);
    }

    public function editCampaign()
    {
        $this->validation->setRules([
            'txt_campaignName' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
            'txt_expectedCloseDate' => [
                'label'  => 'Expected Close Date',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Expected Close Date is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();
            $arrData = [
                'campaign_name'             => $fields['txt_campaignName'],
                'campaign_status'           => $fields['slc_campaignStatus'],
                'product'                   => $fields['txt_product'],
                'expected_close_date'       => $fields['txt_expectedCloseDate'],
                'target_size'               => $fields['txt_targetSize'],
                'campaign_type'             => $fields['slc_campaignType'],
                'target_audience'           => $fields['txt_targetAudience'],
                'sponsor'                   => $fields['txt_sponsor'],
                'num_sent'                  => $fields['txt_numSent'],
                'assigned_to'               => $fields['slc_assignedTo'],
                'budget_cost'               => $fields['txt_budgetCost'],
                'expected_response'         => $fields['txt_expectedResponse'],
                'expected_sales_count'      => $fields['txt_expectedSalesCount'],
                'expected_response_count'   => $fields['txt_expectedResponseCount'],
                'expected_roi'              => $fields['txt_expectedROI'],
                'actual_cost'               => $fields['txt_actualCost'],
                'expected_revenue'          => $fields['txt_expectedRevenue'],
                'actual_sales_count'        => $fields['txt_actualSalesCount'],
                'actual_response_count'     => $fields['txt_actualResponseCount'],
                'actual_roi'                => $fields['txt_actualROI'],
                'campaign_description'      => $fields['txt_description'],
                'updated_by'                => $this->session->get('arkonorllc_user_id')
            ];

            $result = $this->campaigns->editCampaign($arrData, $fields['txt_campaignId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";

            // campaign updates
            $actionDetails = $arrData;

            $arrData = [
              'campaign_id'       => $fields['txt_campaignId'],
              'actions'           => 'Updated Campaign',
              'action_details'    => json_encode($actionDetails),
              'action_author'     => 'Campaign',
              'action_icon'       => 'fa-pen',
              'action_background' => 'bg-dark',
              'created_by'        => $this->session->get('arkonorllc_user_id'),
              'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->campaigns->addCampaignUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeCampaign()
    {
        $fields = $this->request->getPost();

        $result = $this->campaigns->removeCampaign($fields['campaignId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function loadCampaignDetails()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->loadCampaignDetails($fields['campaignId']);
        return $this->response->setJSON($data);
    }









    public function loadCampaignUpdates()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->loadCampaignUpdates($fields['campaignId']);

        $arrResult = [];
        foreach ($data as $key => $value) {
            $arrResult[] = [
                'id'                => $value['id'],
                'campaign_id'       => $value['campaign_id'],
                'actions'           => $value['actions'],
                'action_details'    => json_decode(str_replace("\/","/",$value['action_details']),true),
                'action_author'     => $value['action_author'],
                'action_icon'       => $value['action_icon'],
                'action_background' => $value['action_background'],
                'created_by_name'   => $value['created_by_name'],
                'created_by'        => $value['created_by'],
                'created_date'      => $value['created_date'],
                'date_created'      => $value['date_created'],
                'time_created'      => $value['time_created'],
                'date_now'          => date('Y-m-d H:i:s')
            ];
        }

        return $this->response->setJSON($arrResult);
    }











    public function loadSelectedContactCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->loadSelectedContactCampaigns($fields['campaignId']);
        return $this->response->setJSON($data);
    }

    public function loadUnlinkContacts()
    {
        $fields = $this->request->getGet();

        $arrData = $this->campaigns->loadContactCampaigns($fields['campaignId']);

        $arrContactIds = [];
        foreach($arrData as $key => $value)
        {
            $arrContactIds[] = $value['contact_id']; 
        }

        $data = $this->contacts->loadUnlinkContacts($arrContactIds);
        return $this->response->setJSON($data);
    }






    public function loadCampaignActivities()
    {
        $fields = $this->request->getGet();

        $arrData['arrEvents'] = $this->campaigns->loadCampaignEvents($fields['campaignId']);
        $arrData['arrTasks'] = $this->campaigns->loadCampaignTasks($fields['campaignId']);

        $data = [];
        foreach ($arrData['arrEvents'] as $key => $value) 
        {
            $data[] = [
                'eventId'           => $value['id'],
                'status'            => $value['status'],
                'activityType'      => 'Event',
                'subject'           => $value['subject'],
                'startDate'         => $value['start_date'],
                'startTime'         => $value['start_time'],
                'endDate'           => $value['end_date'],
                'endTime'           => $value['end_time'],
                // 'assignedTo'        => $value['']
            ];
        }

        foreach ($arrData['arrTasks'] as $key => $value) 
        {
            
        }

        return $this->response->setJSON($data);
    }






    public function loadSelectedOrganizationCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->loadSelectedOrganizationCampaigns($fields['campaignId']);
        return $this->response->setJSON($data);
    }

    public function loadUnlinkOrganizations()
    {
        $fields = $this->request->getGet();

        $arrData = $this->campaigns->loadOrganizationCampaigns($fields['campaignId']);

        $arrOrganizationIds = [];
        foreach($arrData as $key => $value)
        {
            $arrOrganizationIds[] = $value['organization_id']; 
        }

        $data = $this->organizations->loadUnlinkOrganizations($arrOrganizationIds);
        return $this->response->setJSON($data);
    }
}
