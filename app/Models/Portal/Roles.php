<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Roles extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'reports_to',
        'role_name',
        'sub_role',
        'can_assign_records_to',
        'privileges',
        'profiles',
        'modules_and_fields',
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
    ///// RoleController->loadRoles()
    ////////////////////////////////////////////////////////////
    public function loadRoles()
    {
        $columns = [
            'a.id',
            'a.reports_to',
            'a.role_name',
            'a.sub_role',
            'a.can_assign_records_to',
            'a.privileges',
            'a.profiles',
            'a.modules_and_fields',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('roles a')->select($columns)->orderBy('a.id','ASC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// RoleController->addRole()
    ////////////////////////////////////////////////////////////
    public function addRole($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('roles');
                $builder->insert($arrData);
                $insertId = $this->db->insertID();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $insertId : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// RoleController->selectRole()
    ////////////////////////////////////////////////////////////
    public function selectRole($roleId)
    {
        $columns = [
            'a.id',
            'a.reports_to',
            'a.role_name',
            'a.sub_role',
            'a.can_assign_records_to',
            'a.privileges',
            'a.profiles',
            'a.modules_and_fields',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('roles a')->select($columns);
        $builder->where('a.id',$roleId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// RoleController->editRole()
    ////////////////////////////////////////////////////////////
    public function editRole($arrData, $roleId)
    {
        try {
            $this->db->transStart();
                $this->db->table('roles')
                        ->where(['id'=>$roleId])
                        ->update($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }


    ////////////////////////////////////////////////////////////
    ///// RoleController->removeRole()
    ////////////////////////////////////////////////////////////
    public function removeRole($roleId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('roles');
                $builder->where(['id'=>$roleId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// RoleController->removeRole()
    ////////////////////////////////////////////////////////////
    public function loadSubRoles($roleId)
    {
        $columns = [
            'a.id',
            'a.reports_to',
            'a.role_name',
            'a.sub_role',
            'a.can_assign_records_to',
            'a.privileges',
            'a.profiles',
            'a.modules_and_fields',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('roles a')->select($columns)->where('a.reports_to',$roleId)->orderBy('a.id','ASC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// RoleController->removeRole()
    ////////////////////////////////////////////////////////////
    public function loadUsers($roleId)
    {
      $columns = [
          'a.id'
      ];
      $builder = $this->db->table('users a')->select($columns)->where('a.role_id',$roleId);
      $query = $builder->get();
      return  $query->getResultArray();
    }
}
