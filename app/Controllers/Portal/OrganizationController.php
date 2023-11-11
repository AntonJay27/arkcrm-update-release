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



	// function checkOnDb($forUpload = [])
	// {
	//     $primaryEmails = [];
	//     foreach($forUpload as $key => $value)
	//     {
	//         $primaryEmails[] = $value['primary_email'];
	//     }

	//     $resultForUpdate = $this->organizations->checkOnDb($primaryEmails);

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

	// }

	// public function checkOrganizationFile()
	// {
	//   $file = $this->request->getFile('organizationList');

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
	//       if(count($validColumns) == 29 && count($arrData) > 0)
	//       {
	//           $newArrData = [];
	//           foreach ($arrData as $key => $value) 
	//           {
	//               $newArrData[] = [
	//                  'organization_name'     => checkData($value[0]),
	//                  'primary_email'         => checkData($value[1]),
	//                  'secondary_email'       => checkData($value[2]),
	//                  'main_website'          => checkData($value[3]),
	//                  'other_website'         => checkData($value[4]),
	//                  'phone_number'          => checkData($value[5]),
	//                  'fax'                   => checkData($value[6]),
	//                  'linkedin_url'          => checkData($value[7]),
	//                  'facebook_url'          => checkData($value[8]),
	//                  'twitter_url'           => checkData($value[9]),
	//                  'instagram_url'         => checkData($value[10]),
	//                  'industry'              => checkData($value[11]),
	//                  'naics_code'            => checkData($value[12]),
	//                  'employee_count'        => checkData($value[13]),
	//                  'annual_revenue'        => checkData($value[14]),
	//                  'type'                  => checkData($value[15]),
	//                  'email_opt_out'         => checkData($value[16]),
	//                  'billing_street'        => checkData($value[17]),
	//                  'billing_city'          => checkData($value[18]),
	//                  'billing_state'         => checkData($value[19]),
	//                  'billing_zip'           => checkData($value[20]),
	//                  'billing_country'       => checkData($value[21]),
	//                  'shipping_street'       => checkData($value[22]),
	//                  'shipping_city'         => checkData($value[23]),
	//                  'shipping_state'        => checkData($value[24]),
	//                  'shipping_zip'          => checkData($value[25]),
	//                  'shipping_country'      => checkData($value[26]),
	//                  'description'           => checkData($value[27]),
	//                  'unsubscribe_auth_code' => encrypt_code(generate_code()),
	//                  'assigned_to'           => $this->session->get('arkonorllc_user_id'),
	//                  'created_by'            => $this->session->get('arkonorllc_user_id'),
	//                  'created_date'          => (checkData($value[28]) == "")? date('Y-m-d H:i:s') : date_format(date_create(checkData($value[28])),"Y-m-d H:i:s")
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

	public function uploadFileOrganization()
	{
		$fields = $this->request->getPost();
	
		$file = $this->request->getFile('organizationList');

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
						$arrResult['arrHeaders'] = $arrData[0];
						array_shift($arrData);
					}
					else
					{
						$arrResult['arrHeaders'] = $arrHeader;
					}
					$arrResult['arrOrganizationList'] = $arrData;
			}
			else
			{
					$arrResult[] = "Your file is empty!";
			}
		}
		else
		{
			$arrResult[] = "Invalid File";
		}

		return $this->response->setJSON($arrResult);
	}

	public function duplicateHandlingOrganization()
	{
		$fields = $this->request->getPost();

		$arrData = json_decode($fields['arrOrganizationList'],true);
		$arrData['duplicateHandlerStatus'] = 'YES';

		return $this->response->setJSON($arrData);
	}

	public function skipDuplicateHandlingOrganization()
	{
		$fields = $this->request->getPost();

		$arrData = json_decode($fields['arrOrganizationList'],true);
		$arrData['duplicateHandlerStatus'] = 'NO';

		return $this->response->setJSON($arrData);
	}

	public function loadCustomMapsOrganization()
	{
		$fields = $this->request->getGet();

		$arrData = $this->organizations->loadCustomMapsOrganization($fields['mapType']);
		return $this->response->setJSON($arrData);
	}

	public function selectCustomMapOrganization()
	{
		$fields = $this->request->getGet();

		$arrResult = $this->organizations->selectCustomMapOrganization($fields['mapId']);
		$arrData = [
			'id'            => $arrResult['id'],
			'map_name'      => $arrResult['map_name'],
			'map_fields'    => json_decode($arrResult['map_fields'],true),
			'map_values'    => json_decode($arrResult['map_values'],true),
		];
		return $this->response->setJSON($arrData);
	}

	public function reviewDataOrganization()
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
		$arrOrganizationList    	= json_decode($fields['arrOrganizationList'],true);
		$arrDefaultValues       	= json_decode($fields['arrDefaultValues'],true);
		$hasHeader 					= $fields['chk_hasHeader'];
		$arrOrganizationsDataList 	= [];
		$rowNumber 					= ($hasHeader == 'YES')? 2 : 1;
		foreach ($arrOrganizationList as $key => $value) 
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
			$arrOrganizationsDataList[] = $arrColumns;    
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
			$arrCheckDuplicateFromFileResult = checkDuplicateRowsForOrganizations($arrOrganizationsDataList, $arrDuplicateHandlerFields, $hasHeader);
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
			$arrCheckDuplicateFromDatabaseResult = $this->organizations->checkDuplicateRowsForOrganizations($arrWhereInColumns);
			
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
			$arrData['arrOrganizationsDataList'] = $arrOrganizationsDataList;
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
			$arrData['arrOrganizationsDataList'] = $arrOrganizationsDataList;
		}

		$arrOrganizationImportData = [
			'arkonorllc_organization_import_columns' => json_encode($arrData['arrHeaders']),
			'arkonorllc_organization_import_conflicts' => json_encode($arrData['arrDuplicateRowsFromFile'])
		];
		$this->session->set($arrOrganizationImportData);

		if($fields['chk_saveCustomMapping'] == 'YES')
		{
			$arrFieldMapping = [
				'map_type'      => 'organization',
				'map_name'      => $fields['txt_customMapName'],
				'map_fields'    => $fields['arrMapFields'],
				'map_values'    => $fields['arrDefaultValues'],
				'created_by'    => $this->session->get('arkonorllc_user_id'),
				'created_date'  => date('Y-m-d H:i:s')
			];
			$this->organizations->addCustomMapping($arrFieldMapping);
		}

		return $this->response->setJSON($arrData);
	}

	public function downloadDuplicateRowsFromCSVOrganization()
	{
		$arrColumns = json_decode($this->session->get('arkonorllc_organization_import_columns'),true);
		$arrData = json_decode($this->session->get('arkonorllc_organization_import_conflicts'),true);
		downloadOrganizationConflicts('conflict-rows-from-file.xlsx',$arrData,$arrColumns);
	}

	// public function downloadDuplicateRowsFromDBOrganization()
	// {
	// 	$fields = $this->request->getPost();
	// 	$arrColumns = json_decode(urldecode($fields['columns2']),true);
	// 	$arrData = json_decode(urldecode($fields['strParams2']),true);
	// 	return $this->response->setJSON($arrData);
	// }

	public function importOrganizations()
	{
		$fields = $this->request->getPost();

		$arrOrganizationImport 	= json_decode($fields['arrOrganizationImport'],true);
		$duplicateHandlerStatus = $arrOrganizationImport['duplicateHandlerStatus'];
		$arrDuplicateHandler 	= $arrOrganizationImport['arrDuplicateHandler'];

		$arrDataForInsert = [];
		$arrDataForUpdate = [];
		if($duplicateHandlerStatus == "YES")
		{
			if($arrDuplicateHandler[0] == 'Skip')
			{
				//lipasan
				foreach ($arrOrganizationImport['arrDataForImport'] as $key => $value) 
				{
					unset($value['id']);
					unset($value['row_number']);
					$arrDataForInsert[] = $value;
				}
			}
			else if($arrDuplicateHandler[0] == 'Override' || $arrDuplicateHandler[0] == 'Merge')
			{
				//palitan
				foreach ($arrOrganizationImport['arrDataForImport'] as $key => $value) 
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
			foreach ($arrOrganizationImport['arrDataForImport'] as $key => $value) 
			{
				unset($value['id']);
				unset($value['row_number']);
				$arrDataForInsert[] = $value;
			}
		}

		$result = $this->organizations->importOrganizations($arrDataForInsert,$arrDataForUpdate);
		$msgResult[] = ($result > 0)? "Success" : "Database error";

		return $this->response->setJSON($msgResult);
	}

	// public function uploadOrganizations()
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
	//               'organization_name'     => $value['organization_name'],
	//               'primary_email'         => $value['primary_email'],
	//               'secondary_email'       => $value['secondary_email'],
	//               'main_website'          => $value['main_website'],
	//               'other_website'         => $value['other_website'],
	//               'phone_number'          => $value['phone_number'],
	//               'fax'                   => $value['fax'],
	//               'linkedin_url'          => $value['linkedin_url'],
	//               'facebook_url'          => $value['facebook_url'],
	//               'twitter_url'           => $value['twitter_url'],
	//               'instagram_url'         => $value['instagram_url'],
	//               'industry'              => $value['industry'],
	//               'naics_code'            => $value['naics_code'],
	//               'employee_count'        => $value['employee_count'],
	//               'annual_revenue'        => $value['annual_revenue'],
	//               'type'                  => $value['type'],
	//               'email_opt_out'         => $value['email_opt_out'],
	//               'billing_street'        => $value['billing_street'],
	//               'billing_city'          => $value['billing_city'],
	//               'billing_state'         => $value['billing_state'],
	//               'billing_zip'           => $value['billing_zip'],
	//               'billing_country'       => $value['billing_country'],
	//               'shipping_street'       => $value['shipping_street'],
	//               'shipping_city'         => $value['shipping_city'],
	//               'shipping_state'        => $value['shipping_state'],
	//               'shipping_zip'          => $value['shipping_zip'],
	//               'shipping_country'      => $value['shipping_country'],
	//               'description'           => $value['description'],
	//               'unsubscribe_auth_code' => encrypt_code(generate_code()),
	//               'assigned_to'           => $this->session->get('arkonorllc_user_id'),
	//               'created_by'            => $this->session->get('arkonorllc_user_id'),
	//               'created_date'          => ($value['created_date'] == "")? date('Y-m-d H:i:s') : $value['created_date']
	//           ];
	//       }
	//   }
	//   //insert
	//   $uploadResult['inserted_rows'] = (count($forInsert) > 0)?$this->organizations->uploadOrganizations($arrForInsert) : 0;

	//   return $this->response->setJSON($uploadResult);
	// }

	// public function organizationConflicts($rawData)
	// {
	//   $Text = json_decode($rawData,true);

	//   // return $this->response->setJSON($Text);

	//   $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
	//   $date = str_replace(".", "", $date);
	//   $filename = "export_".$date.".xlsx";

	//   downloadOrganizationConflicts($filename,$Text);
	// }




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

	public function addContactToOrganizationQuickForm()
	{
	$this->validation->setRules([
			'txt_lastNameQuickForm' => [
				'label'  => 'Last Name',
				'rules'  => 'required',
				'errors' => [
					'required'    => 'Last Name is required',
				],
			],
			'slc_assignedToContactQuickForm' => [
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

			$assignedTo = ($fields['slc_assignedToContactQuickForm'] == "")? NULL : $fields['slc_assignedToContactQuickForm'];

			$arrData = [
				'salutation'            => $fields['slc_salutationQuickForm'],
				'first_name'            => $fields['txt_firstNameQuickForm'],
				'last_name'             => $fields['txt_lastNameQuickForm'],
				'organization_id'       => ($fields['slc_companyNameQuickForm'] == "")? NULL : $fields['slc_companyNameQuickForm'],
				'primary_email'         => $fields['txt_primaryEmailQuickForm'],
				'office_phone'          => $fields['txt_officePhoneQuickForm'],
				'assigned_to'           => $assignedTo,
				'unsubscribe_auth_code' => encrypt_code(generate_code()),
				'created_by'            => $this->session->get('arkonorllc_user_id'),
				'created_date'          => date('Y-m-d H:i:s')
			];

			$insertId = $this->contacts->addContact($arrData);
			$msgResult[] = ($insertId > 0)? "Success" : "Database error"; 
			
			// contact updates
			$actionDetails = [
			'salutation'          => $fields['slc_salutationQuickForm'],
			'first_name'          => $fields['txt_firstNameQuickForm'],
			'last_name'           => $fields['txt_lastNameQuickForm'],
			'organization_id'     => ($fields['slc_companyNameQuickForm'] == "")? NULL : $fields['slc_companyNameQuickForm'],
			'primary_email'       => $fields['txt_primaryEmailQuickForm']
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

			if($fields['slc_companyNameQuickForm'] != "")
			{
			// organization updates
			$arrContacts[] = [
				'contact_id'  => $insertId,
				'salutation'  => $fields['slc_salutationQuickForm'],
				'first_name'  => $fields['txt_firstNameQuickForm'],
				'last_name'   => $fields['txt_lastNameQuickForm'],
			];
			$actionDetails = $arrContacts;

			$arrData = [
					'organization_id'   => $fields['slc_companyNameQuickForm'],
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
	else
	{
			$msgResult[] = $this->validation->getErrors();
	}

	return $this->response->setJSON($msgResult);
	}

	public function addContactToOrganizationFullForm()
	{
	$this->validation->setRules([
			'txt_lastNameFullForm' => [
				'label'  => 'Last Name',
				'rules'  => 'required',
				'errors' => [
					'required'    => 'Last Name is required',
				],
			],
			'slc_assignedToContactFullForm' => [
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

			$assignedTo = ($fields['slc_assignedToContactFullForm'] == "")? NULL : $fields['slc_assignedToContactFullForm'];

			$arrData = [
				'salutation'            => $fields['slc_salutationFullForm'],
				'first_name'            => $fields['txt_firstNameFullForm'],
				'last_name'             => $fields['txt_lastNameFullForm'],
				'position'              => $fields['txt_positionFullForm'],
				'organization_id'       => ($fields['slc_companyNameFullForm'] == "")? NULL : $fields['slc_companyNameFullForm'],
				'primary_email'         => $fields['txt_primaryEmailFullForm'],
				'secondary_email'       => $fields['txt_secondaryEmailFullForm'],
				'date_of_birth'         => $fields['txt_birthDateFullForm'],
				'intro_letter'          => $fields['slc_introLetterFullForm'],
				'office_phone'          => $fields['txt_officePhoneFullForm'],
				'mobile_phone'          => $fields['txt_mobilePhoneFullForm'],
				'home_phone'            => $fields['txt_homePhoneFullForm'],
				'secondary_phone'       => $fields['txt_secondaryPhoneFullForm'],
				'fax'                   => $fields['txt_faxFullForm'],
				'do_not_call'           => $fields['chk_doNotCall'],
				'linkedin_url'          => $fields['txt_linkedinUrlFullForm'],
				'twitter_url'           => $fields['txt_twitterUrlFullForm'],
				'facebook_url'          => $fields['txt_facebookUrlFullForm'],
				'instagram_url'         => $fields['txt_instagramUrlFullForm'],
				'lead_source'           => $fields['slc_leadSourceFullForm'],
				'department'            => $fields['txt_departmentFullForm'],
				'reports_to'            => ($fields['slc_reportsToFullForm'] == "")? NULL : $fields['slc_reportsToFullForm'],
				'assigned_to'           => $assignedTo,
				'email_opt_out'         => $fields['slc_emailOptOutFullForm'],
				'unsubscribe_auth_code' => encrypt_code(generate_code()),
				'mailing_street'        => $fields['txt_mailingStreetFullForm'],
				'mailing_po_box'        => $fields['txt_mailingPOBoxFullForm'],
				'mailing_city'          => $fields['txt_mailingCityFullForm'],
				'mailing_state'         => $fields['txt_mailingStateFullForm'],
				'mailing_zip'           => $fields['txt_mailingZipFullForm'],
				'mailing_country'       => $fields['txt_mailingCountryFullForm'],
				'other_street'          => $fields['txt_otherStreetFullForm'],
				'other_po_box'          => $fields['txt_otherPOBoxFullForm'],
				'other_city'            => $fields['txt_otherCityFullForm'],
				'other_state'           => $fields['txt_otherStateFullForm'],
				'other_zip'             => $fields['txt_otherZipFullForm'],
				'other_country'         => $fields['txt_otherCountryFullForm'],
				'description'           => $fields['txt_descriptionFullForm'],
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
			$actionDetails = [
			'salutation'          => $fields['slc_salutationFullForm'],
			'first_name'          => $fields['txt_firstNameFullForm'],
			'last_name'           => $fields['txt_lastNameFullForm'],
			'organization_id'     => ($fields['slc_companyNameFullForm'] == "")? NULL : $fields['slc_companyNameFullForm'],
			'primary_email'       => $fields['txt_primaryEmailFullForm']
			];

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

			if($fields['slc_companyNameFullForm'] != "")
			{
			// organization updates
			$arrContacts[] = [
				'contact_id'  => $insertId,
				'salutation'  => $fields['slc_salutationFullForm'],
				'first_name'  => $fields['txt_firstNameFullForm'],
				'last_name'   => $fields['txt_lastNameFullForm'],
			];
			$actionDetails = $arrContacts;

			$arrData = [
					'organization_id'   => $fields['slc_companyNameFullForm'],
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
