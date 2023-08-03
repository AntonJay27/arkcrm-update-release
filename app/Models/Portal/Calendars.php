<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Calendars extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'calendars';
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
    ///// CalendarController->loadCalendars()
    ////////////////////////////////////////////////////////////
    public function loadCalendars($userId)
    {
        $columns = [
            'a.id',
            'a.calendar_name',
            'a.timezone',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('calendars a')->select($columns);
        $builder->where('a.created_by',$userId);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// CalendarController->addCalendar()
    ////////////////////////////////////////////////////////////
    public function addCalendar($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('calendars')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// CalendarController->loadUsers()
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
}
