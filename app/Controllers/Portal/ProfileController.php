<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    public function __construct()
    {
        $this->profiles  = model('Portal/Profiles');
    }

    public function loadProfiles()
    {
        $arrProfiles = $this->profiles->loadProfiles();

        return $this->response->setJSON($arrProfiles);
    }

    public function addProfile()
    {
        $this->validation->setRules([
            'txt_profileName' => [
                'label'  => 'Profile Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Profile Name is required',
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'profile_name'          => $fields['txt_profileName'],
                'description'           => $fields['txt_description'],
                'modules_and_fields'    => $fields['arrModulesAndFields'],
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];

            $result = $this->profiles->addProfile($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Database error"; 
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectProfile()
    {
        $fields = $this->request->getGet();

        $data = $this->profiles->selectProfile($fields['profileId']);
        $data['modules_and_fields'] = json_decode($data['modules_and_fields']);
        return $this->response->setJSON($data);
    }

    public function editProfile()
    {
        $this->validation->setRules([
            'txt_profileName' => [
                'label'  => 'Profile Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Profile Name is required',
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'profile_name'          => $fields['txt_profileName'],
                'description'           => $fields['txt_description'],
                'modules_and_fields'    => $fields['arrModulesAndFields'],
                'updated_by'            => $this->session->get('arkonorllc_user_id'),
                'updated_date'          => date('Y-m-d H:i:s')
            ];

            $result = $this->profiles->editProfile($arrData, $fields['txt_profileId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error"; 
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeProfile()
    {
        $fields = $this->request->getPost();

        $result = $this->profiles->removeProfile($fields['profileId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }
}
