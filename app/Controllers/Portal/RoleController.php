<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class RoleController extends BaseController
{
    public function __construct()
    {
        $this->roles = model('Portal/Roles');
    }

    public function loadRoles()
    {
        $arrProfiles = $this->roles->loadRoles();
        return $this->response->setJSON($arrProfiles);
    }

    public function addRole()
    {
        $this->validation->setRules([
            'txt_roleName' => [
                'label'  => 'Role Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Role Name is required',
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'role_name'             => $fields['txt_roleName'],
                'reports_to'            => ($fields['slc_reportsTo'] == "")? null : $fields['slc_reportsTo'],
                'sub_role'              => 0,
                'can_assign_records_to' => $fields['canAssignRecordsTo'],
                'privileges'            => $fields['privileges'],
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];

            if($fields['privileges'] == 'assign-privileges-directly-to-role')
            {
                $arrData['modules_and_fields'] = $fields['arrModulesAndFields'];
            }
            else
            {
                $arrData['profiles'] = $fields['profiles'];
            }

            $result = $this->roles->addRole($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Database error";

            if($fields['slc_reportsTo'] != "")
            {
               $arrData = [
                  'sub_role' => 1
               ];
               $this->roles->editRole($arrData, $fields['slc_reportsTo']);
            } 
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectRole()
    {
        $fields = $this->request->getGet();

        $data = $this->roles->selectRole($fields['roleId']);
        $data['profiles'] = $data['profiles'];
        $data['modules_and_fields'] = json_decode($data['modules_and_fields']);
        return $this->response->setJSON($data);
    }

    public function editRole()
    {
        $this->validation->setRules([
            'txt_roleName' => [
                'label'  => 'Role Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Role Name is required',
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'role_name'             => $fields['txt_roleName'],
                'reports_to'            => ($fields['slc_reportsTo'] == "")? null : $fields['slc_reportsTo'],
                'can_assign_records_to' => $fields['canAssignRecordsTo'],
                'privileges'            => $fields['privileges'],
                'updated_by'            => $this->session->get('arkonorllc_user_id'),
                'updated_date'          => date('Y-m-d H:i:s')
            ];

            if($fields['privileges'] == 'assign-privileges-directly-to-role')
            {
                $arrData['profiles'] = null;
                $arrData['modules_and_fields'] = $fields['arrModulesAndFields'];
            }
            else
            {
                $arrData['profiles'] = $fields['profiles'];
                $arrData['modules_and_fields'] = null;
            }

            $result = $this->roles->editRole($arrData, $fields['txt_roleId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error"; 
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeRole()
    {
        $fields = $this->request->getPost();

        $arrRoleUser = $this->roles->loadUsers($fields['roleId']);

        if(count($arrRoleUser) > 0)
        {
            $msgResult[] = "Unable to remove role, " . count($arrRoleUser) . " user(s) uses this role";
        }
        else
        {
            $roleData = $this->roles->selectRole($fields['roleId']);
            $subRoleData = $this->roles->loadSubRoles($fields['roleId']);

            foreach ($subRoleData as $key => $value) 
            {
                $arrData = [
                   'reports_to' => $roleData['reports_to']
                ];
                $this->roles->editRole($arrData, $value['id']);
            }

            $result = $this->roles->removeRole($fields['roleId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }

        
        return $this->response->setJSON($msgResult);
    }

    public function loadOrganizationName()
    {
      $arrData['organization_name'] = $_ENV['ORGANIZATION_NAME'];
      return $this->response->setJSON($arrData);
    }

    public function editOrganizationName()
    {
      $fields = $this->request->getPost();

      $myfile = file_get_contents(FCPATH.".env");

      $myfile = preg_replace('/ORGANIZATION_NAME/i', $fields['txt_organizationName'], $myfile);

      $result = file_put_contents(FCPATH.".env",$myfile);
    }
}
