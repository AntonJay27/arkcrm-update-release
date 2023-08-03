<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Documents extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'documents';
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
    ///// DocumentController->loadDocuments()
    ////////////////////////////////////////////////////////////
    public function loadDocuments()
    {
        $columns = [
            'a.id',
            'a.title',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.document_number',
            'a.type',
            'a.file_name',
            'a.file_url',
            'a.file_type',
            'a.file_size',
            'a.download_count',
            'a.created_date',
            'a.updated_date'
        ];

        $builder = $this->db->table('documents a')->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->loadUnlinkContactDocuments()
    ///// OrganizationController->loadUnlinkContactDocuments()
    ////////////////////////////////////////////////////////////
    public function loadUnlinkDocuments($arrDocumentIds)
    {
        $columns = [
            'a.id',
            'a.title',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.document_number',
            'a.type',
            'a.file_name',
            'a.file_url',
            'a.file_type',
            'a.file_size',
            'a.download_count',
            'a.created_date',
            'a.updated_date'
        ];

        $builder = $this->db->table('documents a')->select($columns);
        if(count($arrDocumentIds) > 0)
        {
            $builder->whereNotIn('a.id',$arrDocumentIds);
        }
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addContactDocument()
    ///// OrganizationController->addOrganizationDocument()
    ///// DocumentController->addDocument()
    ////////////////////////////////////////////////////////////
    public function addDocument($arrData)
    {
        try {
          $this->db->transStart();
            $this->db->table('documents')->insert($arrData);
            $documentId = $this->db->insertID();
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? $documentId : 0;
        } catch (PDOException $e) {
          throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// DocumentController->selectDocument()
    ///// ContactController->addSelectedContactDocuments()
    ///// OrganizationController->addSelectedOrganizationDocuments()
    ////////////////////////////////////////////////////////////
    public function selectDocument($documentId)
    {
        $columns = [
            'a.id',
            'a.title',
            'a.assigned_to',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'a.document_number',
            'a.type',
            'a.file_name',
            'a.file_url',
            'a.file_type',
            'a.file_size',
            'a.notes',
            'a.download_count',
            'a.created_date',
            'a.updated_date'
        ];

        $builder = $this->db->table('documents a')->select($columns);
        $builder->where('a.id',$documentId);
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// DocumentController->editDocument()
    ////////////////////////////////////////////////////////////
    public function editDocument($arrData, $documentId)
    {
        try {
            $this->db->transStart();
                $this->db->table('documents')
                        ->where(['id'=>$documentId])
                        ->update($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// DocumentController->removeDocument()
    ////////////////////////////////////////////////////////////
    public function removeDocument($documentId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('documents');
                $builder->where(['id'=>$documentId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }





    ////////////////////////////////////////////////////////////
    ///// DocumentController->addDocument()
    ///// DocumentController->editDocument()
    ////////////////////////////////////////////////////////////
    public function addDocumentUpdates($arrData)
    {
        try {
            $this->db->transStart();
                $this->db->table('document_updates')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// DocumentController->loadDocumentUpdates()
    ////////////////////////////////////////////////////////////
    public function loadDocumentUpdates($documentId)
    {
        $columns = [
            'a.id',
            'a.document_id',
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

        $builder = $this->db->table('document_updates a')->select($columns);
        $builder->where('a.document_id',$documentId);
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }




    ////////////////////////////////////////////////////////////
    ///// DocumentController->loadSelectedContactDocuments()
    ////////////////////////////////////////////////////////////
    public function loadSelectedContactDocuments($documentId)
    {
        $columns = [
            'a.id',
            'a.document_id',
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
            'c.mailing_city',
            'c.mailing_country'
        ];

        $builder = $this->db->table('contact_documents a')->select($columns);
        $builder->where('a.document_id',$documentId);
        $builder->join('contacts b','a.contact_id = b.id','left');
        $builder->join('contact_address_details c','c.contact_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// DocumentController->loadUnlinkContacts()
    ///// DocumentController->removeDocument()
    ////////////////////////////////////////////////////////////
    public function loadContactDocuments($documentId)
    {
        $columns = [
            'a.id',
            'a.contact_id'
        ];

        $builder = $this->db->table('contact_documents a')->select($columns);
        $builder->where('a.document_id',$documentId);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// DocumentController->loadSelectedOrganizationDocuments()
    ////////////////////////////////////////////////////////////
    public function loadSelectedOrganizationDocuments($documentId)
    {
        $columns = [
            'a.id',
            'a.document_id',
            'a.organization_id',
            'b.organization_name',
            'b.primary_email',
            'b.main_website',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name'
        ];

        $builder = $this->db->table('organization_documents a')->select($columns);
        $builder->where('a.document_id',$documentId);
        $builder->join('organizations b','a.organization_id = b.id','left');
        $builder->join('organization_address_details c','c.organization_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// DocumentController->loadUnlinkOrganizations()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationDocuments($documentId)
    {
        $columns = [
            'a.id',
            'a.organization_id'
        ];

        $builder = $this->db->table('organization_documents a')->select($columns);
        $builder->where('a.document_id',$documentId);
        $query = $builder->get();
        return  $query->getResultArray();
    }
}
