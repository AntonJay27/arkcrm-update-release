<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class EmailTemplates extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'emailtemplates';
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
    ///// EmailTemplateController->loadTemplates()
    ////////////////////////////////////////////////////////////
    public function loadTemplates($categories, $arrUserData)
    {
        $columns = [
            'a.id',
            'a.template_name',
            'a.template_category',
            'a.template_description',
            'a.template_subject',
            'a.template_content',
            'a.template_visibility',
            'a.template_status',
            '(SELECT CONCAT(first_name) FROM users WHERE id = a.created_by) as created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('email_templates a')->select($columns);
        if($categories != "All")
        {
            $builder->whereIn('a.template_category',[$categories,'All']);
        }        
         $builder->where('a.created_by',$arrUserData['user_id']);
         $builder->where('a.template_visibility','Personal');
         $builder->orWhere('a.template_visibility','Corporate');
         if($arrUserData['admin'] == '1')
         {
            $builder->orWhere('a.template_visibility','System');
         }
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->addTemplate()
    ////////////////////////////////////////////////////////////
    public function addTemplate($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('email_templates')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->selectTemplate()
    ///// ContactController->selectEmailTemplate()
    ///// OrganizationController->selectEmailTemplate()
    ////////////////////////////////////////////////////////////
    public function selectTemplate($templateId)
    {
        $columns = [
            'a.id',
            'a.template_name',
            'a.template_category',
            'a.template_description',
            'a.template_subject',
            'a.template_content',
            'a.template_visibility',
            'a.template_status',
            '(SELECT CONCAT(first_name) FROM users WHERE id = a.created_by) as created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('email_templates a')->select($columns);
        $builder->where('a.id',$templateId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->editTemplate()
    ////////////////////////////////////////////////////////////
    public function editTemplate($arrData, $templateId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('email_templates')->where(['id'=>$templateId])->update($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->removeTemplate()
    ////////////////////////////////////////////////////////////
    public function removeTemplate($templateId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('email_templates')->where(['id'=>$templateId])->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
