<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class SystemUpdateController extends BaseController
{
    public function checkSystemUpdates()
    {
      $output_array = null;
      $cmd_status = null;

      exec('git pull github arkcrm-patch-v1-0-1:arkcrm-patch-v1-0-1', $output_array, $cmd_status);

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

    public function loadSystemUpdates()
    {
      $output_array = null;
      $cmd_status = null;

      exec('git pull github arkcrm-updates', $output_array, $cmd_status);

      $arrResult = [$output_array, $cmd_status];

      return $this->response->setJSON($arrResult);
    }
}
