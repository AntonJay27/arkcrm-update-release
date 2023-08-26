<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class SystemUpdateController extends BaseController
{
    public function checkSystemUpdates()
    {
      $output_array = null;
      $cmd_status = null;

      exec('git pull github arkcrm-patch-v1-0-0:arkcrm-patch-v1-0-0', $output_array, $cmd_status);

      if(count($output_array) > 0)
      {
        $arrResult[] = str_replace(' ', '-', $output_array[0]);
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

      exec('git checkout arkcrm-patch-v1-0-0', $output_array, $cmd_status);

      $arrResult = [$output_array, $cmd_status];

      return $this->response->setJSON($arrResult);
    }
}
