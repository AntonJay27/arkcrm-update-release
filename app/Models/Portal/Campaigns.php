<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Campaigns extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'campaigns';
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
    ///// CampaignController->loadUsers();
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
    ///// CampaignController->loadCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadCampaigns()
    {
        $columns = [
            'a.id',
            'a.campaign_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.campaign_status',
            'a.campaign_type',
            'a.expected_close_date',
            'a.expected_revenue',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('campaigns a')->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->addCampaign()
    ////////////////////////////////////////////////////////////
    public function addCampaign($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('campaigns');
                $builder->insert($arrData);
                $insertId = $this->db->insertID();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $insertId : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->selectCampaign()
    ///// NavigationController->campaignPreview()
    ///// ContactController->addSelectedContactCampaigns()
    ///// OrganizationController->addSelectedOrganizationCampaigns()
    ////////////////////////////////////////////////////////////
    public function selectCampaign($campaignId)
    {
        $columns = [
            'a.id',
            'a.campaign_name',
            'a.campaign_status',
            'a.product',
            'a.expected_close_date',
            'a.target_size',
            'a.campaign_type',
            'a.target_audience',
            'a.sponsor',
            'a.num_sent',
            'a.assigned_to',
            'a.budget_cost',
            'a.expected_response',
            'a.expected_sales_count',
            'a.expected_response_count',
            'a.expected_roi',
            'a.actual_cost',
            'a.expected_revenue',
            'a.actual_sales_count',
            'a.actual_response_count',
            'a.actual_roi',
            'a.campaign_description',
            '(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('campaigns a')->select($columns);
        $builder->where('a.id',$campaignId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->editCampaign()
    ////////////////////////////////////////////////////////////
    public function editCampaign($arrData, $campaignId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('campaigns');
                $builder->where(['id'=>$campaignId]);
                $builder->update($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->removeCampaign()
    ////////////////////////////////////////////////////////////
    public function removeCampaign($campaignId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('campaigns');
                $builder->where(['id'=>$campaignId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadCampaignDetails()
    ////////////////////////////////////////////////////////////
    public function loadCampaignDetails($campaignId)
    {
        $columns = [
            'a.id',
            'a.campaign_name',
            'a.campaign_status',
            'a.product',
            'a.expected_close_date',
            'a.target_size',
            'a.campaign_type',
            'a.target_audience',
            'a.sponsor',
            'a.num_sent',
            'a.assigned_to',
            'a.budget_cost',
            'a.expected_response',
            'a.expected_sales_count',
            'a.expected_response_count',
            'a.expected_roi',
            'a.actual_cost',
            'a.expected_revenue',
            'a.actual_sales_count',
            'a.actual_response_count',
            'a.actual_roi',
            'a.campaign_description',
            '(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('campaigns a')->select($columns);
        $builder->where('a.id',$campaignId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->addCampaignUpdates()
    ////////////////////////////////////////////////////////////
    public function addCampaignUpdates($arrData)
    {
        try {
            $this->db->transStart();
                $this->db->table('campaign_updates')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadCampaignUpdates()
    ////////////////////////////////////////////////////////////
    public function loadCampaignUpdates($campaignId)
    {
        $columns = [
            'a.id',
            'a.campaign_id',
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

        $builder = $this->db->table('campaign_updates a')->select($columns);
        $builder->where('a.campaign_id',$campaignId);
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadSelectedContactCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadSelectedContactCampaigns($campaignId)
    {
        $columns = [
            'a.id',
            'a.campaign_id',
            'a.contact_id',
            'b.salutation',
            'b.first_name',
            'b.last_name',
            'b.office_phone',
            'b.primary_email',
            'b.position',
            'b.organization_id',
            '(SELECT organization_name FROM organizations WHERE id = b.organization_id) as organization_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
            'b.mailing_city',
            'b.mailing_country'
        ];

        $builder = $this->db->table('contact_campaigns a')->select($columns);
        $builder->where('a.campaign_id',$campaignId);
        $builder->join('contacts b','a.contact_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadUnlinkContactCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadUnlinkContactCampaigns($arrCampaignIds)
    {
        $columns = [
            'a.id',
            'a.campaign_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.campaign_status',
            'a.campaign_type',
            'a.expected_close_date',
            'a.expected_revenue',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('campaigns a')->select($columns);
        if(count($arrCampaignIds) > 0)
        {
            $builder->whereNotIn('a.id',$arrCampaignIds);
        }
        $query = $builder->get();
        return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadUnlinkContacts()
    ////////////////////////////////////////////////////////////
    public function loadContactCampaigns($campaignId)
    {
        $columns = [
            'a.id',
            'a.contact_id'
        ];

        $builder = $this->db->table('contact_campaigns a')->select($columns);
        $builder->where('a.campaign_id',$campaignId);
        $query = $builder->get();
        return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadCampaignActivities()
    ////////////////////////////////////////////////////////////
    public function loadCampaignEvents($campaignId)
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
        $builder->where('a.id',$campaignId);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadCampaignActivities()
    ////////////////////////////////////////////////////////////
    public function loadCampaignTasks($campaignId)
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
        $builder->where('a.id',$campaignId);
        $query = $builder->get();
        return  $query->getResultArray();
    }


    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadSelectedOrganizationCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadSelectedOrganizationCampaigns($campaignId)
    {
        $columns = [
            'a.id',
            'a.campaign_id',
            'a.organization_id',
            'b.organization_name',
            'b.primary_email',
            'b.main_website',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name'
        ];

        $builder = $this->db->table('organization_campaigns a')->select($columns);
        $builder->where('a.campaign_id',$campaignId);
        $builder->join('organizations b','a.organization_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadUnlinkOrganizationCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadUnlinkOrganizationCampaigns($arrCampaignIds)
    {
        $columns = [
            'a.id',
            'a.campaign_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.campaign_status',
            'a.campaign_type',
            'a.expected_close_date',
            'a.expected_revenue',
            'a.created_by',
            'a.created_date'
        ];
        
        $builder = $this->db->table('campaigns a')->select($columns);
        if(count($arrCampaignIds) > 0)
        {
            $builder->whereNotIn('a.id',$arrCampaignIds);
        }
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadUnlinkOrganizations()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationCampaigns($campaignId)
    {
        $columns = [
            'a.id',
            'a.organization_id'
        ];

        $builder = $this->db->table('organization_campaigns a')->select($columns);
        $builder->where('a.campaign_id',$campaignId);
        $query = $builder->get();
        return  $query->getResultArray();
    }

}
