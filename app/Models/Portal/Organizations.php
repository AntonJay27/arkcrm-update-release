<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Organizations extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'organizations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadUsers();
    ////////////////////////////////////////////////////////////
    public function loadUsers()
    {
        $columns = [
            'a.id as user_id',
            'a.role_id',
            'a.salutation',
            'a.first_name',
            'a.last_name',
            'a.user_email',
            'a.user_name',
            'a.user_status',
            '(SELECT role_name FROM roles WHERE id=a.role_id) as role_name',
            'a.user_password',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('users a');
        $builder->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// DashboardController->loadOrganizationReports()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationReports($monthYear)
    {
      $columns = [
          'a.id',
          'a.created_by',
          'DATE_FORMAT(a.created_date, "%Y-%m-%d") as created_date'
      ];

      $builder = $this->db->table('organizations a');
      $builder->select($columns);
      $builder->like('a.created_date',$monthYear,'left');
      $builder->orderBy('a.id','DESC');
      $query = $builder->get();
      return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizations()
    ////////////////////////////////////////////////////////////
    public function loadOrganizations()
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.main_website',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to',
            'a.billing_state',
            'a.billing_city',
            'a.billing_country',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganization()
    ////////////////////////////////////////////////////////////
    public function addOrganization($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organizations');
                $builder->insert($arrData);
                $insertId = $this->db->insertID();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $insertId : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganization()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationPicture($organizationId)
    {
        $columns = [
            'a.id',
            'a.picture'
        ];

        $builder = $this->db->table('organizations a');
        $builder->select($columns);
        $builder->where('a.id',$organizationId);
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganization()
    ////////////////////////////////////////////////////////////
    // public function addOrganizationDetails($arrAddressData, $arrDescriptionData, $arrPictureData)
    // {
    //     try {
    //         $this->db->transStart();
    //             $builder = $this->db->table('organization_address_details');
    //             $builder->insert($arrAddressData);
    //             $builder = $this->db->table('organization_description_details');
    //             $builder->insert($arrDescriptionData);
    //             $builder = $this->db->table('organization_profile_pictures');
    //             $builder->insert($arrPictureData);
    //         $this->db->transComplete();
    //         return ($this->db->transStatus() === TRUE)? 1 : 0;
    //     } catch (PDOException $e) {
    //         throw $e;
    //     }
    // }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->selectOrganization()
    ///// OrganizationController->selectEmailTemplate()
    ///// NavigationController->organizationPreview($organizationId)
    ///// OrganizationController->unlinkOrganizationContact($organizationId)
    ///// OrganizationController->addSelectedOrganizationContacts()
    ////////////////////////////////////////////////////////////
    public function selectOrganization($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.secondary_email',
            'a.main_website',
            'a.other_website',
            'a.phone_number',
            'a.fax',
            'a.linkedin_url',
            'a.facebook_url',
            'a.twitter_url',
            'a.instagram_url',
            'a.industry',
            'a.naics_code',
            'a.employee_count',
            'a.annual_revenue',
            'a.type',
            'a.ticket_symbol',
            'a.member_of',
            'a.email_opt_out',
            'a.unsubscribe_auth_code',
            'a.assigned_to',
            '(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
            'a.created_by',
            'a.created_date',
            'a.billing_street',
            'a.billing_city',
            'a.billing_state',
            'a.billing_zip',
            'a.billing_country',
            'a.shipping_street',
            'a.shipping_city',
            'a.shipping_state',
            'a.shipping_zip',
            'a.shipping_country',
            'a.description',
            'a.picture'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $builder->where('a.id',$organizationId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->editOrganization()
    ////////////////////////////////////////////////////////////
    public function editOrganization($arrData, $organizationId)
    {
        try {
            $this->db->transStart();
                $this->db->table('organizations')
                        ->where(['id'=>$organizationId])
                        ->update($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->removeOrganization()
    ////////////////////////////////////////////////////////////
    public function removeOrganization($organizationId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organizations');
                $builder->where(['id'=>$organizationId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }



    ////////////////////////////////////////////////////////////
    ///// OrganizationController->checkOnDb()
    ////////////////////////////////////////////////////////////
    // public function checkOnDb($primaryEmail)
    // {
    //   $columns = [
    //      'a.id',
    //      'a.organization_name',
    //      'a.primary_email',
    //      'a.secondary_email',
    //      'a.main_website',
    //      'a.other_website',
    //      'a.phone_number',
    //      'a.fax',
    //      'a.linkedin_url',
    //      'a.facebook_url',
    //      'a.twitter_url',
    //      'a.instagram_url',
    //      'a.industry',
    //      'a.naics_code',
    //      'a.employee_count',
    //      'a.annual_revenue',
    //      'a.type',
    //      'a.ticket_symbol',
    //      'a.member_of',
    //      'a.email_opt_out',
    //      'a.unsubscribe_auth_code',
    //      'a.assigned_to',
    //      '(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
    //      'a.created_by',
    //      'a.created_date',
    //   ];

    //   $builder = $this->db->table('organizations a')->select($columns);
    //   $builder->whereIn('a.primary_email',$primaryEmail);
    //   $query = $builder->get();
    //   return  $query->getResultArray();
    // }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->uploadOrganizations()
    ////////////////////////////////////////////////////////////
    // public function uploadOrganizations($arrData)
    // {
    //   try {
    //       $this->db->transStart();
    //           $builder = $this->db->table('organizations');
    //           $builder->insertBatch($arrData);
    //       $this->db->transComplete();
    //       return ($this->db->transStatus() === TRUE)? 1 : 0;
    //   } catch (PDOException $e) {
    //       throw $e;
    //   }
    // }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->importOrganizations()
    ////////////////////////////////////////////////////////////
    public function addCustomMapping($arrData)
    {
      try {
          $this->db->transStart();
              $builder = $this->db->table('custom_maps');
              $builder->insert($arrData);
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? 1 : 0;
      } catch (PDOException $e) {
          throw $e;
      }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadCustomMapsOrganization()
    ////////////////////////////////////////////////////////////
    public function loadCustomMapsOrganization($mapType)
    {
        $columns = [
            'a.id',
            'a.map_type',
            'a.map_name',
            'a.map_fields',
            'a.map_values',
            'a.created_by',
            'a.created_date',
        ];

        $builder = $this->db->table('custom_maps a')->select($columns);
        $builder->where('a.map_type',$mapType);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->selectCustomMapOrganization()
    ////////////////////////////////////////////////////////////
    public function selectCustomMapOrganization($mapId)
    {
        $columns = [
            'a.id',
            'a.map_type',
            'a.map_name',
            'a.map_fields',
            'a.map_values',
            'a.created_by',
            'a.created_date',
        ];

        $builder = $this->db->table('custom_maps a')->select($columns);
        $builder->where('a.id',$mapId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->reviewData()
    ////////////////////////////////////////////////////////////
    public function checkDuplicateRowsForOrganizations($arrWhereInColumns)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.secondary_email',
            'a.main_website',
            'a.other_website',
            'a.phone_number',
            'a.fax',
            'a.linkedin_url',
            'a.facebook_url',
            'a.twitter_url',
            'a.instagram_url',
            'a.industry',
            'a.naics_code',
            'a.employee_count',
            'a.annual_revenue',
            'a.type',
            'a.ticket_symbol',
            'a.member_of',
            'a.email_opt_out',
            'a.assigned_to',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.billing_street',
            'a.billing_city',
            'a.billing_state',
            'a.billing_zip',
            'a.billing_country',
            'a.shipping_street',
            'a.shipping_city',
            'a.shipping_state',
            'a.shipping_zip',
            'a.shipping_country',
            'a.description'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $builder->groupStart();
        foreach ($arrWhereInColumns as $key => $value) 
        {
            $builder->orGroupStart();
                $builder->whereIn('a.'.$key,$value);
            $builder->groupEnd();
        }
        $builder->groupEnd();
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->importOrganizations()
    ////////////////////////////////////////////////////////////
    public function importOrganizations($arrDataForInsert,$arrDataForUpdate)
    {
        try {
            $this->db->transStart();
                if(count($arrDataForInsert) > 0)
                {
                    $this->db->table('organizations')->insertBatch($arrDataForInsert);
                }
                if(count($arrDataForUpdate) > 0)
                {
                    $this->db->table('organizations')->updateBatch($arrDataForUpdate,'id');
                }
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }





    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationSummary()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationSummary($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.billing_city',
            'a.billing_country'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $builder->where('a.id',$organizationId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationDetails()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationDetails($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.secondary_email',
            'a.main_website',
            'a.other_website',
            'a.phone_number',
            'a.fax',
            'a.linkedin_url',
            'a.facebook_url',
            'a.twitter_url',
            'a.instagram_url',
            'a.industry',
            'a.naics_code',
            'a.employee_count',
            'a.annual_revenue',
            'a.type',
            'a.ticket_symbol',
            'a.member_of',
            'a.email_opt_out',
            'a.assigned_to',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.billing_street',
            'a.billing_city',
            'a.billing_state',
            'a.billing_zip',
            'a.billing_country',
            'a.shipping_street',
            'a.shipping_city',
            'a.shipping_state',
            'a.shipping_zip',
            'a.shipping_country',
            'a.description'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $builder->where('a.id',$organizationId);
        $query = $builder->get();
        return  $query->getRowArray();
    }


    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganization()
    ////////////////////////////////////////////////////////////
    public function addOrganizationUpdates($arrData)
    {
        try {
            $this->db->transStart();
                $this->db->table('organization_updates')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationUpdates()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationUpdates($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_id',
            'a.actions',
            'a.action_details',
            'a.action_author',
            'a.action_icon',
            'a.action_background',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.created_by) as created_by_name',
            'a.created_by',
            'a.created_date',
            'DATE_FORMAT(a.created_date, "%Y-%m-%d") as date_created',
            'DATE_FORMAT(a.created_date, "%H:%i:%s") as time_created'
        ];

        $builder = $this->db->table('organization_updates a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationContacts()
    ///// OrganizationController->loadUnlinkOrganizationContacts()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationContacts($organizationId)
    {
        $columns = [
            'a.id',
            'a.salutation',
            'a.first_name',
            'a.last_name',
            'a.position',
            'a.organization_id',
            '(SELECT organization_name FROM organizations WHERE id = a.organization_id) as organization_name',
            'a.primary_email',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('contacts a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationContact()
    ////////////////////////////////////////////////////////////
    public function unlinkOrganizationContact($contactId)
    {
        try {
          $this->db->transStart();
            $this->db->table('contacts')->where('id',$contactId)->update(['organization_id'=>null]);
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
          throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addSelectedOrganizationContacts()
    ////////////////////////////////////////////////////////////
    public function addSelectedOrganizationContacts($arrData)
    {
        try {
          $this->db->transStart();
            $this->db->table('contacts')->updateBatch($arrData,'id');
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
          throw $e;
        }
    }






    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationActivities()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationEvents($organizationId)
    {
        $columns = [
            'a.id',
            'a.subject',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.start_date',
            'a.start_time',
            'a.end_date',
            'a.end_time',
            'a.status',
            'a.type',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('events a')->select($columns);
        $builder->where('a.id',$organizationId);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationActivities()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationTasks($organizationId)
    {
        $columns = [
            'a.id',
            'a.subject',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.start_date',
            'a.start_time',
            'a.end_date',
            'a.end_time',
            'a.status',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('tasks a')->select($columns);
        $builder->where('a.id',$organizationId);
        $query = $builder->get();
        return  $query->getResultArray();
    }






    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationEmails()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationEmails($organizationId)
    {
        $columns = [
            'a.id',
            'a.email_subject',
            'a.email_content',
            'a.email_status',
            '(SELECT organization_name FROM organizations WHERE id = a.sent_to) as sent_to_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.sent_by) as sent_by_name',
            'DATE_FORMAT(A.created_date, "%Y-%m-%d") as date_sent',
            'DATE_FORMAT(A.created_date, "%H:%i:%s") as time_sent'
        ];

        $builder = $this->db->table('organization_email_histories a')->select($columns);
        $builder->where('a.sent_to',$organizationId);
        $query = $builder->get();
        return  $query->getResultArray();
    }










    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationDocuments()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationDocuments($organizationId)
    {
        $columns = [
            'a.id',
            'a.document_id',
            'b.title',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
            'b.document_number',
            'b.type',
            'b.file_name',
            'b.file_url',
            'b.file_type',
            'b.file_size',
            'b.download_count',
            'b.created_date',
            'b.updated_date'
        ];

        $builder = $this->db->table('organization_documents a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->join('documents b','a.document_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationDocument()
    ////////////////////////////////////////////////////////////
    public function selectOrganizationDocument($organizationDocumentId)
    {
      $columns = [
          'a.id',
          'a.organization_id',
          'a.document_id',
          'b.title',
          '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
          'b.document_number',
          'b.type',
          'b.file_name',
          'b.file_url',
          'b.file_type',
          'b.file_size',
          'b.download_count',
          'b.notes',
          'b.created_date',
          'b.updated_date'
      ];

      $builder = $this->db->table('organization_documents a')->select($columns);
      $builder->where('a.id',$organizationDocumentId);
      $builder->join('documents b','a.document_id = b.id','left');
      $query = $builder->get();
      return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationDocument()
    ////////////////////////////////////////////////////////////
    public function unlinkOrganizationDocument($organizationDocumentId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_documents');
                $builder->where(['id'=>$organizationDocumentId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addSelectedOrganizationDocuments()
    ////////////////////////////////////////////////////////////
    public function addSelectedOrganizationDocuments($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_documents')->insertBatch($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganizationDocument()
    ////////////////////////////////////////////////////////////
    public function addOrganizationDocument($arrData)
    {
        try {
            $this->db->transStart();
                $this->db->table('organization_documents')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }









    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationCampaigns($organizationId)
    {
        $columns = [
            'a.id',
            'a.campaign_id',
            'b.campaign_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
            'b.campaign_status',
            'b.campaign_type',
            'b.expected_close_date',
            'b.expected_revenue'
        ];

        $builder = $this->db->table('organization_campaigns a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->join('campaigns b','a.campaign_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationCampaign()
    ////////////////////////////////////////////////////////////
    public function selectOrganizationCampaign($organizationCampaignId)
    {
      $columns = [
          'a.id',
          'a.organization_id',
          'a.campaign_id',
          'b.campaign_name',
          '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
          'b.campaign_status',
          'b.campaign_type',
          'b.expected_close_date',
          'b.expected_revenue'
      ];

      $builder = $this->db->table('organization_campaigns a')->select($columns);
      $builder->where('a.id',$organizationCampaignId);
      $builder->join('campaigns b','a.campaign_id = b.id','left');
      $query = $builder->get();
      return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationCampaign()
    ////////////////////////////////////////////////////////////
    public function unlinkOrganizationCampaign($organizationCampaignId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_campaigns');
                $builder->where(['id'=>$organizationCampaignId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addSelectedOrganizationCampaigns()
    ////////////////////////////////////////////////////////////
    public function addSelectedOrganizationCampaigns($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_campaigns');
                $builder->insertBatch($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    








    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadUnlinkOrganizations()
    ///// DocumentController->loadUnlinkOrganizations()
    ////////////////////////////////////////////////////////////
    public function loadUnlinkOrganizations($arrOrganizationIds)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.main_website',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        if(count($arrOrganizationIds) > 0)
        {
            $builder->whereNotIn('a.id',$arrOrganizationIds);
        }
        $query = $builder->get();
        return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationComments()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationComments($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_id',
            'a.comment_id',
            'a.comment',
            'a.created_by',
            '(SELECT picture FROM users WHERE id = a.created_by) as user_picture',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.created_by) as created_by_name',
            'a.created_date'
        ];

        $builder = $this->db->table('organization_comments a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->orderBy('a.comment_id','DESC');
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganizationComment()
    ///// OrganizationController->replyOrganizationComment()
    ////////////////////////////////////////////////////////////
    public function addOrganizationComment($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_comments')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->sendOrganizationEmails()
    ////////////////////////////////////////////////////////////
    public function saveOrganizationEmails($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_email_histories')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }


    ////////////////////////////////////////////////////////////
    ///// OrganizationController->sendOrganizationEmails()
    ////////////////////////////////////////////////////////////
    public function sendOrganizationEmails($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_email_histories')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
