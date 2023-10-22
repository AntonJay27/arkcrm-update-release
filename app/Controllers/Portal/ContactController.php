<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class ContactController extends BaseController
{

    public $_arrContactList = [];
    public $_arrOptions = [];
    public $_duplicateHandler = '';

    public function __construct()
    {
        
        


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
         $arrResult = $this->contacts->loadUsers();
         return $this->response->setJSON($arrResult);
    }
    

    public function loadContacts()
    {
        if(session()->has('arkonorllc_user_loggedIn'))
        {
            if(session()->get('arkonorllc_user_loggedIn'))
            {
                $arrResult = $this->contacts->loadContacts();
                return $this->response->setJSON($arrResult);
            }
            else
            {
                return $this->response->setJSON('Access denied!');
            }
        }
        else
        {
            return $this->response->setJSON('Access denied!');
        }        
    }

    public function addContact()
    {
        $this->validation->setRules([
            'txt_lastName' => [
                'label'  => 'Last Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Last Name is required',
                ],
            ],
            'slc_assignedTo' => [
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
                'position'              => $fields['txt_position'],
                'organization_id'       => ($fields['slc_companyName'] == "")? NULL : $fields['slc_companyName'],
                'primary_email'         => $fields['txt_primaryEmail'],
                'secondary_email'       => $fields['txt_secondaryEmail'],
                'date_of_birth'         => $fields['txt_birthDate'],
                'intro_letter'          => $fields['slc_introLetter'],
                'office_phone'          => $fields['txt_officePhone'],
                'mobile_phone'          => $fields['txt_mobilePhone'],
                'home_phone'            => $fields['txt_homePhone'],
                'secondary_phone'       => $fields['txt_secondaryPhone'],
                'fax'                   => $fields['txt_fax'],
                'do_not_call'           => $fields['chk_doNotCall'],
                'linkedin_url'          => $fields['txt_linkedinUrl'],
                'twitter_url'           => $fields['txt_twitterUrl'],
                'facebook_url'          => $fields['txt_facebookUrl'],
                'instagram_url'         => $fields['txt_instagramUrl'],
                'lead_source'           => $fields['slc_leadSource'],
                'department'            => $fields['txt_department'],
                'reports_to'            => ($fields['slc_reportsTo'] == "")? NULL : $fields['slc_reportsTo'],
                'assigned_to'           => ($fields['slc_assignedTo'] == "")? NULL : $fields['slc_assignedTo'],
                'email_opt_out'         => $fields['slc_emailOptOut'],
                'unsubscribe_auth_code' => encrypt_code(generate_code()),
                'mailing_street'        => $fields['txt_mailingStreet'],
                'mailing_po_box'        => $fields['txt_mailingPOBox'],
                'mailing_city'          => $fields['txt_mailingCity'],
                'mailing_state'         => $fields['txt_mailingState'],
                'mailing_zip'           => $fields['txt_mailingZip'],
                'mailing_country'       => $fields['txt_mailingCountry'],
                'other_street'          => $fields['txt_otherStreet'],
                'other_po_box'          => $fields['txt_otherPOBox'],
                'other_city'            => $fields['txt_otherCity'],
                'other_state'           => $fields['txt_otherState'],
                'other_zip'             => $fields['txt_otherZip'],
                'other_country'         => $fields['txt_otherCountry'],
                'description'           => $fields['txt_description'],
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];

            /////////////////////////
            // contact picture start
            /////////////////////////
            $imageFile = $this->request->getFile('profilePicture');

            if($imageFile != null)
            {
                $newFileName = $imageFile->getRandomName();
                $imageFile->move(ROOTPATH . 'public/assets/uploads/images/contacts', $newFileName);

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
            // contact picture end
            ///////////////////////

            $insertId = $this->contacts->addContact($arrData);
            $msgResult[] = ($insertId > 0)? "Success" : "Database error"; 

            // contact updates
            $actionDetails = $arrData;

            $arrData = [
                'contact_id'        => $insertId,
                'actions'           => 'Created Contact',
                'action_details'    => json_encode($actionDetails),
                'action_author'     => 'User',
                'action_icon'       => 'fa-user',
                'action_background' => 'bg-success',
                'created_by'        => $this->session->get('arkonorllc_user_id'),
                'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->contacts->addContactUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectContact()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->selectContact($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function editContact()
    {
        $this->validation->setRules([
            'txt_lastName' => [
                'label'  => 'Last Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Last Name is required',
                ],
            ],
            'slc_assignedTo' => [
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

            $arrData = [
                'salutation'        => $fields['slc_salutation'],
                'first_name'        => $fields['txt_firstName'],
                'last_name'         => $fields['txt_lastName'],
                'position'          => $fields['txt_position'],
                'organization_id'   => ($fields['slc_companyName'] == "")? NULL : $fields['slc_companyName'],
                'primary_email'     => $fields['txt_primaryEmail'],
                'secondary_email'   => $fields['txt_secondaryEmail'],
                'date_of_birth'     => $fields['txt_birthDate'],
                'intro_letter'      => $fields['slc_introLetter'],
                'office_phone'      => $fields['txt_officePhone'],
                'mobile_phone'      => $fields['txt_mobilePhone'],
                'home_phone'        => $fields['txt_homePhone'],
                'secondary_phone'   => $fields['txt_secondaryPhone'],
                'fax'               => $fields['txt_fax'],
                'do_not_call'       => $fields['chk_doNotCall'],
                'linkedin_url'      => $fields['txt_linkedinUrl'],
                'twitter_url'       => $fields['txt_twitterUrl'],
                'facebook_url'      => $fields['txt_facebookUrl'],
                'instagram_url'     => $fields['txt_instagramUrl'],
                'lead_source'       => $fields['slc_leadSource'],
                'department'        => $fields['txt_department'],
                'reports_to'        => ($fields['slc_reportsTo'] == "")? NULL : $fields['slc_reportsTo'],
                'assigned_to'       => ($fields['slc_assignedTo'] == "")? NULL : $fields['slc_assignedTo'],
                'email_opt_out'     => $fields['slc_emailOptOut'],
                'mailing_street'    => $fields['txt_mailingStreet'],
                'mailing_po_box'    => $fields['txt_mailingPOBox'],
                'mailing_city'      => $fields['txt_mailingCity'],
                'mailing_state'     => $fields['txt_mailingState'],
                'mailing_zip'       => $fields['txt_mailingZip'],
                'mailing_country'   => $fields['txt_mailingCountry'],
                'other_street'      => $fields['txt_otherStreet'],
                'other_po_box'      => $fields['txt_otherPOBox'],
                'other_city'        => $fields['txt_otherCity'],
                'other_state'       => $fields['txt_otherState'],
                'other_zip'         => $fields['txt_otherZip'],
                'other_country'     => $fields['txt_otherCountry'],
                'description'       => $fields['txt_description'],
                'updated_by'        => $this->session->get('arkonorllc_user_id'),
                'updated_date'      => date('Y-m-d H:i:s')
            ];

            /////////////////////////
            // contact picture start
            /////////////////////////
            $imageFile = $this->request->getFile('profilePicture');

            if($imageFile != null)
            {
                $newFileName = $imageFile->getRandomName();
                $imageFile->move(ROOTPATH . 'public/assets/uploads/images/contacts', $newFileName);

                if($imageFile->hasMoved())
                {
                    $arrResult = $this->contacts->loadContactPicture($fields['txt_contactId']);

                    if($arrResult['picture'] != null)
                    {
                        unlink(ROOTPATH . 'public/assets/uploads/images/contacts/' . $arrResult['picture']);
                    }                    

                    $arrData['picture'] = $newFileName;
                }
            }
            else
            {
                $arrData['picture'] = NULL;
            }
            ///////////////////////
            // contact picture end
            ///////////////////////

            $result = $this->contacts->editContact($arrData, $fields['txt_contactId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";

            // contact updates
            $actionDetails = $arrData;

            $arrData = [
                'contact_id'        => $fields['txt_contactId'],
                'actions'           => 'Updated Contact',
                'action_details'    => json_encode($actionDetails),
                'action_author'     => 'User',
                'action_icon'       => 'fa-pen',
                'action_background' => 'bg-dark',
                'created_by'        => $this->session->get('arkonorllc_user_id'),
                'created_date'      => date('Y-m-d H:i:s')
            ];
            $this->contacts->addContactUpdates($arrData);
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeContact()
    {
        $fields = $this->request->getPost();

        $result = $this->contacts->removeContact($fields['contactId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    // function checkOnDb($forUpload = [])
    // {
    //     $primaryEmails = [];
    //     foreach($forUpload as $key => $value)
    //     {
    //         $primaryEmails[] = $value['primary_email'];
    //     }

    //     $resultForUpdate = $this->contacts->checkOnDb($primaryEmails);

    //     $forUpdate = [];
    //     $forInsert = [];
    //     foreach ($forUpload as $key1 => $value1) 
    //     {
    //         $existing = false;
    //         $showInfo = false;
    //         if($resultForUpdate != null)
    //         {
    //             foreach ($resultForUpdate as $key2 => $value2) 
    //             {
    //                 if($value1['primary_email'] == $value2['primary_email'])
    //                 {
    //                     $existing = true;
    //                 }
    //             }
    //         }            

    //         if($existing)
    //         {
    //             // for update
    //             $forUpdate[] = $value1;
    //         }
    //         else
    //         {
    //             // for insert
    //             $forInsert[] = $value1;
    //         }
    //     }

    //     $arrDbResult['forUpdate'] = $forUpdate;
    //     $arrDbResult['forInsert'] = $forInsert;

    //     return $arrDbResult;

    //     // return $resultForUpdate;
    // }

    // public function checkContactFile()
    // {
    //   $file = $this->request->getFile('contactList');

    //   if ($file->isValid() && ! $file->hasMoved()) 
    //   {
    //       $file_data = $file->getName();
    //       $path = $file->getTempName();

    //       $ext = pathinfo($path, PATHINFO_EXTENSION);

    //       $arrData = readUploadFile($path);

    //       $validColumns = [];
    //       foreach($arrData[0] as $key => $value)
    //       {
    //           $arrVal = ["NULL","null","","N/A","n/a","NA","na"];
    //           if(!in_array($value,$arrVal))
    //           {
    //               $validColumns[] = $value;
    //           }
    //       }
    //       array_shift($arrData);
    //       $arrResult = [];
    //       $arrResult['upload_res'] = "";
    //       if(count($validColumns) == 34 && count($arrData) > 0)
    //       {
    //           $newArrData = [];
    //           foreach ($arrData as $key => $value) 
    //           {
    //               $newArrData[] = [
    //                  'salutation'           => checkData($value[0]),
    //                  'first_name'           => checkData($value[1]),
    //                  'last_name'            => checkData($value[2]),
    //                  'date_of_birth'        => checkData($value[3]),
    //                  'position'             => checkData($value[4]),
    //                  'organization_id'      => checkData($value[5]),
    //                  'primary_email'        => checkData($value[6]),
    //                  'secondary_email'      => checkData($value[7]),
    //                  'office_phone'         => checkData($value[8]),
    //                  'mobile_phone'         => checkData($value[9]),
    //                  'home_phone'           => checkData($value[10]),
    //                  'secondary_phone'      => checkData($value[11]),
    //                  'fax'                  => checkData($value[12]),
    //                  'do_not_call'          => checkData($value[13]),
    //                  'linkedin_url'         => checkData($value[14]),
    //                  'twitter_url'          => checkData($value[15]),
    //                  'instagram_url'        => checkData($value[16]),
    //                  'facebook_url'         => checkData($value[17]),
    //                  'lead_source'          => checkData($value[18]),
    //                  'department'           => checkData($value[19]),
    //                  'email_opt_out'        => checkData($value[20]),
    //                  'mailing_street'       => checkData($value[21]),
    //                  'mailing_po_box'       => checkData($value[22]),
    //                  'mailing_city'         => checkData($value[23]),
    //                  'mailing_state'        => checkData($value[24]),
    //                  'mailing_zip'          => checkData($value[25]),
    //                  'mailing_country'      => checkData($value[26]),
    //                  'other_street'         => checkData($value[27]),
    //                  'other_po_box'         => checkData($value[28]),
    //                  'other_city'           => checkData($value[29]),
    //                  'other_state'          => checkData($value[30]),
    //                  'other_zip'            => checkData($value[31]),
    //                  'other_country'        => checkData($value[32]),
    //                  'description'          => checkData($value[33]),
    //                  'unsubscribe_auth_code'=> encrypt_code(generate_code()),
    //                  'assigned_to'          => $this->session->get('arkonorllc_user_id'),
    //                  'created_by'           => $this->session->get('arkonorllc_user_id'),
    //                  'created_date'         => date('Y-m-d H:i:s')
    //               ];
    //           }
    //           $uniqueColumns = ['primary_email','secondary_email'];
    //           $checkDuplicateResult = checkDuplicateRows($newArrData, $uniqueColumns);

    //           if(count($checkDuplicateResult['rowData']) > 0)
    //           {
    //               $checkOnDbResult = $this->checkOnDb($checkDuplicateResult['rowData']);

    //               $arrResult['for_update'] = $checkOnDbResult['forUpdate'];
    //               $arrResult['for_insert'] = $checkOnDbResult['forInsert'];
    //               $arrResult['conflict_rows'] = $checkDuplicateResult['rowConflictData'];
    //           }
    //           else
    //           {
    //               $arrResult['for_update'] = [];
    //               $arrResult['for_insert'] = [];
    //               $arrResult['conflict_rows'] = $checkDuplicateResult['rowConflictData'];
    //           }
    //       }
    //       else
    //       {
    //           $arrResult['upload_res'] = "Invalid file, maybe columns does not match or no data found!";
    //       }    
    //   }
    //   else
    //   {
    //       $arrResult[] = "Invalid File";
    //   }

    //   return $this->response->setJSON($arrResult);
    // }


    public function uploadFileContact()
    {
        $fields = $this->request->getPost();

        $file = $this->request->getFile('contactList');

        $arrResult = [];

        if ($file->isValid() && ! $file->hasMoved()) 
        {
            $file_data = $file->getName();
            $path = $file->getTempName();

            $ext = pathinfo($path, PATHINFO_EXTENSION);

            $arrData = readUploadFile($path);

            $validColumns = [];
            $arrHeader = [];
            foreach($arrData[0] as $key => $value)
            {
                $arrVal = ["NULL","null","","N/A","n/a","NA","na"];
                if(!in_array($value,$arrVal))
                {
                    $validColumns[] = $value;
                    if($fields['chk_hasHeader'] == 'NO')
                    {
                        $arrHeader[] = "";
                    }
                }
            }

            if(count($validColumns) > 0)
            {
                if($fields['chk_hasHeader'] == 'YES')
                {
                    $arrResult['arrHeader'] = $arrData[0];
                    array_shift($arrData);
                }
                else
                {
                    $arrResult['arrHeader'] = $arrHeader;
                }
                $arrResult['arrContactList'] = $arrData;
            }
            else
            {
                $arrResult[] = "Your file is empty!";
            }

            // $arrResult['arrHeader'] = $arrData[0];

            // $validColumns = [];
            // foreach($arrData[0] as $key => $value)
            // {
            //     $arrVal = ["NULL","null","","N/A","n/a","NA","na"];
            //     if(!in_array($value,$arrVal))
            //     {
            //         $validColumns[] = $value;
            //     }
            // }
            // array_shift($arrData);
          
            // $arrResult['arrContactList'] = $arrData;
        }
        else
        {
            $arrResult[] = "Invalid File";
        }

        return $this->response->setJSON($arrResult);
    }

    public function duplicateHandlingContact()
    {
        $fields = $this->request->getPost();

        $this->_arrContactList = json_decode($fields['arrContactList'],true);
        $this->_arrOptions = json_decode($fields['arrOptions'],true);
        $this->_duplicateHandler = $fields['slc_duplicateHandler'];

        $arrResult = $this->_arrContactList;

        return $this->response->setJSON($arrResult);
    }

    public function loadCustomMapsContact()
    {
        $fields = $this->request->getGet();

        $arrData = $this->contacts->loadCustomMapsContact($fields['mapType']);
        return $this->response->setJSON($arrData);
    }

    public function selectCustomMapContact()
    {
        $fields = $this->request->getGet();

        $arrData = $this->contacts->selectCustomMapContact($fields['mapId']);
        $arrNewData = [
            'id'            => $arrData['id'],
            'map_name'      => $arrData['map_name'],
            'map_fields'    => json_decode($arrData['map_fields'],true),
            'map_values'    => json_decode($arrData['map_values'],true),
        ];
        return $this->response->setJSON($arrNewData);
    }

    public function reviewDataContact()
	{
		$fields = $this->request->getPost();

		// get map fields and set as headers/indexes
		$arrMapFields 	= json_decode($fields['arrMapFields'],true);
		$arrHeaders 	= [];
		for ($i=0; $i < count($arrMapFields); $i++) 
		{ 
			if($arrMapFields[$i] != null)
			{
				$arrHeaders[] = $arrMapFields[$i];
			}
		} 

		// get organization list in array object with row number
		$arrContactList    	    = json_decode($fields['arrContactList'],true);
		$arrDefaultValues       = json_decode($fields['arrDefaultValues'],true);
		$hasHeader 				= $fields['chk_hasHeader'];
		$arrContactsDataList 	= [];
		$rowNumber 				= ($hasHeader == 'YES')? 2 : 1;
		foreach ($arrContactList as $key => $value) 
		{
			$arrColumns['row_number'] = $rowNumber;
			for ($i=0; $i < count($arrMapFields); $i++) 
			{ 
				if($arrMapFields[$i] != null)
				{
					if(checkEmptyField($value[$i]) != '')
					{
						$arrColumns[$arrMapFields[$i]] = $value[$i];
					}
					else
					{
						$arrColumns[$arrMapFields[$i]] = $arrDefaultValues[$i];
					}
				}
			}  
			$arrContactsDataList[] = $arrColumns;    
			$rowNumber++;      
		}

		
		
		// Duplicate Handling
		$duplicateHandlerStatus 	= $fields['duplicateHandlerStatus'];
		$arrDuplicateHandler    	= json_decode($fields['arrDuplicateHandler'],true);
		$arrDuplicateRowsFromFile 	= [];
		$arrDataForImport 			= [];
		if($duplicateHandlerStatus == "YES")
		{
			// Compress duplicate handling fields
			$arrDuplicateHandlerFields = [];
			foreach ($arrDuplicateHandler[1] as $key => $value) 
			{
				if(in_array($value,$arrMapFields))
				{
					$arrDuplicateHandlerFields[] = $value;
				}
			}
			$arrCheckDuplicateFromFileResult = checkDuplicateRowsForContacts($arrContactsDataList, $arrDuplicateHandlerFields, $hasHeader);
			$arrDuplicateRowsFromFile = $arrCheckDuplicateFromFileResult['arrDuplicateRows'];

			// Prepare where columns to check duplicate on db
			$arrWhereInColumns = [];
			for ($i=0; $i < count($arrDuplicateHandlerFields); $i++) 
			{ 
				foreach($arrCheckDuplicateFromFileResult['arrNotDuplicateRows'] as $value)
				{
					$arrWhereInColumns[$arrDuplicateHandlerFields[$i]][] = $value[$arrDuplicateHandlerFields[$i]];
				}
			}
			$arrCheckDuplicateFromDatabaseResult = $this->contacts->checkDuplicateRowsForContacts($arrWhereInColumns);
			
			// get duplicate rows on db
			$arrDuplicateRowsFromDatabase = [];
			foreach ($arrCheckDuplicateFromDatabaseResult as $key => $value) 
			{
				$arrData = [];
				$arrData['id'] = $value['id'];
				for ($i=0; $i < count($arrMapFields); $i++) 
				{ 
					if($arrMapFields[$i] != null)
					{
						$arrData[$arrMapFields[$i]] = $value[$arrMapFields[$i]];
					}
				}
				$arrDuplicateRowsFromDatabase[] = $arrData;
			}

			
			
			if($arrDuplicateHandler[0] == 'Skip')
			{
				//lipasan

				// get where in columns or duplicate handler fields
				$arrWhereInColumns = [];
				for ($i=0; $i < count($arrDuplicateHandlerFields); $i++) 
				{ 
					$arrTemp = [];
					foreach($arrDuplicateRowsFromDatabase as $value)
					{
						$arrTemp[$arrDuplicateHandlerFields[$i]][] = $value[$arrDuplicateHandlerFields[$i]];
					}
					$arrWhereInColumns[$arrDuplicateHandlerFields[$i]] = array_unique($arrTemp[$arrDuplicateHandlerFields[$i]]);
				}

				// get no duplicate data for import
				if(count($arrWhereInColumns) > 0)
				{
					foreach ($arrCheckDuplicateFromFileResult['arrNotDuplicateRows'] as $key1 => $value1) 
					{
						$duplicateStatus = false;
						foreach ($arrWhereInColumns as $key2 => $value2) 
						{
							if(in_array($value1[$key2], $value2))
							{
								$duplicateStatus = true;
							}
						}
						if($duplicateStatus == false)
						{
							$value1['id'] = '';
							$arrDataForImport[] = $value1;
						}
					}
				}
				else
				{
					$arrDataForImport = $arrCheckDuplicateFromFileResult['arrNotDuplicateRows'];
				}
			}
			else if($arrDuplicateHandler[0] == 'Override')
			{
				//palitan

				$arrNewData = [];
				foreach ($arrCheckDuplicateFromFileResult['arrNotDuplicateRows'] as $key1 => $value1) 
				{
					$duplicateStatus1 = false;
					foreach ($arrDuplicateRowsFromDatabase as $key2 => $value2) 
					{
						$duplicateStatus2 = false;
						for ($i=0; $i < count($arrDuplicateHandler[1]); $i++) 
						{
							if($value1[$arrDuplicateHandler[1][$i]] == $value2[$arrDuplicateHandler[1][$i]])
							{
								$duplicateStatus1 = true;
								$duplicateStatus2 = true;
							}
						}
						if($duplicateStatus2 == true)
						{
							foreach ($arrHeaders as $key3 => $value3) 
							{
								$value2[$value3] = $value1[$value3];
							}
							$value2['row_number'] = $value1['row_number'];
							$arrNewData[] = $value2;
						}
					}
					if($duplicateStatus1 == false)
					{
						$value1['id'] = "";
						$arrNewData[] = $value1;
					}
				}
				$arrDataForImport = $arrNewData;
			}
			else if($arrDuplicateHandler[0] == 'Merge')
			{
				//pagsamahin
				$arrNewData = [];
				foreach ($arrCheckDuplicateFromFileResult['arrNotDuplicateRows'] as $key1 => $value1) 
				{
					$duplicateStatus1 = false;
					foreach ($arrDuplicateRowsFromDatabase as $key2 => $value2) 
					{
						$duplicateStatus2 = false;
						for ($i=0; $i < count($arrDuplicateHandler[1]); $i++) 
						{
							if($value1[$arrDuplicateHandler[1][$i]] == $value2[$arrDuplicateHandler[1][$i]])
							{
								$duplicateStatus1 = true;
								$duplicateStatus2 = true;
							}
						}
						if($duplicateStatus2 == true)
						{
							foreach ($arrHeaders as $key3 => $value3) 
							{
								if($value2[$value3] == "")
								{
									$value2[$value3] = $value1[$value3];
								}
							}
							$value2['row_number'] = $value1['row_number'];
							$arrNewData[] = $value2;
						}
					}
					if($duplicateStatus1 == false)
					{
						$value1['id'] = "";
						$arrNewData[] = $value1;
					}
				}
				$arrDataForImport = $arrNewData;
				
			}

			$arrData = [];
			$arrData['arrHeaders'] = $arrHeaders;
			$arrData['arrDuplicateHandlerFields'] = $arrDuplicateHandlerFields;
			$arrData['arrDuplicateRowsFromFile'] = $arrDuplicateRowsFromFile;
			$arrData['arrDuplicateRowsFromDatabase'] = $arrDuplicateRowsFromDatabase;
			$arrData['arrDataForImport'] = $arrDataForImport;
			$arrData['arrContactsDataList'] = $arrContactsDataList;
		}
		else
		{
			// skip duplicate handling
			$arrNewData = [];
			foreach ($arrOrganizationsDataList as $key => $value) 
			{
				$value['id'] = '';
				$arrNewData[] = $value;
			}
			$arrDataForImport = $arrNewData;

			$arrData = [];
			$arrData['arrHeaders'] = $arrHeaders;
			$arrData['arrDuplicateHandlerFields'] = [];
			$arrData['arrDuplicateRowsFromFile'] = [];
			$arrData['arrDuplicateRowsFromDatabase'] = [];
			$arrData['arrDataForImport'] = $arrDataForImport;
			$arrData['arrContactsDataList'] = $arrContactsDataList;
		}

		return $this->response->setJSON($arrData);
	}

    public function importContacts()
    {
        $fields = $this->request->getPost();

		$arrContactImport 	= json_decode($fields['arrContactImport'],true);
		$duplicateHandlerStatus = $arrContactImport['duplicateHandlerStatus'];
		$arrDuplicateHandler 	= $arrContactImport['arrDuplicateHandler'];

		$arrDataForInsert = [];
		$arrDataForUpdate = [];
		if($duplicateHandlerStatus == "YES")
		{
			if($arrDuplicateHandler[0] == 'Skip')
			{
				//lipasan
				foreach ($arrContactImport['arrDataForImport'] as $key => $value) 
				{
					unset($value['id']);
					unset($value['row_number']);
					$arrDataForInsert[] = $value;
				}
			}
			else if($arrDuplicateHandler[0] == 'Override' || $arrDuplicateHandler[0] == 'Merge')
			{
				//palitan
				foreach ($arrContactImport['arrDataForImport'] as $key => $value) 
				{
					if($value['id'] == '')
					{
						unset($value['id']);
						unset($value['row_number']);
						$arrDataForInsert[] = $value;
					}
					else
					{
						unset($value['row_number']);
						$arrDataForUpdate[] = $value;
					}
				}
			}
		}
		else
		{
			foreach ($arrContactImport['arrDataForImport'] as $key => $value) 
			{
				unset($value['id']);
				unset($value['row_number']);
				$arrDataForInsert[] = $value;
			}
		}

		$result = $this->contacts->importContacts($arrDataForInsert,$arrDataForUpdate);
		$msgResult[] = ($result > 0)? "Success" : "Database error";

		return $this->response->setJSON($msgResult);
    }
    


    // public function uploadContacts()
    // {
    //   $fields = $this->request->getPost();

    //   $forInsert = (isset($fields['rawData']['forInsert']))? json_decode($fields['rawData']['forInsert'],true) : [];

    //   $arrWhere = 'primary_email';

    //   // insert
    //   if(count($forInsert) > 0)
    //   {
    //       $arrForInsert = [];
    //       foreach ($forInsert as $key => $value) 
    //       {
    //           $password = encrypt_code(generate_code());
    //           $arrForInsert[] = [
    //               'salutation'            => $value['salutation'],
    //               'first_name'            => $value['first_name'],
    //               'last_name'             => $value['last_name'],
    //               'date_of_birth'         => $value['date_of_birth'],
    //               'position'              => $value['position'],
    //               'organization_id'       => $value['organization_id'],
    //               'primary_email'         => $value['primary_email'],
    //               'secondary_email'       => $value['secondary_email'],
    //               'office_phone'          => $value['office_phone'],
    //               'mobile_phone'          => $value['mobile_phone'],
    //               'home_phone'            => $value['home_phone'],
    //               'secondary_phone'       => $value['secondary_phone'],
    //               'fax'                   => $value['fax'],
    //               'do_not_call'           => $value['do_not_call'],
    //               'linkedin_url'          => $value['linkedin_url'],
    //               'twitter_url'           => $value['twitter_url'],
    //               'instagram_url'         => $value['instagram_url'],
    //               'facebook_url'          => $value['facebook_url'],
    //               'lead_source'           => $value['lead_source'],
    //               'department'            => $value['department'],
    //               'email_opt_out'         => $value['email_opt_out'],
    //               'mailing_street'        => $value['mailing_street'],
    //               'mailing_po_box'        => $value['mailing_po_box'],
    //               'mailing_city'          => $value['mailing_city'],
    //               'mailing_state'         => $value['mailing_state'],
    //               'mailing_zip'           => $value['mailing_zip'],
    //               'mailing_country'       => $value['mailing_country'],
    //               'other_street'          => $value['other_street'],
    //               'other_po_box'          => $value['other_po_box'],
    //               'other_city'            => $value['other_city'],
    //               'other_state'           => $value['other_state'],
    //               'other_zip'             => $value['other_zip'],
    //               'other_country'         => $value['other_country'],
    //               'description'           => $value['description'],
    //               'unsubscribe_auth_code' => encrypt_code(generate_code()),
    //               'assigned_to'           => $this->session->get('arkonorllc_user_id'),
    //               'created_by'            => $this->session->get('arkonorllc_user_id'),
    //               'created_date'          => date('Y-m-d H:i:s')
    //           ];
    //       }
    //   }
    //   //insert
    //   $uploadResult['inserted_rows'] = (count($forInsert) > 0)?$this->contacts->uploadContacts($arrForInsert) : 0;

    //   return $this->response->setJSON($uploadResult);
    // }

    // public function contactConflicts($rawData)
    // {
    //   $Text = json_decode($rawData,true);

    //   // return $this->response->setJSON($Text);

    //   $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
    //   $date = str_replace(".", "", $date);
    //   $filename = "export_".$date.".xlsx";

    //   downloadContactConflicts($filename,$Text);
    // }

    public function loadContactSummary()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactSummary($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function loadContactDetails()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactDetails($fields['contactId']);
        return $this->response->setJSON($data);
    }











    public function loadContactUpdates()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactUpdates($fields['contactId']);

        $arrResult = [];
        foreach ($data as $key => $value) {
            $arrResult[] = [
                'id'                => $value['id'],
                'contact_id'        => $value['contact_id'],
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









    public function loadContactActivities()
    {
        $fields = $this->request->getGet();

        $arrData['arrEvents'] = $this->contacts->loadContactEvents($fields['contactId']);
        $arrData['arrTasks'] = $this->contacts->loadContactTasks($fields['contactId']);

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
                'assignedTo'        => $value['']
            ];
        }

        foreach ($arrData['arrTasks'] as $key => $value) 
        {
            
        }

        return $this->response->setJSON($data);
    }












    public function loadContactEmails()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactEmails($fields['contactId']);
        return $this->response->setJSON($data);
    }











    // contact documents

    public function loadContactDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactDocuments($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function unlinkContactDocument()
    {
        $fields = $this->request->getPost();

        $arrDocument = $this->contacts->selectContactDocument($fields['contactDocumentId']);

        $result = $this->contacts->unlinkContactDocument($fields['contactDocumentId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = $arrDocument;

        $arrData = [
            'contact_id'        => $arrDocument['contact_id'],
            'actions'           => 'Unlinked Contact Document',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-unlink',
            'action_background' => 'bg-dark',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkContactDocuments()
    {
        $fields = $this->request->getGet();

        $arrData = $this->contacts->loadContactDocuments($fields['contactId']);

        $arrDocumentIds = [];
        foreach($arrData as $key => $value)
        {
            $arrDocumentIds[] = $value['document_id']; 
        }

        $data = $this->documents->loadUnlinkDocuments($arrDocumentIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedContactDocuments()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedDocuments']))
        {
            foreach(explode(',',$fields['arrSelectedDocuments']) as $key => $value)
            {
               $arrDocument = $this->documents->selectDocument($value);
               $arrDocument['contact_id'] = $fields['contactId'];
               $arrDataUpdates[] = $arrDocument;
               $arrData[] = ['contact_id'=>$fields['contactId'], 'document_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedContacts']) as $key => $value)
            {
               $arrDocument = $this->documents->selectDocument($fields['documentId']);
               $arrDocument['contact_id'] = $value;
               $arrDataUpdates[] = $arrDocument;
               $arrData[] = ['contact_id'=>$value, 'document_id'=>$fields['documentId']];
            }
        }

        $result = $this->contacts->addSelectedContactDocuments($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = $arrDataUpdates;

        $arrData = [
            'contact_id'        => $fields['contactId'],
            'actions'           => 'Linked Contact Document',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-link',
            'action_background' => 'bg-success',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function addContactDocument()
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
               $arrData['file_url'] = $fields['txt_fileUrl'];
            }

            $arrDataDocuments = $arrData;

            $documentId = $this->documents->addDocument($arrData);
            if($documentId > 0)
            {
                $arrData = [
                    'contact_id' => $fields['txt_contactId'],
                    'document_id' => $documentId,
                    'created_by'  => $this->session->get('arkonorllc_user_id'),
                    'created_date'=> date('Y-m-d H:i:s')
                ];
                $arrDataDocuments['document_id'] = $documentId;
                $arrDataUpdates[] = $arrDataDocuments;

                $result = $this->contacts->addContactDocument($arrData);

                // contact updates
                $actionDetails = $arrDataUpdates;

                $arrData = [
                    'contact_id'        => $fields['txt_contactId'],
                    'actions'           => 'Linked Contact Document',
                    'action_details'    => json_encode($actionDetails),
                    'action_author'     => 'User',
                    'action_icon'       => 'fa-link',
                    'action_background' => 'bg-success',
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];
                $this->contacts->addContactUpdates($arrData);

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












    //contact campaign
    public function loadContactCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactCampaigns($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function unlinkContactCampaign()
    {
        $fields = $this->request->getPost();

        $arrCampaign = $this->contacts->selectContactCampaign($fields['contactCampaignId']);

        $result = $this->contacts->unlinkContactCampaign($fields['contactCampaignId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = $arrCampaign;

        $arrData = [
            'contact_id'        => $arrCampaign['contact_id'],
            'actions'           => 'Unlinked Contact Campaign',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-unlink',
            'action_background' => 'bg-dark',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkContactCampaigns()
    {
        $fields = $this->request->getGet();

        $arrData = $this->contacts->loadContactCampaigns($fields['contactId']);

        $arrCampaignIds = [];
        foreach($arrData as $key => $value)
        {
            $arrCampaignIds[] = $value['campaign_id']; 
        }

        $data = $this->campaigns->loadUnlinkContactCampaigns($arrCampaignIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedContactCampaigns()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedCampaigns']))
        {
            foreach(explode(',',$fields['arrSelectedCampaigns']) as $key => $value)
            {
                $arrCampaign = $this->campaigns->selectCampaign($value);
                $arrCampaign['contact_id'] = $fields['contactId'];
                $arrDataUpdates[] = $arrCampaign;
                $arrData[] = ['contact_id'=>$fields['contactId'], 'campaign_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedContacts']) as $key => $value)
            {
                $arrCampaign = $this->campaigns->selectCampaign($fields['campaignId']);
                $arrCampaign['contact_id'] = $value;
                $arrDataUpdates[] = $arrCampaign;
                $arrData[] = ['contact_id'=>$value, 'campaign_id'=>$fields['campaignId']];
            }
        }

        $result = $this->contacts->addSelectedContactCampaigns($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = $arrDataUpdates;

        $arrData = [
            'contact_id'        => $fields['contactId'],
            'actions'           => 'Linked Contact Campaign',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-link',
            'action_background' => 'bg-success',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }
    










    //contact comments

    public function loadContactComments()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactComments($fields['contactId']);

        $arrResult = [];
        foreach ($data as $key => $value) {
            $arrResult[] = [
                'id'                => $value['id'],
                'contact_id'        => $value['contact_id'],
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

    public function addContactCommentSummary()
    {
        $fields = $this->request->getPost();

        $arrData = [
            'contact_id'        => $fields['txt_contactId'],
            'comment_id'        => NULL,
            'comment'           => $fields['txt_summaryComments'],
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $result = $this->contacts->addContactComment($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = [
          'comment'           => $fields['txt_summaryComments']
        ];

        $arrData = [
            'contact_id'        => $fields['txt_contactId'],
            'actions'           => 'Comment',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-comment',
            'action_background' => 'bg-primary',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function addContactComment()
    {
        $fields = $this->request->getPost();

        $arrData = [
            'contact_id'        => $fields['txt_contactId'],
            'comment_id'        => NULL,
            'comment'           => $fields['txt_comments'],
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $result = $this->contacts->addContactComment($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = [
          'comment'             => $fields['txt_comments']
        ];

        $arrData = [
            'contact_id'        => $fields['txt_contactId'],
            'actions'           => 'Comment',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-comment',
            'action_background' => 'bg-primary',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }

    public function replyContactComment()
    {
        $fields = $this->request->getPost();

        $arrData = [
            'contact_id'        => $fields['txt_contactId'],
            'comment_id'        => $fields['txt_replyCommentId'],
            'comment'           => $fields['txt_replyComments'],
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $result = $this->contacts->addContactComment($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";

        // contact updates
        $actionDetails = [
            'comment'             => $fields['txt_replyComments']
        ];

        $arrData = [
            'contact_id'        => $fields['txt_contactId'],
            'actions'           => 'Replied Comment',
            'action_details'    => json_encode($arrData),
            'action_author'     => 'User',
            'action_icon'       => 'fa-comment',
            'action_background' => 'bg-primary',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }



    // send email

    public function selectEmailTemplate()
    {
        $fields = $this->request->getGet();

        $templateData = $this->email_templates->selectTemplate($fields['templateId']);

        $data = $templateData;

        $contactData = $this->contacts->selectContact($fields['contactId']);

        foreach ($contactData as $key => $value) 
        {
            $newContactData['__'.$key.'__'] = $value; 
        }   

        $data['template_subject'] = load_substitutions($newContactData, $templateData['template_subject']);
        $data['template_content'] = load_substitutions($newContactData, $templateData['template_content']);

        return $this->response->setJSON($data);
    }

    public function sendContactEmail()
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

        $arrData = $this->contacts->selectContact($fields['txt_contactId']);

        $data['subjectTitle'] = $fields['txt_subject'];
        $data['emailContent'] = $fields['txt_content'];
        $unsubscribeLink = "contact-unsubscribe/".$fields['txt_contactId']."/".decrypt_code($arrData['unsubscribe_auth_code'])."/".$fields['txt_to'];
        $data['unsubscribeLink'] = (isset($fields['chk_unsubscribe']))? $unsubscribeLink : "";

        $emailResult = sendSliceMail('contact_email',$emailConfig,$emailSender,$emailReceiver,$data);

        $arrData = [];
        if($emailResult > 0)
        {
            $arrData = [
                'email_subject' => $fields['txt_subject'],
                'email_content' => $fields['txt_content'],
                'email_status'  => 'Sent',
                'sent_to'       => $fields['txt_contactId'],
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
                'sent_to'       => $fields['txt_contactId'],
                'sent_by'       => $this->session->get('arkonorllc_user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->contacts->saveContactEmails($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database Error";

         // contact updates
        $actionDetails = [
            'email_subject' => $fields['txt_subject'],
            'email_content' => $fields['txt_content'],
            'email_status'  => ($emailResult > 0)? 'Sent' : 'Not sent',
            'sent_to'       => $fields['txt_contactId'],
            'sent_by'       => $this->session->get('arkonorllc_user_id'),
            'created_date'  => date('Y-m-d H:i:s')
        ];

        $arrData = [
            'contact_id'        => $fields['txt_contactId'],
            'actions'           => 'Sent Email',
            'action_details'    => json_encode($actionDetails),
            'action_author'     => 'User',
            'action_icon'       => 'fa-envelope',
            'action_background' => 'bg-success',
            'created_by'        => $this->session->get('arkonorllc_user_id'),
            'created_date'      => date('Y-m-d H:i:s')
        ];
        $this->contacts->addContactUpdates($arrData);

        return $this->response->setJSON($msgResult);
    }
}
