<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Events extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'events';
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
    public function loadEvents()
    {
        $columns = [
            'a.id',
            'a.subject',
            'a.assigned_to',
            'a.event_timezone',
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
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ///////////////////////////////////////////////////////////
    ///// EventController->addEvent()
    ///////////////////////////////////////////////////////////
    public function addEvent($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('events')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ///////////////////////////////////////////////////////////
    ///// EventController->selectEvent()
    ///////////////////////////////////////////////////////////
    public function selectEvent($eventId)
    {
      $columns = [
          'a.id',
          'a.subject',
          'a.assigned_to',
          'a.event_timezone',
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

      $builder = $this->db->table('events a');
      $builder->select($columns);
      $builder->where('a.id',$eventId);
      $query = $builder->get();
      return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    // EventController->editEvent()
    ////////////////////////////////////////////////////////////
    public function editEvent($arrData,$eventId)
    {
      try {
          $this->db->transStart();
              $builder = $this->db->table('events');
              $builder->where('id',$eventId);
              $builder->update($arrData);
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? 1 : 0;
      } catch (PDOException $e) {
          throw $e;
      }
    }
}
