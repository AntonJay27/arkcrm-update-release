<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class EmailTemplateController extends BaseController
{
    public function __construct()
    {
        $this->email_templates = model('Portal/EmailTemplates');
        $this->users = model('Portal/Users');
    }

    public function loadTemplates($categories)
    {
         $userId = $this->session->get('arkonorllc_user_id');
        $arrUserData = $this->users->selectUser($userId);
        $data = $this->email_templates->loadTemplates($categories, $arrUserData);
        return $this->response->setJSON($data);
    }

    public function addTemplate()
    {
        $this->validation->setRules([
            'slc_category' => [
                'label'  => 'Category Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Category Name is required',
                ],
            ],
            'txt_templateName' => [
                'label'  => 'Template Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Template Name is required',
                ],
            ],
            'slc_templateVisibility' => [
                'label'  => 'Accessibility',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Accessibility is required',
                ],
            ],
            'txt_subject' => [
                'label'  => 'Subject',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Subject is required',
                ],
            ],
            'txt_content' => [
                'label'  => 'Content',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Content is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'template_name'         => $fields['txt_templateName'],
                'template_category'     => $fields['slc_category'],
                'template_description'  => $fields['txt_description'],
                'template_subject'      => $fields['txt_subject'],
                'template_content'      => $fields['txt_content'],
                'template_visibility'   => $fields['slc_templateVisibility'],
                'template_status'       => "1",
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];
            $result = $this->email_templates->addTemplate($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Error! <br>Database error.";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectTemplate()
    {
        $fields = $this->request->getGet();
        $data = $this->email_templates->selectTemplate($fields['templateId']);
        return $this->response->setJSON($data);
    }

    public function editTemplate()
    {
        $this->validation->setRules([
            'slc_category' => [
                'label'  => 'Category Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Category Name is required',
                ],
            ],
            'txt_templateName' => [
                'label'  => 'Template Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Template Name is required',
                ],
            ],
            'slc_templateVisibility' => [
                'label'  => 'Accessibility',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Accessibility is required',
                ],
            ],
            'txt_subject' => [
                'label'  => 'Subject',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Subject is required',
                ],
            ],
            'txt_content' => [
                'label'  => 'Content',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Content is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'template_name'         => $fields['txt_templateName'],
                'template_category'     => $fields['slc_category'],
                'template_description'  => $fields['txt_description'],
                'template_subject'      => $fields['txt_subject'],
                'template_content'      => $fields['txt_content'],
                'template_visibility'   => $fields['slc_templateVisibility'],
                'template_status'       => "1",
                'updated_by'            => $this->session->get('arkonorllc_user_id'),
                'updated_date'          => date('Y-m-d H:i:s')
            ];
            $result = $this->email_templates->editTemplate($arrData, $fields['txt_templateId']);
            $msgResult[] = ($result > 0)? "Success" : "Error! <br>Database error.";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeTemplate()
    {
        $fields = $this->request->getPost();

        $result = $this->email_templates->removeTemplate($fields['templateId']);
        $msgResult[] = ($result > 0)? "Success" : "Error! <br>Database error.";

        return $this->response->setJSON($msgResult);
    }
}
