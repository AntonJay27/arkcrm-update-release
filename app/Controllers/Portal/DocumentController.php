<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class DocumentController extends BaseController
{
    public function __construct()
    {
        $this->contacts          = model('Portal/Contacts');
        $this->organizations     = model('Portal/Organizations');
        $this->documents         = model('Portal/Documents');
        $this->email_templates   = model('Portal/EmailTemplates');
        $this->users             = model('Portal/Users');
    }


    public function loadUsers()
    {
        $whereParams = [];
        $arrResult = $this->users->loadUsers($whereParams);
        return $this->response->setJSON($arrResult);
    }


    public function loadDocuments()
    {
        $data = $this->documents->loadDocuments();
        return $this->response->setJSON($data);
    }

    public function addDocument()
    {
        $this->validation->setRules([
            'txt_title' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
                ],
            ],
            'slc_assignedToDocument' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            if($fields['slc_uploadtype'] == 1)
            {
               $count = 1;
               foreach($this->request->getFileMultiple('file_fileName') as $file)
               {   
                  $temp = explode(".", $file->getClientName());
                  $newfilename = round(microtime(true)) . $count . '.' . end($temp);
                  $file->move(FCPATH . 'public/assets/uploads/documents/', $newfilename);
                  $arrData = [
                     'title'             => $fields['txt_title'],
                     'type'              => $fields['slc_uploadtype'],
                     'file_name'         => $newfilename,
                     'file_type'         => $file->getClientMimeType(),
                     'file_size'         => $file->getSize(),
                     'notes'             => $fields['txt_notes'],
                     'assigned_to'       => $fields['slc_assignedToDocument'],
                     'created_by'        => $this->session->get('arkonorllc_user_id'),
                     'created_date'      => date('Y-m-d H:i:s')
                  ];
                  $count++;
               }
            }
            else
            {
               $arrData = [
                  'title'             => $fields['txt_title'],
                  'type'              => $fields['slc_uploadtype'],
                  'file_url'          => $fields['txt_fileUrl'],
                  'notes'             => $fields['txt_notes'],
                  'assigned_to'       => $fields['slc_assignedToDocument'],
                  'created_by'        => $this->session->get('arkonorllc_user_id'),
                  'created_date'      => date('Y-m-d H:i:s')
               ];
            }           

            $insertId = $this->documents->addDocument($arrData);
            $msgResult[] = ($insertId > 0)? "Success" : "Database error";

            //document updates
            $arrData = [
                'document_id'       => $insertId,
                'actions'           => 'Created Document',
                'action_details'    => 'Bla bla',
                'action_author'     => 'Document',
                'action_icon'       => 'fa-plus',
                'action_background' => 'bg-success',
                'created_by'        => $this->session->get('arkonorllc_user_id'),
                'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->documents->addDocumentUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectDocument()
    {
        $fields = $this->request->getGet();

        $documentId = $fields['documentId'];

        $data = $this->documents->selectDocument($documentId);
        $data['uploadLast'] = dayTime($data['created_date']);
        return $this->response->setJSON($data);
    }

    public function editDocument()
    {
        $this->validation->setRules([
            'txt_title' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
                ],
            ],
            'slc_assignedToDocument' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            if($fields['slc_uploadtype'] == 1)
            {
               $count = 1;
               foreach($this->request->getFileMultiple('file_fileName') as $file)
               {   
                  $temp = explode(".", $file->getClientName());
                  $newfilename = round(microtime(true)) . $count . '.' . end($temp);
                  $file->move(FCPATH . 'public/assets/uploads/documents/', $newfilename);
                  $arrData = [
                     'title'             => $fields['txt_title'],
                     'type'              => $fields['slc_uploadtype'],
                     'file_name'         => $newfilename,
                     'file_type'         => $file->getClientMimeType(),
                     'file_size'         => $file->getSize(),
                     'notes'             => $fields['txt_notes'],
                     'assigned_to'       => $fields['slc_assignedToDocument'],
                     'updated_by'        => $this->session->get('arkonorllc_user_id'),
                     'updated_date'      => date('Y-m-d H:i:s')
                  ];
                  $count++;
               }

               $arrDocumentData = $this->documents->selectDocument($fields['txt_documentId']);
               unlink(ROOTPATH . 'public/assets/uploads/documents/' . $arrDocumentData['file_name']);
            }
            else
            {
               $arrData = [
                   'title'             => $fields['txt_title'],
                   'type'              => $fields['slc_uploadtype'],
                   'file_url'          => $fields['txt_fileUrl'],
                   'notes'             => $fields['txt_notes'],
                   'assigned_to'       => $fields['slc_assignedToDocument'],
                   'updated_by'        => $this->session->get('arkonorllc_user_id'),
                   'updated_date'      => date('Y-m-d H:i:s')
               ];
            }           

            $result = $this->documents->editDocument($arrData, $fields['txt_documentId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";

            //document updates
            $arrData = [
                'document_id'       => $fields['txt_documentId'],
                'actions'           => 'Updated Document',
                'action_details'    => 'Bla bla',
                'action_author'     => 'Document',
                'action_icon'       => 'fa-pen',
                'action_background' => 'bg-success',
                'created_by'        => $this->session->get('arkonorllc_user_id'),
                'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->documents->addDocumentUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeDocument()
    {
        $fields = $this->request->getPost();
        $arrContactData = $this->documents->loadContactDocuments($fields['documentId']);
        $arrOrganizationData = $this->documents->loadOrganizationDocuments($fields['documentId']);
        if($arrContactData == null && $arrOrganizationData == null)
        {
            $result = $this->documents->removeDocument($fields['documentId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = "Unable to remove document, it's either linked to Organization or Contact";
        }
        
        return $this->response->setJSON($msgResult);
    }


    public function downloadDocument()
    {
      $fields = $this->request->getGet();
      $arrDocumentData = $this->documents->selectDocument($fields['documentId']);
      $count = ($arrDocumentData['download_count'] != null)? (int)$arrDocumentData['download_count'] : 0;
      $count += 1;
      $arrData = [
         'download_count' => $count
      ];
      $result = $this->documents->editDocument($arrData, $fields['documentId']);
      $msgResult[] = ($result > 0)? "Success" : "Database error";

      //document updates
      $arrData = [
          'document_id'       => $fields['documentId'],
          'actions'           => 'Download Document',
          'action_details'    => 'Bla bla',
          'action_author'     => 'Document',
          'action_icon'       => 'fa-pen',
          'action_background' => 'bg-success',
          'created_by'        => $this->session->get('arkonorllc_user_id'),
          'created_date'      => date('Y-m-d H:i:s')
      ];
      $this->documents->addDocumentUpdates($arrData);

      return $this->response->setJSON($msgResult);
    }


    public function loadDocumentUpdates()
    {
        $fields = $this->request->getGet();

        $data = $this->documents->loadDocumentUpdates($fields['documentId']);

        $arrResult = [];
        foreach ($data as $key => $value) {
            $arrResult[] = [
                'id'                => $value['id'],
                'document_id'       => $value['document_id'],
                'actions'           => $value['actions'],
                'action_details'    => $value['action_details'],
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




    public function loadSelectedContactDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->documents->loadSelectedContactDocuments($fields['documentId']);
        return $this->response->setJSON($data);
    }

    public function loadUnlinkContacts()
    {
        $fields = $this->request->getGet();

        $arrData = $this->documents->loadContactDocuments($fields['documentId']);

        $arrContactIds = [];
        foreach($arrData as $key => $value)
        {
            $arrContactIds[] = $value['contact_id']; 
        }

        $data = $this->contacts->loadUnlinkContacts($arrContactIds);
        return $this->response->setJSON($data);
    }
    







    
    public function loadSelectedOrganizationDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->documents->loadSelectedOrganizationDocuments($fields['documentId']);
        return $this->response->setJSON($data);
    }

    public function loadUnlinkOrganizations()
    {
        $fields = $this->request->getGet();

        $arrData = $this->documents->loadOrganizationDocuments($fields['documentId']);

        $arrOrganizationIds = [];
        foreach($arrData as $key => $value)
        {
            $arrOrganizationIds[] = $value['organization_id']; 
        }

        $data = $this->organizations->loadUnlinkOrganizations($arrOrganizationIds);
        return $this->response->setJSON($data);
    }
}
