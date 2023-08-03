<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class EmailConfigurations extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'emailconfigurations';
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
    ///// EmailConfigurationController->addEmailConfig()
    ////////////////////////////////////////////////////////////
    public function addEmailConfig($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('email_configurations');
                $builder->insert($arrData);
                $insertId = $this->db->insertID();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $insertId : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// EmailConfigurationController->selectEmailConfig()
    ////////////////////////////////////////////////////////////
    public function selectEmailConfig()
    {
        $columns = [
            'a.id',
            'a.protocol',
            'a.smtp_host',
            'a.smtp_port',
            'a.smtp_crypto',
            'a.smtp_user',
            'a.smtp_pass',
            'a.mail_type',
            'a.charset',
            'a.word_wrap',
            'a.from_email',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date',
        ];

        $builder = $this->db->table('email_configurations a')->select($columns);
        $builder->where('a.id',1);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// EmailConfigurationController->editEmailConfig()
    ////////////////////////////////////////////////////////////
    public function editEmailConfig($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('email_configurations');
                $builder->update($arrData);
                $builder->where('id',1);
                $id = $this->db->affectedRows();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $id : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

}
