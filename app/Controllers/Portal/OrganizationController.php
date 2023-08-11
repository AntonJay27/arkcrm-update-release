<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class OrganizationController extends BaseController
{
    public function __construct()
    {
        
        

        $this->organizations    = model('Portal/Organizations');
        $this->contacts         = model('Portal/Contacts');
        $this->email_templates  = model('Portal/EmailTemplates');
        $this->documents        = model('Portal/Documents');
        $this->campaigns        = model('Portal/Campaigns');
        $this->events           = model('Portal/Events');
        $this->tasks            = model('Portal/Tasks');
        $this->email_config     = model('Portal/EmailConfigurations');


    }

    public function loadUsers()
    {
         $arrResult = $this->organizations->loadUsers();
         return $this->response->setJSON($arrResult);
    }

    public function loadOrganizations()
    {
        $data = $this->organizations->loadOrganizations();
        return $this->response->setJSON($data);
    }

    public function addOrganization()
    {
        $this->validation->setRules([
            'txt_organizationName' => [
                'label'  => 'Organization Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Organization Name is required',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
            'txt_primaryEmail' => [
                'label'  => 'Primary Email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Primary Email is required',
                    'valid_email' => 'Email must be valid',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $msgResult = [];

            $arrData = [
                'organization_name'     => $fields['txt_organizationName'],
                'primary_email'         => $fields['txt_primaryEmail'],
                'secondary_email'       => $fields['txt_secondaryEmail'],
                'main_website'          => $fields['txt_mainWebsite'],
                'other_website'         => $fields['txt_otherWebsite'],
                'phone_number'          => $fields['txt_phoneNumber'],
                'fax'                   => $fields['txt_fax'],
                'linkedin_url'          => $fields['txt_linkedinUrl'],
                'facebook_url'          => $fields['txt_facebookUrl'],
                'twitter_url'           => $fields['txt_twitterUrl'],
                'instagram_url'         => $fields['txt_instagramUrl'],
                'industry'              => $fields['slc_industry'],
                'naics_code'            => $fields['txt_naicsCode'],
                'employee_count'        => $fields['txt_employeeCount'],
                'annual_revenue'        => $fields['txt_annualRevenue'],
                'type'                  => $fields['slc_type'],
                'ticket_symbol'         => $fields['txt_ticketSymbol'],
                'member_of'             => ($fields['slc_memberOf'] == "")? NULL : $fields['slc_memberOf'],
                'email_opt_out'         => $fields['slc_emailOptOut'],
                'assigned_to'           => ($fields['slc_assignedTo'] == "")? NULL : $fields['slc_assignedTo'],
                'billing_street'        => $fields['txt_billingStreet'],
                'billing_city'          => $fields['txt_billingCity'],
                'billing_state'         => $fields['txt_billingState'],
                'billing_zip'           => $fields['txt_billingZip'],
                'billing_country'       => $fields['txt_billingCountry'],
                'shipping_street'       => $fields['txt_shippingStreet'],
                'shipping_city'         => $fields['txt_shippingCity'],
                'shipping_state'        => $fields['txt_shippingState'],
                'shipping_zip'          => $fields['txt_shippingZip'],
                'shipping_country'      => $fields['txt_shippingCountry'],
                'description'           => $fields['txt_description'],
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];

            /////////////////////////
            // organization picture start
            /////////////////////////
            $imageFile = $this->request->getFile('profilePicture');

            if($imageFile != null)
            {
                $newFileName = $imageFile->getRandomName();
                $imageFile->move(ROOTPATH . 'public/assets/uploads/images/organizations', $newFileName);

                if($imageFile->hasMoved())
                {
                    $arrData['picture'] = $newFileName;
                }
            }
            else
            {
                $arrData['picture'] = NULL;
            }
            ///////////////////////
            // organization picture end
            ///////////////////////

            $insertId = $this->organizations->addOrganization($arrData);
            $msgResult[] = ($insertId > 0)? "Success" : "Database error";

            // organization updates
            $actionDetails = $arrData;

            $arrData = [
                'organization_id'   => $insertId,
                'actions'           => 'Created Organization',
                'action_details'    => json_encode($actionDetails),
                'action_author'     => 'User',
                'action_icon'       => 'fa-user',
                'action_background' => 'bg-success',
                'created_by'        => $this->session->get('arkonorllc_user_id'),
                'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->organizations->addOrganizationUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectOrganization()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->selectOrganization($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function editOrganization()
    {
        $this->validation->setRules([
            'txt_organizationName' => [
                'label'  => 'Organization Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Organization Name is required',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
            'txt_primaryEmail' => [
                'label'  => 'Primary Email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Primary Email is required',
                    'valid_email' => 'Email must be valid',
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'organization_name'     => $fields['txt_organizationName'],
                'primary_email'         => $fields['txt_primaryEmail'],
                'secondary_email'       => $fields['txt_secondaryEmail'],
                'main_website'          => $fields['txt_mainWebsite'],
                'other_website'         => $fields['txt_otherWebsite'],
                'phone_number'          => $fields['txt_phoneNumber'],
                'fax'                   => $fields['txt_fax'],
                'linkedin_url'          => $fields['txt_linkedinUrl'],
                'facebook_url'          => $fields['txt_facebookUrl'],
                'twitter_url'           => $fields['txt_twitterUrl'],
                'instagram_url'         => $fields['txt_instagramUrl'],
                'industry'              => $fields['slc_industry'],
                'naics_code'            => $fields['txt_naicsCode'],
                'employee_count'        => $fields['txt_employeeCount'],
                'annual_revenue'        => $fields['txt_annualRevenue'],
                'type'                  => $fields['slc_type'],
                'ticket_symbol'         => $fields['txt_ticketSymbol'],
                'member_of'             => ($fields['slc_memberOf'] == "")? NULL : $fields['slc_memberOf'],
                'email_opt_out'         => $fields['slc_emailOptOut'],
                'assigned_to'           => ($fields['slc_assignedTo'] == "")? NULL : $fields['slc_assignedTo'],
                'billing_street'        => $fields['txt_billingStreet'],
                'billing_city'          => $fields['txt_billingCity'],
                'billing_state'         => $fields['txt_billingState'],
                'billing_zip'           => $fields['txt_billingZip'],
                'billing_country'       => $fields['txt_billingCountry'],
                'shipping_street'       => $fields['txt_shippingStreet'],
                'shipping_city'         => $fields['txt_shippingCity'],
                'shipping_state'        => $fields['txt_shippingState'],
                'shipping_zip'          => $fields['txt_shippingZip'],
                'shipping_country'      => $fields['txt_shippingCountry'],
                'description'           => $fields['txt_description'],
                'updated_by'            => $this->session->get('arkonorllc_user_id'),
                'updated_date'          => date('Y-m-d H:i:s')
            ];

            /////////////////////////
            // organization picture start
            /////////////////////////
            $imageFile = $this->request->getFile('profilePicture');

            if($imageFile != null)
            {
                $newFileName = $imageFile->getRandomName();
                $imageFile->move(ROOTPATH . 'public/assets/uploads/images/organizations', $newFileName);

                if($imageFile->hasMoved())
                {
                    $arrResult = $this->organizations->loadOrganizationPicture($fields['txt_organizationId']);

                    if($arrResult['picture'] != null)
                    {
                        unlink(ROOTPATH . 'public/assets/uploads/images/organizations/' . $arrResult['picture']);
                    }                    

                    $arrData['picture'] = $newFileName;
                }
            }
            else
            {
                $arrData['picture'] = NULL;
            }         
            ///////////////////////
            // organization picture end
            ///////////////////////

            $result = $this->organizations->editOrganization($arrData, $fields['txt_organizationId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";

            // organization updates
            $actionDetails = $arrData;

            $arrData = [
                'organization_id'   => $fields['txt_organizationId'],
                'actions'           => 'Updated Organization',
                'action_details'    => json_encode($actionDetails),
                'action_author'     => 'User',
                'action_icon'       => 'fa-pen',
                'action_background' => 'bg-dark',
                'created_by'        => $this->session->get('arkonorllc_user_id'),
                'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->organizations->addOrganizationUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeOrganization()
    {
        $fields = $this->request->getPost();

        $result = $this->organizations->removeOrganization($fields['organizationId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }



    function checkOnDb($forUpload = [])
    {
        $primaryEmails = [];
        foreach($forUpload as $key => $value)
        {
            $primaryEmails[] = $value['primary_email'];
        }

        $resultForUpdate = $this->organizations->checkOnDb($primaryEmails);

        $forUpdate = [];
        $forInsert = [];
        foreach ($forUpload as $key1 => $value1) 
        {
            $existing = false;
            $showInfo = false;
            if($resultForUpdate != null)
            {
                foreach ($resultForUpdate as $key2 => $value2) 
                {
                    if($value1['primary_email'] == $value2['primary_email'])
                    {
                        $existing = true;
                    }
                }
            }            

            if($existing)
            {
                // for update
                $forUpdate[] = $value1;
            }
            else
            {
                // for insert
                $forInsert[] = $value1;
            }
        }

        $arrDbResult['forUpdate'] = $forUpdate;
        $arrDbResult['forInsert'] = $forInsert;

        return $arrDbResult;

        // return $resultForUpdate;
    }

    public function checkOrganizationFile()
    {
      $file = $this->request->getFile('organizationList');

      if ($file->isValid() && ! $file->hasMoved()) 
      {
          $file_data = $file->getName();
          $path = $file->getTempName();

          $ext = pathinfo($path, PATHINFO_EXTENSION);

          $arrData = readUploadFile($path);

          $validColumns = [];
          foreach($arrData[0] as $key => $value)
          {
              $arrVal = ["NULL","null","","N/A","n/a","NA","na"];
              if(!in_array($value,$arrVal))
              {
                  $validColumns[] = $value;
              }
          }
          array_shift($arrData);
          $arrResult = [];
          $arrResult['upload_res'] = "";
          if(count($validColumns) == 29 && count($arrData) > 0)
          {
              $newArrData = [];
              foreach ($arrData as $key => $value) 
              {
                  $newArrData[] = [
                     'organization_name'     => checkData($value[0]),
                     'primary_email'         => checkData($value[1]),
                     'secondary_email'       => checkData($value[2]),
                     'main_website'          => checkData($value[3]),
                     'other_website'         => checkData($value[4]),
                     'phone_number'          => checkData($value[5]),
                     'fax'                   => checkData($value[6]),
                     'linkedin_url'          => checkData($value[7]),
                     'facebook_url'          => checkData($value[8]),
                     'twitter_url'           => checkData($value[9]),
                     'instagram_url'         => checkData($value[10]),
                     'industry'              => checkData($value[11]),
                     'naics_code'            => checkData($value[12]),
                     'employee_count'        => checkData($value[13]),
                     'annual_revenue'        => checkData($value[14]),
                     'type'                  => checkData($value[15]),
                     'email_opt_out'         => checkData($value[16]),
                     'billing_street'        => checkData($value[17]),
                     'billing_city'          => checkData($value[18]),
                     'billing_state'         => checkData($value[19]),
                     'billing_zip'           => checkData($value[20]),
                     'billing_country'       => checkData($value[21]),
                     'shipping_street'       => checkData($value[22]),
                     'shipping_city'         => checkData($value[23]),
                     'shipping_state'        => checkData($value[24]),
                     'shipping_zip'          => checkData($value[25]),
                     'shipping_country'      => checkData($value[26]),
                     'description'           => checkData($value[27]),
                     'unsubscribe_auth_code' => encrypt_code(generate_code()),
                     'assigned_to'           => $this->session->get('arkonorllc_user_id'),
                     'created_by'            => $this->session->get('arkonorllc_user_id'),
                     'created_date'          => (checkData($value[28]) == "")? date('Y-m-d H:i:s') : date_format(date_create(checkData($value[28])),"Y-m-d H:i:s")
                  ];
              }
              $uniqueColumns = ['primary_email','secondary_email'];
              $checkDuplicateResult = checkDuplicateRows($newArrData, $uniqueColumns);

              if(count($checkDuplicateResult['rowData']) > 0)
              {
                  $checkOnDbResult = $this->checkOnDb($checkDuplicateResult['rowData']);

                  $arrResult['for_update'] = $checkOnDbResult['forUpdate'];
                  $arrResult['for_insert'] = $checkOnDbResult['forInsert'];
                  $arrResult['conflict_rows'] = $checkDuplicateResult['rowConflictData'];
              }
              else
              {
                  $arrResult['for_update'] = [];
                  $arrResult['for_insert'] = [];
                  $arrResult['conflict_rows'] = $checkDuplicateResult['rowConflictData'];
              }
          }
          else
          {
              $arrResult['upload_res'] = "Invalid file, maybe columns does not match or no data found!";
          }    
      }
      else
      {
          $arrResult[] = "Invalid File";
      }

      return $this->response->setJSON($arrResult);
    }

    public function uploadOrganizations()
    {
      $fields = $this->request->getPost();

      $forInsert = (isset($fields['rawData']['forInsert']))? json_decode($fields['rawData']['forInsert'],true) : [];

      $arrWhere = 'primary_email';

      // insert
      if(count($forInsert) > 0)
      {
          $arrForInsert = [];
          foreach ($forInsert as $key => $value) 
          {
              $password = encrypt_code(generate_code());
              $arrForInsert[] = [
                  'organization_name'     => $value['organization_name'],
                  'primary_email'         => $value['primary_email'],
                  'secondary_email'       => $value['secondary_email'],
                  'main_website'          => $value['main_website'],
                  'other_website'         => $value['other_website'],
                  'phone_number'          => $value['phone_number'],
                  'fax'                   => $value['fax'],
                  'linkedin_url'          => $value['linkedin_url'],
                  'facebook_url'          => $value['facebook_url'],
                  'twitter_url'           => $value['twitter_url'],
                  'instagram_url'         => $value['instagram_url'],
                  'industry'              => $value['industry'],
                  'naics_code'            => $value['naics_code'],
                  'employee_count'        => $value['employee_count'],
                  'annual_revenue'        => $value['annual_revenue'],
                  'type'                  => $value['type'],
                  'email_opt_out'         => $value['email_opt_out'],
                  'billing_street'        => $value['billing_street'],
                  'billing_city'          => $value['billing_city'],
                  'billing_state'         => $value['billing_state'],
                  'billing_zip'           => $value['billing_zip'],
                  'billing_country'       => $value['billing_country'],
                  'shipping_street'       => $value['shipping_street'],
                  'shipping_city'         => $value['shipping_city'],
                  'shipping_state'        => $value['shipping_state'],
                  'shipping_zip'          => $value['shipping_zip'],
                  'shipping_country'      => $value['shipping_country'],
                  'description'           => $value['description'],
                  'unsubscribe_auth_code' => encrypt_code(generate_code()),
                  'assigned_to'           => $this->session->get('arkonorllc_user_id'),
                  'created_by'            => $this->session->get('arkonorllc_user_id'),
                  'created_date'          => ($value['created_date'] == "")? date('Y-m-d H:i:s') : $value['created_date']
              ];
          }
      }
      //insert
      $uploadResult['inserted_rows'] = (count($forInsert) > 0)?$this->organizations->uploadOrganizations($arrForInsert) : 0;

      return $this->response->setJSON($uploadResult);
    }

    public function organizationConflicts($rawData)
    {
      $Text = json_decode($rawData,true);

      // return $this->response->setJSON($Text);

      $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
      $date = str_replace(".", "", $date);
      $filename = "export_".$date.".xlsx";

      downloadOrganizationConflicts($filename,$Text);
    }




    public function loadOrganizationSummary()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationSummary($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function loadOrganizationDetails()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationDetails($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function loadOrganizationUpdates()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationUpdates($fields['organizationId']);

        $arrResult = [];
        foreach ($data as $key => $value) {
            $arrResult[] = [
                'id'                => $value['id'],
                'organization_id'   => $value['organization_id'],
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

    public function loadOrganizationContacts()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationContacts($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function addContactToOrganization()
    {
      $this->validation->setRules([
          'txt_lastName' => [
              'label'  => 'Last Name',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Last Name is required',
              ],
          ],
          'slc_assignedToContact' => [
              'label'  => 'Assigned To',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Assigned To is required',
              ],
          ]
      ]);

      if($this->validation->withRequest($this->request)->run())
      {
          $fields = $this->request->getPost();

          $msgResult = [];

          $arrData = [
              'salutation'            => $fields['slc_salutation'],
              'first_name'            => $fields['txt_firstName'],
              'last_name'             => $fields['txt_lastName'],
              'organization_id'       => $fields['slc_companyName'],
              'primary_email'         => $fields['txt_primaryEmail'],
              'office_phone'          => $fields['txt_officePhone'],
              'assigned_to'           => ($fields['slc_assignedToContact'] == "")? NULL : $fields['slc_assignedToContact'],
              'unsubscribe_auth_code' => encrypt_code(generate_code()),
              'created_by'            => $this->session->get('arkonorllc_user_id'),
              'created_date'          => date('Y-m-d H:i:s')
          ];

          $insertId = $this->contacts->addContact($arrData);
          if($insertId != 0)
          {
              $arrAddressData = [
                  'contact_id'        => $insertId,
                  'created_by'        => $this->session->get('arkonorllc_user_id'),
                  'created_date'      => date('Y-m-d H:i:s')
              ];
              $arrDescriptionData = [
                  'contact_id'        => $insertId,
                  'created_by'        => $this->session->get('arkonorllc_user_id'),
                  'created_date'      => date('Y-m-d H:i:s')
              ];

              /////////////////////////
              // contact picture start
              /////////////////////////
              $arrPictureData = [
                  'contact_id'    => $insertId,
                  'picture'       => NULL,
                  'created_by'    => $this->session->get('arkonorllc_user_id'),
                  'created_date'  => date('Y-m-d H:i:s')
              ];                
              ///////////////////////
              // contact picture end
              ///////////////////////

              $result = $this->contacts->addContactDetails($arrAddressData, $arrDescriptionData, $arrPictureData);
              $msgResult[] = ($result > 0)? "Success" : "Database error"; 

              // contact updates
              $actionDetails = [
                'salutation'            => $fields['slc_salutation'],
                'first_name'            => $fields['txt_firstName'],
                'last_name'             => $fields['txt_lastName'],
                'organization_id'       => ($fields['slc_companyName'] == "")? NULL : $fields['slc_companyName'],
                'primary_email'         => $fields['txt_primaryEmail']
              ];

              $arrData = [
                  'contact_id'        => $insertId,
                  'actions'           => 'Quick Create Contact',
                  'action_details'    => json_encode($actionDetails),
                  'action_author'     => 'User',
                  'action_icon'       => 'fa-user',
                  'action_background' => 'bg-success',
                  'created_by'        => $this->session->get('arkonorllc_user_id'),
                  'created_date'      => date('Y-m-d H:i:s')
              ];
              $this->contacts->addContactUpdates($arrData);

              if($fields['slc_companyName'] != "")
              {
                // organization updates
                $arrContacts[] = [
                  'contact_id'  => $insertId,
                  'salutation'  => $fields['slc_salutation'],
                  'first_name'  => $fields['txt_firstName'],
                  'last_name'   => $fields['txt_lastName'],
                ];
                $actionDetails = $arrContacts;

                $arrData = [
                    'organization_id'   => $fields['slc_companyName'],
                    'actions'           => 'Linked Contact To Organization',
                    'action_details'    => json_encode($actionDetails),
                    'action_author'     => 'User',
                    'action_icon'       => 'fa-link',
                    'action_background' => 'bg-success',
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];
                $this->organizations->addOrganizationUpdates($arrData);
              }
          }
      }
      else
      {
          $msgResult[] = $this->validation->getErrors();
      }

      return $this->response->setJSON($msgResult);
    }

    public function unlinkOrganizationContact()
    {
        $fields = $this->request->getPost();

        $contactDetails = $this->contacts->selectContact($fields['contactId']);
        $arrContact = [
          'contact_id'  => $contactDetails['id'],
          'salutation'  => $contactDetails['salutation'],
          'first_name'  => $contactDetails['first_name'],
          'last_name'   => $contactDetails['last_name'],
        ];

        $organizationDetails = $this->organizations->selectOrganization($contactDetails['organization_id']);
        $arrOrganization = [
          'organization_id'   => $organizationDetails['id'],
          'organization_name' => $organizationDetails['organization_name'],
        ];

        $result = $this->organizations->unlinkOrganizationContact($fields['contactId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = $arrOrganization;

        $arrData = [
            'contact_id'        => $fields['contactId'],
            'actions'           => 'Unlinked Contact From Organization',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-unlink',
            'action_background' => 'bg-dark',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        // organization updates
        $actionDetails = $arrContact;

        $arrData = [
            'organization_id'   => $contactDetails['organization_id'],
            'actions'           => 'Unlink Contact From Organization',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-unlink',
            'action_background' => 'bg-dark',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkOrganizationContacts()
    {
        $fields = $this->request->getGet();

        $organizationId = $fields['organizationId'];

        $arrData = $this->organizations->loadOrganizationContacts($organizationId);

        $arrContactIds = [];
        foreach($arrData as $key => $value)
        {
            $arrContactIds[] = $value['id']; 
        }

        $data = $this->contacts->loadUnlinkContacts($arrContactIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedOrganizationContacts()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        $arrContacts = [];
        $arrOrganizations = [];
        foreach(explode(',',$fields['arrSelectedContacts']) as $key => $value)
        {
          $arrData[] = ['id'=>$value, 'organization_id'=>$fields['organizationId']];
          
          $contactDetails = $this->contacts->selectContact($value);
          $arrContacts[] = [
            'contact_id'  => $contactDetails['id'],
            'salutation'  => $contactDetails['salutation'],
            'first_name'  => $contactDetails['first_name'],
            'last_name'   => $contactDetails['last_name'],
          ];

          $organizationDetails = $this->organizations->selectOrganization($fields['organizationId']);
          $arrOrganizations = [
            'organization_id'   => $organizationDetails['id'],
            'organization_name' => $organizationDetails['organization_name'],
          ];

          // contact updates
          $actionDetails = $arrOrganizations;

          $arrDataUpdates = [
              'contact_id'        => $value,
              'actions'           => 'Linked Contact To Organization',
              'action_details'    => json_encode($actionDetails),
              'action_author'     => 'User',
              'action_icon'       => 'fa-link',
              'action_background' => 'bg-success',
              'created_by'        => $this->session->get('arkonorllc_user_id'),
              'created_date'      => date('Y-m-d H:i:s')
          ];
          $this->contacts->addContactUpdates($arrDataUpdates);
        }

        $result = $this->organizations->addSelectedOrganizationContacts($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // organization updates
        $actionDetails = $arrContacts;

        $arrData = [
            'organization_id'   => $fields['organizationId'],
            'actions'           => 'Linked Contact To Organization',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-link',
            'action_background' => 'bg-success',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }







    public function loadOrganizationActivities()
    {
        $fields = $this->request->getGet();

        $arrData['arrEvents'] = $this->organizations->loadOrganizationEvents($fields['organizationId']);
        $arrData['arrTasks'] = $this->organizations->loadOrganizationTasks($fields['organizationId']);

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







    public function loadOrganizationEmails()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationEmails($fields['organizationId']);
        return $this->response->setJSON($data);
    }








    public function loadOrganizationDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationDocuments($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function unlinkOrganizationDocument()
    {
        $fields = $this->request->getPost();

        $arrDocument = $this->organizations->selectOrganizationDocument($fields['organizationDocumentId']);

        $result = $this->organizations->unlinkOrganizationDocument($fields['organizationDocumentId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // organization updates
        $actionDetails = $arrDocument;

        $arrData = [
            'organization_id'   => $arrDocument['organization_id'],
            'actions'           => 'Unlinked Organization Document',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-unlink',
            'action_background' => 'bg-dark',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkOrganizationDocuments()
    {
        $fields = $this->request->getGet();

        $arrData = $this->organizations->loadOrganizationDocuments($fields['organizationId']);

        $arrDocumentIds = [];
        foreach($arrData as $key => $value)
        {
            $arrDocumentIds[] = $value['document_id']; 
        }

        $data = $this->documents->loadUnlinkDocuments($arrDocumentIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedOrganizationDocuments()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedDocuments']))
        {
            foreach(explode(',',$fields['arrSelectedDocuments']) as $key => $value)
            {
               $arrDocument = $this->documents->selectDocument($value);
               $arrDocument['organization_id'] = $fields['organizationId'];
               $arrDataUpdates[] = $arrDocument;
               $arrData[] = ['organization_id'=>$fields['organizationId'], 'document_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedOrganizations']) as $key => $value)
            {
               $arrDocument = $this->documents->selectDocument($fields['documentId']);
               $arrDocument['organization_id'] = $value;
               $arrDataUpdates[] = $arrDocument;
               $arrData[] = ['organization_id'=>$value, 'document_id'=>$fields['documentId']];
            }
        }

        $result = $this->organizations->addSelectedOrganizationDocuments($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // organization updates
        $actionDetails = $arrDataUpdates;

        $arrData = [
            'organization_id'   => $fields['organizationId'],
            'actions'           => 'Linked Organization Document',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-link',
            'action_background' => 'bg-success',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function addOrganizationDocument()
    {
        $this->validation->setRules([
            'txt_title' => [
                'label'  => 'Title',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Title is required',
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

            $arrData = [
                'title'       => $fields['txt_title'],
                'assigned_to' => $fields['slc_assignedToDocument'],
                'type'        => $fields['slc_uploadtype'],
                'notes'       => $fields['txt_notes'],
                'created_by'  => $this->session->get('arkonorllc_user_id'),
                'created_date'=> date('Y-m-d H:i:s')
            ];
            if($fields['slc_uploadtype'] == 1)
            {
                $arrData['file_name'] = '';
            }
            else
            {
                $arrData['file_url'] = $fields['txt_fileUrl'];
            }

            $documentId = $this->documents->addDocument($arrData);
            if($documentId > 0)
            {
                $arrData = [
                    'organization_id' => $fields['txt_organizationId'],
                    'document_id' => $documentId,
                    'created_by'  => $this->session->get('arkonorllc_user_id'),
                    'created_date'=> date('Y-m-d H:i:s')
                ];

                $result = $this->organizations->addOrganizationDocument($arrData);
                $msgResult[] = ($result > 0)? "Success" : "Database error";
            }
            else
            {
                $msgResult[] = "Unable to save the document";
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }









    public function loadOrganizationCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationCampaigns($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function unlinkOrganizationCampaign()
    {
        $fields = $this->request->getPost();

        $arrCampaign = $this->organizations->selectOrganizationCampaign($fields['organizationCampaignId']);

        $result = $this->organizations->unlinkOrganizationCampaign($fields['organizationCampaignId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // organization updates
        $actionDetails = $arrCampaign;

        $arrData = [
            'organization_id'   => $arrCampaign['organization_id'],
            'actions'           => 'Unlinked Organization Campaign',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-unlink',
            'action_background' => 'bg-dark',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkOrganizationCampaigns()
    {
        $fields = $this->request->getGet();

        $arrData = $this->organizations->loadOrganizationCampaigns($fields['organizationId']);

        $arrCampaignIds = [];
        foreach($arrData as $key => $value)
        {
            $arrCampaignIds[] = $value['campaign_id']; 
        }

        $data = $this->campaigns->loadUnlinkOrganizationCampaigns($arrCampaignIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedOrganizationCampaigns()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedCampaigns']))
        {
            foreach(explode(',',$fields['arrSelectedCampaigns']) as $key => $value)
            {
                $arrCampaign = $this->campaigns->selectCampaign($value);
                $arrCampaign['organization_id'] = $fields['organizationId'];
                $arrDataUpdates[] = $arrCampaign;
                $arrData[] = ['organization_id'=>$fields['organizationId'], 'campaign_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedOrganizations']) as $key => $value)
            {
                $arrCampaign = $this->campaigns->selectCampaign($fields['campaignId']);
                $arrCampaign['organization_id'] = $value;
                $arrDataUpdates[] = $arrCampaign;
                $arrData[] = ['organization_id'=>$value, 'campaign_id'=>$fields['campaignId']];
            }
        }

        $result = $this->organizations->addSelectedOrganizationCampaigns($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

         // contact updates
         $actionDetails = $arrDataUpdates;

         $arrData = [
             'organization_id'   => $fields['organizationId'],
             'actions'           => 'Linked Organization Campaign',
             'action_details'    => json_encode($actionDetails),
             'action_author'     => 'User',
             'action_icon'       => 'fa-link',
             'action_background' => 'bg-success',
             'created_by'        => $this->session->get('arkonorllc_user_id'),
             'created_date'      => date('Y-m-d H:i:s')
         ];
         $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }





    //organization comments

    public function loadOrganizationComments()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationComments($fields['organizationId']);

        $arrResult = [];
        foreach ($data as $key => $value) {
            $arrResult[] = [
                'id'                => $value['id'],
                'organization_id'   => $value['organization_id'],
                'comment_id'        => $value['comment_id'],
                'comment'           => $value['comment'],
                'created_by'        => $value['created_by'],
                'user_picture'      => $value['user_picture'],
                'created_by_name'   => $value['created_by_name'],
                'created_date'      => $value['created_date'],
                'date_now'          => date('Y-m-d H:i:s')
            ];
        }
        return $this->response->setJSON($arrResult);
    }

    public function addOrganizationCommentSummary()
    {
        $fields = $this->request->getPost();

        $arrData = [
            'organization_id'   => $fields['txt_organizationId'],
            'comment_id'        => NULL,
            'comment'           => $fields['txt_summaryComments'],
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $result = $this->organizations->addOrganizationComment($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // organization updates
        $actionDetails = [
          'comment'           => $fields['txt_summaryComments'],
        ];

        $arrData = [
            'organization_id'   => $fields['txt_organizationId'],
            'actions'           => 'Comment',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-comment',
            'action_background' => 'bg-primary',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function addOrganizationComment()
    {
        $fields = $this->request->getPost();

        $arrData = [
            'organization_id'   => $fields['txt_organizationId'],
            'comment_id'        => NULL,
            'comment'           => $fields['txt_comments'],
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $result = $this->organizations->addOrganizationComment($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // organization updates
        $actionDetails = [
          'comment'           => $fields['txt_comments'],
        ];
        $arrData = [
            'organization_id'   => $fields['txt_organizationId'],
            'actions'           => 'Comment',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-comment',
            'action_background' => 'bg-primary',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function replyOrganizationComment()
    {
        $fields = $this->request->getPost();

        $arrData = [
            'organization_id'   => $fields['txt_organizationId'],
            'comment_id'        => $fields['txt_replyCommentId'],
            'comment'           => $fields['txt_replyComments'],
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $result = $this->organizations->addOrganizationComment($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // organization updates
        $actionDetails = [
          'comment'           => $fields['txt_replyComments'],
        ];
        $arrData = [
            'organization_id'   => $fields['txt_organizationId'],
            'actions'           => 'Replied Comment',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-comment',
            'action_background' => 'bg-primary',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }



    // send email

    public function selectEmailTemplate()
    {
        $fields = $this->request->getGet();

        $templateData = $this->email_templates->selectTemplate($fields['templateId']);

        $data = $templateData;

        $organizationData = $this->organizations->selectOrganization($fields['organizationId']);

        foreach ($organizationData as $key => $value) 
        {
            $newOrganizationData['__'.$key.'__'] = $value; 
        }   

        $data['template_subject'] = load_substitutions($newOrganizationData, $templateData['template_subject']);
        $data['template_content'] = load_substitutions($newOrganizationData, $templateData['template_content']);

        return $this->response->setJSON($data);
    }

    public function sendOrganizationEmail()
    {
        $fields = $this->request->getPost();

        $config = $this->email_config->selectEmailConfig();

        $emailConfig = [
         'smtp_host'    => $config['smtp_host'],
         'smtp_port'    => $config['smtp_port'],
         'smtp_crypto'  => $config['smtp_crypto'],
         'smtp_user'    => $config['smtp_user'],
         'smtp_pass'    => decrypt_code($config['smtp_pass']),
         'mail_type'    => $config['mail_type'],
         'charset'      => $config['charset'],
         'word_wrap'    => $config['word_wrap']
        ];

        $emailSender    = $config['from_email'];
        $emailReceiver  = $fields['txt_to'];

        $arrData = $this->organizations->selectOrganization($fields['txt_organizationId']);

        $data['subjectTitle'] = $fields['txt_subject'];
        $data['emailContent'] = $fields['txt_content'];
        $unsubscribeLink = "organization-unsubscribe/".$fields['txt_organizationId']."/".decrypt_code($arrData['unsubscribe_auth_code'])."/".$fields['txt_to'];
        $data['unsubscribeLink'] = (isset($fields['chk_unsubscribe']))? $unsubscribeLink : "";

        $emailResult = sendSliceMail('organization_email',$emailConfig,$emailSender,$emailReceiver,$data);

        $arrData = [];
        if($emailResult > 0)
        {
            $arrData = [
                'email_subject' => $fields['txt_subject'],
                'email_content' => $fields['txt_content'],
                'email_status'  => 'Sent',
                'sent_to'       => $fields['txt_organizationId'],
                'sent_by'       => $this->session->get('arkonorllc_user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            ];
        }
        else
        {
            $arrData = [
                'email_subject' => $fields['txt_subject'],
                'email_content' => $fields['txt_content'],
                'email_status'  => 'Not sent',
                'sent_to'       => $fields['txt_organizationId'],
                'sent_by'       => $this->session->get('arkonorllc_user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->organizations->saveOrganizationEmails($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database Error";

        // organization updates
        $actionDetails = [
            'email_subject' => $fields['txt_subject'],
            'email_content' => $fields['txt_content'],
            'email_status'  => ($emailResult > 0)? 'Sent' : 'Not sent',
            'sent_to'       => $fields['txt_organizationId'],
            'sent_by'       => $this->session->get('arkonorllc_user_id'),
            'created_date'  => date('Y-m-d H:i:s')
        ];
        $arrData = [
            'organization_id'   => $fields['txt_organizationId'],
            'actions'           => 'Sent Email',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-envelope',
            'action_background' => 'bg-success',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->organizations->addOrganizationUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }
}
