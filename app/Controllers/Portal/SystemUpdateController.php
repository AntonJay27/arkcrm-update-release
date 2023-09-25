<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class SystemUpdateController extends BaseController
{
    private $branchName = 'arkcrm-patch-v1-0-2';

    public function checkSystemUpdates()
    {
      $output_array = null;
      $cmd_status = null;

      $branchName = $this->branchName;

      exec("git fetch github $branchName:$branchName", $output_array, $cmd_status);
      exec('git branch', $output_array, $cmd_status);

      $arrBranches = [];
      if(count($output_array) > 0)
      {
        foreach ($output_array as $key => $value) 
        {
          $arrBranches[] = str_replace(' ', '', $value);
        }
      }
      if(in_array($branchName, $arrBranches))
      {
        $arrResult[] = 'New update is comming!';
      }
      else
      {
        $arrResult[] = '';
      }

      return $this->response->setJSON($arrResult);
    }

    public function applySystemUpdates()
    {
      $output_array = null;
      $cmd_status = null;

      $branchName = $this->branchName;

      exec("git checkout $branchName", $output_array, $cmd_status);
      $arrResult = [$output_array, $cmd_status];

      return $this->response->setJSON($arrResult);
    }

    public function updateDatabase()
    {
      $result = $this->_createCustomMapTable();
      return $this->response->setJSON($result);
    }

    private function _createCustomMapTable()
    {
      $fields = [
          'id'            => [
              'type'            => 'INT',
              'constraint'      => 11,
              'unsigned'        => true,
              'auto_increment'  => true,
          ],
          'map_type'      => [
              'type'            => 'VARCHAR',
              'constraint'      => 20,
              'null'            => true,
          ],
          'map_name'      => [
              'type'            => 'VARCHAR',
              'constraint'      => 100,
              'null'            => true,
          ],
          'map_fields'    => [
              'type'            => 'JSON',
              'null'            => true,
          ],
          'map_values'    => [
              'type'            => 'JSON',
              'null'            => true,
          ],
          'created_by'    => [
              'type'            => 'INT',
              'constraint'      => 11,
              'unsigned'        => true,
              'null'            => true,
          ],
          'created_date'  => [
              'type'            => 'DATETIME',
              'null'            => true,
          ]
      ];

      try 
      {
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('custom_maps');
        return ["Success","Database updated successfully!"];
      } 
      catch (\Throwable $e) 
      {
        return ["Warning","<b>Database is up to date.</b>"];
      }
    }
}
