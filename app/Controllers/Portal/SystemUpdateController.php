<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class SystemUpdateController extends BaseController
{
    private $branchName = 'arkcrm-patch-v1-0-1';

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
}
