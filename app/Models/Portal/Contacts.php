<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Contacts extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'contacts';
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
    ///// ContactController->loadUsers();
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
    ///// DashboardController->loadContactReports()
    ////////////////////////////////////////////////////////////
    public function loadContactReports($monthYear)
    {
      $columns = [
          'a.id',
          'a.created_by',
          'DATE_FORMAT(a.created_date, "%Y-%m-%d") as created_date'
      ];

      $builder = $this->db->table('contacts a');
      $builder->select($columns);
      $builder->like('a.created_date',$monthYear,'left');
      $builder->orderBy('a.id','DESC');
      $query = $builder->get();
      return  $query->getResultArray();
    }



    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContact()
    ////////////////////////////////////////////////////////////
    public function loadContacts()
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
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('contacts a')->select($columns)->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addContact()
    ////////////////////////////////////////////////////////////
    public function addContact($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contacts');
                $builder->insert($arrData);
                $insertId = $this->db->insertID();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $insertId : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addContact()
    ////////////////////////////////////////////////////////////
    public function loadContactPicture($whereParams)
    {
        $columns = [
            'a.id',
            'a.contact_id',
            'a.picture'
        ];

        $builder = $this->db->table('contact_profile_pictures a')->select($columns)->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addContact()
    ////////////////////////////////////////////////////////////
    public function addContactDetails($arrAddressData, $arrDescriptionData, $arrPictureData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_address_details');
                $builder->insert($arrAddressData);
                $builder = $this->db->table('contact_description_details');
                $builder->insert($arrDescriptionData);
                $builder = $this->db->table('contact_profile_pictures');
                $builder->insert($arrPictureData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->selectContact()
    ///// ContactController->selectEmailTemplate()
    ///// ContactController->sendContactEmail()
    ///// NavigationController->contactPreview($contactId)
    ///// OrganizationController->unlinkOrganizationContact($contactId)
    ///// OrganizationController->addSelectedOrganizationContacts($contactId)
    ////////////////////////////////////////////////////////////
    public function selectContact($contactId)
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
            'a.secondary_email',
            'a.date_of_birth',
            'a.intro_letter',
            'a.office_phone',
            'a.mobile_phone',
            'a.home_phone',
            'a.secondary_phone',
            'a.fax',
            'a.do_not_call',
            'a.linkedin_url',
            'a.twitter_url',
            'a.facebook_url',
            'a.instagram_url',
            'a.lead_source',
            'a.department',
            'a.reports_to',
            'a.assigned_to',
            'a.email_opt_out',
            'a.unsubscribe_auth_code',
            'a.created_by',
            'a.created_date',
            'b.mailing_street',
            'b.mailing_po_box',
            'b.mailing_city',
            'b.mailing_state',
            'b.mailing_zip',
            'b.mailing_country',
            'b.other_street',
            'b.other_po_box',
            'b.other_city',
            'b.other_state',
            'b.other_zip',
            'b.other_country',
            'c.description',
            'd.picture'
        ];

        $builder = $this->db->table('contacts a')->select($columns);
        $builder->where('a.id',$contactId);
        $builder->join('contact_address_details b','a.id = b.contact_id','left');
        $builder->join('contact_description_details c','a.id = c.contact_id','left');
        $builder->join('contact_profile_pictures d','a.id = d.contact_id','left');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->editContact()
    ////////////////////////////////////////////////////////////
    public function editContact($arrData, $contactId)
    {
        try {
            $this->db->transStart();
                $this->db->table('contacts')
                        ->where(['id'=>$contactId])
                        ->update($arrData['contact_details']);
                $this->db->table('contact_address_details')
                        ->where(['contact_id'=>$contactId])
                        ->update($arrData['contact_address']);
                $this->db->table('contact_description_details')
                        ->where(['contact_id'=>$contactId])
                        ->update($arrData['contact_description']);
                $this->db->table('contact_profile_pictures')
                        ->where(['contact_id'=>$contactId])
                        ->update($arrData['contact_picture']);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->removeContact()
    ////////////////////////////////////////////////////////////
    public function removeContact($contactId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contacts');
                $builder->where(['id'=>$contactId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->checkOnDb()
    ////////////////////////////////////////////////////////////
    public function checkOnDb($primaryEmail)
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
         'a.secondary_email',
         'a.date_of_birth',
         'a.intro_letter',
         'a.office_phone',
         'a.mobile_phone',
         'a.home_phone',
         'a.secondary_phone',
         'a.fax',
         'a.do_not_call',
         'a.linkedin_url',
         'a.twitter_url',
         'a.facebook_url',
         'a.instagram_url',
         'a.lead_source',
         'a.department',
         'a.reports_to',
         'a.assigned_to',
         'a.email_opt_out',
         'a.unsubscribe_auth_code',
         'a.created_by',
         'a.created_date',
      ];

      $builder = $this->db->table('contacts a')->select($columns);
      $builder->whereIn('a.primary_email',$primaryEmail);
      $query = $builder->get();
      return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->uploadContacts()
    ////////////////////////////////////////////////////////////
    public function uploadContacts($arrData)
    {
      try {
          $this->db->transStart();
              $builder = $this->db->table('contacts');
              $builder->insertBatch($arrData);
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? 1 : 0;
      } catch (PDOException $e) {
          throw $e;
      }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactSummary()
    ////////////////////////////////////////////////////////////
    public function loadContactSummary($contactId)
    {
        $columns = [
            'a.id',
            'a.first_name',
            'a.last_name',
            'a.position',
            'a.organization_id',
            '(SELECT organization_name FROM organizations WHERE id = a.organization_id) as organization_name',
            'a.assigned_to',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to',
            'b.mailing_city',
            'b.mailing_country'
        ];

        $builder = $this->db->table('contacts a')->select($columns);
        $builder->where('a.id',$contactId);
        $builder->join('contact_address_details b','a.id = b.contact_id','left');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactDetails()
    ////////////////////////////////////////////////////////////
    public function loadContactDetails($contactId)
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
            'a.secondary_email',
            'a.date_of_birth',
            'a.intro_letter',
            'a.office_phone',
            'a.mobile_phone',
            'a.home_phone',
            'a.secondary_phone',
            'a.fax',
            'a.do_not_call',
            'a.linkedin_url',
            'a.twitter_url',
            'a.facebook_url',
            'a.instagram_url',
            'a.lead_source',
            'a.department',
            'a.reports_to',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.reports_to) as reports_to_name',
            'a.assigned_to',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.email_opt_out',
            'b.mailing_street',
            'b.mailing_po_box',
            'b.mailing_city',
            'b.mailing_state',
            'b.mailing_zip',
            'b.mailing_country',
            'b.other_street',
            'b.other_po_box',
            'b.other_city',
            'b.other_state',
            'b.other_zip',
            'b.other_country',
            'c.description'
        ];

        $builder = $this->db->table('contacts a')->select($columns);
        $builder->where('a.id',$contactId);
        $builder->join('contact_address_details b','a.id = b.contact_id','left');
        $builder->join('contact_description_details c','a.id = c.contact_id','left');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addContact()
    ////////////////////////////////////////////////////////////
    public function addContactUpdates($arrData)
    {
        try {
            $this->db->transStart();
                $this->db->table('contact_updates')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactUpdates()
    ////////////////////////////////////////////////////////////
    public function loadContactUpdates($contactId)
    {
        $columns = [
            'a.id',
            'a.contact_id',
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

        $builder = $this->db->table('contact_updates a')->select($columns);
        $builder->where('a.contact_id',$contactId);
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactActivities()
    ////////////////////////////////////////////////////////////
    public function loadContactEvents($contactId)
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
        $builder->where('a.id',$contactId);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactActivities()
    ////////////////////////////////////////////////////////////
    public function loadContactTasks($contactId)
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
        $builder->where('a.id',$contactId);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactEmails()
    ////////////////////////////////////////////////////////////
    public function loadContactEmails($contactId)
    {
        $columns = [
            'a.id',
            'a.email_subject',
            'a.email_content',
            'a.email_status',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM contacts WHERE id = a.sent_to) as sent_to_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.sent_by) as sent_by_name',
            'DATE_FORMAT(A.created_date, "%Y-%m-%d") as date_sent',
            'DATE_FORMAT(A.created_date, "%H:%i:%s") as time_sent'
        ];

        $builder = $this->db->table('contact_email_histories a')->select($columns);
        $builder->where('a.sent_to',$contactId);
        $query = $builder->get();
        return  $query->getResultArray();
    }












    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactDocuments()
    ////////////////////////////////////////////////////////////
    public function loadContactDocuments($contactId)
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

        $builder = $this->db->table('contact_documents a')->select($columns);
        $builder->where('a.contact_id',$contactId);
        $builder->join('documents b','a.document_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->unlinkContactDocument()
    ////////////////////////////////////////////////////////////
    public function selectContactDocument($contactDocumentId)
    {
        $columns = [
            'a.id',
            'a.contact_id',
            'a.document_id',
            'b.title',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
            'b.document_number',
            'b.type',
            'b.file_name',
            'b.file_url',
            'b.file_type',
            'b.file_size',
            'b.notes',
            'b.download_count',
            'b.created_date',
            'b.updated_date'
        ];

        $builder = $this->db->table('contact_documents a')->select($columns);
        $builder->where('a.id',$contactDocumentId);
        $builder->join('documents b','a.document_id = b.id','left');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->unlinkContactDocument()
    ////////////////////////////////////////////////////////////
    public function unlinkContactDocument($contactDocumentId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_documents');
                $builder->where(['id'=>$contactDocumentId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addSelectedContactDocuments()
    ////////////////////////////////////////////////////////////
    public function addSelectedContactDocuments($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_documents');
                $builder->insertBatch($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addContactDocument()
    ////////////////////////////////////////////////////////////
    public function addContactDocument($arrData)
    {
        try {
            $this->db->transStart();
                $this->db->table('contact_documents')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }













    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadContactCampaigns($contactId)
    {
        $columns = [
            'a.id',
            'a.contact_id',
            'a.campaign_id',
            'b.campaign_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
            'b.campaign_status',
            'b.campaign_type',
            'b.expected_close_date',
            'b.expected_revenue'
        ];

        $builder = $this->db->table('contact_campaigns a')->select($columns);
        $builder->where('a.contact_id',$contactId);
        $builder->join('campaigns b','a.campaign_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->unlinkContactCampaign()
    ////////////////////////////////////////////////////////////
    public function selectContactCampaign($contactCampaignId)
    {
         $columns = [
             'a.id',
             'a.contact_id',
             'a.campaign_id',
             'b.campaign_name',
             '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
             'b.campaign_status',
             'b.campaign_type',
             'b.expected_close_date',
             'b.expected_revenue'
         ];

         $builder = $this->db->table('contact_campaigns a')->select($columns);
         $builder->where('a.id',$contactCampaignId);
         $builder->join('campaigns b','a.campaign_id = b.id','left');
         $query = $builder->get();
         return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->unlinkContactCampaign()
    ////////////////////////////////////////////////////////////
    public function unlinkContactCampaign($contactCampaignId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_campaigns');
                $builder->where(['id'=>$contactCampaignId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addSelectedContactCampaigns()
    ////////////////////////////////////////////////////////////
    public function addSelectedContactCampaigns($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_campaigns');
                $builder->insertBatch($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }







    


    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadUnlinkContacts()
    ///// DocumentController->loadUnlinkContacts()
    ////////////////////////////////////////////////////////////
    public function loadUnlinkContacts($arrContactIds)
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
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name'
        ];

        $builder = $this->db->table('contacts a')->select($columns);
        if(count($arrContactIds) > 0)
        {
            $builder->whereNotIn('a.id',$arrContactIds);
        }
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadContactComments()
    ////////////////////////////////////////////////////////////
    public function loadContactComments($contactId)
    {
        $columns = [
            'a.id',
            'a.contact_id',
            'a.comment_id',
            'a.comment',
            'a.created_by',
            '(SELECT picture FROM users WHERE id = a.created_by) as user_picture',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.created_by) as created_by_name',
            'a.created_date'
        ];

        $builder = $this->db->table('contact_comments a')->select($columns);
        $builder->where('a.contact_id',$contactId);
        $builder->orderBy('a.comment_id','DESC');
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// ContactController->addContactComment()
    ///// ContactController->replyContactComment()
    ////////////////////////////////////////////////////////////
    public function addContactComment($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_comments')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }



    ////////////////////////////////////////////////////////////
    ///// ContactController->sendContactEmails()
    ////////////////////////////////////////////////////////////
    public function saveContactEmails($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_email_histories')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /* 
    =======================================================================>
    
        UnsubscribeController->contactUnsubscribe($contactId, $authCode)
    
    =======================================================================>
    */

    ////////////////////////////////////////////////////////////
    ///// UnsubscribeController->contactConfirmation()
    ///// UnsubscribeController->contactUnsubscribe()
    ////////////////////////////////////////////////////////////
    public function verifyContact($contactId, $authCode)
    {
        $columns = [
            'a.id',
            'CONCAT(a.salutation," ",a.first_name," ",a.last_name) as full_name',
            'a.position',
            'a.organization_id',
            'a.primary_email',
            '(SELECT user_email FROM users WHERE id = a.reports_to) as reports_to',
            'a.unsubscribe_auth_code',
            '(SELECT user_email FROM users WHERE id = a.assigned_to) as assigned_to',
            'a.created_by',
            'a.created_date'
        ];

        $where = [
            'a.id' => $contactId,
            'a.unsubscribe_auth_code' => $authCode
        ];

        $builder = $this->db->table('contacts a')->select($columns);
        $builder->where($where);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// UnsubscribeController->contactConfirmation()
    ////////////////////////////////////////////////////////////
    public function emailOptOut($contactId, $arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contacts');
                $builder->where(['id'=>$contactId]);
                $builder->update($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
