<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Profiles extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'profile_name',
        'description',
        'modules_and_fields',
        'created_by',
        'created_date'
    ];

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
    ///// ProfileController->loadProfiles()
    ////////////////////////////////////////////////////////////
    public function loadProfiles($arrProfileIds = [])
    {
        $columns = [
            'a.id',
            'a.profile_name',
            'a.description',
            'a.modules_and_fields',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('profiles a')->select($columns);
        if(count($arrProfileIds) > 0)
        {
            $builder->whereIn('a.id',$arrProfileIds);
        }
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
        // return count($arrProfileIds);
    }

    ////////////////////////////////////////////////////////////
    ///// ProfileController->addProfile()
    ////////////////////////////////////////////////////////////
    public function addProfile($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('profiles');
                $builder->insert($arrData);
                $insertId = $this->db->insertID();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $insertId : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// ProfileController->selectProfile()
    ////////////////////////////////////////////////////////////
    public function selectProfile($profileId)
    {
        $columns = [
            'a.id',
            'a.profile_name',
            'a.description',
            'a.modules_and_fields',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('profiles a')->select($columns);
        $builder->where('a.id',$profileId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ProfileController->editProfile()
    ////////////////////////////////////////////////////////////
    public function editProfile($arrData, $profileId)
    {
        try {
            $this->db->transStart();
                $this->db->table('profiles')
                        ->where(['id'=>$profileId])
                        ->update($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }


    ////////////////////////////////////////////////////////////
    ///// ProfileController->removeProfile()
    ////////////////////////////////////////////////////////////
    public function removeProfile($profileId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('profiles');
                $builder->where(['id'=>$profileId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
